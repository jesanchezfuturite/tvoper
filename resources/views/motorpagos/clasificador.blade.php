@extends('layout.app')
@section('content')
<h3 class="page-title">Motor de pagos <small>Configuración Clasificador</small></h3>
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
            <a href="#">Configuración Clasificador</a>
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
                <i class="fa fa-cogs"></i>Registros Clasificador
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
                    <th>
                        Descripcíon
                    </th>
                    <th>
                        Entidad
                    </th>                                       
                    <th>
                        &nbsp;
                    </th>
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
                <h4 class="modal-title">Registro Clasificador</h4>
            </div>
            <div class="modal-body">
                <div class="form-body">
                <input hidden="true" type="text"  id="idupdate">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Descripcion Clasificador</label>
                            <div class="col-md-8">
                                <input type="text" autocomplete="off" class="form-control" placeholder="Ingresa la Descripcion del Clasificador" id="descripcion">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">                    
                        <div class="form-group">
                            <label class="col-md-3 control-label">Entidad</label>
                            <div class="col-md-8">
                                <select id="entidad" class="select2me form-control" >
                                  <option value="limpia">-------</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">            
                        <div class="form-group">
                            <button type="submit" class="btn blue" onclick="saveUpdateclasificador()"><i class="fa fa-check"></i> Guardar</button>
                        </div>
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
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminaclasificador()">Confirmar</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {
        clasificadorFindAll();
        EntidadFindAll();
       UIBlockUI.init();        
    });    
    function limpiar()
    {
        document.getElementById('idupdate').value="";
        document.getElementById('iddeleted').value="";
        document.getElementById('descripcion').value="";
        $("#entidad").val("limpia").change();
    }
    function saveUpdateclasificador()
    {
        var Registro=$("#idupdate").val();
        var identidad_=$("#entidad").val();
        var descripcion_=$("#descripcion").val();
        if(descripcion_.length==0)
        {
            Command: toastr.warning("Clasificador, Requerido!", "Notifications")
        }else if(identidad_=="limpia"){
            Command: toastr.warning("Entidad Sin Seleccionar, Requerido!", "Notifications")            
        }else{  
            if(Registro.length==0)
            {
                clasificadorInsert();
            }else{
                clasificadorActualiza();
            }
        }

    }
    function clasificadorInsert()
    {
        var identidad_=$("#entidad").val();
        var descripcion_=$("#descripcion").val();
        $.ajax({
        method: "post",            
        url: "{{ url('/clasificador-insert') }}",
        data: {identidad:identidad_,descripcion:descripcion_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        if(responseinfo=="true")
        {
            Command: toastr.success("Success", "Notifications")
            clasificadorFindAll();
            limpiar();
        }else{
            Command: toastr.warning("La partida ya Existe", "Notifications") 
        }
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Insertar la partida", "Notifications")   });
    }
    function eliminaclasificador()
    {
        var iddeleted=$("#iddeleted").val();
        $.ajax({
        method: "post",            
        url: "{{ url('/clasificador-deleted') }}",
        data: {id:iddeleted,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        if(responseinfo=="true")
        {
            Command: toastr.success("Success", "Notifications")
            clasificadorFindAll();

        }else{
            Command: toastr.warning("Error al eliminar la partida!", "Notifications") 
        }
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al eliminar la partida!", "Notifications")   });
    }

    function clasificadorUpdate(id_)
    {
        document.getElementById('idupdate').value=id_;
       
        $.ajax({
        method: "post",            
        url: "{{ url('/clasificador-find-where') }}",
        data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);          
        $.each(Resp, function(i, item) { 
        document.getElementById('descripcion').value=item.descripcion;
         $("#entidad").val(item.entidad_id).change();
        });
       
        })
        .fail(function( msg ) {
         Command: toastr.warning("Registro No Encontrado", "Notifications")  });

    }
    function clasificadorActualiza()
    {
         var id_=$("#idupdate").val();
        var identidad_=$("#entidad").val();
        var descripcion_=$("#descripcion").val();
        $.ajax({
        method: "post",            
        url: "{{ url('/clasificador-update') }}",
        data: {id:id_,identidad:identidad_,descripcion:descripcion_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
            if(responseinfo=="true")
            {
                Command: toastr.success("Success", "Notifications")
                clasificadorFindAll();
                limpiar();
            }else{
                Command: toastr.warning("Error al Actualizar la partida", "Notifications") 
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Actualizar", "Notifications")   });
    }
    function clasificadorDeleted(id_)
    {
        document.getElementById('iddeleted').value=id_;
    }
    function cargarTablaclasificador()
    {
         $("#sample_2 tbody tr").remove();
          $("#sample_2 tbody").append("<tr><th>Espere Cargando...</th></tr>");
         clasificadorFindAll();
    }
    function clasificadorFindAll()
    {
        $.ajax({
           method: "get",           
           url: "{{ url('/clasificador-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          var Resp=$.parseJSON(response);
           $("#Removetable").remove();
         $('#Addtable').append(
            "<div class='portlet-body' id='Removetable'> <div class='form-group'> <div class='col-md-6'> <button class='btn green' href='#portlet-config' data-toggle='modal' >Agregar</button> </div></div><div class='form-group'> <div class='col-md-6 text-right'><button class='btn blue' onclick='GuardarExcel()'><i class='fa fa-file-excel-o'></i> Descargar CSV</button> </div> </div><span class='help-block'>&nbsp; </span><table class='table table-hover' id='sample_2'><thead><tr> <th> Clasificador</th><th>Entidad</th>   <th> &nbsp; </th> </tr> </thead> <tbody></tbody> </table> </div>"
        );
        $.each(Resp, function(i, item) {                
            $('#sample_2 tbody').append("<tr>"
                +"<td>"+item.descripcion+"</td>"
                +"<td>"+item.entidad+"</td>"
                + "<td class='text-center' width='20%'><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='portlet-config' onclick='clasificadorUpdate("+item.id+")'><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only red' data-toggle='modal' href='#static' onclick='clasificadorDeleted("+item.id+")'><i class='fa fa-minus'></i></a></td>"
                +"</tr>"
                );
            });
        TableManaged.init();
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Tabla Partidas");  });
    }
    function EntidadFindAll()
    {
        $.ajax({
        method: "get",            
        url: "{{ url('/entidad-find') }}",
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);
          var item="";
          $("#entidad option").remove();
          $("#entidad").append("<option value='limpia'>-------</option>");
        $.each(Resp, function(i, item) {                
              $("#entidad").append("<option value='"+item.id+"'>"+item.nombre+"</option>");
            
        });
       
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }

function GuardarExcel()
{
 
    document.getElementById("blockui_sample_3_1").click();
     $.ajax({
           method: "GET",            
           url: "{{ url('/clasificador-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            //console.log(responseTipoServicio);
            if(response=="[]")
            { 
              Command: toastr.warning("Sin Registros!", "Notifications")
              document.getElementById("blockui_sample_3_1_1").click();

            }else{
              //var Resp=$.parseJSON(responseTipoServicio);  
               var Entidad="Clasificador";        
               JSONToCSVConvertor(response, Entidad, true);
               
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications") 
         document.getElementById("blockui_sample_3_1_1").click(); }); 
 
     
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