<?php

use app\config\Globales;
use app\modules\edh\models\CertificacionedhSearch;
use app\modules\edh\models\InformeprofesionalSearch;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\SolicitudedhSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Solicitudes';
$this->params['breadcrumbs'][] = $this->title;
$this->params['sidebar'] = [
    'visible' => true,
    'model' => $model,
    'origen' => 'solicitudes',
];

?>
<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'>".'Agregar solicitud al  Caso #'.$model->id."</h2>",
            'id' => 'modaldetalleticket',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>
    <?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader2'>".'Agregar certificado'."</h2>",
            'id' => 'modalcertificado',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent2'></div>";

        Modal::end();
	?>
    <?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader3'>".'Informe profesional'."</h2>",
            'id' => 'modalinfoprofesional',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent3'></div>";

        Modal::end();
	?>
    <?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader4'>".'Cambiar estado'."</h2>",
            'id' => 'amodalsolicitudstate',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent4'></div>";

        Modal::end();
	?>
<div class="solicitudedh-index">

    <?php 

        if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_REGENCIA, Globales::US_COORDINACION, Globales::US_VICEACAD])){
            $buttadd = Html::button('<span class="glyphicon glyphicon-plus"></span> '.'Agregar solicitud', ['value' => Url::to('index.php?r=edh/solicitudedh/create&id='.$model->id), 'class' => 'btn btn-main btn-success amodaldetalleticket contenedorlistado']);
        }else{
            $buttadd = '';
        }

    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            'footer' => false,
            'after' => false,
            'before' => 
                $buttadd
            ,
        ],
        'toolbar'=>[
        
        ],
        'summary' => false,
        //'pjax' => true,
        'condensed' => true,
        'persistResize' => false,
        'responsiveWrap' => false,
        'rowOptions' => function($model){
            
                return ['style' => 'cursor:pointer'];
            
        },
        
        //'hover' => true,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn',
                'vAlign' => 'middle', 
                'hAlign' => 'center', 
            ],

            [
                'header' => '',
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'enableRowClick' => true,
                'allowBatchToggle' => false,
                'detailRowCssClass' => GridView::TYPE_WARNING,
                'enableCache' => false,
                'rowClickExcludedTags' => ['a', 'button', 'input', 'span'],
                
                // show row expanded for even numbered keys
                'detail' => function ($model){
                    $searchModel = new CertificacionedhSearch();
                    $dataProvider = $searchModel->porSolicitud($model->id);

                    $searchModelInforme = new InformeprofesionalSearch();
                    $dataProviderInforme = $searchModelInforme->porSolicitud($model->id);
                    return $this->render('/certificacionedh/porsolicitud', ['solicitud' => $model->id,
                    'dataProvider' => $dataProvider,
                    'searchModelInforme' => $searchModelInforme,
                    'dataProviderInforme' => $dataProviderInforme,
                   
                    ]);},
                
                'value' => function ($model, $key, $index, $column) {
                    //return $sol;
                    return GridView::ROW_COLLAPSED;
                    /*if($key == $sol)
                        return GridView::ROW_EXPANDED;
                    return GridView::ROW_COLLAPSED;*/
                },
                'headerOptions' => ['class' => 'kartik-sheet-style'], 
                'expandOneOnly' => true,
                'disabled' => function($model){
                    return !in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_REGENCIA, Globales::US_COORDINACION, Globales::US_VICEACAD]);
                },
                'visible' => in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_REGENCIA, Globales::US_COORDINACION, Globales::US_VICEACAD]),
                
            ],

            [
                'label' => 'Fecha',
                'vAlign' => 'middle', 
                'hAlign' => 'center', 
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],

            [
                'label' => 'Área de Recepción',
                'vAlign' => 'middle', 
                'hAlign' => 'center', 
                'value' => function($model){
                    return $model->areasolicitud0->nombre;
                }
            ],
            
            [
                'label' => 'Demandante',
                'vAlign' => 'middle', 
                
                'value' => function($model){
                    if($model->demandante !=null)
                        return $model->demandante0->apellido.', '.$model->demandante0->nombre.' ('.$model->demandante0->parentesco.')';
                    return '';
                }
            ],

            [
                'label' => 'Estado',
                'vAlign' => 'middle', 
                'hAlign' => 'center', 
                'value' => function($model){
                    return $model->estadosolicitud0->nombre;
                }
            ],

            [
                'label' => 'Tipo',
                'vAlign' => 'middle', 
                'hAlign' => 'center', 
                'value' => function($model){
                    return $model->tiposolicitud0->nombre;
                }
            ],

            [
                'label' => '# certificados',
                'vAlign' => 'middle', 
                'hAlign' => 'center', 
                'value' => function($model){
                    return count($model->certificacionedhs);
                }
            ],


            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{ver} {rechazar} {eliminar}',
                'vAlign' => 'middle', 
                'hAlign' => 'center', 
                'visible' => in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_REGENCIA, Globales::US_COORDINACION, Globales::US_VICEACAD]),
                'buttons' => [
                    
                    
                                       
                    'rechazar' => function($url, $model, $key){
                            $ret = '';
                            if($model->estadosolicitud < 3){
                                $ret .= Html::button('<span class="glyphicon glyphicon-check"></span> Aceptar', ['value' => Url::to(['cambiarestado', 'id' => $model->id, 'est' => 3]), 'title' => 'Aceptar solicitud del Caso #'.$model->caso, 'class' => 'btn btn-success amodalsolicitudstate', 'style' => 'width:auto;']);
                                $ret .= Html::button('<span class="glyphicon glyphicon-check"></span> Rechazar', ['value' => Url::to(['cambiarestado', 'id' => $model->id, 'est' => 4]), 'title' => 'Rechazar solicitud del Caso #'.$model->caso, 'class' => 'btn btn-danger amodalsolicitudstate', 'style' => 'width:auto;']);
                            }
                            $ret .= Html::button('<span class="glyphicon glyphicon-plus"></span> Expediente', ['value' => Url::to('index.php?r=edh/solicitudedh/expediente&id='.$model->id), 'title' => 'Modificar expediente Caso #'.$model->caso, 'class' => 'btn btn-info amodalsolicitudstate', 'style' => 'width:auto;']);
                            return $ret;
                        
                        },
                    

                    
                ]

            ],
        ],
    ]); ?>
    
</div>
