@extends('layout.app')

@section('content')
<h3 class="page-title"> Configuración de motor de pagos <small>Configuración de Límite de Referencia</small></h3>
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
            <a href="#">Configuración de Límite de Referencia</a>
        </li>
    </ul>
</div>

<!----  #tabla -->
<div class="row">
	<div class="col-md-12">				
		<div class="portlet box blue" id="tabla_1">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-globe"></i>Registros
				</div>
			</div>
		<div class="portlet-body" id="tabla_2">
			 <button class="btn green" data-toggle="modal" href="#static2">Agregar</button>
			<table  class="table table-hover"  id="sample_6">
				<thead>
					<tr>						
						<th>Descripción</th>
						<th class="text-center">Periodicidad</th>							
						<th class="text-center">Vencimiento</th>
						<th class="text-center">Operacion</th>							
					</tr>
				</thead>
				<tbody>							
					 @foreach( $saved_days as $sd)
                        <tr>
                            <td>{{$sd["descripcion"]}}</td>
                            <td class="text-center">{{$sd["periodicidad"]}}</td>
                            <td class="text-center">{{$sd["vencimiento"]}}</td>
                            <td class="text-right" width="20%"><button type="button" class="btn btn-primary" data-toggle="modal" href="#static2" onclick="update({{$sd['id']}})""><i class="fa fa-edit"></i>&nbsp;Editar</button><button type="button" class="btn btn-danger" data-toggle="modal" href="#static" onclick="deleted({{$sd['id']}}) "><i class="fa fa-trash-o"></i>&nbsp;Borrar</button></td>
                        </tr>
                        @endforeach
				</tbody>
			</table>
		</div>
		
		</div>
	</div>
</div>
<!-- modal-dialog -->
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
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminar()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<!-- modal-dialog -->
<div id="static2" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h3 class="form-section">Limite Referencia</h3>
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
															<textarea class="form-control" rows="3" id="descripcion" placeholder="Escribe una Descripción"></textarea>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Periodicidad</label>
																<select id="periodicidad" class="select2me form-control" onchange="ChangePeriodicidad()">
                                  <option value="limpia">-------</option>
																	<option value="Anual">Anual</option>
                                  <option value="Mensual">Mensual</option>
                                  <option value="Trimestral">Trimestral</option>																	
																</select>
																<span class="help-block">
																Seleccione una Opcion </span>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												<div class="row" id="AddCheck">
													
													<!--/span-->
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">Fecha Vencimiento</label>
															<input id="vencimiento" class="form-control" size="16" type="number" maxlength="2" min="1" max="31"  autocomplete="off" placeholder="Ingrese el dia ej. 23"oninput="prueba(this);">
															<span class="help-block">Ingrese una Numero</span>
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
       ComponentsPickers.init();
       TableAdvanced.init();        
    });
function verificaMes()
{
  var check=$("#checkbox30").prop("checked");
  if(check==true)
  {
    document.getElementById("vencimiento").disabled=true;
    document.getElementById("vencimiento").value="0";
  }
  else{
    document.getElementById("vencimiento").disabled=false;
    document.getElementById("vencimiento").value="";
  }
}
function ChangePeriodicidad()
{
  var periodicidad=$("#periodicidad").val();
  if(periodicidad=="Mensual")
  {
    $("#AddCheck").append("<div class='col-md-4' id='Removecheck'><span class='help-block'>Obligatorio si es fin de Mes</span> <div class='form-group'> <div class='md-checkbox'><input type='checkbox' id='checkbox30' class='md-check' onclick='verificaMes()'>   <label for='checkbox30'>    <span></span>  <span class='check'></span> <span class='box'></span>  Fin de Mes. </label> </div><span class='help-block'>Marque</span> </div> </div>");
  }
  else{
    $("#Removecheck").remove();
    document.getElementById("vencimiento").disabled=false;
    document.getElementById("vencimiento").value="";}
}
function metodo()
{
    var description_=$("#descripcion").val();
    var vencimiento_=$("#vencimiento").val();
    var periodicidad_=$("#periodicidad").val();

	var id_=$("#idupdate").val();
    if(description_.length<3){
    Command: toastr.warning("Descripción 3 Caracteres Min., Requerido!", "Notifications")
    document.getElementById('descripcion').focus();
    }else if(vencimiento_.length<1){
        var date = new Date();
       var ultimoDia = new Date(date.getFullYear(), date.getMonth() + 2, 0);
       var dia=ultimoDia.getDate();
        Command: toastr.warning("Vencimiento Valor Valido 1 entre "+dia+", Requerido!", "Notifications")
        document.getElementById('vencimiento').focus();
    }else if(periodicidad_=="limpia"){
        Command: toastr.warning("Periodicidad Sin Seleccionar, Requerido!", "Notifications")
        document.getElementById('periodicidad').focus();
    }
    else{
	   if(id_=="")
	   {
        guardar();		
	   }
	   else{
	   actulizar();	
	   }
    }
}
function prueba(n) {
       var num = n.value;
        var date = new Date();
       if (parseFloat(num) >= 1&& parseFloat(num) <= 31) {
         
       } else {      
           document.getElementById('vencimiento').value='';
 
       }
    }
