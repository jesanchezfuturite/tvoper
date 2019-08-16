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
                    <select class="select2me form-control" name="OptionEntidad" id="OptionEntidad" onchange="TableTramiteEntidad()">
                        <option value="limpia">------</option>
                    </select>       
                </div> 
                </div> 
                </div>            
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box blue">
        <div class="portlet-title" id="TitleBanco">
            <div class="caption" id="RemoveTitle">
                <i class="fa fa-cogs"></i>Registros Entidad Tramite
            </div>
        </div>
        <div class="portlet-body">           
            <div class="form-group">           
                <button class="btn green" href='#static2' data-toggle='modal' >Agregar</button>
            </div>
            
            <div class="table-scrollable">
                <table class="table table-hover" id="table">
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
                    <br>
                 <div class="form-actions">

                     <button type="submit" class="btn blue" onclick="savetramiteEntidad()"><i class="fa fa-check"></i> Guardar</button>
                     <button type="button" onclick="Limpiar()" data-dismiss="modal" class="btn default" >Cancelar</button>
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Registro Tramite Entidad</h4>
            </div>
            <div class="modal-body">
               <div class="overflow-auto" id="demo">
                 <table class="table table-hover" id="sample_6">
                    <thead>
                      <tr>            
                        <th>Selecciona</th>
                        <th>Tipo Tramite</th> 
                      </tr>
                    </thead>
                    <tbody>  
                        
                    </tbody>
                  </table>
               </div> 
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="obtenerTodocheck()">Confirmar</button>
            </div>
        </div>
    </div>
    <!-- added jesv-->
    <input type="hidden" id="selectedChecks" value="[]">
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {       
      FindEntidad();
      AddOptionTipoServicio();
      FindEntidadTable();
      
    });
    function FindEntidadTable()
    {
      $.ajax({
        method: "get",            
        url: "{{ url('/tiposervicio-find-all') }}",
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);
          var item="";
          $("#sample_6 tbody tr").remove();
        $.each(Resp, function(i, item) {                
               $("#sample_6").append("<tr>"
                +"<td class='text-center'><input id='ch_"+item.id+"' type='checkbox'onclick='addRemoveElement("+item.id+");'></td>"
                +"<td >"+item.nombre+"</td>"
                +"</tr>"
            );  
        });
           TableAdvanced.init();
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
    function limpiarCheck()
    {
      $('input:checkbox').removeAttr('checked');
    }


    function obtenerTodocheck()
    {

      /*jesv aqui que guardar los elementos del selectedChecks*/
      var contador=0;
     $("input[type=checkbox]").each(function(x,y){
      console.log(y);
      if($(this).is(":checked"))
        contador++;
    });
      console.log(contador);
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
        if(entidad=="limpia")
        {
            Command: toastr.warning("Entidad Sin Seleccionar Requerido!", "Notifications")
        }else if(tiposervicio=="limpia"){
                 Command: toastr.warning("Tipo Tramite Requerido!", "Notifications")
            
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
    function inserttramiteEntidad()
    {
        var entidad=$("#OptionEntidad").val();
        var tiposervicio=$("#itemsTipoServicio").val();
        if(entidad=="limpia")
        {
            Command: toastr.warning("Entidad Sin Seleccionar Requerido!", "Notifications")
        }else{            
                $.ajax({
                method: "POST",            
                url: "{{ url('/entidad-tramite-insert') }}",
                data: {Id_entidad:entidad,Id_tiposervicio:tiposervicio,_token:'{{ csrf_token() }}'}  })
                .done(function (response) {
            if(response=="true")
            {
                Command: toastr.success("Success", "Notifications")
                TableTramiteEntidad();
                  Limpiar();
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

    function TableTramiteEntidad()
    {
        var id_=$("#OptionEntidad").val();
        if(id_=="limpia")
            {
                $("#table tbody tr").remove();
                $('#table').append("<tr>"
                    +"<td> <span class='help-block'>No Found</span></td>"
                    +"<td class='text-right'></td>"
                    +"</tr>");
            }else{
                $.ajax({
           method: "POST",            
           url: "{{ url('/entidad-tramite-find') }}",
           data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) { 
        $("#table tbody tr").remove();
        var Resp=$.parseJSON(responseinfo);
          var item="";
        $.each(Resp, function(i, item) {                
                 $('#table').append("<tr>"
                    +"<td>"+item.tiposervicio+"</td>"
                    +"<td class='text-right'><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='Editar Registro' onclick=\"updateTramiteEntidad(\'"+item.id+"\')\"><i class='fa fa-edit'></i> </a><a class='btn btn-icon-only red' data-toggle='modal' href='#static' title='Eliminar Registro' onclick=\"DeleteTramiteEntidad(\'"+item.id+"\')\"><i class='fa fa-minus'></i> </a></td>"
                    +"</tr>");    });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
            }
         
    }
    function Limpiar()
    {
        //$("#itemsTipoServicio").val('limpia')
        //$("#itemsTipoServicio option[value='limpia']").attr("selected", true);
        document.getElementById('itemsTipoServicio').value="limpia";
       document.getElementById('idtramiteEntidad').value="";
        document.getElementById('idregistro').value="";
       $("#itemsTipoServicio").val("limpia").change();
         
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
</script>
@endsection