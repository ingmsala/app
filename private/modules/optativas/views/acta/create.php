<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Acta */

$this->title = 'Nueva Acta';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'escalas' => $escalas,
    ]) ?>

</div>
