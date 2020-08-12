<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Tipodesarrollo */

$this->title = 'Nuevo Tipodesarrollo';
$this->params['breadcrumbs'][] = ['label' => 'Tipodesarrollos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipodesarrollo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
