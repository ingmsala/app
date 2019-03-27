<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;



/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Docentexcomision */
/* @var $form yii\widgets\ActiveForm */


?>

<?php
        
        $listComisiones=ArrayHelper::map($comisiones,'comision', function($comision) {
          //var_dump($comision['comision0']['optativa0']['actividad0']);
            return $comision['comision0']['optativa0']['actividad0']['nombre'].' ('.$comision['comision0']['nombre'].')';}
        );
    ?>
<div><b>Actividades Optativas</b></div>
<?php
      
    
   echo Html::dropDownList('comision', $selection=isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0, $listComisiones, ['prompt' => '(Seleccionar)', 'id' => 'cmbyear', 'class' => 'form-control ',
        'onchange'=>'
                    $.get( "'.Url::toRoute('/optativas/default/setsession').'", { id: $(this).val() } )
                            .done(function( data ) {
                                $( "#'.Html::getInputId($model, 'comision').'" ).val( data );
                                location.reload(true);

                            }
                        );

        ',


        ]);

?>

