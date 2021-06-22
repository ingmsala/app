<?php

use app\modules\becas\models\Becaayudaestatal;
use app\modules\becas\models\Becanivelestudio;
use app\modules\becas\models\Becaocupacion;
use app\modules\curriculares\models\Alumno;

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\becas\models\BecasolicitudSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Solicitud de beca';

?>
<div class="becasolicitud-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="panel-group" id="accordion">
    <div class="panel panel-default" id="panel1">
        <div class="panel-heading">
             <h4 class="panel-title">
        <a data-toggle="collapse" data-target="#collapseOne" 
           href="#collapseOne">
          <?='Estudiante: '.$sol->estudiante0->apellido.', '.$sol->estudiante0->nombre?><span class="pull-right"><?=$estudiante?> pts.</span>
        </a>
        
      </h4>
      
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
            <div class="panel-body">
<?= DetailView::widget([
        'model' => $modelEstudiante[0],
        'mode'=>DetailView::MODE_VIEW,
        'condensed'=>true,
        'hover'=>true,
                
        'enableEditMode' => false,
        'attributes' => [
            [
                'columns' => 
                    [
                        [
                            'label' => 'Nivel de estudio',
                            'format' => 'raw',
                            'valueColOptions'=>['style'=>'width:25%'],
                            'labelColOptions'=>['style'=>'width:25%'],
                            'value' => function()use($modelEstudiante, $sol){

                                $niveles = Becanivelestudio::find()->all();
                                $arraynivelestudio = [
                                   
                                    1 => 20,
                                    2 =>18,
                                    3 => 15,
                                    4=>15,
                                    5=>13,
                                    6=>13,
                                    7=>10,
                                    8=>13,
                                    9=>10,
                                    10=>5,
                                    11=>0,
                                ];
                                $ret = '<ul>';
                                foreach ($niveles as $key => $value) {
                                    if($sol->estudiante0->nivelestudio == $value->id)
                                        $ret .='<b><li>'.$value->nombre.': '.$arraynivelestudio[$value->id].' pts.</li></b>';
                                    else
                                        $ret .='<li>'.$value->nombre.': '.$arraynivelestudio[$value->id].' pts.</li>';
                                }
                                $ret .= '</ul>';
                                return $ret;
                                return '<ul><li>'.$sol->estudiante0->nivelestudio0->nombre.'</li></ul>';
                            },
                                
                        ],
                        [
                            'label' => 'Pts.',
                            'valueColOptions'=>['style'=>'width:5%'],
                            'labelColOptions'=>['style'=>'width:5%'],
                            'value' => function()use($modelEstudiante){
                                return $modelEstudiante[0]['nivelestudio'];
                            },
                                
                        ],
                    ]
            ],
            
            [
                'columns' => 
                    [
                        [
                            'label' => 'Situacion Ocupacional',
                            'format' => 'raw',
                            'valueColOptions'=>['style'=>'width:25%'],
                            'labelColOptions'=>['style'=>'width:25%'],
                            'value' => function()use($modelEstudiante, $sol){
                                $ocupaciones = Becaocupacion::find()->all();
                                $arrayocupacional = [
                                    1=>25,
                                    2=>10,
                                    3=>10,
                                    4=>15,
                                    5=>10,
                                    6=>25,
                                    7=>20,
                                    8=>25,
                                ];
                                $arr=[];
                                $ret = '<ul>';
                                foreach ($sol->estudiante0->persona0->becaocupacionpersonas as $key => $value) {
                                    $arr[$value->ocupacion] = $value->ocupacion;
                                }

                                foreach ($ocupaciones as $key2 => $value2) {
                                    if(in_array($value2->id, $arr))
                                        $ret .='<b><li>'.$value2->nombre.': '.$arrayocupacional[$value2->id].' pts.</li></b>';
                                    else
                                        $ret .='<li>'.$value2->nombre.': '.$arrayocupacional[$value2->id].' pts.</li>';
                                }

                                $ret .= '</ul>';
                                return $ret;
                            },
                                
                        ],
                        [
                            'label' => 'Pts.',
                            'valueColOptions'=>['style'=>'width:5%'],
                            'labelColOptions'=>['style'=>'width:5%'],
                            'value' => function()use($modelEstudiante){
                                return $modelEstudiante[0]['situacionocupacional'];
                            },
                                
                        ],
                    ]
            ],
            [
                'columns' => 
                    [
                        [
                            'label' => 'Ayuda estatal',
                            'format' => 'raw',
                            'valueColOptions'=>['style'=>'width:25%'],
                            'labelColOptions'=>['style'=>'width:25%'],
                            'value' => function()use($modelEstudiante, $sol){

                                $ayudas = Becaayudaestatal::find()->all();
                                $arrayayudas = [
                                    1=>0,
                                    2=>8,
                                    3=>10,
                                ];
                                $arr=[];
                                $ret = '<ul>';
                                foreach ($sol->estudiante0->persona0->becaayudapersonas as $key => $value) {
                                    $arr[$value->ayuda] = $value->ayuda;
                                }

                                foreach ($ayudas as $key2 => $value2) {
                                    if(in_array($value2->id, $arr))
                                        $ret .='<b><li>'.$value2->nombre.': '.$arrayayudas[$value2->id].' pts.</li></b>';
                                    else
                                        $ret .='<li>'.$value2->nombre.': '.$arrayayudas[$value2->id].' pts.</li>';
                                }

                                $ret .= '</ul>';
                                return $ret;

                            },
                                
                        ],
                        [
                            'label' => 'Pts.',
                            'valueColOptions'=>['style'=>'width:5%'],
                            'labelColOptions'=>['style'=>'width:5%'],
                            'value' => function()use($modelEstudiante){
                                return $modelEstudiante[0]['ayuda'];
                            },
                                
                        ],
                    ]
            ],
            [
                'columns' => 
                    [
                        [
                            'label' => 'Menor de edad',
                            'format' => 'raw',
                            'valueColOptions'=>['style'=>'width:25%'],
                            'labelColOptions'=>['style'=>'width:25%'],
                            'value' => function()use($modelEstudiante, $sol){
                                if($modelEstudiante[0]['menor']==1)
                                    $resp = 'Sí';
                                else
                                    $resp = 'No';
                                return '<ul><li>'.$resp.' (Fecha nac.: '.Yii::$app->formatter->asDate($sol->estudiante0->fechanac, 'dd/MM/yyyy').')</li></ul>';
                            },
                                
                        ],
                        [
                            'label' => 'Coef.',
                            'valueColOptions'=>['style'=>'width:5%'],
                            'labelColOptions'=>['style'=>'width:5%'],
                            'value' => function()use($modelEstudiante){
                                return $modelEstudiante[0]['coef'];
                            },
                                
                        ],
                    ]
            ],
            [
                'columns' => 
                    [
                        [
                            'label' => 'Total',
                            'format' => 'raw',
                            'valueColOptions'=>['style'=>'width:25%'],
                            'labelColOptions'=>['style'=>'width:25%'],
                            'value' => function()use($modelEstudiante, $sol){
                                return '(estudios + ocupacion + ayuda) × coef';
                            },
                                
                        ],
                        [
                            'label' => 'Pts.',
                            'format' => 'raw',
                            'valueColOptions'=>['style'=>'width:5%'],
                            'labelColOptions'=>['style'=>'width:5%'],
                            'value' => function()use($modelEstudiante){
                                return '<b>'.$modelEstudiante[0]['puntaje'].'</b>';
                            },
                                
                        ],
                    ]
            ],
            

            
            
        ],
    ]) ?>


    </div>
        </div>
    </div>


    <div class="panel panel-default" id="panel2">
        <div class="panel-heading">
             <h4 class="panel-title">
        <a data-toggle="collapse" data-target="#collapseTwo" 
           href="#collapseTwo">
          Convivientes (<?=count($modelConvivientes)?>)<span class="pull-right"><?=$conviviente?> pts.</span>
        </a>
      </h4>

        </div>
        <div id="collapseTwo" class="panel-collapse collapse">
            <div class="panel-body">





