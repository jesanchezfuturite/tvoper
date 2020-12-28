@extends('layout.app')


@section('content')
<link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<h3 class="page-title">Portal <small> Configuración Usuarios </small></h3>
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
            <a href="#">Configuración Usuarios</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Comunidad
            </div>
            <div class="tools"> 
              <a id="Remov" href="javascript:;" data-original-title="" title="">
                <i class='fa fa-remove' style="color:#d7eaf8 !important;"></i>
              </a>
            </div>
        </div>
        <div class="portlet-body">
        <div class="row">
          <div class="col-md-2 col-ms-12">
            <div class="form-group">
              <label class="control-label">Comunidades</label>
              <span class="help-block">(Selecciona)</span> 
            </div>
          </div>
          <div class="col-md-3 col-ms-12">
            <div class="form-group">
                <select id="itemsConfigUser" class="select2me form-control" onchange="changeComunidad()" >
                  <option value="0">-------</option>
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
          <div id="borraheader">  <i class="fa fa-cogs"> </i>&nbsp;Configurar Perfil</div>
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
              <th>Usuario</th>
              <th>Correo Electrónico</th>
              <th>Nombre</th>
              <th>RFC</th>
              <th>Curp</th>
              <th>Status</th>
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


<!----------------------------------------- Nuevo usuario-------------------------------------------->
<div class="modal fade" id="portlet-perfil" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"data-dismiss="modal" aria-hidden="true" onclick="limpiarPerf()"></button>
        <h4 class="modal-title">Configuracion Usuario</h4>
        <input hidden="true" type="text" name="idperfil" id="idperfil">
      </div>
      <div class="modal-body">
        <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6"> 
              <div class="form-group">
                <div class="form-group">
                <label >Usuario</label>&nbsp; &nbsp;<a  class=" popovers"  data-trigger="hover" data-placement="top" data-content="El usuario debe de estar compuesto por minúsculas, un número y ser al menos 8 caracteres..." data-original-title="Información"><i class="fa fa-question-circle"></i></a>                                           
                <input type="text" class="form-control" name="users" id="users" placeholder="Ingrese Nombre de Usuario...">
              </div>                                           
              </div>
            </div>
            <div class="col-md-6"> 
              <div class="form-group">
                <div class="form-group">
                <label >Correo Electrónico</label>                                             
                <input type="text" class="form-control" name="emailUser" id="emailUser" placeholder="Ingrese Correo Electrónico..." autocomplete="off">
                <span id="emailOK" class="help-block"></span>
              </div>                                            
              </div>
            </div>            
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
             <div class="col-md-6"> 
              <div class="form-group">
                <label >Número de Teléfono</label>                                             
                <input type="text" class="valida-numeros form-control" name="telUser" id="telUser" placeholder="Ingrese Numero de Teléfono..." autocomplete="off" maxlength="10">
              </div>
            </div>
             <div class="col-md-6"> 
              <div class="form-group"> 
                   <div class="form-group">
                <label >Nombre(s)</label>                                             
                <input type="text" class="form-control" name="nameUser" id="nameUser" placeholder="Ingrese Nombre(s)..."autocomplete="off">
              </div>                                
              </div>
            </div>            
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6"> 
              <div class="form-group">
                <label >Apellido Paterno</label>                                             
                <input type="text" class="form-control" name="apePatUser" id="apePatUser" placeholder="Ingrese Apellido Paterno...">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label >Apellido Materno</label>                                                       
                <input type="text" class="form-control" name="apeMatUser" id="apeMatUser" placeholder="Ingrese Apellido Materno...">
             </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6"> 
              <div class="form-group">
                <label >CURP</label>                                             
                <input type="text" class="form-control" name="curpUser" id="curpUser" placeholder="Ingrese Curp..."autocomplete="off" onkeyup="this.value = this.value.toUpperCase();" maxlength="18" oninput="validarCurpUser()">
                 <span id="curpUs" class="help-block"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label >RFC</label>                                                       
                <input type="text" class="form-control" name="rfcUser" id="rfcUser" placeholder="Ingrese RFC..."autocomplete="off" onkeyup="this.value = this.value.toUpperCase();" maxlength="13" oninput="validarRFCUser()">
                 <span id="rfcUs" class="help-block"></span>
             </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6">
              <div class="form-group">
                <label >Tipo</label>                                                       
                <select id="itemsTipoUser" class="select2me form-control" >
                  <option value="0">-------</option>
                  <option value="fisica">Fisica</option>
                  <option value="moral">Moral</option>
                </select>
             </div>
            </div>
            <div class="col-md-6"> 
              <div class="form-group"> 
                <label >Contraseña</label> &nbsp; &nbsp;<a  class=" popovers"  data-trigger="hover" data-placement="top" data-content="La contraseña debe de estar compuesto por una mayúscula, minúsculas, un número y ser al menos 8 caracteres..." data-original-title="Información"><i class="fa fa-question-circle"></i></a> 
                <div class="input-icon right">
                    <i  id="pass1"class="fa fa-eye-slash" onclick="onechange1()"  style="cursor:pointer;color: black;"></i>
                    <input type="password" name="password"id="password" autocomplete="new-password" class="form-control" placeholder="Ingresa la Contraseña" value="">
                    <span class="help-block">&nbsp; &nbsp;<a onclick="gPasswordPerf()"> Generar</a></span>
                </div>
              </div> 
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            
            <div class="col-md-6"> 
              <div class="form-group"> 
                <label >Permiso</label>
                <select id="itemsPermiso" class="select2me form-control" >
                  <option value="0">-------</option>
                </select>                               
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-12">             
            <div class="form-group">
              <button type="submit" class="btn blue" onclick="saveUpdatePerf()"><i class="fa fa-check"></i> Guardar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn default" onclick="limpiarPerf()">Cerrar</button>
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
             ¿Desactivar/Activar Registro?<br>
                </p>
                 <input hidden="true" type="text" name="idregistro" id="idregistro" class="idregistro">
                 <input hidden="true" type="text" name="status" id="status" class="status">
            </div>
            <div class="modal-footer">
                <div id="AddbuttonDeleted">
         <button type="button" data-dismiss="modal" class="btn default">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="desactivaAtiva()">Confirmar</button>
        </div>
            </div>
        </div>
    </div>
