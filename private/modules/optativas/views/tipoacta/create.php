<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Tipoacta */

$this->title = 'Nuevo Tipo';
$this->params['breadcrumbs'][] = ['label' => 'Tipoactas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipoacta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
