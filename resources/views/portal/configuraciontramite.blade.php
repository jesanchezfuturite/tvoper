@extends('layout.app')

@section('content')
<style>
  .sortable { list-style-type: none; margin: 0; padding: 0;  }
 
  .sortable li { margin: 0 3px 3px 3px; padding: 0.5em; padding-left: 1.5em; font-size: 16px; height: 3em !important; background: #fff;}
  </style>
<h3 class="page-title">Portal <small>Asignación de campos por trámite</small></h3>
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
            <a href="#">Asignación de campos por trámite</a>
        </li>
    </ul>
</div>
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Info:</strong> Esta configuración te permite...
</div>
<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Tramites
            </div>
        </div>
        <div class="portlet-body">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-2 col-ms-12">
                        <div class="form-group">
                            <span class="help-block"></span>
                            <label >Tramites (Selecciona)</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-ms-12">
                        <div class="form-group">
                            <select class="select2me form-control"name="itemsTramites" id="itemsTramites" onchange="findAgrupaciones()">
                                <option value="limpia">------</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-ms-12">
                        <div class="form-group">
                            <span class="help-block"></span>
                            <label >Tipo Tramite (Selecciona)</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-ms-12">
                        <div class="form-group">
                            <select class="select2me form-control"name="itemsCategoria" id="itemsCategoria">
                                <option value="0">------</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-ms-12 checkfile">
                        <span class="help-block"></span>
                       <div class='md-checkbox'>
                            <input type='checkbox' id='checkbox1' name="checkFile" class='md-check '  onclick="insertPrelacion()">
                                <label for='checkbox1'>
                                <span></span>
                                <span class='check'></span> <span class='box'>
                            </span>  Prelación. </label>
                        </div>
                    </div>                              
                </div>
                <div class="row">
                <div class="col-md-2 col-ms-12 checkdivisa">
                        <span class="help-block"></span>
                       <div class='md-checkbox'>
                            <input type='checkbox' id='checkbox2' name="checkdivisa" class='md-check '  onclick="divisa()">
                                <label for='checkbox2'>
                                <span></span>
                                <span class='check'></span> <span class='box'>
                            </span> Configurar divisa. </label>
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
            <div class="caption">
                <i class="fa fa-bank"></i>Agregar Agrupacion
            </div>
            <div class="tools" id="removeBanco">
                    <a href="#portlet-orden" data-toggle="modal" class="config" data-original-title="" title="Orden" onclick="findAgrupacionesOrden()">
                    </a>
            </div>
        </div>
        <div class="portlet-body">
        <div class="form-body">
        <div class="row">
            <div class="col-md-2 col-ms-12">
                <div class="form-group">
                    <label class="sr-only" for="agrupacionNombre">Nueva Agrupacion</label>
                    <input type="text" class="form-control" id="agrupacionNombre"name="agrupacionNombre" autocomplete="off"placeholder="Nueva Agrupación...">
                </div>
            </div>
             <div class="col-md-1 col-ms-12">
                <div class="form-group">
                    <button type="button" class="btn green" onclick="SaveGrupo()">Agregar</button>
                </div>
            </div>
            <div class="col-md-3 col-ms-12">
                <div class="form-group">
                    <label >Agrupaciones Registrados (Selecciona)</label>   
                  </div>
            </div>
            <div class="col-md-3 col-ms-12">
                <div class="form-group">           
                        <select class="select2me form-control"name="itemsAgrupaciones" id="itemsAgrupaciones" onchange="changeTramites()">
                           <option value="0">------</option>
                           
                        </select>            
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
                    <i class="fa fa-cogs"></i>&nbsp;<span id="nameTramite">Tramite</span> &nbsp;
                    <!--    <span class="label label-sm label-danger">
                            <label id='changeStatus'>No found</label>
                        </span>&nbsp;&nbsp;&nbsp;&nbsp;
                        --->

                </div>
                <div class="tools" id="removeBanco">
                    <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="Agregar Cuenta">
                    </a>
                   <a id="Remov" href="javascript:;" data-original-title="" title="" ><i class='fa fa-remove' style="color:#d7eaf8 !important;"></i>
                    </a>
                </div>
            </div>
            <div class="portlet-body" id="Removetable">
                <span class="help-block"> &nbsp;</span>
                <div id="addtable">                    
                    <ul id="sortable" class="sortable"style="cursor: -webkit-grab; cursor: grab;">
                           
                        </ul>
                </div>
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->

</div>
<div id="modaldelete" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="CleanInputs()"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
             ¿Eliminar Registro?
                </p>
                 <input hidden="true" type="text" name="iddeleted" id="iddeleted" class="iddeleted">
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default" onclick="CleanInputs()">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="deleted()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="CleanInputs()"></button>
                <h4 class="modal-title">Configurar Tramite</h4>
            </div>
            <div class="modal-body">
                    <div class="form-body">
                        <input hidden="true" type="text"  placeholder="Ingrese una Cuenta" id="idRelantion">
                        <div class="modal-body">
                         <input hidden="true" type="text"  id="idupdate">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label >Campo</label>
                                        <select class="select2me form-control"  id="itemsCampos">
                                            <option>------</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Tipo</label>
                                        <select class="select2me form-control"  id="itemsTipos" onchange="changeTipo()">
                                            <option>------</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row radioTipos">
                            <div class="col-md-12">
                                <div class="col-md-8">
                                    <span class="help-block">File Selecciona el tipo. </span>
                                      <div class="md-radio-inline">
                                        <div class="md-radio">
                                          <input type="radio" id="radio4" name="radio3" class="md-radiobtn" value="pdf" >
                                          <label for="radio4">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            Pdf.</label>
                                        </div>|
                                        <div class="md-radio">
                                          <input type="radio" id="radio5" name="radio3" class="md-radiobtn" value="xlsx" >
                                            <label for="radio5">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                              Excel.</label>
                                        </div>|
                                        <div class="md-radio">
                                          <input type="radio" id="radio6" name="radio3" class="md-radiobtn" value="docx" >
                                            <label for="radio6">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                              Word.</label>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class='col-md-4'>
                                    <div class='form-group'>
                                        <label >Caracteristicas</label>
                                        <div class='md-checkbox'>
                                            <input type='checkbox' id='checkbox30' name="checkbox30" class='md-check'>
                                            <label for='checkbox30'>
                                                <span></span>
                                                <span class='check'></span> <span class='box'>
                                            </span>  Requerido. </label>
                                        </div>
                                        <span class='help-block'>Marque</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-10">
                                <button type="button" class="btn blue" onclick="metodoSaveUpdate()"><i class="fa fa-check"></i> Guardar</button>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn default" onclick="CleanInputs()">Cerrar</button>
                    </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</div>
<div class="modal fade" id="modalCaracteristica" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="CleanInputs()"></button>
            <h4 class="modal-title">Caracteristicas del campo</h4>
        </div>
        <div class="modal-body">
            <div class="form-body">
                <input type="hidden" id="idcampo" >
                <input type="hidden" id="idTipo" >
                <div class="modal-body">
                  <input hidden="true" type="text"  id="idAdd">
                  <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label >Nombre</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" >
                                </div>
                            </div>
                        </div>
                    </div>
                  <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Value</label>
                                    <input type="text" name="valor" id="valor" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-10">
                            <button type="button" class="btn blue" onclick="saveCaracteristica()"><i class="fa fa-check"></i> Guardar</button>
                        </div>
                    </div>
                  </div>
                  
                </div>
                <div class="modal-footer">
                      <button type="button" data-dismiss="modal" class="btn default" onclick="CleanInputs()">Cerrar</button>
                  </div>
            </div>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>


<!-----------------------------------------MODAL DETALLES--------------------------->
<div class="modal fade" id="portlet-detalles" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog" style="width: 80%;">
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close"data-dismiss="modal" aria-hidden="true" ></button>
        <h4 class="modal-title">Detalles </h4>
      </div>
      <div class="modal-body" style="height:520px  !important;overflow-y:scroll;overflow-y:auto;">
        <input type="text" name="idTicket" id="idTicket" hidden="true">
       
        <div class="row">
          <div class="col-md-12" id="detalles">
            <div class='col-md-4'>
                <div class='form-group'>
                    <label><strong>Nombre del Campo:</strong></label>
                    <br><label id="campoName"></label>
                </div>
            </div>
            <div class='col-md-4'>
                <div class='form-group'>
                    <label><strong>Tipo Campo:</strong></label>
                    <br><label id="tipoCampo"></label>
                </div>
            </div>
          </div>    
        </div>
        <div class="row">
          <div class="col-md-12" id="addTable2">
           <div id="removeTable2">                 
                <table class="table table-hover" id="sample_2">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Value</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
          </div>    
        </div>
      </div>
      <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn default" onclick="CleanInputs()">Cerrar</button>
        </div>  
    </div>
  </div>
</div>
<!-----------------------------------------MODAL ORDEN GRUPOS--------------------------->
<div class="modal fade" id="portlet-orden" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog" style="width: 70%;">
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close"data-dismiss="modal" aria-hidden="true" ></button>
        <h4 class="modal-title">Agrupación Orden </h4>
      </div>
      <div class="modal-body" style="height:520px  !important;overflow-y:scroll;overflow-y:auto;">  

        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12" id="AgrOrden">
                    <div id="addOrden">                    
                        <ul id="sortableOrden" class="sortable"style="cursor: -webkit-grab; cursor: grab;">
                           
                        </ul>
                    </div>
                </div>
            </div>    
        </div>
      </div>
      <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn default" >Cerrar</button>
        </div>  
    </div>
  </div>
</div>
<div class="modal fade" id="portlet-edit-agr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="cleanAgrEdit()"></button>
            <h4 class="modal-title">Editar Agrupación</h4>
        </div>
        <div class="modal-body">
            <div class="form-body">
                <div class="modal-body">
                  <input hidden="true" type="text"  id="id_agr">
                  <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label >Nombre</label>
                                    <input type="text" name="editnombre" id="editnombre" class="form-control" placeholder="Nombre Agrupación">
                                </div>
                            </div>
                        </div>
                    </div>
                  <div class="row">
                        <div class="form-group">
                            <div class="col-md-10">
                            <button type="button" class="btn blue" onclick="updateGrupo()"><i class="fa fa-check"></i> Guardar</button>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                      <button type="button" data-dismiss="modal" class="btn default" onclick="cleanAgrEdit()">Cerrar</button>
                  </div>
            </div>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>
<div id="modaldeleteAgr" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="cleanAgrEdit()"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
             ¿Eliminar Registro?
                </p>
                 <input hidden="true" type="text" name="iddeletedAgr" id="iddeletedAgr" class="iddeletedAgr">
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default" onclick="cleanAgrEdit()">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="deletedAgr()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('scripts')
<script>
    jQuery(document).ready(function() {
        findTramites();
        findCampos();
        findTipos();
        $(".checkfile").css("display", "none");
        $(".checkdivisa").css("display", "none");
        $(".radioTipos").css("display", "none");
        findTipoCategoria();
    });

    function changeTipo()
    {
       var tipo=$("#itemsTipos").val();
        if(tipo=="7")
        { $(".radioTipos").css("display", "block");

        }else{
             $(".radioTipos").css("display", "none");
        }
    }
    function insertPrelacion()
    {
        var id_tramite_=$("#itemsTramites").val();
        var check=$("#checkbox1").prop("checked");
        //console.log(check);
        $.ajax({
           method: "POST",
           url: "{{ url('/traux-prelacion') }}",
           data: {id_tramite:id_tramite_,prelacion:check,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
         if(response.Code =="200"){
            Command: toastr.success(response.Message, "Notifications")
            }else{
                Command: toastr.warning(response.Message, "Notifications")
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        
    }
    function findAgrupacionesOrden()
    {   id_=$("#itemsTramites").val();
    
        $.ajax({
           method: "POST",
           url: "{{ url('/traux-agrupacion') }}",
           data: {id_tramite:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        var Resp=$.parseJSON(response);
        var categoria="limpia";
             $('#AgrOrden div').remove();
            $('#AgrOrden').append("<div id='addOrden'><ul id='sortableOrden' class='sortable'style='cursor: -webkit-grab; cursor: grab;'></ul></div>");
            $.each(Resp, function(i, item) {
                $('#sortableOrden').append( "<li class='ui-state-default'>"+
                    "<div class='col-md-1' hidden='true'> <input type='checkbox' name='iAgrupacion' value='"+item.id+"' > </div>"+
                    " <div class='col-md-1'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span></div>"+
                   "<div class='col-md-8'>"+item.descripcion+" </div>  <div class='col-md-3'>"+
                   "<a class='btn btn-icon-only blue' href='#portlet-edit-agr' data-toggle='modal' data-original-title='' title='Editar' onclick='agrupacionUpdate("+item.id+",\""+item.descripcion+"\")' style='color:#FFF !important;'><i class='fa fa-pencil'></i></a>"+
                   /*"<a class='btn btn-icon-only red' data-toggle='modal'data-original-title='' title='Eliminar' href='#modaldeleteAgr' onclick='agrupacionDeleted("+item.id+")' style='color:#FFF !important;'><i class='fa fa-minus'></i></a>"+*/
                    "</div></li>"
                );
            });
            $( "#sortableOrden" ).sortable();
             $( "#sortableOrden" ).disableSelection();
            $( "#sortableOrden" ).sortable({
                update: function( event, ui ) {
                findAgrupaciones();
                updatePositionsAgr();
                }
            });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
    function agrupacionUpdate(id,desc)
    {
        document.getElementById('editnombre').value=desc;
        document.getElementById('id_agr').value=id;
    }
    function cleanAgrEdit()
    {
        document.getElementById('editnombre').value="";
        document.getElementById('iddeletedAgr').value="";
    }
    function cleanAgr()
    {
        
        document.getElementById('id_agr').value="";
        
        $('#AgrOrden div').remove();
        $('#AgrOrden').append("<div id='addOrden'><ul id='sortableOrden' class='sortable'style='cursor: -webkit-grab; cursor: grab;'></ul></div>");
    }
    function agrupacionDeleted(id)
    {
        document.getElementById('iddeletedAgr').value=id;
    }
    function insertCampoFile()
    {
        var itemTramite=$("#itemsTramites").val();
        var check=$("#checkbox1").prop("checked");
        var option_="";
        if(check==true)
        {
            option_="1";
        }else{
            option_="2";
        }
        $.ajax({
           method: "POST",
           url: "{{ url('/addFile') }}",
           data: {id_tramite:itemTramite,option:option_, _token:'{{ csrf_token() }}'}
       })
        .done(function (response) {
           if(response.Code=="200"){    
                Command: toastr.success(response.Message, "Notifications");
            }else{            
                Command: toastr.warning(response.Message, "Notifications");
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });

    }
     function findTipoCategoria()
    {
        $.ajax({
           method: "get",
           url: "{{ url('/listarCategorias') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        var Resp=$.parseJSON(response);
            $("#itemsCategoria option").remove();
            $("#itemsCategoria").append("<option value='limpia'>-------</option>");
            $.each(Resp, function(i, item) {
                $("#itemsCategoria").append("<option value='"+item.id+"'>"+item.descripcion+"</option>");
            });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
    function findTramites()
    {
        $.ajax({
           method: "get",
           url: "{{ url('/traux-get-serv') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        var Resp=$.parseJSON(response);
            $("#itemsTramites option").remove();
            $("#itemsTramites").append("<option value='limpia'>-------</option>");
            $.each(Resp, function(i, item) {
                $("#itemsTramites").append("<option value='"+item.id+"'>"+item.desc+"</option>");
            });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
    function findCampos()
    {

        $.ajax({
           method: "get",
           url: "{{ url('/traux-get-camp') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            //console.log(response);
            var Resp=$.parseJSON(response);
            $("#itemsCampos option").remove();
            $("#itemsCampos").append("<option value='limpia'>-------</option>");
            $.each(Resp, function(i, item) {
                $("#itemsCampos").append("<option value='"+item.id+"'>"+item.desc+"</option>");
            });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
    function findTipos()
    {
        $.ajax({
           method: "get",
           url: "{{ url('/traux-get-tcamp') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        var Resp=$.parseJSON(response);
            $("#itemsTipos option").remove();
            $("#itemsTipos").append("<option value='limpia'>-------</option>");
            $.each(Resp, function(i, item) {
                
                $("#itemsTipos").append("<option value='"+item.id+"'>"+item.desc+"</option>");
                
            });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
     function findAgrupaciones()
    {   id_=$("#itemsTramites").val();
        $('#Removetable div').remove();             
        $("#itemsAgrupaciones").val("limpia").change();
        $("#checkbox2").prop("checked", false);
        if(id_=="limpia")
        {   $("#checkbox1").prop("checked", false);
            $("#checkbox2").prop("checked", false);
            $("#itemsAgrupaciones option").remove();
            $("#itemsAgrupaciones").append("<option value='limpia'>-------</option>");            
            $("#itemsCategoria").val("limpia").change();
            $(".checkfile").css("display", "none");
            $(".checkdivisa").css("display", "none");

            return;
        }else{
            $(".checkfile").css("display", "block");
            $(".checkdivisa").css("display", "block");


        }

        $.ajax({
           method: "POST",
           url: "{{ url('/traux-agrupacion') }}",
           data: {id_tramite:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        var Resp=$.parseJSON(response);
        var categoria="limpia";
        var check=false;
        var divisaCheck=false;
            $("#itemsAgrupaciones option").remove();
            $("#itemsAgrupaciones").append("<option value='limpia'>-------</option>");
            $.each(Resp, function(i, item) {
                $("#itemsAgrupaciones").append("<option value='"+item.id+"'>"+item.descripcion+"</option>");
                    categoria=item.id_categoria;
                    check=item.check;
                    divisaCheck=item.divisa;
            });

            $("#itemsCategoria").val(categoria).change();
            $("#checkbox1").prop("checked", check);
            $("#checkbox2").prop("checked", divisaCheck);
            /*if(iCheck=="1")
            {
                $("#checkbox1").prop("checked", true);
            }else{  
                $("#checkbox1").prop("checked", false);
            }*/
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
     function changeTramites()
    {
        var tramite=$("#itemsTramites").val();
        var agrupacion=$("#itemsAgrupaciones").val();
        var tramiteMember=$("#itemsTramites option:selected").text();
        if(agrupacion=="limpia"){
            //Command: toastr.warning("Tramite Sin Seleccionar, Requeridoo!", "Notifications")
            document.getElementById("nameTramite").textContent="Tramite";
            $('#Removetable div').remove();

        }else if(tramite=="limpia")
        {
            Command: toastr.warning("Tramite Sin Seleccionar, Requeridoo!", "Notifications")
            document.getElementById("nameTramite").textContent="Tramite";
            $('#Removetable div').remove();
        } else{
           document.getElementById("nameTramite").textContent="Tramite "+tramiteMember;
           findRelationship();
        }
    }
    function findRelationship()
    {
        var items=$("#itemsTramites").val();
        var agrupacion=$("#itemsAgrupaciones").val();
        $.ajax({
           method: "POST",
           url: "{{ url('/traux-get-relcamp') }}",
           data: {tramiteid:items,agrupacion_id:agrupacion,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        var Resp=$.parseJSON(response);

            $('#Removetable div').remove();
            $('#Removetable').append("<div id='addtable'><ul id='sortable' class='sortable'style='cursor: -webkit-grab; cursor: grab;'></ul></div>");
            $.each(Resp, function(i, item) {
                var car=JSON.stringify(item.caracteristicas);
                var data=JSON.stringify(item);
                $('#sortable').append( "<li class='ui-state-default'>"+
                    "<div class='col-md-1' hidden='true'> <input type='checkbox' name='iCampos' value='"+item.id+"' > </div>"+
                    " <div class='col-md-1'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span></div>"+
                   "<div class='col-md-7'>"+item.campo_nombre+" </div>  <div class='col-md-3'>"+
                   "<a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='Editar' onclick='relationshipUpdate("+item.id+","+item.campo_id+","+item.tipo_id+","+car+")' style='color:#FFF !important;'><i class='fa fa-pencil'></i></a>"+
                   "<a class='btn btn-icon-only red' data-toggle='modal'data-original-title='' title='Eliminar' href='#modaldelete' onclick='relationshipDeleted("+item.id+")' style='color:#FFF !important;'><i class='fa fa-minus'></i></a>"+
                   "<a class='btn btn-icon-only blue' href='#modalCaracteristica' data-toggle='modal' data-original-title='' title='Agregar Caracteristicas' onclick='relationshipAdd("+item.id+","+item.tipo_id+")' style='color:#FFF !important;'><i class='fa fa-plus'></i></a>"+

                   "<a class='btn btn-icon-only blue' href='#portlet-detalles' data-toggle='modal' data-original-title='' title='Detalles' onclick='detalles("+data+")' style='color:#FFF !important;'><i class='fa fa-list'></i></a>"+
                    "</div></li>"
                );
            });
            $( "#sortable" ).sortable();
             $( "#sortable" ).disableSelection();
            $( ".sortable" ).sortable({
                update: function( event, ui ) {
                updatePositions();
                }
            });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
    function detalles(data)
    {
        //console.log(data);
        addtable();
        document.getElementById("campoName").textContent=data.campo_nombre;
        document.getElementById("tipoCampo").textContent=data.tipo_nombre;
        var soli=$.parseJSON(data.caracteristicas);
        var ops;
        for (n in soli) {  
            obj=n;
            tipo=soli[n]; 
            if(obj!="opciones")
            {
                tipo=JSON.stringify(tipo);
                $('#sample_2 tbody').append("<tr>"
                +"<td>"+obj+"</td>"
                +"<td>"+tipo+"</td>"
                +"</tr>"
                );
            }else{
                ops=JSON.stringify(tipo);
            }                         
        }
        if(ops!=null)
        {
            
            $('#sample_2 tbody').append("<tr><td>opciones</td><td>&nbsp;</td></tr>");
            ops=$.parseJSON(ops);
            console.log(ops);
            $.each(ops, function(i, item) {
                var v=item;
                console.log(v);
                for (n in v) {
                    $('#sample_2 tbody').append("<tr>"
                        +"<td>"+n+"</td>"
                        +"<td>"+v[n]+"</td>"
                        +"</tr>"
                    );
                }
        }   );
        }
       

    }
    function addtable()
  {
    $("#addTable2 div").remove();
    $("#addTable2").append("<div id='removeTable2'><table class='table table-hover' id='sample_2'> <thead><tr><th>Nombre Caracteristica<th>Value</th></tr> </thead> <tbody></tbody> </table></div>");
     //TableManaged3.init3();

  }
    function relationshipUpdate(id_,campo,tipo,carac)
    {
        document.getElementById('idRelantion').value=id_;
        $("#itemsTipos").val(tipo).change();
        $("#itemsCampos").val(campo).change();
        carac=$.parseJSON(carac);
        //console.log(carac.required);
        if(carac.required=="true")
        {
            $("#checkbox30").prop("checked", true);
        }else{
            $("#checkbox30").prop("checked", false);
        }
        if(tipo==7)
        {
            $("input[name=radio3][value='"+carac.accept+"']").prop("checked",true);
        }
    }
    function relationshipDeleted(id_)
    {
        document.getElementById('iddeleted').value=id_;
    }
    function relationshipAdd(campo,idtipo){
      $("#idcampo").val(campo);
      $("#idTipo").val(idtipo);
    }

     function metodoSaveUpdate()
    {
         var idRelantion=$("#idRelantion").val();
        var itemsTramites=$("#itemsTramites").val();
        var itemsCampo=$("#itemsCampos").val();
        var itemsTipos=$("#itemsTipos").val();
        var option = document.querySelector('input[name = radio3]:checked');

        var itemsAgrupaciones=$("#itemsAgrupaciones").val();
        if(option!=null)
        {
            option = document.querySelector('input[name = radio3]:checked').value;
        }
        if(itemsAgrupaciones=="limpia"){
           Command: toastr.warning("Agrupación sin seleccionar, Requerido!", "Notifications")
           return;
        }else if(itemsTramites=="limpia"){
           Command: toastr.warning("Tramite sin seleccionar, Requerido!", "Notifications")
           return;
        }else if(itemsCampo=="limpia"){
           Command: toastr.warning("Campo sin seleccionar, Requerido!", "Notifications")
           return;
        }else if(itemsTipos=="limpia"){
           Command: toastr.warning("Tipo sin seleccionar, Requerido!", "Notifications")
           return;
        }else if(itemsTipos==7)
        {
            if(option==null){
                Command: toastr.warning("Selecciona el Tipo File, Requerido!", "Notifications")
                return;
            }
            
        }

        if(idRelantion.length>0)
            {
                update();
            }else{
                insertTramiteCampos();
        }
        
    }
     function insertTramiteCampos()
    {
        var itemTramite=$("#itemsTramites").val();
        var itemsCampo=$("#itemsCampos").val();
        var itemsTipos=$("#itemsTipos").val();
        var itemsAgrupaciones=$("#itemsAgrupaciones").val();
        var check=$("#checkbox30").prop("checked");
        var valCheck='[{"required":"false"}]';
        var option = document.querySelector('input[name = radio3]:checked');
        if(option!=null)
        {
            option = document.querySelector('input[name = radio3]:checked').value;
        }
        if(check==true)
        {
          if(itemsTipos == 3 || itemsTipos == 4 || itemsTipos == 5 || itemsTipos == 6){
            valCheck='{"required":"true", "opciones":[]}';
          }else{
            valCheck='{"required":"true"}';
          }
        }else{
          if(itemsTipos == 3 || itemsTipos == 4 || itemsTipos == 5 || itemsTipos == 6){
            valCheck='{"required":"false", "opciones":[]}';
          }else{
            valCheck='{"required":"false"}';
          }

        }
        var contador=1;
        $("input:checkbox[name=iCampos]:unchecked").each(function(){
            if($(this).val() !="on")
            {               
                contador=contador+1; 
            }
        });
        $.ajax({
           method: "POST",
           url: "{{ url('/traux-add-serv') }}",
           data: {tramiteid:itemTramite,campoid:[itemsCampo],tipoid: [itemsTipos],caracteristicas:[valCheck],agrupacion_id:itemsAgrupaciones,orden:contador,fileT:option, _token:'{{ csrf_token() }}'}
       })
        .done(function (response) {
             if(response.Code =="200"){
                Command: toastr.success(response.Message, "Notifications")
                CleanInputs();
                findRelationship();
            }else{
                Command: toastr.warning(response.Message, "Notifications")
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });

    }
    function update()
    {
        var idRelantion=$("#idRelantion").val();
        var itemTramite=$("#itemsTramites").val();
        var itemsCampo=$("#itemsCampos").val();
        var itemsTipos=$("#itemsTipos").val();
        var check=$("#checkbox30").prop("checked");
        var valCheck='[{"required":"false"}]';
        var option = document.querySelector('input[name = radio3]:checked');
        if(option!=null)
        {
            option = document.querySelector('input[name = radio3]:checked').value;
        }
        if(check==true)
        {
            valCheck='{"required":"true"}';
        }else{          
            valCheck='{"required":"false"}';
        }
        $.ajax({
           method: "POST",
           url: "{{ url('/traux-edit-relcamp') }}",
           data: {id:idRelantion,tramiteid:itemTramite,campoid:[itemsCampo],tipoid: [itemsTipos],caracteristicas:[valCheck],fileT:option, _token:'{{ csrf_token() }}'}
       })
        .done(function (response) {
            
            if(response.Code =="200"){
                Command: toastr.success(response.Message, "Notifications")
                CleanInputs();
                findRelationship();
            }else{
                 Command: toastr.warning(response.Message, "Notifications")
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });

    }
    function saveCaracteristica(){
      var idCampo = $("#idcampo").val();
      var idTipo = $("#idTipo").val();
      var nombre = $("#nombre").val();
      var valor = $("#valor").val();
      //console.log("id "+idCampo+" nombre:"+nombre+" valor:"+valor);
      $.ajax({
        method : "POST",
        url: "{{url('/traux-add-caract')}}",
        data: { id:idCampo,tipo:idTipo, nombre:nombre, valor:valor, _token:"{{ csrf_token() }}"},

        success: function(info){
          if(info.Code != 200)
          {
            console.log(info.Message);
            return false;
          }else{
            // cerramos el modal
            console.log(info.Message);   
          }
        }
      })
      .done(function (response) {
        if(response.Code=="200")
          {CleanInputs();
          //findRelationship();
          changeTramites();
         document.getElementById('nombre').value="";
         document.getElementById('valor').value="";
          //$("#modalCaracteristica .close").click();
          Command: toastr.success(response.Message, "Notifications")
        }else{
            Command: toastr.warning(response.Message, "Notifications")
        }
      });

    }
    function updatePositions()
    {
        const fdata = [];
        var contador=1;
        $("input:checkbox[name=iCampos]:unchecked").each(function(){
            if($(this).val() !="on")
            {
                fdata.push({id : $(this).val(), orden: contador})  
                contador=contador+1; 
            }         
            
        });
        //console.log(fdata);
         $.ajax({
           method: "POST",
           url: "{{ url('/guardar-orden') }}",
           data: {data: fdata,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        
    }
    function updatePositionsAgr()
    {
        const fdata = [];
        var contador=1;
        $("input:checkbox[name=iAgrupacion]:unchecked").each(function(){
            if($(this).val() !="on")
            {
                fdata.push({id : $(this).val(), orden: contador})  
                contador=contador+1; 
            }         
            
        });
        //console.log(fdata);
         $.ajax({
           method: "POST",
           url: "{{ url('/guardar-orden-agrupacion') }}",
           data: {data: fdata,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        
    }
    function SaveGrupo()
    {
        var agrup=$("#agrupacionNombre").val();
        var tramite_id=$("#itemsTramites").val();
        var categoria_id=$("#itemsCategoria").val();
        if(agrup.length==0){
            Command: toastr.warning("Campo agrupación, Requerido!", "Notifications");
            return ;
        }else if(tramite_id=="limpia")
        {
            Command: toastr.warning("Selecciona el Tramite, Requerido!", "Notifications");
            return ;
        }else if(categoria_id=="limpia"){
            Command: toastr.warning("Selecciona Tipo Tramite, Requerido!", "Notifications");
            return ;
        }
        //console.log(fdata);
        var contador=1;
        $("input:checkbox[name=iAgrupacion]:unchecked").each(function(){
            if($(this).val() !="on")
            {               
                contador=contador+1; 
            }
        });
         $.ajax({
           method: "POST",
           url: "{{ url('/guardar-agrupacion') }}",
           data: {descripcion: agrup,id_tramite:tramite_id,id_categoria:categoria_id,orden:contador,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            if(response.Code=="200"){          
                document.getElementById('agrupacionNombre').value=""; 
                Command: toastr.success(response.Message, "Notifications");
                findAgrupaciones();
            }else{            
                Command: toastr.warning(response.Message, "Notifications");
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        
    }
    function updateGrupo()
    {
        var agrup=$("#editnombre").val();
        var id_agr=$("#id_agr").val();
        var tramite_id=$("#itemsTramites").val();
        var categoria_id=$("#itemsCategoria").val();
        if(agrup.length==0){
            Command: toastr.warning("Campo agrupación, Requerido!", "Notifications");
            return ;
        }else if(tramite_id=="limpia")
        {
            Command: toastr.warning("Selecciona el Tramite, Requerido!", "Notifications");
            return ;
        }else if(categoria_id=="limpia"){
            Command: toastr.warning("Selecciona Tipo Tramite, Requerido!", "Notifications");
            return ;
        }
        //console.log(fdata);
         $.ajax({
           method: "POST",
           url: "{{ url('/edit-agrupacion') }}",
           data: {id:id_agr,descripcion: agrup,id_tramite:tramite_id,id_categoria:categoria_id,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            if(response.Code=="200"){          
                cleanAgr(); 
                Command: toastr.success(response.Message, "Notifications");
                findAgrupacionesOrden();
            }else{            
                Command: toastr.warning(response.Message, "Notifications");
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        
    }
    function CleanInputs()
    {
         //document.getElementById('caracteristica').value="";
         //document.getElementById('itemMetodopago').value="limpia";
         $("#itemsTipos").val("limpia").change();
         $("#itemsCampos").val("limpia").change();
         document.getElementById('idRelantion').value="";
         document.getElementById('iddeleted').value="";
        $("#checkbox30").prop("checked", false);
        $(".radioTipos").css("display", "none");
        $("input:radio").attr("checked", false);

    }
    function deleted()
    {
        var idRelantion=$("#iddeleted").val();
        $.ajax({
           method: "POST",
           url: "{{ url('/traux-del-relcamp') }}",
           data: {id:idRelantion, _token:'{{ csrf_token() }}'}
       })
        .done(function (response) {
            CleanInputs();
            findRelationship();
            if(response.Code =="200"){
            Command: toastr.success(response.Message, "Notifications")
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });

    }
    function divisa(){
        var id_tramite_=$("#itemsTramites").val();
        var check=$("#checkbox2").prop("checked");
        $.ajax({
           method: "POST",
           url: "{{ url('/traux-divisa') }}",
           data: {id_tramite:id_tramite_,divisa:check,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
         if(response.Code =="200"){
            Command: toastr.success(response.Message, "Notifications")
            }else{
                $("#checkbox2").prop('checked', false); 
                Command: toastr.warning(response.Message, "Notifications")
            }
        })
        .fail(function( msg ) {
         $("#checkbox2").prop('checked', false); 
         Command: toastr.warning("No Success", "Notifications")  });
        
    }
</script>

@endsection
