<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\sociocomunitarios\models\CalificacionrubricaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Calificacionrubricas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calificacionrubrica-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php
    
?>
    <p>
        <?= Html::a('Agregar', Url::to('index.php?r=sociocomunitarios/calificacionrubrica/create&rubrica='.$rubrica), ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'detalleescalanota0.nota',
            'descripcion:ntext',
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
