<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
//use yii\bootstrap\Nav;
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

if(!Yii::$app->user->isGuest){
    if(Yii::$app->user->identity->role == Globales::US_CAE_ADMIN){
        $items = [
            ['label' => '<span class="glyphicon glyphicon-plus"></span><br />'.'Nueva solicitud'.'',
             'url' => ['/edh/caso/create']],
            ['label' => '<span class="glyphicon glyphicon-folder-open"></span><br />'.'Casos'.'',
             'url' => ['/edh/caso']],
                                            
            ['label' => '<span class="glyphicon glyphicon-cog"></span><br />'.'Administrar'.'',
                                        'items' => [

                                            ['label' => 'Condiciones final de cursado', 'url' => ['/edh/condicionfinal']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Estados de casos', 'url' => ['/edh/estadocaso']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Matrículas', 'url' => ['/edh/matriculaedh']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Área de recepción', 'url' => ['/edh/areasolicitud']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Estado de solicitud', 'url' => ['/edh/estadosolicitud']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Tipo de solicitud', 'url' => ['/edh/tiposolicitud']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Tipo de certificafión', 'url' => ['/edh/tipocertificacion']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Tipo de profesional', 'url' => ['/edh/tipoprofesional']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Tipo de participante', 'url' => ['/edh/tipoparticipante']],
                                            '<div class="dropdown-divider"></div>',
                                            
                                            
                                        ],


            ],
                            
            
            
            
            ['label' => '<span class="glyphicon glyphicon-user"></span><br />'.Yii::$app->user->identity->role0->nombre.'',
            
                'items' => [

                    [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-refresh']).'Cambiar rol de usuario',
                        'url' => ['/rolexuser/cambiar', 'i' => 5],
                    ],
                                            
                    
                    [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                        'url' => ['/edh/login/logout'],
                        'linkOptions' => ['data-method' => 'post'],
                    
            
                    ],
                    '<div class="dropdown-divider"></div>',
                    
                ],
            ]

        ];
    }else{
        $items = [];
    }
}else{
    $items = [];
}
NavBar::begin([
    'brandLabel' => '<img src="assets/images/escudo.png" style="display:inline; vertical-align: middle; height:35px;"><span id="brandspan-optativas">'.'Sistema de Gestión PEDH'.'</span>',
    //'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-default-personal navbar-fixed-top',
        'style' => Yii::$app->user->isGuest ? 'visibility: hidden' : '',
    ],
    'brandOptions' => []
]);
echo NavX::widget([
    'encodeLabels' => false,
    'activateParents' => true,
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $items
]);
NavBar::end();

?>
<?php if(isset($this->params['sidebar'])) {
    if($this->params['sidebar']['visible']== true){ 
        
        $model = $this->params['sidebar']['model'];
        $origen = $this->params['sidebar']['origen'];

        $view = '';
        $solicitudes = '';
        $reuniones = '';
        $actuaciones = '';
        $plan = '';

        if($origen == 'view')
            $view = 'active';
        elseif($origen == 'solicitudes')
            $solicitudes = 'active';
        elseif($origen == 'reuniones')
            $reuniones = 'active';
        elseif($origen == 'actuaciones')
            $actuaciones = 'active';
        elseif($origen == 'plan')
            $plan = 'active';
        
        ?>
    <div class="row">
    <div class="titulocaso">
        <div class="panel panel-primary">
            <div class="panel-heading">Caso<?= '#'.$model->id.': '.$model->matricula0->aniolectivo0->nombre.' - '.$model->matricula0->alumno0->apellido.', '.$model->matricula0->alumno0->nombre.' ('.$model->matricula0->division0->nombre.')'; ?></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="sidebar2">

                            <?php 
                            
                                echo Html::a('Caso', Url::to(['/edh/caso/view', 'id' => $model->id]), ['class' => $view]);
                                echo Html::a('Solicitudes', Url::to(['/edh/solicitudedh/index', 'id' => $model->id]), ['class' => $solicitudes]);
                                echo Html::a('Reuniones', Url::to(['/edh/reunionedh/index', 'caso' => $model->id]), ['class' => $reuniones]);
                                echo Html::a('Actuaciones', Url::to(['/edh/caso/view', 'id' => $model->id]), ['class' => $actuaciones]);
                                echo Html::a('Plan de cursado', Url::to(['/edh/caso/view', 'id' => $model->id]), ['class' => $plan]);
                            
                            ?>
                            
                           
                        </div>
                    </div>

                    <div class="col-md-10">
        
                        <div class='wrapedh'>
                            <div class="container">
                            <?= Alert::widget() ?>
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        <?= $content ?>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    </div>
<?php }}
else{ ?>
<div class="col-md-2">
                        
                    </div>

                    <div class="col-md-8">
    <div class='wrapedh'>
        <div class="container2">
        <?= Alert::widget() ?>
            <div class="row">
                
                <div class="col-md-12">
                    <?= $content ?>
                </div>
                
            </div>
        </div>
    </div>
                    </div>
    
    <?php }?>

    <?php $this->endBody() ?>

</html>
<?php $this->endPage() ?>
