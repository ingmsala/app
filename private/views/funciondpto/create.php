<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Funciondpto */

$this->title = 'Nuevo Funciondpto';
$this->params['breadcrumbs'][] = ['label' => 'Funciondptos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="funciondpto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
