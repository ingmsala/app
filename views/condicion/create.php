<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Condicion */

$this->title = 'Nueva Condicion';
$this->params['breadcrumbs'][] = ['label' => 'Condiciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="condicion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
