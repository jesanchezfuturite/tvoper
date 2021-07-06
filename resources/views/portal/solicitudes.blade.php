@extends('layout.app')

@section('content')
<link href="{{asset('assets/global/dataTable/dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
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
    <div class="col-md-12">
        <div class="tabbable-line boxless tabbable-reversed">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_0" data-toggle="tab">Solicitudes</a>
                </li>
                <li>
                    <a href="#tab_1" data-toggle="tab">Proceso de Solicitudes</a>
                </li> 
            </ul>
            <div class="tab-content">                               
                <div class="tab-pane active" id="tab_0">
					<div class="row">
					    <div class="portlet box blue">
					        <div class="portlet-title">
					            
					            <div class="caption" id="headerTabla">
					              	<div id="borraheader"> 
					              	 	<i class="fa fa-cogs"></i>&nbsp;Solicitudes &nbsp;
					            	</div>
					            </div>
					            <div class="tools" id="toolsSolicitudes">                
					                <a href="#add-solicitud-modal"  onclick="setInfoModal(true)" data-toggle="modal" class="config" data-original-title="" title="Agregar Solicitud">
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
					</div>
                </div>
                <div class="tab-pane" id="tab_1">
                	<div class="row">
					    <div class="portlet box blue">
					        <div class="portlet-title">
					            
					            <div class="caption" id="headerTabla">
					              	<div id="borraheader"> 
					              	 	<i class="fa fa-cogs"></i>&nbsp;Proceso &nbsp;
					            	</div>
					            </div>
					            <div class="tools" id="toolsSolicitudes">                
					                <a href="#add-users"   data-toggle="modal" class="config" data-original-title="" title="Agregar Solicitud">
					                </a>
					            </div>
					        </div>
					        <div class="portlet-body" id="addtables">
					            <div >
					               <table id="sample_2" class="table table-hover" cellspacing="0" width="100%" >
									    <thead>
									        <tr>
									            <th>Proceso</th>
									            <th></th>
									        </tr>
									    </thead>
									</table>
					            </div>
					        </div>
					    </div>
					</div>
                </div>
            </div>
        </div>
    </div>
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
	                        <div class="col-lg-12" id="divSelectTramites" hidden>
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
<div class="modal fade" id="add-users" tabindex="-1" data-backdrop="static" role="dialog" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiaUser()"></button>
                <h4 class="modal-title">Agregar Usuarios</h4>
            </div>
            <div class="modal-body">
	             <form action="#" class="form-horizontal">    
	                <div class="form-body">
	                    <div class="row">
	                        <div class="col-lg-12">
	                        	<div class="form-group">
		                            <label class="col-md-3 control-label">Usuario</label>
		                            <div class="col-md-8">
		                                <select class="select2me form-control" placeholder="Usuario"  multiple name="itemsUsuario" id="itemsUsuario">
								    	</select>   
		                            </div>
		                        </div>
	                        </div>	                        
	                    </div>         
                        <div class="form-group">
                        	<div class="col-md-10"> 
                                <button type="button" id="btnVerf" class="btn blue" onclick="verificaInsertUsers()">
                                	<i class="fa fa-check" id="iconBtnSave"></i> 
                                	Guardar
                                </button>
                            </div>
                        </div>
	                    <div class="modal-footer">
	                        <button type="button" data-dismiss="modal" class="btn default" onclick="limpiaUser()">Cerrar</button>
	                    </div>                        
	                </div>
	             </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="modalDelete" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" ></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
             ¿Eliminar Registro?
                </p>
                 <input hidden="true" type="text" name="iddeleted" id="iddeleted" class="iddeleted">
            </div>
            <div class="modal-footer">
	         	<button type="button" data-dismiss="modal" class="btn default" >Cancelar</button>
	            <button type="button"  class="btn green" onclick="eliminar()" id="btnDel">
	            	<i class="fa fa-check" id="iconBtnDel"></i> 
	            	Confirmar
	            </button>
	        </div>
	   </div>
	</div>
