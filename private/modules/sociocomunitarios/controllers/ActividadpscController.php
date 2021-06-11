<?php

namespace app\modules\sociocomunitarios\controllers;

use app\config\Globales;
use app\models\Agente;
use app\modules\curriculares\models\Acta;
use app\modules\curriculares\models\Docentexcomision;
use app\modules\curriculares\models\MatriculaSearch;
use Yii;
use app\modules\sociocomunitarios\models\Actividadpsc;
use app\modules\sociocomunitarios\models\ActividadpscSearch;
use app\modules\sociocomunitarios\models\DetalleactividadpscSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ActividadpscController implements the CRUD actions for Actividadpsc model.
 */
class ActividadpscController extends Controller
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
                        'actions' => ['index'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [1,3,6,8,9,12,13,14,20, Globales::US_PRECEPTORIA, Globales::US_REGENCIA]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],
                    [
                        'actions' => ['view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                $com = isset($_SESSION['comisiontsx']) ? $_SESSION['comisiontsx'] : 0;

                                if(in_array (Yii::$app->user->identity->role, [1,3,6,9,12,13,14,20, Globales::US_PRECEPTORIA, Globales::US_REGENCIA]))
                                    return true;
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_AGENTE])){
                                   
                                    $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                        $cant = count(Docentexcomision::find()
                                                            ->where(['comision' => $com])
                                                            ->andWhere(['agente' => $agente->id])
                                                            ->all());
                                            if($cant>0){
                                                return true;
                                            }
                                    return true;
                                }
                                
                                
                            }catch(\Exception $exception){
                                return false;
                            }
                            return false;
                        }
                    ],
                    [
                        'actions' => ['create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                
                                $com = isset($_SESSION['comisiontsx']) ? $_SESSION['comisiontsx'] : 0;
                                if(in_array (Yii::$app->user->identity->role, [1]))
                                    return true;
                                if(
                                    count(Acta::find()->where(['comision' => $com])->andWhere(['estadoacta' => 2])->all()) > 0){
                                    Yii::$app->session->setFlash('info', "No se puede realizar la acción ya que la comisión tiene un acta en estado cerrado");
                                    return true;
                                }

                                if(in_array (Yii::$app->user->identity->role, [Globales::US_AGENTE])){
                                   
                                    $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                        $cant = count(Docentexcomision::find()
                                                            ->where(['comision' => $com])
                                                            ->andWhere(['agente' => $agente->id])
                                                            ->all());
                                            if($cant>0){
                                                return true;
                                            }
                                    return true;
                                }
                                
                                
                            }catch(\Exception $exception){
                                return false;
                            }
                            return false;
                        }

                    ],
                    /*[
                        'actions' => ['comisionshoy', 'comisioninterhoy'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return in_array (Yii::$app->user->identity->role, [1,9]);
                        }

                    ],*/
                    

                    
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
     * Lists all Actividadpsc models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'main';
        $searchModel = new ActividadpscSearch();
        $com = isset($_SESSION['comisiontsx']) ? $_SESSION['comisiontsx'] : 0;
        $dataProvider = $searchModel->xcomision($com);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Actividadpsc model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = 'main';
        $actividad = $this->findModel($id);

        $searchModel = new MatriculaSearch();
        $dataProvider = $searchModel->alumnosxcomision($actividad->comision);

        return $this->render('view', [
            'actividad' => $actividad,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Actividadpsc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'main';
        $model = new Actividadpsc();
        $com = isset($_SESSION['comisiontsx']) ? $_SESSION['comisiontsx'] : 0;
        $model->comision = $com;
        if ($model->load(Yii::$app->request->post())) {

            $fechaexplode = explode("/",$model->fecha);
            $newdatefecha = date("Y-m-d", mktime(0, 0, 0, $fechaexplode[1], $fechaexplode[0], $fechaexplode[2]));
            $model->fecha = $newdatefecha;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Actividadpsc model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout = 'main';
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post())) {
            $fechaexplode = explode("/",$model->fecha);
            $newdatefecha = date("Y-m-d", mktime(0, 0, 0, $fechaexplode[1], $fechaexplode[0], $fechaexplode[2]));
            $model->fecha = $newdatefecha;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        try {
            $explodefecha = explode("-",$model->fecha);
            $newdate = date("d/m/Y", mktime(0, 0, 0, $explodefecha[1], $explodefecha[2], $explodefecha[0]));
            $model->fecha = $newdate;
        } catch (\Throwable $th) {

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Actividadpsc model.
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
     * Finds the Actividadpsc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Actividadpsc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Actividadpsc::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
