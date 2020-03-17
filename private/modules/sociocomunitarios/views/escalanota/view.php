<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Escalanota */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Escala de notas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="escalanota-view">

    <?= $this->render('/detalleescalanota/index', [
        'model' => $model,
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
