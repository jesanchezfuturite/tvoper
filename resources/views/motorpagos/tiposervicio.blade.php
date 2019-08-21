@extends('layout.app')

@section('content')
<h3 class="page-title">Motor de pagos <small>Tipo Tramite</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Motor de pagos</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Tipo Tramite</a>
        </li>
    </ul>
</div>

<div class="row">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption" id="headerTabla">
                  <div id="borraheader">  <i class="fa fa-cogs">&nbsp; </i>Tipos Tramite</div>
                </div>
                <div class="tools" id="removeBanco">
                    <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="Agregar Cuenta">
                    </a>
                   <a id="Remov" href="javascript:;" data-original-title="" title="Desactivar Banco"><i class='fa fa-remove' style="color:white !important;"></i>
                        </a>
                    
                </div>
            </div>
            <div class="portlet-body">

            	 <button class="btn green" data-toggle="modal" href="#static2">Agregar</button>
                <div class="table-scrollable">
                    <table class="table table-hover" id="table">
                    <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Origen URL</th>
                        <th>Descripcion gpm</th>
                        <th>Tipo Referencia</th>
                        <th>Limite Referencia</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>                   
                    <tr>
                     <td><span class="help-block">No Found</span></td>
                    </tr>                    
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
</div>
<div id="static2" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h3 class="form-section">Tipo Tramite</h3>
            </div>
            <div class="modal-body">
              <div class="tabbable-line boxless tabbable-reversed">
						<!--<form class="horizontal-form">-->
							<input hidden="true" type="text" name="idupdate" id="idupdate" class="idupdate">
											<div class="form-body">
												
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Descripcion</label>
															<input type="text" name="descripcion"class="form-control"id="descripcion" placeholder="Escribe una Descripcion..." autocomplete="off" >
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Origen URL</label>
															<input type="text" name="origen"class="form-control"id="origen" placeholder="Escribe la url..." autocomplete="off" >
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Gpo Trans</label>
															<input type="text" name="" class="form-control"  id="Gpo" placeholder="Escribe..." autocomplete="off" >
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Gpm</label>
															<input type="text" name="gpm"class="form-control"id="gpm" placeholder="Escribe..." autocomplete="off" >
														</div>
													</div>
													<!--/span-->
												</div>
												<div class="row">
													
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Gpm Descripcion</label>
															<input type="text" name="gpmdescripcion"class="form-control"id="gpmdescripcion" placeholder="Escribe..." autocomplete="off" >
														</div>
													</div>
													<!--/span-->
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Tipo Referencia</label>
																<select id="tiporeferencia" class="select2me form-control">
                                  									<option value="limpia">-------</option>
																</select>
																<span class="help-block">
																Seleccione una Opcion </span>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Limite Referencia</label>

																<select id="limiterefencia" class="select2me form-control">
                                  									<option value="limpia">-------</option>
																</select>
																<span class="help-block">
																Seleccione una Opcion </span>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
											</div>
											<div class="form-actions left">
												<!--<button type="button" class="btn default">Cancel</button>-->
												<button type="submit" class="btn blue" onclick="metodo()"><i class="fa fa-check"></i> Guardar</button>
											</div>
										<!--</form>-->
									</div>
								</div>
								<div class="modal-footer">
         				<button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cerrar</button>
            	</div>
            </div>            
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script type="text/javascript">
	jQuery(document).ready(function() {
        findLimiteReferencia();
    });
	function findLimiteReferencia()
	{
		$.ajax({
           method: "get",           
           url: "{{ url('/limite-referencia-fin-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          var Resp=$.parseJSON(response);
           $("#limiterefencia option").remove();
         $('#limiterefencia').append(
            "<option value='limpia'>------</option>"
        );
        $.each(Resp, function(i, item) {                
            $('#limiterefencia').append(
                "<option value='"+item.id+"'>"+item.descripcion+" "+item.periodicidad+" "+item.vencimiento+"</option>"
                );
            });
      	})
        .fail(function( msg ) {
         console.log("Error al Cargar select Option Limite Referencia");  });
	}

	function findTipoReferencia()
	{
		$.ajax({
           method: "get",           
           url: "{{ url('/limite-referencia-fin-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          var Resp=$.parseJSON(response);
           $("#tiporeferencia option").remove();
         $('#tiporeferencia').append(
            "<option value='limpia'>------</option>"
        );
        $.each(Resp, function(i, item) {                
            $('#tiporeferencia').append(
                "<option value='"+item.id+"'>"+item.descripcion+" "+item.periodicidad+" "+item.vencimiento+"</option>"
                );
            });
      	})
        .fail(function( msg ) {
         console.log("Error al Cargar select Option Limite Referencia");  });
    
	}
</script>
@endsection