</div>

<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
<input type="text" name="base64pdf1" id="base64pdf1" hidden="true">
<input type="text" name="base64pdf2" id="base64pdf2" hidden="true">
@endsection

@section('scripts')
<script src="assets/global/scripts/validar_pdf.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript">
  jQuery(document).ready(function() {
    $(".iDocument").css("display","none");
    TableManaged.init();
    ItemsTramite();
    ItemsPermisos();
    
  });
  function getBase64SAT(file) {
   var reader = new FileReader();
   reader.readAsDataURL(file);
   reader.onload = function () {
    document.getElementById("base64pdf1").value=reader.result;
     //return reader.result;
   };
   
}
function getBase64Notario(file) {
   var reader = new FileReader();
   reader.readAsDataURL(file);
   reader.onload = function () {
    document.getElementById("base64pdf2").value=reader.result;
     //return reader.result;
   };
   
}
$('#downloadSAT').click(function(){ downloadPdf("sat"); return false; });
$('#downloadNotary').click(function(){ downloadPdf("notary"); return false; });
function downloadPdf(file)
{
  var id_notary=$("#itemsNotario").val();
  if(id_notary=="0")
  {
    return;
  }
   $.ajax({
        method: "get",            
        url: "{{ url('/get-route') }}"+"/"+id_notary+"/"+file,
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
           window.open(response, '_blank');
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al descargar", "Notifications")   });
  
}
function changeComunidad()
{
  var comunidad=$("#itemsConfigUser").val();
  $("#itemsNotario").val("0").change();
  if(comunidad=="0")
  {
    $("#itemsNotario option").remove();
    $('#itemsNotario').append("<option value='0'>------</option>");

    return;
  }
   $.ajax({
        method: "get",            
        url: "{{ url('/notary-offices-community') }}"+"/"+comunidad,
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
            $("#itemsNotario option").remove();
            $('#itemsNotario').append("<option value='0'>------</option>");
            $.each(response, function(i, item) {                
                $('#itemsNotario').append("<option value='"+item.id+"'>"+item.notary_number+"</option>");
            });
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Cargar Select Rol", "Notifications")   });
  
}

  function ItemsPermisos()
  {
    $.ajax({
      method: "get",            
      url: "{{ url('/notary-offices-roles') }}",
      data: {_token:'{{ csrf_token() }}'}  })
      .done(function (response) {     
        //console.log(response);
        var resp=$.parseJSON(response);
        $("#itemsPermiso option").remove();
        $('#itemsPermiso').append("<option value='0'>------</option>");
        $("#itemsPermisoNotario option").remove();
        $('#itemsPermisoNotario').append("<option value='0'>------</option>");
          $.each(resp.response, function(i, item) {
            $('#itemsPermiso').append("<option value='"+item.id+"'>"+item.description+"</option>");
            $('#itemsPermisoNotario').append("<option value='"+item.id+"'>"+item.description+"</option>");
                //console.log(item.id);
          });
        })
      .fail(function( msg ) {
         Command: toastr.warning("Error al Cargar Select Rol", "Notifications")   });
  }
  function ItemsTramite()
    {
        $.ajax({
        method: "get",            
        url: "{{ url('/operacion-roles-get-rol') }}",
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
            $("#itemsCofigNotario option").remove();
            $("#itemsConfigUser option").remove();
            $('#itemsCofigNotario').append("<option value='0'>------</option>");
            $('#itemsConfigUser').append("<option value='0'>------</option>");
            $.each(response, function(i, item) {                
                $('#itemsCofigNotario').append("<option value='"+item.id+"'>"+item.descripcion+"</option>");
                $('#itemsConfigUser').append("<option value='"+item.id+"'>"+item.descripcion+"</option>");
            });
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Cargar Select Rol", "Notifications")   });
  }
  async function saveNotario()
  {
    var numNotario=$("#numNotario").val();
    var telNotario=$("#telNotario").val();
    var faxNotario=$("#faxNotario").val();
    var emailNotario=$("#emailNotario").val();
    var calleNotario=$("#calleNotario").val();
    var numeroNotario=$("#numeroNotario").val();
    var distritoNotario=$("#distritoNotario").val();
    var itemsCiudadNot=$("#itemsCiudadNot").val();
    var itemsEntidadNot=$("#itemsEntidadNot").val();
    var codigopostNotario=$("#codigopostNotario").val();
    var userNotario=$("#userNotario").val();
    var emailNotario2=$("#emailNotario2").val();
    var nameNotario=$("#nameNotario").val();
    var apPatNotario=$("#apPatNotario").val();
    var apMatNotario=$("#apMatNotario").val();
    var telNotario2=$("#telNotario2").val();
    var curpNotario=$("#curpNotario").val();
    var rfcNotario=$("#rfcNotario").val();
    var itemsTipoNotario=$("#itemsTipoNotario").val();
    var passNotario=$("#passNotario").val();

    var itemsCofigNotario=$("#itemsCofigNotario").val();
    var itemsPermisoNotario=$("#itemsPermisoNotario").val();
    var pdf = $("#fileSAT")[0].files[0]; 
    var pdf2 = $("#fileNotario")[0].files[0];
     var pdfSAT = $("#fileSAT").val(); 
    var pdfNotario = $("#fileNotario").val();
    if(pdfSAT.length>0 && pdfNotario.length>0){ 
      getBase64SAT(pdf);
      getBase64Notario(pdf2);
    }
      
    emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    
    if (numNotario.length<1) {
       Command: toastr.warning("Campo Numero Notario, requerido!", "Notifications") 
    }else if (codigopostNotario.length<5) {
       Command: toastr.warning("Campo Codigo Postal, longitud minima 5!", "Notifications") 
    }else if (distritoNotario.length<1) {
       Command: toastr.warning("Campo Distrito, requerido!", "Notifications") 
    }else if (telNotario.length<10) {
       Command: toastr.warning("Campo Numero Teléfono, longitud minima 10!", "Notifications") 
    }else if (!emailRegex.test(emailNotario)) {
       Command: toastr.warning("Campo Correo Electrónico, formato incorrecto!", "Notifications") 
    }else if(!/[a-z]/.test(userNotario) || !/[A-Z]/.test(userNotario) || !/[0-9]/.test(userNotario) || userNotario.length < 8){
       Command: toastr.warning("Campo Usuario, formato incorrecto, 8 min. caracteres,1 mayuscula, 1 numero! ", "Notifications") 
    }else if (!emailRegex.test(emailNotario2)) {
       Command: toastr.warning("Segundo campo Correo Electrónico, formato incorrecto!", "Notifications") 
    }else if (telNotario2.length<10) {
       Command: toastr.warning("Segundo Campo Numero Teléfono, longitud minima 10!", "Notifications") 
    }else if (!curpValida(curpNotario)) {
       Command: toastr.warning("Campo CURP, formato incorrecto!", "Notifications") 
    }else if (rfcNotario.length<12) {
       Command: toastr.warning("Campo RFC, longitud minima 12!", "Notifications") 
    }else if(!/[a-z]/.test(passNotario) || !/[A-Z]/.test(passNotario) || !/[0-9]/.test(passNotario) || passNotario.length < 8){
      Command: toastr.warning("Campo Contraseña, formato incorrecto!", "Notifications") 
    }else if(itemsCofigNotario =='0'){
      Command: toastr.warning("Campo Usuario configurado para, requerido!", "Notifications") 
    }else if(itemsPermisoNotario =='0'){
      Command: toastr.warning("Campo Permiso, requerido!", "Notifications") 
    }else if(pdfSAT.length==0){ 
         Command: toastr.warning("Archivo Constancia SAT, Requerido!", "Notifications")
    }else if(pdfNotario.length==0){ 
         Command: toastr.warning("Archivo Constancia Notario, Requerido!", "Notifications")
    }else{
     await sleep(1000);
      insertNotario();
    }
  }

   function insertNotario()
  {
   var numNotario='';
   numNotario=$("#numNotario").val();
    var telNotario=$("#telNotario").val();
    var faxNotario=$("#faxNotario").val();
    var emailNotario=$("#emailNotario").val();
    var calleNotario=$("#calleNotario").val();
    var numeroNotario=$("#numeroNotario").val();
    var numeroExtNotario=$("#numeroExtNotario").val();
    var distritoNotario=$("#distritoNotario").val();
    var itemsCiudadNot=$("#itemsCiudadNot").val();
    var itemsEntidadNot=$("#itemsEntidadNot").val();
    var codigopostNotario=$("#codigopostNotario").val();
    var userNotario=$("#userNotario").val();
    var emailNotario2=$("#emailNotario2").val();
    var nameNotario=$("#nameNotario").val();
    var apPatNotario=$("#apPatNotario").val();
    var apMatNotario=$("#apMatNotario").val();
    var telNotario2=$("#telNotario2").val();
    var curpNotario=$("#curpNotario").val();
    var rfcNotario=$("#rfcNotario").val();
    var itemsTipoNotario=$("#itemsTipoNotario").val();
    var itemsCofigNotario=$("#itemsCofigNotario").val();
    var itemsPermisoNotario=$("#itemsPermisoNotario").val();
    var passNotario=$("#passNotario").val();

    var base64SAT=$("#base64pdf1").val();
    var base64Notario=$("#base64pdf2").val();

   
    var titular_={username: userNotario,
    email: emailNotario2,
    password: passNotario,
    name: nameNotario,
    mothers_surname:apMatNotario ,
    fathers_surname:apPatNotario,
    curp: curpNotario,
    rfc: rfcNotario,
    phone:telNotario2,
    person_type:itemsTipoNotario,
    config_id: itemsCofigNotario,
    role_id: itemsPermisoNotario };

    var notary_off= {notary_number: numNotario,
      phone: telNotario,
      fax: faxNotario,
      email: emailNotario,
      street: calleNotario,
      number: numeroNotario,
      "outdoor-number": numeroExtNotario,
      district: distritoNotario,
      federal_entity_id: itemsEntidadNot,
      city_id: itemsCiudadNot,
      zip: codigopostNotario,
      sat_constancy_file: base64SAT,
      notary_constancy_file: base64Notario,
      titular: titular_
      }; 
    //console.log(notary_off);
    $.ajax({
           method: "POST", 
           url: "{{ url('/notary-offices') }}",
           data:{notary_office:notary_off,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          console.log(response);
          var resp=$.parseJSON(response);
          console.log(resp);
          if(resp.data=="response"){
            changeComunidad();
            limpiarNot();
            Command: toastr.success("Success", "Notifications");
            return;
          }
          if(response==null || response=="null")
          {
            changeComunidad();
            limpiarNot();
            Command: toastr.success("Success", "Notifications");
            return;
          }
          if(resp.error){
            Command: toastr.warning(resp.error.message, "Notifications");
          }else{
            changeComunidad();
            limpiarNot();
            Command: toastr.success("Success", "Notifications");
            return;
          }
         
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    
  }
  function changeNotario()
  {
    var id=$("#itemsNotario").val();
    var com=$("#itemsConfigUser").val();
    if(id=="0")
    {
      $(".iDocument").css("display","none");
      addtable();
      TableManaged.init();
      return;
    }
    if(com=="0")
    {      
      Command: toastr.warning("Selecciona una Comunidad, Requerido!", "Notifications") 
      //$("#itemsNotario").val(0).change();
      return;
    }
    $(".iDocument").css("display","block");
    $.ajax({
           method: "get",            
           url: "{{ url('/notary-offices-get-users') }}"+"/"+id,
           data: {_token:'{{ csrf_token() }}'}   })
        .done(function (response) { 
          document.getElementById('jsonCode').value=response;            
          var Resp=response;
          addtable();
        $.each(Resp, function(i, item) {   
             json=JSON.stringify(item);        
             status=item.status;    
            if (status=='1') 
              { label="success";
                msgg="Activa";
                icon="red"; 
                title="Desactivar";
              }else if(status=='0'){ 
                label="danger";
                msgg="Inactiva"; 
                icon="green";  
                title="Activar";
              }else{
                label="warning";
                msgg="Sin estatus"; 
                icon="green";
                title="Activar";
              }
              //console.log(item.config_id);
            //if(com==item.config_id){   
              $('#sample_3 tbody').append("<tr>"
                +"<td>"+item.username+"</td>"
                +"<td>"+item.email+"</td>"
                +"<td>"+item.name+"</td>"
                +"<td>"+item.rfc+"</td>"
                +"<td>"+item.curp+"</td>"
                +"<td>&nbsp;<span class='label label-sm label-"+label+"'>"+msgg+"</span></td>"
                + "<td class='text-center' width='20%'><a class='btn btn-icon-only blue' href='#portlet-perfil' data-toggle='modal' data-original-title='' title='Editar' onclick='"+"perfilUpdate("+json+")'><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only "+icon+"' data-toggle='modal' href='#portlet-deleted'  title='"+title+"' onclick='perfilDelete(\""+item.id+"\",\""+item.status+"\")'><i class='fa fa-minus'></i></a></td>"
                +"</tr>"
                );
              //}
            });
        TableManaged.init();
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function addtable()
  {
    $("#addtables div").remove();
    $("#addtables").append("<table class='table table-hover' id='sample_3'> <thead><tr><th>Usuario</th><th>Correo Electrónico</th> <th>Nombre</th><th>RFC</th><th>Curp</th><th>Status</th><th>&nbsp;</th></tr> </thead> <tbody></tbody> </table>");
     //TableManaged3.init3();

  }

  function perfilDelete(id,status)
  {
    document.getElementById('idregistro').value=id;
    document.getElementById('status').value=status;
  }
  function desactivaAtiva()
  {
    var id_=$("#idregistro").val();
    var status_=$("#status").val();
    var id_notary=$("#itemsNotario").val();
    if(status_=="null")
    {
      estatus="1";
      title="Activado";
    }else if(status_=="1")
    {
      estatus="0";
      title="Desactivado";
    }else{
      estatus="1";
      title="Activado";
    }
    $.ajax({
           method: "POST",            
           url: "{{ url('/notary-offices-user-status') }}",
           data: {notary_id:id_notary,user_id:id_,status:estatus, _token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
          changeNotario();
          Command: toastr.success(title+" Correctamente", "Notifications") 
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function perfilUpdate(json)
  {
   //console.log(json);
    $("#itemsTipoUser").val("0").change();
    $("#itemsPermiso").val(json.role_id).change();
    //$("#itemsConfigUser").val(json.config_id).change();
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
  function updatePerfil()
  {
    
    var id_notary=$("#itemsNotario").val();
    var id_user=$("#idperfil").val();
      var TipoUser=$("#itemsTipoUser").val();
      var itemsConfigUser=$("#itemsConfigUser").val();
      var itemsPermiso=$("#itemsPermiso").val();
      var users=$("#users").val();
      var emailUser=$("#emailUser").val();
      var telUser=$("#telUser").val();
      var nameUser=$("#nameUser").val();
      var apePatUser=$("#apePatUser").val();
      var apeMatUser=$("#apeMatUser").val();
      var curpUser=$("#curpUser").val();
      var rfcUser=$("#rfcUser").val();
      var password=$("#password").val();
      var user_={username: users,
                email: emailUser,
                name: nameUser,
                mothers_surname: apeMatUser,
                fathers_surname: apePatUser,
                curp: curpUser,
                rfc: rfcUser,
                phone: telUser,
                config_id:itemsConfigUser,
                role_id:itemsPermiso
            };
      $.ajax({
           method: "POST",            
           url: "{{ url('/notary-offices-edit-user') }}",
           data: {notary_id:id_notary,user_id:id_user,user:user_ ,_token:'{{ csrf_token() }}'}  })
        .done(function (response) { 
             limpiarPerf();
             Command: toastr.success("Success", "Notifications")
             changeNotario();

        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
  function saveUpdatePerf()
  {    var id_notary=$("#itemsNotario").val();
      var id=$("#idperfil").val();
      var TipoUser=$("#itemsTipoUser").val();
      var users=$("#users").val();
      var emailUser=$("#emailUser").val();
      var telUser=$("#telUser").val();
      var nameUser=$("#nameUser").val();
      var apePatUser=$("#apePatUser").val();
      var apeMatUser=$("#apeMatUser").val();
      var curpUser=$("#curpUser").val();
      var rfcUser=$("#rfcUser").val();
      var password=$("#password").val();
      var itemsConfigUser=$("#itemsConfigUser").val();
      var itemsPermiso=$("#itemsPermiso").val();

          emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    
      if(id_notary=='0'){
        Command: toastr.warning("Selecciona Nortario, requerido!", "Notifications") 
      }else if(itemsConfigUser =='0'){
        Command: toastr.warning("Campo Comunidades, requerido!", "Notifications") 
      }else if(users.length < 1){
        Command: toastr.warning("Campo Usuario, requerido!", "Notifications") 
      }else if (!emailRegex.test(emailUser)) {
        Command: toastr.warning("Campo Correo Electrónico, formato incorrecto!", "Notifications") 
      }else if (telUser.length<10) {
        Command: toastr.warning("Campo Numero Teléfono, longitud minima 10!", "Notifications") 
      }else if (nameUser.length<1) {
        Command: toastr.warning("Campo Nombre, requerido!", "Notifications") 
      }else if (apePatUser.length<1) {
        Command: toastr.warning("Campo Apellido Paterno, requerido!", "Notifications") 
      }else if (apeMatUser.length<1) {
        Command: toastr.warning("Campo Apellido Materno, requerido!", "Notifications") 
      }else if (!curpValida(curpUser)) {
       Command: toastr.warning("Campo CURP, formato incorrecto!", "Notifications") 
      }else if (rfcUser.length<13) {
        Command: toastr.warning("Campo RFC, longitud minima 13!", "Notifications") 
      }else if(itemsPermiso =='0'){
        Command: toastr.warning("Campo Permiso, requerido!", "Notifications") 
      }else{
        if(id.length>0)
          {
            updatePerfil();
          }else{
            insertPerfil();
          }
      }
  }
  function insertPerfil()
  {
      var id_notary=$("#itemsNotario").val();
      var TipoUser=$("#itemsTipoUser").val();
      var users=$("#users").val();
      var emailUser=$("#emailUser").val();
      var telUser=$("#telUser").val();
      var nameUser=$("#nameUser").val();
      var apePatUser=$("#apePatUser").val();
      var apeMatUser=$("#apeMatUser").val();
      var curpUser=$("#curpUser").val();
      var rfcUser=$("#rfcUser").val();
      var password=$("#password").val();
      var itemsConfigUser=$("#itemsConfigUser").val();
      var itemsPermiso=$("#itemsPermiso").val();
      if(!/[a-z]/.test(password) || !/[A-Z]/.test(password) || !/[0-9]/.test(password) || password.length < 8){
        Command: toastr.warning("Campo Contraseña, formato incorrecto!", "Notifications") 
        return;
      }
      var user_={username: users,
                email: emailUser,
                password: password,
                name: nameUser,
                mothers_surname: apeMatUser,
                fathers_surname: apePatUser,
                curp: curpUser,
                rfc: rfcUser,
                phone: telUser,
                person_type: TipoUser,
                config_id: itemsConfigUser,
                role_id: itemsPermiso
            };
            console.log(id_notary);
            console.log(user_);
      $.ajax({
           method: "POST",            
           url: "{{ url('/notary-offices-create-users') }}",
           data: {notary_id:id_notary,users:user_ ,_token:'{{ csrf_token() }}'}  })
        .done(function (response) { 
          response=$.parseJSON(response);
             var error=response.error;
             console.log(error);
             if(response.data=="error")
             {
               Command: toastr.warning(error.message, "Notifications")
               return;
             }
             limpiarPerf();
             Command: toastr.success("Success", "Notifications")
             changeNotario();
             //console.log(response);
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    
  }  
  function limpiarPerf()
    {
      $("#itemsTipoUser").val("0").change();
      $("#itemsPermiso").val("0").change();
      //$("#itemsConfigUser").val("0").change();
      document.getElementById('idperfil').value=""; 
      document.getElementById('users').value=""; 
      document.getElementById('emailUser').value=""; 
      document.getElementById('telUser').value=""; 
      document.getElementById('nameUser').value=""; 
      document.getElementById('apePatUser').value=""; 
      document.getElementById('apeMatUser').value=""; 
      document.getElementById('curpUser').value=""; 
      document.getElementById('rfcUser').value=""; 
      document.getElementById('password').value=""; 
  }
  function limpiarNot()
  {
    document.getElementById('numNotario').value="";
    document.getElementById('telNotario').value="";
    document.getElementById('faxNotario').value="";
    document.getElementById('emailNotario').value="";
    document.getElementById('numeroNotario').value="";
    document.getElementById('calleNotario').value="";
    document.getElementById('distritoNotario').value="";
    $("#itemsCiudadNot").val("0").change();
    $("#itemsCofigNotario").val("0").change();
    $("#itemsEntidadNot").val("0").change();
    document.getElementById('codigopostNotario').value="";
    document.getElementById('userNotario').value="";
    document.getElementById('emailNotario2').value="";
    document.getElementById('nameNotario').value="";
    document.getElementById('apPatNotario').value="";
    document.getElementById('apMatNotario').value="";
    document.getElementById('telNotario2').value="";
    document.getElementById('curpNotario').value="";
    document.getElementById('rfcNotario').value="";
    $("#itemsTipoNotario").val("0").change();
    document.getElementById('passNotario').value=""; 
    $("#itemsPermisoNotario").val("0").change();
    //$("input:radio").attr("checked", false);
    document.getElementById('base64pdf1').value="";
    document.getElementById('base64pdf2').value="";
    document.getElementById('delFileNotario').click();
    document.getElementById('delFileSAT').click();
    document.getElementById('numeroExtNotario').value="";

}
function onechange2()
{
    var nombre=$("#pass2").attr("class");
    if(nombre=="fa fa-eye-slash")
    {
      $("#pass2").removeClass("fa-eye-slash").addClass("fa-eye");
      $('#passNotario').attr('type', 'text');
    }else{
      $("#pass2").removeClass("fa-eye").addClass("fa-eye-slash");
      $('#passNotario').attr('type', 'password');
    }
}
function onechange1()
{
  var nombre=$("#pass1").attr("class");
    if(nombre=="fa fa-eye-slash")
    {
      $("#pass1").removeClass("fa-eye-slash").addClass("fa-eye");
      $('#password').attr('type', 'text');
    }else{
      $("#pass1").removeClass("fa-eye").addClass("fa-eye-slash");
      $('#password').attr('type', 'password');
    }
}
function GuardarExcel()
{
  var JSONData=$("#jsonCode").val();
  JSONToCSVConvertor(JSONData, "Costos", true)
  
  
}
$('.valida-numeros').on('input', function () { 
    this.value = this.value.replace(/[^0-9]/g,'');
});
$('.valida-user').on('input', function () { 
    this.value = this.value.replace(/[^0-9a-zA-Z]/g,'');
});
document.getElementById('emailUser').addEventListener('input', function() {
    campo = event.target;
    valido = document.getElementById('emailOK');        
    emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    if (emailRegex.test(campo.value)) {
        valido.innerText = "";
    } else {
      valido.innerText = "Incorrecto";
      document.getElementById("emailOK").style.color = "red";
    }
});
document.getElementById('emailNotario').addEventListener('input', function() {
    campo = event.target;
    valido = document.getElementById('emailNot');        
    emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    if (emailRegex.test(campo.value)) {
        valido.innerText = "";
    } else {
      valido.innerText = "Incorrecto";
      document.getElementById("emailNot").style.color = "red";
    }
});
document.getElementById('emailNotario2').addEventListener('input', function() {
    campo = event.target;
    valido = document.getElementById('emailNot2');        
    emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    if (emailRegex.test(campo.value)) {
        valido.innerText = "";
    } else {
      valido.innerText = "Incorrecto";
      document.getElementById("emailNot2").style.color = "red";
    }
});
function curpValida(curp) {
    var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
        validado = curp.match(re);
  
    if (!validado)  //Coincide con el formato general?
      return false;
    
    //Validar que coincida el dígito verificador
    function digitoVerificador(curp17) {
        //Fuente https://consultas.curp.gob.mx/CurpSP/
        var diccionario  = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
            lngSuma      = 0.0,
            lngDigito    = 0.0;
        for(var i=0; i<17; i++)
            lngSuma = lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
        lngDigito = 10 - lngSuma % 10;
        if (lngDigito == 10) return 0;
        return lngDigito;
    }
  
    if (validado[2] != digitoVerificador(validado[1])) 
      return false;
        
    return true; //Validado
}
function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
  }
function gPasswordNot()
{
  var caracteres = "abcdefghijkmnpqrtuvwxyzABCDEFGHJKMNPQRTUVWXYZ123467890";
  var pass = "";
  for (i=0; i<16; i++) pass +=caracteres.charAt(Math.floor(Math.random()*caracteres.length));
  document.getElementById("passNotario").value=pass;
}
function gPasswordPerf()
{
  var caracteres = "abcdefghijkmnpqrtuvwxyzABCDEFGHJKMNPQRTUVWXYZ123467890";
  var pass = "";
  for (i=0; i<16; i++) pass +=caracteres.charAt(Math.floor(Math.random()*caracteres.length));
  document.getElementById("password").value=pass;
}
function rfcValido(rfc, aceptarGenerico = true) {
    const re       = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
    var   validado = rfc.match(re);
    if (!validado)
        return false;
    const digitoVerificador = validado.pop(),
          rfcSinDigito      = validado.slice(1).join(''),
          len               = rfcSinDigito.length,
          diccionario       = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
          indice            = len + 1;
    var   suma,
          digitoEsperado;
    if (len == 12) suma = 0
    else suma = 481; 
    for(var i=0; i<len; i++)
        suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
    digitoEsperado = 11 - suma % 11;
    if (digitoEsperado == 11) digitoEsperado = 0;
    else if (digitoEsperado == 10) digitoEsperado = "A";
    if ((digitoVerificador != digitoEsperado)
     && (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
        return false;
    else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
        return false;
    return rfcSinDigito + digitoVerificador;
}
function validarRFCNot() {
    var rfc=$("#rfcNotario").val();
    //console.log(rfc);
    rfcCorrecto=rfcValido(rfc.toUpperCase());
    valido = document.getElementById('rfcNot'); 
    if (rfcCorrecto) {
     valido.innerText = "";
    } else {
      valido.innerText = "Incorrecto";
      document.getElementById("rfcNot").style.color = "red";
    }
}
function validarRFCUser() {
    var rfc=$("#rfcUser").val();
    rfcCorrecto=rfcValido(rfc.toUpperCase());
    valido = document.getElementById('rfcUs'); 
    if (rfcCorrecto) {
      valido.innerText = "";
    } else {
      valido.innerText = "Incorrecto";
      document.getElementById("rfcUs").style.color = "red";
    }
}
function validarCurpNot() {
    var curp=$("#curpNotario").val();
    rfcCorrecto=curpValida(curp.toUpperCase());
    valido = document.getElementById('curpNot'); 
    if (rfcCorrecto) {
      valido.innerText = "";
    } else {
      valido.innerText = "Incorrecto";
      document.getElementById("curpNot").style.color = "red";
    }
}
function validarCurpUser() {
    var curp=$("#curpUser").val();
    rfcCorrecto=curpValida(curp.toUpperCase());
    valido = document.getElementById('curpUs'); 
    if (rfcCorrecto) {
      valido.innerText = "";
    } else {
      valido.innerText = "Incorrecto";
      document.getElementById("curpUs").style.color = "red";
    }
}

</script>
@endsection
