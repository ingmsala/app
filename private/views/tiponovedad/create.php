<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tiponovedad */

$this->title = 'Create Tiponovedad';
$this->params['breadcrumbs'][] = ['label' => 'Tiponovedads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tiponovedad-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
