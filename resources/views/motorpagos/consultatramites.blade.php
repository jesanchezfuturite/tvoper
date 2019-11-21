@extends('layout.app')

@section('content')
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
  <a href="javascript:;" class="btn default" id="blockui_sample_3_1_1" >Unblock</a></div>
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
                <div class="row">
                    <div id="addTimerpicker">
               
                    </div>
                </div> 
                <div class="tab-pane active" id="tab_0">
                    <div class="portlet box blue" id="addTable_1">

                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>Operaciones
                            </div>
                        </div>                    
                                                 
                        <div class="portlet-body "> 
                                                      
                            <div class="row "> 
                             <div class="col-md-3"> </div>
                                <div class="col-md-3"> 
                                    <div class="form-group">
                                        <span class="help-block">Entidad</span>
                                            <select id="itemsEntidad" class="select2me form-control" onchange="ChangeItemsOper()">
                                                 <option id="limpia" value="limpia">-------</option>
                                               
                                            </select>
                                        <span class="help-block  text-right">Seleccione una Opcion </span>
                                    </div>
                                </div>
                                <div class="col-md-3"> 
                                    <div class="form-group">
                                        <span class="help-block"> Estatus</span>
                                            <select id="itemsStatus" class="select2me form-control" onchange="ChangeItemsOper()">
                                                 <option id="limpia" value="limpia">-------</option>
                                               
                                            </select>
                                        <span class="help-block  text-right">Seleccione una Opcion </span>
                                    </div>
                                </div>                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                    <span class="help-block">Tramite </span>                                       
                                            <select id="itemsTipoServicio" class="select2me form-control" onchange="ChangeItemsOper()">
                                                 <option id="limpia" value="limpia">-------</option>
                                               
                                            </select>
                                        <span class="help-block text-right">Seleccione una Opcion </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body" id="table_1"> 
                                <table class="table table-hover" id="sample_3">
                                    <thead>
                                        <tr> 
                                            <th>Estatus</th>
                                            <th>Transacción</th>
                                            <th>RFC</th>
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
                                        </tr>                                   
                                    </tbody>
                                </table>                          
                        </div>
                     </div>
                </div>            
                <div class="tab-pane" id="tab_1">
                    <div class="portlet box blue" id="addTable_2">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>Egobierno
                            </div>
                        </div>
                        <div class="portlet-body ">                         
                            <div class="row"> 
                                <div class="col-md-3"> </div>
                                <div class="col-md-3"> 
                                    <div class="form-group">
                                         <span class="help-block"> Entidad</span>
                                            <select id="itemsEntidad2" class="select2me form-control" onchange="ChangeItemsEgob()">
                                                 <option id="limpia" value="limpia">-------</option>
                                               
                                            </select>
                                        <span class="help-block text-right">Seleccione una Opcion </span>
                                    </div>
                                </div>
                                <div class="col-md-3 "> 
                                    <div class="form-group">
                                        <span class="help-block"> Estatus</span>
                                            <select id="itemsStatus2" class="select2me form-control" onchange="ChangeItemsEgob()">
                                                 <option id="limpia" value="limpia">-------</option>
                                               
                                            </select>
                                        <span class="help-block  text-right">Seleccione una Opcion </span>
                                    </div>
                                </div>  
                                <div class="col-md-3">                              
                                    <div class="form-group">
                                         <span class="help-block"> Tramite</span>
                                            <select id="itemsTipoServicio2" class="select2me form-control" onchange="ChangeItemsEgob()">
                                                 <option id="limpia" value="limpia">-------</option>
                                               
                                            </select>
                                        <span class="help-block text-right">Seleccione una Opcion </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="portlet-body" id="table_2"> 
                            <table class="table table-hover" id="sample_2">
                                    <thead>
                                        <tr> 
                                            <th>Estatus</th>
                                            <th>Transacción</th>
                                            <th>RFC</th>
                                            <th>Declarado</th>
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

                            
@endsection

