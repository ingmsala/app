<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Asignacionticket */

$this->title = 'Nuevo Asignacionticket';
$this->params['breadcrumbs'][] = ['label' => 'Asignaciontickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asignacionticket-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
