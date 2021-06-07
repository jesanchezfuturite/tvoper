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
    <div class="portlet-body" >
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
                        <li>
                            <a href="#tab_2" data-toggle="tab">Contribuyente</a>
                        </li>
                        <li>
                            <a href="#tab_3" data-toggle="tab">Tramites</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_0">
                            <span class="help-block"></span>
                            <div class="portlet box blue">
                                <div class="portlet-title"><div class="caption"><i class="fa fa-gift"></i>Operaciones</div></div>
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
                                        <div id="addTimerpicker" hidden="true">
                                            <div class='col-md-4'><span class='help-block'>&nbsp;</span> <div class='form-group'>   <label for='fecha'>Seleccionar Rango de Fechas. </label><div class='input-group input-large date-picker input-daterange' data-date-format='yyyy-mm-dd'><span class='input-group-addon'>De</span><input type='text' class='form-control' name='from' id='fechainicio' autocomplete='off'><span class='input-group-addon'>A</span><input type='text' class='form-control' name='to'id='fechafin' autocomplete='off'></div></div></div>
                                            <div class="col-md-3"><span class='help-block'>&nbsp;</span>
                                                        <div class="form-group">
                                                            <label>Familia</label>
                                                            <select class="select2me form-control"  id="itemsFamilia" >
                                                                <option>------</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                            <div class='col-md-3'><span class='help-block'>&nbsp;</span><div class='form-group'> <label> RFC / Placas / Folio</label> <input type='text' placeholder='Ingrese RFC / Placas / Folio' autocomplete='off' name='rfc' id='rfc' class='form-control'></div></div><div class='col-md-1'><span class='help-block'>&nbsp; </span><span class='help-block'>&nbsp; </span><div class='form-group'><button class='btn green' id='Buscaroper' onclick='consultaRangoFechasOper()'>Buscar</button></div></div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='form-group'>
                                            <div class='col-md-12 text-right'>
                                                <button class='btn blue' onclick='saveOper()'><i class='fa fa-file-excel-o'></i> Descargar CSV</button>
                                            </div>
                                        </div>
                                    </div>
                                    <span class='help-block'>&nbsp; </span>
                                    <div id="addTable_1">
                                        <div  id="table_1">
                                            <div class="table-scrollable">
                                                <table class="table table-hover table-responsive" id="sample_3">
                                                    <thead>
                                                        <tr>
                                                            <th>Folio</th>
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
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_1">

                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i>Egobierno
                                    </div>
                                </div>
                                <div class="portlet-body" >
                                <div class="row">
                                <div class="col-md-12 text-right">
                                <span class="help-block">Selecciona una Opcion. </span>
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" id="radio" name="radio3" class="md-radiobtn" value="undia" onclick="radiobuttons2()">
                                            <label for="radio3">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            Hace 1 Dia (Últimas 24hrs). </label>
                                        </div>|
                                        <div class="md-radio">
                                            <input type="radio" id="radio4" name="radio3" class="md-radiobtn" value="tresdias" onclick="radiobuttons2()">
                                            <label for="radio4">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            Hace 3 Días.</label>
                                        </div>|
                                        <div class="md-radio">
                                            <input type="radio" id="radio5" name="radio3" class="md-radiobtn" value="avanzado" onclick="radiobuttons2()">
                                            <label for="radio5">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            Avanzado (Rango Fechas). </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                    <div class="row">
                                        <div id="addTimerpicker2" hidden="true">
                                            <div class='col-md-4'><span class='help-block'>&nbsp;</span> <div class='form-group'>   <label for='fecha'>Seleccionar Rango de Fechas. </label><div class='input-group input-large date-picker input-daterange' data-date-format='yyyy-mm-dd'><span class='input-group-addon'>De</span><input type='text' class='form-control' name='from' id='fechainicio2' autocomplete='off'><span class='input-group-addon'>A</span><input type='text' class='form-control' name='to'id='fechafin2' autocomplete='off'></div></div></div><div class='col-md-3'><span class='help-block'>&nbsp;</span><div class='form-group'> <label> RFC / Placas / Folio</label> <input type='text' placeholder='Ingrese RFC / Placas / Folio' autocomplete='off' name='rfc2' id='rfc2' class='form-control'></div></div><div class='col-md-1'><span class='help-block'>&nbsp; </span><span class='help-block'>&nbsp; </span><div class='form-group'><button class='btn green' id='Buscaregob' onclick='consultaRangoFechasEgob()'>Buscar</button></div></div>
                                        </div>
                                    </div>
                                        <div class='row'> <div class='form-group'> <div class='col-md-12 text-right'> <button class='btn blue' onclick='saveEgob()'><i class='fa fa-file-excel-o'></i> Descargar CSV</button> </div></div> </div><span class='help-block'>&nbsp; </span>
                                    <div id="addTable_2">
                                    <div id="table_2">
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

                                    </table>
                                </div>
                                </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i>Contribuyente
                                    </div>
                                </div>
                                <div class="portlet-body" >
                                    <div class="row">
                                        <span class='help-block'>&nbsp;</span>
                                        <div id="addTimerpicker3">
                                            <div class='col-md-4'>
                                                <div class='form-group'>
                                                    <label for='fecha'>Seleccionar Rango de Fechas. </label>
                                                    <div class='input-group input-large date-picker input-daterange' data-date-format='yyyy-mm-dd'>
                                                        <span class='input-group-addon'>De</span>
                                                        <input type='text' class='form-control' name='from' id='fechainicio3' autocomplete='off'>
                                                        <span class='input-group-addon'>A</span>
                                                        <input type='text' class='form-control' name='to'id='fechafin3' autocomplete='off'>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='col-md-1'>
                                                <span class='help-block'>&nbsp; </span>
                                                <div class='form-group'><button class='btn green' id='Buscar' onclick='consultaRangoFechasGpm()'>Buscar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='form-group'>
                                            <div class='col-md-12 text-right'>
                                                <button class='btn blue' onclick='saveContr()'><i class='fa fa-file-excel-o'></i> Descargar CSV</button>
                                            </div>
                                        </div>
                                    </div>
                                    <span class='help-block'>&nbsp; </span>
                                    <div id="addTable_3">
                                        <div id="table_3">
                                            <div class="table-scrollable">
                                                <table class="table table-hover table-responsive" id="sample_4">
                                                    <thead>
                                                        <tr>
                                                            <th>Id Transacción</th>
                                                            <th>Id Transaccion Entidad</th>
                                                            <th>Fecha Transacición</th>
                                                            <th>Importe Transacción</th>
                                                            <th>Nombre Tramite</th>
                                                            <th>Id Tramite Egob</th>
                                                            <th>Id Tramite Entidad</th>
                                                            <th>Importe Tramite</th>
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
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_3">
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i>Tramites
                                    </div>
                                </div>
                                <div class="portlet-body" >
                                <div class="row">
                                <div class="col-md-12 text-right">
                                <span class="help-block">Selecciona una Opcion. </span>
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" id="radio_1" name="radio7" class="md-radiobtn" value="undia" onclick="radiobuttonsTramites()">
                                            <label for="radio_1">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            Hace 1 Dia (Últimas 24hrs). </label>
                                        </div>|
                                        <div class="md-radio">
                                            <input type="radio" id="radio_2" name="radio7" class="md-radiobtn" value="tresdias" onclick="radiobuttonsTramites()">
                                            <label for="radio_2">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            Hace 3 Días.</label>
                                        </div>|
                                        <div class="md-radio">
                                            <input type="radio" id="radio_3" name="radio7" class="md-radiobtn" value="avanzado" onclick="radiobuttonsTramites()">
                                            <label for="radio_3">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            Avanzado (Rango Fechas). </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                    <div class="row">
                                        <div id="addTimerpicker4" hidden="true">
                                            <div class='col-md-4'>
                                                <span class='help-block'>&nbsp;</span> 
                                                <div class='form-group'>   
                                                    <label for='fecha'>Seleccionar Rango de Fechas. </label>
                                                    <div class='input-group input-large date-picker input-daterange' data-date-format='yyyy-mm-dd'>
                                                        <span class='input-group-addon'>De</span>
                                                        <input type='text' class='form-control' name='from' id='fechainicio4' autocomplete='off'>
                                                        <span class='input-group-addon'>A</span>
                                                        <input type='text' class='form-control' name='to'id='fechafin4' autocomplete='off'>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='col-md-3'>
                                                <span class='help-block'>&nbsp;</span>
                                                <div class='form-group'> 
                                                    <label> RFC / Placas / Folio</label> 
                                                    <input type='text' placeholder='Ingrese RFC / Placas / Folio' autocomplete='off' name='rfc4' id='rfc4' class='form-control'>
                                                </div>
                                            </div>
                                            <div class='col-md-1'>
                                                <span class='help-block'>&nbsp; </span>
                                                <span class='help-block'>&nbsp; </span>
                                                <div class='form-group'>
                                                    <button class='btn green' id='BuscarTramites' onclick='consultaRangoFechasTramites()'>Buscar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'> 
                                        <div class='form-group'> 
                                            <div class='col-md-12 text-right'> 
                                                <button class='btn blue' onclick='saveTramites()'><i class='fa fa-file-excel-o'></i> Descargar CSV</button> 
                                            </div>
                                        </div> 
                                    </div>
                                    <span class='help-block'>&nbsp; </span>
                                    <div id="addTable_4">
                                        <div id="table_4">
                                            <div class="table-scrollable">
                                                <table class="table table-hover table-responsive" id="sample_7">
                                                    <thead>
                                                        <tr> 
                                                            <th>Transacción</th>
                                                            <th>Conciliacion</th>
                                                            <th>Estatus</th>
                                                            <th>Declarado</th>
                                                            <th>Familia</th>
                                                            <th>Entidad</th>
                                                            <th>Tramite</th>
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
                                                        </tr>                                   
                                                    </tbody>
                                        
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
<input type="text" name="jsonCode3" id="jsonCode3" hidden="true">
<input type="text" name="jsonCode4" id="jsonCode4" >
                                                        
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
        cargatabla1();
        cargatabla2(); 
        cargatabla3(); 
        cargatabla4();
        ComponentsPickers.init(); 
        findFamilia();
    });

    function consultaRangoFechasOper()
    {
       fechaIn=$("#fechainicio").val();
        fechaF=$("#fechafin").val();
        var rfc=$("#rfc").val();
        if(rfc.length<1 && fechaIn.length<1 && fechaF.length<1){
            Command: toastr.warning("Rango de Fechas o RFC / Placa / Folio, Requerido!", "Notifications")
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
            Command: toastr.warning("Rango de Fechas o RFC / Placa / Folio, Requerido!", "Notifications")
        }else{
            consultaEgob(fechaIn,fechaF);

        }
    }
    function consultaRangoFechasGpm()
    {
       fechaIn=$("#fechainicio3").val();
        fechaF=$("#fechafin3").val();
        if(fechaIn.length<1 && fechaF.length<1){
            Command: toastr.warning("Fecha Inicio y Fin, Requerido!", "Notifications")
        }else{
            consultaGpm(fechaIn,fechaF);
        }
    }
    function consultaRangoFechasTramites()
    {
       fechaIn=$("#fechainicio4").val();
        fechaF=$("#fechafin4").val();
        if(fechaIn.length<1 && fechaF.length<1){
            Command: toastr.warning("Fecha Inicio y Fin, Requerido!", "Notifications")
        }else{
            consultaTramites(fechaIn,fechaF);
        }
    }
    function radiobuttons()
    {
        document.getElementById('fechainicio').value='';
        document.getElementById('fechafin').value='';
        document.getElementById('rfc').value='';

        var option = document.querySelector('input[name = radio2]:checked').value;
        if(option=="avanzado")
        {
            timpicker();
        }else{
            //$("#addTimerpicker div").remove();
            $("#addTimerpicker").css("display", "none");
            if(option=="undia")
           {
                consultaOper("1","1");
            }else{
                consultaOper("3","3");
            }
        }
    }
    function radiobuttons2()
    {
        document.getElementById('fechainicio2').value='';
        document.getElementById('fechafin2').value='';
        document.getElementById('rfc2').value='';
        console.log('Egobierno');
        var option = document.querySelector('input[name = radio3]:checked').value;
        if(option=="avanzado")
        {
            timpicker2();
        }else{
            //$("#addTimerpicker2 div").remove();
             $("#addTimerpicker2").css("display", "none");
            if(option=="undia")
            {
                consultaEgob('1','1');
            }else{
                consulta3dias('3','3');
            }
        }
    }
    function radiobuttonsTramites()
    {
        document.getElementById('fechainicio4').value='';
        document.getElementById('fechafin4').value='';
        document.getElementById('rfc4').value='';
        var option = document.querySelector('input[name = radio7]:checked').value;
        console.log(option);
        if(option=="avanzado")
        {
            timpicker2();
        }else{
            //$("#addTimerpicker2 div").remove();
             $("#addTimerpicker2").css("display", "none");
            if(option=="undia")
            {
                consultaTramites('1','1');
            }else{
                consultaTramites('3','3');
            }
        }
    }
    function timpicker()
    {
        //$("#addTimerpicker div").remove();
         //$("#addTimerpicker").append("");
         $("#addTimerpicker").css("display", "block");
        document.getElementById('fechainicio').value='';
        document.getElementById('fechafin').value='';
        document.getElementById('rfc').value='';
    }
     function timpicker2()
    {
        //$("#addTimerpicker2 div").remove();
        /// $("#addTimerpicker2").append("");
        $("#addTimerpicker2").css("display", "block");
        document.getElementById('fechainicio2').value='';
        document.getElementById('fechafin2').value='';
        document.getElementById('rfc2').value='';
    }

    $("#rfc").on("keypress", function(e)  {
        if (e.keyCode == 13) {
           var rfc=$('#rfc').val();
            if(rfc.length==0)
            {
                Command: toastr.warning("RFC / Placas / Folio, Requerido!!", "Notifications")
            }else{
                consultaRangoFechasOper();
            }

        }
    });
    $("#rfc2").keyup(function (e) {
        if (e.keyCode  == 13) {
            var rfc2=$('#rfc2').val();
            if(rfc2.length==0)
            {
                Command: toastr.warning("RFC / Placas / Folio, Requerido!!", "Notifications")
            }else{
                    consultaRangoFechasEgob();
            }

        }
    });

    function consultaEgob(fechaIn,fechaF) {
        Addtable2();
        //document.getElementById("blockui_sample_3_1").click();
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
        $.each(Resp, function(i, item) {
            /*if(item.estatus=='p')
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
            }*/
             $("#sample_2 tbody").append("<tr>"
                +"<td>"+item.Transaccion+"</td>"
                +"<td>"+item.estatus+"</td>"
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
        cargatabla2();
        //document.getElementById("blockui_sample_3_1_1").click();
        })
        .fail(function( msg ) {
            //document.getElementById("blockui_sample_3_1_1").click();
            $("#sample_2 tbody tr").remove();
            $("#sample_2 tbody").append("<tr>"
                +"<td>No Found</td>"
                +"</tr>");
         Command: toastr.warning("Registro No Encontrado", "Notifications")  });


    }
    function Addtable4()
    {
        $("#table_4").remove();
        $("#addTable_4").append("<div id='table_4'><div class='table-scrollable'><table class='table table-hover table-responsive' id='sample_7'><thead><tr><th>Transacción</th><th>Conciliacion</th><th>Estatus</th><th>Declarado</th><th>Familia</th> <th>Entidad</th><th>Tramite</th></tr> </thead><tbody>  <tr><td><strong>Espere Cargando...</strong></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>  </tbody> </table></div> </div>");
    }
    function Addtable3()
    {
        $("#table_3").remove();
        $("#addTable_3").append("<div id='table_3'><div class='table-scrollable'>     <table class='table table-hover table-responsive' id='sample_4'><thead><tr> <th>Id Transacción</th>  <th>Id Transaccion Entidad</th> <th>Fecha Transacición</th> <th>Importe Transacción</th> <th>Nombre Tramite</th>  <th>Id Tramite Egob</th><th>Id Tramite Entidad</th><th>Importe Tramite</th></tr> </thead><tbody>  <tr><td><strong>Espere Cargando...</strong></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>  </tbody> </table></div> </div>");
    }
    function Addtable2()
    {
        $("#table_2").remove();
        $("#addTable_2").append("<div id='table_2'><div class='table-scrollable'>          <table class='table table-hover table-responsive' id='sample_2'><thead>  <tr><th>Transacción</th><th>Conciliacion</th><th>Estatus</th> <th>RFC</th><th>Declarado</th> "+"<th>Familia</th>"+"<th>Entidad</th> <th>Tramite</th><th>Contribuyente</th>  <th>Inicio Tramite</th> <th>Banco</th> <th>Tipo Pago</th><th>Total Tamite</th></tr> </thead><tbody> <tr><td> <strong>Espere Cargando...</strong></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>"+"<td></td>"+"<td></td><td></td></tr> </tbody></table></div> </div>");
    }
     function Addtable1()
    {
        $("#table_1").remove();
        $("#addTable_1").append("<div id='table_1'><div class='table-scrollable'>   <table class='table table-hover table-responsive' id='sample_3'><thead>  <tr><th>Folio</th> <th>Transacción</th><th>Conciliacion</th><th>Estatus</th> <th>RFC</th> "+"<th>Familia</th>"+" <th>Entidad</th> <th>Tramite</th><th>Contribuyente</th>  <th>Inicio Tramite</th> <th>Banco</th> <th>Tipo Pago</th><th>Total Tamite</th></tr> </thead><tbody> <tr><td><strong>Espere Cargando...</strong></td><td></td><td></td><td></td>"+"<td></td>"+"<td></td><td></td><td></td><td></td><td></td><td></td></tr> </tbody></table></div> </div>");
    }
    function cargatabla1()
    {    var inin=0;
        $('#sample_3 thead tr').clone(true).appendTo( '#sample_3 thead' );
        $('#sample_3').DataTable( {
        "lengthMenu": [[5, 15, 20, -1], [5, 15, 20, "All"]],
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;

                //console.log(inin);

                var select = $('<select class="select2me form-control"><option value=""></option></select>')


                    .appendTo( $("#sample_3 thead tr:eq(0) th:eq('"+inin+"')").empty() )
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
                 inin=inin+1;
            } );
        }
        } );

    }
    function cargatabla2()
    {
         var inin=0;
        $('#sample_2 thead tr').clone(true).appendTo( '#sample_2 thead' );
        $('#sample_2').DataTable( {
        "lengthMenu": [[5, 15, 20, -1], [5, 15, 20, "All"]],
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select class="select2me form-control"><option value=""></option></select>')
                    .appendTo( $("#sample_2 thead tr:eq(0) th:eq('"+inin+"')").empty() )
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
                 inin=inin+1;
            } );
            }
        } );

    }
    function cargatabla3()
    {
         var inin=0;
        $('#sample_4 thead tr').clone(true).appendTo( '#sample_4 thead' );
        $('#sample_4').DataTable( {
        "lengthMenu": [[5, 15, 20, -1], [5, 15, 20, "All"]],
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select class="select2me form-control"><option value=""></option></select>')
                    .appendTo( $("#sample_4 thead tr:eq(0) th:eq('"+inin+"')").empty() )
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
                 inin=inin+1;
            } );
            }
        } );

    }

    function cargatabla4()
    {
        console.log("ola");
         var inin=0;
        $('#sample_5 thead tr').clone(true).appendTo( '#sample_5 thead' );
        $('#sample_5').DataTable( {
        "lengthMenu": [[5, 15, 20, -1], [5, 15, 20, "All"]],
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select class="select2me form-control"><option value=""></option></select>')
                    .appendTo( $("#sample_7 thead tr:eq(0) th:eq('"+inin+"')").empty() )
                    .on( 'change', function () {
                        console.log($(this).val());
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
                 inin=inin+1;
            } );
            }
        } );

    }

    function consultaOper(fechaIn,fechaF) {
        Addtable1();
        //document.getElementById("blockui_sample_3_1").click();
        var rfc_=$("#rfc").val();
        var familia_=$("#itemsFamilia").val();
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

        $.each(Resp, function(i, item) {
             /*  if(item.estatus=='p')
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
            }*/
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
        //document.getElementById("blockui_sample_3_1_1").click();
        })
        .fail(function( msg ) {
            //document.getElementById("blockui_sample_3_1_1").click();
            $("#sample_3 tbody tr").remove();
            $("#sample_3 tbody").append("<tr>"
                +"<td>No Found</td>"
                +"</tr>");
         Command: toastr.warning("Registro No Encontrado", "Notifications")  });
    }
    function consultaTramites(fechaIn,fechaF) {
        Addtable4();
        //document.getElementById("blockui_sample_3_1").click();
        $.ajax({
        method: "post",
        url: "{{ url('/consulta-transacciones-tramites') }}",
        data: {fecha_inicio:fechaIn,fecha_fin:fechaF,_token:'{{ csrf_token() }}'}  })
        .done(function (response) { 
            obj = JSON.stringify(response);
        document.getElementById('jsonCode4').value=obj;        
        $("#sample_7 tbody tr").remove();   
        // var Resp=$.parseJSON(response);
         var color='';
        var label='';

        $.each(Resp, function(i, item) {
            console.log(item);
             $("#sample_7 tbody").append("<tr>"
                +"<td>"+item.id+"</td>"
                +"<td>"+item.id_transaccion_motor+"</td>"
                +"<td>"+item.fecha_transaccion+"</td>"
                +"<td>"+item.notary_number+"</td>"
                +"<td>"+item.titular.apellido_paterno_titular+"</td>"
                +"<td>"+item.titular.apellido_materno_titular+"</td>"
                +"<td>"+item.info.tipoTramite+"</td>"
                +"</tr>");
            });
       cargatabla4();
        //document.getElementById("blockui_sample_3_1_1").click();
        })
        .fail(function( msg ) {
            //document.getElementById("blockui_sample_3_1_1").click();
            $("#sample_5 tbody tr").remove();
            $("#sample_5 tbody").append("<tr>"
                +"<td>No Found</td>"
                +"</tr>");
         Command: toastr.warning("Registro No Encontrado", "Notifications")  });
    }
    function consultaOper(fechaIn,fechaF) {
        console.log(fechaIn, fechaF);
        Addtable1();
        //document.getElementById("blockui_sample_3_1").click();
        var rfc_=$("#rfc").val();
        var familia_=$("#itemsFamilia").val();
        $.ajax({
        method: "post",
        url: "{{ url('/consulta-transacciones-oper') }}",
        data: {familia:familia_,rfc:rfc_,fecha_inicio:fechaIn,fecha_fin:fechaF,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        document.getElementById('jsonCode1').value=response;
        $("#sample_3 tbody tr").remove();
        var Resp=$.parseJSON(response);
         var color='';
        var label='';

        $.each(Resp, function(i, item) {
             /*  if(item.estatus=='p')
            {
                color='success';
                label='procesado';
            }else if(item.estatus=='np')
            {
                color='danger';
                label='No procesado';
            }else if(item.estatus=='ad')
            {f
                color='warning';
                label='ad';
            }else{
                color='Info';
                label='ane';
            }*/
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
        //document.getElementById("blockui_sample_3_1_1").click();
        })
        .fail(function( msg ) {
            //document.getElementById("blockui_sample_3_1_1").click();
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
     function saveContr()
    {
        var JSONData=$("#jsonCode3").val();
        var ReportTitle='Transacciones_Contribuyente';
        JSONToCSVConvertor(JSONData, ReportTitle, true);
    }
    function saveTramites()
    {
        var JSONData=$("#jsonCode4").val();
        var ReportTitle='Transacciones_tramites';
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
    //document.getElementById("blockui_sample_3_1_1").click();

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
