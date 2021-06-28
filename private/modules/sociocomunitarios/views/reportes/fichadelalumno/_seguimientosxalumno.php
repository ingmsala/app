<?php

use app\modules\sociocomunitarios\models\Detallerubrica;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\InasistenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="inasistencia-index">

    <?= 
    GridView::widget([
        'dataProvider' => $dataProviderSeguimientos,
        'summary' => false,
        'columns' => [
            [
                'label' => 'Tipo',
                'attribute' => 'tiposeguimiento0.nombre',
                
            ],
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
                'label' => 'Estado',
                'attribute' => 'estadoseguimiento0.nombre',
                
            ],
            [
                'label' => 'Descripción',
                //'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    $detru = $model->descripcion;
                    try {
                        $detallerubrica = Detallerubrica::find()->where(['seguimiento' => $model->id])->all();
                        $detru .= '<br/><ul>';

                        foreach ($detallerubrica as $dr) {
                            $detru.= '<li>'.$dr->calificacionrubrica0->rubrica0->descripcion.': '.$dr->calificacionrubrica0->detalleescalanota0->nota.'</li>';
                        }
                        $detru .= '</ul>';
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                    
                    return $detru;
                },
            ],
            
        ],
            

        
    ]); ?>
</div>