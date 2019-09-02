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
			<form action="#" class="form-horizontal" method="POST">
				<div class="form-body">
					<h3 class="form-section">Datos del Contribuyente</h3>
					<div class="form-group">						
						<label for="" class="col-md-3 control-label">RFC</label>
						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-bookmark"></i></span>
								<input name="rfc" type="text" class="form-control" placeholder="Contribuyente">
							</div>
							<span class="help-block">Este dato es requerido.</span>
						</div>
					</div>
					<div class="form-group">						
						<label for="" class="col-md-3 control-label">Nombre</label>
						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input name="nombre" type="text" class="form-control" placeholder="Contribuyente">
							</div>
						</div>
					</div>
					<div class="form-group">						
						<label for="" class="col-md-3 control-label">Email</label>
						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
								<input name="email" type="text" class="form-control" placeholder="Contribuyente" readonly="true">
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
									<input name="calle" type="text" class="form-control" placeholder="Contribuyente" readonly="true">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">						
								<label for="" class="col-md-3 control-label">No. Exterior</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-bell"></i></span>
									<input name="noext" type="text" class="form-control" placeholder="Contribuyente" readonly="true">
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
									<input name="colonia" type="text" class="form-control" placeholder="Contribuyente" readonly="true">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">						
								<label for="" class="col-md-3 control-label">No. Interior</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-bell"></i></span>
									<input name="noint" type="text" class="form-control" placeholder="Contribuyente" readonly="true">
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
									<select name="mp" class="form-control" placeholder="Contribuyente">
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
									<input name="fp" type="text" class="form-control" value="PAGO EN UNA SOLA EXHIBICION" readonly="true">
								</div>
							</div>
						</div>
					</div>
					

					
										
				</div>				
			</form>
		</div>
	</div>
</div>

@endsection

@section('scripts')

@endsection