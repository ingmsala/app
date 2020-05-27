<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Condicionnodocente */

$this->title = 'Nuevo Condicionnodocente';
$this->params['breadcrumbs'][] = ['label' => 'Condicionnodocentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="condicionnodocente-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
