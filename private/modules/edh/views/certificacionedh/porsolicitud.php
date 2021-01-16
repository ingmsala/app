<?php


use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\CertificacionedhSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Certificacionedhs';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="certificacionedh-index">

<ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" <?php echo 'href="#certificados'.$solicitud.'"'?>>Certificados</a></li>
          <li><a data-toggle="tab" <?php echo 'href="#informes'.$solicitud.'"'?>>Informes profesionales</a></li>
          
          
        </ul>

        <div class="tab-content">
            <div <?php echo 'id="certificados'.$solicitud.'"'?> class="tab-pane fade in active">
    
                <p style="margin-top:1em" class="pull-right">
                <?= Html::button('<span class="glyphicon glyphicon-plus"></span> '.'Agregar certificado', ['value' => Url::to('index.php?r=edh/certificacionedh/create&solicitud='.$solicitud), 'class' => 'btn btn-success amodalcertificado']); ?>
                </p>

                <div class="clearfix"></div>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'summary' => false,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'label' => 'Fecha',
                            'value' => function($model){
                                date_default_timezone_set('America/Argentina/Buenos_Aires');
                                return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                            }
                        ],
                        'referente',
                        'institucion',
                        'contacto',
                        'diagnostico',            
                        'tipocertificado0.nombre',
                        'tipoprofesional0.nombre',
                        'indicacion:ntext',
                        [
                            'label' => 'Adjuntos',
                            'format' => 'raw',
                            'value' => function($model){

                                


                                $echofooter = '<ul style="padding-inline-start: 0px;">';
                                
                                
                                foreach ($model->adjuntocertificacions as $adjunto) {

                                    $len = (Yii::$app->params['devicedetect']['isMobile']) ? 15 : 20;

                                    if(strlen($adjunto->nombre)>$len){
                                        
                                        $arr = explode(".", $adjunto->nombre);
                                        $ext = end($arr);
                                        $img = substr(ltrim($adjunto->nombre),0,$len).'...'.$ext;
                        
                        
                                    }else
                                        $img = $adjunto->nombre;


                                    
                                    
                                        $echofooter .= '<li style="list-style:none">'.Html::a('<div class="label label-default">'.$img.'</div>', Url::to(['adjuntocertificacion/descargar', 'file' => $adjunto->url]), ['target'=>'_blank']).'</li>';
                                            
                                        
                                    
                                }
                                $echofooter .= '</ul>';
                                return $echofooter;
                            }
                        ],

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            </div>

            <div <?php echo 'id="informes'.$solicitud.'"'?> class="tab-pane fade">
            <?php 

                echo $this->render('/informeprofesional/index', [
                    'searchModel' => $searchModelInforme,
                    'dataProvider' => $dataProviderInforme,
                    'solicitud' => $solicitud,
                ]);

            ?>
            

          </div>
        </div>
</div>
