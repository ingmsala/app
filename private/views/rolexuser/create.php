<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Rolexuser */

$this->title = 'Nuevo Rolexuser';
$this->params['breadcrumbs'][] = ['label' => 'Rolexusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rolexuser-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'usuarios' => $usuarios,
        'roles' => $roles,
    ]) ?>

</div>
