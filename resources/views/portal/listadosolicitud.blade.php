@extends('layout.app')

@section('content')

<h3 class="page-title">Portal <small>Listado Solicitudes</small></h3>
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
            <a href="#">Listado Solicitudes</a>
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
		            <div class="col-md-3 col-ms-12">
		                <div class="form-group">
		                	<label >Tipo de Solicitud</label>           
						    <select class="select2me form-control" name="opTipoSolicitud" id="opTipoSolicitud" onchange="">
						       <option value="0">------</option>
						        @foreach(json_decode($tramites,true) as $tr)
                       			 <option value="{{$tr['id_tramite']}}">{{$tr["tramite"]}}</option>
                      			@endforeach     
						    </select>   
		                </div>
		            </div>
		            <div class="col-md-3 col-ms-12">
		                <div class="form-group"> 
		                	<label >Estatus</label>          
						    <select class="select2me form-control" name="opEstatus" id="opEstatus" onchange="">	       	
						       <option value="0">------</option>
						       @foreach( $status as $sd)
                       			 <option value="{{$sd['id']}}">{{$sd["descripcion"]}}</option>
                      			@endforeach     
						    </select>  
		                </div>
		            </div>
		            <div class="col-md-3 col-ms-12">
		                <div class="form-group"> 
		                	<label >No. Solicitud</label>          
						    <input type="text" class="form-control" name="noSolicitud" id="noSolicitud" placeholder="Ingrese Numero de Solicitud...">  
		                </div>
		            </div>
		            <div class="col-md-1 col-ms-12">
                    	<div class="form-group">
                    		<span class="help-block">&nbsp;</span>
                    		<button type="button" class="btn green" onclick="findSolicitudes()">Buscar</button>
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
              	 	<i class="fa fa-cogs"></i>&nbsp;Solicitudes &nbsp;
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
            			<th>&nbsp;</th>
            			</tr>
          			</thead>
          			<tbody>                   
                         
          			</tbody>
        		</table>  
      		</div>             
    	</div>
    </div>
</div>
<!----------------------------------------- Informacion de la Solicitud-------------------------------------------->
<div class="modal fade" id="portlet-atender" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog" style="width: 80%;">
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close"data-dismiss="modal" aria-hidden="true" ></button>
        <h4 class="modal-title">Información de la Solicitud <label id="idmodal">1</label> </h4>
        <div style="text-align: right !important;"><button type="button"  data-dismiss="modal" class="btn green right" style="text-align: right;">Cerrar Ticket</button></div>
      </div>
      <div class="modal-body" style="height:520px  !important;overflow-y:scroll;overflow-y:auto;">
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6">             
              <div class="form-group">
                <label><strong>Descripción</strong></label>
              </div>
            </div>
            <div class="col-md-6">             
              <div class="form-group">
                <label><strong>Descripción</strong></label>
              </div>
            </div>
          </div>        
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-12"> 
              <hr>
            </div>
          </div>        
        </div>        
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-9">             
              <div class="form-group">
                <label>Mensaje</label>
                <textarea class="form-control" rows="4" placeholder="Escribe..."></textarea>
              </div>
            </div>
            <div class="col-md-3">             
              <div class="form-group">
                <span class="help-block">&nbsp;</span>
                <button type="button" class="btn blue"><i class="fa fa-check"></i> Guardar</button>
                <br>
                <br>
                <span class="btn green fileinput-button">
                  <i class="fa fa-plus"></i>&nbsp;
                  <span>Adjuntar</span>
                  <input type="file" name="file" id="file">
                </span>
              </div>
            </div>
          </div>        
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-12">
              <div class="addtableMsg">
                <table class="table table-hover" id="sample_7">
                  <thead>
                    <tr>
                      <th>Mensajes</th>
                    </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>mensaje mensaje mensaje</td>
                  </tr>   
                  <tr>
                    <td>mensaje mensaje mensaje</td>
                  </tr> 
                  <tr>
                    <td>mensaje mensaje mensaje</td>
                  </tr> 
                  <tr>
                    <td>mensaje mensaje mensaje</td>
                  </tr> 
                  <tr>
                    <td>mensaje mensaje mensaje</td>
                  </tr> 
                  <tr>
                    <td>mensaje mensaje mensaje</td>
                  </tr>
                  <tr>
                    <td>mensaje mensaje mensaje</td>
                  </tr>
                  <tr>
                    <td>mensaje mensaje mensaje</td>
                  </tr>
                  <tr>
                    <td>mensaje mensaje mensaje</td>
                  </tr> 
                  <tr>
                    <td>mensaje mensaje mensaje</td>
                  </tr>                
                  </tbody>
                </table>
              </div>
            </div>
          </div>          
        </div>
      </div>
      <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn green" >Cerrar Ticket</button>
      </div>   
    </div>
  </div>
</div>
@endsection

@section('scripts')
	<script>
	jQuery(document).ready(function() {
    TableManaged2.init2();
    TableManaged7.init7();
    });

   	function findSolicitudes(){
    	var noSolicitud=$("#noSolicitud").val();
    	var opTipoSolicitud=$("#opTipoSolicitud").val();
    	var opEstatus=$("#opEstatus").val();
    	var formdata = new FormData();

    	if(noSolicitud.length>0){
    		formdata.append("id_solicitud", noSolicitud);  
    	}else if(opTipoSolicitud !="0" && opEstatus !="0"){
    		formdata.append("estatus", opEstatus);    
    		formdata.append("tipo_tramite", opTipoSolicitud);   
    	}else if(opTipoSolicitud != "0"){
    		formdata.append("tipo_tramite", opTipoSolicitud);  
    	}else if( opEstatus != "0"){
    		formdata.append("estatus", opEstatus);    
    	}else{
    		Command: toastr.warning("campo Tipo Solitud / Estatus / Numero de Solitud, requerido!", "Notifications");
    		return;
    	}
    	formdata.append("_token", '{{ csrf_token() }}');  
    	$.ajax({
           method: "POST", 
           contentType: false,
            processData: false,
           url: "{{ url('/filtrar-solicitudes') }}",
           data: formdata })
        .done(function (response) {
        	//var Resp=$.parseJSON(response);
            addtable();
            //console.log(response);
            //console.log(JSON.stringify(response));
            if(JSON.stringify(response)=='[]')
            	{TableManaged2.init2();  return;}
            var Resp=$.parseJSON(JSON.stringify(response));
            $.each(Resp, function(i, item) {
            	$('#sample_2 tbody').append("<tr>"
                	+"<td>"+item.id+"</td>"
                	+"<td>"+item.titulo+"</td>"
                	+"<td>"+item.mensaje+"</td>"
                	+"<td>"+item.descripcion+"</td>"
                	+ "<td class='text-center' width='20%'><a class='btn default btn-xs blue-stripe' href='#portlet-atender' data-toggle='modal' data-original-title='' title='Atender' onclick='findAtender(\""+item.id+"\")'> Atender </a></td>"
                	+"</tr>"
                );
            });
        	TableManaged2.init2();   
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
  	}
  	function addtable(){
    	$("#addtables div").remove();
    	$("#addtables").append("<div id='removetable'><table class='table table-hover' id='sample_2'> <thead><tr><th>ID</th><th>Titulo</th><th>Mensaje</th><th>Descripción</th><th>&nbsp;</th> </tr></thead> <tbody></tbody> </table></div>");
    }
    function findAtender(id)
    {
      document.getElementById("idmodal").textContent=id;
    }
	</script>
@endsection
