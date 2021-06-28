<?php

namespace app\modules\sociocomunitarios\controllers;

use Yii;
use app\config\Globales;
use app\models\Agente;
use app\modules\curriculares\models\Acta;
use app\modules\curriculares\models\Detalleacta;
use app\modules\curriculares\models\DetalleactaSearch;
use app\modules\curriculares\models\Detalleescalanota;
use app\modules\curriculares\models\Docentexcomision;
use app\modules\curriculares\models\Estadoseguimiento;
use app\modules\curriculares\models\Seguimiento;
use kartik\grid\EditableColumnAction;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DetalleactaController implements the CRUD actions for Detalleacta model.
 */
class DetalleactaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['editdetalleacta', 'index', 'cerraracta', 'delete', 'printacta', 'altaacta'],
                'rules' => [
                    [
                        'actions' => ['actas', 'view', 'index', 'cerraracta', 'printacta'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_CONSULTA, Globales::US_DIRECCION, Globales::US_SACADEMICA, Globales::US_COORDINACION, Globales::US_PSC, Globales::US_PRECEPTORIA, Globales::US_REGENCIA]))
                                    return true;
                                elseif(in_array (Yii::$app->user->identity->role, [Globales::US_AGENTE, Globales::US_PRECEPTOR])){
                                    
                                    $acta = Acta::findOne(Yii::$app->request->queryParams['acta_id']);
                                    return true;
                                    $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                    
                                    $cant = count(Docentexcomision::find()
                                                    ->where(['comision' => $acta->comision])
                                                    ->andWhere(['agente' => $agente->id])
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
                    
                    [
                        'actions' => ['editdetalleacta'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                           try{
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]))
                                    return true;
                                elseif(in_array (Yii::$app->user->identity->role, [Globales::US_AGENTE, Globales::US_PRECEPTOR])){
                                    /*$acta = Acta::findOne(Yii::$app->request->queryParams['acta_id']);
                                    $agente = Agente::find()->where(['legajo' => Yii::$app->user->identity->username])->one();
                                    $cant = count(Docentexcomision::find()
                                                    //->where(['comision' => $acta->comision])
                                                    ->Where(['agente' => $agente->id])
                                                    ->all());
                                    if($cant>0){
                                        return true;
                                    }*/
                                    return true;
                                }
                                return false;
                                
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['altaacta'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]))
                                    return true;
                                elseif(in_array (Yii::$app->user->identity->role, [Globales::US_AGENTE, Globales::US_PRECEPTOR])){
                                    $acta = Acta::findOne(Yii::$app->request->queryParams['id']);
                                    $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                    $cant = count(Docentexcomision::find()
                                                    ->where(['comision' => $acta->comision])
                                                    ->andWhere(['agente' => $agente->id])
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

                    [
                        'actions' => ['create', 'delete'],   
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

     public function actions()
   {
       return ArrayHelper::merge(parent::actions(), [
           'editdetalleacta' => [                                       
               'class' => EditableColumnAction::className(),     
               'modelClass' => Detalleacta::className(),                
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
     * Lists all Detalleacta models.
     * @return mixed
     */

    public function actionIndex($acta_id = 0){
        $this->layout = 'main';
        return $this->generarActa($acta_id,0);
    }

    public function actionCerraracta($acta_id = 0){
        $this->layout = 'main';
        return $this->generarActa($acta_id, 1);
    }

    public function actionAltaacta(){
        $this->layout = 'main';
        if(Yii::$app->request->post()){
            $acta_id = Yii::$app->request->post('Acta')['id'];
            
            
            if(Acta::findOne($acta_id)->estadoacta == 1){
                $matriculas = (array)Yii::$app->request->post('selection');
                foreach ($matriculas as $matricula) {
                    $model = new Detalleacta();
                    $model->acta = $acta_id;
                    $model->matricula = $matricula;
                    if($model->validate()){
                        $model->save();
                    }
                }
            }else{
                Yii::$app->session->setFlash('danger', "No se puede agregar alumnos a un acta cerrada");
            }

            

            return $this->redirect(['acta/view', 'id' => $acta_id]);

            
        }
        return $this->redirect(['acta/actas', 'cl' => 0]);
    }

    public function generarActa($acta_id, $cl)
    {
        $btncerrar = '';
        
        if (Yii::$app->request->post('hasEditable')) {
            $keys = unserialize(Yii::$app->request->post('editableKey'));
            return $keys;
        }
       
        //return var_dump($acta_id);
        $acta = Acta::findOne($acta_id);

        if($acta == null){
            Yii::$app->session->setFlash('danger', "No existe el acta solicitada");
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        }
        if($cl==0)
            $url = 'index';
        elseif ($cl==1) {
            if($acta->estadoacta==1)
            $btncerrar = Html::a('<center><span class="glyphicon glyphicon-lock" aria-hidden="true"></span><br />Cerrar acta</center>', Url::to(['acta/cerraracta', 'acta' => $acta->id]), ['class' => 'btn btn-default']);
            $url = 'cerraracta';
        }
        $detalleescalas = Detalleescalanota::find()->where(['escalanota' => $acta->escalanota])->all();
        $seguimientos = Seguimiento::find()
                            ->joinWith(['matricula0'])
                            ->where(['matricula.comision' => $acta->comision])
                            ->andWhere(['tiposeguimiento' => 2])
                            ->orderBy('id')->all();
        $estadoseguimiento = Estadoseguimiento::find()->all();
        
        $searchModel = new DetalleactaSearch();
        $dataProvider = $searchModel->alumnosXacta($acta_id);

        $zAprobados = count(Detalleacta::find()->joinWith(['detalleescala0'])->where(['acta' => $acta_id])->andWhere(['detalleescalanota.condicionnota' => 1])->all());
        $zRegulares = count(Detalleacta::find()->joinWith(['detalleescala0'])->where(['acta' => $acta_id])->andWhere(['detalleescalanota.condicionnota' => 2])->all());
        $zLibres = count(Detalleacta::find()->joinWith(['detalleescala0'])->where(['acta' => $acta_id])->andWhere(['detalleescalanota.condicionnota' => 3])->all());

        return $this->render($url, [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'detalleescalas' => $detalleescalas,
            'acta' => $acta,
            'zAprobados' => $zAprobados,
            'zRegulares' => $zRegulares,
            'zLibres' => $zLibres,
            'btncerrar' => $btncerrar,
            'seguimientos' => $seguimientos,
            'estadoseguimiento' => $estadoseguimiento,
        ]);
    }

    

    /**
     * Deletes an existing Detalleacta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->layout = 'main';
        $det = $this->findModel($id);
        $acta = $det->acta;
       $det->delete();

        return $this->redirect(['index', 'acta_id' => $acta]);
    }

    /**
     * Finds the Detalleacta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Detalleacta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Detalleacta::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPrintacta($acta_id){
        //$this->layout = null;
        $this->layout = 'vacio';
        $actaX = Acta::findOne($acta_id);
        
        if($actaX->estadoacta == 1){
            Yii::$app->session->setFlash('danger', "No se puede imprimir un acta abierta");
            return $this->redirect(['detalleacta/cerraracta', 'acta_id' => $acta_id]);
        }

        $docentes = $actaX->comision0->docentexcomisions;
        $item = [];
        foreach ($docentes as $agente) {
            if($agente->role == 8)
                $item[] = [$agente->agente0->apellido, $agente->agente0->nombre];
        }

        $filenamesext = "{$actaX->libro0->aniolectivo0->nombre} - Acta de {$actaX->comision0->espaciocurricular0->actividad0->nombre}";
        $filename =$filenamesext.".pdf";

        if (YII_ENV_DEV) {
            Yii::$app->getModule('debug')->instance->allowedIPs = [];
        }
        $salida = '';
        
        $salida .= $this->generarActa($acta_id,1);
        $content = $this->renderAjax('print', [
                'salida' => $salida,
                
               
            ]);

        //return $content;

        $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        'marginHeader' => 5,
        'marginLeft' => 5,
        'marginTop' => -65,
        'marginRight' => 5,

        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
        'destination' => Pdf::DEST_DOWNLOAD, 
        'filename' => $filename, 
        // your html content input
        'content' => $content,  
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        //'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '
                

                .panel-title{
                    text-align: center;
                    display: none;
                }
                .kv-grid-table{
                    font-size:10px;
                }
                .detalleacta-index{
                   
                    max-height: 100%;
                    overflow: hidden;
                   
                }

                .pull-right {
                    display: none;
                }

                .container-fluid{
                    text-align: left;
                    font-weight: normal;
                    font-style: normal;
                }

                .bold{
                    font-weight: bold;
                }

                #imagen{
                    width: 300px;
                    height: 93px;
                }
                .cerradax{
                    float: left;
                }
                

                ', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Colegio Nacional de Monserrat', 'setAutoTopMargin' => 'pad'],
         // call mPDF methods on the fly
        'methods' => [ 
            //'defaultheaderline' => 0,

            'SetHeader'=>['<div class="container-fluid"><div class="row">
                                    <div class="col-xs-3">
                                        <img id="imagen" src="assets/images/enc3.png" />
                                    </div>
                                    <div class="col-xs-3">
                                        <ul style="padding-left: 0px;list-style:none;">
                                            <li><span class="bold">MÓDULO:</span> Proyectos Sociocomunitarios</li>
                                            <li><span class="bold">ACTIVIDAD:</span> '.$actaX->comision0->espaciocurricular0->actividad0->nombre.'</li>
                                            <li><span class="bold">AÑO LECTIVO:</span> '.$actaX->libro0->aniolectivo0->nombre.'</li>
                                        </ul>
                                    </div>
                                    <div class="col-xs-3">
                                        <span class="bold">DOCENTES</span>'.
                                         
                                                Html::ul($item, ['item' => function($item) {
                                                         return 
                                                                    Html::tag('li', $item[0].', '.$item[1]);
                                                    
                                                }])

                                        .'
                                        
                                    </div>
                                    <div class="col-xs-1">
                                        <ul style="padding-left: 0px;list-style:none;">
                                                <li><span class="bold">LIBRO:</span> '.$actaX->libro0->nombre.'</li>
                                                <li><span class="bold">ACTA N°:</span> '.$actaX->nombre.'</li>
                                            </ul> 
                                        
                                    </div>
                                </div><div class="row" style="text-align: center;"><span class="bold">ACTA DE REGULARIDAD</span></div></div>'], 
            'SetFooter'=>['<div class="container-fluid">
                            <div class="col-xs-3">
                            <span class="cerradax">Acta cerrada por: '.$actaX->user0->username.'</span>'
                            .'</div><div class="col-xs-3">.</div><div class="col-xs-6">'
                            .date('d/m/Y')." - ".$filenamesext.' - Hoja {PAGENO}/{nb}'
                            .'</div></div>'],
        ]
    ]);
    
    // return the pdf output as per the destination setting
    
    return $pdf->render(); 
    }
}