<?php
//echo var_dump($modelConvivientes);
foreach ($modelConvivientes as $modelConviviente) {
    


echo DetailView::widget([
        'model' => $modelConviviente,
        'mode'=>DetailView::MODE_VIEW,
        'condensed'=>true,
        'hover'=>true,
        'panel' => [
            'type' => DetailView::TYPE_PRIMARY,
            'heading' => Html::encode($modelConviviente['persona']->apellido.', '.$modelConviviente['persona']->nombre.' ('.$modelConviviente['persona']->parentesco0->nombre.')'),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
                
        'enableEditMode' => false,
        'attributes' => [
            [
                'columns' => 
                    [
                        [
                            'label' => 'Nivel de estudio',
                            'format' => 'raw',
                            'valueColOptions'=>['style'=>'width:25%'],
                            'labelColOptions'=>['style'=>'width:25%'],
                            'value' => function()use($modelConviviente, $sol){

                                $niveles = Becanivelestudio::find()->all();
                                $arraynivelestudio = [
                                   
                                    1 => 20,
                                    2 =>18,
                                    3 => 15,
                                    4=>15,
                                    5=>13,
                                    6=>13,
                                    7=>10,
                                    8=>13,
                                    9=>10,
                                    10=>5,
                                    11=>0,
                                ];
                                $ret = '<ul>';
                                foreach ($niveles as $key => $value) {
                                    if($modelConviviente['persona']->nivelestudio == $value->id)
                                        $ret .='<b><li>'.$value->nombre.': '.$arraynivelestudio[$value->id].' pts.</li></b>';
                                    else
                                        $ret .='<li>'.$value->nombre.': '.$arraynivelestudio[$value->id].' pts.</li>';
                                }
                                $ret .= '</ul>';
                                return $ret;

                                return '<ul><li>'.$modelConviviente['persona']->nivelestudio0->nombre.'</li></ul>';
                            },
                                
                        ],
                        [
                            'label' => 'Pts.',
                            'valueColOptions'=>['style'=>'width:5%'],
                            'labelColOptions'=>['style'=>'width:5%'],
                            'value' => function()use($modelConviviente){
                                return $modelConviviente['nivelestudio'];
                            },
                                
                        ],
                    ]
            ],
            
            [
                'columns' => 
                    [
                        [
                            'label' => 'Situacion Ocupacional',
                            'format' => 'raw',
                            'valueColOptions'=>['style'=>'width:25%'],
                            'labelColOptions'=>['style'=>'width:25%'],
                            'value' => function()use($modelConviviente, $sol){

                                $ocupaciones = Becaocupacion::find()->all();
                                $arrayocupacional = [
                                    1=>25,
                                    2=>10,
                                    3=>10,
                                    4=>15,
                                    5=>10,
                                    6=>25,
                                    7=>20,
                                    8=>25,
                                ];
                                $arr=[];
                                $ret = '<ul>';
                                foreach ($modelConviviente['persona']->persona0->becaocupacionpersonas as $key => $value) {
                                    $arr[$value->ocupacion] = $value->ocupacion;
                                }

                                foreach ($ocupaciones as $key2 => $value2) {
                                    if(in_array($value2->id, $arr))
                                        $ret .='<b><li>'.$value2->nombre.': '.$arrayocupacional[$value2->id].' pts.</li></b>';
                                    else
                                        $ret .='<li>'.$value2->nombre.': '.$arrayocupacional[$value2->id].' pts.</li>';
                                }

                                $ret .= '</ul>';
                                return $ret;



                                $echo = '<ul>';
                                foreach ($modelConviviente['persona']->persona0->becaocupacionpersonas as $key => $value) {
                                    $echo .='<li>'.$value->ocupacion0->nombre.'</li>';
                                }
                                $echo .= '</ul>';
                                return $echo;
                            },
                                
                        ],
                        [
                            'label' => 'Pts.',
                            'valueColOptions'=>['style'=>'width:5%'],
                            'labelColOptions'=>['style'=>'width:5%'],
                            'value' => function()use($modelConviviente){
                                return $modelConviviente['situacionocupacional'];
                            },
                                
                        ],
                    ]
            ],
            [
                'columns' => 
                    [
                        [
                            'label' => 'Ayuda estatal',
                            'format' => 'raw',
                            'valueColOptions'=>['style'=>'width:25%'],
                            'labelColOptions'=>['style'=>'width:25%'],
                            'value' => function()use($modelConviviente, $sol){

                                $ayudas = Becaayudaestatal::find()->all();
                                $arrayayudas = [
                                    1=>0,
                                    2=>8,
                                    3=>10,
                                ];
                                $arr=[];
                                $ret = '<ul>';
                                foreach ($modelConviviente['persona']->persona0->becaayudapersonas as $key => $value) {
                                    $arr[$value->ayuda] = $value->ayuda;
                                }

                                foreach ($ayudas as $key2 => $value2) {
                                    if(in_array($value2->id, $arr))
                                        $ret .='<b><li>'.$value2->nombre.': '.$arrayayudas[$value2->id].' pts.</li></b>';
                                    else
                                        $ret .='<li>'.$value2->nombre.': '.$arrayayudas[$value2->id].' pts.</li>';
                                }

                                $ret .= '</ul>';
                                return $ret;

                                $echo = '<ul>';
                                foreach ($modelConviviente['persona']->persona0->becaayudapersonas as $key => $value) {
                                    $echo .='<li>'.$value->ayuda0->nombre.'</li>';
                                }
                                $echo .= '</ul>';
                                return $echo;
                            },
                                
                        ],
                        [
                            'label' => 'Pts.',
                            'valueColOptions'=>['style'=>'width:5%'],
                            'labelColOptions'=>['style'=>'width:5%'],
                            'value' => function()use($modelConviviente){
                                return $modelConviviente['ayuda'];
                            },
                                
                        ],
                    ]
            ],
            [
                'columns' => 
                    [
                        [
                            'label' => 'Menor de edad',
                            'format' => 'raw',
                            'valueColOptions'=>['style'=>'width:25%'],
                            'labelColOptions'=>['style'=>'width:25%'],
                            'value' => function()use($modelConviviente, $sol){
                                if($modelConviviente['menor']==1)
                                    $resp = 'Sí';
                                else
                                    $resp = 'No';
                                return '<ul><li>'.$resp.' (Fecha nac.: '.Yii::$app->formatter->asDate($modelConviviente['persona']->fechanac, 'dd/MM/yyyy').')</li></ul>';
                            },
                                
                        ],
                        [
                            'label' => 'Coef.',
                            'valueColOptions'=>['style'=>'width:5%'],
                            'labelColOptions'=>['style'=>'width:5%'],
                            'value' => function()use($modelConviviente){
                                return $modelConviviente['coef'];
                            },
                                
                        ],
                    ]
            ],
            [
                'columns' => 
                    [
                        [
                            'label' => 'Total',
                            'format' => 'raw',
                            'valueColOptions'=>['style'=>'width:25%'],
                            'labelColOptions'=>['style'=>'width:25%'],
                            'value' => function()use($modelConviviente, $sol){
                                return '(estudios + ocupacion + ayuda) × coef';
                            },
                                
                        ],
                        [
                            'label' => 'Pts.',
                            'format' => 'raw',
                            'valueColOptions'=>['style'=>'width:5%'],
                            'labelColOptions'=>['style'=>'width:5%'],
                            'value' => function()use($modelConviviente){
                                return '<b>'.$modelConviviente['puntaje'].'</b>';
                            },
                                
                        ],
                    ]
            ],
            

            
            
        ],
    ]).'<br />';
    
    
}
?>
            </div>
        </div>
    </div>

            <div class="panel panel-default" id="panel3">
        <div class="panel-heading">
             <h4 class="panel-title">
        <a data-toggle="collapse" data-target="#collapseTres" 
           href="#collapseTres">
          Menores de edad (<?=$cantmenor?>)<span class="pull-right"><?=$pjemenor?> pts.</span>
        </a>
        
      </h4>
      
        </div>
        <div id="collapseTres" class="panel-collapse collapse">
            <div class="panel-body">
            <?php

                                $echomen = '<ol>';
                                foreach ($arraymenor as $key => $value) {
                                    $fecha = date_create($value->fechanac);
                                    $hoy = new DateTime($sol->convocatoria0->hasta);
                                    $interval = date_diff( $fecha, $hoy);
                                    $edad = $interval->y;
                                    if($edad == 0){
                                        $edad = $interval->m.' meses';
                                        if($edad == '0 meses')
                                            $edad = $interval->days.' días';
                                    }else{
                                        $edad = $edad.' años';
                                    }
                                    $echomen .='<li>'.$value->apellido.', '.$value->nombre.' (Edad: '.$edad.')</li>';
                                   
                                }
                                $echomen .= '</ol>';

            ?>
<?= DetailView::widget([
        'model' => $arraymenor,
        'mode'=>DetailView::MODE_VIEW,
        'condensed'=>true,
        'hover'=>true,
                
        'enableEditMode' => false,
        'attributes' => [
            [
                'columns' => 
                    [
                        [
                            'label' => $echomen,
                            'format' => 'raw',
                            'valueColOptions'=>['style'=>'width:25%'],
                            'labelColOptions'=>['style'=>'width:25%'],
                            'value' => function()use($arraymenor, $cantmenor, $sol){
                                $arrmen = [
                                    0 => 0,
                                    1 => 2,
                                    2 => 4,
                                    3 => 6,
                                    4 => 8,
                                    5 => 10,
                                ];
                               

                                $echo = '<ul>';

                                foreach ($arrmen as $key2 => $value2) {
                                    
                                        if($key2==5){
                                            if($key2==$cantmenor || $cantmenor>5)
                                                $echo .='<b><li>Cantidad '.$key2.' o más: 10 pts.</li></b>';
                                            else
                                                $echo .='<li>Cantidad '.$key2.' o más: 10 pts.</li>';
                                        }else{
                                            if($key2==$cantmenor)
                                                $echo .='<b><li>Cantidad '.$key2.': '.$value2.' pts.</li></b>';
                                            else
                                                $echo .='<li>Cantidad '.$key2.': '.$value2.' pts.</li>';
                                        }

                                    
                                    
                                }
                                
                                $echo .= '</ul>';
                                return $echo;
                            },
                                
                        ],
                        [
                            'label' => 'Pts.',
                            'valueColOptions'=>['style'=>'width:5%'],
                            'labelColOptions'=>['style'=>'width:5%'],
                            'value' => function()use($pjemenor){
                                return $pjemenor;
                            },
                                
                        ],
                    ]
            ],
            
        ],
    ]) ?>


    </div>
        </div>
    </div>

    <div class="panel panel-default" id="panel4">
        <div class="panel-heading">
             <h4 class="panel-title">
        <a data-toggle="collapse" data-target="#collapseCuatro" 
           href="#collapseCuatro">
          Mayores de edad (<?=$cantmayor?>)<span class="pull-right"><?=$pjemayor?> pts.</span>
        </a>
        
      </h4>
      
        </div>
        <div id="collapseCuatro" class="panel-collapse collapse">
            <div class="panel-body">
            <?php
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $echomay = '<ol>';
            foreach ($arraymayor as $key => $value) {
                $fecha = date_create($value->fechanac);
                $hoy = new DateTime($sol->convocatoria0->hasta);
                $interval = date_diff( $fecha, $hoy);
                $edad = $interval->y;
                if($edad == 0){
                    $edad = $interval->m.' meses';
                    if($edad == '0 meses')
                        $edad = $interval->days.' días';
                }else{
                    $edad = $edad.' años';
                }
                $echomay .='<li>'.$value->apellido.', '.$value->nombre.' (Edad: '.$edad.')</li>';
            }
            $echomay .= '</ol>';
            ?>
<?= DetailView::widget([
        'model' => $arraymayor,
        'mode'=>DetailView::MODE_VIEW,
        'condensed'=>true,
        'hover'=>true,
                
        'enableEditMode' => false,
        'attributes' => [
            [
                'columns' => 
                    [
                        [
                            'label' => $echomay,
//                            'Cantidad: '.$cantmayor,
                            'format' => 'raw',
                            'valueColOptions'=>['style'=>'width:25%'],
                            'labelColOptions'=>['style'=>'width:25%'],
                            'value' => function()use($arraymayor, $cantmayor, $sol){
                                

                                //$echo .= '<br/>';

                                $arrmay = [
                                    0 => 0,
                                    1 => 1,
                                    2 => 2,
                                    3 => 3,
                                    4 => 4,
                                    5 => 5,
                                ];

                                $echo = '<ul>';

                                foreach ($arrmay as $key2 => $value2) {
                                    
                                        if($key2==5){
                                            if($key2==$cantmayor || $cantmayor>5)
                                                $echo .='<b><li>Cantidad '.$key2.' o más: 5 pts.</li></b>';
                                            else
                                                $echo .='<li>Cantidad '.$key2.' o más: 5 pts.</li>';
                                        }else{
                                            if($key2==$cantmayor)
                                                $echo .='<b><li>Cantidad '.$key2.': '.$value2.' pts.</li></b>';
                                            else
                                                $echo .='<li>Cantidad '.$key2.': '.$value2.' pts.</li>';
                                        }

                                    
                                    
                                }
                                
                                $echo .= '</ul>';

                                return $echo;
                            },
                                
                        ],
                        [
                            'label' => 'Pts.',
                            'valueColOptions'=>['style'=>'width:5%'],
                            'labelColOptions'=>['style'=>'width:5%'],
                            'value' => function()use($pjemayor){
                                return $pjemayor;
                            },
                                
                        ],
                    ]
            ],
            
        ],
    ]) ?>


    </div>
        </div>
    </div>

</div>  
<h1 class="pull-right"><?= Html::encode('Total: '.$puntajefinal) ?></h1>  
<div class="clearfix"></div>
    </div>
