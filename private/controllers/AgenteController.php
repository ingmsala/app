<?php

namespace app\controllers;

use Yii;
use app\models\Agente;
use app\models\AgenteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Genero;
use yii\filters\AccessControl;
use app\config\Globales;
use app\models\Agentextipo;
use app\models\NodocenteSearch;
use app\models\Rolexuser;
use app\models\Tipocargo;
use app\models\Tipodocumento;
use app\models\User;
use kartik\grid\EditableColumnAction;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * DocenteController implements the CRUD actions for Agente model.
 */
class AgenteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'editdocumento', 'updatedate', 'actualizarmapuche', 'actualizardomicilio'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'editdocumento', 'actualizarmapuche', 'actualizardomicilio'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_ABM_AGENTE]);
                                }catch(\Exception $exception){
                                    return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['delete', 'updatedate'],   
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
                        'actions' => ['index', 'view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_CONSULTA, Globales::US_ABM_AGENTE]);
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

    public function actions()
   {
       return ArrayHelper::merge(parent::actions(), [
           'editdocumento' => [                                       
               'class' => EditableColumnAction::className(),     
               'modelClass' => Agente::className(),                
               'outputValue' => function ($model, $attribute, $key, $index) {
                    //$fmt = Yii::$app->formatter;
                    return $model->$attribute;                 
               },
               'outputMessage' => function($model, $attribute, $key, $index) {
                     return '';                                  
               },
               
           ]
       ]);
   }

    /**
     * Lists all Agente models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AgenteSearch();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Agente model.
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
     * Creates a new Agente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Agente();
        $model->scenario = Agente::SCENARIO_AB;
        $generos = Genero::find()->all();
        $tipodocumento = Tipodocumento::find()->all();
        $tipocargo = Tipocargo::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $model->apellido = strtoupper($model->apellido);
            $model->nombre = strtoupper($model->nombre);
            $model->mail = strtolower($model->mail);

            $tiposcargos = Yii::$app->request->post()['Agente']['tiposcargo'];
            
            $model->mapuche = 2;
            if($model->save()){
                
                $unc = explode('@', $model->mail);
                if($unc[1]=='unc.edu.ar'){
                    $user = new User();
                    $user->username = $model->mail;
                    $user->role = Globales::US_AGENTE;
                    $user->activate = 1;
                    $user->setPassword($model->documento);
                    $user->generateAuthKey();
                    $user->save();

                    $rolexuser = new Rolexuser();
                    $rolexuser->user = $user->id;
                    $rolexuser->role = $user->role;
                    $rolexuser->save();

                }

                foreach ($tiposcargos as $tc) {
                    $tcx = new Agentextipo();
                    $tcx->agente = $model->id;
                    $tcx->tipocargo = $tc;
                    $tcx->save();
                }
                Yii::$app->session->setFlash('success', "Se creó correctamente el registro");
                return $this->redirect(['view', 'id' => $model->id]);
            }
                
        }

        return $this->render('create', [
            'model' => $model,
            'generos' => $generos,
            'tipodocumento' => $tipodocumento,
            'tipocargo' => $tipocargo,
        ]);
    }

    /**
     * Updates an existing Agente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Agente::SCENARIO_AM;
        $generos = Genero::find()->all();
        $tipodocumento = Tipodocumento::find()->all();
        $tipocargo = Tipocargo::find()->all();

        $query = Agentextipo::find()->where(['agente' => $model->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

                

        //return var_dump($model);

        if ($model->load(Yii::$app->request->post())) {

            $model->apellido = strtoupper($model->apellido);
            $model->nombre = strtoupper($model->nombre);
            $model->mail = strtolower($model->mail);
            if($model->save())
                Yii::$app->session->setFlash('success', "Se modificó correctamente el registro");
                return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'generos' => $generos,
            'tipodocumento' => $tipodocumento,
            'tipocargo' => $tipocargo,
            'dataProvider' => $dataProvider,
            //'tiposcargo' => $tiposcargo,
        ]);
    }
    public function actionUpdatedate($id, $fecha)
    {
        $model = Agente::find()->where(['legajo'=>$id])->one();
        //$model->scenario = Agente::SCENARIO_ABM;
        $model->apellido = $model->apellido;
        $model->nombre = $model->nombre;
        $model->mail = $model->mail;
        $model->genero = $model->genero;
        $model->fechanac = $fecha;
        //model->save();
        
        return $model->save();
        

       
    }

    /**
     * Deletes an existing Agente model.
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
     * Finds the Agente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Agente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Agente::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCalendarioaniversario()
    {
        
        $events = [];

        $docs = Agente::find()->all();
        foreach ($docs as $doc) {
         
            if($doc->fechanac !=null){
                $fecha = explode("-",$doc->fechanac);
            
            for ($i=0; $i <= 1; $i++) { 
                $newfecha = date('Y')+$i."-".$fecha[1]."-".$fecha[2];
                $events[] = new \edofre\fullcalendar\models\Event([
                    'id'               => $doc->id,
                    'title'            => $doc->apellido.', '.$doc->nombre,
                    'start'            => $newfecha,
                    'end'              => $newfecha,
                    'startEditable'    => true,
                    //'color'            => $color,
                    'url'              => 'index.php?r=docente/sendmail&id='.$doc->id.'&tipomail=2',
                    'durationEditable' => true,]);
                }
            }
            
            
            
        }

        return $this->render('calendarioaniversario', [
            'selectable'  => true,
            'events' => $events
            
        ]);
    }

    public function actionActualizardomicilio(){

        
        $searchModel = new AgenteSearch();
        $dataProvider = $searchModel->direccionesdesactualizadas(Yii::$app->request->queryParams);

        $searchModelNo = new NodocenteSearch();
        $dataProviderNo = $searchModelNo->direccionesdesactualizadas(Yii::$app->request->queryParams);

        return $this->render('actualizardomicilio', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelNo' => $searchModelNo,
            'dataProviderNo' => $dataProviderNo,
        ]);
        

    }

    public function actionActualizarmapuche($id){
        $doc = $this->findModel($id);
        $doc->mapuche = 1;
        $doc->save();
        return $this->redirect(['actualizardomicilio']);
    }

    public function actionSendmail($id, $tipomail)
    {
        $doc = $this->findModel($id);

        if($tipomail == 1){

            if($doc->mail == 'msala@unc.edu.ar'){
                        Yii::$app->mailer->compose()
                        ->setFrom([Globales::MAIL => 'CNM'])
                        ->setTo($doc->mail)
                        ->setSubject('Feliz Cumpleaños')
                        ->setHtmlBody('Le deseamos FC')
                        ->send();
            }

        }
        

        return $this->redirect(['calendarioaniversario']);
    }

    
}
