<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rolexuser */

$this->title = 'Modificar Rolexuser: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Rolexusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="rolexuser-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'usuarios' => $usuarios,
        'roles' => $roles,
    ]) ?>

</div>
