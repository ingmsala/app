<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Adjuntoticket */

$this->title = 'Nuevo Adjuntoticket';
$this->params['breadcrumbs'][] = ['label' => 'Adjuntotickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adjuntoticket-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
