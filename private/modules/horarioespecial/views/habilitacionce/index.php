<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\horarioespecial\models\HabilitacionceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Calendario de Clases Especiales';

?>
<div class="habilitacionce-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva habilitación', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    

    <?= edofre\fullcalendar\Fullcalendar::widget([
        'events'        => $events,
        'header' => [
            'center' => 'title',
            'left'   => 'prev,next, today',
            'right'  => '',
        ],
        
        'clientOptions' => [
            //'defaultView' => 'agendaDay',
        ],
    ]);
?>
</div>
