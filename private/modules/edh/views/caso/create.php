<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Caso */

?>
<div class="caso-create">

    

    <?= $this->render('_form', [
        'model' => $model,
        'modelSolicitud' => $modelSolicitud,
        'aniolectivos' => $aniolectivos,
        'areas' => $areas,
    ]) ?>

</div>

