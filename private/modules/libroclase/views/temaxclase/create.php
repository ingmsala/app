<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Temaxclase */

$this->title = 'Create Temaxclase';
$this->params['breadcrumbs'][] = ['label' => 'Temaxclases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="temaxclase-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
