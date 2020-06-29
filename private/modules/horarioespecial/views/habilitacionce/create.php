<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\horarioespecial\models\Habilitacionce */

$this->title = 'Nueva habilitación de Clase Especial';

?>
<div class="habilitacionce-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'divisiones' => $divisiones,
        
    ]) ?>

</div>
