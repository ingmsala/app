<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Estadotarea */

$this->title = 'Nuevo Estadotarea';
$this->params['breadcrumbs'][] = ['label' => 'Estadotareas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadotarea-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
