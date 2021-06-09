$(function(){
	$('#modalButton').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
			document.getElementById('modalHeader').innerHTML ='Agregar Docente a Catedra';
	})
});

$(function(){
	$('.modala').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Modificar Docente de Catedra';
	})
});

$(function(){
	$('.modalButtonNombramiento').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Asignar Suplente a Cargo';
	})
});

$(function(){
	$('.modalaNombramiento').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Modificar Nombramiento';
	})
});

$(function(){
	$('#modalaDetalleParte').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Agregar Ausencia';
	})
});

$(function(){
	$('#amodalpasividad').click(function(){
		$('#modalpasividad').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Percepción de pasividades (Jubilaciones, Pensiones, Retiros, etc.)';
	})
});
$(function(){
	$('.amodalrechazar').click(function(){
		$('#modalrechazar').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Motivo del rechazo de la Declaración jurada';
	})
});
$(function(){
	$('.amodalhorariojs').click(function(){
		$('#modalpasividad').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Carga de horario';
	})
});

$(function(){
	
	$('.amodaldetallefonid').click(function(){
		
	var inputValue = $("#docente-cuil").val();
	$.ajax({
		type: "POST",
		url: "index.php?r=fonid/savedoc",
		data: {
			cuil: inputValue
			}, 
		success: function(result) {
			
			}, 
		error: function(result) {
			
		}
	});
		$('#modaldetallefonid').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Otros establecimientos';
	})
});

$(function(){
	
	$('.amodaldetalleticket').click(function(){
		
		$('#modaldetalleticket').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		//document.getElementById('modalHeader').innerHTML ='ss';
	})
});

$(function(){
	
	$('.amodalcasoupdate').click(function(){
		$('#modalcasoupdate').modal('show').find('#modalHeader').html($(this).attr('title'));
		$('#modalcasoupdate').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		
			//.load($(this).attr('value'));
		//document.getElementById('modalHeader').innerHTML ='ss';
	})
});



$('body').on('click', '.amodalcertificado',function(){
	$('#modalcertificado').modal('show')
		.find('#modalContent2')
		.load($(this).attr('value'));
	
});

$('body').on('click', '.amodalinfoprofesional',function(){
	$('#modalinfoprofesional').modal('show')
		.find('#modalContent3')
		.load($(this).attr('value'));
	
});

$('body').on('click', '.amodalsolicitudstate',function(){
	$('#amodalsolicitudstate').modal('show').find('#modalHeader4').html($(this).attr('title'));
	$('#amodalsolicitudstate').modal('show')
		.find('#modalContent4')
		.load($(this).attr('value'));
	
});

$('body').on('click', '.amodalgenerico',function(){
	
	$('#modalgenerico').modal('show').find('#modalHeader').html($(this).attr('title'));
	$('#modalgenerico').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	
});

$(function(){
	$('.amodalgenerico').click(function(){
		
	$('#modalgenerico').modal('show').find('#modalHeader').html($(this).attr('title'));
	$('#modalgenerico').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	})
});

$('body').on('click', '.amodalagregartema',function(){

	var array = []
    
	var checkboxes = document.querySelectorAll('input[type=hidden].valtemaxx')
	
	
	$('#modalagregartema').modal('show').find('#modalHeader').html($(this).attr('title'));
	$('#modalagregartema').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	
		
	
});

$('body').on('click', '.amodalplancursado',function(){
	$('#modalplancursado').modal('show').find('#modalHeader').html($(this).attr('title'));
	$('#modalplancursado').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	
});

$('body').on('click', '.deletebuttonadjuntocert',function(){
	var id = $(this).attr('value');
	if(confirm('Desea eliminar el archivo adjunto?')){
		$.ajax({
			
			url:'index.php?r=edh/adjuntocertificacion/delete',
			method:'post',
			data:{id:$(this).attr('value')},
			success:function(data){
				$.pjax.reload({container: "#test", async: false});
			},
			error:function(jqXhr,asistio,error){
				alert(error);
			}
		});
	}
	
});


	
	$('body').on('click', '.bajarprioridad',function(){
		
	var url = $(this).attr('value');

	$.ajax({
		type: "POST",
		url: url,
		
		success: function(result) {
			$.pjax.reload({container: "#test", async: false});
			
			document.getElementById("collapse"+result).collapse('show');
			}, 
		error: function(result) {
			alert("no se");
		}
	});
		
	});

