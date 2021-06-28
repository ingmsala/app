<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Estadoauthpago */

$this->title = 'Create Estadoauthpago';
$this->params['breadcrumbs'][] = ['label' => 'Estadoauthpagos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadoauthpago-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
