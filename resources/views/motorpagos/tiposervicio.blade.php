@extends('layout.app')

@section('content')
<link href="assets/global/css/checkbox.css" rel="stylesheet" type="text/css"/>
<h3 class="page-title">Motor de pagos <small>Configuración de Trámite</small></h3>
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
            <a href="#">Configuración de Trámite</a>
        </li>
    </ul>
</div>
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Importante:</strong> Para esta configuración debe existir un tipo de referencia y límite de referencia para llevar acabo el alta.
</div>
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Info: </strong>Esta configuración te permite dar de alta un trámite al sistema, editar o eliminar su registro. Así como también asignar el tipo de referencia y tipo de límite.
</div>
<div class="row">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box blue"id="table_1">
            <div class="portlet-title" >
                <div class="caption" id="headerTabla">
                  <div id="borraheader">  <i class="fa fa-cogs">&nbsp; </i>Tipos Tramite</div>
                  </div>
                  <div class="tools" hidden="true">
              </div>             
            </div>
            <div class="portlet-body" id="table_2">
              <div class="row">            
            <div class="col-md-1">
                <div class="form-group">
                   <button class="btn green" data-toggle="modal" href="#static2">Agregar</button>
                </div> 
            </div>
             <div class="col-md-2">
                <div class="form-group">
                   <button class="btn green" data-toggle="modal" href="#static3">Actualizar por Entidad</button>
                </div> 
            </div>  
            	                
              </div>

                <span class="help-block">&nbsp;</span>
                    <table class="table table-hover" id="sample_2">
                    <thead>
                    <tr>
                        <th>&nbsp;Entidad&nbsp;</th>
                        <th>Servicio</th>
                        <th>Origen URL</th>
                        <th>Descripcion gpm</th>
                        <th>Tipo Referencia</th>
                        <th>Limite Referencia</th>
                        <th>&nbsp;Operacion&nbsp; &nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>                   
                    @foreach( $response as $sd)
                        <tr>
                          <td>{{$sd["entidad"]}}</td>
                            <td>{{$sd["Tipo_Descripcion"]}}</td>
                            <td>{{$sd["Origen_URL"]}}</td>
                            <td>{{$sd["descripcion_gpm"]}}</td>
                            <td>{{$sd["tiporeferencia_id"]}}</td>
                            <td>{{$sd["limitereferencia_id"]}}</td>
                             <td class="text-center"><a class='btn btn-icon-only blue' href='#static2' data-toggle='modal' data-original-title='' title='static2' onclick='OperacionTramite({{$sd["Tipo_Code"]}})'><i class='fa fa-pencil'></i></a></td>
                        </tr>
                    @endforeach                  
                    </tbody>
                    </table>
               
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
															<input type="text" name="gpo" class="form-control"  id="gpo" placeholder="Escribe..." autocomplete="off" >
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
															<input type="text" name="gpmdescripcion"class="form-control"id="gpmdescripcion" row="2" placeholder="Escribe..." autocomplete="off" >
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

																<select id="limitereferencia" class="select2me form-control">
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
												<button type="submit" class="btn blue" onclick="savetramite()"><i class="fa fa-check"></i> Guardar</button>
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

<div id="static3" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar_modal()"></button>
                <h4 class="form-section">Actualizar Registros</h4>
            </div>
            <div class="modal-body">
              
              <div class="portlet-body form">
              <input hidden="true" type="text" name="idupdate" id="idupdate" class="idupdate">
                      
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="col-md-2 control-label" >Entidad</label>                       
                              <div class="col-md-9">                                             
                                <select id="optionEntidad" class="select2me form-control" onchange="changeEntidadFind()">
                                    <option value="limpia">-------</option>
                                </select>
                                <span class="help-block">
                                Seleccione una Opcion </span>
                              </div>
                            </div>
                          </div>
                        </div>                      
                    </div>
                    <div class="row">
                          <div class="col-md-12">
                             <div class="col-md-12">
                              <div class='form-group'>
                                <label class="col-md-2 control-label" >Buscar</label> 
                               <div class="col-md-6">
                                <input type="text" name="search" id="search" class="form-control" placeholder="Escribe...">
                                </div>               
                              </div>               
                              </div>               
                              <br>
                              <div  id="demo">              
                              <table class="table table-hover table-wrapper-scroll-y my-custom-scrollbar" id="table2">
                                <thead>
                                  <tr>            
                                   <th>Selecciona los Servicios</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <tr>
                                  <td>No Found</td>
                                  <td></td>
                                </tr>         
                                </tbody>
                              </table>
                            </div> 
                          </div>
                        </div>
                    <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Tipo Referencia</label>
                                <select id="tiporeferencia2" class="select2me form-control">
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

                                <select id="limitereferencia2" class="select2me form-control">
                                  <option value="limpia">-------</option>
                                </select>
                                <span class="help-block">
                                Seleccione una Opcion </span>
                            </div>
                          </div>
                          <!--/span-->
                        </div>

                      <div class="form-actions left">
                        <!--<button type="button" class="btn default">Cancel</button>-->
                        <button type="submit" class="btn blue" onclick="updateServiciosArray()"><i class="fa fa-check"></i> Guardar</button>
                      </div>                                    
                </div>
                <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar_modal()">Cerrar</button>
              </div>
            </div>            
        </div>
    </div>
