<?php

namespace app\modules\sociocomunitarios\controllers;

use Yii;
use app\models\Docente;
use app\modules\curriculares\models\Acta;
use app\modules\curriculares\models\Comision;
use app\modules\curriculares\models\Docentexcomision;
use app\modules\curriculares\models\Estadoseguimiento;
use app\modules\curriculares\models\Matricula;
use app\modules\curriculares\models\MatriculaSearch;
use app\modules\curriculares\models\Seguimiento;
use app\modules\curriculares\models\SeguimientoSearch;
use app\modules\curriculares\models\Tiposeguimiento;
use app\modules\sociocomunitarios\models\Calificacionrubrica;
use app\modules\sociocomunitarios\models\Detallerubrica;
use app\modules\sociocomunitarios\models\Rubrica;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * SeguimientoController implements the CRUD actions for Seguimiento model.
 */
class SeguimientoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'rubrica'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [1,8])){
                                    $autoriza = false;
                                     if(in_array (Yii::$app->user->identity->role, [1])){
                                         return true;
                                    }
                                    if($_GET['r'] == 'sociocomunitarios/seguimiento/create')
                                        $matricula = Matricula::findOne(Yii::$app->request->queryParams['id']);
                                    else
                                        $matricula = Seguimiento::findOne(Yii::$app->request->queryParams['id'])->matricula0;
                                    
                                    $docente = Docente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                    $cant = count(Docentexcomision::find()
                                                        ->where(['comision' => $matricula->comision])
                                                        ->andWhere(['docente' => $docente->id])
                                                        ->all());
                                        if($cant>0){
                                            $autoriza = true;
                                        }

                                   
                                    

