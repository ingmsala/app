<?php

use app\config\Globales;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\Turnoexamen */

$this->title = 'Modificar Turno de examen: ' . $model->id;

?>
<?php
        if(!in_array (Yii::$app->user->identity->role, [Globales::US_AGENTE, Globales::US_CONSULTA, Globales::US_PRECEPTORIA, Globales::US_PRECEPTOR])){
            $breadcrumbs = [];
            $breadcrumbs [] = ['label' => $model->nombre];
        }
        echo Breadcrumbs::widget([
        'homeLink' => ['label' => '< Volver', 'url' => ['/turnoexamen']],
        'links' => $breadcrumbs,
    ]) ?>
<div class="turnoexamen-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tipos' => $tipos,
        'estados' => $estados,
    ]) ?>

</div>
