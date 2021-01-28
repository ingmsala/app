<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Tipoprofesional */

$this->title = 'Nuevo Tipo de profesional';
$this->params['breadcrumbs'][] = ['label' => 'Tipoprofesionals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipoprofesional-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
