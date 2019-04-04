<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Novedadesparte */

$this->title = 'Nueva Novedad';

?>
<div class="novedadesparte-create">

   

    <?= $this->render('_form', [
        'model' => $model,
        'tiponovedades' => $tiponovedades,
        'preceptores' => $preceptores,
    ]) ?>

</div>
