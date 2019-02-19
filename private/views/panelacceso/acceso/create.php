<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Acceso */

$this->title = 'Nueva visita';
$this->params['breadcrumbs'][] = ['label' => 'Accesos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acceso-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'id' => $id,
        'dni' => $dni,
        'apellidos' => $apellidos,
        'nombres' => $nombres,
        'areas' => $areas,
        'modelTarjeta' => $modelTarjeta,
    ]) ?>

</div>
