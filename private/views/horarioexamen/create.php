<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Horarioexamen */

$this->title = 'Create Horarioexamen';
$this->params['breadcrumbs'][] = ['label' => 'Horarioexamens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horarioexamen-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
