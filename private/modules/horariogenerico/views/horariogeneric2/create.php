<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\horariogenerico\models\Horariogeneric */

$this->title = 'Create Horariogeneric';
$this->params['breadcrumbs'][] = ['label' => 'Horariogenerics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horariogeneric-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
