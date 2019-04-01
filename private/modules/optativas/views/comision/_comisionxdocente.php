<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Alert;



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

<div id="menucomxdoc">
    <div><b>Espacios Optativos</b></div>
<?php
      

   echo Html::dropDownList('comision', $selection=isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0, $listComisiones, ['prompt' => '(Seleccionar)', 'id' => 'cbmcomision', 'class' => 'form-control ',
        'onchange'=>'
                    $.get( "'.Url::toRoute('/optativas/default/setsession').'", { id: $(this).val() } )
                            .done(function( data ) {
                                $( "#'.Html::getInputId($model, 'comision').'" ).val( data );
                                window.location.replace("index.php?r=optativas");

                            }
                        );

        ',


        ]);

?>
</div>
<div style="margin-top: 5px;">
   <?php

         if (Yii::$app->session->has('success')){ 
             echo Alert::widget([
                    'options' => [
                        'class' => 'alert-danger',
                        
                    ],
                    'body' => Yii::$app->session->get('success'),
                ]);
                Yii::$app->session->remove('success');
    } ?> 
</div>


