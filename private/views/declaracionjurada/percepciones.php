<?php


use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\switchinput\SwitchInput;
use kartik\switchinput\SwitchInputAsset;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Declaracionjurada */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Declaración Jurada';
?>


<h1><?= Html::encode($this->title) ?></h1>
    <h4 class="text-muted">De los cargos y actividades  que desempeña el causante</h4>

<div class="declaracionjurada-form">
    
 
        
    
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
            <?php
                echo '<label class="control-label has-star" >Percepción de pasividades (Jubilaciones, Pensiones, Retiros, etc.)</label>';
                echo SwitchInput::widget([
                    'inlineLabel' => false,
                    'name' => 'pasivi',
                    'value'=>$model->pasividad,
                    'pluginOptions' => [
                        'size' => 'medium',
                        'onText' => 'Sí',
                        'offText' => 'No',
                        'offColor' => 'danger',
                        'onColor' => 'success',
                    ],
                    'pluginOptions' => [
                        'id' => 'amodalpasividad',
                        'size' => 'medium',
                        'onText' => 'Sí',
                        'offText' => 'No',
                        'offColor' => 'danger',
                        'onColor' => 'success',
                    ],
                    'pluginEvents' => [
                        'switchChange.bootstrapSwitch' => 'function() { 
                            var conf = this.checked;
                            var estado = 0;
                            if(conf){
                                $("#divpasividad").show();
                                estado = 1;

                                $("#modalpasividad").modal("show")
                                .find("#modalContent")
                                .load("'.Url::to("index.php?r=pasividaddj/create&dj=".$model->id).'");
                                document.getElementById("modalHeader").innerHTML ="Percepción de pasividades (Jubilaciones, Pensiones, Retiros, etc.)";

                            }else{
                                $("#divpasividad").hide();
                                estado = 0;
                            }
                            
                            

                            $.ajax({
                                url:   "index.php?r=declaracionjurada/actualizarpasividad",
                                type:  "post",
                                data: {id: '.$model->id.', estado: estado},
                                
                                error: function (xhr, status, error) {
                                alert(error);
                                }
                            }).done(function (data) {
                                
                            });
                            
                        }',
                    ],
                ]);
            /*echo Form::widget([
                'model'=>$model,
                
                'attributes'=>[
                    'pasividad'=> [
                        'label' => 'Percepción de pasividades (Jubilaciones, Pensiones, Retiros, etc.)',
                        'type'=>Form::INPUT_WIDGET, 
                                'widgetClass'=>'\kartik\switchinput\SwitchInput', 
                                'options'=>[
                                    'pluginOptions' => [
                                        'id' => 'amodalpasividad',
                                        'size' => 'medium',
                                        'onText' => 'Sí',
                                        'offText' => 'No',
                                        'offColor' => 'danger',
                                        'onColor' => 'success',
                                    ],
                                    'pluginEvents' => [
                                        'switchChange.bootstrapSwitch' => 'function() { 
                                            var conf = this.checked;
                                            var estado = 0;
                                            if(conf){
                                                $("#divpasividad").show();
                                                estado = 1;

                                                $("#modalpasividad").modal("show")
                                                .find("#modalContent")
                                                .load("'.Url::to("index.php?r=pasividaddj/create&dj=".$model->id).'");
                                                document.getElementById("modalHeader").innerHTML ="Percepción de pasividades (Jubilaciones, Pensiones, Retiros, etc.)";

                                            }else{
                                                $("#divpasividad").hide();
                                                estado = 0;
                                            }
                                            
                                            

                                            $.ajax({
                                                url:   "index.php?r=declaracionjurada/actualizarpasividad",
                                                type:  "post",
                                                data: {id: '.$model->id.', estado: estado},
                                                
                                                error: function (xhr, status, error) {
                                                alert(error);
                                                }
                                            }).done(function (data) {
                                                
                                            });
                                            
                                        }',
                                    ],
                                ]
                    ],
                ]
            ]);*/?>
            </h3>
        </div>
        <div id="divpasividad" class="panel-body" <?php if($model->pasividad==0) echo 'style="display: none;"'; else echo 'style="display: block;"'; ?> >
            
            <?php
            
                echo $this->render('/pasividaddj/view', [
                        'dj' => $model->id,
                        'model' => $pasividaddj,
                    ]);

            ?>
        </div>
        
        <?php $form = ActiveForm::begin(); ?>
                  
        <div class="form-group">
            <div class="pull-right"><?= Html::submitButton('Siguiente >', ['class' => 'btn btn-primary']) ?></div>
            <div class="pull-right">&nbsp;</div>
            <div class="pull-right"><?= Html::a('< Anterior', Url::to('index.php?r=declaracionjurada/cargos'), $options = ['class' => 'btn btn-primary']); ?></div>
            
        </div>
        <?php ActiveForm::end(); ?>  
    </div>
    
    

    

<?php
    SwitchInputAsset::register($this);
?>