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


$this->title = 'Declaración Jurada';

?>

<h1><?= Html::encode($this->title) ?></h1>
    

<div class="declaracionjurada-form">
<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modalpasividad',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>

<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); ?>
    <?php

            
            /*unset($attribs['attributes']['color']);
            $attribs['attributes']['status'] = [
                'type'=>TabularForm::INPUT_WIDGET, 
                'widgetClass'=>\kartik\widgets\SwitchInput::classname()
            ];*/

            if(Yii::$app->params['devicedetect']['isMobile']){
                date_default_timezone_set('America/Argentina/Buenos_Aires');

                echo '<em class="text-muted">Debe cargar todos los cargos (incluso aquellos que se encuentren en licencia). Para agregar uno nuevo haga click en +. Para modificar o eliminar alguno ya cargado haga click sobre el cargo</em> <br/><br/>';
                    
                $models = $dataProvider->getModels();
                $i = 0;
                foreach ($models as $model) {
                    
                    //$fechaok = Yii::$app->formatter->asDate($modelok['fecha'], 'dd/MM/yyyy');

                    if($model->cargo != null){
                        echo '<div class="col-6">';
                    $i++;
                    $entidad = ($model->publico==1) ? 'Pública':'Privada';
                    $licencia = ($model->licencia==1) ? 'No':'Sí';
                    
                    //echo '<div class="col-xs-6 col-md-3">';
                    if($model->publico == 2){

                        echo Html::button('<ul>'
                        .'<li><b>Entidad:</b> '.$entidad.'</li>'
                        .'<li><b>Repartición:</b> '.$model->reparticion.'</li>'
                        .'<li><b>Cargo:</b> '.$model->cargo.'</li>'
                        .'<li><b>Horas:</b> '.$model->horas.'</li>'
                        .'<li><b>Licencia:</b> '.$licencia.'</li></ul>', ['value' => Url::to('index.php?r=funciondj/update&id='.$model->id), 'class' => 'btn btn-default active btn-block amodalhorariojs', 'style'=>'text-align:left;overflow: hidden;text-overflow: ellipsis;white-space:normal;']);

                    }else{
                        echo Html::button('<ul>'
                        .'<li><b>Entidad:</b> '.$entidad.'</li>'
                        .'<li><b>Dependencia:</b> '.$model->dependencia.'</li>'
                        .'<li><b>Repartición:</b> '.$model->reparticion.'</li>'
                        .'<li><b>Cargo:</b> '.$model->cargo.'</li>'
                        .'<li><b>Horas:</b> '.$model->horas.'</li>'
                        .'<li><b>Licencia:</b> '.$licencia.'</li></ul>', ['value' => Url::to('index.php?r=funciondj/update&id='.$model->id), 'class' => 'btn btn-default active btn-block amodalhorariojs', 'style'=>'text-align:left;overflow: hidden;text-overflow: ellipsis;white-space:normal;']);
                    }

                    
                    //echo '</div>';

                    
                    echo '</div>'.'<br />';
                    }
                    
                }
                echo '<div class="clearfix"></div>';
                echo '<div class="btn-group-fab" role="group" aria-label="FAB Menu">';
                    echo '<div>';
                     
                        echo Html::button('<span class="glyphicon glyphicon-plus"></span>', ['value' => Url::to('index.php?r=funciondj/create&dj='.$declaracionjurada), 'class' => 'btn btn-main btn-success amodalhorariojs']);
                    
                    echo '</div>';
            echo '</div>';


            echo '<div class="form-group">';
            echo '<div class="pull-left">'.Html::a("< Anterior", Url::to('index.php?r=declaracionjurada/datospersonales'), $options = ['class' => 'btn btn-primary']) .'</div>';

            if($i>0){
                echo '<div class="pull-left">&nbsp;</div>';        
                echo '<div class="pull-left">'.Html::a("Siguiente >", Url::to('index.php?r=declaracionjurada/percepciones'), $options = ['class' => 'btn btn-primary']) .'</div>';
                
            }
            echo '</div>';


            }
                else{
            echo '<h4 class="text-muted">Debe completar una fila por cada cargo (incluso aquellos que se encuentren en licencia)</h4>';
            echo TabularForm::widget([
                'dataProvider'=>$dataProvider,
                'form'=>$form,
                //'staticOnly'=>true,
                'actionColumn'=>[
                    'class' => 'kartik\grid\ActionColumn',
                    'template' => '{deletefuncion} ',
                    'buttons' => [
                        
                        'deletefuncion' => function($url, $model, $key){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=funciondj/delete&id='.$model['id'], 
                                ['data' => [
                                'confirm' => '¿Está seguro de querer eliminar este elemento?',
                                'method' => 'post',
                                 ]
                                ]);
                        },
                    ]
    
                ],
                'checkboxColumn'=>false,
                
                'attributes'=>[

                    'id' => [ // atributo de clave primaria 
                        'type' => TabularForm :: INPUT_HIDDEN , 
                        'columnOptions' => [ 'hidden' => true ]
                    ],

                    'publico'=>[
                        'type'=>TabularForm::INPUT_WIDGET, 
                        'widgetClass'=>'\kartik\select2\Select2', 
                            'options'=> [
                                'data'=>$publicos, 'hideSearch' => true,
                                'pluginEvents' => [
                                    'select2:select' => 'function() {
                                        idx = $(this).attr("id").replace("publico", "dependencia");
                                        if ($(this).val()==1) {
                                            document.getElementById(idx).disabled = false;
                                            document.getElementById(idx).value = "";
                                            
                                            }else{
                                                
                                            document.getElementById(idx).disabled = true;
                                            document.getElementById(idx).value = "";
                                            }
                                    }
                                            ',
                                ],
                            ],
                           
                    ],


                    
                    'dependencia'=>[
                        'type'=>TabularForm::INPUT_WIDGET, 
                        'widgetClass'=>'\kartik\typeahead\Typeahead', 
                        'options'=>function($model, $key, $index, $widget) use ($listadofunciones) {
                            if($model->publico == 1){
                                $dis = false;
                                $arr =  array_column($listadofunciones,'dependencia');
                                $pl = '';
                            }else{
                                $dis = true;
                                $arr = [];
                                $pl = '';
                            }
                                
                            return [
                                'options' => ['placeholder' => $pl, "autocomplete"=>"off", 'disabled' => $dis],
                                'pluginOptions' => ['highlight'=>true],
                                'dataset' => [
                                    [
                                        'local' => $arr,
                                        'limit' => 10
                                    ]
                                ]
                        
                            ];
                        }, 
                        
                    ],
                    'reparticion'=>[
                        'type'=>TabularForm::INPUT_WIDGET, 
                        'widgetClass'=>'\kartik\typeahead\Typeahead', 
                        'options'=>[
                            'options' => ['placeholder' => 'Repartición o lugar de trabajo', "autocomplete"=>"off"],
                            'pluginOptions' => ['highlight'=>true],
                            'dataset' => [
                                [
                                    'local' => array_column($listadofunciones,'reparticion'),
                                    'limit' => 10
                                ]
                            ]
                        ], 
                    ],
                    'cargo'=>[
                        'type'=>TabularForm::INPUT_WIDGET, 
                        'widgetClass'=>'\kartik\typeahead\Typeahead', 
                        'options'=>[
                            'options' => ['placeholder' => 'Cargo', "autocomplete"=>"off"],
                            'pluginOptions' => ['highlight'=>true],
                            'dataset' => [
                                [
                                    'local' => array_column($listadofunciones,'cargo'),
                                    'limit' => 10
                                ]
                            ]
                        ], 
                    ],
                    'horas'=>[
                        'type'=>TabularForm::INPUT_TEXT,
                        'options' => ['placeholder' => 'Horas', "autocomplete"=>"off"],
                    ],

                    'licencia'=>[
                        'type'=>TabularForm::INPUT_WIDGET, 
                        'widgetClass'=>'\kartik\select2\Select2', 
                            'options'=> ['data'=>$licencia, 'hideSearch' => true],
                           
                    ],

                    

                ],
                
                'gridSettings'=>[
                    //'condensed'=>true,
                    //'floatHeader'=>true,
                    'responsiveWrap' => false,
                    'summary' => false,
                    'panel'=>[
                        'heading' => 'Datos relacionados con las funciones, cargos y ocupaciones',
                        'before' => false,
                        'footer'=>false,
                        'type' => GridView::TYPE_DEFAULT,
                        'after'=> Html::submitButton('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar fila', ['class'=>'btn btn-success', 'name' => 'btn_submit', 'value' => 'add'])
                               
                                
                    ],
                    
                ]   
            ]);

            echo '<div class="form-group">';
            echo '<div class="pull-right">'.Html::submitButton("Siguiente >", ["class" => "btn btn-primary", "name" => "btn_submit", "value" => "sig"]) .'</div>';
            echo '<div class="pull-right">&nbsp;</div>';
            echo '<div class="pull-right">'.Html::submitButton("< Anterior", ["class" => "btn btn-primary", "name" => "btn_submit", "value" => "ant"]) .'</div>';
            echo '</div>';
            
        }

            
    ?>
   
        

        

    <?php ActiveForm::end(); ?>

</div>