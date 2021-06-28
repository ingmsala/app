<?php

use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Authpago */
/* @var $form yii\widgets\ActiveForm */
$estados =ArrayHelper::map($estados,'id', 'nombre');
$proveedores =ArrayHelper::map($proveedores,'id', function($model){
    return $model->cuit.' - '.$model->nombre;
});
?>

<div class="authpago-form">

    
<?php $form = ActiveForm::begin(); ?>



<?php

            echo FormGrid::widget([
            
            'model'=>$modelauth,
            'form'=>$form,
            'autoGenerateColumns'=>true,
            'rows'=>[
               
                [
                    
                    'attributes'=>[       // 2 column layout
                        
                        
                        'proveedorsearch'=>['type'=>Form::INPUT_TEXT],   
                        'ordenpagosearch'=>['type'=>Form::INPUT_TEXT],   
                        
                        
                        
                    ]
                ],
                

                
                                
                
            ]

        ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    </div>