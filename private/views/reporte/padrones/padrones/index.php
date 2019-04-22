<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-list-alt"></span> Padrones Docentes</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                      <div class="col-xs-6 col-md-6">
                        <ol class="breadcrumb">
                          <center>Secundario</center>
                        </ol>
                      </div>
                      <div class="col-xs-6 col-md-6">
                        <ol class="breadcrumb">
                          <center>Pregrado</center>
                        </ol>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-md-6">
                          <a href="index.php?r=reporte/padrones/padrones/docentes&prop=1" class="btn btn-info btn-lg" role="button"> <?= $cantidaddocentessecundario ?><br/>Profesores</a>
                          <a href="index.php?r=reporte/padrones/padrones/preceptores&prop=1" class="btn btn-warning btn-lg" role="button"><?= $cantidadpreceptoressecundario ?> <br/>Preceptores</a>
                          <a href="index.php?r=reporte/padrones/padrones/jefespreceptor&prop=1" class="btn btn-primary btn-lg" role="button"><?= $cantidadjefessecundario ?> <br/>Jefes</a>
                          <a href="index.php?r=reporte/padrones/padrones/otrosdocentes&prop=1" class="btn btn-success btn-lg" role="button"><?= $cantidadotrosdocentessec ?> <br/>Otros Docentes</a>
                        </div>
                        <div class="col-xs-6 col-md-6">
                          <a href="index.php?r=reporte/padrones/padrones/docentes&prop=2" class="btn btn-info btn-lg" role="button"><?= $cantidaddocentespregrado ?> <br/>Profesores</a>
                          <a href="index.php?r=reporte/padrones/padrones/preceptores&prop=2" class="btn btn-warning btn-lg" role="button"><?= $cantidadpreceptorespregrado ?> <br/>Preceptores</a>
                          <a href="index.php?r=reporte/padrones/padrones/jefespreceptor&prop=2" class="btn btn-primary btn-lg" role="button"><?= $cantidadjefespregrado ?> <br/>Jefes</a>
                          <a href="index.php?r=reporte/padrones/padrones/otrosdocentes&prop=2" class="btn btn-success btn-lg" role="button"><?= $cantidadotrosdocentespre ?> <br/>Otros Docentes</a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
