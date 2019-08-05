@extends('layout.app')

@section('content')
<h3 class="page-title"> Configuración de motor de pagos <small>Limite Referencia</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Configuración de motor de pagos</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Limite Referencia</a>
        </li>
    </ul>
</div>
<div class="col-md-12">
	<div class="tabbable-line boxless tabbable-reversed">
						
		<div class="tab-content">
			<div class="tab-pane active" id="tab_0">
				<div class="portlet box green">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-gift"></i>Registro
						</div>										
					</div>
					<div class="portlet-body form">
					<!-- BEGIN FORM-->
				<div class="row">
				<div class="col-md-12">
					<div class="tabbable-line boxless tabbable-reversed">
						<!--<form class="horizontal-form">-->
											<div class="form-body">
												<h3 class="form-section">Limite Referencia</h3>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Descripcion</label>
															<textarea class="form-control" rows="3" id="descripcion" placeholder="Escribe una Descripción"></textarea>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Periodicidad</label>
																<select id="periodicidad" class="select2me form-control">
																	<option value="Mesual">Mesual</option>
																	<option value="Trimestral">Trimestral</option>
																</select>
																<span class="help-block">
																Seleccione una Opcion </span>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												<div class="row">
													
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Fecha Vencimiento</label>
															<input id="datetime1" class="form-control form-control-inline input-medium date-picker" size="16" type="datetime" value="" placeholder="dd/mm/yyy">
															<span class="help-block">Seleccione una Fecha</span>

														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
											</div>
											<div class="form-actions left">
												<!--<button type="button" class="btn default">Cancel</button>-->
												<button type="submit" class="btn blue" onclick="guardar()"><i class="fa fa-check"></i> Guardar</button>
											</div>
										<!--</form>-->
									</div>
								</div>
							</div>
						<!-- END FORM-->
					</div>
				</div>								
			</div>							
		</div>
	</div>
</div>
<!----  #tabla -->
<div class="row">
	<div class="col-md-12">				
		<div class="portlet box red-intense">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-globe"></i>Registros
				</div>
			</div>
		<div class="portlet-body">
			<table class="table table-striped table-bordered table-hover" id="sample_2">
				<thead>
					<tr>
						<th hidden>id</th>
						<th>Descripción</th>
						<th>Periodicidad</th>							
						<th>Vencimiento</th>							
					</tr>
				</thead>
				<tbody>							
					 @foreach( $saved_days as $sd)
                        <tr>
                            <td hidden>{{$sd["id"]}}</td>
                            <td>{{$sd["descripcion"]}}</td>
                            <td>{{$sd["periodicidad"]}}</td>
                            <td>{{$sd["vencimiento"]}}</td>
                        </tr>
                        @endforeach
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
	jQuery(document).ready(function() {       
       ComponentsPickers.init();
       TableAdvanced.init();

    });

function guardar()
{
var date = $("#datetime1").datepicker("getDate");
var description=$("#descripcion").val();
var periodicidad=$("#periodicidad").val();
alert(date+description+periodicidad);
}
</script>
@endsection