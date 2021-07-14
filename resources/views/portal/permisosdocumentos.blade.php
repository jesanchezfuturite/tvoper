@extends('layout.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}"/>
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
<div id="portlet-file-upload" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" ></button>
                <h4 class="modal-title">Cargadar Archivo </h4>
            </div>
            <div class="modal-body" >
              <br>
              <div class="row">
               <div class="col-md-12"> 

                  <div class="form-group">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                            <span class="btn green btn-file">
                            <span class="fileinput-new">
                            <i class="fa fa-plus"></i>&nbsp; &nbsp;*Adjuntar Archivo </span>
                            <span class="fileinput-exists">
                            <i class="fa fa-exchange"></i>&nbsp; &nbsp;Cambiar Archivo </span>
                            <input type="file" name="fileSAT" accept="application/pdf" id="fileSAT">
                            </span>
                            <div class="col-md-12"><span class="fileinput-filename" style="display:block;text-overflow: ellipsis;width: 200px;overflow: hidden; white-space: nowrap;">
                            </span>&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"style="position: absolute;left: 215px;top: 4px" id="delFileSAT">
                            </a></div>
                            
                    </div>
                  </div>
                </div>
                
              </div>
              <div class="row">
               <div class="col-md-4"> 
                  <div class="form-group">
                    <button type="submit" class="btn blue btn-save-Not" onclick="saveFile()"><i class="fa fa-check"></i> Guardar</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn default" >Salir</button>
            </div>
        </div>
    </div>
</div>
<div id="portlet-file" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" ></button>
                <h4 class="modal-title">Archivo Cargado</h4>
            </div>
            <div class="modal-body" id="addurlfile">
                             
                <iframe src="" id="file_pdf" width="100%" height="500px" title="Archivo prelacion" download="archivos_SDa"></iframe>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn default" >Salir</button>
            </div>
        </div>
    </div>
</div>
<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
<input type="text" name="id_registro" id="id_registro" hidden="true">
<input type="text" name="required_docs" id="required_docs" hidden="true">
@endsection

@section('scripts')
<script src="{{ asset('assets/global/scripts/validar_pdf.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>
	<script>
	jQuery(document).ready(function() {
    TableManaged2.init2();
    });

  function updatePermisos(id,folio,status)
  { 
    var labl=document.getElementById("lbl_habilitar");    
    document.getElementById("lbl_folio").textContent=folio;
    //$('#portlet-update').modal('show');    
     if($("#check_"+id).prop("checked") == true && status==1)
    {
    }else if($("#check_"+id).prop("checked") == false && status==null || status==0)
    {       
    }else if($("#check_"+id).prop("checked") == true){
      labl.textContent="Habilitar";
      $('#portlet-update').modal('show');    
    }else if($("#check_"+id).prop("checked") == false){
       labl.textContent="Deshabilitar";
       $('#portlet-update').modal('show');    
    }
    document.getElementById("id_registro").value=id;
    document.getElementById("required_docs").value=status;
  }
  function cerrarModal()
  {
    var id=$("#id_registro").val();
    var required_docs=$("#required_docs").val();
    //console.log($("#check_"+id).prop("checked") )
    console.log(required_docs);
    if(required_docs==1)
    {
      $("#row_"+id).empty(); 
       $("#row_"+id).append("<input type='checkbox'   data-toggle='modal' href='#portlet-update' class='make-switch' data-on-color='success' data-off-color='danger'name='check_permiso' onchange='updatePermisos("+id+","+id+","+required_docs+")' id='check_"+id+"'>");
      $('#check_'+id).prop('checked', true);
    }else{
      $("#row_"+id).empty();       
       $("#row_"+id).append("<input type='checkbox'   data-toggle='modal' href='#portlet-update' class='make-switch' data-on-color='success' data-off-color='danger'name='check_permiso' onchange='updatePermisos("+id+","+id+","+required_docs+")' id='check_"+id+"' checked>");
       $('#check_'+id).prop('checked', false);
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
              var btn_file='';
              console.log(item.attach);
              if(item.attach!=null)
              {
                btn_file="<a class='btn btn-icon-only green' data-toggle='modal' data-original-title='' title='Detalles' onclick='verArchivo(\""+item.file_data+"\",\""+item.file_name+"\",\""+item.file_extension+"\",)'><i class='fa  fa-file'></i> </a>";
              }

            	$('#sample_2 tbody').append("<tr>"
                	+"<td>"+item.id+"</td>"
                	+"<td>"+item.clave+"</td>"
                	+"<td>"+item.descripcion+"</td>"
                	+"<td>"+item.created_at+"</td>"
                	+"<td id='row_"+item.id+"'><input type='checkbox'   data-toggle='modal' href='#portlet-update' class='make-switch' data-on-color='success' data-off-color='danger'name='check_permiso' onchange='updatePermisos("+item.id+","+item.id+","+item.required_docs+")' id='check_"+item.id+"'></td>"
                  +"<td>"+btn_file+"</td>"
                  +"<td><a class='btn btn-icon-only green' data-toggle='modal' data-original-title='' title='Detalles' onclick='subirArchivo(\""+item.id+"\")'><i class='fa fa-edit'></i> </a></td>"
                 
                  +"<td><a class='btn btn-icon-only blue' href='#portlet-detalle' data-toggle='modal' data-original-title='' title='Detalles' onclick='findDetalles(\""+item.id+"\")'><i class='fa fa-list'></i> </a></td>"
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
  function saveFile()
  {

  }
  function subirArchivo(id)
  {
    $('#portlet-file-upload').modal('show');
  }
  function verArchivo(file_data,file_name,file_extension)
  {
    $('#portlet-file').modal('show');
    if(file_extension=='xlsx'){
      document.getElementById('file_pdf').src = "";
    }else if(file_extension=='png' || file_extension=='jpg'){
       document.getElementById('file_pdf').src = "data:image/"+file_extension+";base64,"+file_data;
    } else{
      document.getElementById('file_pdf').src = "data:application/"+file_extension+";base64,"+file_data;
    }     
    
    $("#addurlfile a").empty();
    $("#addurlfile").append("<a href='{{ url()->route('listado-download', '') }}/"+file_name+"' title='Descargar Archivo'>"+file_name+"<i class='fa fa-download blue'></i></a>");
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
    $("#addtables").append("<div id='removetable'><table class='table table-hover' id='sample_2'> <thead><tr><th>ID</th><th>clave</th><th>Estatus</th><th>Fecha Ingreso</th><th width='15%' align='center'>Permiso descarga </th><th></th><th></th><th></th> </tr></thead> <tbody></tbody> </table></div>");
  }
  function limpiar()
  {
    document.getElementById("").value="";
    
  }
	</script>
@endsection
