<?php

use kartik\form\ActiveForm;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Html;

use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Docentes con horas superpuestas en Declaración Jurada';
$anios=ArrayHelper::map($anios,'id','nombre');

?>
<div class="horario-index">


    
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
		        //'filterModel' => $searchModel,
				'panel' => [
					'type' => GridView::TYPE_DEFAULT,
					'heading' => Html::encode($this->title),
					//'beforeOptions' => ['class'=>'kv-panel-before'],
				],
				'summary' => false,
		
				'exportConfig' => [
					GridView::EXCEL => [
						'label' => 'Excel',
						'filename' =>Html::encode($this->title),
						
						//'alertMsg' => false,
					],
					
		
				],
		        'summary' => false,
		        'responsiveWrap' => false,
		        'columns' => [
		            ['class' => 'yii\grid\SerialColumn'],
		            
		            
		            [
		                'label' => 'Agente',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
						'attribute' => 'agente',
						
		            ],

					[
		                'label' => 'División',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
						'format' => 'raw',
						'attribute' => 'division',
		                
		            ],

                    [
		                'label' => 'Actividad',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
						'attribute' => 'actividad',
						
		            ],
		            
		            [
		                'label' => 'Día',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
						'attribute' => 'dia',
						
		            ],
                    [
		                'label' => 'Hora de clase',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
						'attribute' => 'hora',
						
		            ],
                    [
		                'label' => 'Declaración Jurada',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
						'attribute' => 'superposicion',
						
		            ],
                ]
    ]);

    ?>
</div>