@extends('layout.app')
@section('content')
<h3 class="page-title">Motor de pagos <small>Configuración Familia</small></h3>
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
            <a href="#">Configuración Familia</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Agregar Familia
            </div>
        </div>
        <div class="portlet-body">
        <div class="form-body">
        <div class="row">
            <div class="col-md-2 col-ms-12">
                <div class="form-group">
                    <label class="sr-only" for="nombreFamilia">Nueva Familia</label>
                    <input type="text" class="form-control" id="nombreFamilia"name="nombreFamilia" autocomplete="off"placeholder="Nueva Familia">
                </div>
            </div>
             <div class="col-md-1 col-ms-12">
                    <div class="form-group">
                    <button type="button" class="btn green" onclick="SaveFamilia()">Agregar</button>
                    </div>
            </div>
            <div class="col-md-3 col-ms-12">
                <div class="form-group">
                    <label >Familia Registradas (Selecciona para ver las Entidades)</label>   
                  </div>
            </div>
            <div class="col-md-3 col-ms-12">
                <div class="form-group">           
                        <select class="select2me form-control"name="items" id="itemsFamilia" onchange="changeItemsFamilia()">
                           <option value="limpia">------</option>
                            @foreach( $familia as $sd)
                            <option value='{{$sd["id"]}}'>{{$sd["nombre"]}}</option>
                            @endforeach
                           
                        </select>            
                </div>
            </div>
            <div id="editfamilia" class="col-md-1 col-ms-12" hidden="true">
                <div class="form-group" >
                  <button type="button" class="btn green tooltips" onclick="editFamilia()"  data-container="body" data-placement="top" data-original-title="Editar Nombre Familia" data-toggle='modal' href='#modfamilia'><i class='fa fa-pencil'></i></button>  
                </div>
            </div>
            </div> 
            </div>
        </div>
    </div>
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
                <i class="fa fa-cogs"></i>Registros Familia
            </div>
        </div>
        <div class="portlet-body" >
        <div class="row">           
            <div class="col-md-2">              
                <div class="form-group">                 
                <button class="btn green" href='#portlet-config' data-toggle='modal' >Agregar</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">                             
                <button class="btn green" href='#modentidad' data-toggle='modal' >Nueva Entidad</button>
                </div>
            </div>
            <div class="col-md-6 text-right">
                <div class="form-group">
                             
                <button class="btn blue" onclick="GuardarExcel()"><i class="fa fa-file-excel-o"></i> Descargar CSV</button>
              </div>
            </div>
        </div>
            <span class="help-block">&nbsp; </span>
            <div class="portlet-body" id="Removetable">
                <table class="table table-hover" id="sample_2">
                <thead>
                <tr>
                    <th>
                        Familia
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
    </div>
    <!-- END SAMPLE TABLE PORTLET-->    

</div>
<div class="modal fade" id="portlet-config" tabindex="-1" data-backdrop="static" role="dialog" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Agregar Entidad</h4>
            </div>
            <div class="modal-body">
                <div class="form-body">
                         <input hidden="true" type="text"  id="idupdate">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Entidad</label>
                            <div class="col-md-8">
                                <select id="entidad" class="select2me form-control" >
                                  <option value="limpia">-------</option>
                                </select>
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
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminarFamiliaEntidad()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<div id="modfamilia" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiarfamilia()"></button>
                <h4 class="modal-title">Nombre Familia</h4>
            </div>
            <div class="modal-body">
                <br>
                <br>

                <div class="row">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="upFamilia">Familia:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="upFamilia"name="upFamilia" autocomplete="off"placeholder="Familia...">
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="form-group">
                    <div class="col-md-12">                    
                            <button type="submit" class="btn blue" onclick="updateFamilia()"><i class="fa fa-check"></i> Guardar</button>
                        </div>
                    </div>
                </div>
                <br>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn default" onclick="limpiarfamilia()">Cerrar</button>
                </div>
            </div>

        </div>
    </div>
