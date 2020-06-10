<?php

namespace app\controllers;

use Yii;
use app\models\Docente;
use app\models\DocenteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Genero;
use yii\filters\AccessControl;
use app\config\Globales;
use app\models\Tipodocumento;
use app\models\User;
use kartik\grid\EditableColumnAction;
use yii\helpers\ArrayHelper;

/**
 * DocenteController implements the CRUD actions for Docente model.
 */
class DocenteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'editdocumento', 'updatedate'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'editdocumento'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA]);
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
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_CONSULTA]);
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
               'modelClass' => Docente::className(),                
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
     * Lists all Docente models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocenteSearch();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Docente model.
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
     * Creates a new Docente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Docente();
        $model->scenario = Docente::SCENARIO_ABM;
        $generos = Genero::find()->all();
        $tipodocumento = Tipodocumento::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $model->apellido = strtoupper($model->apellido);
            $model->nombre = strtoupper($model->nombre);
            if($model->save()){
                $user = new User();
                $user->username = $model->mail;
                $user->role = Globales::US_DOCENTE;
                $user->activate = 0;
                $user->setPassword($model->documento);
                $user->generateAuthKey();
                $user->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
                
        }

        return $this->render('create', [
            'model' => $model,
            'generos' => $generos,
            'tipodocumento' => $tipodocumento,
        ]);
    }

    /**
     * Updates an existing Docente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Docente::SCENARIO_ABM;
        $generos = Genero::find()->all();
        $tipodocumento = Tipodocumento::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $model->apellido = strtoupper($model->apellido);
            $model->nombre = strtoupper($model->nombre);
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'generos' => $generos,
            'tipodocumento' => $tipodocumento,
        ]);
    }
    public function actionUpdatedate($id, $fecha)
    {
        $model = Docente::find()->where(['legajo'=>$id])->one();
        //$model->scenario = Docente::SCENARIO_ABM;
        $model->apellido = $model->apellido;
        $model->nombre = $model->nombre;
        $model->mail = $model->mail;
        $model->genero = $model->genero;
        $model->fechanac = $fecha;
        //model->save();
        
        return $model->save();
        

       
    }

    /**
     * Deletes an existing Docente model.
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
     * Finds the Docente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Docente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Docente::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCalendarioaniversario()
    {
        
        $events = [];

        $docs = Docente::find()->all();
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
