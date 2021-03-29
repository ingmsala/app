<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PreinscripcionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Habilitar inscripciones';

?>
<div class="preinscripcion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva habilitación', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Tipo de espacio',
                'value' => function($model){
                    return $model->tipoespacio0->nombre;
                    

                }
            ],
            'descripcion',
            [
                'label' => 'Estado',
                'value' => function($model){
                    $tipodepublicacion=[
                        0=> 'Inactivo',
                        1=> 'Habilitado para inscripción',
                        2=> 'Sólo Publicación',
                        3=> 'Regido por fecha',
                    ];
                    return $tipodepublicacion[$model->activo];

                }
            ],
            [
                'label' => 'Habilitado para',
                'format' => 'raw',
                'value' => function($model){
                    $salida = '<ul>';
                    foreach ($model->anios as $anios) {
                        $salida .= '<li>'.$anios->anio.'° año</li>';
                    }
                    $salida .= '</ul>';
                    return $salida;
                }
            ],
            [
                'label' => 'Inicio',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    //Yii::$app->formatter->locale = 'es-AR';
                    $hora = explode(' ', $model->inicio);
                    $horax = explode(':',$hora[1]);
                    $horaok = $horax[0].':'.$horax[1];
                    return Yii::$app->formatter->asDatetime($model->inicio, 'dd/MM/Y').' '.$horaok;
                }
            ],
            [
                'label' => 'Fin',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    $hora = explode(' ', $model->fin);
                    $horax = explode(':',$hora[1]);
                    $horaok = $horax[0].':'.$horax[1];
                    return Yii::$app->formatter->asDatetime($model->fin, 'dd/MM/Y').' '.$horaok;
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn', 
                'template' => '{update}',
            ],
        ],
    ]); ?>
</div>
