<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\Novedadesparte */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $listtiponovedades=ArrayHelper::map($tiponovedades,'id','nombre'); ?>
<?php $listpreceptores=ArrayHelper::map($preceptores,'id',function($model){
	return $model->apellido.', '.$model->nombre;
}); ?>

<div class="novedadesparte-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= 

        $form->field($model, 'tiponovedad')->widget(Select2::classname(), [
            'data' => $listtiponovedades,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'pluginEvents' => [
                'select2:select' => 'function() {
                    if ($(this).val()==1 || $(this).val()==5 || $(this).val()==6) {
                           $( "#divpreceptor" ).show();
                           $( "#divedilicias" ).hide();
                        }else{
                            
                           $( "#divpreceptor" ).hide();
                            $( "#divedilicias" ).hide();
                           if ($(this).val()==2 || $(this).val()==3){
                                $( "#divedilicias" ).show();
                           }
                        }
                        
                }',
            ]
        ]);

    ?>
    <div id="divpreceptor" <?php if($model->docente!=null) echo 'style="display: block; "'; else echo 'style="display: none; "'; ?>>
        
    
    <?= 
                                
                                $form->field($model, 'docente')->widget(Select2::classname(), [
                                    'data' => $listpreceptores,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Docente');

                            ?>
    </div>
    <div id="divedilicias" <?php if(in_array($model->tiponovedad, [2,3])) echo 'style="display: block; "'; else echo 'style="display: none; "'; ?>>
    <div class="row">
        <div class="col-lg-6">
                    <?= Html::label('N° Aula o Nombre del espacio', 'aulaoespacio') ?>
                    <?= Html::textInput('aulaoespacio', null, ['class' => 'form-control']) ?>   
        </div> 
        <div class="col-lg-6">
                   <?= Html::label('Banco', 'banco') ?>
                    <?= Html::textInput('banco', null, ['class' => 'form-control']) ?>   
        </div>         
    </div>   
    
    </div>
    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
