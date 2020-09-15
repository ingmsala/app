<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Divisionxmesa */

$this->title = 'Nuevo Divisionxmesa';
$this->params['breadcrumbs'][] = ['label' => 'Divisionxmesas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="divisionxmesa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
