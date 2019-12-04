<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Actividadesmantenimiento */

$this->title = 'Modificar Actividadesmantenimiento: ' . $model->id;

?>
<div class="actividadesmantenimiento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