                                    if(
                                        count(Acta::find()->where(['comision' => $matricula->comision])->andWhere(['estadoacta' => 2])->all()) > 0){
                                        Yii::$app->session->setFlash('info', "No se puede realizar la acción ya que la comisión tiene un acta en estado cerrado");
                                        $autoriza = false;
                                    }
                                    return $autoriza;
                                }
                                return false;
                                
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],
                    [
                        'actions' => ['index','rubrica'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [1,3,6,8,9,12,13,20]);
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
                                if(in_array (Yii::$app->user->identity->role, [1,3,6,12,13, 20]))
                                    return true;
                                elseif(in_array (Yii::$app->user->identity->role, [8,9])){
                                    $matricula = Matricula::findOne(Yii::$app->request->queryParams['id']);
                                    $docente = Docente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                    $cant = count(Docentexcomision::find()
                                                    ->where(['comision' => $matricula->comision])
                                                    ->andWhere(['docente' => $docente->id])
                                                    ->all());
                                    if($cant>0){
                                        return true;
                                    }
                                }
                                    
                                
                                
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
     * Lists all Seguimiento models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $this->layout = 'main';
        $searchModel = new MatriculaSearch();
        $com = isset($_SESSION['comisiontsx']) ? $_SESSION['comisiontsx'] : 0;
        if($com != 0){

            $dataProvider = $searchModel->alumnosxcomision($com);
            
            $seguimientos = Seguimiento::find()
                
                ->joinWith('matricula0')
                ->where(['matricula.comision' =>$com])
                ->all();

            return $this->render('index', [
                
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'seguimientos' => $seguimientos,

            ]);
        }else{
        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Proyecto Sociocomunitario</b>');
            return $this->redirect(['/sociocomunitarios']);
        }
    }

    /**
     * Displays a single Seguimiento model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
        $this->layout = 'main';
        $matricula = $id;
        $com = isset($_SESSION['comisiontsx']) ? $_SESSION['comisiontsx'] : 0;
        if($com != 0){
            $searchModel = new SeguimientoSearch();
            $dataProvider = $searchModel->seguimientosdelalumno($matricula);
            $matr = Matricula::findOne($matricula);
            
            return $this->render('view', [
                'matricula' => $matricula,
                'dataProvider' => $dataProvider,
                'matr' => $matr,
            ]);
        }else{
        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Proyecto Sociocomunitario</b>');
            return $this->redirect(['/sociocomunitarios']);
        }
    }

    /**
     * Creates a new Seguimiento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $trimestre = [1=>'1° trimestre',2=>'2° trimestre',3=>'3° trimestre'];
        $this->layout = 'main';
        $com = isset($_SESSION['comisiontsx']) ? $_SESSION['comisiontsx'] : 0;
        if($com != 0){
            $model = new Seguimiento();
            $estados = Estadoseguimiento::find()->all();
            $tipos = Tiposeguimiento::find()->all();
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $model->fecha = date("Y-m-d");
            $model->matricula = $id;
            //$trimestre = ArrayHelper::map($trimestre,0,1);

            $array = [];

            $provider = new ArrayDataProvider([
                'allModels' => $array,
                    
            ]);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                if($model->tiposeguimiento == 3)
                    return $this->redirect(['view', 'id' => $model->matricula]);
                else
                    return $this->redirect(['rubrica', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
                'estados' => $estados,
                'trimestre' => $trimestre,
                'tipos' => $tipos,
                'provider' => $provider,
                
                'matr' => Matricula::findOne($id),
            ]);
        }else{
        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Proyecto Sociocomunitario</b>');
            return $this->redirect(['/sociocomunitarios']);
        }
    }

    public function actionRubrica($id){
        $this->layout = 'main';
        $com = isset($_SESSION['comisiontsx']) ? $_SESSION['comisiontsx'] : 0;
        if($com != 0){
            $model = $this->findModel($id);
            $comision = Comision::findOne($com);
            $curso = $comision->espaciocurricular0->curso;
            $rubricas = Rubrica::find()->where(['curso' => $curso])->all();
            
            $array = [];
            
            $cantdefilas = count($rubricas);
            $cantactivas = 0;
                
            foreach ($rubricas as $rubrica) {
                
                    
                    

                    $calificacionrub = Calificacionrubrica::find()->where(['rubrica' => $rubrica->id])->all();

                    $sal = '<div class="list-group">';
                    $ca = 0;
                    foreach ($calificacionrub as $calif) {

                        $dr = Detallerubrica::find()->where(['seguimiento' => $model->id])->andWhere(['calificacionrubrica' => $calif->id])->one();
                        if($dr==null)
                            $ac = '';
                        else{
                            $ac=' active';
                            $cantactivas++;
                            $ca++;
                        }
                            
                        $sal.=Html::a('<h4 class="list-group-item-heading">'.$calif->detalleescalanota0->nota.'</h4>'.'<p class="list-group-item-text">'.$calif->descripcion.'</p>',"#",[
                            'class' => 'list-group-item'.$ac,
                            'onclick'=>'
                                event.preventDefault();
                                $.ajax({
                                    type     :"post",
                                    cache    : false,
                                    url  : "index.php?r=sociocomunitarios/detallerubrica/new",
                                    
                                    data: {seguimiento: '.$model->id.', calificacion: '.$calif->id.', id: '.$model->id.'},
                                    
                                    error: function (xhr, status, error) {
                                        if(error != "Forbidden")
                                            alert(error);
                                    }
                                    }).done(function (data) {
                                        //$(this).addClass("list-group-item active");
                                    //alert($(this));
                                        $.pjax.reload({container: "#test", async: false});
                                    });',
                                        ]);
                    }

                    $sal .='</div>';
                    if($ca == 0)
                        $array[$rubrica->id][0] = $rubrica->descripcion.'<span style="color:red"> *</span>';
                    else
                        $array[$rubrica->id][0] = $rubrica->descripcion;
                    $array[$rubrica->id][1] = $sal;
                
                
                
            }

            /*$drs = Detallerubrica::find()->where(['seguimiento' => $model->id])->all();

            foreach ($drs as $dr) {
                
                
                        $array[$dr->calificacionrubrica0->rubrica][1] = 'ok';
                    
                

            }*/
               
            $provider = new ArrayDataProvider([
                'allModels' => $array,
                    
            ]);

            if (Yii::$app->request->post()) {
                if($cantactivas<$cantdefilas){
                    Yii::$app->session->setFlash('danger', "* Falta/n completar ".($cantdefilas-$cantactivas).' Aspecto/s a evaluar');
                }
                else{
                    Yii::$app->session->setFlash('info', "Se guardó correctamente la rúbrica");
                    return $this->redirect(['index']);
                }
            }

            return $this->render('rubrica', [
                'model' => $model,
                'provider' => $provider,
                'cantdefilas' => $cantdefilas,
                'cantactivas' => $cantactivas,
                
            ]);

        }else{
            Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Proyecto Sociocomunitario</b>');
                return $this->redirect(['/sociocomunitarios']);
            }
    }

    /**
     * Updates an existing Seguimiento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $trimestre = [1=>'1° trimestre',2=>'2° trimestre',3=>'3° trimestre'];
        $this->layout = 'main';
        $com = isset($_SESSION['comisiontsx']) ? $_SESSION['comisiontsx'] : 0;
        if($com != 0){
            $model = $this->findModel($id);
            $estados = Estadoseguimiento::find()->all();
            $tipos = Tiposeguimiento::find()->all();

            

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                if($model->tiposeguimiento == 3)
                    return $this->redirect(['view', 'id' => $model->matricula]);
                else
                    return $this->redirect(['rubrica', 'id' => $model->id]);
                
            }

            return $this->render('update', [
                'model' => $model,
                'estados' => $estados,
                'tipos' => $tipos,
                'trimestre' => $trimestre,
                
            ]);
        }else{
        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Proyecto Sociocomunitario</b>');
            return $this->redirect(['/sociocomunitarios']);
        }
    }

    /**
     * Deletes an existing Seguimiento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        
        $this->layout = 'main';
        $model = $this->findModel($id);
        $matricula = $model->matricula;
        $model->delete();

        return $this->redirect(['view', 'id' => $matricula]);
    }

    /**
     * Finds the Seguimiento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Seguimiento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Seguimiento::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
