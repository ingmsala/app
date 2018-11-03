<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Revista */

$this->title = 'Create Revista';
$this->params['breadcrumbs'][] = ['label' => 'Revistas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="revista-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
