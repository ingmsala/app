<?php

use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Docentes con horas superpuestas';
$anios=ArrayHelper::map($anios,'id','nombre');

?>
<div class="horario-index">


    <h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin(); ?>
<?= 

$form->field($model, 'aniolectivo')->widget(Select2::classname(), [
    'data' => $anios,
    'options' => ['placeholder' => 'Seleccionar...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);

?>

    <div class="form-group">
        <?= Html::submitButton('<div class="glyphicon glyphicon-search"></div> Buscar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>




    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'apellido',
            'nombre',
           
            [
                'label' => 'Ver',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a('<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>', $url = '?r=horario/completoxdocente&agente='.$model['id']);
                }
            ],
        ],
    ]); ?>
</div>