<?php

use app\modules\libroclase\models\Temaxclase;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\libroclase\models\TemaunidadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div id="detuni-temauni">
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'rowOptions' => function($model){
            if ($model['desarrollo'] =='Completo'){
                return ['class' => 'success', 'id' => $model['id']];
            }
            //return ['class' => 'warning', 'id' => $model['id']];
        },
        'columns' => [
            [
                'label' => '',
                'format' => 'raw',
                'headerOptions' => ['style' => 'width:5%'],
                'value' => function($model) use($nose){
                    
                    if(in_array($model['id'], $nose)){
                        $bot = 1;
                        $classcss = 'danger';
                        $gly = 'trash';
                    }else{
                        $bot = 0;
                        $classcss = 'success';
                        $gly = 'plus';
                    }

                    return '<div id="buttontema'.$model['id'].'">'.
                                Html::button('<span class="glyphicon glyphicon-'.$gly.'" aria-hidden="true"></span>', 
                                ['class' => 'btn btn-'.$classcss, 
                        
                                        'onclick' => '
                                            $.get("index.php?r=libroclase/temaunidad/devolvertema&bot='.$bot.'&id='.$model['id'].'", function( data ) {
                                                jsonString = JSON.parse(data);
                                                bot = jsonString[2];
                                                id = jsonString[3];
                                                if(bot==1){
                                                    $( "div#temasseleccionados" ).append( jsonString[1] );
                                                    $( "div#forminputs" ).append( jsonString[4] );
                                                }else{
                                                    $( "div#tema"+id ).remove();
                                                    $( "input#valtema"+id ).remove();
                                                }
                                                $( "div#buttontema'.$model['id'].'" ).html( jsonString[0] );
                                                
                                            });
                                        '
                
                                ]).
                            '</div>';

                            
                }
        ],
        [
            'label' => 'Descripción',
            'format' => 'raw',
            'value' => function($model)use($cat){
                /*$cantparcial = Temaxclase::find()
                    ->joinWith(['clasediaria0', 'clasediaria0.horaxclases'])
                    ->where(['clasediaria.catedra' => $cat])
                    ->andWhere(['temaxclase.temaunidad' => $model['id']])
                    ->andWhere(['clasediaria.aniolectivo' => 3])
                    ->andWhere(['temaxclase.tipodesarrollo' => 1])
                    ->count();

                $canttotal = Temaxclase::find()
                    ->joinWith(['clasediaria0', 'clasediaria0.horaxclases'])
                    ->where(['clasediaria.catedra' => $cat])
                    ->andWhere(['temaxclase.temaunidad' => $model['id']])
                    ->andWhere(['clasediaria.aniolectivo' => 3])
                    ->andWhere(['temaxclase.tipodesarrollo' => 2])
                    ->count();
                $suma = $cantparcial + $canttotal;
                if ($suma > 0){
                    if($canttotal > 0){
                        $parcial = '. Desarrollo: Completo';
                    }else{
                        $parcial = '. Desarrollo: Parcial';
                    }
                }else
                    $parcial = '';*/
                
                    
                return $model['descripcion']/*.' - <span class="text-muted" style="font-style: italic;">Horas dictadas del tema: '.$suma.$parcial.'</span>'*/;
            }
        ],
        [
            'label' => 'Desarrollo',
            'format' => 'raw',
            'value' => function($model){
                /*$cantparcial = Temaxclase::find()
                    ->joinWith(['clasediaria0', 'clasediaria0.horaxclases'])
                    ->where(['clasediaria.catedra' => $cat])
                    ->andWhere(['temaxclase.temaunidad' => $model['id']])
                    ->andWhere(['clasediaria.aniolectivo' => 3])
                    ->andWhere(['temaxclase.tipodesarrollo' => 1])
                    ->count();

                $canttotal = Temaxclase::find()
                    ->joinWith(['clasediaria0', 'clasediaria0.horaxclases'])
                    ->where(['clasediaria.catedra' => $cat])
                    ->andWhere(['temaxclase.temaunidad' => $model['id']])
                    ->andWhere(['clasediaria.aniolectivo' => 3])
                    ->andWhere(['temaxclase.tipodesarrollo' => 2])
                    ->count();
                $suma = $cantparcial + $canttotal;
                if ($suma > 0){
                    if($canttotal > 0){
                        $parcial = '. Desarrollo: Completo';
                    }else{
                        $parcial = '. Desarrollo: Parcial';
                    }
                }else
                    $parcial = '';*/
                
                    if($model['total']==1){
                        $total = '<br/>('.$model['total'].' hora)';
                    }elseif($model['total']>1){
                        $total = '<br/>('.$model['total'].' horas)';
                    }else
                        $total = '';
                return $model['desarrollo'].$total/*.' - <span class="text-muted" style="font-style: italic;">Horas dictadas del tema: '.$suma.$parcial.'</span>'*/;
            }
        ],

        ],
    ]); ?>

<button type="button" class="btn btn-primary pull-right" data-dismiss="modal" aria-hidden="true">Listo</button>
</div>
<div class="clearfix"></div>
