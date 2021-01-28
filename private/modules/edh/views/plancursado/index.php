<?php

use app\modules\edh\models\SeguimientoplanSearch;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\PlancursadoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Planes de cursado';
$this->params['sidebar'] = [
    'visible' => true,
    'model' => $model,
    'origen' => 'plan',
];
?>

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modalplancursado',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>

<div class="plancursado-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'rowOptions' => function($model){
            if ($model->tipoplan == 1){
                return ['class' => 'info', 'id' => $model->id];
            }
            //return ['class' => 'warning', 'id' => $model['id']];
        },
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            'footer' => false,
            'after' => false,
            'before' =>Html::button('<span class="glyphicon glyphicon-plus"></span> '.'Agregar plan', ['value' => Url::to(['create', 'caso' =>$model->id]), 'title' => 'Nuevo plan personalizado',  'class' => 'btn btn-success btn-success amodalplancursado'])
        ],
        'toolbar'=>[
            
            
            
        ],
        'summary' => false,
        'condensed' => true,
        'responsiveWrap' => false,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
                'header' => '',
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'enableRowClick' => true,
                'allowBatchToggle' => false,
                'detailRowCssClass' => GridView::TYPE_WARNING,
                'enableCache' => false,
                'rowClickExcludedTags' => ['a', 'button', 'input', 'span'],
                
                // show row expanded for even numbered keys
                'detail' => function ($model){
                    $searchModel = new SeguimientoplanSearch();
                    $dataProvider = $searchModel->porPlan($model->id);
                    
                    return $this->render('/seguimientoplan/index', [
                        'plan' => $model->id,
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                    
                    ]);},
                
                'value' => function ($model, $key, $index, $column) {
                    //return $sol;
                    return GridView::ROW_COLLAPSED;
                    /*if($key == $sol)
                        return GridView::ROW_EXPANDED;
                    return GridView::ROW_COLLAPSED;*/
                },
                'headerOptions' => ['class' => 'kartik-sheet-style'], 
                'expandOneOnly' => true
            ],

            [
                'label' => 'Fecha',
                'vAlign' => 'middle', 
                'hAlign' => 'center', 
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Materias',
                'vAlign' => 'middle', 
                //'hAlign' => 'center', 
                'format' => 'raw', 
                'value' => function($model){
                    if($model->tipoplan == 1)
                        return 'Todas';
                    $ret = '';
                    try {
                        $ret .= '<ul>';
                        foreach ($model->catedradeplans as $catedrasxplan) {
                            $ret .= '<li>'.$catedrasxplan->catedra0->actividad0->nombre.'</li>';
                        }
                        $ret .= '</ul>';
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                    return $ret;
                    
                }
            ],
            [
                'label' => 'Descripción',
                'vAlign' => 'middle', 
                'hAlign' => 'center', 
                'value' => function($model){
                    return $model->descripcion;
                }
            ],
            [
                'label' => 'Tipo',
                'vAlign' => 'middle', 
                'hAlign' => 'center', 
                'value' => function($model){
                    return $model->tipoplan0->nombre;
                }
            ],

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
</div>
