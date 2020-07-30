<?php



use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\builder\TabularForm;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\typeahead\Typeahead;


$this->title = 'Otros establecimientos';

?>

<h1><?= Html::encode($this->title) ?></h1>
    

<div class="declaracionjurada-form">



    <?php

            
            /*unset($attribs['attributes']['color']);
            $attribs['attributes']['status'] = [
                'type'=>TabularForm::INPUT_WIDGET, 
                'widgetClass'=>\kartik\widgets\SwitchInput::classname()
            ];*/

            if(Yii::$app->params['devicedetect']['isMobile']){
                date_default_timezone_set('America/Argentina/Buenos_Aires');

                echo '<em class="text-muted">En donde se desempeña con carácter de docente</em> <br/><br/>';
                echo Html::button('<span class="glyphicon glyphicon-plus"></span> Agregar establecimiento', ['value' => Url::to('index.php?r=detallefonid/create&fn='.$fonid), 'class' => 'btn btn-main btn-success amodaldetallefonid']).'<br /><br />';
                $models = $dataProvider->getModels();
                $i = 0;
                foreach ($models as $model) {
                    
                    //$fechaok = Yii::$app->formatter->asDate($modelok['fecha'], 'dd/MM/yyyy');

                    if($model->id != null){
                        echo '<div class="col-6">';
                    $i++;
                    
                    $tipo = ($model->tipo==1) ? 'Secundarias':'Terciarias';
                    
                    //echo '<div class="col-xs-6 col-md-3">';
                   
                        echo Html::button('<ul>'
                        .'<li><b>Jurisdicción:</b> '.$model->jurisdiccion.'</li>'
                        .'<li><b>Establecimiento:</b> '.$model->denominacion.'</li>'
                        .'<li><b>Nombre:</b> '.$model->nombre.'</li>'
                        .'<li><b>Cargo:</b> '.$model->cargo.'</li>'
                        .'<li><b>Horas:</b> '.$model->horas.'</li>'
                        .'<li><b>Secundario/terciario:</b> '.$tipo.'</li>'
                        .'<li><b>Observaciones:</b> '.$model->observaciones.'</li></ul>', ['value' => Url::to('index.php?r=detallefonid/update&id='.$model->id), 'class' => 'btn btn-default active btn-block amodaldetallefonid', 'style'=>'text-align:left;overflow: hidden;text-overflow: ellipsis;white-space:normal;']);
                        

                    
                    //echo '</div>';

                    
                    echo '</div>'.'<br />';
                    }
                    
                }
                


            


            }
                else{
            echo '<h4 class="text-muted">En donde se desempeña con carácter de docente</h4>';
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => '',

                'panel'=>[
                    'heading' => 'Año '.date('Y'),
                    'before' => false,
                    'footer'=>false,
                    'type' => GridView::TYPE_DEFAULT,
                    'after'=> Html::button('<span class="glyphicon glyphicon-plus"></span> Agregar fila', ['value' => Url::to('index.php?r=detallefonid/create&fn='.$fonid), 'class' => 'btn btn-main btn-success amodaldetallefonid'])
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
        
                    
                    'jurisdiccion',
                    'denominacion',
                    'nombre',
                    'cargo',
                    'horas',
                    [
                        'header' => 'Secundarias o <br/> Terciarias',
                        'value' => function($model){
                            if($model->tipo == 1){
                                return "Secundarias";
                            }
                            return "Terciarias";
                        }
                    ],
                    'observaciones',
                    //'fonid',
        
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{modificar}{borrar}',
                        
                        'buttons' => [
                            'modificar' => function($url, $model, $key){
                                return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => Url::to('index.php?r=detallefonid/update&id='.$model['id']), 'class' => 'btn btn-link amodaldetallefonid']);
                            },
                            'borrar' => function($url, $model, $key){
                                
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=detallefonid/delete&id='.$model['id'], 
                                    ['data' => [
                                    'confirm' => 'Está seguro de querer eliminar este elemento?',
                                    'method' => 'post',
                                     ]
                                    ]);
                            }
                        ]
                    ]
                ],
            ]);

            
            

            
            
        }

            
    ?>
   
        

        

    
</div>