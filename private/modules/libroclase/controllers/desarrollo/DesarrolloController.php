<?php

namespace app\modules\libroclase\controllers\desarrollo;

use app\config\Globales;
use app\models\Agente;
use app\models\Catedra;
use app\models\Detallecatedra;
use app\models\HorarioSearch;
use app\modules\curriculares\models\Aniolectivo;
use Yii;
use app\modules\libroclase\models\desarrollo\Desarrollo;
use app\modules\libroclase\models\desarrollo\DesarrolloSearch;
use app\modules\libroclase\models\Programa;
use app\modules\libroclase\models\Temaunidad;
use app\modules\libroclase\models\TemaunidadSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DesarrolloController implements the CRUD actions for Desarrollo model.
 */
class DesarrolloController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['catedras', 'index', 'view', 'create', 'control'],
                'rules' => [
                    [
                        'actions' => ['catedras', 'index', 'view', 'create', 'control'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_AGENTE, Globales::US_REGENCIA]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['view', 'create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                           try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]);
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
     * Lists all Desarrollo models.
     * @return mixed
     */
    public function actionCatedras($al)
    {
        
        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);

        $aniolectivo = Aniolectivo::findOne($al);
        
        if(Yii::$app->user->identity->role == Globales::US_AGENTE){
            //$this->layout = 'mainpersonal';
            $doc = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
            
            $dcs = Detallecatedra::find()
                ->joinWith(['catedra0', 'catedra0.division0', 'catedra0.actividad0'])
                ->where(['detallecatedra.agente' => $doc->id])
                ->andWhere(['detallecatedra.revista' => 6])
                ->andWhere(['detallecatedra.aniolectivo' => $aniolectivo->id])
                ->andWhere(['not in','actividad.id', [184, 201, 195,33,23]])
                ->orderBy('division.id')
                ->all();

            $array = [];

            foreach ($dcs as $dc) {
                $array [] = $dc->catedra0;
            }

            $divisiones = $array;
            $echodiv = '';
            foreach ($divisiones as $catedra) {
                //return var_dump($catedra);
                    $echodiv .= '<div class="pull-left" >';
                    $echodiv .= '<center><div  style="margin:10px;">';
                    $echodiv .= '<a class="menuHorarios" href="index.php?r=libroclase/desarrollo/desarrollo/index&cat='.$catedra['id'].'&al='.$aniolectivo->id.'" role="button" >'.$catedra['division0']['nombre'].'<br><span style="font-size:0.5em;" class="label label-default">'.$catedra['actividad0']['nombre'].'</span><br><span style="font-size:0.5em;">Plan: '.$catedra->actividad0->plan0->nombre.'</span></a>';
                    $echodiv .= '</div></center>';
                    $echodiv .= '</div>';
            }
            return $this->render('menuxdivision', [
                'echodiv' => $echodiv,
            ]);
        
        }
        
        
    }
    
    public function actionIndex($cat, $al)
    {
        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);
        $searchModel = new DesarrolloSearch();
        $dataProvider = $searchModel->xcatedra($cat, $al);
        $catedra = Catedra::findOne($cat);
        $aniolectivo = Aniolectivo::findOne($al);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'catedra' => $catedra,
            'aniolectivo' => $aniolectivo,
        ]);
    }

    /**
     * Displays a single Desarrollo model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($t, $or = 'nor')
    {
        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);


        //$actividad = 35;

        $desarrollo = Desarrollo::find()
                        ->where(['token' => $t])
                        ->one();

        $programa = Programa::find()
                        ->where(['actividad' =>  $desarrollo->catedra0->actividad])
                        //->andWhere(['vigencia' => 1])
                        ->one();
        $al = Aniolectivo::findOne($desarrollo->aniolectivo);
        
        $searchModel = new TemaunidadSearch();
        $dataProvider = $searchModel->porprograma($programa->id);

        if ($desarrollo->load(Yii::$app->request->post())) {

            $desarrollo->estado = 2;
            $desarrollo->fechaenvio = date('Y-m-d');
            $desarrollo->save();
            return $this->redirect(['view', 't' => $desarrollo->token]);
        }

        if($or == 'nor'){
            return $this->render('view', [
                'programa' => $programa,
                'al' => $al,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $desarrollo,
            ]);
        }else{
            return $this->renderAjax('view', [
                'programa' => $programa,
                'al' => $al,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $desarrollo,
            ]);
        }
    }

    /**
     * Creates a new Desarrollo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($cat)
    {
        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);

        $doc = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();

        $model = new Desarrollo();
        $model->aniolectivo = 2;
        $model->catedra = $cat;
        $model->docente = $doc->id;
        $model->estado = 1;
        $model->fechacreacion = date('Y-m-d');
        $model->token = Yii::$app->security->generateRandomString(120);
        $model->save();
        return $this->redirect(['view', 't' => $model->token]);
        
    }

    /**
     * Updates an existing Desarrollo model.
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
     * Deletes an existing Desarrollo model.
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


    public function actionControl($al=0)
    {
        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);

        $anios = Aniolectivo::find()->all();
        $model = new Catedra();
        $model->aniolectivo = $al;
        if (Yii::$app->request->post()) {
            $searchModel = new HorarioSearch();
            $dataProvider = $searchModel->getCompletoDetallado(Yii::$app->request->post()['Catedra']['aniolectivo']);
        }else{
            $searchModel = new HorarioSearch();
            $dataProvider = $searchModel->getCompletoDetallado($al);
        }
        
        if(isset(Yii::$app->request->post()['Catedra']['aniolectivo'])){
            $model->aniolectivo = Yii::$app->request->post()['Catedra']['aniolectivo'];
        }

        return $this->render('control', [
            'model' => $model,
            'anios' => $anios,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    

    /**
     * Finds the Desarrollo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Desarrollo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Desarrollo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
