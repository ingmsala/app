<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Horariodj */

$this->title = $model->diasemana0->nombre;

?>
<div class="horariodj-create">

    <h1><?= Html::encode($this->title) ?><em class="text-muted" style="font-size: .4em;"><?= ' '.$model->funciondj0->cargo.' ('.$model->funciondj0->reparticion.')'?></em></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
