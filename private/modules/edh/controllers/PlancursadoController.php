<?php

namespace app\modules\edh\controllers;

use app\models\Catedra;
use app\models\Detallecatedra;
use app\modules\edh\models\Actuacionedh;
use app\modules\edh\models\Caso;
use app\modules\edh\models\Catedradeplan;
use app\modules\edh\models\Detalleplancursado;
use app\modules\edh\models\DetalleplancursadoSearch;
use Yii;
use app\modules\edh\models\Plancursado;
use app\modules\edh\models\PlancursadoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * PlancursadoController implements the CRUD actions for Plancursado model.
 */
class PlancursadoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Plancursado models.
     * @return mixed
     */
    public function actionIndex($caso)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $model = Caso::findOne($caso);

        if(!in_array(3, array_column($model->solicitudedhs, 'estadosolicitud'))){
            Yii::$app->session->setFlash('danger', 'No se puede gestionar el Plan de Cursado, ya que no existe ninguna solicitud en estado <b>"Aceptada"</b>');
            return $this->redirect(['caso/view', 'id' => $model->id]);
        }

        $searchModel = new PlancursadoSearch();
        $dataProvider = $searchModel->porCaso($caso);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Plancursado model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $ref = 0)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $searchModel = new DetalleplancursadoSearch();
        $dataProvider = $searchModel->porPlan($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
            'ref' => $ref,
        ]);
    }

    /**
     * Creates a new Plancursado model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($caso)
    {
        $model = new Plancursado();
        $modelCatxplan = new Catedradeplan();
        $caso = Caso::findOne($caso);

        $model->caso = $caso->id;
        $model->tipoplan = 2;

        $docentes_curso = Detallecatedra::find()
            ->joinWith(['catedra0', 'catedra0.actividad0', 'agente0'])
            ->where(['catedra.division' => $caso->matricula0->division])
            ->andWhere(['<>', 'actividad.id', 31])
            ->andWhere(['<>', 'actividad.id', 33])
            ->andWhere(['<>', 'actividad.id', 195])
            ->andWhere(['revista' => 6])
            ->andWhere(['aniolectivo' => $caso->matricula0->aniolectivo])
            ->orderBy('agente.apellido, agente.nombre')
            ->all();
        
        $catedras = ArrayHelper::map($docentes_curso, 
                                    function($model){
                                        return $model->catedra;
                                    }, 
                                    function($model){
                                        return $model->catedra0->actividad0->nombre;
                                    }
                        );

        if ($model->load(Yii::$app->request->post()) && $modelCatxplan->load(Yii::$app->request->post())) {
            
            $explode = explode("/",$model->fecha);
            $newdate = date("Y-m-d", mktime(0, 0, 0, $explode[1], $explode[0], $explode[2]));
            $model->fecha = $newdate;
            $model->save();
            
            foreach ($modelCatxplan['catedra'] as $catxplan) {
                
                $modelCatxplanX = new Catedradeplan();
                $modelCatxplanX->plan = $model->id;
                $modelCatxplanX->catedra = $catxplan;
                $modelCatxplanX->save();

                $detalleplancursadoX = new Detalleplancursado();
                $detalleplancursadoX->scenario = $detalleplancursadoX::SCENARIO_NEWMAIN;
                $detalleplancursadoX->plan = $model->id;
                $detalleplancursadoX->catedra = $catxplan;
                $detalleplancursadoX->estadodetplan = 1;
                $detalleplancursadoX->save();

            }

            $actuacion = new Actuacionedh();
            $actuacion = $actuacion->nuevaActuacion($model->caso, 4, 'Se crea un nuevo plan de cursado: #'.$model->id, 0);
            
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'catedras' => $catedras,
            'modelCatxplan' => $modelCatxplan,
        ]);
    }


    /**
     * Updates an existing Plancursado model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Plancursado model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $caso = $model->caso;
        try {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Se eliminó correctamente el plan de cursado');
        } catch (\Throwable $th) {
            Yii::$app->session->setFlash('danger', 'No se puede eliminar el plan de cursado');
        }
        
        return $this->redirect(['index', 'caso' => $caso]);
    }

    /**
     * Finds the Plancursado model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Plancursado the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Plancursado::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
