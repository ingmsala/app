<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Pasividaddj */

$this->title = 'Nuevo Pasividaddj';
$this->params['breadcrumbs'][] = ['label' => 'Pasividaddjs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pasividaddj-create">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
