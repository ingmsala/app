<?php

namespace app\modules\horarioespecial\controllers;

use app\models\Catedra;
use app\models\Detallecatedra;
use app\models\Espacio;
use Yii;
use app\modules\horarioespecial\models\Detallemodulo;
use app\modules\horarioespecial\models\DetallemoduloSearch;
use app\modules\horarioespecial\models\Grupodivision;
use app\modules\horarioespecial\models\Habilitacionce;
use app\modules\horarioespecial\models\Horarioclaseespecial;
use app\modules\horarioespecial\models\Moduloclase;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * DetallemoduloController implements the CRUD actions for Detallemodulo model.
 */
class DetallemoduloController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Detallemodulo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DetallemoduloSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Detallemodulo model.
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
     * Creates a new Detallemodulo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($gr, $md)
    {
        

        $dm = Detallemodulo::find()->where(['grupodivision' => $gr])->andWhere(['moduloclase' => $md])->andWhere(['is not', 'horarioclaseespecial', null])->all();
        $grupo = Grupodivision::findOne($gr)->habilitacionce;
        $gruposhabilitados = Grupodivision::find()->where(['habilitacionce' => $grupo])->all();
        
        $gruposhabilitados = count($gruposhabilitados);
        $dm = count($dm);

        //return var_dump($dm);

        if($dm < $gruposhabilitados){
            $model = new Detallemodulo();
            $model->grupodivision = $gr;
            $model->moduloclase = $md;

            $espacios = Espacio::find()->all();
            $horarioclaseespaciales = Horarioclaseespecial::find()->all();
            if ($model->load(Yii::$app->request->post())) {

                $param = Yii::$app->request->post();
                        
                
                foreach ($param['Detallemodulo']['horarioclaseespecial'] as $horario) {
                    $model2 = new Detallemodulo();
                    $model2->grupodivision = $gr;
                    $model2->moduloclase = $md;
                    $model2->espacio = $param['Detallemodulo']['espacio'];
                    $model2->horarioclaseespecial = $horario;
                    $model2->save();
                    
                }

                $detallemodulovacio = Detallemodulo::find()
                                        ->where(['grupodivision' => $gr])
                                        ->andWhere(['moduloclase' => $md])
                                        ->andWhere(['is', 'horarioclaseespecial', null])
                                        ->one();
                if($detallemodulovacio != null)
                    $detallemodulovacio->delete();

                return $this->redirect(Yii::$app->request->referrer.'#'.$model2->grupodivision0->habilitacionce);
            }
            $detallecatedras = Detallecatedra::find()
                                ->joinWith(['catedra0'])
                                ->where(['revista' => 6])
                                ->andWhere(['catedra.division' => $model->grupodivision0->habilitacionce0->division])
                                ->all();
            
            return $this->renderAjax('create', [
                'model' => $model,
                'espacios' => $espacios,
                'detallecatedras' => $detallecatedras,
                'horarioclaseespaciales' => $horarioclaseespaciales,
                'multiple' => true,
            ]);
        
        }else{
            Yii::$app->session->setFlash('danger', "No puede crear mas horarios para esta cantidad de grupos");
            /*$model = new Detallemodulo();
            $model->grupodivision = $gr;
            $model->moduloclase = $md;
            return $this->renderAjax('create', [
                'model' =>  new Detallemodulo(),
                'espacios' => [],
                'horarioclaseespaciales' => [],
            ]);*/
        }

        
    }

    public function actionAgregarmodulo($md, $gr){
        $model = new Detallemodulo();
        $model->moduloclase = $md;
        $model->grupodivision = $gr;
        $model->save();
        return $this->redirect(Yii::$app->request->referrer.'#'.$model->grupodivision0->habilitacionce);
    }

    /**
     * Updates an existing Detallemodulo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $espacios = Espacio::find()->all();
        $horarioclaseespaciales = Horarioclaseespecial::find()->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->referrer.'#'.$model->grupodivision0->habilitacionce);
        }
        
        $detallecatedras = Detallecatedra::find()
                                ->joinWith(['catedra0'])
                                ->where(['revista' => 6])
                                ->andWhere(['catedra.division' => $model->grupodivision0->habilitacionce0->division])
                                ->all();

        return $this->renderAjax('update', [
            'model' => $model,
            'espacios' => $espacios,
            'detallecatedras' => $detallecatedras,
            'horarioclaseespaciales' => $horarioclaseespaciales,
            'multiple' => false,
        ]);
    }

    /**
     * Deletes an existing Detallemodulo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);

        return $this->redirect(['index']);
    }

    public function actionHorarios(){
        /*CAMBIAR DOCENTE*/
        $detallecatedras = Detallecatedra::find()
                                ->joinWith(['agente0'])
                                ->where(['detallecatedra.revista' => 6])
                                ->andWhere(['agente.id' => 163])
                                ->all();
        
        //return var_dump($detallecatedras);

        $divisiones = ArrayHelper::getColumn($detallecatedras,'catedra0.division');
        //return var_dump($divisiones);

        $array = [];
        //foreach ($detallecatedras as $dc) {
        $dm = Detallemodulo::find()
                        ->joinWith(['grupodivision0.habilitacionce0', 'moduloclase0', 'horarioclaseespecial0'])
                        ->where(['habilitacionce.estado' => 1])
                        ->andWhere(['in', 'habilitacionce.division', $divisiones])
                        ->andWhere(['is not', 'horarioclaseespecial', null])
                        /*->andWhere(['or',
                            ['is', 'detallemodulo.detallecatedra', null],
                            ['=', 'detallemodulo.detallecatedra', $dc->id],

                        ])*/
                        ->groupBy(['habilitacionce.division', 'habilitacionce.fecha', 'moduloclase'])
                        ->orderBy('habilitacionce.division, habilitacionce.fecha, horarioclaseespecial.inicio, moduloclase.nombre')
                        ->all();
            //if($dm != null)
             //   $array[] = $dm;
        //}

        $provider = new ArrayDataProvider([
            'allModels' => $dm,
        ]);

        //return var_dump($array);

        return $this->render('horarios',[
            'provider' => $provider
        ]);

    }

    public function actionAsignardocentemodulos($id){

        

                                
        $detallemodulo = Detallemodulo::findOne($id);

        $division = $detallemodulo->grupodivision0->habilitacionce0->division;
        /*CAMBIAR DOCENTE*/
        $detallecatedras = Detallecatedra::find()
                                ->joinWith(['agente0', 'catedra0'])
                                ->where(['detallecatedra.revista' => 6])
                                ->andWhere(['agente.id' => 163])
                                ->andWhere(['catedra.division' => $division])
                                ->all();

       // return var_dump($detallecatedras);

        if(count($detallecatedras)==0){
            return $this->redirect(['horarios']);
            return "No tiene horas en esa división";
        }elseif(count($detallecatedras)==1){
            /*CAMBIAR DOCENTE*/
            $detallecatedra = Detallecatedra::find()
                                ->joinWith(['agente0', 'catedra0'])
                                ->where(['detallecatedra.revista' => 6])
                                ->andWhere(['agente.id' => 163])
                                ->andWhere(['catedra.division' => $division])
                                ->one();

            return $this->redirect(['nuevaclase','id' => $id, 'detallecatedra' => $detallecatedra->id]);
            $echodiv = $this->detalleaulas($id);
            return $this->renderAjax('detalleaulas',[
                'echodiv' => $echodiv,
            ]); 
        }else{
            return "tiene varias materias";
        }

    }

    public function actionNuevaclase($id, $detallecatedra){

        $detallemodulo = Detallemodulo::findOne($id);
        $combos = [];
        $combos[] = [1,2,3];
        $combos[] = [3,1,2];
        $combos[] = [2,3,1];

        foreach ($combos as $combo) {
            
        }

        $dms = Detallemodulo::find()
                ->joinWith(['grupodivision0'])
                ->where(['moduloclase' => $detallemodulo->moduloclase])
                ->andWhere(['grupodivision.habilitacionce' => $detallemodulo->grupodivision0->habilitacionce])
                //->andWhere(['is', 'detallecatedra', null])
                ->all();
        $horarios = [];
        $c = 0;
        $cmb = false;
        $combo = 0;
        foreach ($dms as $dm) {
            $horarios []= [$dm->id, $dm->grupodivision, $dm->horarioclaseespecial, $dm->detallecatedra];

            if($cmb == false){
                if($dm->detallecatedra == null && $c == 0){
                    $combo = 1;
                    $cmb = true;
                    
                }elseif($dm->detallecatedra == null && $c == 1){
                    $combo = 2;
                    $cmb = true;
                    
                }elseif($dm->detallecatedra == null && $c == 3){
                    $combo = 3;
                    $cmb = true;
                    
                }
            }
            
            $c++;
        }

        if($combo == 1){
            $cuadrantes = [0, 4, 8];
            
        }

        if($combo == 2){
            $cuadrantes = [1, 5, 6];
        }

        if($combo == 3){
            $cuadrantes = [2, 3, 7];
        }
        $h = [];

        if($cmb){
            foreach ($cuadrantes as $cuadrante) {
                $model = Detallemodulo::findOne($horarios[$cuadrante][0]);
                $model->detallecatedra = $detallecatedra;
                
                $model->save();
            }
        }else{
            return "No hay mas cupo para anotarse";
        }
        
        

    }

    public function actionDetalleaulas($id){
        $echodiv = $this->detalleaulas($id);
        return $this->renderAjax('detalleaulas',[
            'echodiv' => $echodiv,
        ]);
    }



    protected function detalleaulas($dm){

        $detallemodulo = Detallemodulo::findOne($dm);
        

        
        $echodiv = '';
        date_default_timezone_set('America/Argentina/Buenos_Aires');


        if(Yii::$app->params['devicedetect']['isMobile']){
            $horarios = Detallemodulo::find()->joinWith(['grupodivision0', 'horarioclaseespecial0', 'detallecatedra0.agente0', 'grupodivision0.habilitacionce0'])->where(['habilitacionce.fecha' => $detallemodulo->grupodivision0->habilitacionce0->fecha])->andWhere(['=', 'agente.mail', 'ignacio.ortiz.moran@unc.edu.ar'])->orderBy('horarioclaseespecial.inicio')->all();
            $array = [];
            $salida = '<h2>'.Yii::$app->formatter->asDate($detallemodulo->grupodivision0->habilitacionce0->fecha, 'dd/MM/yyyy').'</h2>';
            
            foreach ($horarios as $horariox) {
                                    
                if($horariox->horarioclaseespecial != null){
                    
                    $ini = explode(":", $horariox->horarioclaseespecial0->inicio);
                    $fin = explode(":", $horariox->horarioclaseespecial0->fin);
                    if($horariox->espacio != null)
                        $espacio = '<br />'.$horariox->espacio0->nombre;
                    else
                        $espacio = ' ';
                    /*CAMBIAR DOCENTE*/
                    if($horariox->detallecatedra != null){
                        $division = $horariox->grupodivision0->habilitacionce0->division0->nombre.' - ';
                        $detallecat = '<br /> '.$horariox->detallecatedra0->catedra0->actividad0->nombre;
                        $seccion = substr($horariox->grupodivision0->habilitacionce0->division0->nombre, -1);
                        $bold = "normal";
                        if($seccion == "A")
                            $color = '#6AB953';
                        elseif($seccion == "B")
                            $color = '#6DDAC4';
                        elseif($seccion == "C")
                            $color = '#6DABDA';
                        elseif($seccion == "D")
                            $color = '#A56DDA';
                        elseif($seccion == "E")
                            $color = '#DA6DAF';
                        elseif($seccion == "F")
                            $color = '#DA6D82';
                        elseif($seccion == "G")
                            $color = '#DAB96D';
                        else
                            $color = '#D1DA6D';
                    }else{
                        $detallecat = ' ';
                        $color = "#d6e3e9";
                        $bold = "normal";
                    }
                    
                    $salida.= '<div style="font-weight: '.$bold.';background-color:'.$color.';border-style: solid;border-width: 1px;border-radius: 5px;">'.$division.$ini[0].':'.$ini[1].' a '.$fin[0].':'.$fin[1].$espacio.$detallecat.'</div>';
                    
                }
            }
            return $salida;
            

        }

        else{

        
            $habilitacionesall = Habilitacionce::find()->joinWith(['grupodivisions'])->where(['grupodivision.habilitacionce' => $detallemodulo->grupodivision0->habilitacionce])->all();

            foreach ($habilitacionesall as $habili) {
                //$habili = Habilitacionce::findOne($id);
                
                //$echodiv .= '<div class="col-md-12">';
                
                $echodiv .=  DetailView::widget([
                    'model'=>$habili,
                    'condensed'=>true,
                    
                    //'mode'=>DetailView::MODE_VIEW,
                    'enableEditMode' => false,
                    
                    'attributes'=>[
                        
                        [
                            'label' => $habili->division0->nombre.'<br />'.Yii::$app->formatter->asDate($habili->fecha, 'dd/MM/yyyy'),
                            'format' => 'raw',
                            'value' => function() use ($habili) {
                                //return var_dump($model);
                                $grupos = Grupodivision::find()->where(['habilitacionce' => $habili->id])->all();
                                $modulos = Moduloclase::find()->joinWith(['detallemodulos', 'detallemodulos.grupodivision0'])->where(['grupodivision.habilitacionce' => $habili->id])->all();
                                
                                
                                $cd = 0;
                                $array = [];
                                $salida = '';


                                if(count($grupos)==0){
                                    $grupomodel = new Grupodivision();
                                    $grupomodel->habilitacionce = $habili->id;
                                    $grupomodel->nombre = 1;
                                    $grupomodel->save();
                                    $grupos = Grupodivision::find()->where(['habilitacionce' => $habili->id])->all();
                                }


                                foreach ($grupos as $grupo) {
                                    $ch = 0;
                                    foreach ($modulos as $modulo) {
                                        # code...
                                        if($cd == 0)
                                            $array[$modulo->id][$cd] = 'Grupo'.'<br /><em>'.$grupo->nombre.'</em>'; 
                                            $array[$modulo->id]['-99'] = '<em>'.$modulo->nombre.'</em>'; 
                                            $array[$modulo->id][$grupo->id] = '';
                                    
                                        $ch = $ch + 1;
                                    }
                                    $cd = $cd + 1;
                                }
                                //return var_dump($array);
                                $gruposcolumna = [];
                                
                                $gruposcolumna ['-99'] = [
                                    
                                    'label' => '',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'attribute' => '-99',
                                    
                                ];

                                foreach ($grupos as $key => $grupo) {
                                    $gruposcolumna[$grupo->id] = 
                                        
                                        [
                                            'label' => 'Grupo '.$grupo->nombre,
                                            'vAlign' => 'middle',
                                            'hAlign' => 'center',
                                            'format' => 'raw',
                                            'attribute' => $grupo->id,
                                            /*'value' => function($model){
                                                return $model['0'];
                                                
                                            }*/
                                        ];
                                }
                                $horarios = Detallemodulo::find()->joinWith(['grupodivision0', 'horarioclaseespecial0'])->where(['grupodivision.habilitacionce' => $habili->id])->orderBy('horarioclaseespecial.inicio')->all();
                                foreach ($horarios as $horariox) {
                                    
                                    if($horariox->horarioclaseespecial != null){
                                        
                                        $ini = explode(":", $horariox->horarioclaseespecial0->inicio);
                                        $fin = explode(":", $horariox->horarioclaseespecial0->fin);
                                        if($horariox->espacio != null)
                                            $espacio = '<br />'.$horariox->espacio0->nombre;
                                        else
                                            $espacio = ' ';
                                        /*CAMBIAR DOCENTE*/
                                        if($horariox->detallecatedra != null){
                                            $detallecat = '<br /> '.$horariox->detallecatedra0->catedra0->actividad0->nombre.'<br />('.$horariox->detallecatedra0->agente0->apellido.')';
                                            if($horariox->detallecatedra0->agente0->mail == 'ignacio.ortiz.moran@unc.edu.ar'){
                                                $color = "#c7f4d3";
                                                $bold = "bold";
                                            }else{
                                                $color = "#d6e3e9";
                                                $bold = "normal";
                                            }
                                        }else{
                                            $detallecat = ' ';
                                            $color = "#d6e3e9";
                                            $bold = "normal";
                                        }
                                        
                                        $array[$horariox->moduloclase][$horariox->grupodivision] .= '<div style="font-weight: '.$bold.';background-color:'.$color.';border-style: solid;border-width: 1px;border-radius: 5px;">'.$ini[0].':'.$ini[1].' a '.$fin[0].':'.$fin[1].$espacio.$detallecat.'</div>';
                                        
                                    }
                                }
                                ksort($array);
                                //return var_dump($array);
                                //return var_dump($gruposcolumna);
                                $provider = new ArrayDataProvider([
                                    'allModels' => $array,
                                    
                                ]);

                                $salida = '';
                            
                            if(count($modulos)==0){
                                return $salida;
                            }
                            
                            
                                $salida .= GridView::widget([
                                    'dataProvider' => $provider,
                                    //'filterModel' => $searchModel,
                                    'id' => $habili->id,
                                    'summary' => false,
                                    //'hover' => true,
                                    'responsiveWrap' => false,
                                    'condensed' => true,
                                    
                                    'columns' => $gruposcolumna,
                                ]);
                                
                                return $salida;
                            }
                        ],
                        
                    
                    ]
                ]);
                //$echodiv .= '</div>';
            }
        }

        return $echodiv;
                           

    }

    /**
     * Finds the Detallemodulo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Detallemodulo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Detallemodulo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
