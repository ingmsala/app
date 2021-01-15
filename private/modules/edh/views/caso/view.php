<?php

use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Caso */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Casos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$this->params['sidebar'] = [
    'visible' => true,
    'model' => $model,
    'origen' => 'view',
];

?>
<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'>".'Modificar  Caso#'.$model->id."</h2>",
            'id' => 'modaldetalleticket',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>
<div class="caso-view">

    <?php 
        $textasignacion = $model->matricula0->alumno0->apellido.', '.$model->matricula0->alumno0->nombre;
        $estado = $model->estadocaso0->nombre;
        $fecha = $model->inicio;
        $resolucion = $model->resolucion;
        $condicionfinal = $model->condicionfinal0->nombre;
        $descrip = '';
        $pie = $condicionfinal;
        echo '<div class="vista-listado flowGrid">
                    <div class="item-aviso flowGridItem">
                        <div class="header-aviso-resultados Empleos">
                            <h3>'.$textasignacion.'</h3>
                            <h4>'.$estado.'</h4>
                            <h4>'.$resolucion.'</h4>
                            <p class="fecha-publicado-resultados"><span class="text-muted">'.$fecha.'</span></p>
                        </div>
                        <div class="content-aviso-resultados">
                        '.$descrip.'
                        </div>
                        <div class="footer-aviso-resultados">
                            <div class="box-rs">
                            '.$pie.'
                            </div>
                            
                        </div>
                    </div>
                                    
                </div>';
        echo Html::button('<span class="glyphicon glyphicon-pencil"></span> '.'Modificar', ['value' => Url::to('index.php?r=edh/caso/actualizar&id='.$model->id), 'class' => 'btn btn-main btn-primary amodaldetalleticket pull-right contenedorlistado']);
    ?>
    

</div>
