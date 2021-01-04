<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Detalleticket */

$this->title = 'Nuevo Detalleticket';
$this->params['breadcrumbs'][] = ['label' => 'Detalletickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalleticket-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
