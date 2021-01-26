<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Catedradeplan */

$this->title = 'Create Catedradeplan';
$this->params['breadcrumbs'][] = ['label' => 'Catedradeplans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catedradeplan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
