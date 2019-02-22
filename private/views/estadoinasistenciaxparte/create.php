<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Estadoinasistenciaxparte */

$this->title = 'Create Estadoinasistenciaxparte';

?>
<div class="estadoinasistenciaxparte-create">

    

    <?= $this->render('_form', [
        'model' => $model,
        'faltas' => $faltas,
    ]) ?>

</div>
