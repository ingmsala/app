<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Clase */

$this->title = 'Nueva Clase';

?>
<div class="clase-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tiposclase' => $tiposclase,
        'mesx' => $mesx,
    ]) ?>

</div>
