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
								<button type="button" class="btn btn-secondary" onclick="quitar()">
									<i class="fa fa-angle-double-left"></i>
								</button>
								<button type="button" class="btn btn-secondary" onclick="agregar()">
									<i class="fa fa-angle-double-right"></i>
								</button>
							</div>
						</div>
						<div class="col-md-4 col-ms-12">
							<div class="form-group">
								<select class="form-control" name="divisasSelectAgregadas" id="divisasSelectAgregadas" multiple  size="8">

								</select>
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
		$.ajax({
		   method: "get",
		   url: "{{ url('/obtener-divisas') }}",
		   data: {_token:'{{ csrf_token() }}'}  })
		.done(function (response) {
			console.log( response )
			//let divisas =  JSON.parse( response ).response;
			
			divisas=$.parseJSON(response).response;
			dibujarSelectDivisas(  );
			dibujarSelectDivisasAgregadas();

		})
		.fail(function( msg ) {
		 Command: toastr.warning("No Success", "Notifications")  });
	}

	function agregar(){
		let divisasAgregadasValue = $("#divisasSelect").val();
		
		let indiceELIMINADOS = [];

		divisas.forEach( (divisa, index) => { 
			if(divisasAgregadasValue.includes(divisa.parametro)){
				divisasAgregadas.push(divisa);
				indiceELIMINADOS.push(index);
			} 
		});

		indiceELIMINADOS.forEach( indice =>{
			divisas.splice(indice,1);
		}); 
		
		http://10.153.144.228/save-divisas

		dibujarSelectDivisas(  );
		dibujarSelectDivisasAgregadas();

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
		let divisasEliminadasValue = $("#divisasSelectAgregadas").val();
		
		let indices = [];

		divisasAgregadas.forEach( (divisa, index) => { 
			if(divisasEliminadasValue.includes(divisa.parametro)){
				divisas.push(divisa);
				indices.push(index);
			} 
		});

		indices.forEach( indice =>{
			divisasAgregadas.splice(indice,1);
		}); 
		
		dibujarSelectDivisas(  );
		dibujarSelectDivisasAgregadas();

	}
</script>

@endsection
