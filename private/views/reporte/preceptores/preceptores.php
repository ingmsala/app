<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RevistaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Preceptores';

?>

<div class="revista-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modal',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>
<div class="row">

<div class="alert alert-info" role="alert">
    Verificar que las divisiones coincidan con las aulas. Si hay un cambio de aula transitorio, se deberá modificar en la grilla para mantenerla actualizada.
</div>

<div class="col-md-6">
<?= GridView::widget([
		        'dataProvider' => $provider,
		        //'filterModel' => $searchModel,
		        'summary' => false,
		        'responsiveWrap' => false,
		        'condensed' => true,
		        'columns' => [
		            ['class' => 'yii\grid\SerialColumn'],
		            
		            [
		                'label' => 'División',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '1'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
                    ],

                    [
		                'label' => 'Preceptor/a',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '2'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
                    ],
                    [
		                'label' => 'Aula',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '3'
		                /*'value' => fu2nction($model){
		                	return var_dump($model);
		                }*/
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update}',
                        
                        'buttons' => [
                            
                            'update' => function($url, $model, $key){
                                //return var_dump($model);
                                return Html::button('<span class="glyphicon glyphicon-pencil"></span>',
                                    ['value' => Url::to('index.php?r=nombramiento/abmpreceptor&nom='.$model['999'].'&div='.$model['0']),
                                        'class' => 'btn btn-link', 'id'=>'abmdivision']);
        
        
                                Html::button(
                                    '<span class="glyphicon glyphicon-pencil"></span>',
                                    '?r=nombramiento/abmpreceptor&nom='.$model['999'].'&div='.$model['0']);
                            },
        
                            
                        ]
        
                    ], 
                ]
            ]);
                ?>
                </div></div>
</div>