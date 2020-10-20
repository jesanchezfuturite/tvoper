@extends('layout.app')

@section('content')
<link href="assets/global/dataTable/dataTables.min.css" rel="stylesheet" type="text/css"/>
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
		            <div class="col-md-1 col-ms-12">
		                <div class="form-group">
		                    <label >Tipo de Solicitud</label>
		                  </div>
		            </div>
		            <div class="col-md-3 col-ms-12">
		                <div class="form-group">           
						    <select class="select2me form-control" name="opTipoSolicitud" id="opTipoSolicitud" onchange="">
						       <option value="limpia">------</option>
						    </select>   
		                </div>
		            </div>
		            <div class="col-md-1 col-ms-12">
		                <div class="form-group">
		                    <label >Estatus</label>
		                  </div>
		            </div>
		            <div class="col-md-3 col-ms-12">
		                <div class="form-group">           
						    <select class="select2me form-control" name="opEstatus" id="opEstatus" onchange="">
						       <option value="limpia">------</option>
						    </select>  
		                </div>
		            </div>
		            <div class="col-md-1 col-ms-12">
                    	<div class="form-group">
                    		<button type="button" class="btn green" onclick="">Buscar</button>
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
        <div class="portlet-body">
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

<!-- modal-dialog -->

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
@endsection

@section('scripts')
	<script src="assets/global/dataTable/dataTables.min.js"></script>
	<script src="assets/global/dataTable/jszip.min.js"></script>
	<script src="assets/global/dataTable/vfs_fonts.js"></script>
	<script>
		jQuery(document).ready(() => {
	    	//getTramites();
	    });
	    /*function getApi( url , fnDone, fnFail, fnAlways ){
	        $.ajax({method: "get", url,data: {_token:'{{ csrf_token() }}'}  }).done(fnDone).fail(fnFail).always(fnAlways);
		}
		function getTramites(){
			let url = "{{ url('/solicitud-tramites') }}";
			getApi( url , ((response) => {  
	        	tramites = JSON.parse(response);
	        	setTramites( $("#tramitesSelect") );
	        }), (( msg ) => {
	         	Command: toastr.warning("No Success", "Notifications") ;
	        }) ,  () => $("#spin-animate").hide())
		}
		function setTramites(element){
        	tramites.forEach(tramite => addOptionToSelect( element, tramite.tramite, tramite.id_tramite ));
		}

		function addOptionToSelect( element, name, key ){
			element.append( new Option(name , key) );
		}*/


	</script>
@endsection
