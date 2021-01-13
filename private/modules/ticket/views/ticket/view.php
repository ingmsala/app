<?php

use kartik\base\Config;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\markdown\Markdown;
use kartik\markdown\Module;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Ticket */

$this->title = 'Ticket #'.$model->id;

?>

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'>".'Respuesta Ticket #'.$model->id.': '.$model->asunto."</h2>",
            'id' => 'modaldetalleticket',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>
<div class="ticket-view">

    <h2><?= Html::encode($this->title)?></h2>
    <p>
        <?php Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que desea eliminar el elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php
        //$arr = ArrayHelper::map($adjuntos,'url', 'nombre');
        $arr = ArrayHelper::map($adjuntos,'url', function($model){
            $len = (Yii::$app->params['devicedetect']['isMobile']) ? 20 : 40;
            if(strlen($model->nombre)>$len){
                $arr = [];
                $arr = explode(".", $model->nombre);
                $ext = end($arr);
                return substr(ltrim($model->nombre),0,$len).'...'.$ext;


            }else
                return $model->nombre;
        });

        $module = Config::getModule(Module::MODULE);
        $output = Markdown::convert($model->descripcion, ['custom' => $module->customConversion]);
        
        $echofooter = HtmlPurifier::process($output);

        //$echofooter = $model->descripcion;
        if($arr != null){
            $echofooter .= '<hr style="margin-bottom:0px;" />';
            $echofooter .= '<div class="push-left text-muted">Adjuntos</div><div class="row">';
                foreach ($arr as $key => $img) {
                    $echofooter .= '<div style="margin-left:5%" class="col-md-3">'.Html::a('<div class="label label-default">'.$img.'</div>', Url::to(['adjuntoticket/descargar', 'file' => $key]), ['target'=>'_blank']).'</div>';
                }
            $echofooter .= '</div>';
        }
        

    ?>
    

    <?php

        $fecha = Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
        $hora = explode(':', $model->hora);

        echo '<div class="col-md-12">';
        //echo use 
        echo DetailView::widget([
            'model'=>$model,
            'condensed'=>true,
            'hover'=>true,
            'responsive' => true,
            'mode'=>DetailView::MODE_VIEW,
            'enableEditMode' => false,
            'panel'=>[
                'heading'=>$model->asunto,
                'headingOptions' => [
                    'template' => '',
                ],
                'type'=>DetailView::TYPE_PRIMARY ,
                'footer' => $echofooter,
                'footerOptions' => ['style' => 'background-color:#fff']
            ],
            'attributes'=>[
                /*'fecha',
                'hora',
                'asunto',
                'descripcion:ntext',
                'estadoticket',
                'agente',
                'asignacionticket',
                'prioridadticket',*/
                [
                    'columns' => 
                        [
                            [
                                'label' => 'Abierto',
                                //'attribute'=>'fecha',
                                'value' => $fecha.' - '.$hora[0].':'.$hora[1].'hs.'
                            ],
                            
                            [
                                'label' => 'Prioridad',
                                'format' => 'raw',
                                'value' => $model->prioridadticket0->nombre
                            ],

                            [
                                'label' => 'Estado',
                                'format' => 'raw',
                                'value' => ($model->estadoticket == 1) ? '<span class="label label-success">'.$model->estadoticket0->nombre.'</span>' : '<span class="label label-danger">'.$model->estadoticket0->nombre.'</span>'
                            ],
                        
                        ],
                ],

                [
                    'columns' => 
                        [
                            [
                                'label' => 'Creado por',
                                'value' => $model->agente0->apellido.", ".$model->agente0->nombre, 
                            ],
                            
                            [
                                'label' => 'Asignado a',
                                'value' => $primeraAsignacion->agente ? $primeraAsignacion->agente0->apellido.', '.$primeraAsignacion->agente0->nombre : $primeraAsignacion->areaticket0->nombre
                            ]
                        
                        ],
                ],

                [
                    'group'=>true,
                    'label'=>'Descripción',
                    'rowOptions'=>['class'=>'warning']
                ],

                
            
            ]
        ]);
        echo '</div>';

        
        echo $this->render('/detalleticket/porticket', [
            'dataProvider' => $dataProvider,
            'modelDetalles' => $modelDetalles,
            
        ]);   
        
        echo '<div class="contenedorlistado">';

        if($model->estadoticket == 2){
            $textButton = 'Reabrir ticket';
            $btnClass = 'danger';
            $gly = 'open';
        }else{
            $textButton = 'Responder';
            $btnClass = 'primary';
            $gly = 'plus';
        }
        
        echo Html::button('<span class="glyphicon glyphicon-'.$gly.'"></span> '.$textButton, ['value' => Url::to('index.php?r=ticket/detalleticket/create&ticket='.$model->id), 'class' => 'btn btn-main btn-'.$btnClass.' amodaldetalleticket pull-right contenedorlistado']);
        
        echo '</div>';
        

    ?>

    

</div>
