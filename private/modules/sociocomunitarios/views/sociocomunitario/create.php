<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Espaciocurricular */

$this->title = 'Nuevo Proyecto Sociocomunitario';
$this->params['breadcrumbs'][] = ['label' => 'Espaciocurriculars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="optativa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'actividades' => $actividades,
        'aniolectivo' => $aniolectivo,
        'areasoptativas' => $areasoptativas,
    ]) ?>

</div>