</div>
<div class="modal fade" id="portlet-motivos" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"data-dismiss="modal" aria-hidden="true" onclick="limpiarChecks()"></button>
        <h4 class="modal-title">Configurar Motivos de Rechazo</h4>
        <input hidden="true" type="text" name="idcatalogo" id="idcatalogo">
      </div>
      <div class="modal-body" style="height:520px  !important;overflow-y:scroll;overflow-y:auto;">
        <div class="modal-body">
        <div class="row">
           <div class="col-md-12">
            <div class='form-group'>
              <div class="col-md-4"></div>
              <label for="search" class="col-md-2 control-label" >Buscar:</label> 
              <div class="col-md-6"> 
                <input type="text" name="search" id="search" class="form-control" placeholder="Buscar...">
              <!--  <div class='md-checkbox'><input type='checkbox' id='checkbox30' class='md-check'>   <label for='checkbox30'>    <span></span>  <span class='check'></span> <span class='box'></span>Mostrar Todos</label> </div>-->
              </div> 
            </div>
          </div>
        </div>
        <div class="row">
          <div  id="demo">              
            <table class="table table-hover table-wrapper-scroll-y my-custom-scrollbar" id="table2">
              <thead>
                <tr>            
                <th>Selecciona</th>
                </tr>
            </thead>
            <tbody>  
                        
            </tbody>
          </table>
        </div> 
      <br>
        </div>     
    </div>
  </div>
    <div class="modal-footer"><span class="help-block"></span>  
          <button type="button" data-dismiss="modal" class="btn default" onclick="limpiarChecks()">Cerrar</button>
      </div>
    </div>

</div>
</div>
<input type="text" name="jsonCode" id="jsonCode" hidden="true">
<input type="text" name="id_proceso" id="id_proceso" hidden="true">
<input type="text" name="id_catalogo" id="id_catalogo" hidden="true">


@endsection

