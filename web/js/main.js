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
	$('#modalButtonNombramiento').click(function(){
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
	$('.modalaReporteHoras').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		
		
	})
});
