<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Estadoacta */

$this->title = 'Nuevo Estado de acta';
$this->params['breadcrumbs'][] = ['label' => 'Estadoactas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadoacta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
