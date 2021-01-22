<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\CertificacionedhSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Certificacionedhs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificacionedh-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Certificacionedh', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'contacto',
            'diagnostico',
            'fecha',
            'indicacion:ntext',
            //'institucion',
            //'referente',
            //'solicitud',
            //'tipocertificado',
            //'tipoprofesional',

            ['class' => 'yii\grid\ActionColumn', 

'template' => '{update} {view}'
            ],

        ],
    ]); ?>
</div>
