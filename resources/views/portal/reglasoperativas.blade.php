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
           <div id="id_button" style="display: none;">
          <div class='col-md-12'>
            <div class='form-group'>
              <label class=' col-md-1'>Formula</label>
              <div class='col-md-4'> 
                <input type='text' class='form-control' name='formula' id='formula' placeholder='Ingrese la Formula...'><span class='help-block'>&nbsp;</span>
              </div> 
            </div>
          </div>
          <div class='col-md-12' ><div class='form-group'>
            <div class=' col-md-10'></div>
              <div class=' col-md-2'> <button type='submit' class='btn blue' onclick='saveReglas()'><i class='fa fa-check'></i> Guardar</button> </div> </div></div>
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
<input type="text" name="id_regla" id="id_regla" hidden="true">
<input type="text" name="deleteCampos" id="deleteCampos" hidden="true">
@endsection

@section('scripts')
	<script>
	jQuery(document).ready(function() {
    
    });
    function findCampos()
    { 
      var id_=$("#opTramite").val();
      $("#addCampos").empty();
      document.getElementById("id_button").style.display = "none";
      if(id_=="0")
      {
        return;
      }
      findRegla();
      $.ajax({
           method: "POST", 
           url: "{{ url()->('reglas-tmt-relationship') }}",
           data:{id:id_, _token:'{{ csrf_token() }}'} })
        .done(function (response) {
          //console.log(response);
          document.getElementById("campos").value=response;
          var Resp=$.parseJSON(response);
          $.each(Resp, function(i, item) {           
            $("#addCampos").append("<div class='col-md-4'><div class='form-group'>"+
              "<div class=' col-md-4'><select class='select2me form-control' name='opTramite' id='"+item.campo_id+"'> <option value='0'>------</option></select></div>"+
              " <label class='col-md-6'>"+item.descripcion+"</label><span class='help-block'>&nbsp;</span><span class='help-block'>&nbsp;</span> </div></div>");

          });
           document.getElementById("id_button").style.display = "block";
          addselects();
          findConstantes();
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
    function findRegla()
    {
       document.getElementById("id_regla").value='0';
        document.getElementById("formula").value="";
      var id_=$("#opTramite").val();
        $.ajax({
           method: "POST", 
           url: "{{ url()->('reglas-info') }}",
           data:{tramite_id:id_, _token:'{{ csrf_token() }}'} })
        .done(function (response) {
          //console.log(response);
          if(response=="[]")
          {
            return;
          }
           var Resp=$.parseJSON(response);
          $.each(Resp, function(i, item) {
            document.getElementById("id_regla").value=item.id;
            document.getElementById("formula").value=item.definicion;
            });
           
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    }
    function findConstantes()
    {
      var id_=$("#id_regla").val();
      document.getElementById("deleteCampos").value="[]";
      if(id_=="0")
        {return;}
        $.ajax({
           method: "POST", 
           url: "{{ url()->('reglas-cmp') }}",
           data:{regla_id:id_, _token:'{{ csrf_token() }}'} })
        .done(function (response) {
          
          if(response=="[]")
          {
            return;
          }
          document.getElementById("deleteCampos").value=response;
           var Resp=$.parseJSON(response);
          $.each(Resp, function(i, item) {
            $("#"+item.id_campo).val(item.constante).change();
          });
           
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    }
    function deleteConstantes()
    {
      var campos=$("#deleteCampos").val();
      if(campos=="[]")
        {return;}
      var Resp=$.parseJSON(campos);
      $.each(Resp, function(i, item) {
        $.ajax({
           method: "POST", 
           url: "{{ url()->('reglas-delete') }}",
           data:{ id:item.id, _token:'{{ csrf_token() }}'} })
        .done(function (response) {
          
          if(response.Code=="400")  
          {
            Command: toastr.warning(response.Message, "Notifications")
          }         
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
      });
    }
    function saveReglas()
    {
      const fdata = [];
      var repetidos=[];
      var id_=$("#opTramite").val();
      var definicion_=$("#formula").val();
      var campos=$("#campos").val();
      var Resp=$.parseJSON(campos);
      $.each(Resp, function(i, item) {
        var val=$("#"+item.campo_id).val();

        if(val!="0"){
          fdata.push({campo_id : item.campo_id,constante : val})
          repetidos.push(val);
        }
      });
      for (var i = 0; i < repetidos.length; i++) {
        for (var j = 0; j < repetidos.length; j++) {
            if (repetidos[i] == repetidos[j] && i != j) { 
              Command: toastr.warning("Constante repetido letra "+ repetidos[j], "Notifications") 
                return;
             }
         }
      }
        $.ajax({
           method: "POST", 
           url: "{{ url()->('reglas-save') }}",
           data:{tramite_id:id_,definicion:definicion_,campos:fdata, _token:'{{ csrf_token() }}'} })
        .done(function (response) {
          if(response.Code=='200')
          {
            Command: toastr.success(response.Message, "Notifications")
          }else{
             Command: toastr.warning(response.Message, "Notifications")
          }
          //deleteConstantes();
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
      }

  </script>
@endsection
