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
            'class' => 'navbar-inverse navbar-fixed-top',
            'style' => Yii::$app->user->isGuest ? 'visibility: hidden' : '',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Reportes', 
                'items' => [
                    ['label' => 'Horas Catedra Secundario', 'url' => ['#']],
                        '<div class="dropdown-divider"></div>',
                    ['label' => 'Horas Catedra Pregrado', 'url' => ['#']],
                        '<div class="dropdown-divider"></div>',
                    ['label' => 'Cargos', 'url' => ['#']],
                        '<div class="dropdown-divider"></div>',
                    ['label' => 'Preceptores', 'url' => ['/reporte/preceptores']],
                        '<div class="dropdown-divider"></div>',
                    ['label' => 'Jefe de Preceptores', 'url' => ['#']],
                        '<div class="dropdown-divider"></div>',
                    

                    ['label' => 'Listado de Horas por Docente', 'url' => ['/reporte/horasdocentes']],
                        '<div class="dropdown-divider"></div>',
                ],
            ],
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
                    ['label' => 'Tipo de Actividad', 'url' => ['/actividad-tipo']],
                        '<div class="dropdown-divider"></div>',
                    ['label' => 'Detalle de Catedra', 'url' => ['/detalle-catedra']],
                ],

            ],
            ['label' => 'Procesos', 
                'items' => [
                    ['label' => 'Comparar con Mapuche', 'url' => ['#']],
                        '<div class="dropdown-divider"></div>',
                    
                ],
            ],
            Yii::$app->user->isGuest ? (
                ['label' => 'Ingresar', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Cerrar sesión (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
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
