<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\Becaocupacionpersona */

$this->title = 'Create Becaocupacionpersona';
$this->params['breadcrumbs'][] = ['label' => 'Becaocupacionpersonas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="becaocupacionpersona-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
