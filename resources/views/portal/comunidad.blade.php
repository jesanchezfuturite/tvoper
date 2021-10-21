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
                  <select class="select2me form-control"name="itemsRoles" id="itemsRoles" onchange="changeComunidad()">
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
               <a href="#portlet-user" data-toggle="modal" class="tooltips" data-original-title="" title="Nuevo Perfil" onclick="newNotary()"><i class='fa fa-user' style="color:#d7eaf8 !important;"></i></a>
               <a href="#portlet-user" data-toggle="modal" class="tooltips" data-original-title="" title="Editar Perfil" onclick="editNotary()"><i class='fa fa-pencil edit-notary' style="color:#d7eaf8 !important;"></i></a>
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
                <select class="select2me form-control"name="itemsNotario" id="itemsNotario" onchange="changeNotario()">
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
                <select class="select2me form-control"name="itemsPerm" id="itemsPerm">
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
        <a href="#portlet-user" data-toggle="modal" class="tooltips" data-original-title="" title="Agregar Usuario"  onclick="configUser()"><i class='fa fa-user' style="color:#d7eaf8 !important;"></i></a>
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
        <h3 class="modal-title" id="encabezado_modal">Configuración Usuario</h3>        
      </div>
      <div class="modal-body">
      <div class="section-notary">
        <div class="row">
          <div class="col-md-12">
            <div class="portlet-body form">
              <div class="form-body">
                <h4 class="form-section"><strong>Datos generales</strong></h4>
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
                <h4 class="form-section"><strong>Datos del titular</strong></h4>
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
<div class="modal fade" id="portlet-rol" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"data-dismiss="modal" aria-hidden="true" onclick="limpiarRol()"></button>
        <h4 class="modal-title">Configuracion Comunidad</h4>
        <input type="text" name="id_rol" id="id_rol" hidden="true">
      </div>
      <div class="modal-body">
        <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-12"> 
              <div class="form-group">
                <label >Nombre</label>                                             
                <input type="text" class="form-control" name="nameComunidad" id="nameComunidad" placeholder="Ingrese Nombre de la Comunidad...">
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

