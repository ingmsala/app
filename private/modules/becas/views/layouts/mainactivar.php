<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;

use yii\bootstrap\NavBar;
use app\assets\AppAsset;
use app\config\Globales;
use kartik\nav\NavX;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="assets/images/favicon1.ico" type="image/x-icon" />
    <?= Html::csrfMetaTags() ?>
    
    <?php $this->head() ?>
</head>

    <?php $this->beginBody() ?>

<?php 


$items = [];

$items = [
                            
    ['label' => '< Volver al Portal de Trámites', 'url' => 'https://monserrat.unc.edu.ar/portal-de-tramites/'],
];
    
NavBar::begin([
    'brandLabel' => '<img src="assets/images/escudo.png" style="display: inline;vertical-align: middle; height:45px;"><span class="pull-left;" id="brandspan-optativas">Colegio Nacional de Monserrat</span>',
    'brandUrl' => Url::to('https://monserrat.unc.edu.ar/portal-de-tramites/', $schema = false),
    'options' => [
        'class' => 'navbar-default navbar-fixed-top',
        'style' => 'height:75px;',
    ],
    'brandOptions' => []
]);
echo NavX::widget([
    'encodeLabels' => false,
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $items
]);
NavBar::end();

?>
       
<div class='wrappersonal'>
    <div class="container">
    <?= Alert::widget() ?>
        <div class="row">
            
            <div class="col-md-12">
                <?= $content ?>
            </div>
            
        </div>
    </div>
</div>

    <?php $this->endBody() ?>

</html>
<?php $this->endPage() ?>
