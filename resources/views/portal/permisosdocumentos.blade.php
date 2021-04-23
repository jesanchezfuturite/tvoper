@extends('layout.app')

@section('content')

<h3 class="page-title">Portal <small>Permisos de descarga de documentos firmados</small></h3>
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
            <a href="#">Permisos de descarga de documentos firmados</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Filtros
            </div>
        </div>
        <div class="portlet-body">
	        <div class="form-body">
		        <div class="row">		          
		            <div class="col-md-4 col-ms-12">
		                <div class="form-group">
		                	<label >Folio</label>
                      <input type="text" name="folio" id="folio" class="form-control" placeholder="Ingresa el folio.." autocomplete="off"> 
		                </div>
		            </div>		            
		            <div class="col-md-1 col-ms-12">
                    	<div class="form-group">
                    		<span class="help-block">&nbsp;</span>
                    		<button type="button" class="btn green"id="btnbuscar" onclick="findTramiteSolicitud()">Buscar</button>
                    	</div>
            		</div>
		            
	            </div> 
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            
            <div class="caption" id="headerTabla">
              	<div id="borraheader"> 
              	 	<i class="fa fa-cogs"></i>&nbsp;Registros &nbsp;
            	</div>
            </div>
            <div class="tools" id="toolsSolicitudes">                
                <a href="#" data-toggle="modal" class="config" data-original-title="" title="">
                </a>
            </div>
        </div>
         <div class="portlet-body" id="addtables">
    		<div id="removetable">
          		<table class="table table-hover" id="sample_2">
            		<thead>
              			<tr>
              			<th>ID</th>
              			<th>Titulo</th>
              			<th>Estatus</th>
              			<th>Fecha de Ingreso</th>
            			<th width="15%" align="center">Permiso descarga </th>
            			</tr>
          			</thead>
          			<tbody> 
          			</tbody>
        		</table>  
      		</div>             
    	</div>
    </div>
</div>
<!----------------------------------------- modal confirmation-------------------------------------------->
<div id="portlet-update" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="cerrarModal()"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <span class="help-block">&nbsp;</span> <p>
             ¿<label id="lbl_habilitar" style="color: #cb5a5e;"></label> permisos de descarga de documentos firmados, Folio: <label id="lbl_folio" style="color: #cb5a5e;"></label>?</p>
              <span class="help-block">&nbsp;</span>              
                
            </div>
            <div class="modal-footer">
                <div id="AddbuttonDeleted">
         <button type="button" data-dismiss="modal" class="btn default" onclick="cerrarModal()">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="permisosUpdate()">Confirmar</button>
        </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="portlet-detalle" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog" style="width: 80%;">
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Detalle de la Solicitud </h4>        
      </div>
      <div class="modal-body" style="height:520px  !important;overflow-y:scroll;overflow-y:auto;">
        <input type="text" name="idTicket" id="idTicket" hidden="true">
        <div class="row">
          <div class="col-md-12">
            <div class="portlet-body form">
              <div class="form-body">
                <h4 class="form-section"><strong>Datos generales</strong></h4>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" id="detalles">
            <div id="addDetalles">
            </div>
          </div>    
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="portlet-body form">
              <div class="form-body">
                <h4 class="form-section"><strong>Datos del solicitante</strong></h4>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" id="solicitante">
            <div id="addSolicitante">
            </div>
          </div>    
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn default">Cerrar</button>          
      </div>   
    </div>
  </div>
</div>
<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
<input type="text" name="id_registro" id="id_registro" hidden="true">
@endsection

