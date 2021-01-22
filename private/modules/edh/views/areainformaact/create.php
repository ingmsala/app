<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Areainformaact */

$this->title = 'Create Areainformaact';
$this->params['breadcrumbs'][] = ['label' => 'Areainformaacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="areainformaact-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
