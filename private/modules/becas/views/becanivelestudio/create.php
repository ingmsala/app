<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\Becanivelestudio */

$this->title = 'Create Becanivelestudio';
$this->params['breadcrumbs'][] = ['label' => 'Becanivelestudios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="becanivelestudio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
