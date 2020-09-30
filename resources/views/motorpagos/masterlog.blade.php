@extends('layout.app')
@section('content')

<link href="assets/global/dataTable/dataTables.min.css" rel="stylesheet" type="text/css"/>
<link href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>

<h3 class="page-title">Consultas <small>Reporte por fecha de pago</small></h3>

<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Consultas</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Reporte por fecha de pagos</a>
        </li>
    </ul>
</div>

<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Info:</strong> Reporte por fecha de pago, filtro por FECHA y PLATAFORMA, Busqueda por rango de fechas.
</div>

<div class="row">
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-gift"></i>Reporte</div>                        
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <span class="help-block">Selecciona una Opcion. </span>
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="radio6" name="radio2" class="md-radiobtn" value="undia" onclick="radiobuttons()">
                                        <label for="radio6">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>Hace 1 Dia (Últimas 24hrs). </label>
                                    </div>
                                    <div class="md-radio">
                                        <input type="radio" id="radio7" name="radio2" class="md-radiobtn" value="tresdias" onclick="radiobuttons()">
                                        <label for="radio7">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>Hace 3 Días.</label>
                                    </div>
                                    <div class="md-radio">
                                        <input type="radio" id="radio8" name="radio2" class="md-radiobtn" value="avanzado" onclick="radiobuttons()">
                                        <label for="radio8">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>Avanzado (Rango Fechas). </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="addTimerpicker" hidden="true">
                                <div class='col-md-4'>
                                    <span class='help-block'>&nbsp;</span>
                                    <div class='form-group'>
                                        <label for='fecha'>Seleccionar Rango de Fechas.</label>
                                        <div class='input-group input-large date-picker input-daterange' data-date-format='yyyy-mm-dd'>
                                            <span class='input-group-addon'>De</span>
                                            <input type='text' class='form-control' name='from' id='fechainicio' autocomplete='off'>
                                            <span class='input-group-addon'>A</span>
                                            <input type='text' class='form-control' name='to'id='fechafin' autocomplete='off'>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-3'>
                                    <span class='help-block'>&nbsp;</span>
                                    <div class='form-group'>
                                        <label>Referencia / Folio</label>
                                        <input type='text' placeholder='Ingrese RFC / Placas / Folio' autocomplete='off' name='rfc' id='rfc' class='form-control'>
                                    </div>
                                </div>
                                <div class='col-md-1'>
                                    <span class='help-block'>&nbsp;</span>
                                    <span class='help-block'>&nbsp;</span>
                                    <div class='form-group'>
                                        <button class='btn green' id='Buscaroper' onclick='RangoFechas()'>Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class='row'>
                            <div class='form-group'>
                                <div class='col-md-12 text-right'>
                                    <button class='btn blue' onclick='saveOper()'><i class='fa fa-file-excel-o'></i>Descargar CSV</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                   
                    <span class='help-block'>&nbsp;</span>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bs-modal-lg" id="large" tabindex="-1" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Modal Title</h4>
            </div>
            <div class="modal-body">
               <div class="vl">
                    <span class="help-block"> &nbsp;</span>
                    <span class="help-block"> &nbsp;</span>
                    <span class="help-block"> &nbsp;</span>
                    <span class="help-block"> &nbsp;</span>
                    <span class="help-block"> &nbsp;</span>
                    <span class="help-block"> &nbsp;</span>
                    <span class="help-block"> &nbsp;</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">Close</button>
            
            </div>
        </div>
    </div>
</div>
<input type="text" name="jsonCode1" id="jsonCode1" hidden="true">
<input type="text" name="jsonCode2" id="jsonCode2" hidden="true">
<input type="text" name="jsonCode3" id="jsonCode3" hidden="true">

@endsection
@section('scripts')

<script src="assets/global/dataTable/dataTables.min.js"></script>
<script src="assets/global/dataTable/dataTables.buttons.min.js"></script>
<script src="assets/global/dataTable/buttons.flash.min.js"></script>
<script src="assets/global/dataTable/jszip.min.js"></script>
<script src="assets/global/dataTable/pdfmake.min.js"></script>
<script src="assets/global/dataTable/vfs_fonts.js"></script>
<script src="assets/global/dataTable/buttons.html5.min.js"></script>
<script src="assets/global/dataTable/buttons.print.min.js"></script>

<script  type="text/javascript">

    function RangoFechas()
    {
        fechaIn=$("#fechainicio").val();
        fechaF=$("#fechafin").val();
        
        if(fechaIn.length < 1 && fechaF.length < 1){
            Command: toastr.warning("Rango de Fechas Requerido!", "Notifications")            
        }else{
            consulta(fechaIn,fechaF);                    
        }
    }

    function consulta(fechaIn,fechaF) {
        
        Addtable1();

        $.ajax({
            method: "post",            
            url: "{{ url('/report-paid-operation') }}",
            data: {fechaInicio:fechaIn,fechaFin:fechaF,_token:'{{ csrf_token() }}'}  })
        .done(function (response) { 
            document.getElementById('jsonCode1').value=response;        
            $("#sample_3 tbody tr").remove();   
            var Resp=$.parseJSON(response);
            var color='';
            var label='';
        
        $.each(Resp, function(i, item) { 

            $("#sample_3 tbody").append("<tr>"
                +"<td>"+item.Folio+"</td>"
                +"<td>"+item.Transaccion+"</td>"
                +"<td>"+item.estatus+"</td>"
                +"<td>"+item.Estatus+"</td>"
                +"<td>"+item.RFC+"</td>"
                +"<td>"+item.Familia+"</td>"
                +"<td>"+item.Entidad+"</td>"
                +"<td>"+item.Tramite+"</td>"
                +"<td>"+item.Contribuyente+"</td>"
                +"<td>"+item.Inicio_Tramite+"</td>"
                +"<td>"+item.Banco+"</td>"
                +"<td>"+item.Tipo_Pago+"</td>"
                +"<td>"+item.Total_Tramite+"</td>"
                +"</tr>");
            });        
            
            cargatabla1();

        })
        .fail(function( msg ) {

            $("#sample_3 tbody tr").remove(); 
            $("#sample_3 tbody").append("<tr>"
                +"<td>No Found</td>"
                +"</tr>");
            Command: toastr.warning("Registro No Encontrado", "Notifications")  
        });     
    }

    function cargatabla1()
    {    
        var inin=0;
        
        $('#sample_3 thead tr').clone(true).appendTo('#sample_3 thead');
        $('#sample_3').DataTable({
            
            "lengthMenu": [[5, 15, 20, -1], [5, 15, 20, "All"]],            
            initComplete: function () {            
                this.api().columns().every( function () {
                    
                    var column = this;               
                    var select = $('<select class="select2me form-control"><option value=""></option></select>')
                        .appendTo( $("#sample_3 thead tr:eq(0) th:eq('"+inin+"')").empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
     
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                               
                        });
     
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    });
                    inin=inin+1;
                });
            }
        });
        
    }

</script>

@endsection