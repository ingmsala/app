<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Programa */

$this->title = $model->actividad0->nombre;
$array = array(
    37 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/LENGUA%20Y%20LITERATURA%20CASTELLANAS%20%20IV.pdf'),
    38 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/Latin%20IV.pdf'),
    39 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/INGLES%20IV.pdf'),
    40 => array('http://monserrat.unc.edu.ar/files/geografia_IV_nuevo.pdf'),
    41 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/HISTORIA%20IV.pdf'),
    42 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/FORMACION%20%20ETICA%20Y%20CiVICA%20III.pdf'),
    43 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/HISTORIA%20DEL%20ARTE%20II.pdf'),
    44 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/Plastica%20IV.pdf'),
    45 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/MATEMATICA%20IV.pdf'),
    46 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/BIOLOGIA%20I.pdf'),
    47 => array('http://monserrat.unc.edu.ar/files/programa_de_fisico-quimica.pdf'),
    48 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/EDUCACION%20FISICA%20IV.pdf'),
    49 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/LENGUA%20Y%20LITERATURA%20CASTELLANAS%20V.pdf'),
    50 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/Latin%20V.pdf'),
    51 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/GRIEGO%20I%20-a%20partir%20de%202013.pdf'),
    52 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/INGLES%20V.pdf'),
    53 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/FRANCES%201.pdf'),
    54 => array('https://drive.google.com/file/d/0B_chOWB_RacCYVNKN2hkd3RKUjQ/view?usp=sharing'),
    55 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/HISTORIA%20V.pdf'),
    56 => array('http://monserrat.unc.edu.ar/files/programa_de_quimica_I.pdf'),
    57 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/BIOLOGIA%20II.pdf'),
    58 => array('http://monserrat.unc.edu.ar/files/matematicaV_2015.pdf'),
    59 => array('http://monserrat.unc.edu.ar/files/estadisticayprobabilidadesV_2015.pdf'),
    60 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/INFORMATICA%20II.pdf'),
    61 => array('http://monserrat.unc.edu.ar/files/metodolog_de_la_inv_V.pdf'),
    62 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/FILOSOFIA%20I.pdf'),
    63 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/EDUCACION%20FISICA%20V.pdf'),
    64 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/LENGUA%20Y%20LITERATURA%20CASTELLANAS%20VI.pdf'),
    65 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/GRIEGO%20II%20-a%20partir%20de%202013.pdf'),
    66 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/INGLES%20VI.pdf'),
    67 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/FRANCES%20II.pdf'),
    68 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/HISTORIA%20VI.pdf'),
    69 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/HISTORIA%20DE%20LA%20CULTURA%20I.pdf'),
    70 => array('https://drive.google.com/file/d/0B_chOWB_RacCN2xsUWR4Y2tINk0/view?usp=sharing'),
    71 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/FILOSOFIA%202.pdf'),
    72 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/TROGONOMETRIA.pdf'),
    73 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/GEOMETRIA.pdf'),
    74 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/BIOLOGIA%20III.pdf'),
    75 => array('http://monserrat.unc.edu.ar/files/programa_de_quimica_II.pdf'),
    76 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/fisica%201.pdf'),
    77 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/INFORMATICA%20III.pdf'),
    78 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/EDUCACION%20FISICA%20VI.pdf'),
    79 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/LENGUA%20Y%20LITERATURA%20CASTELLANAS%20VII.pdf'),
    80 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/GRIEGO%20III%20-a%20partir%20de%202013.pdf'),
    81 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/FRANCES%20III%20-a%20partir%20de%202013.pdf'),
    82 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/HISTORIA%20VII.pdf'),
    83 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/FILOSOFIA%203.pdf'),
    84 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/PSICOLOGIA.pdf'),
    85 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/ANALISIS%20MATEMATICO%20Y%20GEOMETRIA%20ANALITICA.pdf'),
    86 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/BIOLOGIA%20IV.pdf'),
    87 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/SOCIOLOGIA.pdf'),
    88 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/ECONOMIA%20POLITICA.pdf'),
    89 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/HISTORIA%20DE%20LA%20CULTURA%20II.pdf'),
    90 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/ELEMENTOS%20DE%20DERECHO%20y%20DERECHO.pdf'),
    91 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/INFORMATICA%20IV.pdf'),
    92 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/EDUCACION%20FISICA%20VII.pdf'),
    93 => array('http://secretarias.unc.edu.ar/monserrat/secundario/plan-de-estudios/plan-estudios-pdf/FISICA%20II.pdf'),
    9 => array('https://drive.google.com/file/d/1eU7-ncqDQIKJImtq2dNcZXQcqwBOTIe9/view?usp=sharing'),
    1 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/05/2020/2020-249.pdf'),
    2 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/05/2020/2020-240.pdf'),
    3 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/05/2020/2020-239.pdf'),
    8 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/05/2020/2020-234.pdf'),
    7 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/06/2020/2020-251.pdf'),
    6 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/05/2020/2020-242.pdf'),
    4 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/05/2020/2020-237.pdf'),
    5 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/05/2020/2020-236.pdf'),
    11 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/05/2020/2020-241.pdf'),
    10 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/06/2020/2020-252.pdf'),
    12 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/05/2020/2020-235.pdf'),
    22 => array('https://drive.google.com/file/d/1yvp2Ofi0pq9311MOGCnmCRdLfABsSt9q/view?usp=sharing'),
    13 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/06/2020/2020-265.pdf'),
    14 => array('https://drive.google.com/file/d/1kgP8sywinmbz7_aK1aNoVnvJL9NIPwUT/view?usp=sharing'),
    15 => array('https://drive.google.com/file/d/1ZLiYbLhHJhUMxUB2v7B505kt-zRhwbK_/view?usp=sharing'),
    21 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/06/2020/2020-268.pdf'),
    20 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/06/2020/2020-267.pdf'),
    19 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/06/2020/2020-258.pdf'),
    17 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/06/2020/2020-266.pdf'),
    18 => array('https://drive.google.com/file/d/1naYzNUndISu5L8CRtEKuIyx5HnJYMyU5/view?usp=sharing'),
    16 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/06/2020/2020-354.pdf'),
    24 => array('https://drive.google.com/file/d/1c9NUatEXsGcyX5FZrIRh3Wg96mnx9tnC/view?usp=sharing'),
    34 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/07/2020/2020-372.pdf'),
    25 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/07/2020/2020-373.pdf'),
    26 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/06/2020/2020-298.pdf'),
    27 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/06/2020/2020-314.pdf'),
    32 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/06/2020/2020-315.pdf'),
    35 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/07/2020/2020-374.pdf'),
    29 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/06/2020/2020-312.pdf'),
    30 => array('https://monserrat.unc.edu.ar/wp-content/blogs.dir/8/files/sites/8/gravity_forms/1-78b52efae091f851456cd09386bd37b8/06/2020/2020-313.pdf'),
    28 => array('https://drive.google.com/file/d/1iUtvg_v6Jn74vpmshlEOss-mrW3NwOjF/view?usp=sharing'),
    183 => array('https://drive.google.com/file/d/15tbs9WmwHLdIsKMVcDN6MiMuxi2TyPiP/view?usp=sharing'),
    36 => array('https://drive.google.com/file/d/1q09HJfSxzHadP65BkNZWAAflIQa8gt0o/view?usp=sharing'),
);

?>

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modalviewprograma',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>
<div class="programa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'plan0.nombre',
            [
                'label' => 'Vigencia',
                'value' => function ($model){
                    return ($model->vigencia == 1) ? 'Vigente' : 'Inactivo';
                }
            ],
            /*[
                'label' => 'Programa oficial',
                'format' => 'raw',
                'value' => Html::a('Ver programa', $array[$model->actividad0->id][0], ['target'=>'_blank'])
            ],*/
            
        ],
    ]) ?>



<?php

    echo Html::button('<span class="glyphicon glyphicon-plus"></span> Agregar unidad', ['value' => Url::to('index.php?r=libroclase/detalleunidad/create&programa='.$model->id), 'class' => 'btn btn-main btn-success amodalnuevodetalleunidad']).'<br /><br />';

?>
<?php Pjax::begin(['id' => 'test', 'timeout' => 5000]); ?>
<?= $salida ?>
<?php Pjax::end(); ?>
</div>
