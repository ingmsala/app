<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Progress;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\ClaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clases';



?>


<div class="clase-index" style="margin-top: 20px;">
    <h2>
    <?php 
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        echo Yii::$app->formatter->asDate(date('Y-m-d'), 'dd/MM/yyyy').' (HOY)';
     ?>
    </h2>
   <?= $echo ?>
   <div class="clearfix"></div>
   <h3>
    Agenda de los próximos 7 días
    </h3>
   <?= $echo2 ?>


</div>
