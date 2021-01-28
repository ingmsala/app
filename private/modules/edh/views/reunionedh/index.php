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


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            'footer' => false,
            'after' => false,
            'before' => 
            Html::button('<span class="glyphicon glyphicon-plus"></span> '.'Agregar reunión', ['value' => Url::to('index.php?r=edh/reunionedh/create&caso='.$model->id), 'class' => 'btn btn-main btn-success amodaldetalleticket contenedorlistado'])
            ,
        ],
        'toolbar'=>[
        
        ],
        'summary' => false,
        'responsiveWrap' => false,
        'hover' => true,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            
            [
                'label' => 'Fecha',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Html::a(Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy'), Url::to(['view', 'id' => $model->id]));
                }
            ],
            [
                'label' => 'Hora',
                'format' => 'raw',
                'value' => function($model){
                    $hora = explode(':', $model->hora);
                    return Html::a($hora[0].':'.$hora[1].'hs.', Url::to(['view', 'id' => $model->id]));
                }
            ],
            [
                'label' => 'Temática',
                'format' => 'raw',
                'value' => function($model){
                    $hora = explode(':', $model->hora);
                    return Html::a($model->tematica, Url::to(['view', 'id' => $model->id]));
                }
            ],
            [
                'label' => 'Lugar',
                'format' => 'raw',
                'value' => function($model){
                    $hora = explode(':', $model->hora);
                    return Html::a($model->lugar, Url::to(['view', 'id' => $model->id]));
                }
            ],
           

            /*['class' => 'kartik\grid\ActionColumn', 
                'template' => '{view}'
            ],*/
        ],
    ]); ?>
</div>
