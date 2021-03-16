<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Horaxclase */

$this->title = 'Create Horaxclase';
$this->params['breadcrumbs'][] = ['label' => 'Horaxclases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horaxclase-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
