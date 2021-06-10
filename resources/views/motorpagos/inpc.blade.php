@extends('layout.app')
@section('content')
<h3 class="page-title">Motor de pagos <small>Configuración INPC</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Motor de pagos</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Configuración INPC</a>
        </li>
    </ul>
</div>

<div class="row">
     <div hidden="true">
  <a href="javascript:;" class="btn green" id="blockui_sample_3_1" >Block</a>
  <a href="javascript:;" class="btn default" id="blockui_sample_3_1_1" >Unblock</a></div>
  <div id="blockui_sample_3_1_element">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box blue" id="Addtable">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs"></i>Registros Indice Nacional de Precios al Consumidor
            </div>
        </div>
        <div class="portlet-body" id="Removetable">           
            <div class="form-group"> 
                <div class="col-md-6">              
                <button class="btn green" href='#portlet-config' data-toggle='modal' >Agregar</button>
                </div>
            </div>
            <div class="form-group">
             <div class="col-md-6 text-right">                
                <button class="btn blue" onclick="GuardarExcel()"><i class="fa fa-file-excel-o"></i> Descargar CSV</button>
              </div>
            </div>
            <span class="help-block">&nbsp; </span>
            
                <table class="table table-hover" id="sample_2">
                <thead>
                <tr>
                    <th>Año</th>
                    <th>Mes</th> 
                    <th>Indice</th>                                       
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                     <td><span class="help-block">No Found</span></td>
                            <td></td>                         
                            <td></td>                                                               
                </tbody>
                </table>
          
        </div>
    </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->    

