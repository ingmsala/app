<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Lugaractuacion */

$this->title = 'Nuevo Lugar de actuación';
$this->params['breadcrumbs'][] = ['label' => 'Lugaractuacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lugaractuacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
