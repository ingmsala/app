<?php

namespace app\modules\sociocomunitarios\controllers;

use Yii;
use app\modules\curriculares\models\Comision;
use app\modules\curriculares\models\Espaciocurricular;
use app\modules\curriculares\models\ComisionSearch;
use app\modules\curriculares\models\DocentexcomisionSearch;
use app\modules\curriculares\models\Docentexcomision;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\config\Globales;

/**
 * ComisionController implements the CRUD actions for Comision model.
 */
class ComisionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'comxanio'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [1]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['comxanio'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [1,3,6,8,9,12,13,14]);
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
     * Lists all Comision models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $searchModel = new ComisionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Comision model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
        
        $searchModel = new DocentexcomisionSearch();
        $dataProviderdocentes = $searchModel->providerdocentes($id);
        $searchModelpreceptores = new DocentexcomisionSearch();
        $dataProviderpreceptores = $searchModelpreceptores->providerpreceptores($id);

        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProviderdocentes' => $dataProviderdocentes,
            'dataProviderpreceptores' => $dataProviderpreceptores,
        ]);
    }

    /**
     * Creates a new Comision model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        
        $model = new Comision();
        $espaciocurricular = Espaciocurricular::find()
                ->where(['id' => $id])
                ->all();
        $model->espaciocurricular = $id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'espaciocurricular' => $espaciocurricular,
        ]);
    }

    /**
     * Updates an existing Comision model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        
        $model = $this->findModel($id);
        $espaciocurricular = Espaciocurricular::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'espaciocurricular' => $espaciocurricular,
        ]);
    }

    /**
     * Deletes an existing Comision model.
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
     * Finds the Comision model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comision the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comision::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionComxanio()
    {
        $searchModel = new ComisionSearch();
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];

        if (isset($_POST['depdrop_parents'])) {
            
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {

                $anio_id = $parents[0];
                /*$comisiones = Comision::find()
                    ->joinWith(['comision0', 'espaciocurricular0', 'espaciocurricular0.aniolectivo0', 'espaciocurricular0.actividad0', ])
                    ->where(['espaciocurricular.aniolectivo' => $anio_id])
                    ->orderBy('actividad.nombre')->all();*/



                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SACADEMICA, Globales::US_COORDINACION, Globales::US_SREI, Globales::US_CONSULTA, Globales::US_SECRETARIA])){
                    $comisiones = Docentexcomision::find()
                    ->distinct()
                    ->select(['comision', 'espaciocurricular.aniolectivo'])
                    ->joinWith(['comision0', 'comision0.espaciocurricular0', 'comision0.espaciocurricular0.actividad0'])
                    ->where(['espaciocurricular.aniolectivo' => $anio_id])
                    ->andWhere(['espaciocurricular.tipoespacio' => 2])
                    ->orderBy('actividad.nombre', 'espaciocurricular.nombre')
                    ->all();
                }else{
                    $comisiones = Docentexcomision::find()
                    ->joinWith(['docente0', 'comision0', 'comision0.espaciocurricular0', 'comision0.espaciocurricular0.actividad0'])
                    ->where(['docente.mail' => Yii::$app->user->identity->username])
                    ->andWhere(['espaciocurricular.aniolectivo' => $anio_id])
                    ->andWhere(['espaciocurricular.tipoespacio' => 2])
                    ->orderBy('actividad.nombre', 'espaciocurricular.nombre')
                    ->all(); 
                }
       

                $listComisiones=ArrayHelper::toArray($comisiones, [
                    'app\modules\curriculares\models\Docentexcomision' => [
                        'id' => function($comision) {
                            return $comision['comision0']['id'];},
                        'name' => function($comision) {
                            return $comision['comision0']['espaciocurricular0']['actividad0']['nombre'].' ('.$comision['comision0']['nombre'].')';},
                    ],
                ]);
                $out = $listComisiones;
                $session = Yii::$app->session;
                if(isset($_SESSION['comisiontsx'])){
                    $com = $_SESSION['comisiontsx'];
                    
                    $comx = Comision::findOne($com);
                    if($comx != null)
                        $session->set('aniolectivox', $comx->espaciocurricular0->aniolectivo);
                    else
                        $session->set('aniolectivox', $anio_id);
                }else{
                    $com = 0;
                    $session->set('aniolectivox', $anio_id);
                }
                
                return ['output'=>$out, 'selected'=>$com];
            }

        }

        return ['output'=>'', 'selected'=>''];

        
        
        
    }
}
