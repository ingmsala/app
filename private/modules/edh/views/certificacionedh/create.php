<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Certificacionedh */


?>
<div class="certificacionedh-create">


    <?= $this->render('_form', [
        'model' => $model,
        'modelajuntos' => $modelajuntos,
        'tiposcertificado' => $tiposcertificado,
        'tiposprofesional' => $tiposprofesional,
        'referentes' => $referentes,
        'instituciones' => $instituciones,
        'diagnosticos' => $diagnosticos,
        
    ]) ?>

</div>
