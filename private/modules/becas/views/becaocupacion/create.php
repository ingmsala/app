<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\Becaocupacion */

$this->title = 'Create Becaocupacion';
$this->params['breadcrumbs'][] = ['label' => 'Becaocupacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="becaocupacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
