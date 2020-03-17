<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Estadolibro */

$this->title = 'Nuevo Estado de libro';
$this->params['breadcrumbs'][] = ['label' => 'Estadolibros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadolibro-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
