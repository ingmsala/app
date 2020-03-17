<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Clase */

?>
<div class="clase-view" style="margin-top: 20px;">

   
   <?= $this->render('_alumnosxcomision', [
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
        'comision' => $comision,
        
    ]) ?>

</div>