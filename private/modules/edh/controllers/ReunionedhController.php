<?php

namespace app\modules\edh\controllers;

use app\models\AgenteSearch;
use app\models\Nombramiento;
use app\modules\edh\models\Caso;
use app\modules\edh\models\ParticipantereunionSearch;
use Yii;
use app\modules\edh\models\Reunionedh;
use app\modules\edh\models\ReunionedhSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReunionedhController implements the CRUD actions for Reunionedh model.
 */
class ReunionedhController extends Controller
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
     * Lists all Reunionedh models.
     * @return mixed
     */
    public function actionIndex($caso)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $searchModel = new ReunionedhSearch();
        $dataProvider = $searchModel->porCaso($caso);
        $model = Caso::findOne($caso);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }



    /**
     * Displays a single Reunionedh model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $model = $this->findModel($id);

        $searchModelParticipantes = new ParticipantereunionSearch();
        
        $dataProviderParticipantes = $searchModelParticipantes->porReunion($model->id);

        
        try {
            $desdeexplode = explode("-",$model->fecha);
            $newdatedesde = date("d/m/Y", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[2], $desdeexplode[0]));
            $model->fecha = $newdatedesde;
        } catch (\Throwable $th) {
            
        }
        

        if ($model->load(Yii::$app->request->post())) {

            return var_dump(Yii::$app->request->post());

            $desdeexplode = explode("/",$model->fecha);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->fecha = $newdatedesde;
            $model->save();

            //Yii::$app->session->setFlash('success2', 'Se guardó correctamente');
            Yii::$app->session->set('success3', "Se <b>actualizó</b> correctamente la reunión");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('view', [
            'model' => $model,
            'searchModelParticipantes' => $searchModelParticipantes,
            'dataProviderParticipantes' => $dataProviderParticipantes,
           
        ]);
    }

    /**
     * Creates a new Reunionedh model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($caso)
    {
        $model = new Reunionedh();
        $model->caso = $caso;

        if ($model->load(Yii::$app->request->post())) {

            $desdeexplode = explode("/",$model->fecha);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->fecha = $newdatedesde;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Reunionedh model.
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
     * Deletes an existing Reunionedh model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Reunionedh model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reunionedh the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reunionedh::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
