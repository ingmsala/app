<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\desarrollo\Desarrollo */

$this->title = 'Nuevo Desarrollo';
$this->params['breadcrumbs'][] = ['label' => 'Desarrollos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="desarrollo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
