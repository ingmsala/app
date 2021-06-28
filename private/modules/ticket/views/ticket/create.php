<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Ticket */

$this->title = 'Nuevo Ticket';

?>

<?php 
        $breadcrumbs = [];
        $breadcrumbs [] = ['label' => 'Nuevo Ticket'];
        //$breadcrumbs [] = $this->title;

    ?>


    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => '< Volver', 'url' => ['index']],
        'links' => $breadcrumbs,
    ]) ?>
<div class="ticket-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelasignacion' => $modelasignacion,
        'creadores' => $creadores,
        'prioridades' => $prioridades,
        'asignaciones' => $asignaciones,
        'modelajuntos' => $modelajuntos,
        'clasificaciones' => $clasificaciones,
        'modelauth' => $modelauth,
        'estados' => $estados,
        'proveedores' => $proveedores,
        'authpagovisible' => $authpagovisible,
        'origen' => 'create',
        'searchModelAdjuntos' => null,
        'dataProviderAdjuntos' => null,
    ]) ?>

</div>
