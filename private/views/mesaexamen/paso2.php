<?php

use app\modules\solicitudprevios\models\Detallesolicitudext;
use kartik\date\DatePicker;
use kartik\detail\DetailView;
use kartik\form\ActiveForm;
use kartik\grid\GridView;
use kartik\select2\Select2;
use kartik\time\TimePicker;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$this->title = $turno->nombre;

$this->params['sidebar'] = [
    'visible' => false,
    
];

/* @var $this yii\web\View */
/* @var $model app\models\Mesaexamen */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
        $breadcrumbs = [];
        $breadcrumbs [] = ['label' => $turno->nombre];
        //$breadcrumbs [] = $this->title;

    ?>


    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => '< Volver', 'url' => ['/mesaexamen/paso1', 'turno' => $turno->id]],
        'links' => $breadcrumbs,
    ]) ?>

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modalcasoupdate',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>

<div class="mesaexamen-form">

<h1><?= Html::encode($this->title) ?></h1>
<div style="font-size: 8pt;">
<?= GridView::widget([
		        'dataProvider' => $provider,
		        //'filterModel' => $searchModel,
		        'summary' => false,
		        'responsiveWrap' => false,

				'rowOptions' => function($model){
					if ($model['999'] =='MAÑANA'){
						return ['class' => 'primary'];
					}
					return ['class' => 'warning'];
				},

		        'columns' => $diasgrid['columns']
		        
	    	]); ?>
</div>
</div>
