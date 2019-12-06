<?php

use app\models\Nodocente;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ActividadesmantenimientoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Actividades de mantenimientos';

?>
<div class="actividadesmantenimiento-index">

    

    <p>
        <?= Html::a('Nueva Actividad', ['actividadesmantenimiento/create', 'tarea' => $tarea], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                }
            ],
            /*[
                'label' => 'Responsable',
                'value' => function($model){
                    $nodoc = Nodocente::find()->where(['legajo' => $model->usuario0->username]);
                    return $nodoc->apellido.', '.$nodoc->nombre;
                }
            ],*/
            [
                'label' => 'Usuario',
                'value' => function($model){
                        
                         $nodocentes= Nodocente::find()
                            ->where(['legajo' => $model->usuario0->username])
                            ->orderBy('apellido, nombre')
                            ->one();
                            if($nodocentes == null){
                                return $model->usuario0->username;
                            }
                            return $nodocentes->apellido.', '.$nodocentes->nombre;
                        
                    
                }
            ],
            
            'observaciones:ntext',

            /*['class' => 'yii\grid\ActionColumn'],*/
        ],
    ]); ?>
</div>
