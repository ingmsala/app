<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Escalanota */

$this->title = 'Nueva Escala de nota';
$this->params['breadcrumbs'][] = ['label' => 'Escalanotas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="escalanota-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
