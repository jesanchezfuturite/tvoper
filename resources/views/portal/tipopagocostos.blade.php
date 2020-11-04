@extends('layout.app')


@section('content')
<link href="assets/global/css/checkbox.css" rel="stylesheet" type="text/css"/>
<h3 class="page-title">Portal <small>Configuración de Costos</small></h3>
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
            <a href="#">Configuración de Costos</a>
        </li>
    </ul>
</div>
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Info: </strong>Esta configuración te permite dar...
</div>
<div class="row">
 <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title" >
                <div class="caption" id="headerTabla">
                  <div id="borraheader">  <i class="fa fa-cogs"> </i>&nbsp;Configurar Costos</div>
                  </div>
                 <div class="tools">
                    <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="Crear Nuevo">
                    </a>
                   <a id="Remov" href="javascript:;" data-original-title="" title=""><i class='fa fa-remove' style="color:white !important;"></i>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
              <div class="row">
                <span class="help-block"></span>
                <div class='col-md-12 text-right'>
                  <div class='form-group'>
                    <button class='btn blue' onclick='GuardarExcel()'><i class='fa fa-file-excel-o'></i> Descargar CSV</button>
                  </div>
                </div>
                <span class="help-block">&nbsp;</span>
              </div>
            </div>
            <div class="portlet-body" id="addtables">
              <div id="removetable">
              <table class="table table-hover" id="sample_2">
                <thead>
                  <tr>
                    <th>Tramite</th>
                    <th>Tipo</th>
                    <th>Costo</th>
                    <th>Cuota Minimo</th>
                    <th>Cuota Maximo</th>
                    <th>&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                    <tr> <td>No found</td> </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
</div>

<!----------------------------------------- deleted config costo-------------------------------------------->
<div id="portlet-deleted" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
             ¿Eliminar Registro?
                </p>
                 <input hidden="true" type="text" name="iddeleted" id="iddeleted" class="iddeleted">
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="deleteCosto()">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<!----------------------------------------- Nuevo config costo-------------------------------------------->
<div class="modal fade" id="portlet-config" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
        <h4 class="modal-title">Configuracion Costos</h4>
        <input hidden="true" type="text" name="idcosto" id="idcosto">
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-9">
              <div class="form-group">
                <label >Tramite</label>
                <select id="itemsTramites" class="select2me form-control" >
                  <option value="limpia">-------</option>
                </select>
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <label >Tipo</label>
                <select id="itemsTipo" class="select2me form-control" >
                  <option value="limpia">-------</option>
                  <option value="F">Fijo</option>
                  <option value="V">Variable</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-9">
              <div class="form-group">
              <label >Costo</label>
                <span class="help-block">Selecciona una Opcion. </span>
                  <div class="md-radio-inline">
                    <div class="md-radio">
                      <input type="radio" id="radio6" name="radio2" class="md-radiobtn" value="H">
                      <label for="radio6">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span>
                        Hoja.</label>
                    </div>|
                    <div class="md-radio">
                      <input type="radio" id="radio7" name="radio2" class="md-radiobtn" value="M" >
                        <label for="radio7">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span>
                          Millar.</label>
                    </div>|
                    <div class="md-radio">
                      <input type="radio" id="radio8" name="radio2" class="md-radiobtn" value="L" >
                      <label for="radio8">
                      <span></span>
                      <span class="check"></span>
                      <span class="box"></span>
                        Lote. </label>
                    </div>
                    <div class="md-radio">
                      <input type="radio" id="radio9" name="radio2" class="md-radiobtn" value="N">
                      <label for="radio9">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span>
                        No Aplica.</label>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>Este costo depende de un minimo de cuotas?</label>
              <div class="md-radio-inline">
                <div class="md-radio">
                  <input type="radio" id="radio10" name="radio10" class="md-radiobtn" value="si">
                  <label for="radio10">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span>
                    Si.</label>
                </div>
                <div class="md-radio">
                  <input type="radio" id="radio11" name="radio10" class="md-radiobtn" value="no">
                  <label for="radio11">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span>
                    No.</label>
                </div>
              </div>
              <div class="col-md-9">
                <div class="form-group costo-fijo">
                  <label >Costo Fijo</label>
                  <input type="text" class="valida-decimal form-control" name="fijo" id="fijo" placeholder="Ingrese el costo fijo del trámite">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 cuotas">
            <div class="col-md-9">
              <div class="form-group ">
                <label >Cuota Minima</label>
                <input type="text" class="valida-decimal form-control" name="cuotaMin" id="cuotaMin" placeholder="Ingrese Cuota Minima...">
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <label >Cuota Máximo</label>
                <input type="text" class="valida-decimal form-control" name="cuotaMax" id="cuotaMax" placeholder="Ingrese la Cuota Máximo...">
             </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <label >Valor</label>
                <input type="text" class="valida-decimal form-control" name="valor" id="valor" placeholder="Ingrese el valor de la operacion Ej. 0.50">
             </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="form-group">
              <button type="submit" class="btn blue" onclick="saveUpdate()"><i class="fa fa-check"></i> Guardar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--------------------------------------- Nuevo config subsidio ------------------------------------------>
