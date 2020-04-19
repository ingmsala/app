<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cronograma de Clases Virtuales';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="horario-index">

    <h1><?= Html::encode($this->title) ?></h1>


<?= edofre\fullcalendar\Fullcalendar::widget([
        'events'        => $events
    ]);
?>

</div>
