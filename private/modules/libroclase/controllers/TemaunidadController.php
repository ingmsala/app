<?php

namespace app\modules\libroclase\controllers;

use app\config\Globales;
use app\models\Agente;
use app\models\Detallecatedra;
use app\models\Docentexdepartamento;
use app\modules\libroclase\models\Clasediaria;
use app\modules\libroclase\models\Detalleunidad;
use Yii;
use app\modules\libroclase\models\Temaunidad;
use app\modules\libroclase\models\TemaunidadSearch;
use kartik\helpers\Html;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TemaunidadController implements the CRUD actions for Temaunidad model.
 */
class TemaunidadController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'porunidad', 'detunidad', 'devolvertema'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if((in_array (Yii::$app->user->identity->username, [Globales::US_SUPER])))
                                    return true;
                                $persona = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                $depto = Docentexdepartamento::find()->where(['agente' => $persona->id])->count();
                                return (in_array (Yii::$app->user->identity->username, Globales::authttemas) || $depto>0 );
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['porunidad', 'detunidad'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if (in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_AGENTE])){
                                    $doc = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                    
                                    $dcs = Detallecatedra::find()
                                    ->joinWith(['catedra0', 'catedra0.division0'])
                                    ->where(['detallecatedra.agente' => $doc->id])
                                    ->andWhere(['detallecatedra.revista' => 6])
                                    ->andWhere(['detallecatedra.aniolectivo' => 3])
                                    ->andWhere(['catedra.id' => Yii::$app->request->queryParams['cat']])
                                    ->all();
                                        
                                    if(count($dcs)>0)
                                        return true;
                                    else
                                        return false;

                                }
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],
                    [
                        'actions' => ['devolvertema'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_AGENTE]);
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
     * Lists all Temaunidad models.
     * @return mixed
     */
    public function actionIndex($actividad)
    {
        $searchModel = new TemaunidadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
    }

    public function actionPorunidad($detuni, $actividad, $cat)
    {
        $searchModel = new TemaunidadSearch();
        $dataProvider = $searchModel->pordetalleunidadycat($detuni, $cat);
        
        $model = new Clasediaria();

        $unidades = Detalleunidad::find()
                                ->joinWith(['unidad0', 'programa0'])
                                ->where(['programa.actividad' => $actividad])
                                ->andWhere(['programa.vigencia' => 1])
                                ->orderBy('unidad.id')
                                ->all();
                                

        return $this->renderAjax('porunidad', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'unidades' => $unidades,
            'model' => $model,
            'cat' => $cat,
        ]);
    }

    public function actionDetunidad($detuni, $nose, $cat)
    {
        $nose2 = json_decode($nose);
        $searchModel = new TemaunidadSearch();
        $dataProvider = $searchModel->pordetalleunidadycat($detuni, $cat);

        return $this->renderPartial('detunidad', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'nose' => $nose2,
            'cat' => $cat,
        
        ]);
    }
    public function actionDevolvertema($id, $bot)
    {
        $tema = Temaunidad::findOne($id);
        //return '<div id="tema'.$id.'">'.$tema->descripcion.'</div>';
        if($bot==0){
            $label = '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
            $tipo = 'danger';
            $bot = 1;
        }else{
            $label = '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>';
            $tipo = 'success';
            $bot = 0;
        }
            $par = '<input type=\"hidden\" name=\"tipodes['.$id.']\" id=\"tipodes'.$id.'\" value=\"1\">';
            $tot = '<input type=\"hidden\" name=\"tipodes['.$id.']\" id=\"tipodes'.$id.'\" value=\"2\">';
        return json_encode([
            '0' => '<div id="buttontema'.$id.'">'.
                                Html::button($label, 
                                ['class' => 'btn btn-'.$tipo, 
                        
                                        'onclick' => '
                                            $.get("index.php?r=libroclase/temaunidad/devolvertema&bot='.$bot.'&id='.$id.'", function( data ) {
                                                jsonString = JSON.parse(data);
                                                bot = jsonString[2];
                                                id = jsonString[3];
                                                if(bot==1){
                                                    $( "div#temasseleccionados" ).append( jsonString[1] );
                                                    $( "div#forminputs" ).append( jsonString[4] );
                                                }else{
                                                    $( "div#tema"+id ).remove();
                                                    $( "input#valtema"+id ).remove();
                                                }
                                                
                                                $( "div#buttontema'.$id.'" ).html( jsonString[0] );
                                            });
                                        '
                
                                ]).
                            '</div>', 
            '1' => '<div class="temaseleccionado" id="tema'.$id.'">'.$tema->descripcion.
                '<div class="btn-group pull-right" role="group" aria-label="...">'.
                    Html::button("Parcial", 
                        [   
                            'class' => 'btn btn-success', 
                            'id' => 'pp'.$id.'pp',
                                'onclick' => '
                                    id = '.$id.';
                                    cl = "tt"+id+"tt";
                                    cl2 = "pp"+id+"pp";
                                    try{
                                        $( "div#tipodes"+id ).remove();
                                    }catch(err){
                                    }
                                    $( "div#forminputstipo-des" ).append( "'.$par.'" );
                                    this.setAttribute("id", cl2);
                                    document.getElementById(cl).setAttribute("class", "btn btn-default");
                                    document.getElementById(cl2).setAttribute("class", "btn btn-success");
                                    
                                   
                                    
                                    
                                    
                                    
                                    
                                '

                        ]).
                    Html::button("Total", 
                        [   
                            'class' => 'btn btn-default', 
                            'id' => 'tt'.$id.'tt',
                
                                'onclick' => '
                                    id = '.$id.';
                                    cl = "tt"+id+"tt";
                                    cl2 = "pp"+id+"pp";
                                    try{
                                        $( "div#tipodes"+id ).remove();
                                    }catch(err){
                                    }
                                    $( "div#forminputstipo-des" ).append( "'.$tot.'" );
                                    this.setAttribute("id", cl);
                                    document.getElementById(cl).setAttribute("class", "btn btn-success");
                                    document.getElementById(cl2).setAttribute("class", "btn btn-default");
                                    
                                    
                                
                                '

                        ])
                .'</div><div class="clearfix"></div>'
            .'</div>',
            '2' => $bot,
            '3' => $id,
            '4' => '<input type="hidden" class="valtemaxx" name="valtemas['.$id.']" id="valtema'.$id.'" value="'.$id.'">',
        ]);

        
    }

    /**
     * Displays a single Temaunidad model.
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
     * Creates a new Temaunidad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($detalleunidad)
    {
        
        $model = new Temaunidad();
        $model->detalleunidad = $detalleunidad;

        if ($model->load(Yii::$app->request->post())) {
            $cantidad = Temaunidad::find()->where(['detalleunidad' => $detalleunidad])->count()+1;
            $param = Yii::$app->request->post();

            $temas = $param['Temaunidad']['descripcion'];
            $separador = $param['separador'];
            $procesar = $param['procesar'];

            if($separador == ''){
                //return var_dump($separador);
                $model->prioridad = $cantidad;
                $model->save();
            }else{

                try {
                    $temas2 = explode($separador, $procesar);
                    $i = 0;
                    foreach ($temas2 as $t) {
                        $model2 = new Temaunidad();
                        $model2->prioridad = $cantidad + $i;
                        $model2->detalleunidad = $detalleunidad;
                        $model2->descripcion = $t;
                        $model2->save();
                        $i++;
                    }
                } catch (\Throwable $th) {
                    //$model->descripcion = $param['Temaunidad']['descripcion'];
                    $model->prioridad = $cantidad;
                    $model->save();
                }
            }

            //return var_dump($param);
            
            

            

            //return var_dump($param);

            return $this->redirect(['/libroclase/programa/view', 'id' => $model->detalleunidad0->programa, 'in' => $model->detalleunidad0->id]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Temaunidad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/libroclase/programa/view', 'id' => $model->detalleunidad0->programa, 'in' => $model->detalleunidad0->id]);
        }


        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Temaunidad model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $modelaux = $this->findModel($id);
        $model = $modelaux;
        $modelaux->delete();

        $temas = Temaunidad::find()
            ->where(['detalleunidad' => $model->detalleunidad])
            ->andWhere((['>', 'prioridad', $model->prioridad]))
            ->all();
        
        foreach ($temas as $tema) {
            $tema->prioridad = $tema->prioridad - 1;
            $tema->save();
        }

        return $this->redirect(['/libroclase/programa/view', 'id' => $model->detalleunidad0->programa, 'in' => $model->detalleunidad0->id]);
        
        
    }

    public function actionCambiarprioridad($up, $id){

        $modelaux = $this->findModel($id);
        if($up == 1){
            $modelacambiar = Temaunidad::find()
            ->where(['detalleunidad' => $modelaux->detalleunidad])
            ->andWhere((['=', 'prioridad', ($modelaux->prioridad - 1)]))
            ->one();
            if($modelacambiar != null){
                $modelacambiar->prioridad = $modelaux->prioridad;
                $modelaux->prioridad = $modelaux->prioridad - 1;
                $modelacambiar->save();
                $modelaux->save();
            }
            

        }else{
            $modelacambiar = Temaunidad::find()
            ->where(['detalleunidad' => $modelaux->detalleunidad])
            ->andWhere((['=', 'prioridad', ($modelaux->prioridad + 1)]))
            ->one();
            if($modelacambiar != null){
                $modelacambiar->prioridad = $modelaux->prioridad;
                $modelaux->prioridad = $modelaux->prioridad + 1;
                $modelacambiar->save();
                $modelaux->save();
            }
            
        }

        return $modelaux->detalleunidad0->id;

        //return $this->redirect(['/libroclase/programa/view', 'id' => $modelaux->detalleunidad0->programa, 'in' => $modelaux->detalleunidad0->id]);
        

    }

    /**
     * Finds the Temaunidad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Temaunidad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Temaunidad::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
