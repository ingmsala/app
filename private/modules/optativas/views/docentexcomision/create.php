<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Docentexcomision */

$this->title = 'Agregar Docente a Comisión';

?>
<div class="docentexcomision-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'docentes' => $docentes,
        'comisiones' => $comisiones,
        'optativa' => $optativa,
        'roles' => $roles,
        
    ]) ?>

</div>
