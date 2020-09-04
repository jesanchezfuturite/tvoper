@extends('layout.app')

@section('content')
<h3 class="page-title">Portal <small>Solicitudes</small></h3>
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
            <a href="#">Solicitudes</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Agregar Solicitud
            </div>
        </div>
        <div class="portlet-body">
	        <div class="form-body">
		        <div class="row">
		            <div class="col-md-3 col-ms-12">
		                <div class="form-group">
		                    <label >Trámites</label>
		                  </div>
		            </div>
		            <div class="col-md-3 col-ms-12">
		                <div class="form-group">           
						    <select class="select2me form-control" name="tramitesSelect" id="tramitesSelect" onchange="updateTablaSolicitudes()">
						       <option value="limpia">------
						        </option>
						    </select>
							<i class="fa fa-spin fa-spinner" id="spin-animate"></i>    
		                </div>
		            </div>
		            <div class="col-md-2 col-ms-12">
		                <div class="form-group" id="addButton">
		                    
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
                <a href="#add-solicitud-modal"  onclick="setTramites()" data-toggle="modal" class="config" data-original-title="" title="Agregar Solicitud">
                </a>
               	<a id="Remov" href="javascript:;" data-original-title="" title="Desactivar Banco" onclick="desactivaSolicitud()">
               		<i class='fa fa-remove' style="color:white !important;"></i>
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-scrollable" id="tablaSolicitudesDiv">
               <table id="example" class="table table-hover" cellspacing="0" width="100%" >
				    <thead>
				        <tr>
				            <th></th>
				            <th>Titulo</th>
				            <th></th>
				        </tr>
				    </thead>
				</table>
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->

</div>

<div class="modal fade" id="add-solicitud-modal" tabindex="-1" data-backdrop="static" role="dialog" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Agregar</h4>
            </div>
            <div class="modal-body">
	             <form action="#" class="form-horizontal">    
	                <div class="form-body">
	                    <input hidden="true" type="text"  id="idupdate">
	                    <input hidden="true" type="text"  id="padre_id">
	                    <div class="row">
	                        <div class="col-md-12">                        
	                           <div class="form-group">
	                                <label class="col-md-3 control-label ">Titulo</label>
	                                <div class="col-md-8">
	                                    <input id="titulo" class="valida-num form-control" autocomplete="off" placeholder="Ingresar Titulo">
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-lg-12">
	                        	<div class="form-group">
		                            <label class="col-md-3 control-label">Trámite</label>
		                            <div class="col-md-8">
		                                <select class="select2me form-control" name="tramitesSelectModal" id="tramitesSelectModal">
		                                	<option value="limpia">------</option>
								    	</select>   
		                            </div>
		                        </div>
	                        </div>
	                        <div class="col-lg-12">
	                        	<div class="form-group">
		                            <label class="col-md-3 control-label">Usuario</label>
		                            <div class="col-md-8">
		                                <select class="select2me form-control" placeholder="Usuario"  multiple name="usuarioSelectModal" id="usuarioSelectModal">
								    	</select>   
		                            </div>
		                        </div>
	                        </div>	                        
	                    </div>         
                        <div class="form-group">
                        	<div class="col-md-10"> 
                                <button type="button" id="btnSav" class="btn blue" onclick="verificaInsert()">
                                	<i class="fa fa-check" id="iconBtnSave"></i> 
                                	Guardar
                                </button>
                            </div>
                        </div>
	                    <div class="modal-footer">
	                        <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cerrar</button>
	                    </div>                        
	                </div>
	             </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- modal-dialog -->
@endsection