<div class="modal fade" id="portlet-subsidio" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"data-dismiss="modal" aria-hidden="true" onclick="limpiarSub()"></button>
        <h4 class="modal-title">Configuracion Subsidio</h4>
        <input hidden="true" type="text" name="id_subsidio" id="id_subsidio">
        <input hidden="true" type="text" name="id_tramite" id="id_tramite">
        <input hidden="true" type="text" name="id_costo" id="id_costo">
      </div>
      <div class="modal-body">
        <div class="modal-body">

        <div class="row">
          <div class="col-md-12">
            <div class="col-md-9">
              <div class="form-group">
                <label >Partidas</label>
                <select class="select2me form-control" name="itemsPartidas" id="itemsPartidas">
                    <option value="limpia">------</option>

                </select>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-9">
              <div class="form-group">
                <label >Cuotas</label>
                <input type="text" class="valida-decimal form-control" name="cuotas" id="cuotas" placeholder="Ingrese Cuotas...">
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <label >Limite Cuota</label>
                <input type="text" class="valida-decimal form-control" name="cuotaLimit" id="cuotaLimit" placeholder="Ingrese Limite de Cuotas...">
             </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <label ># de Oficio ó Decreto</label>
                <input type="text" class="valida-decimal form-control" name="oficio" id="oficio" placeholder="Ingrese el numero de oficio del subsidio">
             </div>
            </div>
          </div>
        </div>
      <div class="row">
          <div class="col-md-12">
            <div class="col-md-9">
              <div class="form-group">
                <label >Valor de Cuota</label>
                <input type="text" class="valida-decimal form-control" name="uma" id="uma" placeholder="Ingrese Valor de Cuota..." disabled="true">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="form-group">
              <button type="submit" class="btn blue" onclick="save()"><i class="fa fa-check"></i> Guardar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn default" onclick="limpiarSub()">Cerrar</button>
      </div>
    </div>
    </div>
  </div>
</div>
<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
@endsection

@section('scripts')

