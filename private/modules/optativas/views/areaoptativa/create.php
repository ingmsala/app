<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Areaoptativa */

$this->title = 'Create Areaoptativa';
$this->params['breadcrumbs'][] = ['label' => 'Areaoptativas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="areaoptativa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
