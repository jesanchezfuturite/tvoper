@extends('layout.app')


@section('content')
<link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<h3 class="page-title">Portal <small> Asignación de usuarios por Notaria </small></h3>
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
            <a href="#">Asignación de usuarios por Notaria</a>
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
                <i class="fa fa-bank"></i>Agregar Notaria
            </div>
            <div class="tools">                
              <a href="#portlet-notario" data-toggle="modal" class="config" data-original-title=""onclick="newNotary()" title="Nueva Notaria"></a>
              <a href="#portlet-notario" data-toggle="modal" class="tooltips" data-original-title="" title="Editar Notaria" onclick="editNotary()"><i class='fa fa-pencil edit-notary' style="color:#d7eaf8 !important;"></i></a>
             <!-- <a id="Remov" href="javascript:;" data-original-title="" title="">
                <i class='fa fa-remove' style="color:#d7eaf8 !important;"></i>
              </a>--->
            </div>
        </div>
        <div class="portlet-body">
        <div class="row">
          <!---<div class="col-md-2 col-ms-12">
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
            </div> -->           
          <div class="col-md-3 col-ms-12">
            <div class="form-group">
                <label >Notarias Registrados </label>  
                <span class="help-block">(Selecciona para ver los Perfiles)</span> 
            </div>
          </div>
          <div class="col-md-3 col-ms-12">
            <div class="form-group">           
              <select class="select2me form-control"name="itemsNotario" id="itemsNotario" onchange="changeNotario()">
                <option value="0">------</option>   
                </select>            
            </div>
          </div>    
        </div>
      </div>
    </div>
</div>
<!---<div class="row">
    <div class="portlet box blue iDocument">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-file-pdf-o"></i>&nbsp;Documentos
            </div>            
        </div>
        <div class="portlet-body">
        <div class="row">
          <div class="col-md-6 col-ms-12">
            <div class="form-group">
               <a id="downloadSAT" href="#" class="icon-btn" data-original-title="" title="Descargar Archivo">
                <i class="fa fa-file-pdf-o"></i>
                <div>
                 &nbsp;Descargar Constancia SAT&nbsp;
                </div>
              </a>&nbsp;&nbsp;
              <a id="downloadNotary" href="#" class="icon-btn" data-original-title="" title="Descargar Archivo">
                <i class="fa fa-file-pdf-o"></i>
                <div>
                  &nbsp;Descargar Constancia Notaria&nbsp;
                </div>
              </a>
            </div>
          </div>
          <div class="col-md-3 col-ms-12">
            <div class="form-group">
              
            </div>
          </div>          

        </div>
      </div>
    </div>
</div>-->
<div class="row perfilesHide">
 <!-- BEGIN SAMPLE TABLE PORTLET-->
  <div class="portlet box blue">
    <div class="portlet-title" >
      <div class="caption">
          <div id="borraheader">  <i class="fa fa-cogs"> </i>&nbsp;Administrar Usuarios</div>
      </div>
      <div class="tools">                
        <a href="#portlet-notario" data-toggle="modal" class="config" data-original-title="" title="Nuevo Perfil" onclick="configUser()"></a>
       <!-- <a id="Remov" href="javascript:;" data-original-title="" title=""><i class='fa fa-remove' style="color:#d7eaf8 !important;"></i></a>-->
      </div>           
    </div>
      <div class="portlet-body">
      <!--  <div class="row">
          <span class="help-block"></span>             
          <div class='col-md-12 text-right'>
          <div class='form-group'>                      
            <button class='btn blue' onclick='GuardarExcel()'><i class='fa fa-file-excel-o'></i> Descargar CSV</button> 
          </div>
      </div>
      <span class="help-block">&nbsp;</span>                              
    </div> -->
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
            <th>Opciones</th>
            <th>Documentos</th>
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

<!----------------------------------------- Nuevo Notario-------------------------------------------->
<div class="modal fade" id="portlet-notario" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
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
              <button type="submit" class="btn blue btn-save-Not" onclick="saveNotario()"><i class="fa fa-check"></i> Guardar</button>
              <button type="submit" class="btn blue btn-upd-Not" onclick="updateNotaria()"><i class="fa fa-check"></i> Guardar</button>
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
<div id="portlet-desactivaCuenta" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
             Ya Existe un Cuenta de <label id="lbl_permiso" style="color: #cb5a5e;"></label>
             <br>
             <br>
             Se desactivara la cuenta existente, ¿Continuar?

                </p>
            </div>
            <div class="modal-footer">
                <div id="AddbuttonDeleted">
         <button type="button" data-dismiss="modal" class="btn default">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="desactivaCuenta()">Confirmar</button>
        </div>
            </div>
        </div>
    </div>
</div>
<div id="portlet-del-cuenta" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
             Ya Existe un Cuenta de <label id="lbl_del_permiso" style="color: #cb5a5e;"></label>
             <br>
             <br>
             Desactive la cuenta primero.

                </p>
            </div>
            <div class="modal-footer">
                <div id="AddbuttonDeleted"><button type="button" data-dismiss="modal" class="btn default">Cancelar</button>
        <!--- 
            <button type="button" data-dismiss="modal" class="btn green" onclick="desactivaCuenta()">Confirmar</button><span class="help-block">&nbsp;</span>-->
            
        </div>
            </div>
        </div>
    </div>
</div>

<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
<input type="text" name="base64pdf1" id="base64pdf1" hidden="true">
<input type="text" name="base64pdf2" id="base64pdf2" hidden="true">
<input type="text" name="id_NotTitular" id="id_NotTitular" hidden="true">
<input type="text" name="id_NotSuplente" id="id_NotSuplente" hidden="true">
<input type="text" name="permisoEdit" id="permisoEdit" hidden="true">
<input type="text" name="arrayPermisos" id="arrayPermisos" hidden="true">
@endsection

