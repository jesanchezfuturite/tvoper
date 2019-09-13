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
					<div class="row">
						<div class="col-md-6">
							<h3 class="form-section">Datos del Contribuyente</h3>
							<div class="form-group" style="text-align: center;">
								<label for="" class="col-md-3 control-label">RFC</label>
								<div class=" col-md-8 input-group" >
									<span class="input-group-addon"><i class="fa fa-user"></i></span>
									<input name="rfc" id="rfc" type="text" class="form-control" placeholder="Contribuyente" onkeyup="this.value = this.value.toUpperCase();">
									<span class="input-group-btn"><a class="btn blue" id="btnVrfc"><i class="fa fa-search"></i> Verificar </a></span>
								</div>
								<span class="help-block">Este dato es requerido.</span>
							</div>
							<div class="form-group">
								<label for="" class="col-md-3 control-label">Nombre</label>
								<div class=" col-md-8 input-group">
									<span class="input-group-addon"><i class="fa fa-user"></i></span>
									<input name="nombre" id="nombre" type="text" class="form-control" placeholder="Contribuyente">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-md-3 control-label">Apellido Paterno</label>
								<div class=" col-md-8 input-group">
									<span class="input-group-addon"><i class="fa fa-user"></i></span>
									<input name="apaterno" id="apaterno" type="text" class="form-control" placeholder="Contribuyente">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-md-3 control-label">Apellido Materno</label>
								<div class=" col-md-8 input-group">
									<span class="input-group-addon"><i class="fa fa-user"></i></span>
									<input name="amaterno" id="amaterno" type="text" class="form-control" placeholder="Contribuyente">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-md-3 control-label">E-mail</label>
								<div class=" col-md-8 input-group">
									<span class="input-group-addon"><i class="fa fa-at"></i></span>
									<input name="email" id="email" type="text" class="form-control" placeholder="Contribuyente">
								</div>
							</div>

						</div>
						<div class="col-md-6">
							<h3 class="form-section">Datos del CFDI</h3>
							<div class="form-group">
								<label for="" class="col-md-3 control-label">Calle</label>
								<div class=" col-md-8 input-group">
									<span class="input-group-addon"><i class="fa fa-road"></i></span>
									<input name="calle" id="calle" type="text" class="form-control" placeholder="Contribuyente">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-md-3 control-label">Numero</label>
								<div class="col-md-4">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-bell"></i></span>
										<input name="noext" id="noext" type="text" class="form-control" placeholder="Exterior">
									</div>								
								</div>
								<div class="col-md-4">									
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-bell"></i></span>
										<input name="noint" id="noint" type="text" class="form-control" placeholder="Interior">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-md-3 control-label">Colonia</label>
								<div class=" col-md-8 input-group">
									<span class="input-group-addon"><i class="fa fa-globe"></i></span>
									<input name="colonia" id="colonia" type="text" class="form-control" placeholder="Contribuyente">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-md-3 control-label">Metodo de Pago</label>
								<div class=" col-md-8 input-group">
									<span class="input-group-addon"><i class="fa fa-bookmark"></i></span>
									<select id="mp" name="mp" class="form-control" placeholder="Contribuyente" >
                                        @foreach($formaspago as $fpk => $fp)
                                        <option value="{{ $fpk }}">{{ '[ '.$fpk.' ]  -- ' . strtoupper($fp) }}</option>
                                        @endforeach
                                    </select>
                                    <!-- <span class="input-group-addon" id="sp-mp"></span>    -->
								</div>
								
							</div>
							<div class="form-group">
								<label for="" class="col-md-3 control-label">Forma de Pago</label>
								<div class=" col-md-8 input-group">
									<span class="input-group-addon"><i class="fa fa-bookmark"></i></span>
									<input id="fp" name="fp" type="text" class="form-control" value="PAGO EN UNA SOLA EXHIBICION" readonly="true">
								</div>
							</div>
						</div>
					</div>
					<h3 class="form-section">Detalle del CFDI</h3>
					<div class="table-scrollable">
	                    <table class="table table-striped table-bordered table-hover" id="details">
	                        <thead>
	                            <tr class="row">
	                                <th>Cantidad</th>
	                                <th>Unidad</th>
	                                <th>Precio Unitario</th>
	                                <th>Total</th>
	                                <th>Concepto</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	<tr class="row">
	                        		<td><input name="qty[]" type="text" class="form-control" value="1" readonly="true"></td>
	                        		<td><input name="uni[]" type="text" class="form-control" value="SERVICIO" readonly="true"></td>
	                        		<td><input name="pru[]" type="text" class="form-control currency"></td>
	                        		<td><input name="ttl[]" type="text" class="form-control currency"></td>
	                        		<td><input name="con[]" type="text" class="form-control"></td>
	                        	</tr>
	                        </tbody>
	                    </table>
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

    $('.currency').on('keypress',function(event) {

	    if(event.which < 46 || event.which > 59) {
	        event.preventDefault();
	    } // prevent if not number/dot

	    if(event.which == 46 && $(this).val().indexOf('.') != -1) {
	        event.preventDefault();
	    } // prevent if already dot
	});

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
		$('#nombre').val();
		$('#apaterno').val();
		$('#amaterno').val();
		$('#email').val();
		$('#calle').val();
		$('#noint').val();
		$('#noext').val();
		$('#colonia').val();

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

		var row = $('<tr>').addClass('row')
			.append($('<td>').append($('<input>').attr({readonly:true,value:1,name:'qty[]'}).addClass('form-control')))
			.append($('<td>').append($('<input>').attr({readonly:true,value:'SERVICIO',name:'uni[]'}).addClass('form-control')))
			.append($('<td>').append($('<input>').attr({name:'pru[]'}).addClass('form-control')))
			.append($('<td>').append($('<input>').attr({name:'ttl[]'}).addClass('form-control')))
			.append($('<td>').append($('<input>').attr({name:'con[]'}).addClass('form-control')))
			


		$('#details > tbody').append(row);
			
	});

</script>
@endsection