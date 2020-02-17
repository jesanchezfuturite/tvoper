@extends('layout.app')
@section('content')
<h3 class="page-title">Motor de pagos <small>Configuración UMA</small></h3>
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
            <a href="#">Configuración UMA</a>
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
                <i class="fa fa-cogs"></i>Registros UMA
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
                    <th>Valor Diario</th> 
                    <th>Valor Mensual</th>                                       
                    <th>Valor Anual</th>                                       
                    <th>Fecha Inicio</th>                                       
                    <th>Fecha Fin</th>                                       
                    <th>&nbsp;</th>
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
    </div>
    <!-- END SAMPLE TABLE PORTLET-->    

</div>
<div class="modal fade bs-modal-lg" id="portlet-config" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Agregar</h4>
            </div>
            <div class="modal-body">
                         <input hidden="true" type="text"  id="idupdate">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label >Año</label>                            
                                <input id="anio" class="valida-num form-control" maxlength="4"  autocomplete="off" placeholder="Ingresar Año">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label>Valor Diario</label>                            
                                <input id="Vdiario" class="valida-decimal form-control"   autocomplete="off" placeholder="Ingresar Valor Diario">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12"> 
                        <div class="col-md-6">
                            <div class="form-group">
                            <label >Valor Mensual</label>
                                <input id="Vmensual" class="valida-decimal form-control"   autocomplete="off" placeholder="Ingresar Valor Mensual">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label >Valor Anual</label>
                                <input id="Vanual" class="valida-decimal form-control"   autocomplete="off" placeholder="Ingresar Valor Anual">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12"> 
                        <div class=' date-picker input-daterange' data-date-format='yyyy-mm-dd'>
                            <div class="form-group">    
                                <div class='col-md-6'>
                                    <div class="form-group">
                                        <label >Fecha Inicio </label>
                                        <input type='text' class='form-control' name='from' id='fechainicio' autocomplete='off'> 
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class="form-group">
                                        <label>Fecha Fin </label>
                                        <input type='text' class='form-control' name='to'id='fechafin' autocomplete='off'>
                                </div>                                
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
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
            <button type="button" data-dismiss="modal" class="btn green" onclick="umaeliminar()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {
             umaCargartabla();
             ComponentsPickers.init();
    });    
    function limpiar()
    {
        document.getElementById('anio').value="";
        document.getElementById('Vdiario').value="";
        document.getElementById('Vmensual').value="";
        document.getElementById('Vanual').value=""; 
        //document.getElementById('fechafin').value=""; 
        //document.getElementById('fechainicio').value=""; 
        document.getElementById('iddeleted').value=""; 
        document.getElementById('idupdate').value=""; 
        $('#fechafin').datepicker('setDate',null );
        $('#fechainicio').datepicker('setDate',null );
    }
    function addTable()
    {
        $('#Addtable').append(
            "<div class='portlet-body' id='Removetable'> <div class='form-group'> <div class='col-md-6'> <button class='btn green' href='#portlet-config' data-toggle='modal' >Agregar</button> </div></div><div class='form-group'> <div class='col-md-6 text-right'><button class='btn blue' onclick='GuardarExcel()'><i class='fa fa-file-excel-o'></i> Descargar CSV</button> </div> </div><span class='help-block'>&nbsp; </span><table class='table table-hover' id='sample_2'><thead><tr> <th>Año</th><th>Valor Diario</th><th>Valor Mensual</th><th>Valor Anual</th><th>Fecha Inicio</th><th>Fecha Fin</th><th> &nbsp; </th> </tr> </thead> <tbody><tr><td><p>Cargando...<p></td></tr></tbody> </table> </div>"
        );
    }
    function umaCargartabla()
    {
        $.ajax({
           method: "get",           
           url: "{{ url('/uma-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        document.getElementById('jsonCode').value=response;            
          var Resp=$.parseJSON(response);
           $("#Removetable").remove();
         addTable();
         $('#sample_2 tbody tr').remove();
        $.each(Resp, function(i, item) {                
            $('#sample_2 tbody').append("<tr>"
                +"<td>"+item.year+"</td>"
                +"<td>"+item.dia+"</td>"
                +"<td>"+item.mes+"</td>"
                +"<td>"+item.anio+"</td>"
                +"<td>"+item.fecha_inicio+"</td>"
                +"<td>"+item.fecha_fin+"</td>"
                + "<td class='text-center' width='20%'><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='portlet-config' onclick='umaUpdate("+item.id+")'><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only red' data-toggle='modal' href='#static' onclick='umaDeleted("+item.id+")'><i class='fa fa-minus'></i></a></td>"
                +"</tr>"
                );
            });
        TableManaged.init();
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Tabla Partidas");  });
    }
    function umaInsert()
    {
        var year_=$("#anio").val();
        var dia_=$("#Vdiario").val();
        var mes_=$("#Vmensual").val();
        var anio_=$("#Vanual").val();        
        var fechafin=$("#fechafin").val();
        var fechainicio=$("#fechainicio").val();
         $.ajax({
           method: "post",           
           url: "{{ url('/uma-insert') }}",
           data: {year:year_,dia:dia_,mes:mes_,anio:anio_,fecha_inicio:fechainicio,fecha_fin:fechafin,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {

          if(response=="true"){
            Command: toastr.success("Success", "Notifications")
            umaCargartabla();
            limpiar();
          }else{
            Command: toastr.warning("Error al Guardar", "Notifications")
          }
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Tabla Partidas");  });
    }
    function umaActualizar()
    {
        var id_=$("#idupdate").val();        
        var year_=$("#anio").val();
        var dia_=$("#Vdiario").val();
        var mes_=$("#Vmensual").val();
        var anio_=$("#Vanual").val        
        var fechafin=$("#fechafin").val();
        var fechainicio=$("#fechainicio").val();
         $.ajax({
           method: "post",           
           url: "{{ url('/uma-update') }}",
           data: {id:id_,year:year_,dia:dia_,mes:mes_,anio:anio_,fecha_inicio:fechainicio,fecha_fin:fechafin,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          if(response=="true")
            {
                Command: toastr.success("Success", "Notifications")
                umaCargartabla();
            }else{
                Command: toastr.warning("Error al Actualizar", "Notifications")
            }
            limpiar();
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Tabla Partidas");  });
    }
    function umaUpdate(id_)
    {
        document.getElementById('idupdate').value=id_;
        $.ajax({
           method: "post",           
           url: "{{ url('/uma-find-where') }}",
           data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          var Resp=$.parseJSON(response);
          
            $.each(Resp, function(i, item) {                
                document.getElementById('anio').value=item.year;
                document.getElementById('Vdiario').value=item.dia;
                document.getElementById('Vmensual').value=item.mes;
                document.getElementById('Vanual').value=item.anio;
                //document.getElementById('fechainicio').value=item.fecha_inicio;
                //document.getElementById('fechafin').value=item.fecha_fin;
                 $('#fechainicio').datepicker('setDate',item.fecha_inicio ); 
                 $('#fechafin').datepicker('setDate',item.fecha_fin );
               
            });
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Tabla Partidas");  });
    } 
    function VerificaInsert()
    {        
        var id_=$("#idupdate").val();
        var year_=$("#anio").val();
        var dia_=$("#Vdiario").val();
        var mes_=$("#Vmensual").val();
        var anio_=$("#Vanual").val();
        var fechafin=$("#fechafin").val();
        var fechainicio=$("#fechainicio").val();
        if(anio_.length==0)
        {
            Command: toastr.warning("Campo Valor Anual, Requerido!", "Notifications")

        }else if(mes_.length==0)
        {
            Command: toastr.warning("Campo Valor Mensual, Requerido!", "Notifications")

        }else if(dia_.length==0)
        {
            Command: toastr.warning("Campo Valor Diario, Requerido!", "Notifications")

        }else if(year_.length>4)
        {
            Command: toastr.warning("Campo Año, Requerido!", "Notifications")

        }else if(fechainicio.length==0)
        {
            Command: toastr.warning("Campo Fecha Inicio, Requerido!", "Notifications")

        }else if(fechafin.length==0)
        {
            Command: toastr.warning("Campo Fecha Fin, Requerido!", "Notifications")

        }else{
            if(id_.length==0)
            {
                umaInsert();
            }else{
                umaActualizar();
            }
        }

    }
    function umaDeleted(id_)
    {
        document.getElementById('iddeleted').value=id_;

    }
    function umaeliminar()
    {
        var id_=$("#iddeleted").val();
         $.ajax({
           method: "post",           
           url: "{{ url('/uma-deleted') }}",
           data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          if(response=="true")
            {
                Command: toastr.success("Success", "Notifications")
                umaCargartabla();
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
        JSONToCSVConvertor(JSONData, "UMA", true)
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