</div>
<div id="static" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
             ¿Eliminar Registro?
                </p>
                 <input hidden="true" type="text" name="idvalor" id="idvalor" class="idvalor">
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="deleteTipoServicio()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script type="text/javascript">
	jQuery(document).ready(function() {
        findLimiteReferencia();
        findTipoReferencia();
        FindEntidad();
        

        TableManaged.init();         
       //TableAdvanced.init();

        
    });
  function updateServiciosArray()
  {
    var tiporeferencia=$("#tiporeferencia2").val();
    var limitereferencia=$("#limitereferencia2").val();
    let valoresCheck = [];
    $("input[type=checkbox]:checked").each(function(){
       valoresCheck.push(this.value);
    });
   if(valoresCheck.length == 0)
   {
     Command: toastr.warning("Ningun Servicio Seleccionado", "Notifications")
   }else if(limitereferencia=="limpia"){
    Command: toastr.warning("Limite Referencia Requerido", "Notifications")
   }else if(tiporeferencia=="limpia"){
    Command: toastr.warning("Tipo Referencia Requerido!", "Notifications")
   }else{
    ActualizarServicios();

   }
  }
  function ActualizarServicios()
  {
    var tiporeferencia_=$("#tiporeferencia2").val();
    var limitereferencia_=$("#limitereferencia2").val();
    let valoresCheck = [];
    $("input[type=checkbox]:checked").each(function(){
       valoresCheck.push(this.value);
    });
    $.ajax({
           method: "POST",            
           url: "{{ url('/tipo-servicio-update-array') }}",
           data: {tiporeferencia:tiporeferencia_,limitereferencia:limitereferencia_,id:valoresCheck, _token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
        if(response=="true")
        {   
        $("#tiporeferencia2").val("limpia").change();
        $("#limitereferencia2").val("limpia").change();
        $('input:checkbox').removeAttr('checked');
         
          Command: toastr.success("Success", "Notifications")
             ActualizaTabla();

        } 
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function FindEntidad()
    {
         $.ajax({
           method: "get",            
           url: "{{ url('/entidad-find') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);
          var item="";
          $("#optionEntidad option").remove();
          $("#optionEntidad").append("<option value='limpia'>-------</option>"
            );
        $.each(Resp, function(i, item) {                
               $("#optionEntidad").append("<option value='"+item.id+"'>"+item.nombre+"</option>"
            );  
        });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
	function findLimiteReferencia()
	{
		$.ajax({
           method: "get",           
           url: "{{ url('/limite-referencia-fin-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          var Resp=$.parseJSON(response);
           $("#limitereferencia option").remove();
         $('#limitereferencia').append(
            "<option value='limpia'>------</option>"
        );
         $("#limitereferencia2 option").remove();
         $('#limitereferencia2').append(
            "<option value='limpia'>------</option>"
        );
        $.each(Resp, function(i, item) {                
            $('#limitereferencia').append(
                "<option value='"+item.id+"'>"+item.descripcion+" "+item.periodicidad+" "+item.vencimiento+"</option>"
                );
                $('#limitereferencia2').append(
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
           url: "{{ url('/tipo-referencia-Find') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          var Resp=$.parseJSON(response);
           $("#tiporeferencia option").remove();
         $('#tiporeferencia').append(
            "<option value='limpia'>------</option>"
        );
          $("#tiporeferencia2 option").remove();
         $('#tiporeferencia2').append(
            "<option value='limpia'>------</option>"
        );
        $.each(Resp, function(i, item) {                
            $('#tiporeferencia').append(
                "<option value='"+item.id+"'>"+item.fecha_condensada+"</option>"
                );           
         $('#tiporeferencia2').append(
                "<option value='"+item.id+"'>"+item.fecha_condensada+"</option>"
                );
            });

      	})
        .fail(function( msg ) {
         console.log("Error al Cargar select Option Limite Referencia");  });
    
	}
    function OperacionTramite(id_)
    {
        document.getElementById('idupdate').value=id_;
        $.ajax({
           method: "POST",
           url: "{{ url('/tipo-servicio-Find-where') }}",
           data: { id:id_, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
            
        var Resp=$.parseJSON(response);
        $.each(Resp, function(i, item) {  
        document.getElementById('descripcion').value=item.descripcion;
        document.getElementById('origen').value=item.origen;
        document.getElementById('gpo').value=item.gpm;
        document.getElementById('gpm').value=item.gpo;
        document.getElementById('gpmdescripcion').value=item.descripcion_gpm;          
        $("#limitereferencia").val(item.limitereferencia).change();
        $("#tiporeferencia").val(item.tiporeferencia).change();
       console.log(item.tiporeferencia +" "+item.limitereferencia);
       
        });
        
     })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
  function savetramite()
  {
    var desc=$("#descripcion").val();
    var origen=$("#origen").val();
    var gpo=$("#gpo").val();
    var gpm=$("#gpm").val();
    var gpmdescripcion=$("#gpmdescripcion").val();
    var limitereferencia=$("#limitereferencia").val();
    var tiporeferencia=$("#tiporeferencia").val();
    var id=$("#idupdate").val();
    if(desc.length<1)
    {
        Command: toastr.warning("Descripcion Requerido!", "Notifications")
        document.getElementById('descripcion').focus();
    }/*else if(origen.length<=0)
    {
        Command: toastr.warning("Origen URL Requerido!", "Notifications")
        document.getElementById('origen').focus();
    }else if(gpo.length<=0)
    {
        Command: toastr.warning("gpo Requerido!", "Notifications")
        document.getElementById('gpo').focus();
    }else if(gpm.length<=0)
    {
        Command: toastr.warning("gpm Requerido!", "Notifications")
        document.getElementById('gpm').focus();
    }else if(gpmdescripcion.length<=0)
    {
        Command: toastr.warning("GPM Descripcion Requerido!", "Notifications")
    $("#tiporeferencia").val("limpia").change();
        document.getElementById('gpmdescripcion').focus();
    }*/else if(limitereferencia=="limpia")
    {
        Command: toastr.warning("Limite Referencia Requerido!", "Notifications")
        document.getElementById('limitereferencia').focus();
    }else if(tiporeferencia=="limpia")
    {
        Command: toastr.warning("Tipo de Referencia Requerido!", "Notifications")
        document.getElementById('tiporeferencia').focus();
    }else
    {
        if(id=="")
        {
            insertTipoServicio();
        }else{
            updateTipoServicio();
        }

    }
  }
  function insertTipoServicio()
  {
    var desc=$("#descripcion").val();
    var origen=$("#origen").val();
    var gpo=$("#gpo").val();
    var gpm=$("#gpm").val();
    var gpmdescripcion=$("#gpmdescripcion").val();
    var limitereferencia_=$("#limitereferencia").val();
    var tiporeferencia_=$("#tiporeferencia").val();
    if(origen.length==0)
    {origen="url";}
    if(gpo.length==0)
    {gpo="1";}
    if(gpm.length==0)
    {gpm="1";}
    if(gpmdescripcion.length==0)
    {gpmdescripcion="1";}
    $.ajax({
           method: "POST",
           url: "{{ url('/tipo-servicio-insert') }}",
           data: { descripcion:desc,url:origen,gpoTrans:gpo,id_gpm:gpm,descripcion_gpm:gpmdescripcion,tiporeferencia:tiporeferencia_,limitereferencia:limitereferencia_, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
     
        if(response=="true")
        {            
            ActualizaTabla();
            Command: toastr.success("Success", "Notifications")
            limpiar();
        }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function updateTipoServicio()
  {
    var desc=$("#descripcion").val();
    var origen=$("#origen").val();
    var gpo=$("#gpo").val();
    var gpm=$("#gpm").val();
    var gpmdescripcion=$("#gpmdescripcion").val();
    var limitereferencia_=$("#limitereferencia").val();
    var tiporeferencia_=$("#tiporeferencia").val();
    var id_=$("#idupdate").val();
    $.ajax({
           method: "POST",
           url: "{{ url('/tipo-servicio-update') }}",
           data: { id:id_,descripcion:desc,url:origen,gpoTrans:gpo,id_gpm:gpm,descripcion_gpm:gpmdescripcion,tiporeferencia:tiporeferencia_,limitereferencia:limitereferencia_, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
     
        if(response=="true")
        {           
            ActualizaTabla(); 
            Command: toastr.success("Success", "Notifications")
            limpiar();
        }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });

    }
    function deletetramite(id_)
    {
        document.getElementById('idvalor').value=id_;
    }
    function deleteTipoServicio()
    {
        var id_=$("#idvalor").val();
        $.ajax({
           method: "POST",
           url: "{{ url('/tipo-servicio-delete') }}",
           data: { id:id_, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
     
        if(response=="true")
        {          
            ActualizaTabla();  
            Command: toastr.success("Success", "Notifications")

        }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }

    function ActualizaTabla()
    {
   
    $.ajax({
           method: "GET",
           url: "{{ url('/tipo-servicio-find-all') }}",
           data: { _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
         var Resp=$.parseJSON(response);
         var orig="";
         var desc="";
         $("#table_2").remove();
         $("#table_1").append("<div class='portlet-body' id='table_2'><div class='row'>      <div class='col-md-1'><div class='form-group'>   <button class='btn green' data-toggle='modal' href='#static2'>Agregar</button></div>     </div>   <div class='col-md-2'> <div class='form-group'> <button class='btn green' data-toggle='modal' href='#static3'>Actulizar por Entidad</button>     </div>  </div>              </div>  <span class='help-block'>&nbsp;</span>   <table class='table table-hover' id='sample_2'>   <thead>   <tr> <th>&nbsp;Entidad&nbsp;</th>  <th>Servicio</th>    <th>Origen URL</th>  <th>Descripcion gpm</th>  <th>Tipo Referencia</th>  <th>Limite Referencia</th> <th>&nbsp;Operacion&nbsp; &nbsp;</th> </tr>  </thead><tbody></tbody></table></div>");
        $.each(Resp, function(i, item) {
            if(item.origen==null)
            {
              orig="";
            }else{orig=item.origen;}
            if(item.descripcion_gpm==null)
            {
              desc="";
            }else{desc=item.descripcion_gpm;  }
            $("#sample_2 tbody").append("<tr>"
            +"<td>"+item.entidad+"</td>"
            +"<td>"+item.descripcion+"</td>"
            +"<td>"+orig+"</td>"
            +"<td>"+desc+"</td>"
            +"<td>"+item.tiporeferencia+"</td>"
            +"<td>"+item.limitereferencia+"</td>"
            +"<td class='text-center'><a class='btn btn-icon-only blue' href='#static2' data-toggle='modal' data-original-title='' title='static2' onclick=\"OperacionTramite(\'"+item.id+"\')\"><i class='fa fa-pencil'></i></a></td>"
            +"</tr>");
            /*<a class='btn btn-icon-only red' data-toggle='modal' href='#static' onclick=\"deletetramite(\'"+item.id+"\')\"><i class='fa fa-minus'></i></a>*/
       
          });
            TableManaged.init();
           //TableAdvanced.init() 
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });

  } 
  function changeEntidadFind()
  {
    var entidad=$("#optionEntidad").val();
    if(entidad=="limpia")
    {
      $("#table2 tbody tr").remove();
        $("#table2").append("<tr>"
          +"<td>No Found</td>"
          +"<td></td>"
          +"</tr>"
        ); 
    }else{
      FindserviciosTableAll();
    }

  }
  function FindserviciosTableAll()
    {
      var entidad=$("#optionEntidad").val();
      $.ajax({
       method: "POST",
           url: "{{ url('/tipo-servicio-find-where-id') }}",
           data: { id_entidad:entidad,_token: '{{ csrf_token() }}' }  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);
          var item="";
          $("#table2 tbody tr").remove();
        $.each(Resp, function(i, item) {                
               $("#table2").append("<tr>"
                +"<td class='text-center'><input id='ch_"+item.id+"' type='checkbox' value='"+item.id+"'></td>"
                +"<td width='100%'>"+item.descripcion+"</td>"
                +"</tr>"
            );  
        });
      })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
    $("#search").keyup(function(){
        _this = this;
        $.each($("#table2 tbody tr"), function() {
        if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
        $(this).hide();
        else
        $(this).show();
        });
    });
  function limpiar()
  {
    $("#tiporeferencia").val("limpia").change();
    $("#limitereferencia").val("limpia").change();
    document.getElementById('gpmdescripcion').value="";
    document.getElementById('gpm').value="";
    document.getElementById('gpo').value="";
    document.getElementById('origen').value="";
    document.getElementById('descripcion').value="";
    document.getElementById('idupdate').value="";

  }
  function limpiar_modal() {
    $("#tiporeferencia2").val("limpia").change();
    $("#limitereferencia2").val("limpia").change();
    $("#optionEntidad").val("limpia").change();
          $("#table2 tbody tr").remove();
        $("#table2").append("<tr>"
          +"<td>No Found</td>"
          +"<td></td>"
          +"</tr>"
        );
       document.getElementById('search').value="";

  }
</script>
@endsection
