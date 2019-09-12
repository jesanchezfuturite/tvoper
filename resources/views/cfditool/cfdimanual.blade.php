@extends('layout.app')

@section('content')

<h3 class="page-title"> CFDI - Manual<small></small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">CFDI</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Captura para CFDI</a>
        </li>
    </ul>
</div>

<div class="row d-inline-block">
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption">
				<i class="icon-equalizer font-blue-sunglo"></i>
				<span class="caption-subject font-blue-sunglo bold uppercase"> Captura de CFDI</span>
			</div>
		</div>
		<div class="portlet-body form">
			<form action="#" class="form-horizontal" method="POST" id="formCFDI">
				<div class="form-body">
					<h3 class="form-section">Datos del Contribuyente</h3>
					<div class="form-group">						
						<label for="" class="col-md-3 control-label">RFC</label>
						<div class="col-md-4">
							<div class="input-group" style="text-align: left;">
								<span class="input-group-addon"><i class="fa fa-bookmark"></i></span>
								<input name="rfc" id="rfc" type="text" class="form-control" placeholder="Contribuyente" onkeyup="this.value = this.value.toUpperCase();">		
								<span class="input-group-btn"><a class="btn blue" id="btnVrfc"><i class="fa fa-search"></i> Verificar </a></span>					
							</div>					
							<span class="help-block">Este dato es requerido.</span>
						</div>								
					</div>
					<div class="form-group">						
						<label for="" class="col-md-3 control-label">Nombre</label>
						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input id="nombre" name="nombre" type="text" class="form-control" placeholder="Contribuyente">								
							</div>
						</div>
					</div>
					<div class="form-group">						
						<label for="" class="col-md-3 control-label">Apellido Paterno</label>
						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input id="apaterno" name="apaterno" type="text" class="form-control" placeholder="Contribuyente">								
							</div>
						</div>
					</div>
					<div class="form-group">						
						<label for="" class="col-md-3 control-label">Apellido Materno</label>
						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input id="amaterno" name="amaterno" type="text" class="form-control" placeholder="Contribuyente">								
							</div>
						</div>
					</div>
					<div class="form-group">						
						<label for="" class="col-md-3 control-label">Email</label>
						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
								<input id="email" name="email" type="text" class="form-control" placeholder="Contribuyente" readonly="true">
							</div>
						</div>
					</div>
					<h3 class="form-section">Datos del CFDI</h3>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">						
								<label for="" class="col-md-3 control-label">Calle</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-road"></i></span>
									<input id="calle" name="calle" type="text" class="form-control" placeholder="Contribuyente" readonly="true">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">						
								<label for="" class="col-md-3 control-label">No. Exterior</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-bell"></i></span>
									<input id="noext" name="noext" type="text" class="form-control" placeholder="Contribuyente" readonly="true">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">						
								<label for="" class="col-md-3 control-label">Colonia</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-globe"></i></span>
									<input id="colonia" name="colonia" type="text" class="form-control" placeholder="Contribuyente" readonly="true">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">						
								<label for="" class="col-md-3 control-label">No. Interior</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-bell"></i></span>
									<input id="noint" name="noint" type="text" class="form-control" placeholder="Contribuyente" readonly="true">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">						
								<label for="" class="col-md-3 control-label">Metodo de Pago</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-bookmark"></i></span>
									<select id="mp" name="mp" class="form-control" placeholder="Contribuyente">
										@foreach($formaspago as $fpk => $fp)
										<option value="{{ $fpk }}">{{ $fp }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">						
								<label for="" class="col-md-3 control-label">Formas de Pago</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-bookmark"></i></span>
									<input id="fp" name="fp" type="text" class="form-control" value="PAGO EN UNA SOLA EXHIBICION" readonly="true">
								</div>
							</div>
						</div>
					</div>
					<h3 class="form-section">Detalle del CFDI</h3>
					<div class="row" id="details">
						
						<div class="col-md-6">
							<div class="form-group">
								<label for="" class="col-md-3 control-label">Cantidad</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-bookmark"></i></span>
									<input name="qty[]" type="text" class="form-control" value="1" readonly="true">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-md-3 control-label">Unidad</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-bookmark"></i></span>
									<input name="uni[]" type="text" class="form-control" value="Servicio" readonly="true">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-md-3 control-label">Precio Unitario</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-usd"></i></span>
									<input name="pru[]" type="text" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-md-3 control-label">Total</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-usd"></i></span>
									<input name="ttl[]" type="text" class="form-control">
								</div>
							</div>							
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="" class="col-md-3 control-label">Concepto</label>
								<div class="input-group">
									<textarea class="form-control" name="con[]" maxlength="255" rows="10" cols="80"></textarea>
								</div>
							</div>
						</div>

					</div>
					<br><br>
					<div class="col text-center">
						<button class="btn btn-success" id="btnAdd" type="button">Agregar</button>								
					</div>									
				</div>				
			</form>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">    

    $.validator.addMethod("RFC", function (value, element) {
        if (value !== '') {
            var patt = new RegExp("^[A-Z,Ñ,&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9][A-Z,0-9]?[A-Z,0-9]?[0-9,A-Z]?$");
            
            return patt.test(value);
        } else {
            return false;
        }
    }, "Ingrese un RFC valido");

	$('#formCFDI').validate({
		rules: {
	        rfc: {
	            required: true,
	            RFC: true
	        }
	    },
	    messages:{
	        rfc: ""
	    },
	    submitHandler: function(){
	    	var rfc = $('#rfc').val();

	    	$.ajax({
	    		method:"POST",
	    		beforeSend: function() {

	    		},
	    		url: "{{ url('/cfdi-manual/busca-rfc') }}",
	    		data: { rfc: rfc, _token: '{{ csrf_token() }}' }
	    	})
	    	.done(function(data){
	    		console.log(data);
	    	});
		},
	    highlight: function (element) {
	        $("#rfc").css('border','1px solid red')
	    },
	    unhighlight: function (element) {
	        $("#rfc").css('border','0px solid black')
	    }
	});

	$('#btnVrfc').on('click',function(){

		var rfc = $('#rfc').val();

		if(rfc.length>0){
			$.ajax({
	    		method:"POST",
	    		beforeSend: function() {
	    			$('#btnVrfc').html('');
	    			$('#btnVrfc').removeClass('red').removeClass('blue').removeClass('green').addClass('yellow')
	    			$('#btnVrfc').append($('<i>').addClass('fa fa-warning')).append(' Verificando... ');
	    		},
	    		url: "{{ url('/cfdi-manual/busca-datos') }}",
	    		data: { rfc: rfc, _token: '{{ csrf_token() }}' }
	    	})
	    	.done( function(data){

	    		var info = JSON.parse(data);

	    		if($.isEmptyObject(info)){
	    			$('#btnVrfc').html('');
	    			$('#btnVrfc').removeClass('blue').removeClass('green').removeClass('yellow').addClass('red');
    				$('#btnVrfc').append($('<i>').addClass('fa fa-remove')).append(' No encontrado ');
	    		}
	    		else{

	    			$('#btnVrfc').html('');
	    			$('#btnVrfc').removeClass('blue').removeClass('green').removeClass('yellow').addClass('green');
    				$('#btnVrfc').append($('<i>').addClass('fa fa-check')).append(' Encontrado ');
    				$('#nombre').val(info.nombres);
    				$('#apaterno').val(info.apellido_paterno);
    				$('#amaterno').val(info.apellido_materno);
    				$('#email').val(info.email);
    				$('#calle').val(info.calle);
    				$('#noint').val(info.num_interior);
    				$('#noext').val(info.num_exterior);
    				$('#colonia').val(info.colonia);
	    		}
	    	});	

		}
		else{
			alert('El RFC es requerido');
		}
	});

	$('#btnAdd').on('click',function(){

		$('#details')
			.append($('<div>').addClass('col-md-6').css({'margin-bottom':'20px','margin-top':'15px','width':'100%','height':'1px','border-top':'1px solid #B2B2B2'}))
			.append($('<div>').addClass('col-md-6')
				.append($('<div>').addClass('form-group	')
					.append($('<label>').addClass('col-md-3 control-label').html('Cantidad'))
					.append($('<div>').addClass('input-group')
						.append($('<span>').addClass('input-group-addon')
							.append($('<i>').addClass('fa fa-bookmark')))
						.append($('<input>').addClass('form-control').attr({name:'qty[]',readonly:true}).val('1'))))
				.append($('<div>').addClass('form-group')
					.append($('<label>').addClass('col-md-3 control-label').html('Unidad'))
					.append($('<div>').addClass('input-group')
						.append($('<span>').addClass('input-group-addon')
							.append($('<i>').addClass('fa fa-bookmark')))
						.append($('<input>').addClass('form-control').attr({name:'uni[]',readonly:true}).val('Servicio'))))
				.append($('<div>').addClass('form-group')
					.append($('<label>').addClass('col-md-3 control-label').html('Precio Unitario'))
					.append($('<div>').addClass('input-group')
						.append($('<span>').addClass('input-group-addon')
							.append($('<i>').addClass('fa fa-usd')))
						.append($('<input>').addClass('form-control').attr({name:'pru[]'}))))
				.append($('<div>').addClass('form-group')
					.append($('<label>').addClass('col-md-3 control-label').html('Total'))
					.append($('<div>').addClass('input-group')
						.append($('<span>').addClass('input-group-addon')
							.append($('<i>').addClass('fa fa-usd')))
						.append($('<input>').addClass('form-control').attr({name:'ttl[]'}))))
			)
			.append($('<div>').addClass('col-md-6')
				.append($('<div>').addClass('form-group')
					.append($('<label>').addClass('col-md-3 control-label').html('Concepto'))
					.append($('<div>').addClass('input-group')
						.append($('<textarea>').addClass('form-control').attr({maxlength:"255",rows:"10",cols:"80",name:'con[]'})))));
	});

</script>
@endsection