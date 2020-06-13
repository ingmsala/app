<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;


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
<body>
    <?php $this->beginBody() ?>

<?php 

   
$items = [
                    
    

    ['label' => '<span class="glyphicon glyphicon-user"></span><br>'.Yii::$app->user->identity->username.'',
    
        'items' => [
                                      
            
            [
                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                'url' => ['/cas/auth/logout'],
                'linkOptions' => ['data-method' => 'post'],
            
    
            ],
            '<div class="dropdown-divider"></div>',
            
         ],
    ]

];
NavBar::begin([
    'brandLabel' => '<img src="assets/images/escudo.png" style="display:inline; vertical-align: middle; height:35px;"><span id="brandspan-optativas">Seleccione una opción</span>',
    //'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-default navbar-fixed-top',
        'style' => Yii::$app->user->isGuest ? 'visibility: hidden' : '',
    ],
    'brandOptions' => []
]);
echo Nav::widget([
    'encodeLabels' => false,
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $items
]);
NavBar::end();

?>
       
<div class='wraphorario'>
    <div class="container2">

    <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <?= $content ?>
    </div>
    <div class="col-md-1"></div>
    </div>

    <?= Alert::widget() ?>
    
    
</div>
</div>





    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
