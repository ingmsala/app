<?php

namespace app\controllers;

use Yii;
use app\config\Globales;
use app\models\Anioxtrimestral;
use app\models\AnioxtrimestralSearch;
use app\models\HorarioexamenSearch;
use app\models\Trimestral;
use app\modules\curriculares\models\Aniolectivo;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;




/**
 * AnioxtrimestralController implements the CRUD actions for Anioxtrimestral model.
 */
class AnioxtrimestralController extends Controller
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
                        'actions' => ['view', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]);
                                }catch(\Exception $exception){
                                    return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['index', 'create', 'publicadotruefalse'],   
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
                        'actions' => ['update'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action){
                                try{

                                    $axt = $this->findModel(Yii::$app->request->queryParams['id']);
                                    if($axt->activo==1 || Yii::$app->user->identity->role==Globales::US_SUPER)
                                        return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]);
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
     * Lists all Anioxtrimestral models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AnioxtrimestralSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Anioxtrimestral model.
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
     * Creates a new Anioxtrimestral model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Anioxtrimestral();
        $anio = Aniolectivo::find()->orderBy('id desc')->all();
        $trimestral = Trimestral::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->validate();
            $inicioexplode = explode("/",$model->inicio);

            if(count($inicioexplode) > 1){
                $newdateinicio = date("Y-m-d", mktime(0, 0, 0, $inicioexplode[1], $inicioexplode[0], $inicioexplode[2]));
                $model->inicio = $newdateinicio;
            }else{
                $model->inicio = null;
            }
            
            $finexplode = explode("/",$model->fin);

            if(strpos($finexplode[2], "hosta") === false)
                $anio = $finexplode[2];
            else
                $anio = $finexplode[4];
            if(count($finexplode) > 1){
                $newdatefin = date("Y-m-d", mktime(0, 0, 0, $finexplode[1], $finexplode[0], $anio));
                $model->fin = $newdatefin;
            }else{
                $model->fin = null;
            }

            if ($model->save())
            {
                if($model->trimestral < 4){
                    $cant = $this->inactivarAnioxTrim($model->id, false);
                    if($cant>0)
                        Yii::$app->session->setFlash('info', "{$cant} trimestral cambió a estado <b>inactivo</b>");
                }else{
                    $cant = $this->inactivarAnioxTrim($model->id, true);
                    if($cant>0)
                        Yii::$app->session->setFlash('info', "{$cant} examen cambió a estado <b>inactivo</b>");
                }
                
                return $this->redirect(['horarioexamen/migracionfechas', 'anioxtrimestral' => $model->id]);
            }


            //return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'anio' => $anio,
            'trimestral' => $trimestral,
        ]);
    }

    public function inactivarAnioxTrim($id, $col){
        if($col)
            $anioxtrimestrales = Anioxtrimestral::find()
                ->where(['<>', 'id', $id])
                ->andWhere(['trimestral' => 4])
                ->andWhere(['or', 
                        ['activo' => 1],
                        ['publicado' => 1]
                    ])
                ->all();
        else
            $anioxtrimestrales = Anioxtrimestral::find()
                ->where(['<>', 'id', $id])
                ->andWhere(['<', 'trimestral', 4])
                ->andWhere(['or', 
                        ['activo' => 1],
                        ['publicado' => 1]
                    ])
                ->all();
        $c = 0;
        foreach ($anioxtrimestrales as $axtx) {
            $axtx->activo = 2;
            $axtx->publicado = 2;                
            $axtx->save();
            $c++;
        }

        return $c;
        

    }

    /**
     * Updates an existing Anioxtrimestral model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $anio = Aniolectivo::find()->orderBy('id desc')->all();
        $trimestral = Trimestral::find()->all();

        $inicioexplode1 = explode("-",$model->inicio);
            //return var_dump($inicioexplode1);
            if(count($inicioexplode1) > 1){
                $newdateinicio1 = date("d/m/Y", mktime(0, 0, 0, $inicioexplode1[1], $inicioexplode1[2], $inicioexplode1[0]));
                $model->inicio = $newdateinicio1;
            }else{
                $model->inicio = null;
            }

            $finexplode1 = explode("-",$model->fin);

            if(count($finexplode1) > 1){
                $newdatefin1 = date("d/m/Y", mktime(0, 0, 0, $finexplode1[1], $finexplode1[2], $finexplode1[0]));
                $model->fin = $newdatefin1;
            }else{
                $model->fin = null;
            }

        if ($model->load(Yii::$app->request->post())) {

            $inicioexplode = explode("/",$model->inicio);

            if(strpos($inicioexplode[2], "hasta") === false)
                $anioini = $inicioexplode[2];
            else
                $anioini = substr($inicioexplode[2], 0, 4);
            
            //return $anio;
            if(count($inicioexplode) > 1){
                $newdateinicio = date("Y-m-d", mktime(0, 0, 0, $inicioexplode[1], $inicioexplode[0], $anioini));
                $model->inicio = $newdateinicio;
            }else{
                $model->inicio = null;
            }

            $finexplode = explode("/",$model->fin);
            if(strpos($finexplode[2], "hasta") === false)
                $anio = $finexplode[2];
            else
                $anio = $finexplode[4];
            if(count($finexplode) > 1){
                $newdatefin = date("Y-m-d", mktime(0, 0, 0, $finexplode[1], $finexplode[0], $anio));
                $model->fin = $newdatefin;
            }else{
                $model->fin = null;
            }
            $model->save();
            return $this->redirect(['index']);
        }
        $tipo = ($model->trimestral < 4) ? 2 : 3;
        $searchModel = new HorarioexamenSearch();
        $inconvcursos = $searchModel->getSuperposicionCursos($tipo)->totalCount;
        $inconvdocentes = $searchModel->getSuperposicionDocentes($tipo)->totalCount;
        $inconvmaterias = $searchModel->getMateriasNocargadas($tipo)->totalCount;
        $totalinconv = $inconvcursos + $inconvdocentes + $inconvmaterias;

        if($totalinconv>0){
            Yii::$app->session->setFlash('danger', "Se detectaron {$totalinconv} inconveniente/s en el horario. Se recomienda revisarlo/s <b>".Html::a('acá', 'index.php?r=horarioexamen/revisarhorarios&id='.$model->id)."</b> antes de publicar el mismo.");
            //return $this->redirect(['/horarioexamen/revisarhorarios', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'anio' => $anio,
            'trimestral' => $trimestral,
            
           
        ]);
    }

    /**
     * Deletes an existing Anioxtrimestral model.
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
     * Finds the Anioxtrimestral model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Anioxtrimestral the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Anioxtrimestral::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPublicadotruefalse()
    {
        //$searchModel = new ComisionSearch();
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];

        if (isset($_POST['depdrop_parents'])) {
            
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {

                $activo_id = $parents[0];
                /*$comisiones = Comision::find()
                    ->joinWith(['comision0', 'espaciocurricular0', 'espaciocurricular0.aniolectivo0', 'espaciocurricular0.actividad0', ])
                    ->where(['espaciocurricular.aniolectivo' => $anio_id])
                    ->orderBy('actividad.nombre')->all();*/

                $listpublic = [];

                if($activo_id == 1){
                    $out = [
                   ['id'=>'1', 'name'=>'Sí'],
                   ['id'=>'2', 'name'=>'No']
                  ];
                }else{
                    $out = [
                   
                   ['id'=>'2', 'name'=>'No']
                  ];
                }
                
                //$com = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
                return ['output'=>$out, 'selected'=>''];
            }

        }

        return ['output'=>'', 'selected'=>''];

        
        
        
    }
}
