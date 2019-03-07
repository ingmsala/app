<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Nombramiento */


$this->params['breadcrumbs'][] = ['label' => 'Nombramientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nombramiento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formsuplente', [
        'model' => $model,
        'nombramientoParent' => $nombramientoParent,
        'docentes' => $docentes,
        'revistas' => $revistas,
        'divisiones' => $divisiones,
        'extensiones' => $extensiones,
        'cargos' => $cargos,
        'revistas' => $revistas,
        'condiciones' => $condiciones,
        
    ]) ?>

</div>