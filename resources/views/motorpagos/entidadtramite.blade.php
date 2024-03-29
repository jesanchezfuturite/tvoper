@extends('layout.app')


@section('content')
<link href="assets/global/css/checkbox.css" rel="stylesheet" type="text/css"/>
<h3 class="page-title">Motor de pagos <small>Configuración Entidad Tramite</small></h3>
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
            <a href="#">Configuración Entidad Tramite</a>
        </li>
    </ul>
</div>
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Importante:</strong> Para esta configuración es necesario tener el alta del trámite.
   
</div>
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Info: </strong>Esta configuración te permite relacionar un trámite a una entidad. También puedes eliminar o editar el registro.
</div>

<div class="row">
  
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Agregar Entidad
            </div>

        </div>
        <div class="portlet-body">
        <div class="form-body">
        <div class="row">
            
            <div class="col-md-2">
                <div class="form-group">
                    <label class="sr-only" for="entidad">Nueva Entidad</label>
                    <input type="text" class="form-control" id="entidad"name="entidad" autocomplete="off" placeholder="Nueva Entidad">
                </div> 
            </div> 
            <div class="col-md-1">
                <div class="form-group">               
                    <button type="button" class="btn green" onclick="saveEntidad()">Agregar</button>
                </div>
            </div>
            <div class="col-md-3">   
                <div class="form-group">
                    <label>Entidades Registradas (Selecciona para ver los Tramites)</label>         
                </div>
            </div> 
            <div class="col-md-3">   
                <div class="form-group">    
                    <select class="select2me form-control" name="OptionEntidad" id="OptionEntidad" onchange="changeEntidad()">
                        <option value="limpia">------</option>
                    </select>       
                </div> 
            </div>
            <div id="editentidad" class="col-md-1 col-ms-12" hidden="true">
                <div class="form-group" >
                  <button type="button" class="btn green tooltips" onclick="editEntidad()"  data-container="body" data-placement="top" data-original-title="Editar Nombre Entidad" data-toggle='modal' href='#modEntidad'><i class='fa fa-pencil'></i></button>  
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
        <div class="portlet-title" id="TitleBanco">
            <div class="caption" id="RemoveTitle">
                <i class="fa fa-cogs"></i>Registros Entidad Tramite  @if(session('is_admin') == true)<span class="label label-sm label-danger">
                            <strong>Clave: </strong>Sin Clave</span> @endif
            </div>
        </div>
        <div class="portlet-body" id="RemoveTable">
          <div class="row">
            <div class="form-group">
              <div class="col-md-6">                      
                <button class="btn green" href='#static2' data-toggle='modal' >Agregar</button>
              </div>
            </div>
            <div class="form-group">
             <div class="col-md-6 text-right">                
                <button class="btn blue" onclick="GuardarExcel()"><i class="fa fa-file-excel-o"></i> Descargar CSV</button>
              </div>
            </div>
            <span class="help-block">&nbsp; </span>
          </div>
          
                <table class="table table-hover" id="sample_2">
                <thead>
                <tr>
                    <th>
                        Nombre
                    </th>                    
                    <th>
                        &nbsp;
                    </th>
                </tr>
                </thead>
                <tbody>              
                        <tr>                           
                            <td>                              
                              <span class="help-block">No Found</span>                          
                            </td>
                            <td class="text-right">
                            </td>
                        </tr>                              
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="Limpiar()"></button>
                <h4 class="modal-title">Editar Tramite Entidad</h4>
            </div>
            <div class="modal-body">
                 <div class="form-body">
                      <input type="text" name="idtramiteEntidad" id="idtramiteEntidad" hidden="true">                   
                     <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                        <label class="control-label">Tipo Tramite</label>
                                            <select id="itemsTipoServicio" class="select2me form-control">
                                                 <option id="limpia" value="limpia">-------</option>
                                               
                                            </select>
                                        <span class="help-block">
                                    Seleccione una Opcion </span>
                                 </div>
                             </div>
                        </div>
                    </div>
                  <div class="row">
                <div class="col-md-12">            
                    <div class="form-group">
                        <button type="submit" class="btn blue" onclick="savetramiteEntidad()"><i class="fa fa-check"></i> Guardar</button>
                    </div>
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
             ¿Eliminar Registro?
                </p>
                 <input hidden="true" type="text" name="idregistro" id="idregistro" class="idregistro">
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminaTramiteEntidad()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<div id="static2" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiarr()"></button>
                <h4 class="modal-title">Registro Tramite Entidad</h4>
            </div>
            <div class="modal-body">  
               <div class="col-md-12"><div class='form-group'><label for="search">Buscar:</label></div></div>
                 <div class="col-md-8"><div class='form-group'><input type="text" name="search" id="search" class="form-control" placeholder="Escribe..."></div></div>
                <div class="col-md-4"><div class='form-group'> <div class='md-checkbox'><input type='checkbox' id='checkbox30' class='md-check' onclick='MostrarTodos()'>   <label for='checkbox30'>    <span></span>  <span class='check'></span> <span class='box'></span>Mostrar Todos</label> </div><span class='help-block'>Muestra Todo los Registros</span> 
              </div></div>
                
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
               <div class="col-md-12">            
                  <div class="form-group">
                    <button type="submit" class="btn blue" onclick="obtenerTodocheck()"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                </div> 
                <br>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn default" onclick="limpiarr()">Cerrar</button>
            </div>
            
        </div>
    </div>
    <!-- added jesv-->
    <input type="hidden" id="selectedChecks" value="[]">
