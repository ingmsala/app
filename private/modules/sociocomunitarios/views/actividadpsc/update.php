<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\sociocomunitarios\models\Actividadpsc */

$this->title = 'Modificar actividad';

?>
<div class="actividadpsc-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
