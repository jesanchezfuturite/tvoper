@extends('layout.app')
@section('content')

<h3 class="page-title">Portal <small>Configuración de campos para trámites </small></h3>
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
            <a href="#">Configuración de campos para trámites</a>
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
                <i class="fa fa-cogs"></i>Campos para trámites
            </div>
        </div>
        <div class="portlet-body" id="Removetable">           
            
            <div class="form-group"> 
                <div class="col-md-12">              
                <button class="btn green" href='#portlet-config' data-toggle='modal' >Agregar</button>
                <span class="help-block">&nbsp; </span>
                </div>
            </div>
            
            
            <table class="table table-hover" id="sample_2">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Estatus</th>                                      
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $data as $tramite)
                        <tr>                           
                            <td>                              
                                {{$tramite["campo"]}}                               
                            </td>
                            <td >  
                                @if( $tramite["estatus"] == 1 )
                                   Activo
                                @else
                                    Inactivo
                                @endif
                            </td>
                            <td class='text-center' width='20%'>
                                @if( $tramite["estatus"] == 1   )
                                    <a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='portlet-config' onclick='update( {{ json_encode($tramite) }} )'>
                                    <i class='fa fa-pencil'></i>
                                    </a>                              
                                    <a class='btn btn-icon-only red' data-toggle='modal' href='#static' onclick='deleted( {{ json_encode($tramite) }} )'>
                                        <i class='fa fa-minus'></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach                                                              
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
                 
                <div class="form-body">
                    <input hidden="true" type="text"  id="idupdate">
                    <input hidden="true" type="text"  id="estatus">
                    <div class="row">
                        <div class="col-md-12">                        
                           <div class="form-group">
                                <label class="col-md-3 control-label ">Nombre</label>
                                <div class="col-md-8">
                                    <input id="nombre" class="valida-num form-control" autocomplete="off" placeholder="Ingresar Nombre">
                                </div>
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
                 <input hidden="true" type="text" name="iddeleted" id="iddeleted" class="iddeleted">
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminar()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="portlet-tramites" tabindex="-1" data-backdrop="static" role="dialog" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Campos en uso por Tramites</h4>
            </div>
            <div class="modal-body" style="height:360px  !important;overflow-y:scroll;overflow-y:auto;">                 
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12">                      
                           <table id="tblTramites" class="table table-hover" >
                            <thead>
                                <tr>
                                    <th>Tramites</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    <br>                
            </div>
            <div class="modal-footer">
                <button class="btn blue" onclick="GuardarExcel()"><i class="fa fa-file-excel-o"></i> Descargar CSV</button>
                 <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
@endsection
@section('scripts')

<script type="text/javascript">

    jQuery(document).ready(function() {
        TableAdvanced.init();
    });

    function limpiar()
    {
        document.getElementById('nombre').value="";
        document.getElementById('idupdate').value="";
        document.getElementById('estatus').value="";
    }

    function VerificaInsert()
    {
        var nombre=$("#nombre").val();
        var id_=$("#idupdate").val();
        if(nombre.length<1)
        {
            Command: toastr.warning("Campo Nombre, Requerido!", "Notifications")
        } else {
            id_.length == 0 ? insert() : actualizar();
        }

    }

    function insert()
    {
        var campo =$("#nombre").val();

         $.ajax({
           method: "post",           
           url: "{{ url('/tramites-add-field') }}",
           data: {campo ,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          if(response.Code =="200"){
            Command: toastr.success(response.Message, "Notifications")
            limpiar();
            location.reload();
          }else{
            Command: toastr.warning(response.Message, "Notifications")
          }
        })
        .fail(function( msg ) {
            console.log("Error al Cargar Tabla");  
        });
    }

    function actualizar( ){
        var campo =$("#nombre").val();
        var id_= $("#idupdate").val();
        var status = $('#estatus').val( );
        $.ajax({
           method: "post",           
           url: "{{ url('/tramites-edit-field') }}",
           data: {campo, id_campo: id_, status ,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          if(response.Code =="200"){
            Command: toastr.success(response.Message, "Notifications")
            limpiar();
            location.reload();
          }else{
            Command: toastr.warning(response.Message, "Notifications")
          }
        })
        .fail(function( msg ) {
            console.log("Error al Cargar Tabla");  
        });     
    }

    function update( tramite )
    {
        $("#nombre").val( tramite.campo );
        $('#idupdate').val( tramite.id_campo );
        $('#estatus').val( tramite.estatus );
    } 

    function deleted( tramite ){
        $("#nombre").val( tramite.campo );
        $('#idupdate').val( tramite.id_campo );
        $('#estatus').val( tramite.estatus );  
    }

    function eliminar(){
        var campo =$("#nombre").val();
        var id_= $("#idupdate").val();
        var status = 0;
        $.ajax({
           method: "post",           
           url: "{{ url('/tramites-estatus') }}",
           data: {campo, id_campo: id_, status ,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          if(response.Code =="200"){
            Command: toastr.success(response.Message, "Notifications")
            limpiar();
            location.reload();
          }else{
            console.log(campo);
            document.getElementById("jsonCode").value=response.response;
            var n=$.parseJSON(response.response);
            $("#tblTramites tbody").empty();
            $.each(n, function(i, item) {
                $("#tblTramites tbody").append("<tr>"
                    +"<td>"+item.nombre+"</td>"
                    +"</tr>");
            });
            Command: toastr.warning(response.Message, "Notifications")
            $('#portlet-tramites').modal('show');
          }
        })
        .fail(function( msg ) {
            console.log("Error al Cargar Tabla");  
        }); 
    }
    function GuardarExcel()
    {
        var campo =$("#nombre").val();
        var JSONData=$("#jsonCode").val();
        JSONToCSVConvertor(JSONData, "Campo "+campo, true)
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