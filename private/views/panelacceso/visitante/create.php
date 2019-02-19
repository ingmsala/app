<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Visitante */

$this->title = 'Create Visitante';
$this->params['breadcrumbs'][] = ['label' => 'Visitantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visitante-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
