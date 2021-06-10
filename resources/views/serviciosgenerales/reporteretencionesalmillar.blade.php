@extends('layout.app')
@section('content')
<h3 class="page-title">Motor de Pagos <small>Trámites Retenciones al Millar</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Motor de Pagos</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Retenciones al Millar</a>
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
                <i class="fa fa-cogs"></i>Retenciones al Millar
            </div>
        </div>
        <div class="portlet-body" id="divRemove">
            <h4>Selecciona los datos a Consultar:</h4>
            <hr>
            <br>          
            <div class="row">           
                <div class="col-md-12">
                    <div class="form-group"> 
                        <div class="col-md-3">
                            <label for="estpagada"class="control-label">Partida:</label>
                            <select id="partida" class="select2me form-control" onchange="">
                                <option value="limpia">Selecionar</option> 
                                <option value="81800">81800</option>           
                                <option value="81700">81700</option>           
                                <option value="41117">41117</option>           
                            </select>
                        </div>
                    </div>
                    <div class="form-group"> 
                    <div class="col-md-3"> 
                        <label>Selecciona una Opcion. <label>
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input type="radio" id="radio6" name="radio2" class="md-radiobtn" value="undia" onclick="radiobuttons()" checked>
                                    <label for="radio6">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                         Pagados </label>
                                </div>|
                                <div class="md-radio">
                                    <input type="radio" id="radio7" name="radio2" class="md-radiobtn" value="tresdias" onclick="radiobuttons()">
                                    <label for="radio7">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                        Sin Pagar</label>
                                </div>
                        </div>                                                                 
                    </div>                   
                </div>
                <div class="form-group">
                    <div class='col-md-4'>   
                        <label for='fecha'>Seleccionar Rango de Fechas. </label>
                        <div class='input-group input-large date-picker input-daterange' data-date-format='yyyy-mm-dd'><span class='input-group-addon'>De</span><input type='text' class='form-control' name='from' id='fechainicio' autocomplete='off'><span class='input-group-addon'>A</span><input type='text' class='form-control' name='to'id='fechafin' autocomplete='off'>
                            
                        </div>
                    </div>
                </div>
                </div> 
             </div><br>
            <div class="row">
               <div class='col-md-12'>                    
                   <!-- <span class='help-block'>&nbsp;</span>-->
                    <button class='btn green' id='Buscar' onclick='findreporte()'>Buscar</button>
                </div>               
            </div>
            <hr>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12 text-right">                
                        <button class="btn blue" onclick="GuardarExcel()"><i class="fa fa-file-excel-o"></i> Descargar CSV</button>
                        <span class='help-block'>&nbsp;</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class='col-md-12'>
                    <div class="portlet-body" id="Removetable">  

                        <table class="table table-hover" id="sample_2">
                            <thead>
                                <tr>
                                    <th>Transaccacion </th>
                                    <th>Ejercicio Fiscal</th> 
                                    <th>Folio SIE(PEI</th>                                       
                                    <th>Modalidad de Ejecución</th>
                                    <th>Referencia del Contrato</th>
                                    <th>Numero Factura</th>
                                    <th>Estimacion Pagada</th>
                                    <th>Id Retención</th>
                                    <th>Fecha de Retención</th>
                                    <th>Monto Retenido</th>
                                    <th>Razón Social Cont.</th>
                                    <th>Dependencia Normativa</th>
                                    <th>Dependencia Ejecutora</th>
                                    <th>Fecha Tramite</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td><span class="help-block">No Found</span></td>
                                <td></td>                         
                                <td></td>                                                              
                                <td></td>                                                              
                                <td></td>                                                              
                                <td></td>                                                              
                                <td></td>                                                              
                                <td></td>                                                              
                                <td></td>                                                              
                                <td></td>                                                              
                                <td></td>                                                              
                                <td></td>                                                              
                                <td></td>                                                              
                                <td></td>   </tr>                                                           
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                <p>¿Continuar?</p>
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default" >Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="continuarsecondary()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<input type="text" name="link" id="link" hidden="true">
<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true" value="[]">

@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {
        ComponentsPickers.init();
        
    });
    function tableadd()
    {
        $("#Removetable table").remove();
        $("#Removetable").append('<table class="table table-hover" id="sample_2"><thead><tr><th>Transaccacion </th><th>Ejercicio Fiscal</th><th>Folio SIE(PEI</th><th>Modalidad de Ejecución</th> <th>Referencia del Contrato</th> <th>Numero Factura</th> <th>Estimacion Pagada</th><th>Id Retención</th><th>Fecha de Retención</th> <th>Monto Retenido</th> <th>Razón Social Cont.</th> <th>Dependencia Normativa</th> <th>Dependencia Ejecutora</th> <th>Fecha Tramite</th></tr></thead><tbody><tr> <td><span class="help-block">No Found</span></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td> <td></td><td></td><td></td><td></td>  <td></td> <td></td></tr> </tbody></table>');
    }
    function findreporte()
    {
        var fecha_inicio=$("#fechainicio").val();
        var fecha_fin=$("#fechafin").val();
        var partida_=$("#partida").val();
        if(fecha_inicio.length<1)
        {
            Command: toastr.warning("Campo Fecha Inicio, Requerido!", "Notifications")
        }else if(fecha_fin.length<1){

            Command: toastr.warning("Campo Fecha Fin, Requerido!", "Notifications")
        }else if(partida_=='limpia'){

            Command: toastr.warning("Campo Partida, Requerido!", "Notifications")
        }else{
            findreportemillar();
        }
    }
    function findreportemillar()
    {
        var fecha_inicio=$("#fechainicio").val();
        var fecha_fin=$("#fechafin").val();
        var partida_=$("#partida").val();
        tableadd();
        $.ajax({
           method: "post",           
           url: "{{ url()->('detallleaportacion-find') }}",
           data: {partida:partida_,fechaInicio:fecha_inicio,fechaFin:fecha_fin,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            //console.log(response);
            document.getElementById('jsonCode').value=response; 
            $("#sample_2 tbody tr").remove();
            var Resp=$.parseJSON(response);
            $.each(Resp, function(i, item) {                
                $('#sample_2 tbody').append("<tr>"
                  +"<td>"+item.id_transaccion+"</td>"
                  +"<td>"+item.ejercicio_fiscal+"</td>"
                  +"<td>"+item.folio_sie+"</td>"
                  +"<td>"+item.modalidad_ejecucion+"</td>"
                  +"<td>"+item.referencia_contrato+"</td>"
                  +"<td>"+item.numero_factura+"</td>"                  
                  +"<td>"+item.estimacion_pagada+"</td>"
                  +"<td>"+item.id_retencion+"</td>"
                  +"<td>"+item.fecha_retencion+"</td>"
                  +"<td>"+item.monto_retenido+"</td>"
                  +"<td>"+item.razon_social+"</td>"
                  +"<td>"+item.dependencia_normativa+"</td>"
                  +"<td>"+item.dependencia_ejecutora+"</td>"
                  +"<td>"+item.fecha_tramite+"</td>"
                  +"</tr>"
                );               
            });
            TableManaged.init();
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Partidas");  });
    }
   
    function GuardarExcel()
    {
        var JSONData=$("#jsonCode").val();
        JSONToCSVConvertor(JSONData, "Retenciones al Millar", true)
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