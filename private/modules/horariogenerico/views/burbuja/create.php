<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\horariogenerico\models\Burbuja */

$this->title = 'Create Burbuja';
$this->params['breadcrumbs'][] = ['label' => 'Burbujas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="burbuja-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
