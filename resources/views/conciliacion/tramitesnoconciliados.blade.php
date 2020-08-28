@extends('layout.app')
@section('content')
<h3 class="page-title">Conciliación <small>Tramites Pagados Sin Conciliar</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Conciliación</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Tramites Pagados Sin Conciliar</a>
        </li>
    </ul>
</div>

<div class="row">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box blue" id="Addtable">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs"></i>Tramites Pagados Sin Conciliar
            </div>
        </div>
        <div class="portlet-body" > 
            <div class="row">
                <div class='form-group'>  
                    <div class="col-md-6">
                       
                        <label for='fecha'>Seleccionar Rango de Fechas. </label>
                        <div class='input-group input-large date-picker input-daterange' data-date-format='yyyy-mm-dd'><span class='input-group-addon'>De</span><input type='text' class='form-control' name='from' id='fechainicio' autocomplete='off'><span class='input-group-addon'>A</span><input type='text' class='form-control' name='to'id='fechafin' autocomplete='off'></div>
                        <span class="help-block">&nbsp; </span>  
                        <button class='btn green' id='Buscar' onclick='Cargarnoconciliados()'>Buscar</button>
                    </div>
                </div>
            <div class='form-group'> 
                <div class='col-md-1'>
                    <span class="help-block">&nbsp; </span>
                    <div class='form-group'>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12 text-right">   
                <span class="help-block">&nbsp; </span>             
                    <button class="btn blue" onclick="GuardarExcel()"><i class="fa fa-file-excel-o"></i> Descargar CSV</button>
                </div>
            </div>
        </div>
        </div>
        <div class="portlet-body" id="Removetable">           
            
                <table class="table table-hover" id="sample_2">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Referencia</th>
                        <th>Banco</th>
                        <th>Fecha Pago</th>
                        <th>Estatus</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                     <td><span class="help-block">No Found</span></td>
                        <td></td>                         
                        <td></td>                                                               
                        <td></td>                                                               
                        <td></td>                                                               
                        <td></td>                                                               
                </tbody>
            </table>
          
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->    

</div>
<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {
             ComponentsPickers.init(); 
    });    
    function addTable()
    { 
        $("#Removetable").remove();
        $('#Addtable').append(
            "<div class='portlet-body' id='Removetable'><table class='table table-hover' id='sample_2'><thead><tr><th>Folio</th><th>Referencia</th><th>Banco</th><th>Fecha Pago</th><th>Estatus</th><th>Monto</th></tr></thead> <tbody><tr><td><strong>Espere Cargando...</strong></td><td></td><td></td><td></td><td></td><td></td></tbody> </table> </div>"
        );
    }
    function Cargarnoconciliados()
    {
        var fechaIn=$("#fechainicio").val();
        var fechaFi=$("#fechafin").val();
        addTable();
        $.ajax({
           method: "post",           
           url: "{{ url('/find-tramites-no-conciliados') }}",
           data: {fechaInicio:fechaIn,fechaFin:fechaFi,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
             
            document.getElementById('jsonCode').value=response;            
            var Resp=$.parseJSON(response);
            $("#sample_2 tbody tr").remove();
        $.each(Resp, function(i, item) {                
            $('#sample_2 tbody').append("<tr>"
                +"<td>"+item.folio+"</td>"
                +"<td>"+item.referencia+"</td>"
                +"<td>"+item.banco+"</td>"
                +"<td>"+item.fecha_pago+"</td>"
                +"<td>"+item.status+"</td>"
                +"<td>"+formatter.format(item.monto)+"</td>"
                +"</tr>"
                );
            });
        TableManaged.init();
        })
        .fail(function( msg ) {
            console.log("Error al Cargar Tabla Partidas");  
            $("#sample_2 tbody tr").remove();
        });
    }
     const formatter = new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
      minimumFractionDigits: 2
    })
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