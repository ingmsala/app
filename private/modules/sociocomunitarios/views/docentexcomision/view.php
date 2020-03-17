<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Docentexcomision */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Docentexcomisions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docentexcomision-view">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'docente0.apellido',
            'docente0.nombre',
            [
                'label' => "Espaciocurricular",
                'attribute' => 'comision0.espaciocurricular0.actividad0.nombre',
            ],

            [
                'label' => "Comisión",
                'attribute' => 'comision0.nombre',
            ],
            
        ],
    ]) ?>

</div>