</div>
<div id="modentidad" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiarNewEntidad()"></button>
                <h4 class="modal-title">Nueva Entidad</h4>
            </div>
            <div class="modal-body">
                <br>
                <br>

                <div class="row">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="newEntidad">Entidad:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="newEntidad"name="newEntidad" autocomplete="off"placeholder="Nueva Entidad...">
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="form-group">
                    <div class="col-md-12">                    
                            <button type="submit" class="btn blue" onclick="insertNewEntidad()"><i class="fa fa-check"></i> Guardar</button>
                        </div>
                    </div>
                </div>
                <br>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn default" onclick="limpiarNewEntidad()">Cerrar</button>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {
       EntidadFindAll(); 
       familiaEntidadFindAll();
        
       UIBlockUI.init();        
    });
    function limpiarNewEntidad()
    {
        document.getElementById("newEntidad").value="";
    }
    function insertNewEntidad()
    {
        var validaentidad=$("#newEntidad").val();
        $.ajax({
           method: "get",            
           url: "{{ url('/entidad-find') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
            var Resp=$.parseJSON(responseinfo); 
            var coincidencia=0;    
            var entidad_="";    
            $.each(Resp, function(i, item) {                
                entidad_=item.nombre;
                if(validaentidad.toLowerCase()==entidad_.toLowerCase()){
                    coincidencia=coincidencia+1;
                }
            });
            if(coincidencia==0){
                insertEntidad();
            }else{
                Command: toastr.warning("La Entidad Ya Se Encuentra Registrado!", "Notifications")
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }

    function insertEntidad()
    {   
        var validaentidad=$("#newEntidad").val();
        if(validaentidad.length==0)
            {
                Command: toastr.warning("Entidad Requerido!", "Notifications")
            }else{
                $.ajax({
                method: "POST",            
                url: "{{ url('/entidad-insert') }}",
                data: {nombre:validaentidad,_token:'{{ csrf_token() }}'}  })
                .done(function (response) {
                    if(response=="true"){
                    EntidadFindAll();
                    Command: toastr.success("Success", "Notifications")
                    }   else{
                Command: toastr.warning("No Success", "Notifications") 
            }

            limpiarNewEntidad();
            
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        }
            return false;
    }
    function limpiarfamilia()
    {
        document.getElementById("upFamilia").value="";
    }
    function editFamilia()
    {
        var id_=$("#itemsFamilia").val();
        $.ajax({
        method: "post",            
        url: "{{ url('/familia-find-where') }}",
        data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
            var Resp=$.parseJSON(response);            
            $.each(Resp, function(i, item) {                
                 document.getElementById("upFamilia").value=item.nombre;
            });            
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Insertar la Familia", "Notifications")   });
    }
    function updateFamilia()
    {
        var id_=$("#itemsFamilia").val();
        var familia_=$("#upFamilia").val();
        if(familia_.length>1){
        $.ajax({
        method: "post",            
        url: "{{ url('/familia-update') }}",
        data: {id:id_,familia:familia_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
           if(response=="true"){
                Command: toastr.success("Actualizado Correctamente!", "Notifications")
                 selectItemsFamilia2(id_);
           }else{
            Command: toastr.warning("Error al Actualizar la Familia", "Notifications")
           }
            
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Actualizar la Familia", "Notifications")   });
        }else{
            Command: toastr.warning("La Campo Nombre, Requerido!", "Notifications")         
        }
    }
     function selectItemsFamilia2(id_)
    {
        $.ajax({
        method: "get",            
        url: "{{ url('/familia-find-all') }}",
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
            $("#itemsFamilia option").remove();
            var Resp=$.parseJSON(response);
            $('#itemsFamilia').append(
                "<option value='limpia'>------</option>"
            );
            $.each(Resp, function(i, item) {                
                 $('#itemsFamilia').append(
                "<option value='"+item.id+"'>"+item.nombre+"</option>"
                   );
                });
            $("#itemsFamilia").val(id_).change();
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Cargar Select", "Notifications")   });
    }
    function limpiar()
    {
        document.getElementById('idupdate').value="";
        document.getElementById('iddeleted').value="";
        $("#entidad").val("limpia").change();
    }
    function SaveFamilia()
    {

        var nombre_ =$("#nombreFamilia").val();
        if(nombre_.length>1){
        $.ajax({
        method: "post",            
        url: "{{ url('/familia-insert') }}",
        data: {nombre:nombre_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        if(responseinfo=="true")
        {
            Command: toastr.success("Success", "Notifications")
            selectItemsFamilia();
            
        }else{
            Command: toastr.warning("La Familia ya Existe", "Notifications") 
        }
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Insertar la Familia", "Notifications")   });
    }else{
            Command: toastr.warning("La Campo Nombre, Requerido!", "Notifications")         
    }

    }
    function selectItemsFamilia()
    {
        $.ajax({
        method: "get",            
        url: "{{ url('/familia-find-all') }}",
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
            $("#itemsFamilia option").remove();
            var Resp=$.parseJSON(response);
            $('#itemsFamilia').append(
                "<option value='limpia'>------</option>"
            );
            $.each(Resp, function(i, item) {                
                 $('#itemsFamilia').append(
                "<option value='"+item.id+"'>"+item.nombre+"</option>"
                   );
                });
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Cargar Select", "Notifications")   });
    }
   
    function changeItemsFamilia()
    {
         var id=$("#itemsFamilia").val();
         if(id=="limpia")
            {
                Command: toastr.warning("Familia No Seleccionada.", "Notifications")
                $("#Removetable").remove();
                 $("#editfamilia").css("display","none");
                addTable();               
            }else{
                $("#editfamilia").css("display","block");
            familiaEntidadFindAll();
        }
    }
    function familiaEntidadFindAll()
    {
        var id=$("#itemsFamilia").val();
        $.ajax({
           method: "post",           
           url: "{{ url('/familiaentidad-find') }}",
           data: {familia_id:id,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          var Resp=$.parseJSON(response);
         addTable();
        $.each(Resp, function(i, item) {                
            $('#sample_2 tbody').append("<tr>"
                +"<td>"+item.familia+"</td>"
                +"<td>"+item.entidad+"</td>"
                + "<td class='text-center' width='20%'><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='portlet-config' onclick='familiaentidadUpdate("+item.id+","+item.entidad_id+")'><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only red' data-toggle='modal' href='#static' onclick='familiaentidadDeleted("+item.id+")'><i class='fa fa-minus'></i></a></td>"
                +"</tr>"
                );
            });
        TableManaged.init();
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Tabla Partidas");  });
    }
    function addTable()
    {
        $("#Removetable").remove();
        $('#Addtable').append(
            "<div class='portlet-body' id='Removetable'><table class='table table-hover' id='sample_2'><thead><tr> <th> Familia</th><th>Entidad</th>   <th> &nbsp; </th> </tr> </thead> <tbody></tbody> </table> </div>"
        );
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
    function VerificaInsert()
    {
        var id_=$("#idupdate").val();
        if(id_.length==0)
        {
            saveFamiliaEntidad();
        }else{
            actualizaFamiliEntidad();
        }
    }
    function saveFamiliaEntidad()
    {
        var id_familia=$("#itemsFamilia").val();
        var id_entidad=$("#entidad").val();
        if(id_familia=="limpia")
        {
            Command: toastr.warning("Familia Sin Seleccionar, Requerido!", "Notifications")
        }else if(id_entidad=="limpia")
        {
            Command: toastr.warning("Entidad Sin Seleccionar, Requerido!", "Notifications")
        }else{
            insertFamiliaEntidad();
        }
    }
    function insertFamiliaEntidad()
    {
        var id_familia=$("#itemsFamilia").val();
        var id_entidad=$("#entidad").val();
         $.ajax({
        method: "post",            
        url: "{{ url('/familiaentidad-insert') }}",
        data: {familia_id:id_familia,entidad_id:id_entidad,_token:'{{ csrf_token() }}'}  })
        .done(function (response) { 
            if(response=="true")
                {
                    Command: toastr.success("Success", "Notifications")
                    changeItemsFamilia();
                    limpiar();

                }else{
                    Command: toastr.warning("Ya Existe Una Entidad a La Familia", "Notifications")
                }
       
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }

    function GuardarExcel()
    {
 
    document.getElementById("blockui_sample_3_1").click();
     var id=$("#itemsFamilia").val();
        $.ajax({
           method: "post",           
           url: "{{ url('/familiaentidad-find') }}",
           data: {familia_id:id,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            //console.log(responseTipoServicio);
            if(response=="[]")
            { 
              Command: toastr.warning("Sin Registros!", "Notifications")
              document.getElementById("blockui_sample_3_1_1").click();

            }else{
              //var Resp=$.parseJSON(responseTipoServicio);  
               var Familia="Familia";        
               JSONToCSVConvertor(response, Familia, true);
               
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications") 
         document.getElementById("blockui_sample_3_1_1").click(); }); 
 
     
}
function familiaentidadUpdate($id,$id_entidad) {
    $("#entidad").val($id_entidad).change();
    document.getElementById('idupdate').value=$id;
}
function actualizaFamiliEntidad() {
    var id_entidad=$("#entidad").val();
    var id_familia=$("#itemsFamilia").val();
    var id_=$("#idupdate").val();
     $.ajax({
        method: "post",            
        url: "{{ url('/familiaentidad-update') }}",
        data: {id:id_,familia_id:id_familia,entidad_id:id_entidad,_token:'{{ csrf_token() }}'}  })
        .done(function (response) { 
            if(response=="true")
                {
                    Command: toastr.success("Success", "Notifications")
                    changeItemsFamilia();
                    limpiar();
                }else{
                    Command: toastr.warning("Ya Existe Una Entidad a La Familia", "Notifications")
                }
       
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });

}
function familiaentidadDeleted($id) {
    document.getElementById('iddeleted').value=$id;
    
}
function eliminarFamiliaEntidad()
{
    var id_=$("#iddeleted").val();
     $.ajax({
        method: "post",            
        url: "{{ url('/familiaentidad-deleted') }}",
        data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) { 
            if(response=="true")
                {
                    Command: toastr.success("Success", "Notifications")
                    changeItemsFamilia();
                    limpiar();
                }else{
                    Command: toastr.warning("Ya Existe Una Entidad a La Familia", "Notifications")
                }
       
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });

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