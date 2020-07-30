<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Detallefonid */


$this->params['breadcrumbs'][] = ['label' => 'Detallefonids', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detallefonid-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
