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
                        }else{
                            
                           $( "#divpreceptor" ).hide();

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
    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
