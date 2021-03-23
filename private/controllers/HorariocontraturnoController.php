<?php

namespace app\controllers;

use app\config\Globales;
use app\models\Agente;
use app\models\Catedra;
use app\models\Diasemana;
use app\models\Division;
use Yii;
use app\models\Horariocontraturno;
use app\models\HorariocontraturnoSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HorariocontraturnoController implements the CRUD actions for Horariocontraturno model.
 */
class HorariocontraturnoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    
                    [
                        'actions' => ['create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],
                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Horariocontraturno models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HorariocontraturnoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Horariocontraturno model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Horariocontraturno model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($division, $al)
    {
        $model = new Horariocontraturno();
        $model->aniolectivo = $al;

        $catedras = Catedra::find()->joinWith(['detallecatedras', 'actividad0'])
                            ->where(['division' => $division])
                            ->andWhere(['detallecatedra.revista' => 1])
                            ->andWhere(['like', 'actividad.nombre', 'Educación Físi'.'%', false])
                            ->all();
        $agentes = Agente::find()
                        ->joinWith(['detallecatedras', 'detallecatedras.catedra0', 'detallecatedras.catedra0.actividad0'])
                        ->where(['like', 'actividad.nombre', 'Educación Físi'.'%', false])
                        ->orderBy('apellido, nombre')
                        ->all();
        $dias = Diasemana::find()->all();
        $divi = Division::findOne($division);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/horario/completoxcurso', 'division' => $division, 'vista' => 'docentes', 'al' => $al]);
        }

        return $this->render('create', [
            'model' => $model,
            'catedras' => $catedras,
            'agentes' => $agentes,
            'dias' => $dias,
            'al' => $al,
            'divi' => $divi,
        ]);
    }

    /**
     * Updates an existing Horariocontraturno model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $division = $model->catedra0->division;
        $al = $model->aniolectivo;

        $catedras = Catedra::find()->joinWith(['detallecatedras', 'actividad0'])
                        ->where(['division' => $division])
                        ->andWhere(['detallecatedra.revista' => 1])
                        ->andWhere(['like', 'actividad.nombre', 'Educación Físi'.'%', false])
                        ->all();
        $agentes = Agente::find()
                    ->joinWith(['detallecatedras', 'detallecatedras.catedra0', 'detallecatedras.catedra0.actividad0'])
                    ->where(['like', 'actividad.nombre', 'Educación Físi'.'%', false])
                    ->orderBy('apellido, nombre')
                    ->all();
        $dias = Diasemana::find()->all();
        $divi = Division::findOne($division);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/horario/completoxcurso', 'division' => $division, 'vista' => 'docentes', 'al' => $al]);
        }

        return $this->render('update', [
            'model' => $model,
            'catedras' => $catedras,
            'agentes' => $agentes,
            'dias' => $dias,
            'al' => $al,
            'divi' => $divi,
        ]);
    }

    /**
     * Deletes an existing Horariocontraturno model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $division = $model->catedra0->division;
        $al = $model->aniolectivo;

        $model->delete();

        return $this->redirect(['/horario/completoxcurso', 'division' => $division, 'vista' => 'docentes', 'al' => $al]);
    }

    /**
     * Finds the Horariocontraturno model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Horariocontraturno the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Horariocontraturno::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
