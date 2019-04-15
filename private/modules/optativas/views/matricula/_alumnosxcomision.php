<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\MatriculaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Planilla de Asistencia';
$this->params['breadcrumbs'][] = ['label' => 'Clases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $listInasistenciasdeldia=ArrayHelper::map($inasistenciasdeldia,'matricula','matricula'); ?>
<?php $listAlumnosdecomision=ArrayHelper::map($alumnosdecomision,'id','id'); ?>
<?php 
     $presentes =array_diff($listAlumnosdecomision, $listInasistenciasdeldia);
     $presentestxt = implode(",",$listAlumnosdecomision);

?>

<?php $this->registerJs("
    

 


  $('#btnausentes').on('click', function (e) {
    e.preventDefault();

    var array = []
var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')

for (var i = 0; i < checkboxes.length; i++) {
  array.push(checkboxes[i].name)
}

//alert(array);

    
    
    var keys = array;


    if(keys.length < 1){
        keys = [0];
    }
        
        var deleteUrl     = 'index.php?r=optativas/inasistencia/procesarausentes';
        var clase     = ".$clase.";
        var presentes     = '".$presentestxt."';
        var pjaxContainer = 'test';
        var pjaxContainer2 = 'test2';
                    
                    $.ajax({
                      url:   deleteUrl,
                      type:  'post',
                      data: {id: keys, clase: clase, presentes: presentes},
                      
                      error: function (xhr, status, error) {
                        alert(error);
                      }
                    }).done(function (data) {
                      
                      $.pjax.reload({container: '#' + $.trim(pjaxContainer)});
                      $.pjax.reload({container: '#' + $.trim(pjaxContainer2)});
                      window.location.href = 'index.php?r=optativas%2Fclase%2Fview&id='+ clase;

                      //alert('La operación se realizó correctamente');
                    });
    
              
  });

"); ?>




<div class="matricula-index">

    
<?php 


Pjax::begin(['id' => 'test', 'timeout' => 5000]); 
    
    

Pjax::end();
 ?>

    
</div>
<!--
<a
    href="index.php?r=optativas%2Fclase%2Fviewgrid&id=<?=$clase; ?>"
    target="v"
    onclick="window.open('', 'v', 'width=950,height=600');" >
    Cambiar Vista
</a>-->

<div class="row">
 <?php 
 Pjax::begin(['id' => 'test2', 'timeout' => 5000]);
 echo $echodiv; 
    Pjax::end();
 ?>

</div>
<div class="pull-right">
    <?=Html::a(
                '<span class="glyphicon glyphicon-ok"></span> Confirmar Ausentes',
                false,
                [
                    'class' => 'btn btn-primary',
                    'id' => 'btnausentes',
                    'delete-url'     => '/parte/procesarmarcadosreg',
                    'pjax-container' => 'test',
                    
                ]
            );
    ?>
</div>
