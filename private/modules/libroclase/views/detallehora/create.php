<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Detallehora */

$this->title = 'Nuevo Detallehora';
$this->params['breadcrumbs'][] = ['label' => 'Detallehoras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detallehora-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
