<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccesoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Visitantes actuales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acceso-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
      <div class="col-md-6">           
          <?= Html::button('Ingreso Visita', ['value' => Url::to('index.php?r=panelacceso/acceso/buscarvisitante'), 'class' => 'btn btn-success btn-lg', 'id'=>'modalButtonIngreso']) ?>
      </div>
      <div class="col-md-6"> 
          <?= Html::button('Egreso Visita', ['value' => Url::to('index.php?r=panelacceso/acceso/egreso'), 'class' => 'btn btn-danger btn-lg', 'id'=>'modalButtonEgreso']) ?>
      </div>
    </div>
    
    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Fecha de Ingreso',
                'attribute' => 'fechaingreso',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                //'value' => 'division0.nombre',
                'group' => true,
                'value' => function($model){
                    
                   return Yii::$app->formatter->asDate($model->fechaingreso, 'dd-MM-yyyy');
                }
            ],

            ['label' => 'Visitante',
                'attribute' => 'docente',
                'value' => function($model){
                    return $model->visitante0->apellidos.', '.$model->visitante0->nombres;
                }
            ],

            [
                'label' => 'Hora de Ingreso',
                'attribute' => 'fechaingreso',
                'hAlign' => 'center',
                'value' => function($model){
                    
                   return Yii::$app->formatter->asDate($model->fechaingreso, 'HH:mm').' hs.';
                }
            ],
            
            [
                'label' => 'Area',
                'attribute' => 'area0.nombre',
            ],

            ['class' => 'yii\grid\ActionColumn'],
            

            
        ],
    ]); ?>

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

        
        $this->registerJs("
           var msg = '".$msg."'
            if (msg == 'egr')   {         
                $('#infoegreso').fadeIn(1000);
                   setTimeout(function() { 
                       $('#infoegreso').fadeOut(1000); 
                   }, 3000);
              }
            if (msg == 'ingr')   {         
                $('#infoingreso').fadeIn(1000);
                   setTimeout(function() { 
                       $('#infoingreso').fadeOut(1000); 
                   }, 3000);
              };");
    ?>

    


<div class="alert alert-success" id="infoegreso" style="display:none;">
    <strong>Egreso</strong> registrado correctamente
  </div>
</div>

<div class="alert alert-success" id="infoingreso" style="display:none;">
    <strong>Ingreso</strong> registrado correctamente
  </div>
</div>