@section('scripts')
	<script src="{{asset('assets/global/dataTable/dataTables.min.js')}}"></script>
	<script src="{{asset('assets/global/dataTable/jszip.min.js')}}"></script>
	<script src="{{asset('assets/global/dataTable/vfs_fonts.js')}}"></script>
	<script>

	    jQuery(document).ready(() => {
	    	getTramites();
	    	getUsers();
	    	findMotivos();
	    	TableManaged2.init2();

	    });
		var tramites = [];
		var usuarios = [];

		function getApi( url , fnDone, fnFail, fnAlways ){
	        $.ajax({method: "get", url,data: {_token:'{{ csrf_token() }}'}  }).done(fnDone).fail(fnFail).always(fnAlways);
		}

		function getTramites(){
			let url = "{{ url()->route('solicitud-tramites') }}";
			getApi( url , ((response) => {  
	        	tramites = JSON.parse(response);
	        	setTramites( $("#tramitesSelect") );
	        }), (( msg ) => {
	         	Command: toastr.warning("No Success", "Notifications") ;
	        }) ,  () => $("#spin-animate").hide())
		}
		
		function getUsers(){
			let url = "{{ url()->route('solicitud-getUsers') }}";
			getApi( url , ((response) => usuarios = JSON.parse(response)), 
				(( msg ) => {
	         	Command: toastr.warning("No Success", "Notifications") ;
	        }));	
		}

		function setTramites(element){
        	tramites.forEach(tramite => addOptionToSelect( element, tramite.tramite, tramite.id_tramite ));
		}

		function addOptionToSelect( element, name, key ){
			element.append( new Option(name , key) );
		}

		function setUsuarios(){
			usuarios.forEach(usuario => addOptionToSelect( $("#usuarioSelectModal"),  usuario.nombre + " - " + usuario.email , usuario.id ));
			usuarios.forEach(usuario => addOptionToSelect( $("#itemsUsuario"),  usuario.nombre + " - " + usuario.email , usuario.id ));
		}

		function onlyUnique(value, index, self) { 
		    return self.indexOf(value) === index;
		}

		function setInfoModal( ocultarSelect){
			if( !ocultarSelect ) {
				setTramites( $("#tramitesSelectModal")  );
			} else {
				$("#divSelectTramites").hide();
			}
			setUsuarios();
		}


		function updateTablaSolicitudes(){
			let url = "{{ url()->route('solicitud-all') }}?" + "_token=" + '{{ csrf_token() }}' +"&id_tramite="+ $("#tramitesSelect").val();
			createTable( url);
			console.log(url);			
			findCatalogos();
			findProcesos();
		}

		function getTemplateAcciones( data, type, row, meta  ){
			let botonEditar = "<a class='btn btn-icon-only blue' data-toggle='modal' data-original-title='' title='Editar' onclick='openModalUpdate("+  JSON.stringify(row) + ")'><i class='fa fa-pencil'></i></a>";
			let botonEliminar = "<a class='btn btn-icon-only red' data-toggle='modal' title='Eliminar' onclick='openModalDelete( "  + data + " )'><i class='fa fa-minus'></i></a>";
			let botonMotivo = "<a class='btn btn-icon-only green'href='#portlet-motivos' data-toggle='modal' title='Motivos de Rechazo' onclick='openModalMotivo( "  + data + " )'><i class='fa fa-list'></i></a>";
			let botonAddSolicitudDependiente = "<a class='btn btn-icon-only blue' data-toggle='modal' data-original-title='' title='Agregar solicitud dependiente' onclick='openModalUpdate("+  JSON.stringify(row) +", true)'><i class='fa fa-code-fork'></i></a>";
			return botonEditar + botonAddSolicitudDependiente + botonEliminar+botonMotivo;	
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
					     	"class": 'detectarclick',
					     	"width": "3%",
						    "render": function ( data, type, row, meta ) {
						    	return row.hijas.length > 0 ? '<a ><i id="iconShow-' + data  +'" class="fa fa-plus"></a>' : '';
						    }
					    },
		           		{ "data": "titulo" },
		           		{
		           			"data": "id_solcitud",
		           			"render": getTemplateAcciones
		           		}
		        	]
		    });
			$('#example tbody').unbind().on('click', 'td.detectarclick', buildTemplateChild );
		}

		function buildTemplateChild(){
			var table = $('#example').DataTable();
	        var tr = $(this).parents('tr');
	        var row = table.row( tr );
	        if(row.data() && row.data().hijas.length > 0){
		        if ( row.child.isShown() ) {
		            row.child.hide();
		            tr.removeClass('shown');
		        	$("#iconShow-" + row.data().id_solcitud).addClass("fa-plus").removeClass("fa-minus");
		        } else {
		            $("#iconShow-" + row.data().id_solcitud).removeClass("fa-plus").addClass("fa-minus");
		            row.child( "<div style='margin-left:25px; margin-right:200px;'>"  + format(row.data()) + "</div>").show();
		            tr.addClass('shown');
		        }
		    }
		  
		}

		function showMore( solicitud, e){
			var tr = $(e.target).parents('tr');
			if( solicitud.hijas && solicitud.hijas.length > 0 ){

				if(tr.hasClass("shown") ){
					tr.removeClass('shown');
					$("#brothertr-" + solicitud.id_solcitud ).remove();

					$("#iconShowChild-" + solicitud.id_solcitud).addClass("fa-plus").removeClass("fa-minus");
				} else {
					$("#iconShowChild-" + solicitud.id_solcitud).removeClass("fa-plus").addClass("fa-minus");
					tr.addClass('shown');
					$("#trchild-" + solicitud.id_solcitud).after("<tr style='border-left-style: dotted; border-bottom-style: dotted;' id='brothertr-" + solicitud.id_solcitud + "''><td colspan='4'>"  + format( solicitud  ) + "</td></tr>");
				}

			}
		}

		function formularioValido( solicitud ){
			let valido = false;
			if(solicitud.titulo.length<1) {
	            Command: toastr.warning("Campo Titulo, Requerido!", "Notifications");
	        } else if( solicitud.id_tramite == "limpia"){
				Command: toastr.warning("Campo Trámite, Requerido!", "Notifications")
	        } else if( !solicitud.user ){
				Command: toastr.warning("Campo Usuario, Requerido!", "Notifications")
	        } else {
	        	valido = solicitud;
	        }
	        return valido;
		}

		function getSolicitud(){
			let titulo=$("#titulo").val();
			//let selectModalIsVisible = $("#divSelectTramites").is(":visible");selectModalIsVisible ? $("#tramitesSelectModal").val() : $("#tramitesSelect").val();
	        let tramitesSelectModal= $("#tramitesSelect").val();
	        let status = 1;
	        let usuariosArray = $("#usuarioSelectModal").val();
			let id_solcitud= $("#idupdate").val();
			let padre_id = $("#padre_id").val();

			usuariosArray = usuariosArray ? usuariosArray.filter( onlyUnique ) : [];
			return  {
	        		titulo, id_tramite:tramitesSelectModal,user:usuariosArray.join(), status,
	        		_token:'{{ csrf_token() }}', padre_id, id_solcitud
	        	}
		}

		function verificaInsert(e){
			let solicitud = formularioValido( getSolicitud() );
			if( solicitud ){
				let url = solicitud.id_solcitud.length == 0 ? "{{ url()->route('solicitud-add') }}" :"{{ url()->route('solicitud-editar') }}";
	            postUpdate( url, solicitud );
			}
		}

		function postUpdate( url, data ){
			activarSpinner( true);
			$.ajax({
	           method: "post", url,
	           dataType: 'json', data
	       	}).done(  (response) => {
	          if(response.Code =="200"){
	            Command: toastr.success(response.Message, "Notifications")
	            limpiar();
	            $("#add-solicitud-modal").modal("hide");
	            updateTablaSolicitudes();
	          }else{
	            Command: toastr.warning(response.Message, "Notifications")
	          }
	        })
	        .fail( ( msg ) => console.log("Error al Cargar Tabla") )
	        .always( () => activarSpinner( false) );
		}

		function limpiar(){
			$("#padre_id").val("");
			$("#idupdate").val("");
	        $("#titulo").val("");
	        $("#tramitesSelectModal option[value=limpia]").attr('selected','selected').change();
	        $("#usuarioSelectModal").val([]).trigger('change');
		}


		function format ( d ) {		    
		    let html = '<table class="table table-hover">';
		    html += "<tr> <th></th><th>Titulo</th> <th></th></tr>";
			
		    
		    d.hijas.forEach( (solicitud) =>{
		    	let botonEditar = " <a class='btn btn-icon-only blue' data-toggle='modal' data-original-title='' title='Editar' onclick='openModalUpdate("+  JSON.stringify(solicitud) +"  )'><i class='fa fa-pencil'></i></a>";
		    	let botonEliminar = "<a class='btn btn-icon-only red' data-toggle='modal' title='Eliminar' onclick='openModalDelete( "  + solicitud.id_solcitud + " )'><i class='fa fa-minus'></i></a>";
		    	let botonMotivo = "<a href='#portlet-motivos' class='btn btn-icon-only green' data-toggle='modal' tittle='Motivos de Rechazo' onclick='openModalMotivo( "  + solicitud.id_solcitud + " )'><i class='fa fa-list'></i></a>";
		    	let botonAddSolicitudDependiente = "<a class='btn btn-icon-only blue' data-toggle='modal' data-original-title='' title='Agregar solicitud dependiente' onclick='openModalUpdate("+  JSON.stringify(solicitud) +", true)'><i class='fa fa-code-fork'></i></a>";
		   
				let tdShowHijas = solicitud.hijas && solicitud.hijas.length > 0 ? "<a onclick='showMore(" + JSON.stringify(solicitud) +", event)' ><i id='iconShowChild-" + solicitud.id_solcitud  +"' class='fa fa-plus'></a>" : '';
				
		        html += '<tr id="trchild-' + solicitud.id_solcitud +'" ><td style="width:3%;">' + tdShowHijas +'</td><td>'+ solicitud.titulo  + '</td><td>'+ botonEditar +  botonAddSolicitudDependiente +botonEliminar + botonMotivo + '</td></tr>'
		    
		    });
		    html+='</table>';
		    return html;
		}
		
		function openModalUpdate( solicitud, isDependiente ){
			configModal();
			!isDependiente ? setInfoForm( solicitud ) : $("#padre_id").val( solicitud.id_solcitud );
		}

		function eliminar(){
			activarSpinner( true , $("#btnDel"), $("#iconBtnDel"));
			let url =  "{{ url()->route('solicitud-delete') }}";
			let data = { id_solcitud: $("#iddeleted").val(),_token:'{{ csrf_token() }}'}
			$.ajax({
	           method: "post", url,
	           dataType: 'json', data
	       	}).done(  (response) => {
	          if(response.Code =="200"){
	            Command: toastr.success(response.Message, "Notifications")
	            $("#modalDelete").modal("hide");
	            updateTablaSolicitudes();
	          }else{
	            Command: toastr.warning(response.Message, "Notifications")
	          }
	        })
	        .fail( ( msg ) => console.log("Error al Cargar Tabla") )
	        .always( () => activarSpinner( false , $("#btnDel"), $("#iconBtnDel") ) );
		}

		function openModalDelete( id_solcitud){
			$("#iddeleted").val( id_solcitud );
			$("#modalDelete").modal({show: 'true'}); 
		}

		function configModal(){
			$("#add-solicitud-modal").modal({show: 'true'}); 
			setInfoModal();			
		}
		function openModalMotivo(data){
			document.getElementById('idcatalogo').value=data;
			findMotivosSelect(data);
		}
		function setInfoForm( solicitud ){
			$("#titulo").val( solicitud.titulo );
			$("#tramitesSelectModal option[value=" +  solicitud.tramite_id +"]").attr('selected','selected').change();
	        $("#usuarioSelectModal").val(solicitud.atendido_por.split(",")).trigger('change'); 
	        $("#idupdate").val( solicitud.id_solcitud );
	        $("#padre_id").val( solicitud.padre_id );
		}

		function activarSpinner( activar , btn, icono){
			let elementBtn = btn ? btn : $("#btnSav");
			let elementIcono = icono ? icono : $("#iconBtnSave");
			let classRemove = activar ? "fa-check" : "fa-spin fa-spinner";
			let classAdd = activar ? "fa-spin fa-spinner" : "fa-check";
			elementIcono.removeClass(classRemove).addClass(classAdd);
	    	elementBtn.attr("disabled", activar);
		}

	    function findMotivos()
	    {
	    	$("#table2 tbody tr").remove();
			$.ajax({
			    method: "get",            
			    url: "{{ url()->route('get-motivos') }}",
			    data: {_token:'{{ csrf_token() }}'}  })
			    .done(function (response) {     
			        
			        $.each($.parseJSON(response), function(i, item) {                
			            $("#table2").append("<tr>"
			              +"<td> <label  style='cursor:pointer'><input id='ch_"+item.id+"'style='cursor:pointer' name='checkMotivo' type='checkbox'onclick='saveMotivos("+item.id+");' value='"+item.id+"'>&nbsp;"+item.motivo+"</label></td>"
			              +"</tr>"
			            );
			        });
			    })
			.fail(function( msg ) {
			Command: toastr.warning("Error al Cargar Select Rol", "Notifications")   });
	}
	function saveMotivos(id_motivo)
	{
		if($("#ch_"+id_motivo).prop("checked")==true)
		{
			insertMotivos(id_motivo);
		}else{
			deleteMotivos(id_motivo);
		}
	}
	function insertMotivos(id_motivo)
	{
		var catalogo_id=$("#idcatalogo").val();
		$.ajax({
			    method: "POST",            
			    url: "{{ url()->route('create-solicitud-motivo') }}",
			    data: {solicitud_catalogo_id:catalogo_id,motivo_id:id_motivo,_token:'{{ csrf_token() }}'}  })
			    .done(function (response) {     
			        if(response.Code=="200")
			        	{
			        		console.log(response.Message);
			        	}else{
			        		Command: toastr.warning(response.Message, "Notifications") 
			        	}
			        
			    })
			.fail(function( msg ) {
			Command: toastr.warning("Error al Cargar Select Rol", "Notifications")   });
	}
	function deleteMotivos(id_motivo)
	{
		var catalogo_id=$("#idcatalogo").val();
		$.ajax({
			    method: "POST",            
			    url: "{{ url()->route('delete-solicitudes-motivos') }}",
			    data: {solicitud_catalogo_id:catalogo_id,motivo_id:id_motivo,_token:'{{ csrf_token() }}'}  })
			    .done(function (response) { 
			    //console.log(response);    
			        if(response.Code=="200" || response.Code==null)
			        	{
			        		console.log(response.Message);
			        	}else{
			        		Command: toastr.warning(response.Message, "Notifications") 
			        	}
			       
			    })
			.fail(function( msg ) {
			Command: toastr.warning("Error al Cargar Select Rol", "Notifications")   });
	}
	function limpiarChecks()
	{
			$("input:checkbox[name=checkMotivo]").removeAttr("checked");
	}
	function findMotivosSelect(id)
	{
		id=[id];
			$.ajax({
			    method: "get",            
			    url: "{{ url()->route('get-solicitudes-motivos', '') }}",
			    data: {solicitud_catalogo_id:id,_token:'{{ csrf_token() }}'}  })
			    .done(function (response) {     
			        
			        $.each($.parseJSON(response), function(i, item) {                
			            $("#ch_"+item.motivo_id).prop("checked", true);
			        });
			    })
			.fail(function( msg ) {
			Command: toastr.warning("Error al Cargar Select Rol", "Notifications")   });
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
  function addtable()
  {
    $("#addtables div").remove();
    $("#addtables").append("<div><table class='table table-hover' id='sample_2'> <thead><tr><th>Proceso</th><th></th></tr> </thead> <tbody></tbody> </table></div>");
     //TableManaged3.init3();<th>&nbsp;</th>

  }
    function findProcesos()
    {
    	setUsuarios();
    	addtable();
    	var id_tramite=$("#tramitesSelect").val();    	
		$.ajax({
		    method: "get",            
		    url: "{{ url()->route('get-all-procesos','') }}"+"/"+id_tramite,
		    data: {_token:'{{ csrf_token() }}'}  })
		    .done(function (response) {     
		        console.log(response);
		        
		        $("#sample_2 tbody tr").remove();
		        $.each(response, function(i, item) {
		        	var users=item.users;
			        if(typeof users==="undefined")
			        { users=[]; }                
		            $("#sample_2").append("<tr>"
		              +"<td>"+item.descripcion+"</td>"
		              +"<td><a href='#add-users' class='btn btn-icon-only blue' data-toggle='modal' title='Agregar Usuarios' title='Editar' onclick='editarUsers("+  JSON.stringify(users) + ","+item.id+")'><i class='fa fa-plus'></i></a></td>"
		              +"</tr>"
		            );
		        });
		        TableManaged2.init2();
		    })
		.fail(function( msg ) {
		Command: toastr.warning("Error al Cargar Select Rol", "Notifications")   });
	}
	function editarUsers(users,id_proceso)
	{
		console.log(id_proceso);
		var usr=[];
		$.each(users, function(i, item) {                
	       usr.push(item.id);
	    });
	    document.getElementById("jsonCode").value=JSON.stringify(usr);
	    document.getElementById("id_proceso").value=JSON.stringify(id_proceso);
	    $("#itemsUsuario").val(usr).trigger('change');
	}
	function saveUsers()
	{
		var usuariosArray=$("#itemsUsuario").val();
		var id_proceso=$("#id_proceso").val();
		var id_catalogo=$("#id_catalogo").val();
		usuariosArray = usuariosArray ? usuariosArray.filter( onlyUnique ) : [];
		$.ajax({
		    method: "post",            
		    url: "{{ url()->route('agregar-estatus-atencion') }}",
		    data: {catalogo_id:id_catalogo,id_estatus_atencion:id_proceso,user:usuariosArray.join(),_token:'{{ csrf_token() }}'}  })
		    .done(function (response) {     
		        if(response.Code=='200'){
		        	findProcesos();
		            Command: toastr.success(response.Message, "Notifications") 
		        }else{
		            Command: toastr.warning(response.Message, "Notifications") 
		        } 		        
		    })
		.fail(function( msg ) {
		Command: toastr.warning("Error agregar estatus atencion", "Notifications")   });
	}
	function editUsers()
	{
		var usuariosArray=$("#itemsUsuario").val();
		var id_proceso=$("#id_proceso").val();
		var id_catalogo=$("#id_catalogo").val();
		usuariosArray = usuariosArray ? usuariosArray.filter( onlyUnique ) : [];
		$.ajax({
		    method: "post",            
		    url: "{{ url()->route('agregar-estatus-atencion') }}",
		    data: {catalogo_id:id_catalogo,id_estatus_atencion:id_proceso,user:usuariosArray.join(),_token:'{{ csrf_token() }}'}  })
		    .done(function (response) {     
		        if(response.Code=='200'){
		        	findProcesos();
		            Command: toastr.success(response.Message, "Notifications") 
		        }else{
		            Command: toastr.warning(response.Message, "Notifications") 
		        } 		        
		})
		.fail(function( msg ) {
		Command: toastr.warning("Error agregar estatus atencion", "Notifications")   });
	}
	function verificaInsertUsers()
	{
		var users_new=$("#itemsUsuario").val();
		var users=$.parseJSON($("#jsonCode").val());
		var tramite=$("#tramitesSelect").val();
		var id_catalogo=$("#id_catalogo").val();
		if (id_catalogo==0) {
			Command: toastr.warning("Solicitud sin Agregar" , "Notifications") 
			return;
		}else if(tramite=="limpia"){
			Command: toastr.warning("Selecciona el Tramite, Requerido" , "Notifications") 
			return;
		}
		console.log(users);
		console.log(users_new);
		if(users.length==0){
			saveUsers();
		}else if(!checkArrays(users,users_new)){
			editUsers();
		}
	}
	function findCatalogos()
	{
		var id_tramite=$("#tramitesSelect").val();
		$.ajax({
		    method: "get",            
		    url: "{{ url()->route('solicitud-all') }}"+"?id_tramite="+id_tramite,
		    data: {_token:'{{ csrf_token() }}'}  })
		    .done(function (response) {  
		    	response=$.parseJSON(response);  	         
			    var id_catalogo=response[0].id_solcitud;
				if(typeof (id_catalogo)!=="undefined")
				{
					document.getElementById("id_catalogo").value=id_catalogo;
				}else{
					document.getElementById("id_catalogo").value=0;
				}		       
		    })
		.fail(function( msg ) {
		Command: toastr.warning("Error find Catalogo", "Notifications")   });
	
	 
	}
	function limpiaUser()
	{
		$("#itemsUsuario").val([]).trigger('change');
	}

	function checkArrays( arrA, arrB ){
	    if(arrA.length !== arrB.length) return false;
	    var cA = arrA.slice().sort(); 
	    var cB = arrB.slice().sort();
	    for(var i=0;i<cA.length;i++){
	         if(cA[i]!==cB[i]) return false;
	    }
	    return true;
	}
	</script>
@endsection
