<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Actividadesmantenimiento */

$this->title = 'Nueva Actividad';

?>
<div class="actividadesmantenimiento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'estado' => $estado,
        'modeltarea' => $modeltarea, 
    ]) ?>

</div>
