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
		                	<label >Folio Pago / FSE</label>
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
              			<th>Folio Tramite</th>
              			<th>FSE</th>
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
        <h4 class="modal-title">Detalles</h4>        
      </div>
      <div class="modal-body" style="height:520px  !important;overflow-y:scroll;overflow-y:auto;">
        <input type="text" name="idTicket" id="idTicket" hidden="true">
        <div class="row">
          <div class="col-md-12">
            <div class="portlet-body form">
              <div class="form-body">
                <h4 class="form-section"><strong>Enajenantes</strong></h4>
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
        <div class="row divSolicitante">
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
        <div class="row divNotaria">
          <div class="col-md-12">
            <div class="portlet-body form">
              <div class="form-body">
                <h4 class="form-section"><strong>Datos de la Notaria</strong></h4>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" id="notaria">
            <div id="addnotaria">
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Archivo Cargado</h4>
            </div>
            <div class="modal-body" >
              <div class="row" >          
                <iframe src="" id="file_pdf" class="file_pdf" type="application/pdf" width="100%" height="500px" title="Archivo prelacion" download="archivos_SDa"></iframe>
              </div>
              <hr>
              <div class="row">               
               <div class="col-md-6"> 
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                       
                        <span class="btn green btn-file">
                        <span class="fileinput-new">
                        <i class="fa fa-plus"></i>&nbsp; &nbsp;Adjuntar Archivo </span>
                        <span class="fileinput-exists">
                        <i class="fa fa-exchange"></i>&nbsp; &nbsp;Cambiar Archivo </span>
                        <input type="file" name="file" accept="application/pdf" id="file" onchange="previewFile()">
                        </span>
                        <button type="submit" class="btn blue fileinput-exists" onclick="saveFile()"><i class="fa fa-check"></i> Guardar</button>
                        <span class="fileinput-filename" style="text-overflow: ellipsis;width: 240px;overflow: hidden; white-space: nowrap;">
                        </span>&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"id="delFile">
                        </a>
                
                  </div>
                </div>
                  <div class="col-md-6"> 
                  <div class="form-group" id="addurlfile">
                  
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Salir</button>
            </div>
        </div>
    </div>
</div>
<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
<input type="text" name="id_registro" id="id_registro" hidden="true">
<input type="text" name="required_docs" id="required_docs" hidden="true">
<input type="text" name="id_mensaje" id="id_mensaje" hidden="true">
<input type="text" name="id_ticket" id="id_ticket" hidden="true">
<input type="text" name="file_old" id="file_old" hidden="true">
<input type="text" name="file_data" id="file_data"  hidden="true">
<input type="text" name="file_extension" id="file_extension" hidden="true">
<input type="text" name="file_name" id="file_name" hidden="true">
<input type="text" name="file_save" id="file_save" hidden="true">
@endsection

