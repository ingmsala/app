<?php

use PHPUnit\Framework\MockObject\Stub;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\libroclase\models\ClasediariaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Libro de aula';

?>
<?php 
        $breadcrumbs = [];
        $breadcrumbs [] = ['label' => 'Libro de aula'];
        //$breadcrumbs [] = $this->title;

    ?>


    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => '< Volver', 'url' => ['index']],
        'links' => $breadcrumbs,
    ]) ?>
<div class="clasediaria-index">
    
    <h1><?= $catedra->division0->nombre.' - '.$catedra->actividad0->nombre ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva clase diaria', Url::to(['create', 'cat' => $catedra->id]), ['class' => 'btn btn-success']) ?>
    </p>

    <?=$horasfaltantes ?>

    <?php
    

    
        
    foreach ($dataProvider->getModels() as $model) {
        
        $echo = '';
        date_default_timezone_set('America/Argentina/Buenos_Aires');

        $fecha = Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');

        $horas = $model->horaxclases;
        $listadohoras = 'Horas: ';
        $cantx = '';
        foreach ($horas as $key => $hora) {
            $listadohoras .= $hora->hora0->nombre.' - ';
            if(strlen($cantx)==0){
                $cantx='<span class="label label-purple pull-left">#'.$cant.'</span>';
            }else{
                $cantx.='<span class="label label-purple pull-left">#'.$cant.'</span>';
                
            }
            
            $cant--;
        }
        $listadohoras .= '';

        $temas = $model->temaxclases;

        $canthoras = count($temas);

        $listadotemas = '<ul>';
        foreach ($temas as $key => $tema) {
            $listadotemas .= '<li>'.$tema->temaunidad0->descripcion.' ('.$tema->tipodesarrollo0->nombre.')</li>';

            
        }
        $listadotemas .= '</ul>';
        $pie = '';

        
        if($model->observaciones != null){
            $pie .= '<hr style="margin-bottom:0px;" />';
            $pie .= '<div class="push-left text-muted">Observaciones</div><div class="row" style="margin-left:2%">';
                
            $pie .= '<div>'.$model->observaciones.'</div>';
                
            $pie .= '</div>';
        }
        $hoy = strtotime(date('Y-m-d'));
        $fecha1w = strtotime('+10 day', strtotime($model->fechacarga));

        if($hoy<=$fecha1w){

            $delete = Html::a('×', ['delete', 'id' => $model->id], [
                'class' => 'close',
                'data' => [
                    'confirm' => 'Este proceso borra definitivamente del libro de temas la clase del día '.$fecha.'. Está seguro que desea proceder?',
                    'method' => 'post',
                ],
            ]);
        }else
            $delete = '';

        $echo .= '<div class="vista-listado flowGrid">
        <div class="item-aviso flowGridItem">
            <div class="header-aviso-resultados Empleos">
                <h3>'.$cantx.' - '.$fecha.'</h3>'.$delete.'
                <h4><span class="label label-petroleo">'.$model->modalidadclase0->nombre.'</span></h4>
                <p class="hora-publicado-resultados"><span class="text-muted">'.$listadohoras.'</span></p>
            </div>
            <div class="content-aviso-resultados">
            '.$listadotemas.'
            </div>
            <div class="footer-aviso-resultados">
                <div class="box-rs">
                '.$pie.'
                </div>
                
            </div>
        </div>
                        
        </div>';
        //$cant--;
       //echo Html::a($echo, ['update', 'id' => $model->id], ['class' => 'button-listado']);
        echo $echo;
        }
        



    

    ?>

    <?php /* GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                   if ($model->fecha == date('Y-m-d')){
                        return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy').' (HOY)';
                   } 
                   return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Horas',
                'format' => 'raw',
                'value' => function($model){
                    $horas = $model->horaxclases;
                    $salida = '<ul>';
                    foreach ($horas as $key => $hora) {
                        $salida .= ' - '.$hora->hora0->nombre;
                    }
                    $salida .= '</ul>';
                    return $salida;
                }
            ],
            [
                'label' => 'Temas',
                'format' => 'raw',
                'value' => function($model){
                    $temas = $model->temaxclases;
                    $salida = '<ul>';
                    foreach ($temas as $key => $tema) {
                        $salida .= '<li>'.$tema->temaunidad0->descripcion.' ('.$tema->tipodesarrollo0->nombre.')</li>';
                    }
                    $salida .= '</ul>';
                    return $salida;
                }
            ],
            //'fechacarga',
            //'agente',
            //'observaciones:ntext',
            //'modalidadclase',

            
        ],
    ]);*/ ?>
</div>
