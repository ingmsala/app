<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Prioridadticket */

$this->title = 'Nuevo Prioridadticket';
$this->params['breadcrumbs'][] = ['label' => 'Prioridadtickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prioridadticket-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
