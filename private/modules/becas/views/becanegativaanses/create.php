<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\Becanegativaanses */

$this->title = 'Create Becanegativaanses';
$this->params['breadcrumbs'][] = ['label' => 'Becanegativaanses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="becanegativaanses-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
