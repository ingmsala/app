<?php

use app\modules\ticket\models\Estadoauthpago;
use kartik\detail\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Authpago */

\yii\web\YiiAsset::register($this);

if($updatehabilitado == 1){//update depende de estado ticket y del authpago
    $botonupdate = Html::button('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', ['value' => Url::to(['/ticket/authpago/update', 'id' => $model->id]), 'title' => 'Modificar Orden de Pago', 'class' => 'btn btn-link btn-sp amodalgenerico pull-right']);
}
elseif($updatehabilitado == 2)//createupdate 
    $botonupdate = Html::button('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', ['value' => urldecode(Url::to(['/ticket/authpago/createupdate&'.http_build_query($model->attributes)])), 'title' => 'Modificar Orden de Pago', 'class' => 'btn btn-link btn-sp amodalgenerico pull-right']);
else
    $botonupdate = '';
?>
<div style="margin:28px;">

<?= DetailView::widget([
        'model' => $model,
        'mode'=>DetailView::MODE_VIEW,
        'enableEditMode' => false,
        'panel' => [
            'type' => DetailView::TYPE_INFO,
            'heading' => '<div>'.Html::encode('Orden de pago').$botonupdate.'</div>',
            //'beforeOptions' => ['class'=>'kv-panel-before'],
            /*'headingOptions' => [
                'template' => '',
            ],*/
        ],
        'attributes' => [
            
           
            [
                'columns' => 
                    [
                        [
                            'label' => 'Fecha',
                            'value' => function()use($model){
                                
                                date_default_timezone_set('America/Argentina/Buenos_Aires');
                                //return var_dump(strpos('-',$model->fecha));
                                if(strpos($model->fecha, '-')===false)
                                    return $model->fecha;
                                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                                
                            } 
                            
                        ],
                        [
                            'label' => 'N° Orden de pago',
                            'value' => $model->ordenpago
                                
                        ],
                        [
                            'label' => 'Monto',
                            'value' => '$ '.$model->monto
                                
                        ],
                    ]
            ],

           
            [
                'columns' => 
                    [
                        [
                            'label' => 'CUIT - Proveedor',
                            'value' => $model->proveedor0->cuit
                            
                        ],
                        [
                            'label' => 'Proveedor',
                            'value' => $model->proveedor0->nombre
                                
                        ],
                        [
                            'label' => 'Estado',
                            'format' => 'raw',
                            'value' => function()use($model){
                                if($model->estado == 1)
                                    $lbl = 'info';
                                elseif($model->estado == 2)
                                    $lbl = 'petroleo';
                                elseif($model->estado == 3)
                                    $lbl = 'purple';
                                else
                                    $lbl = 'warning';
                                return '<span class="label label-'.$lbl.'">'.$model->estado0->nombre.'</span>';
                            }
                        ],
                    ]
            ],
            
        ],
    ]) ?>

    
    

</div>
