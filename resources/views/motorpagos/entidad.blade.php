@extends('layout.app')

@section('content')
<h3 class="page-title">Motor de pagos <small>Configuración Entidad</small></h3>
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
            <a href="#">Configuración Entidad</a>
        </li>
    </ul>
</div>


<div class="row">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box blue">
        <div class="portlet-title" id="TitleBanco">
            <div class="caption" id="RemoveTitle">
                <i class="fa fa-cogs"></i>Registros Entidad
            </div>
        </div>
        <div class="portlet-body">           
            <div class="form-group">           
                <button class="btn green" href='#portlet-config' data-toggle='modal' >Agregar</button>
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
               @foreach( $viewEntidad as $sd)
                        <tr>                           
                            <td>                              
                            {{$sd["nombre"]}}                               
                            </td>
                            <td class="text-right">
                               <a class="btn btn-icon-only blue" href="#portlet-config" data-toggle="modal" data-original-title="" title="Agregar Cuenta" onclick="updateEntidad({{$sd['id']}})"><i class="fa fa-edit"></i> </a><a class="btn btn-icon-only red" data-toggle="modal" href="#static" onclick="DeleteEntidad({{$sd['id']}})"><i class="fa fa-minus"></i> </a>
                            </td>
                        </tr>
                @endforeach                
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
                <h4 class="modal-title">Registro Entidad</h4>
            </div>
            <div class="modal-body">
                 <form action="#" class="form-horizontal">
                    <div class="form-body">
                         <input hidden="true" type="text"  id="idEntidad">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Entidad</label>
                            <div class="col-md-6">
                                <input type="text" autocomplete="off" class="form-control" placeholder="Ingresa Entidad" id="entidad">
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-6">
                                    <button type="submit" data-dismiss="modal" class="btn blue" onclick="saveUpdateEntidad()">Guardar</button>
                                    <button type="button" data-dismiss="modal" class="btn default" onclick="Limpiar()">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminaEntidad()">Confirmar</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
    function saveUpdateEntidad()
    {
        var idR=$("#idEntidad").val();
        if(idR=="")
        {
            insertEntidad();
        }else{
            EditaEntidad();
        }
    }
    function insertEntidad()
    {   
        var validaentidad=$("#entidad").val();
        if(validaentidad.length==0)
            {
                Command: toastr.warning("No Success", "Notifications")
            }else{
        var entidad=$("#entidad").val();
         $.ajax({
           method: "POST",            
           url: "{{ url()->('entidad-insert') }}",
           data: {nombre:entidad,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            if(response=="true"){
                TableEntidad();
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
    function updateEntidad(id_)
    {
          
         document.getElementById('idEntidad').value=id_;
         $.ajax({
           method: "POST",            
           url: "{{ url()->('entidad-find-where') }}",
           data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            var Resp=$.parseJSON(response);
          var item="";
        $.each(Resp, function(i, item) {
           document.getElementById('entidad').value=item.nombre; 
            });
           
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });

    }
    function EditaEntidad()
    {
        var validaentidad=$("#entidad").val();
        if(validaentidad.length==0)
            {
                Command: toastr.warning("No Success", "Notifications")
            }else{
        var entidad=$("#entidad").val();
        var identidad=$("#idEntidad").val();
         $.ajax({
           method: "POST",            
           url: "{{ url()->('entidad-update') }}",
           data: {id:identidad,nombre:entidad,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
           if(response=="true") {
            TableEntidad();
            Command: toastr.success("Success", "Notifications")
            }else{ Command: toastr.warning("No Success", "Notifications")}
            Limpiar();
           
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        }
            return false;
    }
    function DeleteEntidad(id_)
    {
         document.getElementById('idregistro').value=id_;
    }
    function eliminaEntidad()
    {
        var entidad=$("#idregistro").val();
         $.ajax({
           method: "POST",            
           url: "{{ url()->('entidad-delete') }}",
           data: {id:entidad,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
             if(response=="true") {
            TableEntidad();
            Command: toastr.success("Success", "Notifications")
            }else{
                Command: toastr.warning("No Success", "Notifications")
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
            return false;
    }
    function TableEntidad()
    {
         $.ajax({
           method: "POST",            
           url: "{{ url()->('entidad-find') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) { 
        $("#table tbody tr").remove();
        var Resp=$.parseJSON(responseinfo);
          var item="";
        $.each(Resp, function(i, item) {                
                 $('#table').append("<tr>"
                    +"<td>"+item.nombre+"</td>"
                    +"<td class='text-right'><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='Agregar Cuenta' onclick='updateEntidad("+item.id+")'><i class='fa fa-edit'></i> </a><a class='btn btn-icon-only red' data-toggle='modal' href='#static' onclick='DeleteEntidad("+item.id+")'><i class='fa fa-minus'></i> </a></td>"
                    +"</tr>");    });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
    function Limpiar()
    {
       document.getElementById('entidad').value=""; 
       document.getElementById('idEntidad').value=""; 
    }
</script>
@endsection