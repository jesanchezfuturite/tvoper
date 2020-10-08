@extends('layout.app')

@section('content')
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
                <div id="addtable">
                    <table class="table table-hover" id="sample_2">
                    <thead>
                    <tr>
                        <th>Tramite</th>
                        <th>Campo</th>
                        <th>Tipo</th>
                        <th>Caracteristicas</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    </table>
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


@endsection

@section('scripts')
<script>
    jQuery(document).ready(function() {
    TableManaged.init();
      findTramites();
      findCampos();
      findTipos();
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

    function changeTramites()
    {
        var tramite=$("#itemsTramites").val();
        var tramiteMember=$("#itemsTramites option:selected").text();
        if(tramite=="limpia")
        {
            //Command: toastr.warning("Tramite Sin Seleccionar, Requeridoo!", "Notifications")
            document.getElementById("nameTramite").textContent="Tramite";
            addTable();
            TableManaged.init();
        }else{
           document.getElementById("nameTramite").textContent="Tramite "+tramiteMember;
           findRelationship();
        }
    }


     function metodoSaveUpdate()
    {
         var idRelantion=$("#idRelantion").val();
        var itemsTramites=$("#itemsTramites").val();
        var itemsCampo=$("#itemsCampos").val();
        var itemsTipos=$("#itemsTipos").val();
        if(itemsTramites=="limpia"){
           Command: toastr.warning("Tramite sin seleccionar, Requerido!", "Notifications")
        }else if(itemsCampo=="limpia"){
           Command: toastr.warning("Campo sin seleccionar, Requerido!", "Notifications")
        }else if(itemsTipos=="limpia"){
           Command: toastr.warning("Tipo sin seleccionar, Requerido!", "Notifications")
        }else{
            if(idRelantion.length>0)
                {
                    update();
                }else{
                insertTramiteCampos();
            }
        }
    }
    function findRelationship()
    {
        var items=$("#itemsTramites").val();
         var tramiteMember=$("#itemsTramites option:selected").text();
        $.ajax({
           method: "POST",
           url: "{{ url('/traux-get-relcamp') }}",
           data: {tramiteid:items,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        var Resp=$.parseJSON(response);

            addTable();
            $.each(Resp, function(i, item) {
                var car=$.parseJSON(item.caracteristicas);
                $('#sample_2 tbody').append("<tr>"
                +"<td>"+tramiteMember+"</td>"
                +"<td>"+item.campo_nombre+"</td>"
                +"<td>"+item.tipo_nombre+"</td>"
                +"<td>"+item.caracteristicas+"</td>"
                + "<td class='text-center' width='20%'><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='Editar' onclick='relationshipUpdate("+item.id+","+item.campo_id+","+item.tipo_id+","+car.required+")'><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only red' data-toggle='modal'data-original-title='' title='Eliminar' href='#modaldelete' onclick='relationshipDeleted("+item.id+")'><i class='fa fa-minus'></i></a><a class='btn btn-icon-only blue' href='#modalCaracteristica' data-toggle='modal' data-original-title='' title='Agregar Caracteristicas' onclick='relationshipAdd("+item.id+")'><i class='fa fa-pencil'></i></a></td>"
                +"</tr>"
                );
            });
            TableManaged.init();

        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }

    function addTable()
    {
        $('#Removetable div').remove();
        $('#Removetable').append(
            "<div id='addtable'><table class='table table-hover' id='sample_2'> <thead> <tr><th>Tramite</th><th>Campo</th><th>Tipo</th><th>Caracteristicas</th> <th></th></tr> </thead><tbody></tbody></table> </div>"
        );
    }
    function insertTramiteCampos()
    {
        var itemTramite=$("#itemsTramites").val();
        var itemsCampo=$("#itemsCampos").val();
        var itemsTipos=$("#itemsTipos").val();
        var check=$("#checkbox30").prop("checked");
        var valCheck='[{"required":"false"}]';

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
        $.ajax({
           method: "POST",
           url: "{{ url('/traux-add-serv') }}",
           data: {tramiteid:itemTramite,campoid:[itemsCampo],tipoid: [itemsTipos],caracteristicas:[valCheck], _token:'{{ csrf_token() }}'}
       })
        .done(function (response) {
            CleanInputs();
            findRelationship();
            Command: toastr.success("Success", "Notifications")
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

    }
    function relationshipUpdate(id_,campo,tipo,carac)
    {
        document.getElementById('idRelantion').value=id_;
        $("#itemsTipos").val(tipo).change();
        $("#itemsCampos").val(campo).change();
        if(carac==true)
        {
            $("#checkbox30").prop("checked", true);
        }else{
            $("#checkbox30").prop("checked", false);
        }


    }
    function relationshipDeleted(id_)
    {
        document.getElementById('iddeleted').value=id_;

    }
    function relationshipAdd(campo){
      $("#idcampo").val(campo);
    }

    function saveCaracteristica(){
      var idCampo = $("#idcampo").val();
      var nombre = $("#nombre").val();
      var valor = $("#valor").val();
      console.log("id "+idCampo+" nombre:"+nombre+" valor:"+valor);
      $.ajax({
        method : "POST",
        url: "{{url('/traux-add-caract')}}",
        data: { id:idCampo, nombre:nombre, valor:valor, _token:"{{ csrf_token() }}"},

        success: function(info){
          if(info.Code != 200)
          {
            console.log(info.Message);
            return false;
          }else{
            // cerramos el modal
            console.log(info.Message);
            $("#nombre").empty();
            $("#valor").empty();
          }
        }
      })
      .done(function (response) {
          CleanInputs();
          findRelationship();
          $("#modalCaracteristica .close").click();
          Command: toastr.success("Success", "Notifications")

      });

    }

    function update()
    {
        var idRelantion=$("#idRelantion").val();
        var itemTramite=$("#itemsTramites").val();
        var itemsCampo=$("#itemsCampos").val();
        var itemsTipos=$("#itemsTipos").val();
        var check=$("#checkbox30").prop("checked");
        var valCheck='[{"required":"false"}]';
        if(check==true)
        {
            valCheck='{"required":"true"}';
        }else{
            valCheck='{"required":"false"}';
        }
        $.ajax({
           method: "POST",
           url: "{{ url('/traux-edit-relcamp') }}",
           data: {id:idRelantion,tramiteid:itemTramite,campoid:[itemsCampo],tipoid: [itemsTipos],caracteristicas:[valCheck], _token:'{{ csrf_token() }}'}
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


</script>

@endsection
