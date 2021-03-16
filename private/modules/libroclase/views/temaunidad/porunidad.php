<?php

use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\libroclase\models\TemaunidadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$unidades = ArrayHelper::map($unidades, 'id', function($model){
    return $model->unidad0->nombre.' ('.$model->nombre.')';
});
?>
<div class="porunidad-temaunidad">
<?php $form = ActiveForm::begin(['id' => 'temaporunidad']); ?>
    <?= 

    $form->field($model, 'unidades')->widget(Select2::classname(), [
        'data' => $unidades,
        'options' => ['placeholder' => 'Seleccionar...', 'id' => 'temaunidadx', 
        
            'onchange'=>'
                var array = [];
    
                    var checkboxes = document.querySelectorAll("input[type=hidden].valtemaxx");
                    var nombre;
                    for (var i = 0; i < checkboxes.length; i++) {
                        array.push(checkboxes[i].value);
                    }
                    
                $.get("index.php?r=libroclase/temaunidad/detunidad&detuni="+$(this).val()+"&nose="+JSON.stringify(array)+"&cat='.$cat.'", function( data ) {
                    $( "div#temaunidad" ).html( data );
                    
                });
            '
        ],
        'pluginOptions' => [
            'allowClear' => true,
            
        ],
    ]);

    ?>

<div id="temaunidad">

</div>

<?php ActiveForm::end(); ?>

    
</div>
