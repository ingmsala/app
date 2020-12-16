<?php

namespace app\controllers;

use Yii;
use app\models\Detalleparte;
use app\models\Parte;
use app\models\DetalleparteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Docente;
use app\models\Division;
use app\models\Hora;
use app\models\Falta;
use app\models\EstadoinasistenciaxparteSearch;
use app\models\Estadoinasistenciaxparte;
use app\config\Globales;
use app\models\Nombramiento;

/**
 * DetalleparteController implements the CRUD actions for Detalleparte model.
 */
class DetalleparteController extends Controller
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
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_PRECEPTORIA, Globales::US_PRECEPTOR]);
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
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA]);
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
     * Lists all Detalleparte models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DetalleparteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
    }

    
    /**
     * Displays a single Detalleparte model.
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
     * Creates a new Detalleparte model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $param = Yii::$app->request->queryParams;
        $model = new Detalleparte();
        $model->scenario = $model::SCENARIO_ABM;
        if (isset ($_REQUEST['parte'])) {
            $parte = $_REQUEST['parte'];
            $partex= Parte::findOne($parte);
            
            if(Yii::$app->user->identity->role == Globales::US_PRECEPTOR){
                $partex= Parte::findOne($parte);
                $doc = Docente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                $nom = Nombramiento::find()
                            ->where(['docente' => $doc->id])
                            ->andWhere(['<=', 'division', 53])
                            ->all();
                $array = [];
                foreach ($nom as $n) {
                    $array [] = $n->division;
                }
                    $divisiones=Division::find()
                    ->where(['preceptoria' => $partex->preceptoria])
                    ->andWhere(['in', 'id', $array])
                    ->orderBy('nombre')->all();
                    
            }else{
                
                $divisiones=Division::find()
                    ->where(['preceptoria' => $partex->preceptoria])
                    ->orderBy('nombre')->all();
            }
            
             

        }else{
                $parte='';
                $partex=Parte::find()->all();
                $divisiones=Division::find()->all();
        } 

        $docentes=Docente::find()->orderBy('apellido', 'nombre', 'legajo')->all();
        $faltas = Falta::find()
                    ->where(['not in', 'id', [Globales::FALTA_COMISION, 4]])
                    ->all();
        if($partex->tipoparte == 1)
            $horas = Hora::find()->all();
        elseif($partex->tipoparte == 2)
            $horas = Hora::find()->where(['in', 'id', [2,3]])->all();
        else
            $horas = Hora::find()->where(['in', 'id', [2]])->all();

        if ($model->load(Yii::$app->request->post())) {
            $parte =$model->parte;
            $division = $model->division;
            $docente = $model->docente;
            $llego = $model->llego;
            $detalleadelrecup = $model->detalleadelrecup;
            $retiro = $model->retiro;
            $falta = $model->falta;
            $estadoinasistencia = $model->estadoinasistencia;

            try{
                 $largo = count($model->hora);
             }catch(\Exception $exception){
                $largo = 0;
            }
            $horas = $model->hora;
            
                //return $largo;
            
            
            $guardaok=false;
            for ($i=0; $i < $largo; $i++) { 
                    $model2 = new Detalleparte();
                    $model2->scenario = $model::SCENARIO_ABM;
                    $model2->parte = $parte;
                    $model2->division = $division;
                    $model2->docente = $docente;
                    $model2->llego = $llego;
                    $model2->detalleadelrecup = $detalleadelrecup;
                    $model2->retiro = $retiro;
                    $model2->falta = $falta;
                    //$model2->estadoinasistencia = $estadoinasistencia;
                    $model2->hora = $horas[$i];
                    $ei = new EstadoinasistenciaxparteSearch();
                    $model2->estadoinasistencia = Globales::ESTADOINASIST_PREC;
                   if($model2->save()){
                        $guardaok = $ei->nuevo(null, Globales::ESTADOINASIST_PREC, $model2->id, $model2->falta);
                   
                    } 
            }

             if ($guardaok){
                       
                        return $this->redirect(['parte/view', 'id' => $parte]);
            }
            
        }
        $depdr = ($partex->preceptoria == 7) ? false : true;
        return $this->renderAjax('create', [
            'model' => $model,
            'docentes' => $docentes,
            'divisiones' => $divisiones,
            'partes' => $partex,
            'parte' => $parte,
            'horas' => $horas,
            'faltas' => $faltas,
            'depdr' => $depdr,
        ]);
    }

    /**
     * Updates an existing Detalleparte model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_ABM;
        if (isset ($_REQUEST['parte'])) {
            $parte = $_REQUEST['parte'] ;
            
            $partex= Parte::findOne($parte);
            $divisiones=Division::find()
                ->where(['preceptoria' => $partex->preceptoria])
                ->orderBy('nombre')->all();
             

        }else{
                $parte='';
                $partex=Parte::find()->all();
                $divisiones=Division::find()->all();
        } 

        $docentes=Docente::find()->orderBy('apellido', 'nombre', 'legajo')->all();
        $faltas = Falta::find()
                    ->where(['not in', 'id', [Globales::FALTA_COMISION, 4]])
                    ->all();
        $horas = Hora::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['parte/view', 'id' => $parte]);
        }

        $depdr = ($partex->preceptoria == 7) ? false : true;
        if(Yii::$app->request->isAjax)
            return $this->renderAjax('update', [
                'model' => $model,
                'docentes' => $docentes,
                'divisiones' => $divisiones,
                'partes' => $partex,
                'parte' => $parte,
                'horas' => $horas,
                'faltas' => $faltas,
                'depdr' => $depdr,
            ]);
            
    }

    /**
     * Deletes an existing Detalleparte model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $parte = $model->parte;

        $ei = Estadoinasistenciaxparte::find()
            ->where(['detalleparte' => $id])->all();

        foreach ($ei as $eix) {
            $eix->delete();
        }
        
        
        
        $this->findModel($id)->delete();
        return $this->redirect(['parte/view', 'id' => $parte]);
    }

    /**
     * Finds the Detalleparte model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Detalleparte the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Detalleparte::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
