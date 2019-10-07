<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use app\config\Globales;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Horario */


$this->title = 'Distribución de horas'.$matexp;

$listActividades=ArrayHelper::map($actividades,'id','nombre');

?>
<div class="horario-view">

	<?php  
 $js=<<< JS
     $('[rel="tooltip"]').tooltip();
JS;

?>

<?php                 

        $form = ActiveForm::begin([
            'action' => ['filtropormateria'],
            'method' => 'get',
        ]);

    ?>

<?= $form->field($model, 'id')->widget(Select2::classname(), [
            'data' => $listActividades,
            'options' => [
                'prompt' => '...',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Materias');

 ?>

 <div class="form-group">
        <?= Html::submitButton('Filtrar', ['class' => 'btn btn-primary']) ?>
 </div>
<?php ActiveForm::end(); ?>
	<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modal',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>


<?php //echo var_dump($provider) ?>
    <div class="clearfix"></div>	
	<?= GridView::widget([
		        'dataProvider' => $provider,
		        //'filterModel' => $searchModel,
		        'responsiveWrap' => false,
		        'floatHeader' => true,
		        'floatHeaderOptions' => (Yii::$app->user->identity->role == Globales::US_HORARIO) ? ['top' => 130] : ['top' => 50],
		        'panel' => [
		            'type' => GridView::TYPE_DEFAULT,

		            'heading' => Html::encode($this->title)
		            
		            ],

		         'toolbar'=>[
		            
		            '{export}',
		            
		        ],
		        'exportConfig' => [
            
		            //GridView::HTML => [// html settings],
		            GridView::PDF => ['label' => 'PDF',
		                'filename' =>Html::encode($this->title),
		                'options' => ['title' => 'Portable Document Format'],
		                'config' => [
		                    'methods' => [ 
		                        'SetHeader'=>[Html::encode($this->title).' - Colegio Nacional de Monserrat'], 
		                        'SetFooter'=>[date('d/m/Y').' - Página '.'{PAGENO}'],
		                    ]
		                ],
		            ],
		        ],
		        'summary' => false,
		        'columns' => [
		            //['class' => 'yii\grid\SerialColumn'],
		            [
		                'label' => 'Turno',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'group' => true,
		                //'attribute' => '1',
		                'value' => function($model){
		                	return '<b>'.$model['998'].'</b>';
		                }
		            ],
		            [
		                'label' => 'División',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                //'attribute' => '1',
		                'value' => function($model){
		                	return '<b>'.$model['1'].'</b>';
		                }
		            ],
		            [
		                'label' => 'Docente',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                //'attribute' => '1',
		                'value' => function($model){
		                	return '<b>'.$model['999'].'</b>';
		                }
		            ],
		            [
		                'label' => 'Lunes',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '2',
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Martes',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '3'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Miércoles',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '4'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Jueves',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '5'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Viernes',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '6'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            
		            

		            
		        ],
	    	]); ?>

	  
    

</div>

<?php $this->registerJs($js, yii\web\View::POS_READY); ?>

