<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\horarioespecial\models\Horarioclaseespecial */

$this->title = 'Nuevo Horarioclaseespecial';
$this->params['breadcrumbs'][] = ['label' => 'Horarioclaseespecials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horarioclaseespecial-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
