<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\Becaayudapersona */

$this->title = 'Create Becaayudapersona';
$this->params['breadcrumbs'][] = ['label' => 'Becaayudapersonas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="becaayudapersona-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
