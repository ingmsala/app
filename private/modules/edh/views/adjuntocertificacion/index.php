<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\AdjuntocertificacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adjuntocertificacions';
$this->params['breadcrumbs'][] = $this->title;

$js = <<< JS
    function sendRequest2(e, id){
        
        e.preventDefault();
        $.ajax({
            url:'index.php?r=edh/adjuntocertificacion/delete',
            method:'post',
            data:{id:id},
            success:function(data){
                //alert(data);
            },
            error:function(jqXhr,asistio,error){
                alert(error);
            }
        });
    }
JS;

$this->registerJs($js, \yii\web\View::POS_READY);

?>
<div class="adjuntocertificacion-index">

    <?php Pjax::begin(['id' => 'test']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [

                    'delete' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '#',
                         
                            [
                            'onClick' => "(function (e){
        
                                //e.preventDefault();
                                $.ajax({
                                    url:'index.php?r=edh/adjuntocertificacion/delete',
                                    method:'post',
                                    data:{id:$model->id},
                                    success:function(data){
                                        //alert(data);
                                    },
                                    error:function(jqXhr,asistio,error){
                                        alert(error);
                                    }
                                });
                            })",
                            /*'data' => [
                            'confirm' => 'Está seguro de querer eliminar este elemento?',
                            'method' => 'post',
                             ]*/
                            ]);
                    },

                ]
            
            ],

        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
