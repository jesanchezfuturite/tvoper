@extends('layout.app')


@section('content')

<h3 class="page-title">Portal <small>Configuración Notario</small></h3>
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
            <a href="#">Configuración Notario</a>
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
                <i class="fa fa-bank"></i>Agregar Notario
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
                    <label >Notarios Registrados </label>  
                    <span class="help-block">(Selecciona para ver los Perfiles)</span> 
                  </div>
            </div>
            <div class="col-md-3 col-ms-12">
                <div class="form-group">           
                  <select class="select2me form-control"name="itemsNotario" id="itemsNotario" onchange="changeNotario()">
                    <option value="limpia">------</option>
                     @foreach( $notary as $sd)
                        <option value="{{$sd['id']}}">{{$sd["notary_number"]}}</option>
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
          <div id="borraheader">  <i class="fa fa-cogs"> </i>&nbsp;Configurar Perfil</div>
      </div>
      <div class="tools">                
        <a href="#portlet-perfil" data-toggle="modal" class="config" data-original-title="" title="Crear Nuevo"></a>
        <a id="Remov" href="javascript:;" data-original-title="" title=""><i class='fa fa-remove' style="color:#d7eaf8 !important;"></i></a>
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

<!----------------------------------------- deleted perfil-------------------------------------------->
<div id="portlet-deleted" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
             ¿Eliminar Registro?
                </p>
                 <input hidden="true" type="text" name="iddeleted" id="iddeleted" class="iddeleted">
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="deletePerfil()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<!----------------------------------------- Nuevo Notario-------------------------------------------->
<div class="modal fade" id="portlet-notario" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog" style="width: 80%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"data-dismiss="modal" aria-hidden="true" onclick="limpiarNot()"></button>
        <h4 class="modal-title">Configuracion Notario</h4>
        
      </div>
      <div class="modal-body">
        <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-4"> 
              <div class="form-group">
                <div class="form-group">
                <label >Numero de Notario</label>                                             
                <input type="text" class="form-control" name="numNotario" id="numNotario" placeholder="Ingrese Numero de Notario...">
              </div>                                           
              </div>
            </div>
            <div class="col-md-4"> 
              <div class="form-group">
                <label >Numero de Teléfono</label>                                             
                <input type="text" class="valida-numeros form-control" name="telNotario" id="telNotario" placeholder="Ingrese Numero de Teléfono...">
              </div>
            </div>
             <div class="col-md-4"> 
              <div class="form-group"> 
                   <div class="form-group">
                <label >Fax</label>                                             
                <input type="text" class="form-control" name="faxNotario" id="faxNotario" placeholder="Ingrese Fax...">
              </div>                                
              </div>
            </div>           
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            
             <div class="col-md-4"> 
              <div class="form-group">
                <div class="form-group">
                <label >Correo Electrónico</label>                                             
                <input type="text" class="form-control" name="emailNotario" id="emailNotario" placeholder="Ingrese Correo Electrónico..." autocomplete="off">
                <span id="emailNot" class="help-block"></span>
              </div>                                            
              </div>
            </div>
            <div class="col-md-4"> 
              <div class="form-group">
                <label >Calle</label>                                             
                <input type="text" class="form-control" name="calleNotario" id="calleNotario" placeholder="Ingrese Calle...">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label >Numero</label>                                                       
                <input type="text" class="form-control" name="numeroNotario" id="numeroNotario" placeholder="Ingrese Numero...">
             </div> 
           </div>
                          
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            
             <div class="col-md-3"> 
              <div class="form-group">
                <div class="form-group">
                <label >Distrito</label>                                             
                <input type="text" class="form-control" name="distritoNotario" id="distritoNotario" placeholder="Ingrese Distrito..." autocomplete="off">
              </div>                                            
              </div>
            </div>
            <div class="col-md-3"> 
              <div class="form-group">
                <label >Entidad Federativa</label>  
                <select id="itemsEntidadNot" class="select2me form-control" >
                  <option value="limpia">-------</option>
                </select>    
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label >Ciudad</label>
                <select id="itemsCiudadNot" class="select2me form-control" >
                  <option value="limpia">-------</option>
                </select>
             </div> 
           </div>
            <div class="col-md-3">
              <div class="form-group">
                <label >Codigo Postal</label>                                                       
                <input type="text" class="form-control" name="codigopostNotario" id="codigopostNotario" placeholder="Ingrese Codigo Postal...">
             </div> 
           </div>          
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-4"> 
              <div class="form-group">
                <label >Usuario</label>                                             
                <input type="text" class="form-control" name="userNotario" id="userNotario" placeholder="Ingrese Usuario...">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label >Correo Electrónico</label>                                                       
                <input type="text" class="form-control" name="emailNotario2" id="emailNotario2" placeholder="Ingrese Correo Electrónico...">
                <span id="emailNot2" class="help-block"></span>
             </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label >Nombre (s)</label>                                                       
                <input type="text" class="form-control" name="nameNotario" id="nameNotario" placeholder="Ingrese Nombre..."> 
            </div>
            </div>
          </div>
        </div>
         <div class="row">
          <div class="col-md-12">
            <div class="col-md-4"> 
              <div class="form-group">
                <label >Apellido Paterno</label>                                             
                <input type="text" class="form-control" name="apPatNotario" id="apPatNotario" placeholder="Ingrese Apellido Paterno...">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label >Apellido Materno</label>                                                       
                <input type="text" class="form-control" name="apMatNotario" id="apMatNotario" placeholder="Ingrese Apellido Materno...">
             </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label >Numero de Teléfono</label>                                                       
                <input type="text" class="form-control" name="telNotario2" id="telNotario2" placeholder="Ingrese Numero de Teléfono..."> 
            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-4"> 
              <div class="form-group">
                <label >Curp</label>                                             
                <input type="text" class="form-control" name="curpNotario" id="curpNotario" placeholder="Ingrese Curp...">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label >RFC</label>                                                       
                <input type="text" class="form-control" name="rfcNotario" id="rfcNotario" placeholder="Ingrese RFC...">
             </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label >Tipo</label>                                                       
                <select id="itemsTipoNotario" class="select2me form-control" >
                  <option value="limpia">-------</option>
                  <option value="fisica">Fisica</option>
                  <option value="moral">Moral</option>
                </select>
            
            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            
            <div class="col-md-4"> 
              <div class="form-group"> 
                   <div class="form-group">
                <label >Contraseña</label>                                             
                <div class="input-icon right">
                    <i  id="pass2"class="fa fa-eye-slash" onclick="onechange2()"  style="cursor:pointer;color: black;"></i>
                    <input type="password" name="passNotario"id="passNotario" autocomplete="new-password" class="form-control" placeholder="Ingresa la Contraseña" value="">
                </div>
              </div>                                
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-12">             
            <div class="form-group">
              <button type="submit" class="btn blue" onclick="saveNotario()"><i class="fa fa-check"></i> Guardar</button>
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
</div>
<!----------------------------------------- Nuevo usuario-------------------------------------------->
<div class="modal fade" id="portlet-perfil" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
        <h4 class="modal-title">Configuracion Perfil</h4>
        <input hidden="true" type="text" name="idperfil" id="idperfil">
      </div>
      <div class="modal-body">
        <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6"> 
              <div class="form-group">
                <div class="form-group">
                <label >Usuario</label>                                             
                <input type="text" class="form-control" name="nameUser" id="nameUser" placeholder="Ingrese Nombre de Usuario...">
              </div>                                           
              </div>
            </div>
            <div class="col-md-6"> 
              <div class="form-group">
                <div class="form-group">
                <label >Correo Electrónico</label>                                             
                <input type="text" class="form-control" name="userEmail" id="userEmail" placeholder="Ingrese Correo Electrónico..." autocomplete="off">
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
                <label >Numero de Teléfono</label>                                             
                <input type="text" class="valida-numeros form-control" name="numTel" id="numTel" placeholder="Ingrese Numero de Teléfono..." autocomplete="off">
              </div>
            </div>
             <div class="col-md-6"> 
              <div class="form-group"> 
                   <div class="form-group">
                <label >Nombre(s)</label>                                             
                <input type="text" class="form-control" name="cuotaMin" id="cuotaMin" placeholder="Ingrese Nombre(s)..."autocomplete="off">
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
                <input type="text" class="form-control" name="apePat" id="apePat" placeholder="Ingrese Apellido Paterno...">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label >Apellido Materno</label>                                                       
                <input type="text" class="form-control" name="apeMat" id="apeMat" placeholder="Ingrese Apellido Materno...">
             </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6"> 
              <div class="form-group">
                <label >Curp</label>                                             
                <input type="text" class="form-control" name="curp" id="curp" placeholder="Ingrese Curp..."autocomplete="off">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label >RFC</label>                                                       
                <input type="text" class="form-control" name="rfc" id="rfc" placeholder="Ingrese RFC..."autocomplete="off">
             </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6">
              <div class="form-group">
                <label >Tipo</label>                                                       
                <select id="itemsTipo" class="select2me form-control" >
                  <option value="limpia">-------</option>
                  <option value="fisica">Fisica</option>
                  <option value="moral">Moral</option>
                </select>
             </div>
            </div>
            <div class="col-md-6"> 
              <div class="form-group"> 
                <div class="form-group">
                <label >Contraseña</label> 
                <div class="input-icon right">
                    <i  id="pass1"class="fa fa-eye-slash" onclick="onechange1()"  style="cursor:pointer;color: black;"></i>
                    <input type="password" name="password"id="password" autocomplete="new-password" class="form-control" placeholder="Ingresa la Contraseña" value="">
                </div>
              </div>                                
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-12">             
            <div class="form-group">
              <button type="submit" class="btn blue" onclick="saveUpdate()"><i class="fa fa-check"></i> Guardar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cerrar</button>
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
  /*function ItemsTramite()
    {
        $.ajax({
        method: "get",            
        url: "{{ url('/traux-get-tramites') }}",
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
            $("#itemsTramites option").remove();
            var Resp=$.parseJSON(response);
            $('#itemsTramites').append(
                "<option value='limpia'>------</option>"
            );
            $.each(Resp, function(i, item) {                
                 $('#itemsTramites').append(
                "<option value='"+item.id+"'>"+item.nombre+"</option>"
                   );
                });
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Cargar Select", "Notifications")   });
  }
*/
  function saveNotario()
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
    insertNotario();
  }

  function insertNotario()
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
    if(itemsEntidadNot=="limpia")
    {
      itemsEntidadNot='';
    }
    if(itemsCiudadNot=="limpia")
    {
      itemsCiudadNot='';
    }
    if(itemsTipoNotario=="limpia")
    {
      itemsTipoNotario='';
    }
    var titular_ ={"username": userNotario,
    "email": emailNotario2,
    "password": passNotario,
    "name": nameNotario,
    "mothers_surname":apMatNotario ,
    "fathers_surname":apPatNotario,
    "curp": curpNotario,
    "rfc": rfcNotario,
    "phone":telNotario2,
    "person_type":itemsTipoNotario };

    var notary_off = {"notary_number": numNotario,
      "phone": telNotario,
      "fax": faxNotario,
      "email": emailNotario,
      "street": calleNotario,
      "number": numNotario,
      "district": distritoNotario,
      "federal_entity_id": itemsEntidadNot,
      "city_id": itemsCiudadNot,
      "zip": codigopostNotario,
      "titular": titular_}

    //console.log(notary_off);
    $.ajax({
           method: "POST", 
           url: "{{ url('/notary-offices') }}",
           data: {notary_office:notary_off,_token:'{{ csrf_token() }}'}   })
        .done(function (response) {     
        
          $("#itemsNotario option").remove();
            var Resp=$.parseJSON(response);
            $('#itemsNotario').append(
                "<option value='limpia'>------</option>"
            );
            $.each(Resp, function(i, item) {                
                 $('#itemsNotario').append(
                "<option value='"+item.id+"'>"+item.notary_number+"</option>"
                   );
                });
            limpiarNot();
            Command: toastr.success("Success", "Notifications") 
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    
  }
  function changeNotario()
  {
    var id=$("#itemsNotario").val();
    $.ajax({
           method: "get",            
           url: "{{ url('/notary-offices-get-users') }}"+"/"+id,
           data: {_token:'{{ csrf_token() }}'}   })
        .done(function (response) {     
        
          document.getElementById('jsonCode').value=response;            
          var Resp=response;
          
        addtable();
        $.each(Resp, function(i, item) {   
             console.log(item);             
            $('#sample_3 tbody').append("<tr>"
                +"<td>"+item.username+"</td>"
                +"<td>"+item.email+"</td>"
                +"<td>"+item.name+"</td>"
                +"<td>"+item.rfc+"</td>"
                +"<td>"+item.curp+"</td>"
                + "<td class='text-center' width='20%'><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='Editar' onclick='"+"perfilUpdate(\""+item.id+"\")'><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only red' data-toggle='modal' href='#portlet-deleted' onclick='perfilDelete(\""+item.id+"\")'><i class='fa fa-minus'></i></a></td>"
                +"</tr>"
                );
            });
        TableManaged.init();
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }

  function saveUpdate()
  {
    var upd=$("#nameUser").val();
  
    
    if(upd.length==0)
    {
      Command: toastr.warning("Campo Couta Minimo, Requerido!", "Notifications")
    }else if(upd.length==0)
    {
      Command: toastr.warning("Campo Couta Maximo, Requerido!", "Notifications")
    }else{
      if(upd.length==0)
        {
          insertPerfil();
        }else{
          updatePerfil();
        }
    }
  }
  function insertPerfil()
  {
    var idTramites=$("#itemsTramites").val();

      $.ajax({
           method: "POST",            
           url: "{{ url('') }}",
           data: { _token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
        
         if(response.Code =="200"){
            Command: toastr.success(response.Message, "Notifications") 
            } 
             findCostos();
             limpiar();

        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    
  }  

  function OperacionTramite(id_)
  {
    document.getElementById('idcosto').value=id_;
  }
  function addtable()
  {
    $("#addtables div").remove();
    $("#addtables").append("<table class='table table-hover' id='sample_3'> <thead><tr><th>Usuario</th><th>Correo Electrónico</th> <th>Nombre</th><th>RFC</th><th>Curp</th><th>&nbsp;</th></tr> </thead> <tbody></tbody> </table>");
     //TableManaged3.init3();

  }
  function findPerfil()
  {
    
    $.ajax({
      method: "get",
      url: "{{ url('/') }}",
      data: { _token: '{{ csrf_token() }}' }
      })
      .done(function (response) { 
         

    })
    .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function perfilDelete(id)
  {
    document.getElementById('iddeleted').value=id;
  }
  function deletePerfil()
  {
    var id_=$("#iddeleted").val();
    $.ajax({
           method: "POST",            
           url: "{{ url('') }}",
           data: {id:id_, _token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
        
         if(response.Code =="200"){
            Command: toastr.success(response.Message, "Notifications") 
            } limpiar();
             findPerfil();


        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function PerfilUpdate(id)
  {
    document.getElementById('idcosto').value=id;
  }
  function updatePerfil()
  {
    
    var id_=$("#idcosto").val();
    
      $.ajax({
           method: "POST",            
           url: "{{ url('') }}",
           data: {id:id_, _token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
        
         if(response.Code =="200"){
            Command: toastr.success(response.Message, "Notifications") 
            } 
             findPerfil();

        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });

    }
    
    function limpiarPerf()
    {
      $("#itemsTipo ").val("limpia").change();
    document.getElementById('nameUser').value=""; 
    }
    function deleteTipoServicio()
    {
        var id_=$("#idvalor").val();
        $.ajax({
           method: "POST",
           url: "{{ url('/') }}",
           data: { id:id_, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
     
        if(response=="true")
        {          
             
            Command: toastr.success("Success", "Notifications")

        }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
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
    $("#itemsCiudadNot").val("limpia").change();
    $("#itemsEntidadNot").val("limpia").change();
    document.getElementById('codigopostNotario').value="";
    document.getElementById('userNotario').value="";
    document.getElementById('emailNotario2').value="";
    document.getElementById('nameNotario').value="";
    document.getElementById('apPatNotario').value="";
    document.getElementById('apMatNotario').value="";
    document.getElementById('telNotario2').value="";
    document.getElementById('curpNotario').value="";
    document.getElementById('rfcNotario').value="";
    $("#itemsTipoNotario").val("limpia").change();
    document.getElementById('passNotario').value="";
    //$("input:radio").attr("checked", false);

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
document.getElementById('userEmail').addEventListener('input', function() {
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
