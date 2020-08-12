<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Condicionfinal */

$this->title = 'Nueva Condición final';
$this->params['breadcrumbs'][] = ['label' => 'Condición final', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="condicionfinal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
