<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Espaciocurricular */

$this->title = $model->actividad0->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Espaciocurriculars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="optativa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'aniolectivo0.nombre',
        ],
    ]) ?>

    <?= $this->render('/comision/index', [
        'modeloptativa' => $model,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
    ]) ?>

</div>
