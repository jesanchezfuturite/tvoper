@extends('layout.app')


@section('content')
<link href="assets/global/css/checkbox.css" rel="stylesheet" type="text/css"/>
<h3 class="page-title">Portal <small>Configuración Roles</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="#">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Portal</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Configuración Roles</a>
        </li>
    </ul>
</div>
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Info: </strong>Esta configuración te permite dar...
</div>
<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Agregar Roles
            </div>
            <div class="tools">                
              <a href="#portlet-notario" data-toggle="modal" class="config" data-original-title="" title="Crear Nuevo"></a>
              <a id="Remov" href="javascript:;" data-original-title="" title="">
                <i class='fa fa-remove' style="color:#d7eaf8 !important;"></i>
              </a>
            </div>
        </div>
        <div class="portlet-body">
        <div class="row">            
            <div class="col-md-3 col-ms-12">
                <div class="form-group">
                    <label >Roles Registrados </label>  
                    <span class="help-block">(Selecciona para ver los Roles)</span> 
                  </div>
            </div>
            <div class="col-md-3 col-ms-12">
                <div class="form-group">           
                  <select class="select2me form-control"name="itemsRoles" id="itemsRoles" onchange="changeRol()">
                    <option value="0">------</option>
                    @foreach( $roles as $sd)
                        <option value="{{$sd['id']}}">{{$sd["descripcion"]}}</option>
                      @endforeach     
                  </select>            
                </div>
            </div>           
          </div>
        </div>
    </div>
</div>
<div class="row">
 <!-- BEGIN SAMPLE TABLE PORTLET-->
  <div class="portlet box blue">
    <div class="portlet-title" >
      <div class="caption">
          <div id="borraheader">  <i class="fa fa-cogs"> </i>&nbsp;Configuracion Tramites</div>
      </div>
      <div class="tools">                
        <a href="#portlet-perfil" data-toggle="modal" class="config" data-original-title="" title="Crear Nuevo"></a>
        <a id="Remov" href="javascript:;" data-original-title="" title=""><i class='fa fa-remove' style="color:#d7eaf8 !important;"></i></a>
      </div>           
    </div>
      <div class="portlet-body">
  </div>
  <div class="portlet-body" id="addtables">
    <div id="removetable">
          <table class="table table-hover" id="sample_2">
            <thead>
              <tr>
              <th>Rol</th>
              <th>Tramite</th>
            <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>                   
                         
          </tbody>
        </table>  
      </div>             
    </div>
  </div>
        <!-- END SAMPLE TABLE PORTLET-->
</div>

<!----------------------------------------- Nuevo ROL-------------------------------------------->
<div class="modal fade" id="portlet-notario" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"data-dismiss="modal" aria-hidden="true" onclick="limpiarRol()"></button>
        <h4 class="modal-title">Configuracion Rol</h4>
        
      </div>
      <div class="modal-body">
        <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-12"> 
              <div class="form-group">
                <div class="form-group">
                <label >Nombre</label>                                             
                <input type="text" class="form-control" name="nameRol" id="nameRol" placeholder="Ingrese Nombre de Rol...">
              </div>                                           
              </div>
            </div>        
          </div>
        </div>
       
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-12">             
            <div class="form-group">
              <button type="submit" class="btn blue" onclick="saveRol()"><i class="fa fa-check"></i> Guardar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn default" onclick="limpiarRol()">Cerrar</button>
      </div>
    </div>
    </div>
  </div>
</div>
</div>
<!----------------------------------------- Nuevo Rol Tramite-------------------------------------------->
<div class="modal fade" id="portlet-perfil" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"data-dismiss="modal" aria-hidden="true" onclick="limpiarTramites()"></button>
        <h4 class="modal-title">Configuracion Tramites</h4>
        <input hidden="true" type="text" name="idtramite" id="idtramite">
      </div>
      <div class="modal-body">
        <div class="modal-body">
        <div class="row">
           <div class="col-md-12">
            <div class='form-group'>
              <label for="search" class="col-md-2" >Buscar:</label> 
              <div class="col-md-10"> 
                <input type="text" name="search" id="search" class="form-control" placeholder="Escribe...">
              <!--  <div class='md-checkbox'><input type='checkbox' id='checkbox30' class='md-check'>   <label for='checkbox30'>    <span></span>  <span class='check'></span> <span class='box'></span>Mostrar Todos</label> </div>-->
              </div> 
            </div>
          </div>
          <div  id="demo">              
            <table class="table table-hover table-wrapper-scroll-y my-custom-scrollbar" id="table2">
              <thead>
                <tr>            
                <th>Selecciona</th>
                </tr>
            </thead>
            <tbody>  
                        
            </tbody>
          </table>
        </div> 
        <br>
      <br>
        </div>
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-12">             
            <div class="form-group">
              <button type="submit" class="btn blue" onclick="saveUpdateTramites()"><i class="fa fa-check"></i> Guardar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn default" onclick="limpiarTramites()">Cerrar</button>
      </div>
    </div>
    </div>
  </div>
</div>
</div>

<!----------------------------------------- status perfil-------------------------------------------->
<div id="portlet-deleted" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
             ¿Eliminar Registro?<br>
                </p>
                 <input hidden="true" type="text" name="idregistro" id="idregistro" class="idregistro">
            </div>
            <div class="modal-footer">
                <div id="AddbuttonDeleted">
         <button type="button" data-dismiss="modal" class="btn default">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminaTramite()">Confirmar</button>
        </div>
            </div>
        </div>
    </div>
