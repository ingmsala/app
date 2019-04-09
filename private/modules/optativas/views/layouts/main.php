<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\modules\optativas\models\DocentexcomisionSearch;
use app\modules\optativas\models\Docentexcomision;

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
    <title><?= Html::encode('Gestión de Espacios Optativos') ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php

        NavBar::begin([
            'brandLabel' => '<img src="assets/images/escudo.png" style="display:inline; vertical-align: middle; height:35px;"><span id="brandspan-optativas">Gestión de Espacios Optativos</span>',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-default-optativas navbar-fixed-top',
                'style' => Yii::$app->user->isGuest ? 'visibility: hidden' : '',
            ],
            'brandOptions' => []
        ]);
        echo Nav::widget([
            'encodeLabels' => false,
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                        
                        ['label' => '<span class="glyphicon glyphicon-align-center"></span><div>Home</div>', 'url' => ['/optativas']],
                        ['label' => '<span class="glyphicon glyphicon-book"></span><div>Clases</div>', 'url' => ['/optativas/clase']],
                        ['label' => '<span class="glyphicon glyphicon-copyright-mark"></span><div>Calificaciones</div>', 'url' => ['/optativas/calificacion']],
                        ['label' => '<span class="glyphicon glyphicon-folder-open"></span><div>Seguimiento</div>', 'url' => ['/optativas/seguimiento']],
                        ['label' => '<span class="glyphicon glyphicon-modal-window"></span><br>Reportes', 

                            'items' => [
                                [
                                    'label' => 'Ficha del Alumno',
                                    'url' => ['/optativas/reportes/fichadelalumno'],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                [
                                    'label' => 'Planilla de Asistencia',
                                    'url' => ['/optativas/reportes/planillasistencia'],
                                ],
                            
                                '<div class="dropdown-divider"></div>',
                            
                            ],



                        ],
                        
                            
                        


                  

                Yii::$app->user->isGuest ? (
                    ['label' => 'Ingresar', 'url' => ['/site/login']]
                ) : (


                    ['label' => '<span class="glyphicon glyphicon-user"></span><br>'.Yii::$app->user->identity->username.'',
                        
                        'items' => [
                                                       [
                                'label' => 'Cambiar contraseña',
                                'url' => ['/user/cambiarpass'],
                            ],
                            
                            [
                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                'url' => ['/site/logout'],
                                'linkOptions' => ['data-method' => 'post'],
                            
                    
                            ],
                            '<div class="dropdown-divider"></div>',
                            
                         ],
                    ]


                    
                )
            ],
        ]);
NavBar::end();
?>
    <div class="container optativas">
            

            <div id="content" class="col-sm-3">
                <div class="row">
                    <?php $search= new DocentexcomisionSearch() ?>
                    <?php 

                    if(Yii::$app->request->get('r')!='user/cambiarpass'){

                        echo $this->render('/comision/_comisionxdocente',
                            [
                                'dataProvider' => $search->providerxdocente(Yii::$app->user->identity->username),
                                'comisiones' => $search->comisionesxdocente(Yii::$app->user->identity->username),
                                'model' => new Docentexcomision(),
                            ]);
                    }
                    ?>
                </div>
                <div class="row" style="margin-top: 50px;" id="submenu">
                    <?php

                       echo isset($this->params['submenu']) ? $this->params['submenu'] : '';

                     ?>
                </div>
                    

            </div>
            <div class="col-sm-9">
                
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Colegio Nacional de Monserrat <?= date('Y') ?></p>

        
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