@section('scripts')
<script src="assets/global/scripts/validar_pdf.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript">
  jQuery(document).ready(function() {
     $(".perfilesHide").css("display", "none");
     $(".edit-notary").css("display", "none");
     $(".btn-upd-Not").css("display", "none");
     $(".btn-saveup-User").css("display", "none");
     $(".input-permiso").css("display", "none");
     $(".input-checkbox-reenvio").css("display", "none");
    //$(".iDocument").css("display","none");
    changeComunidad();
    findentidades();
    TableManaged.init();
    ItemsComunidad();
    ItemsPermisos();    
  });
  function changePermiso() {
    if($("#itemsPermiso").val()==2){
      $(".section-archivos").css("display", "block");
     }else{
      $(".section-archivos").css("display", "none");
    }
  }
  function  usernameE(user,input) {
    valido = document.getElementById(input); 
    var formdata = new FormData();    
    if(input=="userError"){
      if(user.length>7)
      { 
        formdata.append("username",user);
        formdata.append("_token",'{{ csrf_token() }}');
        findUserEmail(formdata,input);
      }else{
        valido.innerText = "Incorrecto";
        valido.style.color = "red";
      }
      return;
    }     
  }
  function findUserEmail(formdata,input)
  {    
    valido = document.getElementById(input);
    if(input=="userError"){
      message="El nombre de usuario ya está en uso";
    }
    if(input=="emailOK"){
      message="El correo electrónico ya está en uso";
    }
    if(input=="emailNot"){
      message="El correo electrónico ya está en uso";
    }
    $.ajax({
        method: "POST", 
           contentType: false,
            processData: false,           
        url: "{{ url('/notary-offices-username') }}",
        data: formdata  })
        .done(function (response) { 
        //console.log(response); 

          var resp=$.parseJSON(response);
          if(resp.data=="error"){
            valido.innerText=resp.error.message;
            valido.style.color = "red";
          }else{
            valido.innerText="";
          }
        })
        .fail(function( msg ) {
         console.log("Error consulta Usuario/Email", "Notifications") 
         valido.innerText=message; 
         valido.style.color = "red"; });
  
  }
  function newNotary()
  {
     $(".section-notary").css("display", "block");
     $(".title-user").css("display", "block");
     $(".section-users").css("display", "block");
     $(".section-archivos").css("display", "block");     

     $(".input-comunidad").css("display", "block");
     $(".input-permiso").css("display", "none");
     $(".input-checkbox-reenvio").css("display", "none");

     $(".btn-save-Not").css("display", "block");
     $(".btn-saveup-User").css("display", "none");
     $(".btn-upd-Not").css("display", "none");
     document.getElementById("encabezado_modal").innerHTML = "Configuración Notaria"
     document.getElementById("itemsEntidadNot").disabled=false;
     document.getElementById("numNotario").disabled=false;
  }
  function editNotary()
  {
     $(".section-notary").css("display", "block");
     $(".title-user").css("display", "none");
     $(".section-users").css("display", "none");
     $(".section-archivos").css("display", "none");     

     $(".input-comunidad").css("display", "none");
     $(".input-permiso").css("display", "none");
     $(".input-checkbox-reenvio").css("display", "none");

     $(".btn-save-Not").css("display", "none");
     $(".btn-saveup-User").css("display", "none");
     $(".btn-upd-Not").css("display", "block");
     document.getElementById("encabezado_modal").innerHTML = "Configuración Notaria"
     findeditNotary();
  }
  function configUser()
  {
     $(".section-notary").css("display", "none");
     $(".title-user").css("display", "none");
     $(".section-users").css("display", "block");
     $(".section-archivos").css("display", "none");     

     $(".input-comunidad").css("display", "none");
     $(".input-permiso").css("display", "block");
    

     $(".btn-save-Not").css("display", "none");
     $(".btn-saveup-User").css("display", "block");
     $(".btn-upd-Not").css("display", "none");
     document.getElementById("encabezado_modal").innerHTML = "Configuración Usuario"
     selectPermiso_insert();
  }
  function findeditNotary()
  {
    document.getElementById("numNotario").disabled=true;
    var id_=$("#itemsNotario").val();
    $.ajax({
        method: "get",            
        url: "{{ url('/get-notary-offices/') }}"+"/"+id_,
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {  
          var resp=$.parseJSON(response); 
          //console.log(resp);
          document.getElementById("numNotario").value=resp.response.notary_office.notary_number;
          $("#itemsEntidadNot").val(resp.response.notary_office.federal_entity_id).change();          
          document.getElementById("calleNotario").value=resp.response.notary_office.street;
          document.getElementById("numeroExtNotario").value=resp.response.notary_office["outdoor-number"];
          document.getElementById("numeroNotario").value=resp.response.notary_office.number;
          document.getElementById("codigopostNotario").value=resp.response.notary_office.zip;
          document.getElementById("distritoNotario").value=resp.response.notary_office.district;
          document.getElementById("telNotario").value=resp.response.notary_office.phone;
          document.getElementById("emailNotario").value=resp.response.notary_office.email;
          chgopt(resp.response.notary_office.city_id);
          console.log(resp.response.notary_office.federal_entity_id);
          if(resp.response.notary_office.federal_entity_id==0)
          {
            document.getElementById("itemsEntidadNot").disabled=false;
          }else{
            document.getElementById("itemsEntidadNot").disabled=true;
          }
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error consulta curp", "Notifications")   });
  }
  async function chgopt(id)
  {  
    await sleep(1000);
    $("#itemsCiudadNot").val(id).change();
  }
  function findCurp()
  {
    var curp=$("#curpUser").val();
   $.ajax({
        method: "get",            
        url: "{{ url('/consultar-curp') }}"+"/"+curp,
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {  
          var resp=$.parseJSON(response); 
          if(resp.status=="ok")
          {
            document.getElementById("nameUser").value=resp.data.nombres;
            document.getElementById("apePatUser").value=resp.data.apePat;
            document.getElementById("apeMatUser").value=resp.data.apeMat;
            document.getElementById("nameUser").disabled=true ;
            document.getElementById("apePatUser").disabled=true;
            document.getElementById("apeMatUser").disabled=true;
          }else{
            document.getElementById("nameUser").disabled=false ;
            document.getElementById("apePatUser").disabled=false;
            document.getElementById("apeMatUser").disabled=false;
          }

        })
        .fail(function( msg ) {
         Command: toastr.warning("Error consulta curp", "Notifications")   });
  
  }
  function findentidades()
  {
  
   $.ajax({
        method: "get",            
        url: "{{ url('/obtener-estados') }}",
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {  
        var resp=$.parseJSON(response); 
        //console.log(response);  
            $("#itemsEntidadNot option").remove();
            $('#itemsEntidadNot').append("<option value='0'>------</option>");
            $.each(resp, function(i, item) { 
              if(item.clave>0 && item.clave<33) {             
                $('#itemsEntidadNot').append("<option value='"+item.clave+"'>"+item.nombre+"</option>");
              }
            });
            $("#itemsEntidadNot").val("19").change();

        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Cargar Select Rol", "Notifications")   });
  
}
function changeEntidades()
{
  var entidad=$("#itemsEntidadNot").val();
   $.ajax({
        method: "get",            
        url: "{{ url('/obtener-municipios') }}"+"/"+entidad,
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
        //console.log(response);  

          var resp=$.parseJSON(response);
            $("#itemsCiudadNot option").remove();
            $('#itemsCiudadNot').append("<option value='0'>------</option>");
            $.each(resp, function(i, item) {                
                $('#itemsCiudadNot').append("<option value='"+item.clave+"'>"+item.nombre+"</option>");
            });

        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Cargar Select Rol", "Notifications")   });
  
}
  function getBase64SAT(file) {
   var reader = new FileReader();
   reader.readAsDataURL(file);
   reader.onload = function () {
    document.getElementById("base64pdf1").value=reader.result;
    //console.log(reader.result);
     //return reader.result;
   };
   
}
function getBase64Notario(file) {
   var reader = new FileReader();
   reader.readAsDataURL(file);
   reader.onload = function () {
    document.getElementById("base64pdf2").value=reader.result;
    //console.log(reader.result);
     //return reader.result;
   };
   
}
//$('#downloadSAT').click(function(){ downloadPdf("sat"); return false; });
//$('#downloadNotary').click(function(){ downloadPdf("notary"); return false; });
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
  //var comunidad=$("#itemsConfigUser").val();
  var comunidad="4";
  //$("#itemsNotario").val("0").change();
  if(comunidad=="0")
  {
    $("#itemsNotario option").remove();
    $('#itemsNotario').append("<option value='0'>------</option>");
    $(".perfilesHide").css("display", "none");
    return;
  }
   $.ajax({
        method: "get",            
        url: "{{ url('/notary-offices-community') }}"+"/"+comunidad,
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) { 
          //console.log(response)
            var ent="";
            $("#itemsNotario option").remove();
            $('#itemsNotario').append("<option value='0'>------</option>");
            $.each(response, function(i, item) {  
                if(item.estado==null || item.estado=="null")
                  {ent="";}else{ent=" - "+item.estado.nombre;}
                $('#itemsNotario').append("<option value='"+item.id+"'>"+item.notary_number+ent+"</option>");
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
        document.getElementById("arrayPermisos").value=response;
          
        })
      .fail(function( msg ) {
         Command: toastr.warning("Error al Cargar Select Rol", "Notifications")   });
  }
  function selectPermiso_insert()
  { 
    $(".input-checkbox-reenvio").css("display", "none");
    var array=$("#arrayPermisos").val();
    var resp=$.parseJSON(array);
        $("#itemsPermiso option").remove();
        $('#itemsPermiso').append("<option value='0'>------</option>");
          $.each(resp.response, function(i, item) {
            if( item.name=="notary_titular" || item.name=="notary_substitute" || item.name=="notary_capturist" || item.name=="notary_payments" || item.name=="notary_capturist_payments"){
              $('#itemsPermiso').append("<option value='"+item.id+"'>"+item.description+"</option>");
            }
          });
          $("#itemsPermiso").val("0").change();
  }
  function selectPermiso_updateNotary(id_)
  { 
 $(".input-checkbox-reenvio").css("display", "block");
    var array=$("#arrayPermisos").val();
    var resp=$.parseJSON(array);
        $("#itemsPermiso option").remove();
        $('#itemsPermiso').append("<option value='0'>------</option>");
          $.each(resp.response, function(i, item) {
            if(item.name=="notary_titular" || item.name=="notary_substitute"){
              $('#itemsPermiso').append("<option value='"+item.id+"'>"+item.description+"</option>");
            }
          });
          $("#itemsPermiso").val(id_).change();

  }
  function selectPermiso_updateUser(id_)
  {  $(".input-checkbox-reenvio").css("display", "block");
    var array=$("#arrayPermisos").val();
    var resp=$.parseJSON(array);
        $("#itemsPermiso option").remove();
        $('#itemsPermiso').append("<option value='0'>------</option>");
          $.each(resp.response, function(i, item) {
            if( item.name=="notary_capturist" || item.name=="notary_payments" || item.name=="notary_capturist_payments"){
              $('#itemsPermiso').append("<option value='"+item.id+"'>"+item.description+"</option>");
            }
          });
          $("#itemsPermiso").val(id_).change();
  }
  function ItemsComunidad()
    {
        $.ajax({
        method: "get",            
        url: "{{ url('/operacion-roles-get-rol') }}",
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
            $("#itemsCofigNotario option").remove();
            //$("#itemsConfigUser option").remove();
            $('#itemsCofigNotario').append("<option value='0'>------</option>");
            //$('#itemsConfigUser').append("<option value='0'>------</option>");
            $.each(response, function(i, item) {                
                $('#itemsCofigNotario').append("<option value='"+item.id+"'>"+item.descripcion+"</option>");
                //$('#itemsConfigUser').append("<option value='"+item.id+"'>"+item.descripcion+"</option>");
            });
            $("#itemsCofigNotario").val("4").change();
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Cargar Select Rol", "Notifications")   });
  }
  function updateFile()
  {
     var id_=$("#itemsNotario").val();
    var base64SAT=$("#base64pdf1").val();
    var base64Notario=$("#base64pdf2").val();
    var numeroNotario=$("#itemsNotario option:selected").text();
    var splitNum=numeroNotario.split(" - ");
    numNotario=splitNum[0];
    var formdata = new FormData();
      formdata.append("id", id_);      
      formdata.append("notary_number", numNotario);    
      formdata.append("sat_constancy_file", base64SAT);  
      formdata.append("notary_constancy_file", base64Notario);
    
    formdata.append("_token",'{{ csrf_token() }}');
    //console.log(Object.fromEntries(formdata));
    if(base64SAT.length>0 || base64Notario.length>0)
      {saveChangeNotary(formdata);}
    //chgoptionNotary(id_);

        
  }
  function updateNotaria()
  {
     var id_=$("#itemsNotario").val();
     var numNotario=$("#numNotario").val();
    var telNotario=$("#telNotario").val();
    var emailNotario=$("#emailNotario").val();
    var calleNotario=$("#calleNotario").val();
    var numeroNotario=$("#numeroNotario").val();
    var numeroExtNotario=$("#numeroExtNotario").val();
    var distritoNotario=$("#distritoNotario").val();
    var itemsCiudadNot=$("#itemsCiudadNot").val();
    var itemsEntidadNot=$("#itemsEntidadNot").val();
    var codigopostNotario=$("#codigopostNotario").val();
    var base64SAT=$("#base64pdf1").val();
    var base64Notario=$("#base64pdf2").val();
    emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    if (numNotario.length<1) {
       Command: toastr.warning("Campo Numero Notaria, requerido!", "Notifications") 
       $("#numNotario").focus();
    }else if(itemsEntidadNot=="0"){
      Command: toastr.warning("Campo Entidad Federativa, requerido!", "Notifications")
    }else if(itemsCiudadNot=="0"){
      Command: toastr.warning("Campo Ciudad, requerido!", "Notifications")
    }else if (calleNotario.length<3) {
       Command: toastr.warning("Campo Calle min. 3 caracteres, requerido!", "Notifications") 
       $("#calleNotario").focus(); 
    }else if (numeroExtNotario.length<1) {
       Command: toastr.warning("Campo Número Exterior, requerido!", "Notifications")
       $("#numeroExtNotario").focus(); 
    }else if (codigopostNotario.length<5) {
       Command: toastr.warning("Campo Codigo Postal, longitud minima 5!", "Notifications")
       $("#codigopostNotario").focus(); 
    }else if (distritoNotario.length<1) {
       Command: toastr.warning("Campo Colonia, requerido!", "Notifications") 
       $("#distritoNotario").focus(); 
    }else if (telNotario.length<10) {
       Command: toastr.warning("Campo Numero Teléfono, longitud minima 10!", "Notifications")
       $("#telNotario").focus();  
    }else if (!emailRegex.test(emailNotario)) {
       Command: toastr.warning("Campo Correo Electrónico, formato incorrecto!", "Notifications") 
        $("#emailNotario").focus();
    }else{
      var formdata = new FormData();
        formdata.append("id", id_);      
        formdata.append("notary_number", numNotario);      
        formdata.append("phone", telNotario);
        formdata.append("email", emailNotario);
        formdata.append("street", calleNotario);
        formdata.append("number", numeroNotario);
        formdata.append("outdoor-number", numeroExtNotario);
        formdata.append("district", distritoNotario);
        formdata.append("federal_entity_id", itemsEntidadNot);
        formdata.append("city_id", itemsCiudadNot);
        
        /*if(base64SAT.length>0 ){ 
          formdata.append("sat_constancy_file", base64SAT);        
        }if(base64Notario.length>0){ 
          formdata.append("notary_constancy_file", base64Notario);
        }*/
        formdata.append("_token",'{{ csrf_token() }}');
        saveChangeNotary(formdata);
        changeComunidad();
        chgoptionNotary(id_);

    }     
  }
  async function chgoptionNotary(id)
  {  
    await sleep(2000);
    $("#itemsNotario").val(id).change();
  }
  function saveChangeNotary(formdata)
  {
    //console.log(Object.fromEntries(formdata));
    $.ajax({
           method: "POST", 
           contentType: false,
            processData: false,
           url: "{{ url('/notary-offices-update') }}",
           data:formdata })
        .done(function (response) {
          var resp=$.parseJSON(response);
         //console.log(resp);
          
          if(response==null || response=="null")
          {
            Command: toastr.success("Success", "Notifications");
            return;
          }
          if(resp.data=="response"){
            Command: toastr.success("Success", "Notifications");
            return;
          }
          if(resp.error){
            Command: toastr.warning(resp.error.message, "Notifications");
          }else{
            Command: toastr.success("Success", "Notifications");
            return;
          }         
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
  }

  function saveNotario()
  {
    var numNotario=$("#numNotario").val();
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
    
    var users=$("#users").val();
      var emailUser=$("#emailUser").val();
      var password=$("#password").val();      
      var nameUser=$("#nameUser").val();
      var apeMatUser=$("#apeMatUser").val();
      var apePatUser=$("#apePatUser").val();      
      var curpUser=$("#curpUser").val();      
      var rfcUser=$("#rfcUser").val();
      //var itemsConfigUser=$("#itemsConfigUser").val();
      var telUser=$("#telUser").val();
    //var itemsPermisoNotario=$("#itemsPermisoNotario").val();
    var pdfSAT = $("#fileSAT").val(); 
    var pdfNotario = $("#fileNotario").val();
      
    emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    
    if (numNotario.length<1) {
       Command: toastr.warning("Campo Numero Notaria, requerido!", "Notifications") 
       $("#numNotario").focus();
    }else if(itemsEntidadNot=="0"){
      Command: toastr.warning("Campo Entidad Federativa, requerido!", "Notifications")
      //$("#itemsEntidadNot").focus(); 
    }else if(itemsCiudadNot=="0"){
      Command: toastr.warning("Campo Ciudad, requerido!", "Notifications")
      //$("#itemsCiudadNot").focus(); 
    }else if (calleNotario.length<3) {
       Command: toastr.warning("Campo Calle min. 3 caracteres, requerido!", "Notifications") 
       $("#calleNotario").focus(); 
    }else if (numeroExtNotario.length<1) {
       Command: toastr.warning("Campo Número Exterior, requerido!", "Notifications")
       $("#numeroExtNotario").focus(); 
    }else if (codigopostNotario.length<5) {
       Command: toastr.warning("Campo Codigo Postal, longitud minima 5!", "Notifications")
       $("#codigopostNotario").focus(); 
    }else if (distritoNotario.length<1) {
       Command: toastr.warning("Campo Colonia, requerido!", "Notifications") 
       $("#distritoNotario").focus(); 
    }else if (telNotario.length<10) {
       Command: toastr.warning("Campo Numero Teléfono, longitud minima 10!", "Notifications")
       $("#telNotario").focus();  
    }else if (!emailRegex.test(emailNotario)) {
       Command: toastr.warning("Campo Correo Electrónico, formato incorrecto!", "Notifications") 
        $("#emailNotario").focus();
    }else if (!curpValida(curpUser)) {
       Command: toastr.warning("Campo CURP, formato incorrecto!", "Notifications") 
       $("#curpUser").focus(); 
    }else if (nameUser.length<1) {
      Command: toastr.warning("Campo Nombre, requerido!", "Notifications")
        $("#nameUser").focus();  
    }else if (apePatUser.length<1) {
        Command: toastr.warning("Campo Apellido Paterno, requerido!", "Notifications") 
        $("#apePatUser").focus(); 
    }else if (apeMatUser.length<1) {
        Command: toastr.warning("Campo Apellido Materno, requerido!", "Notifications") 
        $("#apeMatUser").focus(); 
    }else if (rfcUser.length<13) {
        Command: toastr.warning("Campo RFC, longitud minima 13!", "Notifications")
        $("#rfcUser").focus();  
    }else if (telUser.length<10) {
        Command: toastr.warning("Campo Numero Teléfono, longitud minima 10!", "Notifications") 
        $("#telUser").focus(); 
    }else if (!emailRegex.test(emailUser)) {
        Command: toastr.warning("Campo Correo Electrónico, formato incorrecto!", "Notifications")
        $("#emailUser").focus(); 
    }else if(users.length < 8){
        Command: toastr.warning("Campo Usuario, mini. 8 caracteres", "Notifications") 
        $("#users").focus();
    }else if( !/[a-z]/.test(password) || !/[A-Z]/.test(password) || !/[0-9]/.test(password) || password.length < 8){
      Command: toastr.warning("Campo Contraseña, formato incorrecto!", "Notifications") 
        $("#password").focus();      
    }else if(pdfSAT.length==0){ 
         Command: toastr.warning("Archivo Constancia SAT, Requerido!", "Notifications")
    }else if(pdfNotario.length==0){ 
         Command: toastr.warning("Archivo Constancia Notaria, Requerido!", "Notifications")
    }else{
     //await sleep(1000);
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
    
    //var itemsPermisoNotario=$("#itemsPermisoNotario").val();
    var users=$("#users").val();
      var emailUser=$("#emailUser").val();
      var password=$("#password").val();      
      var nameUser=$("#nameUser").val();
      var apeMatUser=$("#apeMatUser").val();
      var apePatUser=$("#apePatUser").val();      
      var curpUser=$("#curpUser").val();      
      var rfcUser=$("#rfcUser").val();
      //var itemsConfigUser=$("#itemsConfigUser").val();
      var telUser=$("#telUser").val();
      var TipoUser=$("#itemsTipoUser").val();
      var itemsCofigNotario=$("#itemsCofigNotario").val();
      var itemsPermiso=$("#itemsPermiso").val();

    var base64SAT=$("#base64pdf1").val();
    var base64Notario=$("#base64pdf2").val();

   
    var titular_={username: users,
                email: emailUser,
                password: password,
                name: nameUser,
                mothers_surname: apeMatUser,
                fathers_surname: apePatUser,
                curp: curpUser,
                rfc: rfcUser,
                phone: telUser,
                person_type: TipoUser,
                config_id: itemsCofigNotario,
                role_id: 2 };

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
          //console.log(response);
          var resp=$.parseJSON(response);
          //console.log(resp);
          if(resp.response.code=="422"){
             Command: toastr.warning(resp.response.message, "Notifications");
            return;
          }else{
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
         
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    
  }
  function changeNotario()
  {
    var id=$("#itemsNotario").val();
    //var com=$("#itemsConfigUser").val();
    var com=4;
    if(id=="0")
    {
      //$(".iDocument").css("display","none");
      $(".edit-notary").css("display", "none");
      $(".perfilesHide").css("display", "none");
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
    $(".edit-notary").css("display", "block");
    //$(".iDocument").css("display","block");
    $.ajax({
           method: "get",            
           url: "{{ url('/notary-offices-get-users') }}"+"/"+id,
           data: {_token:'{{ csrf_token() }}'}   })
        .done(function (response) { 
          //console.log(response);
          document.getElementById('jsonCode').value=response;            
          var Resp=response;
          addtable();
          $(".perfilesHide").css("display", "block");
          btn_download="";
          btn_desact="";
          document.getElementById('id_NotTitular').value="";
          document.getElementById('id_NotSuplente').value="";
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
              if(item.role_id==5 && status=="1")
              {
                document.getElementById('id_NotSuplente').value=item.id;
              }              
              if(item.role_id==2 && status=="1")
              {
                document.getElementById('id_NotTitular').value=item.id;
                btn_download="<a class='btn btn-icon-only yellow' href='#' data-toggle='modal' data-original-title='' title='Descargar Constancia SAT' onclick='downloadPdf(\"sat\")'><i class='fa fa-file-pdf-o'></i></a><a class='btn btn-icon-only yellow' data-toggle='modal' href='#'  title='Descargar Constancia Notaria' onclick='downloadPdf(\"notary\")'><i class='fa fa-file-pdf-o'></i></a>";
                btn_desact="</a><a class='btn btn-icon-only default' data-toggle='modal' href='#'  title='No Aplica')'><i class='fa fa-power-off'></i></a>";
              }else{
                btn_download=""; 
                btn_desact="</a><a class='btn btn-icon-only "+icon+"' data-toggle='modal' href='#'  title='"+title+"' onclick='perfilDelete(\""+item.id+"\",\""+item.status+"\",\""+item.role_id+"\")'><i class='fa fa-power-off'></i></a>";               
              }
              role=item.roles; 
              $('#sample_3 tbody').append("<tr>"
                +"<td>"+role.description+"</td>"
                +"<td>"+item.username+"</td>"
                +"<td>"+item.email+"</td>"
                +"<td>"+item.name+" "+item.fathers_surname+" "+item.mothers_surname+"</td>"
                +"<td>"+item.rfc+"</td>"
                +"<td>"+item.curp+"</td>"
                +"<td>&nbsp;<span class='label label-sm label-"+label+"'>"+msgg+"</span></td>"
                + "<td class='text-center' width='15%'><a class='btn btn-icon-only blue' href='#portlet-notario' data-toggle='modal' data-original-title='' title='Editar' onclick='"+"perfilUpdate("+json+")'><i class='fa fa-pencil'></i>"+btn_desact+"</td>"
                + "<td class='text-center' width='15%'>"+btn_download+"</td>"
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
    $("#addtables").append("<table class='table table-hover' id='sample_3'> <thead><tr><th>Tipo Rol</th><th>Usuario</th><th>Correo Electrónico</th> <th>Nombre</th><th>RFC</th><th>Curp</th><th>Status</th><th>&nbsp;&nbsp;Opciones&nbsp;</th><th>Documentos</th></tr> </thead> <tbody></tbody> </table>");
     //TableManaged3.init3();

  }

  function perfilDelete(id,status,role_id)
  {
    var id_NotTitular=$("#id_NotTitular").val();
    var id_NotSuplente=$("#id_NotSuplente").val();
    document.getElementById('idregistro').value=id;
    document.getElementById('status').value=status;
    if(status==1)
    {$('#portlet-deleted').modal('show');
     
    }else{
      if(role_id==2 && id_NotTitular.length>0){
        $('#lbl_del_permiso').text("Nortario Titular");
        $('#portlet-del-cuenta').modal('show');
      }else if(role_id==5 && id_NotSuplente.length>0)
      {
        $('#lbl_del_permiso').text("Nortario Suplente");
        $('#portlet-del-cuenta').modal('show');
      }else{
        $('#portlet-deleted').modal('show')
      }
      

    }
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
   configUser();
    //$("#itemsTipoUser").val("0").change();
    selectPermiso_updateNotary();
    //$("#itemsPermiso").val(json.role_id).change();
    //$("#itemsConfigUser").val(json.config_id).change();
      document.getElementById('permisoEdit').value=json.role_id; 
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
      if(json.role_id==2 && json.status==1)
      {
        document.getElementById("itemsPermiso").disabled=true; 
      }else{
        document.getElementById("itemsPermiso").disabled=false;
        
      }
      if(json.role_id==2 || json.role_id==5)
      {
        selectPermiso_updateNotary(json.role_id);
      }else{
        selectPermiso_updateUser(json.role_id);
        $(".section-archivos").css("display", "none");
      }
      document.getElementById("nameUser").disabled=true;
      document.getElementById("apePatUser").disabled=true;
      document.getElementById("apeMatUser").disabled=true;

  }
  function updatePerfil()
  {    
    var id_notary=$("#itemsNotario").val();
    var id_user=$("#idperfil").val();
      var TipoUser=$("#itemsTipoUser").val();      
      var users=$("#users").val();
      var emailUser=$("#emailUser").val();
      var telUser=$("#telUser").val();
      var nameUser=$("#nameUser").val();
      var apePatUser=$("#apePatUser").val();
      var apeMatUser=$("#apeMatUser").val();
      var curpUser=$("#curpUser").val();
      var rfcUser=$("#rfcUser").val();
      var password_=$("#password").val();
      var itemsConfigUser=$("#itemsCofigNotario").val();
      var itemsPermiso=$("#itemsPermiso").val();
      var base64SAT=$("#base64pdf1").val();
      var base64Notario=$("#base64pdf2").val();
      var check=$("#checkbox1").prop("checked"); 
      var user_={username: users,
                email: emailUser,
                name: nameUser,
                mothers_surname: apeMatUser,
                fathers_surname: apePatUser,
                curp: curpUser,
                rfc: rfcUser,
                phone: telUser,
                config_id: itemsConfigUser,
                role_id: itemsPermiso,
                status: 1,
                reenvio:check
            };
      if(check==true || password_.length>0)
      {
        if(!/[a-z]/.test(password_) || !/[A-Z]/.test(password_) || !/[0-9]/.test(password_) || password_.length < 8){
          Command: toastr.warning("Campo Contraseña, formato incorrecto!", "Notifications")
          $("#password").focus();  
          return;
        }
        Object.assign(user_,{password:password_});        
      }
      if(base64SAT.length>0)
      {
        Object.assign(user_,{sat_constancy_file:base64SAT});
      } 
       if(base64Notario.length>0)
      {
        Object.assign(user_,{notary_constancy_file:base64Notario});
      }
      console.log(user_);
      $.ajax({
           method: "POST",           
           url: "{{ url('/notary-offices-edit-user') }}",
           data: {notary_id:id_notary,user_id:id_user,user:user_ ,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {          
             //limpiarNot();
             Command: toastr.success("Success", "Notifications")
             changeNotario();

        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
  function saveUpdatePerf()
  {   
      var id_NotTitular=$("#id_NotTitular").val();
      var id_NotSuplente=$("#id_NotSuplente").val();
      var id_notary=$("#itemsNotario").val();
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
      var itemsConfigUser=4;
      var itemsPermiso=$("#itemsPermiso").val();
      var permisoEdit=$("#permisoEdit").val();
      var namePermiso=$("#itemsPermiso option:selected").text();
          emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;  
      var base64SAT=$("#base64pdf1").val();
      var base64Notario=$("#base64pdf2").val();
      var check=$("#checkbox1").prop("checked");   
      if(id_notary=='0'){
        Command: toastr.warning("Selecciona Nortario, requerido!", "Notifications") 
      }else if (!curpValida(curpUser)) {
       Command: toastr.warning("Campo CURP, formato incorrecto!", "Notifications") 
       $("#curpUser").focus(); 
      }else if (nameUser.length<1) {
        Command: toastr.warning("Campo Nombre, requerido!", "Notifications")
        $("#nameUser").focus();  
      }else if (apePatUser.length<1) {
        Command: toastr.warning("Campo Apellido Paterno, requerido!", "Notifications") 
        $("#apePatUser").focus(); 
      }else if (apeMatUser.length<1) {
        Command: toastr.warning("Campo Apellido Materno, requerido!", "Notifications") 
        $("#apeMatUser").focus(); 
      }else if (rfcUser.length<13) {
        Command: toastr.warning("Campo RFC, longitud minima 13!", "Notifications")
        $("#rfcUser").focus();  
      }else if (telUser.length<10) {
        Command: toastr.warning("Campo Numero Teléfono, longitud minima 10!", "Notifications") 
        $("#telUser").focus(); 
      }else if (!emailRegex.test(emailUser)) {
        Command: toastr.warning("Campo Correo Electrónico, formato incorrecto!", "Notifications")
        $("#emailUser").focus(); 
      }else if(users.length < 8){
        Command: toastr.warning("Campo Usuario, mini. 8 caracteres", "Notifications") 
        $("#users").focus();
      }else if(itemsPermiso =='0'){
        Command: toastr.warning("Campo Permiso, requerido!", "Notifications") 
      }else{        
        if(id.length>0)
          {
            if(check==true){
              if(password.length<1)
              { Command: toastr.warning("Campo Contraseña, requerido!", "Notifications") 
                $("#password").focus();
                return;
              }
              if(!/[a-z]/.test(password) || !/[A-Z]/.test(password) || !/[0-9]/.test(password) || password.length < 8){
                Command: toastr.warning("Campo Contraseña, formato incorrecto!", "Notifications")
                $("#password").focus();  
                return;
              }
            }
            if(id==id_NotSuplente && itemsPermiso==permisoEdit){
              updatePerfil();
            }else if(id==id_NotTitular && itemsPermiso==permisoEdit){
              updatePerfil(); 
            }else if(itemsPermiso==2 && id_NotTitular.length>0)
            {    
              if(base64SAT.length==0)
              {
                Command: toastr.warning("Archivo Constancia SAT, requerido!", "Notifications")
              }else if(base64Notario.length==0){
                Command: toastr.warning("Archivo Constancia Notaria, requerido!", "Notifications")
              }else{
                $('#portlet-desactivaCuenta').modal('show');
                $('#lbl_permiso').text(namePermiso);  
              }
            }else if(itemsPermiso==5 && id_NotSuplente.length>0)
            {             
                $('#portlet-desactivaCuenta').modal('show');
                $('#lbl_permiso').text(namePermiso);             
            }else{
              updatePerfil();
            }            
          }else{
            if(itemsPermiso==2 && id_NotTitular.length>0)
            {    
              if(base64SAT.length==0)
              {
                Command: toastr.warning("Archivo Constancia SAT, requerido!", "Notifications")
              }else if(base64Notario.length==0){
                Command: toastr.warning("Archivo Constancia Notaria, requerido!", "Notifications")
              }else{
                $('#portlet-desactivaCuenta').modal('show');
                $('#lbl_permiso').text(namePermiso);  
              }
            }else if(itemsPermiso==5 && id_NotSuplente.length>0)
            {             
                $('#portlet-desactivaCuenta').modal('show');
                $('#lbl_permiso').text(namePermiso);
            }else{
              insertPerfil();
            }
          }
      }
  }
  function insertPerfil()
  {
      var id_notary=$("#itemsNotario").val();
      
      var users=$("#users").val();
      var emailUser=$("#emailUser").val();
      var password=$("#password").val();      
      var nameUser=$("#nameUser").val();
      var apeMatUser=$("#apeMatUser").val();
      var apePatUser=$("#apePatUser").val();      
      var curpUser=$("#curpUser").val();      
      var rfcUser=$("#rfcUser").val();
      //var itemsConfigUser=$("#itemsConfigUser").val();
      var telUser=$("#telUser").val();
      var TipoUser=$("#itemsTipoUser").val();
      var itemsConfigUser=$("#itemsCofigNotario").val();;
      var itemsPermiso=$("#itemsPermiso").val();
      if(!/[a-z]/.test(password) || !/[A-Z]/.test(password) || !/[0-9]/.test(password) || password.length < 8){
        Command: toastr.warning("Campo Contraseña, formato incorrecto!", "Notifications")
        $("#password").focus();  
        return;
      }
      var base64SAT=$("#base64pdf1").val();
      var base64Notario=$("#base64pdf2").val();
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
            
        if(base64SAT.length>0 && base64Notario.length>0)
      {
        Object.assign(user_,{sat_constancy_file:base64SAT,notary_constancy_file:base64Notario});
      }  
      $.ajax({
           method: "POST",            
           url: "{{ url('/notary-offices-create-users') }}",
           data: {notary_id:id_notary,users:user_ ,_token:'{{ csrf_token() }}'}  })
        .done(function (response) { 
          //console.log(response);
          response=$.parseJSON(response);  
             if(response==null || response.data=="error")
             {  var error=response.error;
               Command: toastr.warning(error.message, "Notifications")
               return;
             }
             limpiarNot();
             Command: toastr.success("Success", "Notifications")
             changeNotario();
             //console.log(response);
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    
  }
  function desactivaCuenta()
  {
    var itemsPermiso=$("#itemsPermiso").val();
    var idperfil=$("#idperfil").val();
    var id_="";
    var id_notary=$("#itemsNotario").val();
     if(itemsPermiso==2)
     {
      id_=$("#id_NotTitular").val();
      
     }
     if(itemsPermiso==5)
     {
      id_=$("#id_NotSuplente").val();
     }
     if(idperfil.length>0)
            {
              updatePerfil();
            }else{
              
              insertPerfil();
            }
    /*$.ajax({
           method: "POST",            
           url: "{{ url('/notary-offices-user-status') }}",
           data: {notary_id:id_notary,user_id:id_,status:0, _token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
          
        })
        .fail(function( msg ) {
                 Command: toastr.warning("No Success", "Notifications")  });*/
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
    //$("#itemsCofigNotario").val("0").change();
    $("#itemsEntidadNot").val("19").change();
    document.getElementById('codigopostNotario').value="";
    //$("#itemsTipoUser").val("0").change();
      //$("#itemsPermiso").val("0").change();
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
      document.getElementById('permisoEdit').value="";
      document.getElementById("itemsPermiso").disabled=false; 
    //$("input:radio").attr("checked", false);
    document.getElementById('base64pdf1').value="";
    document.getElementById('base64pdf2').value="";
    document.getElementById('delFileNotario').click();
    document.getElementById('delFileSAT').click();
    document.getElementById('numeroExtNotario').value="";
    document.getElementById("nameUser").disabled=false ;
    document.getElementById("apePatUser").disabled=false;
    document.getElementById("apeMatUser").disabled=false;
    document.getElementById('emailNot').innerText="";
    document.getElementById('emailOK').innerText="";
    document.getElementById('userError').innerText="";
    $("#checkbox1").prop("checked", false);
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
    var formdata = new FormData();        
    emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    if (emailRegex.test(campo.value)) {
      formdata.append("email",campo.value);
        formdata.append("_token",'{{ csrf_token() }}');
        valido.innerText = "";
        findUserEmail(formdata,"emailOK");
    } else {
      valido.innerText = "Incorrecto";
      document.getElementById("emailOK").style.color = "red";
    }
});
document.getElementById('emailNotario').addEventListener('input', function() {
    campo = event.target;
    valido = document.getElementById('emailNot'); 
    var formdata = new FormData();       
    emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    if (emailRegex.test(campo.value)) {
        formdata.append("email",campo.value);
        formdata.append("_token",'{{ csrf_token() }}');
        valido.innerText = "";
         findUserEmail(formdata,"emailNot");
    } else {
      valido.innerText = "Incorrecto";
      document.getElementById("emailNot").style.color = "red";
    }
});
function curpValida(curp) {
    var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
        validado = curp.match(re);
  
    if (!validado)  //Coincide con el formato general?
      return false;
    
    //Validar que coincida el dígito verificador
    /*function digitoVerificador(curp17) {
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
      return false;*/
        
    return true; //Validado
}
function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
  }
function gPasswordPerf()
{
  var caracteres = "abcdefghijkmnpqrtuvwxyzABCDEFGHJKMNPQRTUVWXYZ123467890";
  var pass = "";
  for (i=0; i<16; i++) pass +=caracteres.charAt(Math.floor(Math.random()*caracteres.length));
  document.getElementById("password").value=pass;
}
function rfcValido(rfc, aceptarGenerico = false) {
    const re       = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A-Z\d])$/;
    var   validado = rfc.match(re);
    if (!validado)
        return false;
   /* const digitoVerificador = validado.pop(),
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
    return rfcSinDigito + digitoVerificador;*/
    return true;
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
function validarCurpUser() {
    var curp=$("#curpUser").val();
    rfcCorrecto=curpValida(curp.toUpperCase());
    valido = document.getElementById('curpUs'); 
    if (rfcCorrecto) {
      valido.innerText = "";
      findCurp();
    } else {
      valido.innerText = "Incorrecto";
      document.getElementById("curpUs").style.color = "red";
      document.getElementById("nameUser").disabled=false ;
      document.getElementById("apePatUser").disabled=false;
      document.getElementById("apeMatUser").disabled=false;
    }
}
$("#fileSAT").change(function(){
    var pdf = $("#fileSAT")[0].files[0]; 
    if(this.files.length==0)
    {      
      document.getElementById('base64pdf1').value="";    
    }else{
      getBase64SAT(pdf);
    }
});
$("#fileNotario").change(function(){  
    var pdf = $("#fileNotario")[0].files[0];
    if(this.files.length==0)
    {      
      document.getElementById('base64pdf2').value="";
    }else{
      getBase64Notario(pdf);
    }
    
});

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
