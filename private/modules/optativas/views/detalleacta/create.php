<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Detalleacta */

$this->title = 'Create Detalleacta';
$this->params['breadcrumbs'][] = ['label' => 'Detalleactas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalleacta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
