<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Trimestral */

$this->title = 'Create Trimestral';
$this->params['breadcrumbs'][] = ['label' => 'Trimestrals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trimestral-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
