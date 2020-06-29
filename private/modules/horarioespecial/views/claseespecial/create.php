<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\horarioespecial\models\Claseespecial */

$this->title = 'Nuevo Claseespecial';
$this->params['breadcrumbs'][] = ['label' => 'Claseespecials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="claseespecial-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
