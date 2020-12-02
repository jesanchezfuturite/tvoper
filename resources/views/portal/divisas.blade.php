@extends('layout.app')

@section('content')
<h3 class="page-title">Portal <small>Asignación de campos por trámite</small></h3>
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="index.html">Home</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<a href="#">Portal</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<a href="#">Divisas</a>
		</li>
	</ul>
</div>
<!--
<div class="row">
	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-users"></i>Lista de usuarios
			</div>
		</div>
		<div class="portlet-body">
			<div class="form-body">
				<div class="row">
					<div class="col-md-3 col-ms-12">
						<div class="form-group">
							<select class="select2me form-control" name="usuarios" id="usuarios" onchange="changeTramites()">
								<option value="limpia">------</option>

							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>-->
<div class="row">
		<!-- BEGIN SAMPLE TABLE PORTLET-->
		<div class="portlet box blue">
			<div class="portlet-title">

				<div class="caption" id="headerTabla">
					<i class="fa fa-cogs"></i>&nbsp;<span id="divisas">Divisas</span> &nbsp;
					<!--    <span class="label label-sm label-danger">
							<label id='changeStatus'>No found</label>
						</span>&nbsp;&nbsp;&nbsp;&nbsp;
						--->

				</div>
				<div class="tools" id="divisasTools">
					<!--
					<a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="Agregar Cuenta">
					</a>
				   <a id="Remov" href="javascript:;" data-original-title="" title="Desactivar Tramite" onclick="desactivaTramite()"><i class='fa fa-remove' style="color:white !important;"></i>
					</a>-->
				</div>
			</div>
			<div class="portlet-body" id="Removetable">
				<div class="form-body">
					<div class="row">
						<div class="col-md-4 col-ms-12">
							<div class="form-group">
								<select class="form-control" name="divisasSelect" id="divisasSelect" multiple  size="8">

								</select>
							</div>
						</div>
						<div class="col-md-4 text-center" style="margin-top: 5%;">
							<div class="btn-group" role="group" aria-label="Basic example">
								<button type="button" class="btn btn-secondary" onclick="quitar()" id="btnEliminar">
									<i class="fa fa-angle-double-left"></i>
								</button>
								<button type="button" class="btn btn-secondary" onclick="agregar()" id="btnAgregar">
									<i class="fa fa-angle-double-right" ></i>
								</button>
							</div>
						</div>
						<div class="col-md-4 col-ms-12">
				
							<div class="form-group">

								<select class="form-control" name="divisasSelectAgregadas" id="divisasSelectAgregadas" multiple  size="8">

								</select>
							</div>
							<div class="text-center">
								<i class="fa fa-spin fa-spinner" id="iconAgregadas" style="display: none;"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END SAMPLE TABLE PORTLET-->

</div>
@endsection

@section('scripts')
<script>
	let divisas = []; 
	let divisasAgregadas = [];

	jQuery(document).ready(function() {
		getDivisas();
	});
	 /*$( function() {
		$( "#sortable" ).sortable();
		$( "#sortable" ).disableSelection();
	  
	} );*/
	
	function getDivisas()
	{
		

		$("#iconAgregadas").fadeIn();
		let ajaxDivisas = $.ajax({
			dataType: "json",
		   	method: "get",
		   	url: "{{ url('/obtener-divisas') }}",
		   	data: {_token:'{{ csrf_token() }}'}  })

		let ajaxDivisasGuardadas = $.ajax({
			dataType: "json",
		   	method: "get",
		   	url: "{{ url('/get-divisas-save') }}",
		   	data: {_token:'{{ csrf_token() }}'}  });


		$.when(ajaxDivisas, ajaxDivisasGuardadas).then( (respuesta1, respuesta2) => {
			divisas =   respuesta1[0].response;
			divisasAgregadas =   respuesta2[0].response.divisas;
		 	divisas = divisas.filter(divisa => {  
		 		return !divisasAgregadas.find( agregada => agregada.parametro == divisa.parametro );
		 	});

		}).always( () =>{
			$("#iconAgregadas").fadeOut();
			dibujarSelectDivisas(  );
			dibujarSelectDivisasAgregadas();
		});
	}

	function agregar(){
		$("#btnAgregar").attr("disabled", true);
		
		
		let divisasAgregadasValue = $("#divisasSelect").val();
		
		let nuevasDivisas = [];


		divisas.forEach( (divisa, index) => { 
			if(divisasAgregadasValue.includes(divisa.parametro)){
				nuevasDivisas.push(divisa);
			} 
		});

 		$.ajax({
           	method: "POST",
           	url: "{{ url('/save-divisas') }}",
           	data: {divisas:nuevasDivisas,_token:'{{ csrf_token() }}'}  })
        	.done( (response) => {
        		getDivisas();
        	})
        .fail(function( msg ) {
        	 Command: toastr.warning("No Success", "Notifications")  
     	}).always( () => {
     		$("#btnAgregar").attr("disabled", false);

     	});

	}

	function dibujarSelectDivisas(){
		$("#divisasSelect option").remove();
		$.each(divisas, function(i, item) {
			$("#divisasSelect").append("<option value='"+item.parametro+"'>"+item.descripcion+"</option>");
		});
	}

	function dibujarSelectDivisasAgregadas(){
		$("#divisasSelectAgregadas option").remove();
		$.each(divisasAgregadas, function(i, item) {
			$("#divisasSelectAgregadas").append("<option value='"+item.parametro+"'>"+item.descripcion+"</option>");
		});
	}

	function quitar(){
		$("#btnEliminar").attr("disabled", true);
		
		let divisasEliminadas= [];
		let divisasEliminadasValue = $("#divisasSelectAgregadas").val();
		

		divisasAgregadas.forEach( (divisa, index) => { 
			if(divisasEliminadasValue.includes(divisa.parametro)){
				divisasEliminadas.push(divisa);
			} 
		});

 		$.ajax({
           	method: "POST",
           	url: "{{ url('/delete-divisas') }}",
           	data: {divisas:divisasEliminadas,_token:'{{ csrf_token() }}'}  })
        	.done( (response) => {
        		getDivisas();
        	})
        .fail(function( msg ) {
        	 Command: toastr.warning("No Success", "Notifications")  
     	}).always( () => {
     		$("#btnEliminar").attr("disabled", false);
     	});

	}
</script>

@endsection
