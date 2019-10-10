<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Horariotrimestral */

$this->title = 'Create Horariotrimestral';
$this->params['breadcrumbs'][] = ['label' => 'Horariotrimestrals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horariotrimestral-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