</div>
<div id="modEntidad" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiarentidad()"></button>
                <h4 class="modal-title">Editar Nombre Entidad</h4>
            </div>
            <div class="modal-body">
                <br>
                <br>

                <div class="row">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="upEntidad">Entidad:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="upEntidad"name="upEntidad" autocomplete="off"placeholder="Entidad...">
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="form-group">
                    <div class="col-md-12">                    
                            <button type="submit" class="btn blue" onclick="updateEntidad()"><i class="fa fa-check"></i> Guardar</button>
                        </div>
                    </div>
                </div>
                <br>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn default" onclick="limpiarentidad()">Cerrar</button>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {       
      FindEntidad();
      AddOptionTipoServicio();
      FindEntidadTable();
      TableManaged.init();
      UIBlockUI.init();
      
    });
    function limpiarentidad()
    {
      document.getElementById("upEntidad").value="";
    }
    function editEntidad()
    {
        var id_=$("#OptionEntidad").val();
        $.ajax({
        method: "post",            
        url: "{{ url('/entidad-find-where') }}",
        data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
            var Resp=$.parseJSON(response);            
            $.each(Resp, function(i, item) {                
                 document.getElementById("upEntidad").value=item.nombre;
            });            
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Insertar la Entidad", "Notifications")   });
    }
    function updateEntidad()
    {
        var id_=$("#OptionEntidad").val();
        var entidad_=$("#upEntidad").val();
        if(entidad_.length>1){
        $.ajax({
        method: "post",            
        url: "{{ url('/entidad-update') }}",
        data: {id:id_,nombre:entidad_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
           if(response=="true"){
                Command: toastr.success("Actualizado Correctamente!", "Notifications")
                 selectItemsEntidad2(id_);
           }else{
            Command: toastr.warning("Error al Actualizar la Entidad", "Notifications")
           }
            
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Actualizar la Entidad", "Notifications")   });
        }else{
            Command: toastr.warning("La Campo Nombre, Requerido!", "Notifications")         
        }
    }
     function selectItemsEntidad2(id_)
    {
          $.ajax({
           method: "get",            
           url: "{{ url('/entidad-find') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);
          var item="";
          $("#OptionEntidad option").remove();
          $("#OptionEntidad").append("<option value='limpia'>-------</option>");
            $.each(Resp, function(i, item) {                
               $("#OptionEntidad").append("<option value='"+item.id+"'>"+item.nombre+"</option>");  
            });
            $("#OptionEntidad").val(id_).change();
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
    function MostrarTodos()
    {
      var check=$("#checkbox30").prop("checked");
      if(check==true)
      {
          FindEntidadTableAll();
        
           //$("#table2 tbody tr").remove();
      }
      else{
        FindEntidadTable();
      }
      document.getElementById('search').focus();
      document.getElementById('search').value="";
    }
    function FindEntidadTableAll()
    {
      $.ajax({
        method: "get",            
        url: "{{ url('/tiposervicio-find-all') }}",
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);
          var item="";
          $("#table2 tbody tr").remove();
        $.each(Resp, function(i, item) {                
               $("#table2").append("<tr>"
                +"<td class='text-center'><input id='ch_"+item.id+"' type='checkbox'onclick='addRemoveElement("+item.id+");'></td>"
                +"<td  width='100%'>"+item.nombre+"</td>"
                +"</tr>"
            );  
        });
        sortTable();
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
    function FindEntidadTable()
    {
      $.ajax({
        method: "get",            
        url: "{{ url('/tiposervicio-find-all-where') }}",
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);
          var item="";
          $("#table2 tbody tr").remove();
        $.each(Resp, function(i, item) {                
               $("#table2").append("<tr>"
                +"<td class='text-center'><input id='ch_"+item.id+"' type='checkbox'onclick='addRemoveElement("+item.id+");'></td>"
                +"<td  width='100%'>"+item.nombre+"</td>"
                +"</tr>"
            );  
        });
        sortTable();
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
     function AddOptionTipoServicio() 
    {          
            $.ajax({
           method: "get",            
           url: "{{ url('/tiposervicio-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) { 
        $("#itemsTipoServicio option").remove();
        var Resp=$.parseJSON(responseinfo);

         $('#itemsTipoServicio').append(
                "<option value='limpia'>------</option>"
        );
          var item="";
        $.each(Resp, function(i, item) {                
                 $('#itemsTipoServicio').append(
                "<option value='"+item.id+"'>"+item.nombre+"</option>"
                   );
                });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
            return false;
    }
    function obtenerTodocheck()
    {

      /*jesv aqui que guardar los elementos del selectedChecks*/
      var checkeds=$("#selectedChecks").val();
       var entidad=$("#OptionEntidad").val();
    
       
        if (checkeds.length < 3) {
          Command: toastr.warning("Tramites Sin Seleccionar Requerido!", "Notifications")
        }else if(entidad=="limpia")
        { 
          Command: toastr.warning("Entidad Sin Seleccionar Requerido!", "Notifications")
        }else{            
                $.ajax({
                method: "POST",            
                url: "{{ url('/entidad-tramite-insert') }}",
                data: {Id_entidad:entidad,checkedsAll:checkeds,_token:'{{ csrf_token() }}'}  })
                .done(function (response) {
            if(response==0){
              Command: toastr.warning("Ninguno Fue Agregado!", "Notifications")
            }else{ 
             
              Command: toastr.success(" "+response+" Registrados!", "Notifications")}
              TableTramiteEntidad();
            })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        }
    }
    function saveEntidad()
    {
        var validaentidad=$("#entidad").val();
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
        var validaentidad=$("#entidad").val();
        if(validaentidad.length==0)
            {
                Command: toastr.warning("Entidad Requerido!", "Notifications")
            }else{
        var entidad=$("#entidad").val();
         $.ajax({
           method: "POST",            
           url: "{{ url('/entidad-insert') }}",
           data: {nombre:entidad,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            if(response=="true"){
                FindEntidad();
                 document.getElementById('entidad').value="";

            Command: toastr.success("Success", "Notifications")
            }else{
                Command: toastr.warning("No Success", "Notifications") 
            }

            Limpiar();
            
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        }
            return false;
    }
    function savetramiteEntidad()
    {
        var entidad=$("#OptionEntidad").val();
        var tiposervicio=$("#itemsTipoServicio").val();
        var tramites=$("#selectedChecks").val();
        if(entidad=="limpia")
        {
            Command: toastr.warning("Tipo Tramite Sin Seleccionar, Requerido!", "Notifications")
        }else if(tramites>=2){
                 Command: toastr.warning("Tramites Sin Seleccionar, Requerido!", "Notifications")
            
        }else{
            $.ajax({
           method: "POST",            
           url: "{{ url('/entidad-tramite-find-where') }}",
           data: {id:entidad,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo); 
        var coincidencia=0;    
        var tiposer="";    
        $.each(Resp, function(i, item) {                
           tiposer=item.tipo_servicios_id;
            if(tiposervicio==tiposer){
                coincidencia=coincidencia+1;
                }
            });
            if(coincidencia==0){
            var itramite=$("#idtramiteEntidad").val();
                if(itramite.length==0)
                {
                    inserttramiteEntidad();
                }
                else{
                    EditaTramiteEntidad();
                }          
            }else{
            Command: toastr.warning("La Entidad Ya Se Encuentra Registrado!", "Notifications")
          
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
            
        }
    }
    function updateTramiteEntidad(id_)
    {
          
         document.getElementById('idtramiteEntidad').value=id_;

         $.ajax({
           method: "POST",            
           url: "{{ url('/entidad-tramite-find-id') }}",
           data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            var Resp=$.parseJSON(response);
          var item="";
        $.each(Resp, function(i, item) {
           //document.getElementById('itemsTipoServicio').value=item.tipo_servicios_id; 
            $("#itemsTipoServicio").val(item.tipo_servicios_id).change();
            });
           
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });

    }
    function EditaTramiteEntidad()
    {
        
        var idtramite=$("#idtramiteEntidad").val();
        var idtiposerv=$("#itemsTipoServicio").val();
         $.ajax({
           method: "POST",            
           url: "{{ url('/entidad-tramite-update') }}",
           data: {id:idtramite,Id_tiposervicio:idtiposerv,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
           if(response=="true") {
            TableTramiteEntidad();
            Command: toastr.success("Success", "Notifications")
            }else{ Command: toastr.warning("No Success", "Notifications")}
            Limpiar();
           
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        
    }
    function DeleteTramiteEntidad(id_)
    {
         document.getElementById('idregistro').value=id_;
    }
    function eliminaTramiteEntidad()
    {
        var entidad=$("#idregistro").val();
         $.ajax({
           method: "POST",            
           url: "{{ url('/entidad-tramite-delete') }}",
           data: {id:entidad,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
             if(response=="true") {
            TableTramiteEntidad();
            Command: toastr.success("Success", "Notifications")
            }else{
                Command: toastr.warning("No Success", "Notifications")
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
            return false;
    }
    function FindEntidad()
    {
         $.ajax({
           method: "get",            
           url: "{{ url('/entidad-find') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);
          var item="";
          $("#OptionEntidad option").remove();
          $("#OptionEntidad").append("<option value='limpia'>-------</option>"
            );
        $.each(Resp, function(i, item) {                
               $("#OptionEntidad").append("<option value='"+item.id+"'>"+item.nombre+"</option>"
            );  
        });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
    function changeEntidad() {
       $("#sample_2 tbody tr").remove();
          $("#sample_2 tbody").append("<tr><th>Espere Cargando...</th></tr>");
        TableTramiteEntidad();
        id_=$("#OptionEntidad").val();
        if(id_=="limpia")
        {
          $("#editentidad").css("display","none");
        }else{
          $("#editentidad").css("display","block");
        }

    }
    function TableTramiteEntidad()
    {
      AddOptionTipoServicio();
      FindEntidadTable();
        var id_=$("#OptionEntidad").val();
        if(id_=="limpia")
            {
              $("#RemoveTitle").remove();
               $("#TitleBanco").append("<div class='caption' id='RemoveTitle'>        <i class='fa fa-cogs'></i>Registros Entidad Tramite  @if(session('is_admin') == true)<span class='label label-sm label-danger'> <strong>Clave: </strong>Sin Clave</span> @endif </div>");

                $("#RemoveTable").remove();
                AddtableSample_1();
                TableManaged.init();
            }else{
                $.ajax({
           method: "POST",            
           url: "{{ url('/entidad-tramite-find') }}",
           data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) { 
          findClave();
        var Resp=$.parseJSON(responseinfo);
          var item="";
          if(responseinfo=="[]")
            {
              $("#RemoveTable").remove();
              AddtableSample_1();
            }else{
               $("#RemoveTable").remove();
                AddtableSample_1();
                $("#sample_2 tbody tr").remove();
                $.each(Resp, function(i, item) {                
                 $('#sample_2').append("<tr>"
                    +"<td>"+item.tiposervicio+"</td>"
                    +"<td class='text-right'><a class='btn btn-icon-only red' data-toggle='modal' href='#static' title='Eliminar Registro' onclick=\"DeleteTramiteEntidad(\'"+item.id+"\')\"><i class='fa fa-minus'></i> </a></td>"
                    +"</tr>");    });
                TableManaged.init(); 
              }
              /*<a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='Editar Registro' onclick=\"updateTramiteEntidad(\'"+item.id+"\')\"><i class='fa fa-edit'></i> </a>*/
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
            }
         
    }
    function AddtableSample_1()
    {
      $("#Addtable").append("<div class='portlet-body' id='RemoveTable'> <div class='row'> <div class='form-group'><div class='col-md-6'> <button class='btn green' href='#static2' data-toggle='modal' >Agregar</button> </div>        </div> <div class='form-group'> <div class='col-md-6 text-right'>     <button class='btn blue' onclick='GuardarExcel()'><i class='fa fa-file-excel-o'></i> Descargar CSV</button> </div></div> <span class='help-block'>&nbsp; </span></div> <table class='table table-hover' id='sample_2'> <thead> <tr><th>Nombre</th> <th>&nbsp;</th></tr> </thead><tbody> <tr><td> <span class='help-block'>No Found</span> </td><td class='text-right'></td> </tr> </tbody></table></div>");
    }
    function findClave()
    {
       var id_=$("#OptionEntidad").val();
       $.ajax({
           method: "POST",            
           url: "{{ url('/entidad-find-where') }}",
           data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) { 
           
          $("#RemoveTitle").remove();
        var Resp=$.parseJSON(responseinfo);
          var item="";
         
        $.each(Resp, function(i, item) {
           if(item.clave=="")
            {
              $("#TitleBanco").append("<div class='caption' id='RemoveTitle'>        <i class='fa fa-cogs'></i>Registros Entidad Tramite  @if(session('is_admin') == true)<span class='label label-sm label-danger'> <strong>Clave: </strong>Sin Clave</span> @endif </div>");
            }else{
              $("#TitleBanco").append("<div class='caption' id='RemoveTitle'>        <i class='fa fa-cogs'></i>Registros Entidad Tramite  @if(session('is_admin') == true)<span class='label label-sm label-danger'> <strong>Clave: </strong>"+item.clave+"</span> @endif </div>");
            }
          });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });  

    }
    function Limpiar()
    {
        //$("#itemsTipoServicio").val('limpia')
        //$("#itemsTipoServicio option[value='limpia']").attr("selected", true);
        document.getElementById('search').value="";
        document.getElementById('itemsTipoServicio').value="limpia";
        document.getElementById('idtramiteEntidad').value="";
        document.getElementById('idregistro').value="";
       $("#itemsTipoServicio").val("limpia").change();
       document.getElementById('selectedChecks').value="[]";
         
    }
    /* jesv added code */
  function addRemoveElement(element)
  {

      // checar el status del campo

      var eleStatus = $("#ch_"+element).prop("checked");

      var checkedElements = $.parseJSON($("#selectedChecks").val());

      if(eleStatus == true)
      {
        // esta seleccionado (agregarlo al json)
        checkedElements.push(element);

        $("#selectedChecks").val(JSON.stringify(checkedElements));

      }else{
        // no esta seleccionado (quitarlo del json)
        $.each(checkedElements,function(i,value){

            if(element == value){
              //remover el nodo
              delete checkedElements[i];
            }

        });

        // eliminar los nodos vacíos
        var filtered = checkedElements.filter(function (el) {
          return el != null;
        });

        $("#selectedChecks").val(JSON.stringify(filtered));
      
      }

  }
  function limpiarr()
  {

      // checar el status del campo

      //var checkbox= $("#selectedChecks").val();

      ///var checkedElements = $.parseJSON(checkbox);
     
      ///$.each(checkedElements,function(i,value){
       ///$("#ch_"+value+"").prop("checked", false);
       //$("#ch_"+value+" :checkbox").attr('checked', true);
       //$("#ch_"+value+"").removeAttr('checked');
        //});
        $("#checkbox30").prop("checked", false);
      document.getElementById('selectedChecks').value="[]";
      document.getElementById('search').value="";
       $('input:checkbox').removeAttr('checked');
       FindEntidadTable();
  }
  function sortTable() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("table2");
  switching = true;
  while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[1];
      y = rows[i + 1].getElementsByTagName("TD")[1];
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
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

function GuardarExcel()
{
 var id_=$("#OptionEntidad").val();
  if(id_=="limpia"){
    Command: toastr.warning("Entidad No Seleccionada!", "Notifications")
  }else{
    document.getElementById("blockui_sample_3_1").click();
     $.ajax({
           method: "POST",            
           url: "{{ url('/entidad-tramite-find') }}",
           data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseTipoServicio) {
            //console.log(responseTipoServicio);
            if(responseTipoServicio=="[]")
            { 
              Command: toastr.warning("Sin Registros!", "Notifications")
              document.getElementById("blockui_sample_3_1_1").click();

            }else{
              //var Resp=$.parseJSON(responseTipoServicio);  
               var Entidad=$("#OptionEntidad option:selected").text();        
               JSONToCSVConvertor(responseTipoServicio, Entidad, true);
               
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications") 
         document.getElementById("blockui_sample_3_1_1").click(); }); 
  
  }
   
     
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

    var fileName = fecha+"Entidad_";
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