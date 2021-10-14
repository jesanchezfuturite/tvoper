@extends('layout.app')


@section('content')
<link href="assets/global/css/checkbox.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<h3 class="page-title">Portal <small>Comunidades</small></h3>
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
            <a href="#">Comunidades</a>
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
                <i class="fa fa-bank"></i>Agregar Comunidad
            </div>
            <div class="tools">                
              <a href="#portlet-rol" data-toggle="modal" class="tooltips" data-original-title="" title="Editar Registro" onclick="editRol()"><i class='fa fa-pencil' style="color:#d7eaf8 !important;"></i>
              </a>
              <a href="#portlet-deleted" data-toggle="modal" class="tooltips" data-original-title="" title="Eliminar Registro">
                <i class='fa fa-remove' style="color:#d7eaf8 !important;"></i>
              </a>
            </div>
        </div>
        <div class="portlet-body">
        <div class="row"> 
          <div class="col-md-1"> 
              <div class="form-group">
                <label >Nueva Comunidad</label>                                             
                
              </div>
            </div> 
            <div class="col-md-3">             
            <div class="form-group">
              <input type="text" class="form-control" name="nameRol" id="nameRol" placeholder="Ingrese Nombre de la Comunidad...">
            </div>
          </div>
            <div class="col-md-1">             
            <div class="form-group">
              <button type="submit" class="btn blue" onclick="saveRol()"><i class="fa fa-check"></i> Agregar</button>
            </div>
          </div>           
            <div class="col-md-3 col-ms-12">
                <div class="form-group">
                    <label >Comunidades Registrados </label>  
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

<!-----------------------------------------ROW-------------------------------------------->
<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Perfiles
            </div>
            <div class="tools">                
              
            </div>
        </div>
        <div class="portlet-body">
          <div class="row"> 
            <div class="col-md-1"> 
                <div class="form-group">
                  <label >Perfiles</label>                                             
                  
                </div>
              </div> 
              <div class="col-md-3">             
              <div class="form-group">
                <select class="select2me form-control"name="itemsRoles" id="itemsRoles" onchange="changeRol()">
                      <option value="0">------</option>                         
                    </select>
              </div>
            </div> 
            <div class="col-md-1"> 
                <div class="form-group">
                  <label >Permisos</label>                                             
                  
                </div>
              </div> 
              <div class="col-md-3">             
              <div class="form-group">
                <select class="select2me form-control"name="itemsRoles" id="itemsRoles" onchange="changeRol()">
                      <option value="0">------</option>                         
                    </select>
              </div>
            </div>           
          </div>
        </div>
    </div>
</div>

<!----------------------------------------- ROW-------------------------------------------->
<div class="row">
 <!-- BEGIN SAMPLE TABLE PORTLET-->
  <div class="portlet box blue">
    <div class="portlet-title" >
      <div class="caption">
          <div id="borraheader">  <i class="fa fa-cogs"> </i>&nbsp;Configuracion Usuarios</div>
      </div>
      <div class="tools">                
       <!--<a href="#portlet-perfil"  class="config" data-original-title="" title="Crear Nuevo"></a>
       -->
        <a href="#portlet-user" data-toggle="modal" class="tooltips" data-original-title="" title="Editar Registro"><i class='fa fa-user' style="color:#d7eaf8 !important;"></i></a>
        <a href="#portlet-perfil" data-toggle="modal" class="tooltips" data-original-title="" title="Editar Registro"><i class='fa fa-pencil' style="color:#d7eaf8 !important;"></i></a>

      </div>           
    </div>
      <div class="portlet-body">
  </div>
  <div class="portlet-body" id="addtables">
    <div id="removetable">
          <table class="table table-hover" id="sample_2">
            <thead>
              <tr>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Perfil</th>
              <th></th>
            <!--<th>&nbsp;</th> --->
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
              <div class="col-md-4"></div>
              <label for="search" class="col-md-2 control-label" >Buscar:</label> 
              <div class="col-md-6"> 
                <input type="text" name="search" id="search" class="form-control" placeholder="Buscar...">
              <!--  <div class='md-checkbox'><input type='checkbox' id='checkbox30' class='md-check'>   <label for='checkbox30'>    <span></span>  <span class='check'></span> <span class='box'></span>Mostrar Todos</label> </div>-->
              </div> 
            </div>
          </div>
        </div>
        <div class="row">
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
        </div>
      <div class="row">
        <div class="col-md-12">            
            <div class="form-group">
              <button type="submit" class="btn blue" onclick="updateTramites()"><i class="fa fa-check"></i> Guardar</button>
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
           <!--  Rol: <label id="idrol"></label>--> 
                </p>
            </div>
            <div class="modal-footer">
                <div id="AddbuttonDeleted">
         <button type="button" data-dismiss="modal" class="btn default">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminaRol()">Confirmar</button>
        </div>
            </div>
        </div>
    </div>
