
<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listado de docentes en horario';

?>

<?php echo file_get_contents($_GET['url']); 

$legajo = substr($_GET['url'],-5);

?>

<?php $this->registerJs('

iframeBody = document.getElementsByClassName ("container")[1].innerText;

hastafecha = iframeBody.split("Documento")[0].split(" ");

fecha = hastafecha[hastafecha.length-1].trim();


var fechaarr = fecha.split("-");
fecha = fechaarr[2]+"-"+fechaarr[1]+"-"+fechaarr[0];

var updateDate     = "index.php?r=agente/updatedate";
$.ajax({
                      url:   updateDate,
                      type:  "get",
                      data: {id: '.$legajo.', fecha: fecha},
                      
                      error: function (xhr, status, error) {
                        alert(error);
                      }
                    }).done(function (data) {
                      window.location.href = "index.php?r=agente";
                      //console.log(data);
                    });

');

?>