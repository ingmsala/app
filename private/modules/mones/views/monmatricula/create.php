<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\mones\models\Monmatricula */

$this->title = 'Nuevo Monmatricula';
$this->params['breadcrumbs'][] = ['label' => 'Monmatriculas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monmatricula-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
