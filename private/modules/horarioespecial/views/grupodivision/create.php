<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\horarioespecial\models\Grupodivision */

$this->title = 'Nuevo Grupodivision';
$this->params['breadcrumbs'][] = ['label' => 'Grupodivisions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupodivision-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
