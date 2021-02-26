<?php

use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\solicitudprevios\models\DetallesolicitudextSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Solicitudes: '.$turno->nombre;

?>

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modalcasoupdate',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>
    <?php 
        $breadcrumbs = [];
        $breadcrumbs [] = ['label' => $turno->nombre];
        //$breadcrumbs [] = $this->title;

    ?>


    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => '< Volver', 'url' => ['/turnoexamen']],
        'links' => $breadcrumbs,
    ]) ?>
<div class="detallesolicitudext-index">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,

        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel', 
                'filename' =>Html::encode($this->title),
                'config' => [
                    'worksheet' => Html::encode($this->title),
            
                ]
            ],
            //GridView::HTML => [// html settings],
            GridView::PDF => ['label' => 'PDF',
                'filename' =>Html::encode($this->title),
                'options' => ['title' => 'Portable Document Format'],
                'config' => [
                    'methods' => [ 
                        'SetHeader'=>[Html::encode($this->title).' - Colegio Nacional de Monserrat'], 
                        'SetFooter'=>[date('d/m/Y').' - Página '.'{PAGENO}'],
                    ]
                ],
            ],
        ],

        'toolbar'=>[
            ['content' => 
               ''

            ],
            '{export}',
            
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Estudiante',
                
                'value' => function($model){
                    //return var_dump($model);
                    return $model->solicitud0->apellido.', '.$model->solicitud0->nombre;
                },
                'group' => true,
                
            ],

            

            [
                'label' => 'Documento',
                
                'value' => function($model){
                    //return var_dump($model);
                    return $model->solicitud0->documento;
                },
                'group' => true,
                
            ],

            
            
            
            [
                'label' => 'Correo electrónico',
                
                'value' => function($model){
                    //return var_dump($model);
                    return $model->solicitud0->mail;
                },
                'group' => true,
                
            ],
            [
                'header' => 'Nro de Teléfono / <br />Celular de contacto',
                
                'value' => function($model){
                    //return var_dump($model);
                    return $model->solicitud0->telefono;
                },
                'group' => true,
                
            ],

            [
                'label' => 'Adjuntos',
                'format' => 'raw',
                'group' => true,
                'value' => function($model){

                    


                    //$echofooter = '<ul style="padding-inline-start: 0px;">';
                    $echofooter = '';
                    
                    foreach ($model->solicitud0->adjuntosolicitudexts as $adjunto) {

                        $len = (Yii::$app->params['devicedetect']['isMobile']) ? 15 : 20;

                        if(strlen($adjunto->nombre)>$len){
                            
                            $arr = explode(".", $adjunto->nombre);
                            $ext = end($arr);
                            $img = substr(ltrim($adjunto->nombre),0,$len).'...'.$ext;
            
            
                        }else
                            $img = $adjunto->nombre;

                        $echofooter .= '<div class="label label-default" style="border-style: solid;border-width: 1px;border-radius: 5px;">'.Html::a('<div class="label label-default">'.$img.'</div>', Url::to(['adjuntosolicitudext/descargar', 'file' => $adjunto->url]), ['target'=>'_blank', 'data-pjax'=>"0"]).' '.
                             '</div><div class="clearfix"></div>';  
                            
                        
                            //$echofooter .= '<li style="list-style:none">'.Html::a('<div class="label label-default">'.$img.'</div>', Url::to(['adjuntocertificacion/descargar', 'file' => $adjunto->url]), ['target'=>'_blank']).'</li>';
                              
                            
                        
                    }
                    //$echofooter .= '</ul>';
                    return $echofooter;
                }
            ],

            [
                'label' => 'Materia',
                
                'value' => function($model){
                    //return var_dump($model);
                    return $model->actividad0->nombre;
                },
                  // enable grouping,
                //'groupedRow' => true,                    // move grouped column to a single grouped row
                //'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                //'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                
            ],

            [
                'label' => 'Estado',
                'format' => 'raw',
                'value' => function($model){
                    //return var_dump($model);
                    if($model->estado0->estado0->id == 3){
                        return Html::button($model->estado0->estado0->nombre, ['value' => Url::to(['/solicitudprevios/estadoxsolicitudext/index', 'det' => $model->id]), 'title' => 'Motivo de rechazo de solicitud'.' #'.$model->id, 'class' => 'btn btn-link amodalcasoupdate']);
                    }
                    return $model->estado0->estado0->nombre;
                },
                  // enable grouping,
                //'groupedRow' => true,                    // move grouped column to a single grouped row
                //'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                //'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                
            ],

            [
                'label' => 'Acción',
                'format' => 'raw',
                'value' => function($model){
                    //return var_dump($model);
                    $salida = '';
                    if($model->estado0->estado0->id == 1){
                        
                        $salida .= Html::button('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>', ['value' => Url::to(['/solicitudprevios/estadoxsolicitudext/create', 'estado' => 3, 'detalle' => $model->id]), 'title' => 'Rechazar solicitud'.' #'.$model->id, 'class' => 'btn btn-danger amodalcasoupdate']);
                        $salida .= Html::a('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>', Url::to(['/solicitudprevios/estadoxsolicitudext/create', 'estado' => 2, 'detalle' => $model->id]), ['title' => 'Aceptar solicitud'.' #'.$model->id, 'class' => 'btn btn-success']);
                        
                    }else{
                        $salida .= Html::a('<span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>', Url::to(['/solicitudprevios/estadoxsolicitudext/create', 'estado' => 1, 'detalle' => $model->id]), ['title' => 'Revertir solicitud'.' #'.$model->id, 'class' => 'btn btn-default']);
                    }
                    return $salida;
                    
                },
                  // enable grouping,
                //'groupedRow' => true,                    // move grouped column to a single grouped row
                //'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                //'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                
            ],

            [
                'label' => 'Datos personales',
                'format' => 'raw',
                'value' => function($model){
                    //return var_dump($model);
                    
                    if($model->estado0->estado0->id == 1){
                        
                        return Html::button('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', ['value' => Url::to(['/solicitudprevios/solicitudinscripext/update', 'id' => $model->solicitud]), 'title' => 'Modificar datos personales', 'class' => 'btn btn-info amodalcasoupdate']);
                        
                    }
                    
                },
                  // enable grouping,
                //'groupedRow' => true,                    // move grouped column to a single grouped row
                //'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                //'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                
            ],
            

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
