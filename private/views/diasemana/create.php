<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Diasemana */

$this->title = 'Create Diasemana';
$this->params['breadcrumbs'][] = ['label' => 'Diasemanas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="diasemana-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
