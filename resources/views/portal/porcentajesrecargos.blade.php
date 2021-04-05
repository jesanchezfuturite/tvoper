@extends('layout.app')
@section('content')
<h3 class="page-title">portal <small>Recargos</small></h3>
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
            <a href="#">Recargos</a>
        </li>
    </ul>
</div>

<div class="row">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box blue" >
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs"></i>Registros recargos
            </div>
            <div class="tools" >                
                <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="Crear Nuevo">
                </a>
            </div>
        </div>
        <div class="portlet-body" id="Addtable">
            <div class="form-group">
                <div class="col-md-12 text-right">                
                    <button class="btn blue" onclick="GuardarExcel()"><i class="fa fa-file-excel-o"></i> Descargar CSV</button>
                </div>
            </div>
            <span class="help-block">&nbsp; </span>
            <div id="Removetable"> 
                <table class="table table-hover" id="sample_2">
                <thead>
                <tr>
                    <th>Año</th>
                    <th>Mes</th> 
                    <th>% Vencido</th>                                       
                    <th>% Requerido</th>                                       
                    <th>% Federal Vencido</th>                                       
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
                
                    <input hidden="true" type="text"  id="idupdate">
                    <div class="row">
                       <div class="form-group">
                            <label class="col-md-3 control-label">Año</label>
                            <div class="col-md-8">
                                <input id="anio" class="valida-num form-control" maxlength="4"  autocomplete="off" placeholder="Ingresar Año">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
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
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-3 control-label">% Vencido</label>
                            <div class="col-md-8">
                                <input id="vencido" class="valida-decimal form-control"   autocomplete="off" placeholder="Ingresar Indice">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-3 control-label">% Requerido</label>
                            <div class="col-md-8">
                                <input id="requerido" class="valida-decimal form-control"   autocomplete="off" placeholder="Ingresar Indice">
                            </div>
                        </div>
                    </div>
                    <br>   
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-3 control-label">% Federal Vencido</label>
                            <div class="col-md-8">
                                <input id="fed_vencido" class="valida-decimal form-control"   autocomplete="off" placeholder="Ingresar Indice">
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
                 <input hidden="true" type="text" name="anio_up" id="anio_up" class="anio_up">
                 <input hidden="true" type="text" name="mes_up" id="mes_up" class="mes_up">
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminarPorcentaje()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {
        Cargartablaporcentajes();
    });    
    function limpiar()
    {
        document.getElementById('anio').value="";
        document.getElementById('vencido').value="";
        document.getElementById('requerido').value="";
        document.getElementById('fed_vencido').value="";
        document.getElementById('idupdate').value="";
        document.getElementById('mes_up').value="";
        document.getElementById('anio_up').value="";
        $("#mes").val("limpia").change();
        document.getElementById("anio").disabled=false;
        document.getElementById("mes").disabled=false;
    }
    function addTable()
    {
        $("#Removetable").remove();
        $('#Addtable').append(
            "<div id='Removetable'> <table class='table table-hover' id='sample_2'><thead><tr> <th>Año</th><th>Mes</th><th>% Vencido</th><th>% Requerido</th><th>% Federal Vencido</th><th> &nbsp; </th>  </tr> </thead> <tbody></tbody> </table> </div>"
        );
    }
    function Cargartablaporcentajes()
    {
        $.ajax({
           method: "get",           
           url: "{{ url('/porcentaje-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            document.getElementById('jsonCode').value=response.Message;          
         addTable();
         if(response.Code=="400")
         {
            console.log(response.Message);
            return;
         }
        $.each(response.Message, function(i, item) {
            var mesd_=meses(item.mes);
            var fed_v=item.federal_vencido;
            var v_=item.vencido;
            var requ_=item.requerido;
            if(fed_v==null || fed_v=="null")
                {fed_v="N/A";}
            if(v_==null || v_=="null")
                {v_="N/A";}
            if(requ_==null || requ_=="null")
                {requ_="N/A";}
            $('#sample_2 tbody').append("<tr>"
                +"<td>"+item.anio+"</td>"
                +"<td>"+mesd_+"</td>"
                +"<td>"+v_+"</td>"
                +"<td>"+requ_+"</td>"
                +"<td>"+fed_v+"</td>"
                + "<td class='text-center' width='20%'><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='Editar' onclick='porcentajeUpdate("+JSON.stringify(item)+")'><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only red' data-toggle='modal' href='#static' title='Eliminar'  onclick='porcentajeDeleted("+item.anio+","+item.mes+")'><i class='fa fa-minus'></i></a></td>"
                +"</tr>"
                );
            });
        TableManaged2.init2();
        })
        .fail(function( msg ) {
         console.log("Error al cargar tabla porcentaje");  });
    }
    function porcentajeInsert()
    {
        var anio_=$("#anio").val();
        var mes_=$("#mes").val();
        var vencido_=$("#vencido").val();
        var requerido_=$("#requerido").val();
        var fed_vencido=$("#fed_vencido").val();
         $.ajax({
           method: "post",           
           url: "{{ url('/porcentaje-insert') }}",
           data: {anio:anio_,mes:mes_,vencido:vencido_,requerido:requerido_,federal_vencido:fed_vencido,_token:'{{ csrf_token() }}'}  })
            .done(function (response) {
              if(response.Code=="200"){
                Command: toastr.success(response.Message, "Notifications")
                Cargartablaporcentajes();
                limpiar();
              }else{
                Command: toastr.warning(response.Message, "Notifications")
              }
        })
        .fail(function( msg ) {
         console.log("Error al cargar tabla porcentaje");  });
    }
    function actualizarPorcentaje()
    {
        var anio_=$("#anio").val();
        var mes_=$("#mes").val();
        var vencido_=$("#vencido").val();
        var requerido_=$("#requerido").val();
        var fed_vencido=$("#fed_vencido").val();
         $.ajax({
           method: "post",           
           url: "{{ url('/porcentaje-update') }}",
           data: {anio:anio_,mes:mes_,vencido:vencido_,requerido:requerido_,federal_vencido:fed_vencido,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          if(response.Code=="200")
            {
                Command: toastr.success(response.Message, "Notifications")
                Cargartablaporcentajes();
                //limpiar();
            }else{
                Command: toastr.warning(response.Message, "Notifications")
            }
            
        })
        .fail(function( msg ) {
         console.log("Error al Actualizar");  });
    }
    function porcentajeUpdate(djson)
    {
       
        document.getElementById('idupdate').value=djson.anio;                       
        document.getElementById('anio').value=djson.anio;
        document.getElementById('vencido').value=djson.vencido;
        document.getElementById('requerido').value=djson.requerido;
        document.getElementById('fed_vencido').value=djson.federal_vencido;
        $("#mes").val(djson.mes).change();        
        document.getElementById("anio").disabled=true;
        document.getElementById("mes").disabled=true;
           
    } 
    function VerificaInsert()
    {
        var anio_=$("#anio").val();
        var id_=$("#idupdate").val();
        var mes_=$("#mes").val();
        var vencido_=$("#vencido").val();
        var requerido_=$("#requerido").val();
        if(anio_.length<4)
        {
            Command: toastr.warning("Campo Año, Requerido!", "Notifications")
        }else if(mes_=="limpia")
        {
            Command: toastr.warning("Campo Mes, Requerido!", "Notifications")
        }else if(vencido_.length==0)
        {
            Command: toastr.warning("Campo % Vencido, Requerido!", "Notifications")
        }else if(requerido_.length==0)
        {
            Command: toastr.warning("Campo % Requerido, Requerido!", "Notifications")
        }        else{
            if(id_.length==0)
            {
                porcentajeInsert();
            }else{
                actualizarPorcentaje();
            }
        }

    }
    function porcentajeDeleted(anio,mes)
    {
        document.getElementById('anio_up').value=anio;
        document.getElementById('mes_up').value=mes;

    }
    function eliminarPorcentaje()
    {
        var anio_=$("#anio_up").val();
        var mes_=$("#mes_up").val();
         $.ajax({
           method: "post",           
           url: "{{ url('/porcentaje-deleted') }}",
           data: {anio:anio_,mes:mes_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          if(response.Code=="200")
            {
                Command: toastr.success(response.Message, "Notifications")
                Cargartablaporcentajes();
            }else{
                Command: toastr.warning(response.Message, "Notifications")
            }
        })
        .fail(function( msg ) {
         console.log("Error al Eliminar");  });
    }
    function GuardarExcel()
    {
        var JSONData=$("#jsonCode").val();
        JSONToCSVConvertor(JSONData, "Porcentajes", true)
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
function meses(mes)
{ var mes_;
    console.log(mes);
    switch(parseInt(mes)) {
        case 1:
            mes_="ENERO";
            break;
        case 2:
            mes_="FEBRERO";
            break;
        case 3:
            mes_="MARZO";
            break;
        case 4:
            mes_="ABRIL";
            break;
        case 5:
            mes_="MAYO";
            break;
        case 6:
            mes_="JUNIO";
            break;
        case 7:
            mes_="JULIO";
            break;
        case 8:
            mes_="AGOSTO";
            break;
        case 9:
            mes_="SEPTIEMBRE";
            break;
        case 10:
            mes_="OCTUBRE";
            break;
        case 11:
            mes_="NOVIEMBRE";
            break;
        case 12:
            mes_="DICIEMBRE";
            break;
        default:
        mes_="N/A";
    }
    return mes_;
}
</script>
@endsection