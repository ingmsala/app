<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tipomovilidad */

$this->title = 'Nuevo Tipomovilidad';
$this->params['breadcrumbs'][] = ['label' => 'Tipomovilidads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipomovilidad-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
