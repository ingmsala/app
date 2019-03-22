<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
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
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php

        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-default navbar-fixed-top',
                'style' => Yii::$app->user->isGuest ? 'visibility: hidden' : '',
            ],
        ]);
        echo Nav::widget([
            'encodeLabels' => false,
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                Yii::$app->user->isGuest ? (
                    ['label' => '']
                ) :(
                    in_array (Yii::$app->user->identity->role, [1, 3, 6]) ? (
                        ['label' => 'Reportes', 
                        'items' => [
                   /* ['label' => 'Horas Catedra Secundario', 'url' => ['#']],
                        '<div class="dropdown-divider"></div>',
                    ['label' => 'Horas Catedra Pregrado', 'url' => ['#']],
                        '<div class="dropdown-divider"></div>',
                    ['label' => 'Cargos', 'url' => ['#']],
                        '<div class="dropdown-divider"></div>',
                    ['label' => 'Jefe de Preceptores', 'url' => ['#']],
                        '<div class="dropdown-divider"></div>',
                    */
                        ['label' => 'Preceptores', 'url' => ['/reporte/preceptores']],
                        '<div class="dropdown-divider"></div>',
                        ['label' => 'Listado de Horas por Docente', 'url' => ['/reporte/horasdocentes']],
                        '<div class="dropdown-divider"></div>',
                        ['label' => 'Horas de actividades por Cátedra', 'url' => ['/reporte/horasmateriaxcatedra']],
                        '<div class="dropdown-divider"></div>',

                        [
                            'label' => 'Parte Docente',
                            'itemsOptions'=>['class'=>'dropdown-submenu'],
                            'submenuOptions'=>['class'=>'dropdown-menu'],
                            'items' => [

                                ['label' => 'Faltas por mes y año', 'url' => ['/reporte/parte/faltasxmes']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Horas sin dictar por Docentes', 'url' => ['/reporte/parte/faltasdocentes']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Evolucion Faltas por año', 'url' => ['/reporte/parte/faltasxmeses']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Cantidad de Faltas por Turno', 'url' => ['/reporte/parte/faltasxmesesxturno']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Comparación por Turno en un año', 'url' => ['/reporte/parte/faltasxanioxturnototal']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Distribución de faltas por rango de días', 'url' => ['/reporte/parte/distribuciondediasxmes']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Distribución de faltas por día y hora', 'url' => ['/reporte/parte/distribuciondediasyhoras']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Distribución de faltas por división', 'url' => ['/reporte/parte/faltasxdivision']],
                                '<div class="dropdown-divider"></div>',

                            ],

                        ],
                        '<div class="dropdown-divider"></div>',    




                    ],
                ]) :
                    ['label' => '']
                ),
                Yii::$app->user->isGuest ? (
                    ['label' => '']
                ) :(
                    in_array (Yii::$app->user->identity->role, [1, 3, 6]) ? (
                        ['label' => 'Administración',
                        'items' => [

                            ['label' => 'Actividades', 'url' => ['/actividad']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Cátedras', 'url' => ['/catedra']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Cargos', 'url' => ['/cargo']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Condiciones', 'url' => ['/condicion']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Divisiones', 'url' => ['/division']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Docentes', 'url' => ['/docente']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Géneros', 'url' => ['/genero']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Nombramientos de cargo', 'url' => ['/nombramiento']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Plan de estudio', 'url' => ['/plan']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Propuestas Formativas', 'url' => ['/propuesta']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Situacion de Revista', 'url' => ['/revista']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Tipo de Actividad', 'url' => ['/actividadtipo']],
                        ],


                    ]) :
                    ['label' => '']
                ),

                Yii::$app->user->isGuest ? (
                    ['label' => '']
                ) :(

                    in_array (Yii::$app->user->identity->role, [1,3,4,5,6]) ? (
                        ['label' => 'Parte Docente', 
                        'items' => [
                            in_array (Yii::$app->user->identity->role, [1, 3, 4, 5, 6])?  
                            ['label' => 'Parte docente', 'url' => ['/parte']]: ['label' => ''],
                            '<div class="dropdown-divider"></div>',
                            in_array (Yii::$app->user->identity->role, [1, 4, 6])?  
                            ['label' => 'Control de Regencia', 'url' => ['parte/controlregencia']] : ['label' => ''],
                            '<div class="dropdown-divider"></div>',
                            in_array (Yii::$app->user->identity->role, [1, 3, 6])?    
                            ['label' => 'Control de Secretaría', 'url' => ['parte/controlsecretaria']]: ['label' => ''],
                            '<div class="dropdown-divider"></div>',
                            /*['label' => 'Horarios de cátedra', 'url' => ['parte/horarios']],
                            '<div class="dropdown-divider"></div>',*/

                        ],
                    ])  :
                    ['label' => '']
                ),          

                Yii::$app->user->isGuest ? (
                    ['label' => '']
                ) :(
                    in_array (Yii::$app->user->identity->role, [1, 7]) ? (
                        ['label' => 'Control de Acceso',
                        'items' => [

                            ['label' => 'Visitas', 'url' => ['/panelacceso/acceso']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Visitantes', 'url' => ['/panelacceso/visitante']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Areas', 'url' => ['/panelacceso/area']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Tarjetas', 'url' => ['/panelacceso/tarjeta']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Restringidos', 'url' => ['/panelacceso/restriccion']],
                            '<div class="dropdown-divider"></div>',
                        ],


                    ]) :
                    ['label' => '']
                ),

                Yii::$app->user->isGuest ? (
                    ['label' => 'Ingresar', 'url' => ['/site/login']]
                ) : (


                    ['label' => 'Usuario: '.Yii::$app->user->identity->username,
                        
                        'items' => [
                           in_array (Yii::$app->user->identity->role, [1]) ? (
                                ['label' => 'Usuarios', 'url' => ['/user']]
                               
                            ) : ['label' => ''],
                            '<div class="dropdown-divider"></div>',

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

<div class="container">
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <?= Alert::widget() ?>
    <?= $content ?>
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
