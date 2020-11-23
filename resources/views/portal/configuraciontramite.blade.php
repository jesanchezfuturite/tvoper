@extends('layout.app')

@section('content')
<style>
  #sortable { list-style-type: none; margin: 0; padding: 0;  }
 
  #sortable li { margin: 0 3px 3px 3px; padding: 0.5em; padding-left: 1.5em; font-size: 16px; height: 3em !important; background: #fff;}
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
                            <select class="select2me form-control"name="itemsTramites" id="itemsTramites" onchange="changeTramites()">
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
                            <select class="select2me form-control"name="itemsTipotramite" id="itemsTipotramite" onchange="changeTramites()">
                                <option value="0">------</option>
                                <option value="imouesto">Impuesto</option>
                                <option value="derecho">Derecho</option>
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
            <div class="caption">
                <i class="fa fa-bank"></i>Agregar Agrupacion
            </div>
        </div>
        <div class="portlet-body">
        <div class="form-body">
        <div class="row">
            <div class="col-md-2 col-ms-12">
                <div class="form-group">
                    <label class="sr-only" for="bancoNombre">Nueva Agrupacion</label>
                    <input type="text" class="form-control" id="bancoNombre"name="bancoNombre" autocomplete="off"placeholder="Nueva Agrupación...">
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
                        <select class="select2me form-control"name="itemsAgrupaciones" id="itemsAgrupaciones" onchange="">
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
                   <a id="Remov" href="javascript:;" data-original-title="" title="Desactivar Tramite" onclick="desactivaTramite()"><i class='fa fa-remove' style="color:white !important;"></i>
                    </a>
                </div>
            </div>
            <div class="portlet-body" id="Removetable">
                <span class="help-block"> &nbsp;</span>
                <div id="addtable">                    
                    <ul id="sortable" class="sortable"style="cursor: -webkit-grab; cursor: grab;">
                            <li class="ui-state-default" >
                              <div class="col-md-1"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>
                                <div class="col-md-8">Campo1 ads d </div>
                                <div class="col-md-2"><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='Editar' onclick='relationshipUpdate()' style="color:#FFF !important;"><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only red' data-toggle='modal'data-original-title='' title='Eliminar' href='#modaldelete' onclick='relationshipDeleted()' style="color:#FFF !important;"><i class='fa fa-minus'></i></a><a class='btn btn-icon-only blue' href='#modalCaracteristica' data-toggle='modal' data-original-title='' title='Agregar Caracteristicas' onclick='relationshipAdd()' style="color:#FFF !important;"><i class='fa fa-pencil'></i></a></div>
                             
                            </li>
                            <li class="ui-state-default" >
                              <div class="col-md-1"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>
                                <div class="col-md-8">Campo2 ads d </div>
                                <div class="col-md-2"><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='Editar' onclick='relationshipUpdate()' style="color:#FFF !important;"><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only red' data-toggle='modal'data-original-title='' title='Eliminar' href='#modaldelete' onclick='relationshipDeleted()' style="color:#FFF !important;"><i class='fa fa-minus'></i></a><a class='btn btn-icon-only blue' href='#modalCaracteristica' data-toggle='modal' data-original-title='' title='Agregar Caracteristicas' onclick='relationshipAdd()' style="color:#FFF !important;"><i class='fa fa-pencil'></i></a></div>
                             
                            </li>
                            <li class="ui-state-default" >
                              <div class="col-md-1"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>
                                <div class="col-md-8">Campo3 ads d </div>
                                <div class="col-md-2"><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='Editar' onclick='relationshipUpdate()' style="color:#FFF !important;"><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only red' data-toggle='modal'data-original-title='' title='Eliminar' href='#modaldelete' onclick='relationshipDeleted()' style="color:#FFF !important;"><i class='fa fa-minus'></i></a><a class='btn btn-icon-only blue' href='#modalCaracteristica' data-toggle='modal' data-original-title='' title='Agregar Caracteristicas' onclick='relationshipAdd()' style="color:#FFF !important;"><i class='fa fa-pencil'></i></a></div>
                             
                            </li>
                            <li class="ui-state-default" >
                              <div class="col-md-1"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>
                                <div class="col-md-8">Campo4 ads d </div>
                                <div class="col-md-2"><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='Editar' onclick='relationshipUpdate()' style="color:#FFF !important;"><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only red' data-toggle='modal'data-original-title='' title='Eliminar' href='#modaldelete' onclick='relationshipDeleted()' style="color:#FFF !important;"><i class='fa fa-minus'></i></a><a class='btn btn-icon-only blue' href='#modalCaracteristica' data-toggle='modal' data-original-title='' title='Agregar Caracteristicas' onclick='relationshipAdd()' style="color:#FFF !important;"><i class='fa fa-pencil'></i></a></div>
                             
                            </li>
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
                                        <select class="select2me form-control"  id="itemsTipos">
                                            <option>------</option>
                                        </select>
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
                                            <input type='checkbox' id='checkbox30' class='md-check'>
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

                    <div class="form-group">
                        <div class="col-md-10">
                            <button type="button" class="btn blue" onclick="metodoSaveUpdate()"><i class="fa fa-check"></i> Guardar</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn default" onclick="CleanInputs()">Cerrar</button>
                    </div>

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
                  <div class="form-group">
                      <div class="col-md-10">
                          <button type="button" class="btn blue" onclick="saveCaracteristica()"><i class="fa fa-check"></i> Guardar</button>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" data-dismiss="modal" class="btn default" onclick="CleanInputs()">Cerrar</button>
                  </div>
                </div>
            </div>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
        findAgrupaciones();
    });
     $( function() {
        $( "#sortable" ).sortable();
        $( "#sortable" ).disableSelection();
      
    } );
    $( ".sortable" ).sortable({
        beforeStop: function( event, ui ) {
           console.log("change"); 
        }
    });
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
    {
        $.ajax({
           method: "get",
           url: "{{ url('/traux-agrupacion') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        var Resp=$.parseJSON(response);
            $("#itemsAgrupaciones option").remove();
            $("#itemsAgrupaciones").append("<option value='limpia'>-------</option>");
            $.each(Resp, function(i, item) {
                $("#itemsAgrupaciones").append("<option value='"+item.id+"'>"+item.descripcion+"</option>");
            });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }


</script>

@endsection
