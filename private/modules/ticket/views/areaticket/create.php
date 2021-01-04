<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Areaticket */

$this->title = 'Nuevo Areaticket';
$this->params['breadcrumbs'][] = ['label' => 'Areatickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="areaticket-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
