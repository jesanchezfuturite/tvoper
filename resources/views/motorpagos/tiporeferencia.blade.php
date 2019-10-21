@extends('layout.app')


@section('content')
<h3 class="page-title">Motor de pagos <small>Configuración Tipo Referencia</small></h3>
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
            <a href="#">Configuración Tipo Referencia</a>
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
                <i class="fa fa-cogs"></i>Registros Tipo Referencia
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
            <span class='help-block'>&nbsp; </span>          
                <table class="table table-hover" id="sample_2">
                <thead>
                <tr>
                    <th>
                        Descripcíon
                    </th>
                    <th>
                        Digito Verifivcador
                    </th>
                    <th>
                        Longitud
                    </th> 
                    <th>
                        Origen
                    </th>
                    <th>
                        Dias Vigencia
                    </th>                                      
                    <th>
                        &nbsp;
                    </th>
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
                <h4 class="modal-title">Registro Tipo Referencia</h4>
            </div>
            <div class="modal-body">
                 <form action="#" class="form-horizontal">
                    <div class="form-body">
                         <input hidden="true" type="text"  id="idupdate">
                       
                        <div class="form-group">
                            <label class="col-md-3 control-label">Descripcion</label>
                            <div class="col-md-8">
                                <input type="text" autocomplete="off" class="form-control" placeholder="Ingresa la Descripcion" id="descripcion">
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label">Digito Verificador</label>
                            <div class="col-md-8">
                                <input type="text" autocomplete="off" class="form-control" placeholder="Ingresa el Digito Verificador" id="digito_verificador"onkeypress="return soloNumeros(event)" id="longitud" maxlength="10">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-md-3 control-label">Longitud</label>
                            <div class="col-md-8">
                                <input type="text" autocomplete="off" class="form-control" placeholder="Ingresa la Longitud" onkeypress="return soloNumeros(event)" id="longitud" maxlength="10">
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label">Origen</label>
                            <div class="col-md-8">
                                <input type="text" autocomplete="off" class="form-control" placeholder="Ingresa Origen" id="origen"onkeypress="return soloNumeros(event)" id="longitud" maxlength="10">
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label">Dias Vigencia</label>
                            <div class="col-md-8">
                                <input type="text" autocomplete="off" class="form-control" placeholder="Ingresa los Dias Vigencia" id="dias_vigencia" onkeypress="return soloNumeros(event)" id="longitud" maxlength="10">
                            </div>
                        </div>
                                                <br>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-6">
                                    <button type="submit" data-dismiss="modal" class="btn blue" onclick="saveUpdatetiporeferencia()">Guardar</button>
                                    <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cancelar</button>
                                </div>
                            </div>
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
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminatiporeferencia()">Confirmar</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {
        tiporeferenciaFindAll();
        UIBlockUI.init();        
    });    
    function limpiar()
    {
        document.getElementById('idupdate').value="";
        document.getElementById('iddeleted').value="";
        document.getElementById('descripcion').value="";
        document.getElementById('digito_verificador').value="";
        document.getElementById('longitud').value="";
        document.getElementById('origen').value="";
        document.getElementById('dias_vigencia').value="";
    }
    function saveUpdatetiporeferencia()
    {
        var Registro=$("#idupdate").val();
        var descripcion_=$("#descripcion").val();
        var digito_verificador=$("#digito_verificador").val();
        var longitud_=$("#longitud").val();
        var origen_=$("#origen").val();
        var dias_vigencia=$("#dias_vigencia").val();
        if(descripcion_.length==0)
        {
            Command: toastr.warning("Clasificador, Requerido!", "Notifications")
        }else if(digito_verificador.length==0)
        {
            Command: toastr.warning("Digito Verifivcador, Requerido!", "Notifications")
        }else if(longitud_.length==0)
        {
            Command: toastr.warning("Longitud, Requerido!", "Notifications")
        }else if(origen_.length==0)
        {
            Command: toastr.warning("Origen, Requerido!", "Notifications")
        }else if(dias_vigencia.length==0)
        {
            Command: toastr.warning("Dias Vigencia, Requerido!", "Notifications")
        }else{  
            if(Registro.length==0)
            {
                tiporeferenciaInsert();
            }else{
                tiporeferenciaActualiza();
            }
        }

    }
    function tiporeferenciaInsert()
    {
        
        var descripcion_=$("#descripcion").val();
        var digito_verificador=$("#digito_verificador").val();
        var longitud_=$("#longitud").val();
        var origen_=$("#origen").val();
        var dias_vigencia=$("#dias_vigencia").val();
        $.ajax({
        method: "post",            
        url: "{{ url('/tipo-referencia-insert') }}",
        data: {descripcion:descripcion_,digitoverificador:digito_verificador,longitud:longitud_,origen:origen_,diasvigencia:dias_vigencia,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        if(responseinfo=="true")
        {
            Command: toastr.success("Success", "Notifications")
            tiporeferenciaFindAll();
            limpiar();
        }else{
            Command: toastr.warning("La partida ya Existe", "Notifications") 
        }
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Insertar la partida", "Notifications")   });
    }
    function eliminatiporeferencia()
    {
        var iddeleted=$("#iddeleted").val();
        $.ajax({
        method: "post",            
        url: "{{ url('/tipo-referencia-deleted') }}",
        data: {id:iddeleted,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        if(responseinfo=="true")
        {
            Command: toastr.success("Success", "Notifications")
            tiporeferenciaFindAll();

        }else{
            Command: toastr.warning("Error al eliminar la partida!", "Notifications") 
        }
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al eliminar la partida!", "Notifications")   });
    }

    function tiporeferenciaUpdate(id_)
    {
        document.getElementById('idupdate').value=id_;
       
        $.ajax({
        method: "post",            
        url: "{{ url('/tipo-referencia-find-where') }}",
        data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);          
        $.each(Resp, function(i, item) { 
        document.getElementById('descripcion').value=item.fecha_condensada;
        document.getElementById('digito_verificador').value=item.digito_verificador;
        document.getElementById('longitud').value=item.longitud;
        document.getElementById('origen').value=item.origen;
        document.getElementById('dias_vigencia').value=item.dias_vigencia;
        });
       
        })
        .fail(function( msg ) {
         Command: toastr.warning("Registro No Encontrado", "Notifications")  });

    }
    function tiporeferenciaActualiza()
    {
        var id_=$("#idupdate").val();
        var descripcion_=$("#descripcion").val();
        var digito_verificador=$("#digito_verificador").val();
        var longitud_=$("#longitud").val();
        var origen_=$("#origen").val();
        var dias_vigencia=$("#dias_vigencia").val();
        $.ajax({
        method: "post",            
        url: "{{ url('/tipo-referencia-update') }}",
        data: {id:id_,descripcion:descripcion_,digitoverificador:digito_verificador,longitud:longitud_,origen:origen_,diasvigencia:dias_vigencia,_token:'{{ csrf_token() }}'} })
        .done(function (responseinfo) {     
            if(responseinfo=="true")
            {
                Command: toastr.success("Success", "Notifications")
                tiporeferenciaFindAll();
                limpiar();
            }else{
                Command: toastr.warning("Error al Actualizar la partida", "Notifications") 
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Actualizar", "Notifications")   });
    }
    function tiporeferenciaDeleted(id_)
    {
        document.getElementById('iddeleted').value=id_;
    }
    function tiporeferenciaFindAll()
    {
        $.ajax({
           method: "get",           
           url: "{{ url('/tipo-referencia-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          var Resp=$.parseJSON(response);
           $("#Removetable").remove();
         $('#Addtable').append(
            "<div class='portlet-body' id='Removetable'> <div class='form-group'> <div class='col-md-6'> <button class='btn green' href='#portlet-config' data-toggle='modal' >Agregar</button> </div></div><div class='form-group'> <div class='col-md-6 text-right'><button class='btn blue' onclick='GuardarExcel()'><i class='fa fa-file-excel-o'></i> Descargar CSV</button> </div> </div><span class='help-block'>&nbsp; </span><table class='table table-hover' id='sample_2'><thead><tr> <th> Descripción</th><th> Digito Verifivcador </th><th>Longitud </th> <th> Origen</th> <th> Dias Vigencia </th> <th> &nbsp; </th> </tr> </thead> <tbody></tbody> </table> </div>"
        );
        $.each(Resp, function(i, item) {                
            $('#sample_2 tbody').append("<tr>"
                +"<td>"+item.fecha_condensada+"</td>"
                +"<td>"+item.digito_verificador+"</td>"
                +"<td>"+item.longitud+"</td>"
                +"<td>"+item.origen+"</td>"
                +"<td>"+item.dias_vigencia+"</td>"
                + "<td class='text-center' width='20%'><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='portlet-config' onclick='tiporeferenciaUpdate("+item.id+")'><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only red' data-toggle='modal' href='#static' onclick='tiporeferenciaDeleted("+item.id+")'><i class='fa fa-minus'></i></a></td>"
                +"</tr>"
                );
            });
        TableManaged.init();
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Tabla Partidas");  });
    }
    function soloNumeros(e)
    {
    var key = window.Event ? e.which : e.keyCode
    return ((key >= 48 && key <= 57) || (key==8))
    }
function GuardarExcel()
{
  
    document.getElementById("blockui_sample_3_1").click();
     $.ajax({
           method: "GET",            
           url: "{{ url('/tipo-referencia-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            //console.log(responseTipoServicio);
            if(response=="[]")
            { 
              Command: toastr.warning("Sin Registros!", "Notifications")
              document.getElementById("blockui_sample_3_1_1").click();
            }else{
              //var Resp=$.parseJSON(responseTipoServicio);  
               var Title="Tipo_Referencia";        
               JSONToCSVConvertor(response, Title, true);               
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications") 
         document.getElementById("blockui_sample_3_1_1").click(); });       
}
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