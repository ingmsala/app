<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Parte */
$formatter = \Yii::$app->formatter;

$this->title = 'Revisión de superposiciones';

?>
<div class="parte-view">

    <h2><?= Html::encode($this->title) ?></h2>

       

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
    <div class="col-md-4">
         

            
            <?php echo $this->render('_superposicionencursos', [
                'col' => $col,
                'providercursos' => $providercursos,
                
            ]); ?>
        
    </div>
    <div class="col-md-4">
            <?php echo $this->render('_superposiciondedocentes', [
                'col' => $col,
                'providerdocentes' => $providerdocentes,
                
            ]); ?>
    </div>
    <div class="col-md-4">
            <?php echo $this->render('_materiasnocargadas', [
                'col' => $col,
                'providermaterias' => $providermaterias,
                
            ]); ?>
    </div>
</div>


</div>
