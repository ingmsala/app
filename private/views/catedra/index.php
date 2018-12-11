<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CatedraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Catedras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catedra-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva Catedra', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            

            
            [   
                'label' => 'Actividad',
                'attribute' => 'actividad',
                'value' => 'actividad0.nombre'
            ],

            [   
                'label' => 'Horas',
                'attribute' => 'actividad.canthoras',
                'value' => 'actividad0.cantHoras'
            ],

            [   
                'label' => 'Division',
                'attribute' => 'division',
                'value' => 'division0.nombre'
            ],
            [
                'attribute' => 'docentes',
                'format' => 'raw',
                'value' => function($model){
                    $items = [];
                    $itemsc = [];
                    //var_dump($model);
       
                    foreach($model->detallecatedras as $detallecatedra){

                        
                        $itemsc[] = [$detallecatedra->condicion0->id, $detallecatedra->condicion0->nombre, $detallecatedra->docente0->apellido.', '.$detallecatedra->docente0->nombre, $detallecatedra->revista0->nombre, $detallecatedra->hora, $detallecatedra->activo];
                        
                    }

                    sort($itemsc);                   
                    //var_dump($itemsc);
                    //return implode(' // ', $itemsc);
                    return Html::ul($itemsc, ['item' => function($item) {
                        //var_dump($item);
                        if($item[5]==1){
                            if($item[0]!=5){//suplente
                                return 
                                    Html::tag('li', 
                                        Html::tag('div',
                                            Html::tag('span', $item[1].' ('.$item[4].'hs.)', ['class' => "badge pull-left"]).
                                            Html::tag('span', $item[3], ['class' => "badge pull-right"])."&nbsp;".$item[2], ['data-toggle' => "pill"]), ['class' => 'list-group-item list-group-item-info']);
                                
                            }

                            return 
                                    Html::tag('li', 
                                        Html::tag('div',
                                            Html::tag('span', $item[1].' ('.$item[4].'hs.)', ['class' => "badge pull-left"]).
                                            Html::tag('span', $item[3], ['class' => "badge pull-right"])."&nbsp;".$item[2], ['data-toggle' => "pill"]), ['class' => 'list-group-item list-group-item-warning']);
                        }
                    }, 'class' => "nav nav-pills nav-stacked"]);
                }],



            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>


