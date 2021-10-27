@extends('layout.app')
@section('content')

<link href="{{ asset('assets/global/dataTable/dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>

<h3 class="page-title">Consultas <small>Log WS Bancos</small></h3>

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
            <a href="#">LOG</a>
        </li>
    </ul>
</div>

<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Info:</strong> Reporte por fecha de pago, filtro por FECHA y PLATAFORMA, Busqueda por rango de fechas.
</div>


<div class="row">
    <div class="col-md-12 col-sm-12 text-left">
        <span class="help-block">Selecciona una Opcion. </span>
        <div class="md-radio-inline">
            <div class="md-radio">
                <input type="radio" id="radio6" name="radio2" class="md-radiobtn" value="undia" onclick="radiobuttons()">
                <label for="radio6">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span> Hace 1 Dia (Últimas 24hrs).
                </label>
            </div>
            <div class="md-radio">
                <input type="radio" id="radio7" name="radio2" class="md-radiobtn" value="tresdias" onclick="radiobuttons()">
                <label for="radio7"><span></span>
                    <span class="check"></span>
                    <span class="box"></span >Hace 3 Días.
            </label>
            </div>
            <div class="md-radio">
                <input type="radio" id="radio8" name="radio2" class="md-radiobtn" value="avanzado" onclick="radiobuttons()">
                <label for="radio8">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span>Avanzado (Rango Fechas). 
                </label>
            </div>
            <div class="md-radio">
                <input type="radio" id="radio9" name="radio2" class="md-radiobtn" value="referencia" onclick="radiobuttons()">
                <label for="radio9">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span>Por referencia. 
                </label>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="addTimerpicker" hidden="true">
            <div class='col-md-3'>
                <span class='help-block'>&nbsp;</span>
                <div class='input-group'>
                    <label for='fecha'>Seleccionar Rango de Fechas.</label>
                    <div class='input-group input-large date-picker input-daterange' data-date-format='yyyy-mm-dd'>
                        <span class='input-group-addon'>De</span>
                        <input type='text' class='form-control' name='from' id='fechainicio' autocomplete='off'>
                        <span class='input-group-addon'>A</span>
                        <input type='text' class='form-control' name='to'id='fechafin' autocomplete='off'>
                    </div>
                </div>
            </div>
            <div class='col-md-1'>
                <span class='help-block'>&nbsp;</span>
                <span class='help-block'>&nbsp;</span>
                <div class='btn-group'>
                    <button class='btn green' id='Buscaroper' onclick='RangoFechas()'>Buscar</button>
                </div>
            </div>
        </div>
        <div id="campoReferencia" hidden="true">
            <div class="col-md-3">
                <span class='help-block'>&nbsp;</span>
                <div class="input-group col-sm-12">
                    <label for="referencia">Datos necesarios.</label>
                    <div class="input-group">
                        <span class="input-group-addon">Referencia</span>
                        <input type="text" class="form-control" name="referencia" id="referencia" autocomplete="off" maxlength="30">
                    </div>
                </div>
            </div>              
            <div class='col-md-1'>
                <span class='help-block'>&nbsp;</span>
                <span class='help-block'>&nbsp;</span>
                <div class='btn-group'>
                    <button class='btn green' id='BuscarRef' onclick='BuscarRef()'>Buscar</button>
                </div>
            </div>
        </div>
        <div class='form-group'>
            <div class='col-md-12 text-left'>
                <span class='help-block'>&nbsp;</span>
                <!-- <button class='btn blue' onclick='saveOper()'><i class='fa fa-file-excel-o'></i> Descargar CSV</button> -->
                <button class='btn blue' id="bitacora"><i class='fa fa-file-excel-o'></i> Descargar CSV</button>
            </div>
        </div>
    </div>
</div>

<span class='help-block'>&nbsp;</span>

<div class="row">
    <div class="col-md-12">
        <div id="addTable_1">
            <div id="table_1">
                <table class="table table-hover table-responsive" id="sample_3">
                    <thead>
                        <tr>
                            <th>Fecha</th> 
                            <th>Operacion</th> 
                            <th>Referencia</th> 
                            <th>Banco</th>
                            <th>Importe</th>
                            <th>Respuesta</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr>                     
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>                                   
                    </tbody>                                    
                </table>                          

            </div>
        </div>
    </div>
