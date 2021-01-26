<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Detalleplancursado */


\yii\web\YiiAsset::register($this);
?>
<div class="detalleplancursado-view">
    <p>
        <?= Html::button('<span class="glyphicon glyphicon-list-alt"></span> '.'Ver notas', ['value' => Url::to(['/edh/notaedh/viewlegajo', 'det' =>$model->id]), 'title' => 'Notas de '.$model->catedra0->actividad0->nombre,  'class' => 'btn btn-success btn-success amodalplancursado']); ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'descripcion:ntext',
            'estadodetplan0.nombre',
        ],
    ]) ?>

</div>
