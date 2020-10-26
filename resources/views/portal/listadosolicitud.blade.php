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
    <!-- BEGIN SAMPLE TABLE PORTLET-->
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
              			<th>Mensaje</th>
              			<th>Descripción</th>
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

<!-- modal-dialog -->
<!----------------------------------------- Nuevo Rol Tramite-------------------------------------------->
<div class="modal fade" id="portlet-atender" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog" style="width: 80%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"data-dismiss="modal" aria-hidden="true" ></button>
        <h4 class="modal-title">Configuracion Solicitudes</h4>
        <input hidden="true" type="text" name="idtramite" id="idtramite">
      </div>
      <div class="modal-body">
      	&nbsp;
      	&nbsp;
      	&nbsp;
      	&nbsp;
      	&nbsp;
      	&nbsp;
      	&nbsp;
      	&nbsp;
      	&nbsp;
      	&nbsp;
      	&nbsp;
      <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn default" >Cerrar</button>
      </div>
    </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
	<script>
	jQuery(document).ready(function() {
    TableManaged2.init2();
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
                	+ "<td class='text-center' width='20%'><a class='btn default btn-xs blue-stripe' href='#portlet-atender' data-toggle='modal' data-original-title='' title='Atender'> Atender </a></td>"
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
	</script>
@endsection
