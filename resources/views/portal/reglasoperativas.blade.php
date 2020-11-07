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
		        </div>
		      </div>
          <div class="col-md-3 col-ms-12">
            <div class="form-group">      
              <select class="select2me form-control" name="opTramite" id="opTramite" onchange="findCampos()">
                  <option value="0">------</option>
                  @foreach($tramites as $tr)
                    <option value="{{$tr['id_tramite']}}">{{$tr["nombre"]}}</option>
                  @endforeach            
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
            <i class="fa fa-cogs"></i>&nbsp;Reglas Operativos Campos &nbsp;
          </div>
        </div>
        <div class="tools" id="toolsSolicitudes">                
          <a href="#" data-toggle="modal" class="config" data-original-title="" title=""></a>
        </div>
      </div>
      <div class="portlet-body">
        <span class="help-block">&nbsp;</span>
    		  <div class="row" id="addCampos">
            
          </div> 
          <span class="help-block">&nbsp;</span>  
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


<input type="text" name="campos" id="campos" hidden="true">
<input type="text" name="variables" id="variables" hidden="true" value="">
<input type="text" name="" hidden="true">
@endsection

@section('scripts')
	<script>
	jQuery(document).ready(function() {
    
    });
    function findCampos()
    { 
      var id_=$("#opTramite").val();
      $("#addCampos").empty();
      $.ajax({
           method: "POST", 
           url: "{{ url('/reglas-tmt-relationship') }}",
           data:{id:id_, _token:'{{ csrf_token() }}'} })
        .done(function (response) {
          //console.log(response);
          document.getElementById("campos").value=response;
          var Resp=$.parseJSON(response);
          $.each(Resp, function(i, item) {           
            $("#addCampos").append("<div class='col-md-4'><div class='form-group'>"+
              "<div class=' col-md-4'><select class='select2me form-control' name='opTramite' id='"+item.campo_id+"'> <option value='0'>------</option></select></div>"+
              " <label class='col-md-3'>"+item.campo_id+"</label><span class='help-block'>&nbsp;</span> </div></div>");

          });
          addselects();
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    }
    function addselects()
    {
      var ABC=['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'Ñ', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
      var campos=$("#campos").val();
      var Resp=$.parseJSON(campos);
      //ABC=$.parseJSON(ABC);
        $.each(Resp, function(i, item) {
          $("#"+item.campo_id+" option").remove();
          $("#"+item.campo_id).append("<option value='0'>------</option>");
           ABC.forEach(function(ab) {                
                $("#"+item.campo_id).append("<option value='"+ab+"'>"+ab+"</option>");
            });
        });
    }

  </script>
@endsection