function guardar()
{

var description_=$("#descripcion").val();
var periodicidad_=$("#periodicidad").val();
var fecha_=new Date();
var fechaIn=fecha_.getFullYear() + "-" + (fecha_.getMonth() + 1) + "-" + fecha_.getDate() + " " + fecha_.getHours() + ":" + fecha_.getMinutes() + ":" + fecha_.getSeconds();
var vencimiento_= $("#vencimiento").val();

$.ajax({
           method: "POST",
           url: "{{ url('/limite-referencia-insert') }}",
           data: { descripcion: description_,periodicidad:periodicidad_,vencimiento:vencimiento_,fecha:fechaIn, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
        	
        var Resp=$.parseJSON(response);
       limpiar();
        Command: toastr.success("Success", "Notifications") 
        actualizatabla(Resp);
     })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
}
      
function actulizar()
{
var id_=$("#idupdate").val();
var description_=$("#descripcion").val();
var periodicidad_=$("#periodicidad").val();
var fecha_=new Date();
var fechaIn=fecha_.getFullYear() + "-" + (fecha_.getMonth() + 1) + "-" + fecha_.getDate() + " " + fecha_.getHours() + ":" + fecha_.getMinutes() + ":" + fecha_.getSeconds();
var vencimiento_= $("#vencimiento").val();

$.ajax({
           method: "POST",
           url: "{{ url('/limite-referencia-update') }}",
           data: { id:id_,descripcion: description_,periodicidad:periodicidad_,vencimiento:vencimiento_,fecha:fechaIn, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
        	
        var Resp=$.parseJSON(response);        
        Command: toastr.success("Success", "Notifications")
         limpiar();
        actualizatabla(Resp);
     })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
}

function deleted(id)
{
	document.getElementById('idvalor').value =id;
	
}
function update(id_)
{
	$.ajax({
           method: "POST",
           url: "{{ url('/limite-referencia-find') }}",
           data: { id:id_, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
        	
        var Resp=$.parseJSON(response);
        $.each(Resp, function(i, item) {  
               document.getElementById('idupdate').value=item.id;
               document.getElementById('descripcion').value=item.descripcion;
        document.getElementById('vencimiento').value=item.vencimiento;
        $("#periodicidad").val(item.periodicidad).change();
        if(parseFloat(item.vencimiento)==0)
        {
          $("#checkbox30").prop("checked", true);
         document.getElementById("vencimiento").disabled=true;
        }
        //document.getElementById('periodicidad').value=item.periodicidad;
       
        });
        
     })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
}

function eliminar()
{
	var id_ = $("#idvalor").val();

  $.ajax({
           method: "POST",
           url: "{{ url('/limite-referencia-deleted') }}",
           data: { id: id_, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
        	
        var Resp=$.parseJSON(response);
        Command: toastr.success("Success", "Notifications") 
        actualizatabla(Resp);                          
         
        
     })
        .fail(function( msg ) {
         Command: toastr.warning("No deleted", "Notifications")  });
       
}

function actualizatabla(Resp)
{
var item = '';
	$("#tabla_2").remove();
            /*agrega tabla*/
             $('#tabla_1').append("<div class='portlet-body' id='tabla_2'><button class='btn green' data-toggle='modal' href='#static2'>Agregar</button><table  class='table table-striped table-bordered table-hover' id='sample_6'><thead><tr><th>Descripción</th><th>Periodicidad</th><th>Vencimiento</th><th>Operacion</th></tr></thead><tbody></tbody></table></div>");
                $.each(Resp, function(i, item) {                
                 $('#sample_6 tbody').append("<tr>"  
                 +"<td>"+ item.descripcion + "</td>"                 
                 + "<td class='text-center'>"+ item.periodicidad + "</a></td>"                 
                 + "<td class='text-center'>"+ item.vencimiento + "</a></td>"                 
                 + "<td class='text-center' width='20%'><button type='button' class='btn btn-primary' data-toggle='modal' href='#static2' onclick='update("+item.id+")'><i class='fa fa-edit'></i>&nbsp;Editar</button><button type='button' class='btn btn-danger' data-toggle='modal' href='#static' onclick='deleted("+item.id+")'><i class='fa fa-trash-o'></i>&nbsp;Borrar</button></td>"
                 + "</tr>");
                });  
     TableAdvanced.init();
}
function limpiar()
{
	document.getElementById('descripcion').value="";
    document.getElementById('vencimiento').value="";
    document.getElementById('idupdate').value="";
    $("#periodicidad").val("limpia").change();

}
  

</script>
@endsection