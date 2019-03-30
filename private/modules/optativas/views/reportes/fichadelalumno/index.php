<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Clase */


$this->params['breadcrumbs'][] = ['label' => 'Ficha del Alumno', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clase-view">

    <h2><?= Html::encode($this->title) ?></h2>

   <?= $this->render('_alumnosxcomision', [
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
        
        
    ]) ?>

</div>