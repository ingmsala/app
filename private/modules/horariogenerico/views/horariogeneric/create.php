<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Clasevirtual */

$this->title = 'Nuevo Clasevirtual';
$this->params['breadcrumbs'][] = ['label' => 'Clasevirtuals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clasevirtual-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