@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {
        UIBlockUI.init();  
        consultaInicial();
        AddOptionTipoServicio(); 
        AddOptionTipoServicio2(); 
        findEstatus();
        findEstatus2();
        FindEntidad();
        FindEntidad2();
        
    });
    function FindEntidad2()
    {
         $.ajax({
           method: "get",            
           url: "{{ url('/entidad-find') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);
          var item="";
          $("#itemsEntidad2 option").remove();
          $("#itemsEntidad2").append("<option value='limpia'>-------</option>"
            );
        $.each(Resp, function(i, item) {                
               $("#itemsEntidad2").append("<option value='"+item.id+"'>"+item.nombre+"</option>"
            );  
        });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
    function FindEntidad()
    {
         $.ajax({
           method: "get",            
           url: "{{ url('/entidad-find') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);
          var item="";
          $("#itemsEntidad option").remove();
          $("#itemsEntidad").append("<option value='limpia'>-------</option>"
            );
        $.each(Resp, function(i, item) {                
               $("#itemsEntidad").append("<option value='"+item.id+"'>"+item.nombre+"</option>"
            );  
        });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
    function ChangeItemsEgob()
    {
        fechaIn=$("#fechainicio").val();
        fechaF=$("#fechafin").val();
        var rfc=$("#rfc").val();
        var option = document.querySelector('input[name = radio2]:checked').value;        
        if(option=="avanzado")
        {
            if(rfc.length<1 && fechaIn.length<1 && fechaF.length<1){
                Command: toastr.warning("Fecha Inicio y Fin o RFC, Requerido!", "Notifications")            
            }else{
                consultaEgobChange(fechaIn,fechaF);
            }            
        }else{
            $("#addTimerpicker div").remove();
            if(option=="undia")
            {              
                consultaEgobChange("1","1");
            }
            else{consultaEgobChange("3","3");}
        }
    }
    function ChangeItemsOper()
    {
        var option = document.querySelector('input[name = radio2]:checked').value;        
        if(option=="avanzado")
        {
            consultaRangoFechasOper();
        }else{
            $("#addTimerpicker div").remove();
            if(option=="undia")
            {              
                consultaOper("1","1");
            }
            else{consultaOper("3","3");}
        }
    }
    function consultaRangoFechasEgobOper()
    {
       fechaIn=$("#fechainicio").val();
        fechaF=$("#fechafin").val();
        var rfc=$("#rfc").val();
        if(rfc.length<1 && fechaIn.length<1 && fechaF.length<1){
            Command: toastr.warning("Fecha Inicio y Fin o RFC, Requerido!", "Notifications")            
        }else{
            consultaEgob(fechaIn,fechaF);
            consultaOper(fechaIn,fechaF);                    
        }
    }
   
    function findEstatus()
    {
        $.ajax({
           method: "get",           
           url: "{{ url('/status-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          var Resp=$.parseJSON(response);
           $("#itemsStatus option").remove();
         $('#itemsStatus').append(
            "<option value='limpia'>------</option>"
        );
        $.each(Resp, function(i, item) {                
            $('#itemsStatus').append(
                "<option value='"+item.id+"'>"+item.nombre+"</option>"
                );
            });
        })
        .fail(function( msg ) {
         console.log("Error al Cargar select Option Limite Referencia");  });
    }
    function findEstatus2()
    {
        $.ajax({
           method: "get",           
           url: "{{ url('/status-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          var Resp=$.parseJSON(response);
           $("#itemsStatus2 option").remove();
         $('#itemsStatus2').append(
            "<option value='limpia'>------</option>"
        );
        $.each(Resp, function(i, item) {                
            $('#itemsStatus2').append(
                "<option value='"+item.id+"'>"+item.nombre+"</option>"
                );
            });
        })
        .fail(function( msg ) {
         console.log("Error al Cargar select Option Limite Referencia");  });
    }
     function AddOptionTipoServicio() 
    {          
            $.ajax({
           method: "get",            
           url: "{{ url('/tiposervicio-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) { 
        $("#itemsTipoServicio option").remove();
        var Resp=$.parseJSON(responseinfo);

         $('#itemsTipoServicio').append(
                "<option value='limpia'>------</option>"
        );
          var item="";
        $.each(Resp, function(i, item) {                
                 $('#itemsTipoServicio').append(
                "<option value='"+item.id+"'>"+item.nombre+"</option>"
                   );
                });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
            return false;
    }
     function AddOptionTipoServicio2() 
    {          
            $.ajax({
           method: "get",            
           url: "{{ url('/tiposervicio-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) { 
        $("#itemsTipoServicio2 option").remove();
        var Resp=$.parseJSON(responseinfo);
         $('#itemsTipoServicio2').append(
                "<option value='limpia'>------</option>"
            );
          var item="";
        $.each(Resp, function(i, item) {                
                 $('#itemsTipoServicio2').append(
                "<option value='"+item.id+"'>"+item.nombre+"</option>"
                   );
                });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
            return false;
    }
    function addOptionTipoServicioExiste2(add)
    {
        $("#itemsTipoServicio2 option").remove();
        var Resp=$.parseJSON(add);
        var persona = {};
        var unicos = Array.from(new Set(Resp.map(s => s.id)))
            .map(id => {
            return {
            id: id,
            tramite: Resp.find(s => s.id === id).tramite
            };
        });        
         $('#itemsTipoServicio2').append(
                "<option value='limpia'>------</option>"
            );
          var item="";
        $.each(unicos, function(i, item) {                
                 $('#itemsTipoServicio2').append(
                "<option value='"+item.id+"'>"+item.tramite+"</option>"
                   );
                });
    }
    function radiobuttons()
    {
        var option = document.querySelector('input[name = radio2]:checked').value;        
        if(option=="avanzado")
        {
            timpicker();
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
         $("#addTimerpicker").append("<div class='col-md-4'><span class='help-block'>&nbsp;</span> <div class='form-group'>   <label for='fecha'>Seleccionar Rango de Fechas. </label><div class='input-group input-large date-picker input-daterange' data-date-format='yyyy-mm-dd'><span class='input-group-addon'>De</span><input type='text' class='form-control' name='from' id='fechainicio' autocomplete='off'><span class='input-group-addon'>A</span><input type='text' class='form-control' name='to'id='fechafin' autocomplete='off'></div></div></div><div class='col-md-3'><span class='help-block'>&nbsp;</span><div class='form-group'> <label> RFC / Placas</label> <input type='text' placeholder='Ingrese RFC o Placas' autocomplete='off' name='rfc' id='rfc' class='form-control'></div></div><div class='col-md-1'><span class='help-block'>&nbsp; </span><span class='help-block'>&nbsp; </span><div class='form-group'><button class='btn green' id='Buscar' onclick='consultaRangoFechasEgobOper()'>Buscar</button></div><span class='help-block'>&nbsp;</span></div>");         
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
        var status=$("#itemsStatus2").val();
        var servicio=$("#itemsTipoServicio2").val();
        var rfc_=$("#rfc").val();
        var entidad_=$("#itemsEntidad2").val();
        $.ajax({
        method: "post",            
        url: "{{ url('/consulta-transacciones-egob') }}",
        data: {rfc:rfc_,tipo_servicio:servicio,estatus:status,entidad:entidad_,fecha_inicio:fechaIn,fecha_fin:fechaF,_token:'{{ csrf_token() }}'}  })
        .done(function (response) { 
        var addServicios='[';
        var coma="";
        $("#sample_2 tbody tr").remove();   
        var Resp=$.parseJSON(response);
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
                +"</tr>");
            
        }else{
        $.each(Resp, function(i, item) { 
             $("#sample_2 tbody").append("<tr>"
                +"<td>"+item.Estatus+"</td>"
                +"<td><a href='#large' data-toggle='modal'>"+item.Transaccion+"</a></td>"
                +"<td>"+item.RFC+"</td>"
                +"<td>"+item.Declarado+"</td>"
                +"<td>"+item.Entidad+"</td>"
                +"<td>"+item.Tramite+"</td>"
                +"<td>"+item.Contribuyente+"</td>"
                +"<td>"+item.Inicio_Tramite+"</td>"
                +"<td>"+item.Banco+"</td>"
                +"<td>"+item.Tipo_Pago+"</td>"
                +"<td>"+item.Total_Tramite+"</td>"
                +"</tr>");
            addServicios=addServicios+coma+'{"id":"'+item.tiposervicio_id+'","tramite":"'+item.Tramite+'"}';
            coma=",";
            });
            addServicios=addServicios+"]";        
        addOptionTipoServicioExiste2(addServicios);
        }
       
       TableManaged2.init2();
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
     function consultaEgobChange(fechaIn,fechaF) {
        Addtable2();
        document.getElementById("blockui_sample_3_1").click();
        var status=$("#itemsStatus2").val();
        var servicio=$("#itemsTipoServicio2").val();
        var entidad_=$("#itemsEntidad2").val();        
        var rfc_=$("#rfc").val();
        $.ajax({
        method: "post",            
        url: "{{ url('/consulta-transacciones-egob') }}",
        data: {rfc:rfc_,tipo_servicio:servicio,estatus:status,entidad:entidad_,fecha_inicio:fechaIn,fecha_fin:fechaF,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {        
        $("#sample_2 tbody tr").remove();   
        var Resp=$.parseJSON(response);
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
                +"</tr>");            
        }else{
        $.each(Resp, function(i, item) { 
             $("#sample_2 tbody").append("<tr>"
                +"<td>"+item.Estatus+"</td>"
                +"<td><a href='#large' data-toggle='modal'>"+item.Transaccion+"</a></td>"
                +"<td>"+item.RFC+"</td>"
                +"<td>"+item.Declarado+"</td>"
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
       TableManaged2.init2();
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
        //$("#table_1").remove();
        $("#addTable_2").append("<div class='portlet-body' id='table_2'><table class='table table-hover' id='sample_2'><thead>  <tr><th>Estatus</th><th>Transacción</th> <th>RFC</th><th>Declarado</th> <th>Entidad</th> <th>Tramite</th><th>Contribuyente</th>  <th>Inicio Tramite</th> <th>Banco</th> <th>Tipo Pago</th><th>Total Tamite</th></tr> </thead><tbody> <tr><td>Espere Cargando...</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr> </tbody></table></div>");
    }
     function Addtable1()
    {
        //$("#table_2").remove();
        $("#table_1").remove();
        $("#addTable_1").append("<div class='portlet-body' id='table_1'><table class='table table-hover' id='sample_3'><thead>  <tr><th>Estatus</th><th>Transacción</th> <th>RFC</th> <th>Entidad</th> <th>Tramite</th><th>Contribuyente</th>  <th>Inicio Tramite</th> <th>Banco</th> <th>Tipo Pago</th><th>Total Tamite</th></tr> </thead><tbody> <tr><td>Espere Cargando...</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr> </tbody></table></div>");
    }
    function limpiar()
    {
        
    }
    function consultaOper(fechaIn,fechaF) {
        Addtable1();
        document.getElementById("blockui_sample_3_1").click();
         var status=$("#itemsStatus").val();
        var servicio=$("#itemsTipoServicio").val();
        var entidad_=$("#itemsEntidad").val();
        var rfc_=$("#rfc").val();
        $.ajax({
        method: "post",            
        url: "{{ url('/consulta-transacciones-oper') }}",
        data: {rfc:rfc_,tipo_servicio:servicio,estatus:status,entidad:entidad_,fecha_inicio:fechaIn,fecha_fin:fechaF,_token:'{{ csrf_token() }}'}  })
        .done(function (response) { 
        $("#sample_3 tbody tr").remove();   
        var Resp=$.parseJSON(response);
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
                +"</tr>");
        }else{
        $.each(Resp, function(i, item) { 
             $("#sample_3 tbody").append("<tr>"
                +"<td>"+item.Estatus+"</td>"
                +"<td><a href='#large' data-toggle='modal'>"+item.Transaccion+"</a></td>"
                +"<td>"+item.RFC+"</td>"
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
       TableManaged3.init3();
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
    function consultaOperChange(fechaIn,fechaF) {
        Addtable1();
        document.getElementById("blockui_sample_3_1").click();
         var status=$("#itemsStatus").val();
        var entidad_=$("#itemsEntidad").val();
        var servicio=$("#itemsTipoServicio").val();
        var rfc_=$("#rfc").val();

        $.ajax({
        method: "post",            
        url: "{{ url('/consulta-transacciones-oper') }}",
        data: {rfc:rfc_,tipo_servicio:servicio,estatus:status,entidad:entidad_,fecha_inicio:fechaIn,fecha_fin:fechaF,_token:'{{ csrf_token() }}'}  })
        .done(function (response) { 
        $("#sample_3 tbody tr").remove();   
        var Resp=$.parseJSON(response);
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
                +"</tr>");
        }else{
        $.each(Resp, function(i, item) { 
             $("#sample_3 tbody").append("<tr>"
                +"<td>"+item.Estatus+"</td>"
                +"<td><a href='#large' data-toggle='modal'>"+item.Transaccion+"</a></td>"
                +"<td>"+item.RFC+"</td>"
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
       TableManaged3.init3();
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
    
</script>
@endsection