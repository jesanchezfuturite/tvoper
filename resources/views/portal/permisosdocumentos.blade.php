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
                    		<button type="button" class="btn green" onclick="findTramiteSolicitud()">Buscar</button>
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
                      <tr>
                    <td>ID</td>
                    <td>Titulo</td>
                    <td>Estatus</td>
                    <td>Fecha de Ingreso</td>
                  <td align="center"><input type="checkbox"   data-toggle='modal' href='#portlet-update' class="make-switch tooltips" checked data-on-color="success" data-off-color="danger" onchange="updatePermisos(1,22222)" id="check_1"></td>
                  </tr> 
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
                <p>
             ¿<label id="lbl_habilitar" style="color: #cb5a5e;"></label> permisos de descarga de documentos firmados?</p>
              <span class="help-block">&nbsp;</span>
             
            <label>Folio: </label>  <label id="lbl_folio" style="color: #cb5a5e;"></label> 
                
            </div>
            <div class="modal-footer">
                <div id="AddbuttonDeleted">
         <button type="button" data-dismiss="modal" class="btn default" onclick="cerrarModal()">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminaRol()">Confirmar</button>
        </div>
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
    
    document.getElementById("lbl_folio").textContent=folio;
    $('#portlet-update').modal('show');    
     if($("#check_"+id).prop("checked") == true)
    {
       document.getElementById("lbl_habilitar").textContent="Habilitar";
    }else{
       document.getElementById("lbl_habilitar").textContent="Deshabilitar";
    }
    document.getElementById("id_registro").value=id;
  }
  function cerrarModal()
  {var id=$("#id_registro").val();
    console.log($("#check_"+id).prop("checked") );
    
    if($("#check_"+id).prop("checked"))
    {
       $("#check_1").prop("checked", false);

    }else{
       $("#check_1").prop("checked", true);
    }

  }
  function findTramiteSolicitud(){
    	var folio=$("#folio").val();
    	 
    	$.ajax({
           method: "POST", 
           url: "{{ url('/') }}",
           data: formdata })
        .done(function (response) {
        	//var Resp=$.parseJSON(response);
            addtable();
            if(JSON.stringify(response)=='[]')
            	{TableManaged2.init2();  return;}
            var Resp=$.parseJSON(JSON.stringify(response));
                       
            $.each(Resp, function(i, item) {
             
            	$('#sample_2 tbody').append("<tr>"
                	+"<td>"+item.id+"</td>"
                	+"<td>"+item.titulo+"</td>"
                	+"<td>"+item.descripcion+"</td>"
                	+"<td>"+item.created_at+"</td>"
                	+ bton
                	+"</tr>"
                );
            });;
        	TableManaged2.init2();   
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
  	}
  function addtable(){
    $("#addtables div").remove();
    $("#addtables").append("<div id='removetable'><table class='table table-hover' id='sample_2'> <thead><tr><th>ID</th><th>Titulo</th><th>Estatus</th><th>Fecha Ingreso</th><th>&nbsp;</th> </tr></thead> <tbody></tbody> </table></div>");
  }
  function limpiar()
  {
    document.getElementById("").value="";
    
  }
	</script>
@endsection