@section('scripts')
	<script src="assets/global/dataTable/dataTables.min.js"></script>
	<script src="assets/global/dataTable/jszip.min.js"></script>
	<script src="assets/global/dataTable/vfs_fonts.js"></script>
	<script>
		var tramites = [];
		let tablaSolicitudes = $("#example").clone(true);
		function getTramites(){
	        $.ajax({
		        method: "get",            
		        url: "{{ url('/solicitud-tramites') }}",
		        data: {_token:'{{ csrf_token() }}'}  })
	        .done((response) => {  
	        	tramites = JSON.parse(response);
	        	tramites.forEach(tramite => {
					let option = new Option(tramite.tramite, tramite.id_tramite);
					$("#tramitesSelect").append(option);
	        	});
	        })
	        .fail(function( msg ) {
	         	Command: toastr.warning("No Success", "Notifications") 
	        }).always( () =>{
	        	$("#spin-animate").hide();
	        } );
		}

		function setTramites(){
        	tramites.forEach( (tramite, index) => {
				let option = new Option(tramite.tramite, tramite.id_tramite, index == 0);
				$("#tramitesSelectModal").append(option);
        	});
        	getUsers();
		}

		function getUsers(){
	        $.ajax({
		        method: "get",            
		        url: "{{ url('/solicitud-getUsers') }}",
		        data: {_token:'{{ csrf_token() }}'}  })
	        .done((response) => {  
	        	console.log(  response )
	        	let usuarios = JSON.parse(response);
	        	usuarios.forEach(usuario => {
					let option = new Option(usuario.nombre + " - " + usuario.email , usuario.id);
					$("#usuarioSelectModal").append(option);
	        	});
	        })
	        .fail(function( msg ) {
	         	Command: toastr.warning("No Success", "Notifications") 
	        });			
		}


		function updateTablaSolicitudes(){
			let url = "{{ url('/solicitud-all') }}?" + "_token=" + '{{ csrf_token() }}' +"&id_tramite="+ $("#tramitesSelect").val();
			createTable( url);
		}

		function createTable( url){
				var table = $('#example').DataTable();
                table.destroy();    

				$('#example').DataTable( {
		            "ajax": {
		            	"url":url,"dataSrc":""
		            },  
		            "columns": [
		            	{
					     	"data": "id_solcitud",
						    "render": function ( data, type, row, meta ) {
						    	console.log( data, type, row, meta )
						      return '<a onclick="showSolicitudesHijas(' + data +" , " + meta.row +')" ><i class="fa fa-plus"></a>';
						    }
					    },
		           		{ "data": "titulo" },
		           		{
		           			"data": "id_solcitud",
		           			"render": function ( data, type, row, meta ) {
		           				let botonEditar = "<a class='btn btn-icon-only blue' data-toggle='modal' data-original-title='' title='Editar' onclick='openModalUpdate("+ data +" , " + meta.row + ")'><i class='fa fa-pencil'></i></a>";
		           				let botonAddSolicitudDependiente = "<a class='btn btn-icon-only blue' data-toggle='modal' data-original-title='' title='Agregar solicitud dependiente' onclick='openModalUpdate("+ data +" , " + meta.row + ", true)'><i class='fa fa-code-fork'></i></a>"
						      return botonEditar + botonAddSolicitudDependiente ;
						    }
		           		}
		        	]
		    });
		}

		function openModalUpdate( data, row, isDependiente ){
			$("#add-solicitud-modal") .modal({
			    show: 'true'
			}); 
			setTramites();
			if( !isDependiente ){
				var table = $('#example').DataTable();
				var data = table
				    .rows( row )
				    .data()[0];
				$("#titulo").val( data.titulo );
				$("#tramitesSelectModal option[value=" +  data.tramite_id +"]").attr('selected','selected').change();
	        	//$("#usuarioSelectModal option:selected").val("").change(); 
	    	} else {
	    		$("#padre_id").val( data );
	    	}
		}

		function showSolicitudesHijas( idSolicitud, row ){
			console.log(row)
		}

		function verificaInsert(e){
			
	        let titulo=$("#titulo").val();
	        let tramitesSelectModal= $("#tramitesSelectModal").val();
	        let status = 1;
	        let usuariosArray = $("#usuarioSelectModal").val();

			var id_=$("#idupdate").val();
	        
	        if(titulo.length<1) {
	            Command: toastr.warning("Campo Titulo, Requerido!", "Notifications")
	        } else if( tramitesSelectModal == "limpia"){
				Command: toastr.warning("Campo Trámite, Requerido!", "Notifications")
	        } else if( !usuariosArray ){
				Command: toastr.warning("Campo Usuario, Requerido!", "Notifications")
	        } else {
	        	let data = {
	        		titulo, id_tramite:tramitesSelectModal,user:usuariosArray.join(), status,
	        		_token:'{{ csrf_token() }}', padre_id:$("#padre_id").val()
	        	}
	            id_.length == 0 ? insertar( data ) : alert(2);
	        }
		}

		function insertar( data ){
			$("#iconBtnSave").removeClass("fa-check");
	        $("#iconBtnSave").addClass("fa-spin fa-spinner");
	        $("#btnSav").attr("disabled", true)
			$.ajax({
	           method: "post",           
	           url: "{{ url('/solicitud-add') }}",
	           dataType: 'json',
	           data: data
	       	}).done(function (response) {
	          if(response.Code =="200"){
	            Command: toastr.success(response.Message, "Notifications")
	            limpiar();
	          }else{
	            Command: toastr.warning(response.Message, "Notifications")
	          }
	        })
	        .fail(function( msg ) {
	            console.log("Error al Cargar Tabla");  
	        }).always( () =>{
	   			$("#iconBtnSave").removeClass("fa-spin fa-spinner");
	        	$("#iconBtnSave").addClass("fa-check");
	        	$("#btnSav").attr("disabled", false)
	    	});
		}

		function limpiar(){
			$("#padre_id").val("");
	        $("#titulo").val("");
	        $("#tramitesSelectModal option[value=limpia]").attr('selected','selected').change();
	        $("#usuarioSelectModal option:selected").val("").change(); 
		}


		function format ( d ) {
		    // `d` is the original data object for the row
		    return '<table  class="table table-hover" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
		        '<tr>'+
		            '<td>Full name:</td>'+
		            '<td>'+d.name+'</td>'+
		        '</tr>'+
		        '<tr>'+
		            '<td>Extension number:</td>'+
		            '<td>'+d.extn+'</td>'+
		        '</tr>'+
		        '<tr>'+
		            '<td>Extra info:</td>'+
		            '<td>And any further details here (images etc)...</td>'+
		        '</tr>'+
		    '</table>';
		}

	    jQuery(document).ready(() => {
	    	getTramites();
	    });

	</script>
@endsection
