@extends('layout.app')

@section('content')

<h3 class="page-title">Portal <small>Reglas Operativas</small></h3>
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
            <a href="#">Reglas Operativas</a>
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
		          <label >Trámite</label> 
              <span class="help-block">(Selecciona el Trámite)</span>          
						  <select class="select2me form-control" name="opTipoSolicitud" id="opTipoSolicitud" onchange="">
						      <option value="0">------</option>
						   <!-- @foreach($tramites as $tr)
                  <option value="{{$tr['id']}}">{{$tr["tramite"]}}</option>
                @endforeach   
                -->  
						  </select>   
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
          <a href="#" data-toggle="modal" class="config" data-original-title="" title=""></a>
        </div>
      </div>
      <div class="portlet-body" id="addtables">
    		             

    	</div>
    </div>
</div>
<!----------------------------------------- Informacion de la Solicitud-------------------------------------------->
<div class="modal fade" id="portlet-atender" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog" style="width: 80%;">
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close"data-dismiss="modal" aria-hidden="true" ></button>
        <h4 class="modal-title">Información <label id="idmodal">1</label> </h4>
      </div>
      <div class="modal-body">
        <input type="text" name="id" id="id" hidden="true">
        
      </div>
      <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn green" onclick="" >Cerrar</button>
      </div>   
    </div>
  </div>
</div>
@endsection

@section('scripts')
	<script>
	jQuery(document).ready(function() {
    
    });
  	function addtable(){
    	$("#addtables div").remove();
    	$("#addtables").append("<div id='removetable'><table class='table table-hover' id='sample_2'> <thead><tr><th>ID</th><th>Titulo</th><th>Estatus</th><th>Fecha Ingreso</th><th>&nbsp;</th> </tr></thead> <tbody></tbody> </table></div>");
    }
    function findAtender()
    {
      $.ajax({
           method: "GET", 
           url: "{{ url('/') }}" + "/"+id,
           data:{ _token:'{{ csrf_token() }}'} })
        .done(function (response) {
          console.log(response);
          var Resp=response;
          for (n in Resp.campos) {            
              $("#addDetalles").append("<div class='col-md-4'><div class='form-group'><label><strong>"+n+":</strong></label><br><label>"+Resp.campos[n]+"</label></div></div>");            
          }
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    }
@endsection
