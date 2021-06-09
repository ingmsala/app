<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Estadotemaclase */

$this->title = 'Create Estadotemaclase';
$this->params['breadcrumbs'][] = ['label' => 'Estadotemaclases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadotemaclase-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
