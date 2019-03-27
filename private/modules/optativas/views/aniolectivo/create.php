<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Aniolectivo */

$this->title = 'Nuevo Año Lectivo';
$this->params['breadcrumbs'][] = ['label' => 'Años Lectivos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aniolectivo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