</div>
<div class="modal fade" id="portlet-config" tabindex="-1" data-backdrop="static" role="dialog" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Agregar</h4>
            </div>
            <div class="modal-body">
                 
                <div class="form-body">
                    <input hidden="true" type="text"  id="idupdate">
                    <div class="row">
                        <div class="col-md-12">                        
                       <div class="form-group">
                            <label class="col-md-3 control-label ">Año</label>
                            <div class="col-md-8">
                                <input id="anio" class="valida-num form-control" maxlength="4"  autocomplete="off" placeholder="Ingresar Año">
                            </div>
                        </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Mes</label>
                            <div class="col-md-8">
                                <select id="mes" class="select2me form-control" >
                                  <option value="limpia">-------</option>
                                  <option value="1">Enero</option>
                                  <option value="2">Febrero</option>
                                  <option value="3">Marzo</option>
                                  <option value="4">Abril</option>
                                  <option value="5">Mayo</option>
                                  <option value="6">Junio</option>
                                  <option value="7">Julio</option>
                                  <option value="8">Agosto</option>
                                  <option value="9">Septiembre</option>
                                  <option value="10">Octubre</option>
                                  <option value="11">Noviembre</option>
                                  <option value="12">Diciembre</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Indice</label>
                            <div class="col-md-8">
                                <input id="indice" class="valida-decimal form-control"   autocomplete="off" placeholder="Ingresar Indice">
                            </div>
                        </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">            
                            <div class="form-group">
                                <button type="submit" class="btn blue" onclick="VerificaInsert()"><i class="fa fa-check"></i> Guardar</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cerrar</button>
                    </div>                        
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- modal-dialog -->
<div id="static" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
             ¿Eliminar Registro?
                </p>
                 <input hidden="true" type="text" name="iddeleted" id="iddeleted" class="iddeleted">
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminarInpc()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {
             CargartablaINPC();
    });    
    function limpiar()
    {
        document.getElementById('anio').value="";
        document.getElementById('indice').value="";
        document.getElementById('idupdate').value="";
        document.getElementById('iddeleted').value="";
        $("#mes").val("limpia").change();
    }
    function addTable()
    {
        $('#Addtable').append(
            "<div class='portlet-body' id='Removetable'> <div class='form-group'> <div class='col-md-6'> <button class='btn green' href='#portlet-config' data-toggle='modal' >Agregar</button> </div></div><div class='form-group'> <div class='col-md-6 text-right'><button class='btn blue' onclick='GuardarExcel()'><i class='fa fa-file-excel-o'></i> Descargar CSV</button> </div> </div><span class='help-block'>&nbsp; </span><table class='table table-hover' id='sample_2'><thead><tr> <th>Año</th><th>Mes</th><th>Indice</th><th> &nbsp; </th> </tr> </thead> <tbody></tbody> </table> </div>"
        );
    }
    function CargartablaINPC()
    {
        $.ajax({
           method: "get",           
           url: "{{ url()->route('inpc-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        document.getElementById('jsonCode').value=response;            
          var Resp=$.parseJSON(response);
           $("#Removetable").remove();
         addTable();
        $.each(Resp, function(i, item) {                
            $('#sample_2 tbody').append("<tr>"
                +"<td>"+item.anio+"</td>"
                +"<td>"+item.mes+"</td>"
                +"<td>"+item.indice+"</td>"
                + "<td class='text-center' width='20%'><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='portlet-config' onclick='InpcUpdate("+item.id+")'><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only red' data-toggle='modal' href='#static' onclick='InpcDeleted("+item.id+")'><i class='fa fa-minus'></i></a></td>"
                +"</tr>"
                );
            });
        TableManaged.init();
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Tabla Partidas");  });
    }
    function InpcInsert()
    {
        var anio_=$("#anio").val();
        var mes_=$("#mes").val();
        var indice_=$("#indice").val();
         $.ajax({
           method: "post",           
           url: "{{ url()->route('inpc-insert') }}",
           data: {anio:anio_,mes:mes_,indice:indice_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {

          if(response.Code=="200"){
            Command: toastr.success(response.Message, "Notifications")
            CargartablaINPC();
            limpiar();
          }else{
            Command: toastr.warning(response.Message, "Notifications")
          }
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Tabla Partidas");  });
    }
    function InpcActualizar()
    {
        var anio_=$("#anio").val();
        var id_=$("#idupdate").val();
        var mes_=$("#mes").val();
        var indice_=$("#indice").val();
         $.ajax({
           method: "post",           
           url: "{{ url()->route('inpc-update') }}",
           data: {id:id_,anio:anio_,mes:mes_,indice:indice_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          if(response.Code=="200")
            {
                Command: toastr.success(response.Message, "Notifications")
                CargartablaINPC();
            }else{
                Command: toastr.warning(response.Message, "Notifications")
            }
            limpiar();
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Tabla Partidas");  });
    }
    function InpcUpdate(id_)
    {
        document.getElementById('idupdate').value=id_;
        $.ajax({
           method: "post",           
           url: "{{ url()->route('inpc-find-where') }}",
           data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          var Resp=$.parseJSON(response);
          
            $.each(Resp, function(i, item) {                
                document.getElementById('anio').value=item.anio;
                document.getElementById('indice').value=item.indice;
                $("#mes").val(item.mes).change();
            });
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Tabla Partidas");  });
    } 
    function VerificaInsert()
    {
        var anio_=$("#anio").val();
        var id_=$("#idupdate").val();
        var mes_=$("#mes").val();
        var indice_=$("#indice").val();
        if(anio_.length<4)
        {
            Command: toastr.warning("Campo Año, Requerido!", "Notifications")

        }else if(mes_=="limpia")
        {
            Command: toastr.warning("Campo Mes, Requerido!", "Notifications")

        }else if(indice_.length==0)
        {
            Command: toastr.warning("Campo Indice, Requerido!", "Notifications")

        }else{
            if(id_.length==0)
            {
                InpcInsert();
            }else{
                InpcActualizar();
            }
        }

    }
    function InpcDeleted(id_)
    {
        document.getElementById('iddeleted').value=id_;

    }
    function eliminarInpc()
    {
        var id_=$("#iddeleted").val();
         $.ajax({
           method: "post",           
           url: "{{ url()->route('inpc-deleted') }}",
           data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          if(response=="true")
            {
                Command: toastr.success("Success", "Notifications")
                CargartablaINPC();
            }else{
                Command: toastr.warning("Error al Actualizar", "Notifications")
            }
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Tabla Partidas");  });
    }
    function GuardarExcel()
    {
        var JSONData=$("#jsonCode").val();
        JSONToCSVConvertor(JSONData, "INPC", true)
    }
    $('.valida-num').on('input', function () { 
    this.value = this.value.replace(/[^0-9]/g,'');
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