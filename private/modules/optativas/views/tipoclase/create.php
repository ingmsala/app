<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Tipoclase */

$this->title = 'Nuevo Tipo de Clase';
$this->params['breadcrumbs'][] = ['label' => 'Tipo de Clases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipoclase-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
