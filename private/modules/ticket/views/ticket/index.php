<?php

use app\modules\ticket\models\Authpago;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\ticket\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;

?>
<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modalgenerico',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();


        $proveedor = isset($params['buscar']['Authpago']['proveedorsearch'])?$params['buscar']['Authpago']['proveedorsearch']:'';
        $ordenpago = isset($params['buscar']['Authpago']['ordenpagosearch'])?$params['buscar']['Authpago']['ordenpagosearch']:'';
        if($proveedor!=''&&$ordenpago!=''){
            $busqueda = '<div>Búsqueda:<ul>';
            $busqueda .= '<li>Proveedor: '.$proveedor.'</li>';
            $busqueda .= '<li>Orden N°: '.$ordenpago.'</li></ul></div>';
        }else{
            if($proveedor!=''){
                $busqueda = '<div>Búsqueda:<ul>';
                $busqueda .= '<li>Proveedor: '.$proveedor.'</li></ul></div>';
            }elseif($ordenpago!=''){
                $busqueda = '<div>Búsqueda:<ul>';
                $busqueda .= '<li>Orden N°: '.$ordenpago.'</li></ul></div>';
            }else{
                $busqueda = '';
            }
        }
            

	?>
<div class="ticket-index">

    <p>
        <h3>Sistema de Tickets</h3>
    Para unificar los canales de comunicación, agilizar los procesos y brindar un mejor seguimiento y gestión de las solicitudes de las diferentes áreas, se implementa un sistema de tickets. 
    A cada solicitud se le asigna un número de ticket único que puede usar para rastrear el progreso y las respuestas en línea.
    Además, podrá consultar los ticket abiertos y cerrados a manera de historial de todas sus solicitudes, para poder consultar de referencia.
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'condensed' => true,
        'hover' => true,
        

        /*'rowOptions' => function($model){
            if ($model['estadoticket'] == 1){
                return ['class' => 'default'];
            }
            return ['class' => 'danger'];
        },*/
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,

        'toolbar'=>[
            ['content' => 
                
                Html::tag('div',  
                Html::button('<center><span class="glyphicon glyphicon-search" aria-hidden="true"></span><br />Buscar</center>', ['value' => Url::to(['/ticket/ticket/buscar']), 'title' => 'Buscar Orden de Pago', 'class' => $class4.' amodalgenerico']).
                Html::a('<center>Mis tickets<br />Abiertos</center>', ['index', 'rpt' => 1], ['class' => $class1.' role="group"']).
                Html::a('<center>Mis tickets<br />Cerrados</center>', ['index', 'rpt' => 2], ['class' => $class2.' role="group"']).
                Html::a('<center>Mis tickets<br />Abiertos y cerrados</center>', ['index', 'rpt' => 3], ['class' => $class3.' role="group"']).
                Html::a('<center><span class="glyphicon glyphicon-plus" aria-hidden="true"></span><br />Nuevo ticket</center>', ['create'], ['class' => 'btn btn-success']),
                [ 'class' => 'btn-group btn-group-xs ' ]).$busqueda
            ],
            
            
            
        ],

        'columns' => [
            
            [
                'label' => 'Ticket',
                'format' => 'raw',
                'width' => '1%',
                'value' => function($model){
                    return Html::a('#'.$model->id, Url::to(['view', 't' => $model->token]));
                }
            ],
            [
                'label' => 'Fecha',
                
                'format' => 'raw',
                'value' => function($model){
                   date_default_timezone_set('America/Argentina/Buenos_Aires');
                   
                   return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],
            
            
            [
                'label' => 'Asunto',
                'attribute' => 'asunto',
                'width' => '40%',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model->asunto, Url::to(['view', 't' => $model->token]));
                }
            ],
            
            [
                'label' => 'Estado',
                'format' => 'raw',
                'value' => function($model){
                    
                    
                    $ret = ($model->estadoticket == 1) ? '<span class="label label-success">'.$model->estadoticket0->nombre.'</span>' : '<span class="label label-danger">'.$model->estadoticket0->nombre.'</span>';
                    
                    $authpago = Authpago::find()->where(['ticket' => $model->id])->andWhere(['activo' => 1])->one();
                    
                    if($authpago!=null){
                        if($authpago->estado == 1)
                            $lbl = 'info';
                        elseif($authpago->estado == 2)
                            $lbl = 'petroleo';
                        elseif($authpago->estado == 3)
                            $lbl = 'purple';
                        else
                            $lbl = 'warning';
                        $ret .= '<br/><div class="label label-'.$lbl.'">Orden: '.$authpago->estado0->nombre.'</div>';
                        
                    }
                    
                    return $ret;
                    
                }
            ],
            [
                'label' => 'Creado por',
                'value' => function($model){
                    return $model->agente0->apellido.', '.$model->agente0->nombre;
                }
            ],
            [
                'label' => 'Asignado a',
                'value' => function($model){
                    if($model->asignacionticket0->agente==null){
                        return $model->asignacionticket0->areaticket0->nombre;
                    }
                    return $model->asignacionticket0->agente0->apellido.', '.$model->asignacionticket0->agente0->nombre;
                }
            ],
            //'asignacionticket',
            //'prioridadticket',
            //'clasificacionticket',

            //['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
</div>
