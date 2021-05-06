<?php

namespace app\controllers;

use app\config\Globales;
use app\models\Estadoturnoexamen;
use app\models\Parametros;
use app\models\Tipoturnoexamen;
use Yii;
use app\models\Turnoexamen;
use app\models\TurnoexamenSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TurnoexamenController implements the CRUD actions for Turnoexamen model.
 */
class TurnoexamenController extends Controller
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
                    [
                        'actions' => ['index', 'view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA, Globales::US_CONSULTA, Globales::US_PRECEPTOR, Globales::US_AGENTE, Globales::US_PRECEPTORIA, Globales::US_DESPACHO]))
                                    return true;
                                return false;
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
     * Lists all Turnoexamen models.
     * @return mixed
     */
    public function actionIndex()
    {
        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);
        $searchModel = new TurnoexamenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Turnoexamen model.
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
     * Creates a new Turnoexamen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Turnoexamen();
        $tipos = Tipoturnoexamen::find()->all();
        $estados = Estadoturnoexamen::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            $desdeexplode = explode("/",$model->desde);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->desde = $newdatedesde;

            $hastaexplode = explode("/",$model->hasta);
            $newdatehasta = (!empty($model->hasta)) ? date("Y-m-d", mktime(0, 0, 0, $hastaexplode[1], $hastaexplode[0], $hastaexplode[2])) : null;
            $model->hasta = $newdatehasta;
            $model->save();
            Yii::$app->session->setFlash('success', "Se creó correctamente el turno de examen");
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'tipos' => $tipos,
            'estados' => $estados,

        ]);
    }

    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $tipos = Tipoturnoexamen::find()->all();
        $estados = Estadoturnoexamen::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            $desdeexplode = explode("/",$model->desde);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->desde = $newdatedesde;

            $hastaexplode = explode("/",$model->hasta);
            $newdatehasta = (!empty($model->hasta)) ? date("Y-m-d", mktime(0, 0, 0, $hastaexplode[1], $hastaexplode[0], $hastaexplode[2])) : null;
            $model->hasta = $newdatehasta;
            $model->save();
            Yii::$app->session->setFlash('success', "Se modificó correctamente el turno de examen");
            return $this->redirect(['index']);
        }

        $desdeexplode = explode("-",$model->desde);
        $newdatedesde = (!empty($model->desde)) ? date("d/m/Y", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[2], $desdeexplode[0])) : null;
        $model->desde = $newdatedesde;

        $hastaexplode = explode("-",$model->hasta);
        $newdatehasta = (!empty($model->hasta)) ? date("d/m/Y", mktime(0, 0, 0, $hastaexplode[1], $hastaexplode[2], $hastaexplode[0])) : null;
        $model->hasta = $newdatehasta;

        return $this->render('update', [
            'model' => $model,
            'tipos' => $tipos,
            'estados' => $estados,
        ]);
    }

    /**
     * Deletes an existing Turnoexamen model.
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
     * Finds the Turnoexamen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Turnoexamen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Turnoexamen::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
