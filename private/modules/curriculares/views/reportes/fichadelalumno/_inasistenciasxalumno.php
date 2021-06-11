<?php

use app\modules\curriculares\models\Inasistencia;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\InasistenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="inasistencia-index">

<?= 
    GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            
            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],

            [
                'label' => 'Horario',
                'format' => 'raw',
                'value' => function($model){
                    if($model->hora != null){
                        $ini = Yii::$app->formatter->asDate($model['hora'], 'HH:mm');
                        if($model->horafin != null){
                            $fin = Yii::$app->formatter->asDate($model['horafin'], 'HH:mm');
                            return $ini.' a '.$fin;
                        }
                            
                        else
                        return $ini;
                    }
                    else
                        return '<span style="color: red;"><i>(A definir)</i><span>';
                }
            ],
            
            'tema',
            
            [
                'label' => 'Tipo de Clase',
                'attribute' => 'tipoclase0.nombre',
            ],
            [
                'label' => 'Tipo de Asistencia',
                'attribute' => 'tipoasistencia0.nombre',
            ],
            [
                'label' => 'Asistió?',
                'value' => function($model) use($matricula){
                    $inasist = Inasistencia::find()
                        ->where(['clase' => $model->id])
                        ->andWhere(['matricula' => $matricula])
                        ->one();
                    if($inasist==null)
                        return 'Sí';
                    return 'No';
                }
            ],
            
        ],
            

        
    ]); ?>
</div>