@section('scripts')

	<script>
	jQuery(document).ready(function() {
    TableManaged2.init2();
    });

  function updatePermisos(id,folio)
  { 
    var labl=document.getElementById("lbl_habilitar");    
    document.getElementById("lbl_folio").textContent=folio;
    $('#portlet-update').modal('show');    
     if($("#check_"+id).prop("checked") == true)
    {
       labl.textContent="Habilitar";
    }else{
       labl.textContent="Deshabilitar";
    }
    document.getElementById("id_registro").value=id;
  }
  function cerrarModal()
  {var id=$("#id_registro").val();
    //console.log($("#check_"+id).prop("checked") );
    if($("#check_"+id).prop("checked")==true)
    {
      $("#row_"+id).empty(); 
       $("#row_"+id).append("<input type='checkbox'   data-toggle='modal' href='#portlet-update' class='make-switch' data-on-color='success' data-off-color='danger'name='check_permiso' onchange='updatePermisos("+id+","+id+")' id='check_"+id+"'>&nbsp;&nbsp;&nbsp;<a class='btn btn-icon-only blue' href='#portlet-detalle' data-toggle='modal' data-original-title='' title='Detalles' onclick='findDetalles(\""+id+"\")'><i class='fa fa-list'></i> </a>");
      $('#check_'+id).prop('checked', false);
    }else{
      $("#row_"+id).empty();       
       $("#row_"+id).append("<input type='checkbox'   data-toggle='modal' href='#portlet-update' class='make-switch' data-on-color='success' data-off-color='danger'name='check_permiso' onchange='updatePermisos("+id+","+id+")' id='check_"+id+"' checked>&nbsp;&nbsp;&nbsp;<a class='btn btn-icon-only blue' href='#portlet-detalle' data-toggle='modal' data-original-title='' title='Detalles' onclick='findDetalles(\""+id+"\")'><i class='fa fa-list'></i> </a>");
       $('#check_'+id).prop('checked', true);
    }
     $("[name='check_permiso']").bootstrapSwitch();
    //console.log($("#check_"+id).prop("checked") );
  }
  function permisosUpdate()
  {
    var id_=$("#id_registro").val();
    var docs=null;
    if($("#check_"+id_).prop("checked"))
    { docs=1; }
      $.ajax({
           method: "POST", 
           url: "{{ url('/solicitud-update-permisos') }}",
           data: {id:id_,required_docs:docs,_token:'{{ csrf_token() }}'} })
        .done(function (response) {
            if(response.status=='400')
              {
                Command: toastr.warning(response.Message, "Notifications");
               return;
             }else{
              findTramiteSolicitud();
              Command: toastr.success(response.Message, "Notifications");
             }              
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });

  }
  var input = document.getElementById("folio");
  input.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
    event.preventDefault();
    document.getElementById("btnbuscar").click();
    }
  });
  function findTramiteSolicitud(){
    	var folio_=$("#folio").val();
    	 
    	$.ajax({
           method: "POST", 
           url: "{{ url('/solicitud-find-folio') }}",
           data: {folio:folio_,_token:'{{ csrf_token() }}'} })
        .done(function (response) {
        	//console.log(response);
            addtable();
            if(response.status=='400')
            	{TableManaged2.init2();  return;}         
            $.each(response.Message, function(i, item) {
             
            	$('#sample_2 tbody').append("<tr>"
                	+"<td>"+item.id+"</td>"
                	+"<td>"+item.clave+"</td>"
                	+"<td>"+item.descripcion+"</td>"
                	+"<td>"+item.created_at+"</td>"
                	+"<td id='row_"+item.id+"'><input type='checkbox'   data-toggle='modal' href='#portlet-update' class='make-switch' data-on-color='success' data-off-color='danger'name='check_permiso' onchange='updatePermisos("+item.id+","+item.id+")' id='check_"+item.id+"'>&nbsp;&nbsp;&nbsp;<a class='btn btn-icon-only blue' href='#portlet-detalle' data-toggle='modal' data-original-title='' title='Detalles' onclick='findDetalles(\""+item.id+"\")'><i class='fa fa-list'></i> </a></td>"
                	+"</tr>"
                );
              if(item.required_docs==1)
                {
                  $('#check_'+item.id).prop('checked', true);
                }else{
                  $('#check_'+item.id).prop('checked', false);
                }
            });
            
          $("[name='check_permiso']").bootstrapSwitch();
        	TableManaged2.init2();   
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
  }
  function findDetalles(id)
  {
      $("#detalles div").remove();
      $("#detalles").append("<div id='addDetalles'></div>");
      $("#solicitante div").remove();
      $("#solicitante").append("<div id='addSolicitante'></div>");
      $.ajax({
           method: "GET", 
           url: "{{ url('/solicitud-find-detalle') }}" + "/"+id,
           data:{ _token:'{{ csrf_token() }}'} })
        .done(function (response) {
          console.log(response);
          document.getElementById("jsonCode").value=JSON.stringify(response);
          var Resp=response;
          var soli=Resp.solicitante;
          var tipo="";
          var obj="";
          for (n in soli) {  
            obj=n;
            tipo=soli[n];    
            if(tipo=="pm")
            {tipo="Moral";}
            if(tipo=="pf")
            {tipo="Fisica";}
            if(obj=="tipoPersona"){
              obj="Tipo Persona";
            }

              $("#addSolicitante").append("<div class='col-md-4'><div class='form-group'><label><strong>"+obj+":</strong></label><br><label>"+tipo+"</label></div></div>");            
          }
          for (n in Resp.campos) {            
              $("#addDetalles").append("<div class='col-md-4'><div class='form-group'><label><strong>"+n+":</strong></label><br><label>"+Resp.campos[n]+"</label></div></div>");            
          }
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
  }
  function addtable(){
    $("#addtables div").remove();
    $("#addtables").append("<div id='removetable'><table class='table table-hover' id='sample_2'> <thead><tr><th>ID</th><th>clave</th><th>Estatus</th><th>Fecha Ingreso</th><th width='15%' align='center'>Permiso descarga </th> </tr></thead> <tbody></tbody> </table></div>");
  }
  function limpiar()
  {
    document.getElementById("").value="";
    
  }
	</script>
@endsection
