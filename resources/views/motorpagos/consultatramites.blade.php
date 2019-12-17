@extends('layout.app')

@section('content')

<link href="assets/global/dataTable/dataTables.min.css" rel="stylesheet" type="text/css"/>
<link href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>

<h3 class="page-title">Motor de pagos <small>Consulta Transacciones</small></h3>
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
            <a href="#">Consulta Transacciones</a>
        </li>
    </ul>
</div>
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Info:</strong> Consulta de las Transacciones, filtro por ESTATUS y TIPO SERVICIO, Busqueda por rango de fechas y RFC.
</div>
<div class="row">
    <div hidden="true">
        <a href="javascript:;" class="btn green" id="blockui_sample_3_1" >Block</a>
        <a href="javascript:;" class="btn default" id="blockui_sample_3_1_1" >Unblock</a>
    </div>
    <div id="blockui_sample_3_1_element">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title" >
                <div class="caption" id="headerTabla">
                  <div id="borraheader"> <a class=" popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="Esta consulta te permite buscar y cambiar el estatus de una transacciónDismissable " data-original-title="Tip"> <i class="fa fa-cogs" style="color:white;">&nbsp; </i></a>Transacciones</div>
                  </div>
                  <div class="tools" hidden="true">
              </div>             
            </div>
            <div class="portlet-body" >
                <div class="row">
                    <div class="col-md-12 text-right"> 
                        <span class="help-block">Selecciona una Opcion. </span>
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input type="radio" id="radio6" name="radio2" class="md-radiobtn"value="undia" onclick="radiobuttons()" checked>
                                    <label for="radio6">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                         Hace 1 Dia (Últimas 24hrs). </label>
                                </div>|
                                <div class="md-radio">
                                    <input type="radio" id="radio7" name="radio2" class="md-radiobtn" value="tresdias" onclick="radiobuttons()">
                                    <label for="radio7">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                        Hace 3 Días.</label>
                                </div>|
                                <div class="md-radio">
                                    <input type="radio" id="radio8" name="radio2" class="md-radiobtn" value="avanzado" onclick="radiobuttons()">
                                    <label for="radio8">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                    Avanzado (Rango Fechas). </label>
                                </div>
                        </div>                                                                 
                    </div>                   
                </div>                           
                
                 <div class="row">           
                    <div class="col-md-12">
                        <div class="tabbable-line boxless tabbable-reversed">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_0" data-toggle="tab">Operaciones</a>
                                </li>
                                <li>
                                    <a href="#tab_1" data-toggle="tab">Egobierno</a>
                                </li>                            
                            </ul>
                            <div class="tab-content">
                               
                                <div class="tab-pane active" id="tab_0"> 
                                <div class="row">
                                    <div id="addTimerpicker"></div>
                                </div> 
                                    <div class="portlet box blue" id="addTable_1">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-gift"></i>Operaciones
                                            </div>
                                        </div> 
                                    <div class="portlet-body" id="table_1">
                                    <div class="table-scrollable"> 
                                        <table class="table table-hover table-responsive" id="sample_3">
                                            <thead>
                                                <tr>
                                                    <th>Transacción</th> 
                                                    <th>Conciliacion</th> 
                                                    <th>Estatus</th>
                                                    <th>RFC</th>
                                                    <th>Familia</th>
                                                    <th>Entidad</th>
                                                    <th>Tramite</th>
                                                    <th>Contribuyente</th> 
                                                    <th>Inicio Tramite</th>                       
                                                    <th>Banco</th>
                                                    <th>Tipo Pago</th>
                                                    <th>Total Tramite</th>
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
                                                </tr>                                   
                                            </tbody>
                                            <tfoot>
                                                 <tr>
                                                    <th>Transacción</th> 
                                                    <th>Conciliacion</th> 
                                                    <th>Estatus</th>
                                                    <th>RFC</th>
                                                    <th>Familia</th>
                                                    <th>Entidad</th>
                                                    <th>Tramite</th>
                                                    <th>Contribuyente</th> 
                                                    <th>Inicio Tramite</th>                       
                                                    <th>Banco</th>
                                                    <th>Tipo Pago</th>
                                                    <th>Total Tramite</th>
                                                </tr>
                                            </tfoot>
                                        </table>                          
                                    </div>
                                    </div>
                                </div>
                            </div>            
                            <div class="tab-pane" id="tab_1">
                                <div class="row">
                                    <div id="addTimerpicker2"></div>
                                </div>
                                <div class="portlet box blue" id="addTable_2">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-gift"></i>Egobierno
                                        </div>
                                    </div>
                                    <div class="portlet-body" id="table_2">
                                        <div class="table-scrollable">
                                        <table class="table table-hover table-responsive" id="sample_2">
                                            <thead>
                                                <tr> 
                                                    <th>Transacción</th>
                                                    <th>Conciliacion</th>
                                                    <th>Estatus</th>
                                                    <th>RFC</th>
                                                    <th>Declarado</th>
                                                    <th>Familia</th>
                                                    <th>Entidad</th>
                                                    <th>Tramite</th>
                                                    <th>Contribuyente</th> 
                                                    <th>Inicio Tramite</th>                       
                                                    <th>Banco</th>
                                                    <th>Tipo Pago</th>                                            
                                                    <th>Total Tamite</th>
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
                                                </tr>                                   
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Transacción</th>
                                                    <th>Conciliacion</th>
                                                    <th>Estatus</th>
                                                    <th>RFC</th>
                                                    <th>Declarado</th>
                                                    <th>Familia</th>
                                                    <th>Entidad</th>
                                                    <th>Tramite</th>
                                                    <th>Contribuyente</th> 
                                                    <th>Inicio Tramite</th>                       
                                                    <th>Banco</th>
                                                    <th>Tipo Pago</th>                                            
                                                    <th>Total Tamite</th>
                                                </tr>
                                            </tfoot>
                                        </table>                            
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    jQuery(document).ready(function() {
        UIBlockUI.init();  
        consultaInicial();
        
    });
    
    function consultaRangoFechasOper()
    {
       fechaIn=$("#fechainicio").val();
        fechaF=$("#fechafin").val();
        var rfc=$("#rfc").val();
        if(rfc.length<1 && fechaIn.length<1 && fechaF.length<1){
            Command: toastr.warning("Fecha Inicio y Fin o RFC, Requerido!", "Notifications")            
        }else{
            consultaOper(fechaIn,fechaF);                    
        }
    }
     function consultaRangoFechasEgob()
    {
       fechaIn=$("#fechainicio2").val();
        fechaF=$("#fechafin2").val();
        var rfc=$("#rfc2").val();
        if(rfc.length<1 && fechaIn.length<1 && fechaF.length<1){
            Command: toastr.warning("Fecha Inicio y Fin o RFC, Requerido!", "Notifications")            
        }else{
            consultaEgob(fechaIn,fechaF);
                                
        }
    }
    function radiobuttons()
    {
        var option = document.querySelector('input[name = radio2]:checked').value;        
        if(option=="avanzado")
        {
            timpicker();
            timpicker2();
        }else{
            $("#addTimerpicker div").remove();
            $("#addTimerpicker2 div").remove();
            if(option=="undia")
            {
                consultaInicial();
            }
            else{consulta3dias();}
        }
    }
    function timpicker()
    {
        $("#addTimerpicker div").remove();
         $("#addTimerpicker").append("<div class='col-md-4'><span class='help-block'>&nbsp;</span> <div class='form-group'>   <label for='fecha'>Seleccionar Rango de Fechas. </label><div class='input-group input-large date-picker input-daterange' data-date-format='yyyy-mm-dd'><span class='input-group-addon'>De</span><input type='text' class='form-control' name='from' id='fechainicio' autocomplete='off'><span class='input-group-addon'>A</span><input type='text' class='form-control' name='to'id='fechafin' autocomplete='off'></div></div></div><div class='col-md-3'><span class='help-block'>&nbsp;</span><div class='form-group'> <label> RFC / Placas</label> <input type='text' placeholder='Ingrese RFC o Placas' autocomplete='off' name='rfc' id='rfc' class='form-control'></div></div><div class='col-md-1'><span class='help-block'>&nbsp; </span><span class='help-block'>&nbsp; </span><div class='form-group'><button class='btn green' id='Buscar' onclick='consultaRangoFechasOper()'>Buscar</button></div><span class='help-block'>&nbsp;</span></div>");         
         ComponentsPickers.init();   
    }
     function timpicker2()
    {
        $("#addTimerpicker2 div").remove();
         $("#addTimerpicker2").append("<div class='col-md-4'><span class='help-block'>&nbsp;</span> <div class='form-group'>   <label for='fecha'>Seleccionar Rango de Fechas. </label><div class='input-group input-large date-picker input-daterange' data-date-format='yyyy-mm-dd'><span class='input-group-addon'>De</span><input type='text' class='form-control' name='from' id='fechainicio2' autocomplete='off'><span class='input-group-addon'>A</span><input type='text' class='form-control' name='to'id='fechafin2' autocomplete='off'></div></div></div><div class='col-md-3'><span class='help-block'>&nbsp;</span><div class='form-group'> <label> RFC / Placas</label> <input type='text' placeholder='Ingrese RFC o Placas' autocomplete='off' name='rfc2' id='rfc2' class='form-control'></div></div><div class='col-md-1'><span class='help-block'>&nbsp; </span><span class='help-block'>&nbsp; </span><div class='form-group'><button class='btn green' id='Buscar' onclick='consultaRangoFechasEgob()'>Buscar</button></div><span class='help-block'>&nbsp;</span></div>");         
         ComponentsPickers.init();   
    }
    function consultaInicial()
    {        
        fechaIn = "1";
        fechaF = "1";
        consultaEgob(fechaIn,fechaF);
        consultaOper(fechaIn,fechaF);       
    }
    function consulta3dias()
    {
        fechaIn = "3";
        fechaF = "3";
        consultaEgob(fechaIn,fechaF);
        consultaOper(fechaIn,fechaF);  
    }
    
    function consultaEgob(fechaIn,fechaF) {
        Addtable2();
        document.getElementById("blockui_sample_3_1").click();
        var rfc_=$("#rfc2").val();
        $.ajax({
        method: "post",            
        url: "{{ url('/consulta-transacciones-egob') }}",
        data: {rfc:rfc_,fecha_inicio:fechaIn,fecha_fin:fechaF,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        document.getElementById('jsonCode2').value=response;
        $("#sample_2 tbody tr").remove();   
        var Resp=$.parseJSON(response);
        var color='';
        var label='';
        if(response=="[]")
        {
            $("#sample_2 tbody").append("<tr>"
                +"<td>No Found</td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"</tr>");
            
        }else{
        $.each(Resp, function(i, item) { 
            if(item.estatus=='p')
            {
                color='success';
                label='Procesado';
            }else if(item.estatus=='np')
            {
                color='danger';
                label='No procesado';
            }else if(item.estatus=='ad')
            {
                color='warning';
                label='ad';
            }else{
                color='Info';
                label='ane';
            }
             $("#sample_2 tbody").append("<tr>"
                +"<td>"+item.Transaccion+"</td>"
                +"<td>"+label+"</td>"
                +"<td>"+item.Estatus+"</td>"           
                +"<td>"+item.RFC+"</td>"
                +"<td>"+item.Declarado+"</td>"
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
           
        }
        cargatabla2();
        document.getElementById("blockui_sample_3_1_1").click();
        })
        .fail(function( msg ) {
            document.getElementById("blockui_sample_3_1_1").click();
            $("#sample_2 tbody tr").remove(); 
            $("#sample_2 tbody").append("<tr>"
                +"<td>No Found</td>"
                +"</tr>");
         Command: toastr.warning("Registro No Encontrado", "Notifications")  });
        
      
    }
    function Addtable2()
    {
        $("#table_2").remove();
        $("#addTable_2").append("<div class='portlet-body' id='table_2'><div class='table-scrollable'>                    <span class='help-block'>&nbsp; </span> <div class='row'> <div class='form-group'> <div class='col-md-11 text-right'> <button class='btn blue' onclick='saveEgob()'><i class='fa fa-file-excel-o'></i> Descargar CSV</button> </div></div> </div><span class='help-block'>&nbsp; </span>          <table class='table table-hover table-responsive' id='sample_2'><thead>  <tr><th>Transacción</th><th>Conciliacion</th><th>Estatus</th> <th>RFC</th><th>Declarado</th> "+"<th>Familia</th>"+"<th>Entidad</th> <th>Tramite</th><th>Contribuyente</th>  <th>Inicio Tramite</th> <th>Banco</th> <th>Tipo Pago</th><th>Total Tamite</th></tr> </thead><tbody> <tr><td>Espere Cargando...</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>"+"<td></td>"+"<td></td><td></td></tr> </tbody><tfoot><tr><th>Transacción</th><th>Conciliacion</th><th>Estatus</th><th>RFC</th><th>Declarado</th>"+"<th>Familia</th>"+"<th>Entidad</th><th>Tramite</th><th>Contribuyente</th>  <th>Inicio Tramite</th><th>Banco</th><th>Tipo Pago</th><th>Total Tamite</th> </tr> </tfoot></table></div> </div>");
    }
     function Addtable1()
    {
        $("#table_1").remove();
        $("#addTable_1").append("<div class='portlet-body' id='table_1'><div class='table-scrollable'>    <span class='help-block'>&nbsp; </span> <div class='row'> <div class='form-group'> <div class='col-md-11 text-right'> <button class='btn blue' onclick='saveOper()'><i class='fa fa-file-excel-o'></i> Descargar CSV</button> </div></div> </div><span class='help-block'>&nbsp; </span>        <table class='table table-hover table-responsive' id='sample_3'><thead>  <tr> <th>Transacción</th><th>Conciliacion</th><th>Estatus</th> <th>RFC</th> "+"<th>Familia</th>"+" <th>Entidad</th> <th>Tramite</th><th>Contribuyente</th>  <th>Inicio Tramite</th> <th>Banco</th> <th>Tipo Pago</th><th>Total Tamite</th></tr> </thead><tbody> <tr><td>Espere Cargando...</td><td></td><td></td><td></td>"+"<td></td>"+"<td></td><td></td><td></td><td></td><td></td></tr> </tbody><tfoot><tr> <th>Transacción</th><th>Conciliacion</th><th>Estatus</th> <th>RFC</th> "+"<th>Familia</th>"+"<th>Entidad</th> <th>Tramite</th><th>Contribuyente</th>  <th>Inicio Tramite</th> <th>Banco</th> <th>Tipo Pago</th><th>Total Tamite</th></tr></tfoot></table></div> </div>");
    }
    function cargatabla1()
    {   /*var hoy = new Date();
        var dd = hoy.getDate();
        var mm = hoy.getMonth()+1;
        var yyyy = hoy.getFullYear();*/
        $('#sample_3').DataTable( {
        /*lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title:  'Transacciones_Oper_'+yyyy+mm+dd
            },'pageLength'
        ],*/
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select class="select2me form-control"><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                           
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
        } );
        
    }
    function cargatabla2()
    {
        /*var hoy = new Date();
        var dd = hoy.getDate();
        var mm = hoy.getMonth()+1;
        var yyyy = hoy.getFullYear();*/
        $('#sample_2').DataTable( {
       /* lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Transacciones_Egob_'+yyyy+mm+dd
            },'pageLength'
        ],*/
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select class="select2me form-control"><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    } );
         
    }
    
    function consultaOper(fechaIn,fechaF) {
        Addtable1();
        document.getElementById("blockui_sample_3_1").click();
        var rfc_=$("#rfc").val();
        $.ajax({
        method: "post",            
        url: "{{ url('/consulta-transacciones-oper') }}",
        data: {rfc:rfc_,fecha_inicio:fechaIn,fecha_fin:fechaF,_token:'{{ csrf_token() }}'}  })
        .done(function (response) { 
        document.getElementById('jsonCode1').value=response;        
        $("#sample_3 tbody tr").remove();   
        var Resp=$.parseJSON(response);
         var color='';
        var label='';
        if(response=="[]")
        {
            $("#sample_3 tbody").append("<tr>"
                +"<td>No Found</td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"</tr>");
        }else{
        $.each(Resp, function(i, item) { 
               if(item.estatus=='p')
            {
                color='success';
                label='procesado';
            }else if(item.estatus=='np')
            {
                color='danger';
                label='No procesado';
            }else if(item.estatus=='ad')
            {
                color='warning';
                label='ad';
            }else{
                color='Info';
                label='ane';
            }
             $("#sample_3 tbody").append("<tr>"
                +"<td>"+item.Transaccion+"</td>"
                +"<td>"+label+"</td>"
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
        }
       cargatabla1();
        document.getElementById("blockui_sample_3_1_1").click();
        })
        .fail(function( msg ) {
            document.getElementById("blockui_sample_3_1_1").click();
            $("#sample_3 tbody tr").remove(); 
            $("#sample_3 tbody").append("<tr>"
                +"<td>No Found</td>"
                +"</tr>");
         Command: toastr.warning("Registro No Encontrado", "Notifications")  });     
    }

    function saveEgob()
    {
        var JSONData=$("#jsonCode2").val();
        var ReportTitle='Transacciones_Egobierno';
        JSONToCSVConvertor(JSONData, ReportTitle, true);
    }
    function saveOper()
    {
        var JSONData=$("#jsonCode1").val();
        var ReportTitle='Transacciones_Operaciones';
        JSONToCSVConvertor(JSONData, ReportTitle, true);
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
