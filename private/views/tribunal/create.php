<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tribunal */

$this->title = 'Nuevo Tribunal';
$this->params['breadcrumbs'][] = ['label' => 'Tribunals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tribunal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
