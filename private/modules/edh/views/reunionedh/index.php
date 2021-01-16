<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\ReunionedhSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reuniones';
$this->params['breadcrumbs'][] = $this->title;

$this->params['sidebar'] = [
    'visible' => true,
    'model' => $model,
    'origen' => 'reuniones',
];

?>

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'>".'Agregar reunión al  Caso #'.$model->id."</h2>",
            'id' => 'modaldetalleticket',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>
<div class="reunionedh-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('<span class="glyphicon glyphicon-plus"></span> '.'Agregar reunión', ['value' => Url::to('index.php?r=edh/reunionedh/create&caso='.$model->id), 'class' => 'btn btn-main btn-success amodaldetalleticket contenedorlistado']); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            [
                'label' => 'Fecha',
                
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Hora',
                
                'value' => function($model){
                    $hora = explode(':', $model->hora);
                    return $hora[0].':'.$hora[1].'hs.';
                }
            ],
            
            'tematica',
            //'parte:ntext',
            'lugar',
            
            //'url:url',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