</div>


<!-----------------------------------------ADD USER----- ----------------------------->
<div class="modal fade" id="portlet-user" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"data-dismiss="modal" aria-hidden="true" onclick="limpiarNot()"></button>
        <h3 class="modal-title" id="encabezado_modal">Configuración Notaria</h3>        
      </div>
      <div class="modal-body">
      <div class="section-notary">
        <div class="row">
          <div class="col-md-12">
            <div class="portlet-body form">
              <div class="form-body">
                <h4 class="form-section"><strong>Datos generales sobre la notaría</strong></h4>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-4"> 
              <div class="form-group">
                <div class="form-group">
                <label for="numNotario">* Número de Notaria</label>                                             
                <input type="text" class="form-control" name="numNotario" id="numNotario" placeholder="Ingrese Numero de Notaria..."autocomplete="off">
              </div>                                           
              </div>
            </div>
            <div class="col-md-4"> 
              <div class="form-group">
                <label for="itemsEntidadNot">* Entidad Federativa</label>  
                <select id="itemsEntidadNot" class="select2me form-control" onchange="changeEntidades()">
                  <option value="0">-------</option>
                </select>    
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="itemsCiudadNot">* Ciudad</label>
                <select id="itemsCiudadNot" class="select2me form-control" >
                  <option value="0">-------</option>
                </select>
             </div> 
            </div>
                                     
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
          <div class="col-md-5"> 
              <div class="form-group">
                <label for="calleNotario"> * Calle</label>                                             
                <input type="text" class="form-control" name="calleNotario" id="calleNotario" placeholder="Ingrese Calle...">
              </div>
            </div> 
           <div class="col-md-2">
              <div class="form-group">
                <label for="numeroExtNotario">* Número Exterior</label>                                                       
                <input type="text" class="form-control" name="numeroExtNotario" id="numeroExtNotario" placeholder="Ingrese Numero Exterior..."maxlength="10"autocomplete="off">
             </div> 
           </div>
           <div class="col-md-2">
              <div class="form-group">
                <label for="numeroNotario">Número Interior</label>                                                       
                <input type="text" class="form-control" name="numeroNotario" id="numeroNotario" placeholder="Ingrese Numero..." autocomplete="off">
             </div> 
           </div> 
           <div class="col-md-3">
              <div class="form-group">
                <label for="codigopostNotario">* Código Postal</label>                                                       
                <input type="text" class="form-control valida-numeros"maxlength = "10" name="codigopostNotario" id="codigopostNotario" placeholder="Ingrese Codigo Postal...">
             </div> 
           </div>
                                         
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-5"> 
              <div class="form-group">
                <div class="form-group">
                <label for="distritoNotario">* Colonia</label>                                             
                <input type="text" class="form-control" name="distritoNotario" id="distritoNotario" placeholder="Ingrese Colonia..." autocomplete="off">
              </div>                                            
              </div>
            </div>
             <div class="col-md-3"> 
              <div class="form-group">
                <label for="telNotario">* Número de Teléfono</label>                                             
                <input type="text" class="valida-numeros form-control" name="telNotario" id="telNotario" placeholder="Ingrese Numero de Teléfono..."  maxlength = "10"autocomplete="off">
              </div>
            </div>            
             <div class="col-md-4">
              <div class="form-group">
                <label for="emailNotario">* Correo Electrónico</label>                                             
                <input type="text" class="form-control" name="emailNotario" id="emailNotario" placeholder="Ingrese Correo Electrónico..." autocomplete="off">
                <span id="emailNot" class="help-block"></span>                                           
              </div>
            </div>            
             
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-4" hidden="true"> 
              <div class="form-group"> 
                   <div class="form-group">
                <label for="faxNotario">Fax</label>                                             
                <input type="text" class="form-control" name="faxNotario" id="faxNotario" placeholder="Ingrese Fax..."  maxlength = "10">
              </div>                                
              </div>
            </div>
                       
          </div>
        </div>
      </div> 
        <div class="row title-user">
          <div class="col-md-12">
            <div class="portlet-body form">
              <div class="form-body">
                <h4 class="form-section"><strong>Datos del notario titular</strong></h4>
                <input hidden="true" type="text" name="idperfil" id="idperfil">
              </div>
            </div>
          </div>
        </div>
        <div class="section-users">
        <div class="row">
          <div class="col-md-12">
          <div class="col-md-4"> 
              <div class="form-group">
                <label for="curpUser">* CURP</label>                                             
                <input type="text" class="form-control" name="curpUser" id="curpUser" placeholder="Ingrese Curp..."autocomplete="off" onkeyup="this.value = this.value.toUpperCase();" maxlength="18" oninput="validarCurpUser()">
                 <span id="curpUs" class="help-block"></span>
              </div>
            </div>             
            <div class="col-md-4"> 
              <div class="form-group">
                <label for="nameUser">* Nombre(s)</label>                                             
                <input type="text" class="form-control" name="nameUser" id="nameUser" placeholder="Ingrese Nombre(s)..."autocomplete="off">
              </div>
            </div>
            <div class="col-md-4"> 
              <div class="form-group">
                <label for="apePatUser">* Apellido Paterno</label>                                             
                <input type="text" class="form-control" name="apePatUser" id="apePatUser" placeholder="Ingrese Apellido Paterno..."autocomplete="off">
              </div>
            </div>
            
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-4">
              <div class="form-group">
                <label for="apeMatUser">* Apellido Materno</label>                                                       
                <input type="text" class="form-control" name="apeMatUser" id="apeMatUser" placeholder="Ingrese Apellido Materno..."autocomplete="off">
             </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="rfcUser">* RFC</label>                                                       
                <input type="text" class="form-control" name="rfcUser" id="rfcUser" placeholder="Ingrese RFC..."autocomplete="off" onkeyup="this.value = this.value.toUpperCase();" maxlength="13" oninput="validarRFCUser()">
                 <span id="rfcUs" class="help-block"></span>
             </div>
            </div>
            <div class="col-md-4"> 
              <div class="form-group">
                <label for="telUser">* Número de Teléfono</label>                                             
                <input type="text" class="valida-numeros form-control" name="telUser" id="telUser" placeholder="Ingrese Numero de Teléfono..." autocomplete="off" maxlength="10">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">          
            <div class="col-md-4"> 
              <div class="form-group">
                <label for="emailUser">* Correo Electrónico</label>                                             
                <input type="text" class="form-control" name="emailUser" id="emailUser" placeholder="Ingrese Correo Electrónico..." autocomplete="off">
                <span id="emailOK" class="help-block"></span>                                            
              </div>
            </div> 
            <div class="col-md-4" hidden="true">
              <div class="form-group">
                <label for="itemsTipoUser">* Tipo</label>                                                       
                <select id="itemsTipoUser" class="select2me form-control" >                  
                  <option value="fisica">Fisica</option>                  
                </select>
             </div>
            </div>
            <div class="col-md-4 input-comunidad"> 
              <div class="form-group">
                <label for="itemsCofigNotario">* Comunidad</label> 
                   <select id="itemsCofigNotario" class="select2me form-control" disabled="true">
                  <option value="0">-------</option>
                </select>                                
              </div>
            </div>
            <div class="col-md-4 input-permiso"> 
              <div class="form-group"> 
                <label for="itemsPermiso">* Permiso</label>
                <select id="itemsPermiso" class="select2me form-control" onchange="changePermiso();">
                  <option value="0">-------</option>
                </select>                               
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-4"> 
              <div class="form-group">
                <div class="form-group">
                <label for="users">* Usuario</label>&nbsp; &nbsp;<a  class=" popovers"  data-trigger="hover" data-placement="top" data-content="El usuario debe ser al menos 8 caracteres..." data-original-title="Información"><i class="fa fa-question-circle"></i></a>                                           
                <input type="text" class="form-control" name="users" id="users" placeholder="Ingrese Nombre de Usuario..."autocomplete="off" oninput="usernameE(this.value,'userError')">
                <span id="userError" class="help-block"></span>
              </div>                                           
              </div>
            </div>
            <div class="col-md-4"> 
              <div class="form-group"> 
               <label class="required_pass">*</label> <label for="password">Contraseña</label> &nbsp; &nbsp;<a  class=" popovers"  data-trigger="hover" data-placement="top" data-content="La contraseña debe de estar compuesto por una mayúscula, minúsculas, un número y ser al menos 8 caracteres..." data-original-title="Información"><i class="fa fa-question-circle"></i></a> 
                <div class="input-icon right">
                    <i  id="pass1"class="fa fa-eye-slash" onclick="onechange1()"  style="cursor:pointer;color: black;"></i>
                    <input type="password" name="password"id="password" autocomplete="new-password" class="form-control" placeholder="Ingresa la Contraseña" value="">
                    <span class="help-block">&nbsp; &nbsp;<a onclick="gPasswordPerf()"> Generar</a></span>
                </div>
              </div> 
            </div>
            
          </div>
        </div>
      </div>
        <div class="row section-archivos">
          <div class="col-md-12">
            <div class="col-md-4"> 
              <div class="form-group">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                        <span class="btn green btn-file">
                        <span class="fileinput-new">
                        <i class="fa fa-plus"></i>&nbsp; &nbsp;*Adjuntar Constancia SAT </span>
                        <span class="fileinput-exists">
                        <i class="fa fa-exchange"></i>&nbsp; &nbsp;Cambiar Constancia SAT </span>
                        <input type="file" name="fileSAT" accept="application/pdf" id="fileSAT">
                        </span>
                        <div class="col-md-12"><span class="fileinput-filename" style="display:block;text-overflow: ellipsis;width: 200px;overflow: hidden; white-space: nowrap;">
                        </span>&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"style="position: absolute;left: 215px;top: 4px" id="delFileSAT">
                        </a></div>
                        
                </div>
              </div>
            </div>
            <div class="col-md-4"> 
              <div class="form-group">
               
               <div class="fileinput fileinput-new" data-provides="fileinput">
                        <span class="btn green btn-file">
                        <span class="fileinput-new">
                        <i class="fa fa-plus"></i>&nbsp; &nbsp;*Adjuntar Constancia Notario </span>
                        <span class="fileinput-exists">
                        <i class="fa fa-exchange"></i>&nbsp; &nbsp;Cambiar Constancia Notario </span>
                        <input type="file" name="fileNotario" accept="application/pdf"  id="fileNotario">
                        </span>
                        <div class="col-md-12"><span class="fileinput-filename" style="display:block;text-overflow: ellipsis;width: 200px;overflow: hidden; white-space: nowrap;">
                        </span><a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput" style="position: absolute;left: 215px;top: 4px" id="delFileNotario">
                        </a></div>
                        
                </div>
              </div>
            </div>
          </div>
          
        </div>
        <div class="row input-checkbox-reenvio">
          <div class="col-md-12">
            <div class="col-md-4"> 
              <div class="form-group">
               <div class='md-checkbox'>
                    <input type='checkbox' id='checkbox1' name="checkFile" class='md-check '>
                    <label for='checkbox1'>
                    <span></span>
                    <span class='check'></span> <span class='box'>
                  </span>  Reenvio de Correo. </label>
                </div>                                        
              </div>
            </div>            
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">             
            <div class="form-group">
              <span class="help-block">&nbsp;</span>
             <!-- <button type="submit" class="btn blue btn-save-Not" onclick="saveNotario()"><i class="fa fa-check"></i> Guardar</button>
              <button type="submit" class="btn blue btn-upd-Not" onclick="updateNotaria()"><i class="fa fa-check"></i> Guardar</button>-->
              <button type="submit" class="btn blue btn-saveup-User" onclick="saveUpdatePerf()"><i class="fa fa-check"></i> Guardar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn default" onclick="limpiarNot()">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<input type="text" name="jsonTramites" id="jsonTramites"  value="[]" hidden="true">