</div>
<form id="form_bitacora" action="{{ url()->route('export-bitacorawsb') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="response" id="response" value="">
</form>

@endsection
@section('scripts')

<script src="{{ asset('assets/global/dataTable/dataTables.min.js') }}"></script>
<script src="{{ asset('assets/global/dataTable/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/global/dataTable/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/global/dataTable/jszip.min.js') }}"></script>
<script src="{{ asset('assets/global/dataTable/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/global/dataTable/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/global/dataTable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/global/dataTable/buttons.print.min.js') }}"></script>

<script  type="text/javascript">

    jQuery(document).ready(function() {
        UIBlockUI.init(); 
        cargatabla1();
        ComponentsPickers.init();

        $('#bitacora').click(function(){
            
            event.preventDefault();

            var j = $('#response').val();
            
            if(j == "") {
                Command: toastr.warning("Se necesita hacer una busqueda", "Notifications");
                return false;
            }

            var option = document.querySelector('input[name = radio2]:checked').value;

            if(j === "0") {
                Command: toastr.warning("No hubo resultados en la busqueda", "Notifications");
                return false;   
            }

            $('#form_bitacora').submit();

        });
 

    });

    
    function RangoFechas()
    {
        fechaIn = $("#fechainicio").val();
        fechaF = $("#fechafin").val();
        
        if(fechaIn.length < 1 && fechaF.length < 1){
            Command: toastr.warning("Rango de Fechas Requerido!", "Notifications")            
        }else{
            consulta(fechaIn,fechaF);                    
        }
    }

    function BuscarRef()
    {
        ref = $('#referencia').val();

        if(ref.length < 1)
            Command: toastr.warning("Referencia no válida","Notifications")
        else
            consultaref(ref)
    }    

    function cargatabla1()
    {    
        var inin = 0;
        
        $('#sample_3 thead tr').clone(true).appendTo('#sample_3 thead');
        $('#sample_3').DataTable({
            "lengthMenu": [[5, 15, 20, -1], [5, 15, 20, "All"]],
            "pageLength": 20,
            initComplete: function() {
                this.api().columns().every(function(){
                    var column = this;
                    var select = $('<select><option value=""> ------ </option></select>')
                        .appendTo($("#sample_3 thead tr:eq(0) th:eq('" + inin + "')")
                            .empty())
                                .on('change',function() { 
                                    var val = $.fn.dataTable.util.escapeRegex( $(this).val() ); 
                                    column.search( val ? '^'+val+'$' : '', true, false ).draw(); 
                                });
                                
                            column.data().unique().sort().each( function(d,j) {
                                select.append('<option value="'+d+'">'+d+'</option>');
                            });

                    inin = inin + 1;
                });
            }
        });        
    }

    function radiobuttons()
    {
        document.getElementById('fechainicio').value='';
        document.getElementById('fechafin').value='';

        var option = document.querySelector('input[name = radio2]:checked').value;

        if(option=="avanzado") {
            timpicker();
        }
        else if(option=="referencia") {
            porreferencia();
        }
        else {
            //$("#addTimerpicker div").remove();
            $("#addTimerpicker").css("display", "none");
            $("#campoReferencia").css("display","none");
            if(option == "undia") {
                consulta("1","1");
            }
            else {
                consulta("3","3");
            }
        }
    }

    function consulta(fechaIn,fechaF) {
        
        Addtable1();

        $.ajax({
            method: "post",            
            url: "{{ url()->route('report-bitacora-wsbancos') }}",
            data: {fechaInicio:fechaIn,fechaFin:fechaF,_token:'{{ csrf_token() }}'}  }
        )
        .done(function (response) { 

            document.getElementById('response').value = JSON.stringify(response);

            $("#sample_3 tbody tr").remove();   

            $.each(response, function(i, item) {

                var iext = (typeof item.extra === 'string' && item.extra !== null) ? $.parseJSON(item.extra) : { id_tramite:0, des_tramite:'ND' };
                var dext = iext.des_tramite === null ? 'ND' : iext.des_tramite.toUpperCase();

                $('#sample_3 tbody')
                    .append($('<tr>')
                        .append($('<td>').html(item.fecha))
                        .append($('<td>').html(item.operacion))
                        .append($('<td>').html(item.referencia))
                        .append($('<td>').html(item.banco))
                        .append($('<td>').html(item.importe))
                        .append($('<td>').html(item.respuesta))
                    );
            });       
            
            cargatabla1();
          
        })
        .fail(function( msg ) {

            $("#sample_3 tbody tr").remove();
            $("#sample_3 tbody").append($('<tr>').append($('<td>').html('No Encontrado'))); 
            Command: toastr.warning("Registro No Encontrado", "Notifications")

        });

    }

    function consultaref(ref) {
        Addtable1();

        $.ajax({
            method: "post",
            url: "{{ url()->route('search-bitacorawsb-ref') }}",
            data: {ref:ref,_token:'{{ csrf_token() }}'}
        })
        .done(function(response){
            $.each(response, function(i, item) {

                var iext = (typeof item.extra === 'string' && item.extra !== null) ? $.parseJSON(item.extra) : { id_tramite:0, des_tramite:'ND' };
                var dext = iext.des_tramite === null ? 'ND' : iext.des_tramite.toUpperCase();

                $('#sample_3 tbody')
                    .append($('<tr>')
                        .append($('<td>').html(item.fecha))
                        .append($('<td>').html(item.operacion))
                        .append($('<td>').html(item.referencia))
                        .append($('<td>').html(item.banco))
                        .append($('<td>').html(item.importe))
                        .append($('<td>').html(item.respuesta))
                    );
            });       
            
            cargatabla1();
        })
        .fail(function(msg){
            $("#sample_3 tbody tr").remove();
            $("#sample_3 tbody").append($('<tr>').append($('<td>').html('No Encontrado'))); 
            Command: toastr.warning("Registro No Encontrado", "Notifications")
        });
    }   

    function Addtable1()
    {
        $("#table_1").remove();
        $("#addTable_1")
            .append($('<div>').attr('id','table_1')
                .append($('<table>')
                    .addClass('table table-hover table-responsive')
                    .attr('id','sample_3')
                    .append($('<thead>')
                        .append($('<tr>')
                            .append($('<th>').html('Fecha'))
                            .append($('<th>').html('Operacion'))
                            .append($('<th>').html('Referencia'))
                            .append($('<th>').html('Banco'))
                            .append($('<th>').html('Importe'))
                            .append($('<th>').html('Respuesta'))
                        )
                    )
                    .append($('<tbody>')
                        .append($('<tr>')
                            .append($('<td>').html('Espere Cargando.....'))
                            .append($('<td>').html(''))
                            .append($('<td>').html(''))
                            .append($('<td>').html(''))
                            .append($('<td>').html(''))
                            .append($('<td>').html(''))
                        )
                    )
                )
            );
    }

    function timpicker()
    {
        $("#campoReferencia").css("display","none");
        $("#addTimerpicker").css("display", "block");         
        document.getElementById('fechainicio').value='';
        document.getElementById('fechafin').value='';
    }

    function porreferencia()
    {
        $("#addTimerpicker").css("display","none");
        $("#campoReferencia").css("display","block");
        document.getElementById('referencia').value='';
    }

    function saveOper()
    {
        var JSONData=$("#response").val();
        var ReportTitle='Reporte_Bitacora_WSB';
        JSONToCSVConvertor(JSONData, ReportTitle, true);
    }

    function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) 
    {    
        var f = new Date();
        fecha =  f.getFullYear()+""+(f.getMonth() +1)+""+f.getDate()+"_";
        var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
        var CSV = '';    
    
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
                row += '"' + arrData[i][index]+ '",';
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
        link.download = fileName + ".xml";
        Command: toastr.success("Success", "Notifications")
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

</script>

@endsection