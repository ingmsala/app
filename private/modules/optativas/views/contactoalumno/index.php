<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\ContactoalumnoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contactoalumnos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contactoalumno-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Contactoalumno', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'apellido',
            'nombre',
            'mail',
            'telefono',
            //'parentezco',

            [
                'label' => "Alumno",
                'value' => function($model){
                    return $model->alumno0->apellido.', '.$model->alumno0->nombre;
                }

            ],
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
