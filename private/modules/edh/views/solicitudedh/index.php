<?php

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

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('<span class="glyphicon glyphicon-plus"></span> '.'Agregar solicitud', ['value' => Url::to('index.php?r=edh/solicitudedh/create&id='.$model->id), 'class' => 'btn btn-main btn-success amodaldetalleticket contenedorlistado']); ?>
    </p>

    
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => false,
        //'pjax' => true,
        'condensed' => true,
        'persistResize' => false,
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
                'expandOneOnly' => true
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
                'buttons' => [
                    
                    
                                       
                    'rechazar' => function($url, $model, $key){
                        
                            return Html::button('<span class="glyphicon glyphicon-refresh"></span>', ['value' => Url::to('index.php?r=edh/solicitudedh/cambiarestado&id='.$model->id), 'class' => 'btn btn-info amodalsolicitudstate', 'style' => 'width:auto;']);
                       
                        
                        },
                    

                    
                ]

            ],
        ],
    ]); ?>
    
</div>
