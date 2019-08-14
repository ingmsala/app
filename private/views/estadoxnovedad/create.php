<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Estadoxnovedad */

$this->title = 'Create Estadoxnovedad';
$this->params['breadcrumbs'][] = ['label' => 'Estadoxnovedads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadoxnovedad-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