@section('scripts')
<script src="{{ asset('assets/global/scripts/validar_pdf.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>
	<script>
	jQuery(document).ready(function() {
    TableManaged2.init2();
      $(".divSolicitante").css("display", "none");
      $(".divNotaria").css("display", "none");
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
    //console.log(required_docs);
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
           url: "{{ url()->route('solicitud-update-permisos') }}",
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
           url: "{{ url()->route('solicitud-find-folio') }}",
           data: {folio:folio_,_token:'{{ csrf_token() }}'} })
        .done(function (response) {
        	//console.log(response);
            addtable();
            if(response.status=='400')
            	{TableManaged2.init2();  return;}         
            $.each(response.Message, function(i, item) {
              var verArchivo="<a class='btn btn-icon-only green' data-toggle='modal' data-original-title='' title='Ver Archivo' onclick='verArchivo(\""+item.file_data+"\",\""+item.file_name+"\",\""+item.file_extension+"\",\""+item.attach+"\",\""+item.id+"\",\""+item.id_mensaje+"\")'><i class='fa  fa-file'></i> </a>";
              if(item.attach==null || item.attach=="null")
              {
                verArchivo="";
              }
            	$('#sample_2 tbody').append("<tr>"
                	+"<td>"+item.id+"</td>"
                	+"<td>"+item.id_transaccion+"</td>"
                  +"<td>"+item.descripcion+"</td>"
                	+"<td>"+item.mensaje+"</td>"
                	+"<td>"+item.created_at+"</td>"
                	+"<td id='row_"+item.id+"'><input type='checkbox'   data-toggle='modal' href='#portlet-update' class='make-switch' data-on-color='success' data-off-color='danger'name='check_permiso' onchange='updatePermisos("+item.id+","+item.id+","+item.required_docs+")' id='check_"+item.id+"'></td>"
                  +"<td>"+verArchivo+"</td>"
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
     var file=$("#file").val();
    var file_old=$("#file_old").val();
    var id_attch=$("#id_mensaje").val();
    var id_ticket=$("#id_ticket").val();
    var fileV = $("#file")[0].files[0];  
    var fileSave    = document.querySelector('input[type=file]').files[0];  
    if(file.length==0){ 
      Command: toastr.warning("Archivo, Requerido!", "Notifications")
      return ;
    }      
    document.getElementById('file_save').value = 1;        
    var formdata = new FormData();
    formdata.append("ticket_id", id_ticket);
    formdata.append("attch_old", file_old);
    formdata.append("id_mensaje", id_attch);
    formdata.append("file", fileV);
    formdata.append("_token",'{{ csrf_token() }}');
    $.ajax({
       method: "POST",
       contentType: false,
       processData: false, 
       url: "{{ url()->route('solicitud-save-documento') }}",
       data:formdata})
    .done(function (response) {
       if(response.Code =="200"){
          Command: toastr.success(response.Message, "Notifications")
          $("#addurlfile div").empty();
          if(response.file_name_new!=''){
            $("#addurlfile").append("<div><label style='color: #cb5a5e;'>Descargar Directa:</label> <a href='{{ url()->route('listado-download', '') }}/"+response.file_name_new+"' title='Descargar Archivo'>"+response.file_name_new.substr(0,50)+"...<i class='fa fa-download blue'></i></a></div>");
          }                  
          document.getElementById('file_data').value = response.file_data;
          findTramiteSolicitud();
          limpiar();  

        }else{
          Command: toastr.warning(response.Message, "Notifications")
        }
    })
    .fail(function( msg ) {
     Command: toastr.warning("Error", "Notifications");
    });
  }
  function subirArchivo(id)
  {
    $('#portlet-file-upload').modal('show');
  }
  function verArchivo(file_data,file_name,file_extension,attach,id_ticket,id_mensaje_)
  {
    document.getElementById("id_ticket").value=id_ticket;
    document.getElementById("id_mensaje").value=id_mensaje_;
    document.getElementById("file_old").value=attach;
    document.getElementById("file_data").value=file_data;
    document.getElementById("file_extension").value=file_extension;
    document.getElementById("file_name").value=file_name;
    $(".file_pdf").css("display", "block");
    $('#portlet-file').modal('show');
    if(file_extension=='pdf' && file_data.length>0){
      const blob = this.dataURItoBlob(file_data);
      document.getElementById('file_pdf').src = URL.createObjectURL(blob); 
    } else{
        document.getElementById('file_pdf').src = "";
        $(".file_pdf").css("display", "none");
    }     
    
    $("#addurlfile div").empty();
    if(file_name!=''){
      $("#addurlfile").append("<div><label style='color: #cb5a5e;'>Descargar Directa:</label> <a href='{{ url()->route('listado-download', '') }}/"+file_name+"' title='Descargar Archivo'>"+file_name.substr(0,50)+"...<i class='fa fa-download blue'></i></a></div>");
    }
    
  }
  function findDetalles(id)
  {
      $("#detalles div").remove();
      $("#detalles").append("<div id='addDetalles'></div>");
      $("#solicitante div").remove();
      $("#solicitante").append("<div id='addSolicitante'></div>");
      $("#notaria div").remove();
      $("#notaria").append("<div id='addnotaria'></div>");
      $.ajax({
           method: "GET", 
           url: "{{ url()->route('solicitud-find-detalle') }}" + "/"+id,
           data:{ _token:'{{ csrf_token() }}'} })
        .done(function (response) {
          //console.log(response);
          document.getElementById("jsonCode").value=JSON.stringify(response);
          var Resp=response;
          var soli=Resp.solicitante;
          var tipo="";
          var obj="";
          if(typeof(Resp.solicitante)==="object"){
            $(".divNotaria").css("display", "block");
            dataNot='';
            for (n in Resp.solicitante) {   
            if(n=='email' || n=='email'|| n=='nombreSolicitante' || n=='apPat' || n=='apMat' || n=='notary')
              {               
                if(n=='email'){dataNot='Correo Electrónico';} 
                 if(n=='nombreSolicitante'){dataNot='Nombre';}
                if(n=='apPat'){dataNot='Apellido Paterno';} 
                if(n=='apMat'){dataNot='Apellido Materno';}  
              var valE= Resp.solicitante[n];
                if(n=="notary"){
                  dataNot="Numero de Notaria";
                  if(typeof(Resp.solicitante.notary)==="object"){  
                  valE= Resp.solicitante.notary.notary_number;           
                  }else{            
                  valE= Resp.solicitante.notary;
                  }
                }         
              $("#addnotaria").append("<div class='col-md-4'><div class='form-group'><label><strong>"+dataNot+":</strong></label><br><label>"+valE+"</label></div></div>"); 
            }
            }
          }
           $.each(Resp.camposConfigurados, function(i, item) {
              if (item.tipo=="enajenante") { 
                
                        
                $.each(item.valor.enajenantes, function(i2, item2) { 
                  var num=i2+1;
                  $("#addDetalles").append("<div class='col-md-12'><strong>Enajenante "+ num +"</strong><hr></div>");
                  for (e in item2.datosPersonales) {
                    $("#addDetalles").append("<div class='col-md-4'><div class='form-group'><label><strong>"+e+":</strong></label><br><label>"+item2.datosPersonales[e]+"</label></div></div>"); 
                  }
                   
                })           
              }
            })
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
  }
  function addtable(){
    $("#addtables div").remove();
    $("#addtables").append("<div id='removetable'><table class='table table-hover' id='sample_2'> <thead><tr><th>Folio Tramite</th><th>FSE</th><th>Estatus</th><th>Descripcion</th><th>Fecha Ingreso</th><th width='15%' align='center'>Permiso descarga </th><th></th><th></th></tr></thead> <tbody></tbody> </table></div>");
  }
  function limpiar()
  {   
    document.getElementById('delFile').click();
    
  }
  function previewFile() {
    var file_save=$("#file_save").val();
    var file_data=$("#file_data").val();
    var file_extension=$("#file_extension").val();
    var file_name=$("#file_name").val();
    var file    = document.querySelector('input[type=file]').files[0];
    var file2    = $("#file").val();
    var reader  = new FileReader();
    if(file2.length>0)
    {
     document.getElementById('file_pdf').src = URL.createObjectURL(file);
    }else{     
      if(file_data.length>0){
        const blob = this.dataURItoBlob(file_data);
       document.getElementById('file_pdf').src = URL.createObjectURL(blob);
      }else{
        document.getElementById('file_pdf').src ="";
      }
    }
  }
 function dataURItoBlob(dataURI) {
      const byteString = window.atob(dataURI);
      const arrayBuffer = new ArrayBuffer(byteString.length);
      const int8Array = new Uint8Array(arrayBuffer);
      for (let i = 0; i < byteString.length; i++) {
        int8Array[i] = byteString.charCodeAt(i);
      }
      const blob = new Blob([int8Array], { type: 'application/pdf'});
      return blob;
    }
	</script>
@endsection
