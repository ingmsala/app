<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Nombramiento */

$this->title = 'Nuevo Nombramiento';
$this->params['breadcrumbs'][] = ['label' => 'Nombramientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nombramiento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,

        'cargos' => $cargos,
        'docentes' => $docentes,
        'revistas' => $revistas,
        'divisiones' => $divisiones,
        'condiciones' => $condiciones,
        'suplentes' => $suplentes,
        'extensiones' => $extensiones,
        
    ]) ?>

</div>
