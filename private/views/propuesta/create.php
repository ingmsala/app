<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Propuesta */

$this->title = 'Nueva Propuesta Formativa';
$this->params['breadcrumbs'][] = ['label' => 'Propuestas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="propuesta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
