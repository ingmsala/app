<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TurnoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="turno-index">

    <h3><?= Html::encode('Director') ?></h3>
   
    <?= GridView::widget([
        'dataProvider' => $director,
        
        'columns' => [
            
            'cargo',
            'nombre',
            'cantidad',

            
        ],
    ]); ?>

<h3><?= Html::encode('Regentes') ?></h3>

<?= GridView::widget([
        'dataProvider' => $regentes,
        
        'columns' => [
            
            'cargo',
            'nombre',
            'cantidad',

            
        ],
    ]); ?>

<h3><?= Html::encode('Vicedirección') ?></h3>

<?= GridView::widget([
        'dataProvider' => $vices,
        
        'columns' => [
            
            'cargo',
            'nombre',
            'cantidad',

            
        ],
    ]); ?>
 <h3><?= Html::encode('Secretarios') ?></h3>
<?= GridView::widget([
        'dataProvider' => $secretarios,
        
        'columns' => [
            
            'cargo',
            'nombre',
            'cantidad',

            
        ],
    ]); ?>

<h3><?= Html::encode('Jefes Preceptores') ?></h3>

<?= GridView::widget([
        'dataProvider' => $jefes,
        
        'columns' => [
            
            'cargo',
            'nombre',
            'cantidad',

            
        ],
    ]); ?>

<h3><?= Html::encode('Preceptores') ?></h3>
<?= GridView::widget([
        'dataProvider' => $preceptores,
        
        'columns' => [
            
            'cargo',
            'nombre',
            'cantidad',

            
        ],
    ]); ?>
</div>