<input type="text" name="jsonTramites" id="jsonTramites"  value="[]" hidden="true">
<input type="text" name="jsonCode" id="jsonCode" hidden="true">
<input type="text" name="selectedChecks" id="selectedChecks" value="[]" hidden="true">
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
    ItemsPermisos();
    findTramites();   
    findentidades();
    TableManaged.init();
    ItemsComunidad();
    //SelectItemsPermisos();
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
   function changePermiso() {
    if($("#itemsPermiso").val()==2){
      $(".section-archivos").css("display", "block");
     }else{
      $(".section-archivos").css("display", "none");
    }
  }
   function findentidades()
  {
  
   $.ajax({
        method: "get",            
        url: "{{ url()->route('obtener-estados') }}",        
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
  function ItemsComunidad()
    {
        $.ajax({
        method: "get",            
        url: "{{ url()->route('operacion-roles-get-rol') }}",        
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
           
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Cargar Select Rol", "Notifications")   });
  }
function changeEntidades()
{
  var entidad=$("#itemsEntidadNot").val();
  var url="{{ url()->route('obtener-municipios', ':entidad') }}";
  var urlnew=  url.replace(':entidad', entidad);
   $.ajax({
        method: "get",            
        url: urlnew,
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
  function deleteRol()
  { 
    var id_=$("#itemsRoles").vall();
     var rolMember=$("#itemsRoles option:selected").text();
      //document.getElementById('idrol').innerHTML =rolMember;

  }
    function ItemsPermisos()
  {
    $.ajax({
      method: "get",            
      url: "{{ url()->route('notary-offices-roles') }}",      
      data: {_token:'{{ csrf_token() }}'}  })
      .done(function (response) { 
        document.getElementById("arrayPermisos").value=JSON.stringify(response);
          SelectItemsPermisos();
        })
      .fail(function( msg ) {
         Command: toastr.warning("Error al Cargar Select Rol", "Notifications")   });
  }
  function SelectItemsPermisos()
  { 
    var array=$("#arrayPermisos").val();
        $("#itemsPerm option").remove();
        $('#itemsPerm').append("<option value='0'>------</option>");
          $.each($.parseJSON(array), function(i, item) {
            if(item.name.match("titular")){
              $('#itemsPerm').append("<option value='"+item.id+"'>"+item.description+"</option>");            
            }
          });
          $("#itemsPerm").val("0").change();
  }
  function selectPermiso_insert()
  { 
    $(".input-checkbox-reenvio").css("display", "none");
    var array=$("#arrayPermisos").val();
        $("#itemsPermiso option").remove();
        $('#itemsPermiso').append("<option value='0'>------</option>");
          $.each($.parseJSON(array), function(i, item) {
            if( item.name=="notary_titular" || item.name=="notary_substitute" || item.name=="notary_capturist" || item.name=="notary_payments" || item.name=="notary_capturist_payments"){
              $('#itemsPermiso').append("<option value='"+item.id+"'>"+item.description+"</option>");
            }
          });
          $("#itemsPermiso").val("0").change();
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
      }else if (apeMatUser.length<1 && apePatUser.length<1) {
        Command: toastr.warning("Campo Apellido Materno/Paterno, requerido!", "Notifications") 
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
    }else if (apePatUser.length<1 && apeMatUser.length<1) {
        Command: toastr.warning("Campo Apellido Materno/Paterno, requerido!", "Notifications") 
        $("#apePatUser").focus(); 
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
        formdata.append("indoor-number", numeroExtNotario);
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
  function findeditNotary()
  {
    document.getElementById("numNotario").disabled=true;
    var id_=$("#itemsNotario").val();
    var url="{{ url()->route('get-notary-offices', ':id') }}";
    var urlnew=  url.replace(':id', id_);

    $.ajax({
        method: "get",            
        url: urlnew,
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {  
          var resp=$.parseJSON(response); 
          //console.log(resp);
          document.getElementById("numNotario").value=resp.response.notary_office.notary_number;
          $("#itemsEntidadNot").val(resp.response.notary_office.federal_entity_id).change();          
          document.getElementById("calleNotario").value=resp.response.notary_office.street;
          document.getElementById("numeroNotario").value=resp.response.notary_office["indoor-number"];
          document.getElementById("numeroExtNotario").value=resp.response.notary_office.number;
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
    var nameComunidad=$("#nameComunidad").val();
    var id_rol=$("#id_rol").val();
    if(nameRol.length>1)
    {
       insertRol();
    }else if(nameComunidad.length>1){
      if(id_rol.length>0)
        {
          updateRol();
        }
    }else{
      Command: toastr.warning("Campo Nombre Rol, requerido!", "Notifications")       
    }
  }
  function editRol() {
    var id_=$("#itemsRoles").val();
    var rolMember=$("#itemsRoles option:selected").text();
    document.getElementById("nameComunidad").value=rolMember;
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
    nameRol=$("#nameComunidad").val();
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
        // console.log(response);
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
    $.ajax({
           method: "POST",            
           url: "{{ url('/operacion-roles-get-tramite') }}"+"/"+id,
           data: {_token:'{{ csrf_token() }}'}   })
        .done(function (response) {    
          $.each($.parseJSON(response), function(i, item) {   
            $("#ch_"+item.Tipo_Code).prop("checked", true);
              oElements.push(item.Tipo_Code);
          });
            var filtered = oElements.filter(function (el) {
              return el != null;
            });
            $("#jsonTramites").val(JSON.stringify(filtered));
            $("#selectedChecks").val(JSON.stringify(filtered)); 
        })
        .fail(function( msg ) {
     
      });
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
function changeComunidad()
{
  changeRol();
  var comunidad=$("#itemsRoles").val();
   $("#itemsCofigNotario").val(comunidad).change();
  //var comunidad="4";
  //console.log(comunidad);
  //$("#itemsNotario").val("0").change();
  if(comunidad=="0")
  {
    $("#itemsNotario option").remove();
    $('#itemsNotario').append("<option value='0'>------</option>");
    $(".perfilesHide").css("display", "none");
       $("#itemsNotario").val("0").change();

    return;
  }

  var url="{{ url()->route('notary-offices-community', ':comunidad') }}";
  var urlnew=  url.replace(':comunidad', comunidad);
   $.ajax({
        method: "get",            
        url: urlnew,        
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
    var url="{{ url()->route('notary-offices-get-users', ':id') }}";
    var urlnew=  url.replace(':id', id);
    //$(".iDocument").css("display","block");
    $.ajax({
           method: "get",            
           url: urlnew,
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
                var id_notaria=item.pivot.notary_office_id;
                var urlsat="{{ url()->route('get-route', [':id_notaria','type'=>'sat']) }}";
                var urlsat=  urlsat.replace(':id_notaria', id_notaria);


                var urlnotaria="{{ url()->route('get-route', [':id_notaria','type'=>'notaria']) }}";
                var urlnotaria=  urlnotaria.replace(':id_notaria', id_notaria);

                document.getElementById('id_NotTitular').value=item.id;
                btn_download="<a class='btn btn-icon-only yellow' href='"+urlsat+"' target='_blank' data-toggle='modal' data-original-title='' title='Descargar Constancia SAT' ><i class='fa fa-file-pdf-o'></i></a><a class='btn btn-icon-only yellow' data-toggle='modal' href='"+urlnotaria+"' target='_blank'  title='Descargar Constancia Notaria' ><i class='fa fa-file-pdf-o'></i></a>";
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
                + "<td class='text-center' width='15%'><a class='btn btn-icon-only blue' href='#portlet-user' data-toggle='modal' data-original-title='' title='Editar' onclick='"+"perfilUpdate("+json+")'><i class='fa fa-pencil'></i>"+btn_desact+"</td>"
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
    function selectPermiso_updateNotary(id_)
  { 
 $(".input-checkbox-reenvio").css("display", "block");
    var array=$("#arrayPermisos").val();
    var resp=$.parseJSON(array);
        $("#itemsPermiso option").remove();
        $('#itemsPermiso').append("<option value='0'>------</option>");
          $.each(resp, function(i, item) {
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
          $.each(resp, function(i, item) {
            if( item.name=="notary_capturist" || item.name=="notary_payments" || item.name=="notary_capturist_payments"){
              $('#itemsPermiso').append("<option value='"+item.id+"'>"+item.description+"</option>");
            }
          });
          $("#itemsPermiso").val(id_).change();
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
      
      var pdfSAT = $("#fileSAT")[0].files[0]; 
      var pdfNot = $("#fileNotario")[0].files[0]; 
      var formdata = new FormData();

      formdata.append("notary_id",id_notary);
      formdata.append("user_id",id_user);     
      
      formdata.append("user[username]",users);
      formdata.append("user[email]",emailUser);
      formdata.append("user[name]",nameUser);
      formdata.append("user[mothers_surname]",apeMatUser);
      formdata.append("user[fathers_surname]",apePatUser);
      formdata.append("user[curp]",curpUser);
      formdata.append("user[rfc]",rfcUser);
      formdata.append("user[phone]",telUser);
      formdata.append("user[config_id]",itemsConfigUser);
      formdata.append("user[role_id]",itemsPermiso);
      formdata.append("user[reenvio]",check);      
      if(check==true || password_.length>0)
      {
        if(!/[a-z]/.test(password_) || !/[A-Z]/.test(password_) || !/[0-9]/.test(password_) || password_.length < 8){
          Command: toastr.warning("Campo Contraseña, formato incorrecto!", "Notifications")
          $("#password").focus();  
          return;
        }
        formdata.append("user[password]",password_);      
      }
      if(base64SAT.length>0)
      {
        formdata.append("file[sat]",pdfSAT);
      } 
       if(base64Notario.length>0)
      {
        formdata.append("file[notaria]",pdfNot);
      }      
      
      formdata.append("_token",'{{ csrf_token() }}');
      $.ajax({
           method: "POST",
           contentType:false,
           processData:false,           
           url: "{{ url()->route('notary-offices-edit-user') }}",           
           data: formdata  })
        .done(function (response) {          
             //limpiarNot();
             Command: toastr.success("Success", "Notifications")
             changeNotario();

        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
  function addtable()
  {
    $("#addtables div").remove();
    $("#addtables").append("<table class='table table-hover' id='sample_3'> <thead><tr><th>Tipo Rol</th><th>Usuario</th><th>Correo Electrónico</th> <th>Nombre</th><th>RFC</th><th>Curp</th><th>Status</th><th>&nbsp;&nbsp;Opciones&nbsp;</th><th>Documentos</th></tr> </thead> <tbody></tbody> </table>");
  }
function saveChangeNotary(formdata)
  {
    //console.log(Object.fromEntries(formdata));
    $.ajax({
           method: "POST", 
           contentType: false,
           processData: false,
           url: "{{ url()->route('notary-offices-update') }}",           
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
function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
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
    //$("#itemsEntidadNot").val("19").change();
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
</script>
@endsection