</div>

<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
@endsection

@section('scripts')

<script type="text/javascript">
  jQuery(document).ready(function() {

    TableManaged.init();
    });
  function saveRol()
  {
    var nameRol=$("#nameRol").val();

    if(nameRol)
    {
      Command: toastr.warning("Campo Nombre Rol, requerido!", "Notifications") 
    }else{
      insertRol();
    }
  }

  function insertRol()
  {
   nameRol=$("#nameRol").val();
    //console.log(notary_off);
    $.ajax({
           method: "POST", 
           url: "{{ url('/operacion-roles-create') }}",
           data:{descripcion:nameRol,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          var resp=$.parseJSON(response);
          if(resp.Code=="200"){
           /* $("#itemsRoles option").remove();
            $('#itemsRoles').append(
                "<option value='0'>------</option>"
            );
            var listusers = resp.list_roles;
            $.each(listusers, function(i, item) {                
                 $('#itemsRoles').append(
                "<option value='"+item.id+"'>"+item.descripcion+"</option>"
                   );
                });*/
            limpiarRol();
            Command: toastr.success(resp.Message, "Notifications");
          }else{
            
            Command: toastr.warning(resp.Message, "Notifications");
          }
         
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    
  }
  function changeRol()
  {
    var id=$("#itemsRoles").val();
    $.ajax({
           method: "get",            
           url: "{{ url('') }}",
           data: {_token:'{{ csrf_token() }}'}   })
        .done(function (response) {     
        
          document.getElementById('jsonCode').value=response;            
          var Resp=response;
          
        addtable();
        $.each(Resp, function(i, item) {        
            $('#sample_3 tbody').append("<tr>"
                +"<td>"+rol+"</td>"
                +"<td>"+item.tramite+"</td>"
                + "<td class='text-center' width='20%'><a class='btn btn-icon-only red' data-toggle='modal' href='#portlet-deleted'  title='Eliminar' onclick='tramiteDelete(\""+item.id+"\")'><i class='fa fa-minus'></i></a></td>"
                +"</tr>"
                );
            });
        TableManaged.init();
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function addtable()
  {
    $("#addtables div").remove();
    $("#addtables").append("<table class='table table-hover' id='sample_3'> <thead><tr><th>Rol</th><th>Tramite</th><th>&nbsp;</th></tr> </thead> <tbody></tbody> </table>");
     //TableManaged3.init3();

  }

  function tramiteDelete(id,status)
  {
    document.getElementById('idregistro').value=id;
    document.getElementById('status').value=status;
  }
  function deleteTramite()
  {
    var id_=$("#idrol").val();
    var id_tramite=$("#idtramite").val();
    $.ajax({
           method: "POST",            
           url: "{{ url('/notary-offices-user-status') }}",
           data: {notary_id:id_notary,user_id:id_,status:estatus, _token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
          changeRols();
          Command: toastr.success(title+" Correctamente", "Notifications") 
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function perfilUpdate(json)
  {
   //console.log(json);
   $("#itemsTipoUser").val("0").change();
      document.getElementById('idperfil').value=json.id; 
      document.getElementById('users').value=json.username; 
      document.getElementById('emailUser').value=json.email; 
      document.getElementById('telUser').value=json.phone; 
      document.getElementById('nameUser').value=json.name; 
      document.getElementById('apePatUser').value=json.fathers_surname; 
      document.getElementById('apeMatUser').value=json.mothers_surname; 
      document.getElementById('curpUser').value=json.curp; 
      document.getElementById('rfcUser').value=json.rfc; 
      document.getElementById('password').value=""; 

  }
  function updateTramites()
  {
    
    var id_=$("#idtramite").val();
      $.ajax({
           method: "POST",            
           url: "{{ url('/') }}",
           data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) { 
             limpiarPerf();
             Command: toastr.success("Success", "Notifications")
             changeNotario();

        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
  function saveUpdatePerf()
  {    
    var id_notary=$("#itemsTramites").val();
    var id=$("#idtramite").val();
    if (rfcUser=="0") {
        Command: toastr.warning("Campo Tramite, requerido", "Notifications") 
      }else{
        if(id.length>0)
          {
            updateTramites();
          }else{
            insertTramites();
          }
      }
  }
  function insertTramites()
  {
      var id_notary=$("#itemsTramites").val();
      
      $.ajax({
           method: "POST",            
           url: "{{ url('/') }}",
           data: {notary_id:id_notary,users:user_ ,_token:'{{ csrf_token() }}'}  })
        .done(function (response) { 
             limpiarTramite();
             Command: toastr.success("Success", "Notifications")
             changeNotario();

        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    
  }  
  function limpiarRol()
    {
      //$("#itemsTipoUser").val("0").change();
      document.getElementById('nameRol').value=""; 
  }
  function limpiarTramites()
  {
    $("#itemsTramites").val("0").change();
    document.getElementById('idtramite').value="";
    //$("input:radio").attr("checked", false);

}
function GuardarExcel()
{
  var JSONData=$("#jsonCode").val();
  JSONToCSVConvertor(JSONData, "Costos", true)
  
  
}
/*function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
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
}*/

</script>
@endsection
