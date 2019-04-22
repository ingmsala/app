<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\widgets\Pjax;



/* @var $this yii\web\View */
/* @var $model app\models\Parte */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $this->registerJs("
    

 


  $('#btnausentes').on('click', function (e) {
    //e.preventDefault();

    
    var keys = 'ok';


    if(keys.length < 1){
        keys = [0];
    }
        
        var deleteUrl     = 'index.php?r=db-manager%2Fdefault%2Fnuevoajax';
       
        var pjaxContainer2 = 'test2';
                    
                    $.ajax({
                      url:   deleteUrl,
                      type:  'post',
                      data: {id: keys},
                      
                      error: function (xhr, status, error) {
                        //alert(error);
                      }
                    }).done(function (data) {
                      //alert(data);
                      $('#devok').innerHTML = data;
                      //$.pjax.reload({container: '#' + $.trim(pjaxContainer2)});
                      //window.location.href = 'index.php?r=optativas%2Fclase%2Fview&id='+ clase;

                      //alert('La operación se realizó correctamente');
                    });
    
              
  });

"); ?>

<div class="parte-form">

    <?php $form = ActiveForm::begin([
    	'id' => 'create-update-detalle-catedra-form',
    ]); ?>

    <?php $listPreceptoria=ArrayHelper::map($precepx,'id','nombre'); 
    
    ?>

  		
	   <div style="width: 25%;">
    <?= 
$form->field($model, 'fecha')->widget(DatePicker::classname(), [
    //'name' => 'dp_3',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    //'value' => '23-Feb-1982',
    'readonly' => true,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'endDate' => "1d",
        
    ],
    
]); ?>

</div>

    
    <?= $form->field($model, 'preceptoria')->dropDownList($listPreceptoria, ['prompt'=>'Seleccionar...','style' => 'width:20%']); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success', 'id' => 'btnausentes']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>




<?php 


Pjax::begin(['id' => 'test2', 'timeout' => 5000]); ?>
    <div id="devok">
    
</div>
    
<?php Pjax::end(); ?>

<?php if (in_array (Yii::$app->user->identity->role, [1])): ?>
            <?=Html::a(
                '<span class="glyphicon glyphicon-ok"></span> BAckup',
                false,
                [
                    'class' => 'btn btn-primary',
                    'id' => 'btnausentes2',
                    
                ]
            );
    ?>
        <?php endif ?>

 
