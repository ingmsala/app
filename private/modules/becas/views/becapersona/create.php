<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\Becapersona */

$this->title = 'Create Becapersona';
$this->params['breadcrumbs'][] = ['label' => 'Becapersonas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="becapersona-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
