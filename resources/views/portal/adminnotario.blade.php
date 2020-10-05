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
                  <select class="select2me form-control"name="items" id="items" onchange="CuentasBanco()">
                    <option value="limpia">------</option>
                          
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
        <div class="row">
          <span class="help-block"></span>             
          <div class='col-md-12 text-right'>
          <div class='form-group'>                      
            <button class='btn blue' onclick='GuardarExcel()'><i class='fa fa-file-excel-o'></i> Descargar CSV</button> 
          </div>
      </div>
      <span class="help-block">&nbsp;</span>                              
    </div>
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
            <button type="button" data-dismiss="modal" class="btn green" onclick="deleteCosto()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<!----------------------------------------- Nuevo Notario-------------------------------------------->
<div class="modal fade" id="portlet-notario" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog" style="width: 80%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
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
                <select id="entidadNotario" class="select2me form-control" >
                  <option value="limpia">-------</option>
                </select>    
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label >Ciudad</label>
                <select id="ciudadNotario" class="select2me form-control" >
                  <option value="limpia">-------</option>
                </select>
             </div> 
           </div>
            <div class="col-md-3">
              <div class="form-group">
                <label >Codigo Postal</label>                                                       
                <input type="text" class="form-control" name="ciudadNotario" id="ciudadNotario" placeholder="Ingrese Codigo Postal...">
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
                <input type="text" class="form-control" name="emailNotario" id="emailNotario" placeholder="Ingrese Correo Electrónico...">
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
                <input type="password" class="valida-decimal form-control" name="passNotario" id="passNotario" placeholder="Ingrese Contraseña..." autocomplete="off">
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

     //findCostos();
    });
  function pass1()
  {document.getElementById('password').type='password';}
  function ItemsTramite()
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
  function valorCuota()
    {
        $.ajax({
        method: "get",            
        url: "{{ url('/traux-get-cuota') }}",
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
            var Resp=$.parseJSON(response);
          document.getElementById('uma').value=Resp.cuota_costo;
                
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Cargar Select", "Notifications")   });
  }
  function saveUpdate()
  {
    var upd=$("#idcosto").val();
    var idTramites=$("#itemsTramites").val();
    var tipoTramite=$("#itemsTipo").val();
    var cuotaMin=$("#cuotaMin").val();
    var cuotaMax=$("#cuotaMax").val();
    var option = document.querySelector('input[name = radio2]:checked');
     
    if(option!=null)
    {
      option = document.querySelector('input[name = radio2]:checked').value;
    }
    if(idTramites=='limpia')
    {
      Command: toastr.warning("Selecciona un Tramite, Requerido!", "Notifications")
    }else if(tipoTramite=='limpia')
    {
      Command: toastr.warning("Selecciona un Tipo, Requerido!", "Notifications")
    }else if(option==null)
    {
      Command: toastr.warning("Selecciona el Costo, Requerido!", "Notifications")
    }else if(cuotaMin.length==0)
    {
      Command: toastr.warning("Campo Couta Minimo, Requerido!", "Notifications")
    }else if(cuotaMax.length==0)
    {
      Command: toastr.warning("Campo Couta Maximo, Requerido!", "Notifications")
    }else
    {
    if(upd.length==0)
      {
        insertCosto();
      }else{
         updateCosto();
      }
    }
  }
  function insertCosto()
  {
    var idTramites=$("#itemsTramites").val();
    var tipoTramite=$("#itemsTipo").val();
    var cuotaMin=$("#cuotaMin").val();
    var cuotaMax=$("#cuotaMax").val();
    var option = document.querySelector('input[name = radio2]:checked').value;
    
      $.ajax({
           method: "POST",            
           url: "{{ url('/traux-post-tramites') }}",
           data: {tramite:idTramites,tipo:tipoTramite,costo:option,minimo:cuotaMin,maximo:cuotaMax, _token:'{{ csrf_token() }}'}  })
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
  function findCostos()
  {
    
    $.ajax({
      method: "get",
      url: "{{ url('/traux-get-costos') }}",
      data: { _token: '{{ csrf_token() }}' }
      })
      .done(function (response) { 
         document.getElementById('jsonCode').value=response;            
          var Resp=$.parseJSON(response);
        addtable();
        var tipo="";
        var costo="";
        $.each(Resp, function(i, item) {   
          if(item.tipo=='f')
          {tipo="Fijo";}else{tipo="Variable";}

          if(item.costo=='H')
          {costo="Hoja";
          }else if(item.costo=='M')
          {costo="Millar";
          }else{ costo="Lote";}               
            $('#sample_2 tbody').append("<tr>"
                +"<td>"+item.tramite+"</td>"
                +"<td>"+tipo+"</td>"
                +"<td>"+costo+"</td>"
                +"<td>"+item.minimo+"</td>"
                +"<td>"+item.maximo+"</td>"
                + "<td class='text-center' width='20%'><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='Editar' onclick='"+"costoUpdate("+item.id+","+item.tramite_id+",\""+item.tipo+"\",\""+item.costo+"\","+item.minimo+","+item.maximo+")'><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only red' data-toggle='modal' href='#portlet-deleted' onclick='costoDelete("+item.id+")'><i class='fa fa-minus'></i></a><a class='btn btn-icon-only green' data-toggle='modal' href='#portlet-subsidio' onclick='updatesubsidio("+item.id+","+item.subsidio_id+","+item.tramite_id+",\""+item.cuotas+"\",\""+item.limite_cuotas+"\")'><i class='fa fa-usd'></i></a></td>"
                +"</tr>"
                );
            });
        TableManaged.init();

    })
    .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function costoDelete(id)
  {
    document.getElementById('iddeleted').value=id;
  }
  function deleteCosto()
  {
    var id_=$("#iddeleted").val();
    $.ajax({
           method: "POST",            
           url: "{{ url('/traux-del-tramites') }}",
           data: {id:id_, _token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
        
         if(response.Code =="200"){
            Command: toastr.success(response.Message, "Notifications") 
            } limpiar();
             findCostos();


        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function costoUpdate(id,tramite_id,tipo,costo,minimo,maximo)
  {
    document.getElementById('idcosto').value=id;
    $("#itemsTramites").val(tramite_id).change();
    $("#itemsTipo").val(tipo).change();
    document.getElementById('cuotaMin').value=minimo;    
    document.getElementById('cuotaMax').value=maximo;
    $("input[name=radio2][value='"+costo+"']").prop("checked",true);
  }
  function updateCosto()
  {
    
    var id_=$("#idcosto").val();
    var idTramites=$("#itemsTramites").val();
    var tipoTramite=$("#itemsTipo").val();
    var cuotaMin=$("#cuotaMin").val();
    var cuotaMax=$("#cuotaMax").val();
    var option = document.querySelector('input[name = radio2]:checked').value;
    
      $.ajax({
           method: "POST",            
           url: "{{ url('/traux-edit-tramites') }}",
           data: {id:id_,tramite:idTramites,tipo:tipoTramite,costo:option,minimo:cuotaMin,maximo:cuotaMax, _token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
        
         if(response.Code =="200"){
            Command: toastr.success(response.Message, "Notifications") 
            } 
             findCostos();

        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });

    }
    function updatesubsidio(id_,subsidio_id,tramite_id,cuotas,limite_cuotas)
    { 
      document.getElementById('id_costo').value=id_;
      document.getElementById('id_tramite').value=tramite_id; 
      if(subsidio_id=='null')
      {   subsidio_id=''; }  
      if(cuotas=='null')
      { cuotas='';}  
      if(limite_cuotas=='null')
      { limite_cuotas=''; }  
      document.getElementById('id_subsidio').value=subsidio_id;       
      document.getElementById('cuotas').value=cuotas;       
      document.getElementById('cuotaLimit').value=limite_cuotas;       
    }
    function save()
    {
      var id_=$("#id_subsidio").val();
      var id_costo=$("#id_costo").val();
      var id_tramite=$("#id_tramite").val();
      var cuotas_=$("#cuotas").val();
      var cuotaLimit=$("#cuotaLimit").val();
      $.ajax({
           method: "POST",            
           url: "{{ url('/traux-post-subsidios') }}",
           data: {id:id_,tramite:id_tramite,costo_id:id_costo,cuotas:cuotas_,limite_cuotas:cuotaLimit, _token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
        
         if(response.Code =="200"){
            Command: toastr.success(response.Message, "Notifications") 
            } 
             findCostos();

        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });  
    }
    function limpiarSub()
    {
      document.getElementById('id_costo').value='';
      document.getElementById('id_tramite').value='';       
      document.getElementById('cuotas').value='';       
      document.getElementById('cuotaLimit').value=''; 
    }
    function deleteTipoServicio()
    {
        var id_=$("#idvalor").val();
        $.ajax({
           method: "POST",
           url: "{{ url('/tipo-servicio-delete') }}",
           data: { id:id_, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
     
        if(response=="true")
        {          
            ActualizaTabla();  
            Command: toastr.success("Success", "Notifications")

        }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function limpiar()
  {
    $("#itemsTramites").val("limpia").change();
    $("#itemsTipo").val("limpia").change();
    document.getElementById('cuotaMin').value="";
    document.getElementById('cuotaMax').value="";
    document.getElementById('idcosto').value="";
    $("input:radio").attr("checked", false);
    document.getElementById('iddeleted').value="";

}
function onechange2()
    {
        var nombre=$("#pass2").attr("class");
        if(nombre=="fa fa-eye-slash")
        {
            $("#pass2").removeClass("fa-eye-slash").addClass("fa-eye");
            $('#confirmpassword').attr('type', 'text');
        }else{
            $("#pass2").removeClass("fa-eye").addClass("fa-eye-slash");
            $('#confirmpassword').attr('type', 'password');
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
        //Se muestra un texto a modo de ejemplo, luego va a ser un icono
        if (emailRegex.test(campo.value)) {
            valido.innerText = "";
            document.getElementById("emailOK").style.color = "green";
        } else {
            valido.innerText = "Incorrecto";
            document.getElementById("emailOK").style.color = "red";
        }
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
