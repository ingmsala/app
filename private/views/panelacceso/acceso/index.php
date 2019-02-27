<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccesoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<div class="acceso-index">

    
   
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-3">           
          <?= 
            Html::a('<span class="logo glyphicon glyphicon-user"></span><h2>Ingreso</h2><h3>DNI</h3>',

           "javascript:void(0)", 

           [

               'id' => 'modalButtonIngreso',
               'class' => 'client',
               'value'=>Url::toRoute(['buscarvisitante'])// modalCall

           ]);

          ?>
          
      </div>
      <div class="col-md-3"> 
          <?= 
            Html::a('<span class="logo2 glyphicon glyphicon-barcode"></span><h2>Egreso</h2><h3>Credencial</h3>',

           "javascript:void(0)", 

           [

               'id' => 'modalButtonEgreso',
               'class' => 'client2',
               'value'=>Url::toRoute(['egreso'])// modalCall

           ]);

          ?>

      </div>
      <div class="col-md-3"></div>
    </div>

   
    <div class="clearfix">...</div>
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