<input type="text" name="jsonCode" id="jsonCode" hidden="true">
<input type="text" name="selectedChecks" id="selectedChecks" value="[]" hidden="true">
@endsection

@section('scripts')
<script src="assets/global/scripts/validar_pdf.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript">
  jQuery(document).ready(function() {
    findTramites();
    TableManaged.init();
    $(".section-notary").css("display", "none");
     $(".title-user").css("display", "none");
     $(".section-users").css("display", "block");
     $(".section-archivos").css("display", "none");     

     $(".input-comunidad").css("display", "none");
     $(".input-permiso").css("display", "block");
    

     $(".btn-save-Not").css("display", "none");
     $(".btn-saveup-User").css("display", "block");
     $(".btn-upd-Not").css("display", "none");
    });
  function deleteRol()
  { 
    var id_=$("#itemsRoles").vall();
     var rolMember=$("#itemsRoles option:selected").text();
      //document.getElementById('idrol').innerHTML =rolMember;

  }
   function eliminaRol()
  {
   id_=$("#itemsRoles").val();
   if(id_=="0")
   {
    return;
   }
    //console.log(notary_off);
    $.ajax({
           method: "POST", 
           url: "{{ url('/operacion-roles-eliminar-rol') }}",
           data:{id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          if(response.Code=="200"){
           //document.getElementById('idrol').innerHTML ="";
            Command: toastr.success(response.Message, "Notifications");
          }else{
            
            Command: toastr.warning(response.Message, "Notifications");
          }
         
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    
  }
  function saveRol()
  {
    var nameRol=$("#nameRol").val();
    var id_rol=$("#id_rol").val();
    if(nameRol.length<1)
    {
      Command: toastr.warning("Campo Nombre Rol, requerido!", "Notifications") 
    }else{
      if(id_rol.length>0)
        {
          updateRol();
        }else{
          insertRol();
      }
    }
  }
  function editRol() {
    var id_=$("#itemsRoles").val();
    var rolMember=$("#itemsRoles option:selected").text();
    document.getElementById("nameRol").value=rolMember;
    document.getElementById("id_rol").value=id_;
    if(id_=="0")
    {
      document.getElementById("nameRol").value="";
    }
  }
  function updateRol()
  {
    var id_=$("#itemsRoles").val();
    if(id_=="0")
    {
     return;
    }
    nameRol=$("#nameRol").val();
    tramties_=$("#selectedChecks").val();
    $.ajax({
           method: "POST", 
           url: "{{ url('/operacion-roles-edit-rol') }}",
           data:{ id: id_, descripcion: nameRol, tramites: tramties_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          if(response.Code=="200"){
            findRol();
            limpiarRol();
            Command: toastr.success(response.Message, "Notifications");
          }else{
            
            Command: toastr.warning(response.Message, "Notifications");
          }
         
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    
  }
  function insertRol()
  {

   nameRol=$("#nameRol").val();
    //console.log(notary_off);
    $.ajax({
           method: "get", 
           url: "{{ url('/operacion-roles-create') }}",
           data:{descripcion:nameRol,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          if(response.Code=="200"){
           findRol();
            limpiarRol();
            Command: toastr.success(response.Message, "Notifications");
          }else{
            
            Command: toastr.warning(response.Message, "Notifications");
          }
         
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    
  }
  function findTramites()
    {
      
      $.ajax({
        method: "get",            
        url: "{{ url('/operacion-roles-get-tramites') }}",
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {   
         console.log(response);
        var Resp=$.parseJSON(response);        
        Resp.sort(function (a, b) {
          if (a.tramite > b.tramite) {
            return 1;
          }
          if (a.tramite < b.tramite) {
            return -1;
          } 
          return 0;
        });
          var item="";
          $("#table2 tbody tr").remove();
        $.each(Resp, function(i, item) {                
            $("#table2").append("<tr>"
              +"<td><input id='ch_"+item.id_tramite+"' type='checkbox'onclick='addRemoveElement("+item.id_tramite+");' value='"+item.id_tramite+"'> &nbsp <label for='ch_"+item.id_tramite+"'>"+item.tramite+"</label></td>"
              +"</tr>"
            );  
         
        });
         
        //sortTable();
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
  function findRol()
  {

     $.ajax({
           method: "get",            
           url: "{{ url('/operacion-roles-get-rol') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
        
           //console.log(response);
          $("#itemsRoles option").remove();
          $("#itemsRoles").append("<option value='0'>-------</option>");
            $.each(response, function(i, item) {                
               $("#itemsRoles").append("<option value='"+item.id+"'>"+item.descripcion+"</option>");  
            });
            //$("#itemsRoles").val(id_).change();
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function changeRol()
  {
    var id=$("#itemsRoles").val();
    var rolMember=$("#itemsRoles option:selected").text();
    document.getElementById('jsonTramites').value="[]"; 
    document.getElementById('selectedChecks').value="[]"; 
    var oElements = $.parseJSON($("#jsonTramites").val());
    $('input:checkbox').removeAttr('checked');
    if(id=='0')
    {
      addtable();
      TableManaged.init();
      return;
    }
    $.ajax({
           method: "POST",            
           url: "{{ url('/operacion-roles-get-tramite') }}"+"/"+id,
           data: {_token:'{{ csrf_token() }}'}   })
        .done(function (response) {     
          //console.log(response);
          //document.getElementById('jsonCode').value=response;  
          if(response==null){
            addtable();
            TableManaged.init();
            return;
          }else{         
            var Resp= $.parseJSON(response);
          }
        addtable();
        $.each(Resp, function(i, item) {        
          $('#sample_3 tbody').append("<tr>"
            +"<td>"+rolMember+"</td>"
            +"<td>"+item.Tipo_Descripcion+"</td>"
            /* + "<td class='text-center' width='20%'><a class='btn btn-icon-only red' data-toggle='modal' href='#portlet-deleted'  title='Eliminar' onclick='tramiteDelete(\""+item.Tipo_Code+"\")'><i class='fa fa-minus'></i></a></td>"*/
            +"</tr>");
          $("#ch_"+item.Tipo_Code).prop("checked", true);
            oElements.push(item.Tipo_Code);
        });
        TableManaged.init();
          var filtered = oElements.filter(function (el) {
            return el != null;
          });
          $("#jsonTramites").val(JSON.stringify(filtered));
          $("#selectedChecks").val(JSON.stringify(filtered)); 
        })
        .fail(function( msg ) {
         //Command: toastr.warning("No Success", "Notifications")
         //console.log(msg);
            addtable();
            TableManaged.init();
          });
  }
  function addtable()
  {
    $("#addtables div").remove();
    $("#addtables").append("<table class='table table-hover' id='sample_3'> <thead><tr><th>Comunidad</th><th>Tramite</th></tr> </thead> <tbody></tbody> </table>");
     //TableManaged3.init3();<th>&nbsp;</th>

  }

  function updateTramites()
  {
      var id_rol=$("#itemsRoles").val();
      var tramites_=$.parseJSON($("#selectedChecks").val());
      document.getElementById('jsonTramites').value=JSON.stringify(tramites_); 
      $.ajax({
           method: "POST",            
           url: "{{ url('/operacion-roles-add-tramite') }}",
           data: { rol_id: id_rol, tramites: tramites_, _token: '{{ csrf_token() }}'}  })
        .done(function (response) { 
          if(response.Code=="200"){
            limpiarTramites();
            Command: toastr.success(response.Message, "Notifications");
            changeRol();
          }else{
            
            Command: toastr.warning(response.Message, "Notifications");
          }

        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    
  }  
  function limpiarRol()
    {
      //$("#itemsTipoUser").val("0").change();
      document.getElementById('nameRol').value=""; 
      document.getElementById("id_rol").value="";
  }
  function limpiarTramites()
  {
    //$("#itemsTramites").val("0").change();
    //document.getElementById('idtramite').value="";
     $('input:checkbox').removeAttr('checked');
    //$("input:radio").attr("checked", false);
    ReSelectedChecks();
}
function ReSelectedChecks()
{
  var checkedElements = $.parseJSON($("#jsonTramites").val());
  document.getElementById('selectedChecks').value=JSON.stringify(checkedElements);
   $.each(checkedElements,function(i,value){
      $("#ch_"+value).prop("checked", true);
  });
}

function GuardarExcel()
{
  var JSONData=$("#jsonCode").val();
  JSONToCSVConvertor(JSONData, "Costos", true)
  
  
}
function addRemoveElement(element)
  {
      var eleStatus = $("#ch_"+element).prop("checked");
      //console.log(element);
      var checkedElements = $.parseJSON($("#selectedChecks").val());
      if(eleStatus == true)
      {
        checkedElements.push(element);
        $("#selectedChecks").val(JSON.stringify(checkedElements));
      }else{
        $.each(checkedElements,function(i,value){
            if(element == value){
              delete checkedElements[i];
            }
        });
        var filtered = checkedElements.filter(function (el) {
          return el != null;
        });
        $("#selectedChecks").val(JSON.stringify(filtered));      
      }
  }

$("#search").keyup(function(){
        _this = this;
        $.each($("#table2 tbody tr"), function() {
        if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
        $(this).hide();
        else
        $(this).show();
        });
    });

</script>
@endsection
