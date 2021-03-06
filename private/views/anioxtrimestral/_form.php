<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\daterange\DateRangePicker;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Anioxtrimestral */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $listAnio=ArrayHelper::map($anio,'id','nombre'); ?>
<?php $listTrimestral=ArrayHelper::map($trimestral,'id','nombre'); ?>
<?php $listduplicar=ArrayHelper::map($duplicar,'id',function($model){
        return $model->aniolectivo0->nombre.' - '.$model->trimestral0->nombre;
}); ?>

<?php 

    if($nuevo == 1)
        $arrayactivo = [1=>'Activo'];
    else
        $arrayactivo = [1=>'Activo', 2=>'Inactivo']

?>

<div class="anioxtrimestral-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'aniolectivo')->dropDownList($listAnio, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'trimestral')->dropDownList($listTrimestral, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'origenduplicado')->dropDownList($listduplicar, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'h1m')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '99:99 - 99:99'
    ]);

    ?>
    <?= $form->field($model, 'h2m')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '99:99 - 99:99'
    ]);

    ?>
    <?= $form->field($model, 'h1t')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '99:99 - 99:99'
    ]);

    ?>
    <?= $form->field($model, 'h2t')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '99:99 - 99:99'
    ]);

    ?>
    
    <?php 

    	echo $form->field($model, 'inicio', [
		    'addon'=>['prepend'=>['content'=>'<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>']],
		    'options'=>['class'=>'drp-container form-group']
		])->widget(DateRangePicker::classname(), [
		    'useWithAddon'=>true,
		    'convertFormat'=>true,
		    'startAttribute' => 'inicio',
    		'endAttribute' => 'fin',
    		'readonly' => true,
		    'pluginOptions'=>[
		        'locale'=>[
		            'format'=>'d/m/yy',
		            'separator'=>' hasta el ',
		        ],
		        'opens'=>'left'
		    ],
		    
		])->label('Fecha');

     ?>

      <?= $form->field($model, 'activo')->dropDownList($arrayactivo, ['prompt'=>'Seleccionar...', 'id' => 'activo-id']); ?>
      <?= 

      $form->field($model, 'publicado')->widget(DepDrop::classname(), [
          //'data' => $listComisiones,
          'options'=>['id'=>'publicado-id'],
          //'value' => 1,
          'pluginOptions'=>[
              'depends'=>['activo-id'],
              'loading' => false,
              'initialize' => ($model->activo==2) ? false : true,
              //'inicializate' => isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0,
              'placeholder'=>'Seleccionar...',
              'url'=>Url::to(['/anioxtrimestral/publicadotruefalse'])
          ],
          
      ]);

  ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
