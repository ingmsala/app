<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Alert;
use kartik\depdrop\DepDrop;



/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Docentexcomision */
/* @var $form yii\widgets\ActiveForm */


?>


<?php
        
        $listComisiones=ArrayHelper::map($comisiones,'comision', function($comision) {
          //var_dump($comision['comision0']['espaciocurricular0']['actividad0']);
            return $comision['comision0']['espaciocurricular0']['aniolectivo0']['nombre'].' - '.$comision['comision0']['espaciocurricular0']['actividad0']['nombre'].' ('.$comision['comision0']['nombre'].')';}
        );
        $listaniolectivos=ArrayHelper::map($aniolectivos,'id','nombre');
    ?>


<div id="menucomxdoc">
<?php                 

                                 $form = ActiveForm::begin([
                                    'action' => ['index'],
                                    'method' => 'get',
                                ]); ?>
 <?= 

      $form->field($model2, 'aniolectivo')->dropDownList(
          $listaniolectivos,
          ['placeholder' => 'Seleccionar...', 
          'id' => 'anio-id',
          
      ])->label("Año Lectivo");

  ?>

  <?= 

      $form->field($model2, 'comision')->widget(DepDrop::classname(), [
          //'data' => $listComisiones,
          'options'=>['id'=>'comision-id'],
          //'value' => 1,
          'pluginOptions'=>[
              'depends'=>['anio-id'],
              'loading' => false,
              'inicializate' => isset($_SESSION['comisiontsx']) ? $_SESSION['comisiontsx'] : 0,
              'placeholder'=>'Seleccionar...',
              'url'=>Url::to(['/sociocomunitarios/comision/comxanio'])
          ],
          
      ])->label("Proyecto Sociocomunitario");

  ?>

  <?php ActiveForm::end(); ?>
   
<?php
      

   /*echo <div><b>Espacios Optativos</b></div> Html::dropDownList('comision', $selection=isset($_SESSION['comisiontsx']) ? $_SESSION['comisiontsx'] : 0, $listComisiones, ['prompt' => '(Seleccionar)', 'id' => 'cbmcomision', 'class' => 'form-control ',
        'onchange'=>'
                    $.get( "'.Url::toRoute('/optativas/default/setsession').'", { id: $(this).val() } )
                            .done(function( data ) {
                                $( "#'.Html::getInputId($model, 'comision').'" ).val( data );
                                window.location.replace("index.php?r=optativas");

                            }
                        );

        ',


        ]);*/

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
    <?php

         if (Yii::$app->session->has('info')){ 
             echo Alert::widget([
                    'options' => [
                        'class' => 'alert-success',
                        'id' => 'alertinfo',
                        
                    ],
                    'body' => Yii::$app->session->get('info'),
                ]);
                Yii::$app->session->remove('info');
    } ?>  
</div>

<?php 

    $js=<<< JS
     $("#alertinfo").animate({opacity: 1.0}, 3000).fadeOut("slow");
     $('#anio-id').val(aniolectivovar).trigger('change').trigger('depdrop:change');
JS;


$js2=<<< JS
     $ ( ' #comision-id ' ). on ( ' depdrop: change ' , function ( event , id , value, count ) {
      console.log(id); console.log(this.value); console.log(count);

      $.get( "index.php?r=sociocomunitarios/default/setsession", { id: $(this).val() } )
                            .done(function( data ) {
                                
                                window.location.replace("index.php?r=sociocomunitarios");
                                //$('#anio-id').val(1).trigger('change').trigger('depdrop:change');
                                //$('#anio-id').val(1).trigger('change').trigger('depdrop:change');
                              });

                            

});
JS;
$this->registerJsVar('aniolectivovar', isset($_SESSION['aniolectivox']) ? $_SESSION['aniolectivox'] : 2, yii\web\View::POS_READY);

$this->registerJs($js, yii\web\View::POS_READY);
$this->registerJs($js2, yii\web\View::POS_READY);

?>


