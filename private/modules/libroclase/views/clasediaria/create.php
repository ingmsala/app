<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Clasediaria */

$this->title = 'Nuevo Clasediaria';
$this->params['breadcrumbs'][] = ['label' => 'Clasediarias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clasediaria-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