$(function(){
	$('#amodalnooficial').click(function(){
		$('#modalnooficial').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='En tareas o actividades no oficiales';
	})
});

$('body').on('click', '.amodalnuevodetalleunidad',function(){
		$('#modalviewprograma').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Nueva unidad';
	});
	

	$('body').on('click', '.amodalagregartema',function(){
		$('#modalviewprograma').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Nuevo tema';
	});


$(function(){
	$('#modalaNovedadesParte').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Agregar Novedad';
	})
});

$(function(){
	$('#modalButtonHorario').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Agregar Horario';
	})
});

$(function(){
	$('#modalaModificarNovedad').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Modificar Novedad';
	})
});

$(function(){
	$('.modalafinfe').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Pasar a historial';
	})
});

$(function(){
	$('.modalaReporteHoras').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		
		
	})
});

$(function(){
	$('.modalaReporteFaltasDocentes').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		
		
	})
});

$(document).on('shown.bs.modal', '.modal', function () {
    $(this).find('[autofocus]').focus();
});

$('body').on('click', '#modalButtonIngreso', function(e) {
	$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
			document.getElementById('modalHeader').innerHTML ='Escaneo de DNI';
			
});


$(function(){
	$('#modalButtonEgreso').click(function(){

		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
			document.getElementById('modalHeader').innerHTML ='Escaneo de Credencial';
			
	})
});

$(function(){
	$('.modalRegencia').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
			document.getElementById('modalHeader').innerHTML ='Rectificación';
	})
});

$(function(){
	$('.modalSecretaria').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
			document.getElementById('modalHeader').innerHTML ='Justificación de inasistencia';
	})
});


$(function(){
	$('#nuevoparte').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Nuevo Parte Docente';
	})
});

$('body').on('click', '#abmdivision', function(e) {
	$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
			document.getElementById('modalHeader').innerHTML ='Asignar División';
			
});

$(document).on('click', '#btnCopiar', function () {


		
        var codigoACopiar = document.getElementById('textoACopiar');    //Elemento a copiar

        //Debe estar seleccionado en la página para que surta efecto, así que...
        var seleccion = document.createRange(); //Creo una nueva selección vacía
        seleccion.selectNodeContents(codigoACopiar);    //incluyo el nodo en la selección
        //Antes de añadir el intervalo de selección a la selección actual, elimino otros que pudieran existir (sino no funciona en Edge)
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(seleccion);  //Y la añado a lo seleccionado actualmente
        try {
            var res = document.execCommand('copy'); //Intento el copiado
            if (res)
                exito();
            else
                fracaso();

            mostrarAlerta();
        }
        catch(ex) {
            excepcion();
        }
        window.getSelection().removeRange(seleccion);
   
});

    
///////
// Auxiliares para mostrar y ocultar mensajes
///////
    var divAlerta = document.getElementById('alerta');
    
    function exito() {
        divAlerta.innerText = '¡¡Código copiado!!';
        divAlerta.classList.add('alert-success');
    }

    function fracaso() {
        divAlerta.innerText = '¡¡Ha fallado el copiado al portapapeles!!';
        divAlerta.classList.add('alert-warning');
    }

    function excepcion() {
        divAlerta.innerText = 'Se ha producido un error al copiar al portapaples';
        divAlerta.classList.add('alert-danger');
    }

    function mostrarAlerta() {
        divAlerta.classList.remove('invisible');
        divAlerta.classList.add('visible');
        setTimeout(ocultarAlerta, 1500);
    }

    function ocultarAlerta() {
        divAlerta.innerText = '';
        divAlerta.classList.remove('alert-success', 'alert-warning', 'alert-danger', 'visible');
        divAlerta.classList.add('invisible');
	}
	
	
    function sendRequestBorraradjuntocertif(e, id){
        
        e.preventDefault();
        $.ajax({
            url:'index.php?r=edh/adjuntocertificacion/delete',
            method:'post',
            data:{id:id},
            success:function(data){
                //alert(data);
            },
            error:function(jqXhr,asistio,error){
                alert(error);
            }
        });
    }









