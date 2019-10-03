<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\spinner\Spinner;
use app\models\NotificacionSearch;
use app\config\Globales;
use yii\bootstrap\Modal;
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
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

<?php 
    //$item = $this->params['itemnav'];
    $item = [
                ['label' => '<div class="menuHorarios" href="#" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span><br />Menú</center></div>',
                            'items' => [isset($this->params['itemnav']) ? $this->params['itemnav'] : '', isset($this->params['itemnav2']) ? $this->params['itemnav2'] : '', ['label' => '<a class="menuHorarios" href="index.php?r=horario/panelprincipal" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-home" aria-hidden="true"></span><br />Inicio</center></a>'], (Yii::$app->user->identity->username == "horarios") ? [
                                                'label' => Html::tag('span', '', ['class'=>'btn btn-default glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/site/logout'],
                                                'linkOptions' => ['data-method' => 'post'],
                                            
                                    
                                            ] : ''  ]
                ]

            ];
    /*$item = [];
    if(isset($this->params['itemnav']))
        array_push($item, $this->params['itemnav']);

    
    if(isset($this->params['itemnav2']))
        array_push($item, $this->params['itemnav2']);

    array_push($item, ['label' => '<a class="menuHorarios" href="index.php?r=horario/panelprincipal" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-home" aria-hidden="true"></span><br />Inicio</center></a>']);
*/
    NavBar::begin([
            'brandLabel' => '<img src="assets/images/logo-encabezado.png" class="pull-left"/><span>'.$this->title.'</span>'.'<span class="pull-right"></span>',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-default-horarios navbar-fixed-top',
                'style' => (Yii::$app->user->isGuest or in_array (Yii::$app->user->identity->role, [8])) ? 'visibility: hidden' : '',
            ],
        ]);
        echo Nav::widget([
            'encodeLabels' => false,
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $item
        ]);
NavBar::end();

?>
       
<div class='wraphorario'>
    <div class="container2">

    <?= Alert::widget() ?>
    <?= $content ?>
    
</div>
</div>





    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