<script type="text/javascript">
  jQuery(document).ready(function() {
      findCostos();
      ItemsTramite();
      valorCuota();
      findPartidas();

      $('.costo-fijo').css("display", "none");

      $("#radio10").click(function(){
        $(".costo-fijo").css("display","none");
        $(".cuotas").css("display", "block");

      });
      $("#radio11").click(function(){
        $(".costo-fijo").css("display","block");
        $(".cuotas").css("display", "none");
      });
    });

  function ItemsTramite()
    {
        $.ajax({
        method: "get",
        url: "{{ url('/traux-get-tramites') }}",
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            $("#itemsTramites option").remove();
            var Resp=$.parseJSON(response);
            $('#itemsTramites').append(
                "<option value='limpia'>------</option>"
            );
            $.each(Resp, function(i, item) {
                 $('#itemsTramites').append(
                "<option value='"+item.id+"'>"+item.nombre+"</option>"
                   );
                });
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Cargar Select", "Notifications")   });
  }
  function valorCuota()
    {
        $.ajax({
        method: "get",
        url: "{{ url('/traux-get-cuota') }}",
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            var Resp=$.parseJSON(response);
          document.getElementById('uma').value=Resp.cuota_costo;

        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Cargar Select", "Notifications")   });
  }
  //funcion para cargar partidas
  function findPartidas()
  {
      $.ajax({
         method: "get",
         url: "{{ url('/traux-get-partida') }}",
         data: {_token:'{{ csrf_token() }}'}  })
      .done(function (response) {
      var Resp=$.parseJSON(response);
          $("#itemsPartidas option").remove();
          $("#itemsPartidas").append("<option value='limpia'>-------</option>");
          $.each(Resp, function(i, item) {
              $("#itemsPartidas").append("<option value='"+item.id+"'>"+item.id+" - "+item.desc+"</option>");
          });
      })
      .fail(function( msg ) {
       Command: toastr.warning("No Success", "Notifications")  });
  }


  function saveUpdate()
  {
    var upd=$("#idcosto").val();
    var idTramites=$("#itemsTramites").val();
    var tipoTramite=$("#itemsTipo").val();
    var costoF = document.querySelector('input[name = radio10]:checked');
    if(costoF == 'si'){
      var cuotaMin=$("#cuotaMin").val();
      var cuotaMax=$("#cuotaMax").val();
    }else{
      var fijo = $("#fijo").val();
    }


    var valor = $("#valor").val();
    var option = document.querySelector('input[name = radio2]:checked');

    if(option!=null)
    {
      option = document.querySelector('input[name = radio2]:checked').value;
    }
    if(idTramites=='limpia')
    {
      Command: toastr.warning("Selecciona un Tramite, Requerido!", "Notifications")
    }else if(tipoTramite=='limpia')
    {
      Command: toastr.warning("Selecciona un Tipo, Requerido!", "Notifications")
    }else if(option==null)
    {
      Command: toastr.warning("Selecciona el Costo, Requerido!", "Notifications")
    }else
    // else if(cuotaMin.length==0)
    // {
    //   Command: toastr.warning("Campo Couta Minimo, Requerido!", "Notifications")
    // }else if(cuotaMax.length==0)
    // {
    //   Command: toastr.warning("Campo Couta Maximo, Requerido!", "Notifications")
    // }
    {
    if(upd.length==0)
      {
        insertCosto();
      }else{
         updateCosto();
      }
    }
  }
  function insertCosto()
  {
    var idTramites=$("#itemsTramites").val();
    var tipoTramite=$("#itemsTipo").val();
    var cuotaMin=$("#cuotaMin").val();
    var cuotaMax=$("#cuotaMax").val();
    var valor= $("#valor").val();
    var fijo = $("#fijo").val();
    var option = document.querySelector('input[name = radio2]:checked').value;

      $.ajax({
           method: "POST",
           url: "{{ url('/traux-post-tramites') }}",
           data: {tramite:idTramites,tipo:tipoTramite,costo:option,fijo:fijo,minimo:cuotaMin,maximo:cuotaMax, valor:valor,  _token:'{{ csrf_token() }}'}  })
        .done(function (response) {

         if(response.Code =="200"){
            Command: toastr.success(response.Message, "Notifications")
            }
             findCostos();
             limpiar();

        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });

  }

  function OperacionTramite(id_)
  {
    document.getElementById('idcosto').value=id_;
  }
  function addtable()
  {
    $("#addtables div").remove();
    $("#addtables").append("<table class='table table-hover' id='sample_2'> <thead><tr><th>Tramite</th> <th>Tipo</th> <th>Costo</th> <th>Cuota Minimo</th> <th>Cuota Maximo</th><th>Valor</th><th>&nbsp;</th></tr> </thead> <tbody></tbody> </table>");
  }
  function findCostos()
  {

    $.ajax({
      method: "get",
      url: "{{ url('/traux-get-costos') }}",
      data: { _token: '{{ csrf_token() }}' }
      })
      .done(function (response) {
         document.getElementById('jsonCode').value=response;
          var Resp=$.parseJSON(response);
        addtable();
        var tipo="";
        var costo="";
        $.each(Resp, function(i, item) {
          if(item.tipo=='F')
          {tipo="Fijo";}else{tipo="Variable";}

          if(item.costo=='H')
          {costo="Hoja";
          }else if(item.costo=='M')
          {costo="Millar";
        }else if(item.costo=='N')
          {costo="No Aplica";
          }else{ costo="Lote";}
            $('#sample_2 tbody').append("<tr>"
                +"<td>"+item.tramite+"</td>"
                +"<td>"+tipo+"</td>"
                +"<td>"+costo+"</td>"
                +"<td>"+item.minimo+"</td>"
                +"<td>"+item.maximo+"</td>"
                +"<td>"+item.valor+"</td>"
                + "<td class='text-center' width='20%'><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='Editar' onclick='"+"costoUpdate("+item.id+","+item.tramite_id+",\""+item.tipo+"\",\""+item.costo+"\",\""+item.costo_fijo+"\","+item.minimo+","+item.maximo+",\""+item.valor+"\")'><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only red' data-toggle='modal' href='#portlet-deleted' onclick='costoDelete("+item.id+")'><i class='fa fa-minus'></i></a><a class='btn btn-icon-only green' data-toggle='modal' href='#portlet-subsidio' onclick='updatesubsidio("+item.id+","+item.subsidio_id+","+item.tramite_id+",\""+item.cuotas+"\",\""+item.limite_cuotas+"\",\""+item.oficio+"\",\""+item.id_partida+"\")'><i class='fa fa-usd'></i></a></td>"
                +"</tr>"
                );
            });
        TableManaged.init();

    })
    .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function costoDelete(id)
  {
    document.getElementById('iddeleted').value=id;
  }
  function deleteCosto()
  {
    var id_=$("#iddeleted").val();
    $.ajax({
           method: "POST",
           url: "{{ url('/traux-del-tramites') }}",
           data: {id:id_, _token:'{{ csrf_token() }}'}  })
        .done(function (response) {

         if(response.Code =="200"){
            Command: toastr.success(response.Message, "Notifications")
            } limpiar();
             findCostos();


        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function costoUpdate(id,tramite_id,tipo,costo,costo_fijo,minimo,maximo,valor)
  {
    document.getElementById('idcosto').value=id;
    $("#itemsTramites").val(tramite_id).change();
    $("#itemsTipo").val(tipo).change();
    document.getElementById('cuotaMin').value=minimo;
    document.getElementById('cuotaMax').value=maximo;
    $("input[name=radio2][value='"+costo+"']").prop("checked",true);
    document.getElementById('valor').value=valor;
    document.getElementById('fijo').value=costo_fijo;
  }
  function updateCosto()
  {

    var id_=$("#idcosto").val();
    var idTramites=$("#itemsTramites").val();
    var tipoTramite=$("#itemsTipo").val();
    var cuotaMin=$("#cuotaMin").val();
    var cuotaMax=$("#cuotaMax").val();
    var valor=$("#valor").val();
    var fijo = $("#fijo").val();
    var option = document.querySelector('input[name = radio2]:checked').value;

      $.ajax({
           method: "POST",
           url: "{{ url('/traux-edit-tramites') }}",
           data: {id:id_,tramite:idTramites,tipo:tipoTramite,costo:option,minimo:cuotaMin,maximo:cuotaMax, valor:valor,fijo:fijo, _token:'{{ csrf_token() }}'}  })
        .done(function (response) {

         if(response.Code =="200"){
            Command: toastr.success(response.Message, "Notifications")
            }
             findCostos();

        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });

    }
    function updatesubsidio(id_,subsidio_id,tramite_id,cuotas,limite_cuotas, oficio, partidas)
    {
      document.getElementById('id_costo').value=id_;
      document.getElementById('id_tramite').value=tramite_id;
      if(subsidio_id=='null')
      {   subsidio_id=''; }
      if(cuotas=='null')
      { cuotas='';}
      if(limite_cuotas=='null')
      { limite_cuotas=''; }
      if(partidas=='null')
      { partidas=''; }
      if(oficio=='null')
      { oficio=''; }
      document.getElementById('id_subsidio').value=subsidio_id;
      document.getElementById('cuotas').value=cuotas;
      document.getElementById('cuotaLimit').value=limite_cuotas;
      document.getElementById('oficio').value=oficio;
      $("#itemsPartidas").val(partidas).change();
    }
    function save()
    {
      var id_=$("#id_subsidio").val();
      var id_costo=$("#id_costo").val();
      var id_tramite=$("#id_tramite").val();
      var cuotas_=$("#cuotas").val();
      var oficio = $("#oficio").val();
      var cuotaLimit=$("#cuotaLimit").val();
      var partida = $("#itemsPartidas").val();
      $.ajax({
           method: "POST",
           url: "{{ url('/traux-post-subsidios') }}",
           data: {id:id_,tramite:id_tramite,costo_id:id_costo,cuotas:cuotas_,oficio:oficio ,limite_cuotas:cuotaLimit,partida:partida, _token:'{{ csrf_token() }}'}  })
        .done(function (response) {

         if(response.Code =="200"){
            Command: toastr.success(response.Message, "Notifications")
            }
             findCostos();

        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
    function limpiarSub()
    {
      document.getElementById('id_costo').value='';
      document.getElementById('id_tramite').value='';
      document.getElementById('cuotas').value='';
      document.getElementById('cuotaLimit').value='';
      document.getElementById('oficio').value='';
      document.getElementById('itemsPartidas').value='';
    }
    function deleteTipoServicio()
    {
        var id_=$("#idvalor").val();
        $.ajax({
           method: "POST",
           url: "{{ url('/tipo-servicio-delete') }}",
           data: { id:id_, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) {

        if(response=="true")
        {
            ActualizaTabla();
            Command: toastr.success("Success", "Notifications")

        }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function limpiar()
  {
    $("#itemsTramites").val("limpia").change();
    $("#itemsTipo").val("limpia").change();
    document.getElementById('cuotaMin').value="";
    document.getElementById('cuotaMax').value="";
    document.getElementById('fijo').value="";
    document.getElementById('idcosto').value="";
    $("input:radio").attr("checked", false);
    document.getElementById('iddeleted').value="";

}
function GuardarExcel()
{
  var JSONData=$("#jsonCode").val();
  JSONToCSVConvertor(JSONData, "Costos", true)


}
$('.valida-formula').on('input', function () {
    this.value = this.value.replace(/[^0-9./*+()v-]/g,'');
});
$('.valida-decimal').on('input', function () {
    this.value = this.value.replace(/[^0-9.]/g,'');
});
function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
  var f = new Date();
  fecha =  f.getFullYear()+""+(f.getMonth() +1)+""+f.getDate()+"_";
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
    var CSV = '';
    //CSV += ReportTitle + '\r\n\n';
    if (ShowLabel) {
        var row = "";
        for (var index in arrData[0]) {
            row += index + ',';
        }
        row = row.slice(0, -1);
        CSV += row + '\r\n';
    }
    for (var i = 0; i < arrData.length; i++) {
        var row = "";
        for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '",';
        }
        row.slice(0, row.length - 1);
        CSV += row + '\r\n';
    }
    if (CSV == '') {
        alert("Invalid data");
        return;
    }
    document.getElementById("blockui_sample_3_1_1").click();

    var fileName = fecha;
    fileName += ReportTitle.replace(/ /g,"_");
    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
    var link = document.createElement("a");
    link.href = uri;
    link.style = "visibility:hidden";
    link.download = fileName + ".csv";
     Command: toastr.success("Success", "Notifications")
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

</script>
@endsection
