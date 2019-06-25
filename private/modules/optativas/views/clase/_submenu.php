<?php

use yii\helpers\Html;

use yii\bootstrap\Progress;

?>

<div class="panel panel-primary">
  <div class="panel-heading">Progreso</div>
  <div class="panel-body">

    <ul class="list-group">
        <li class="list-group-item">Horas dictadas: <?= $horastotalactual.' de '.$duracion.
            Progress::widget([
                            'barOptions' => ['class' => 'progress-bar-success'],
                            'options' => ['class' => 'active progress-striped'],
                            'percent' => $horastotalactual*100/$duracion,
                            'label' => round($horastotalactual*100/$duracion).'%'
                            ]);

            ?>
                
        </li>
        <li class="list-group-item">Presenciales: <?= $horaspresencialactual ?></li> 
        <li class="list-group-item">Salidas o visitas: <?= $horasvisitaactual ?></li>
        <li class="list-group-item">No Presenciales: <?= $horasnopresencialactual.' (Máx.24)',
            '<div style="width: 40%;">'.
            Progress::widget([
                                    'barOptions' => ['class' => 'progress-bar-primary'],
                                    'options' => ['class' => 'active progress-striped'],
                                    'percent' => $horasnopresencialactual*100/24,
                                    'label' => round($horasnopresencialactual*100/24).'%'
                                    ]).'</div>';


           ?>
               
        </li>  
         
    </ul>


  </div>
</div>
