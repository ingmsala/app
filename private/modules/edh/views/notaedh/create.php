<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Notaedh */

?>
<div class="notaedh-create">


    <?= $this->render('_form', [
        'model' => $model,
        'tiposnota' => $tiposnota,
        'trimestres' => $trimestres,
    ]) ?>

</div>