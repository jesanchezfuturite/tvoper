@extends('layout.app')

@section('content')
<h3 class="page-title">Portal <small>Asignación de campos por trámite</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Portal</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Asignación de campos por trámite</a>
        </li>
    </ul>
</div>
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Info:</strong> Esta configuración te permite...
</div>
<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Tramites
            </div>
        </div>
        <div class="portlet-body">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-2 col-ms-12">
                        <div class="form-group">
                            <label >Tramites (Selecciona)</label>   
                        </div>
                    </div>
                    <div class="col-md-3 col-ms-12">
                        <div class="form-group">           
                            <select class="select2me form-control"name="itemsTramites" id="itemsTramites" onchange="changeTramites()">
                                <option value="limpia">------</option>
                               
                            </select>            
                        </div>
                    </div>
                    <div class="col-md-2 col-ms-12">
                        <div class="form-group" id="addButton">
                    
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
            <div class="portlet-title">
                
                <div class="caption" id="headerTabla">
                    <i class="fa fa-cogs"></i>&nbsp;<span id="nameTramite">Tramite</span> &nbsp;
                    <!--    <span class="label label-sm label-danger">
                            <label id='changeStatus'>No found</label> 
                        </span>&nbsp;&nbsp;&nbsp;&nbsp;
                        --->
                    
                </div>
                
                <div class="tools" id="removeBanco">                
                    <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="Agregar Cuenta">
                    </a>
                   <a id="Remov" href="javascript:;" data-original-title="" title="Desactivar Banco" onclick="desactivabanco()"><i class='fa fa-remove' style="color:white !important;"></i>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-hover" id="table">
                    <thead>
                    <tr>
                        <th>Tramite</th>
                        <th>Campo</th>
                        <th>Tipo</th>
                        <th>Caracteristicas</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>                   
                    <tr>
                     <td><span class="help-block">No Found</span></td>
                    </tr>                    
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->

</div>
<div class="modal fade bs-modal-lg" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="CleanInputs()"></button>
                <h4 class="modal-title">Configurar Tramite</h4>
            </div>
            <div class="modal-body">
                 <form action="#" class="form-horizontal">
                    <div class="form-body">
                        <input hidden="true" type="text"  placeholder="Ingrese una Cuenta" id="idRelantion">
                        <div class="modal-body">
                         <input hidden="true" type="text"  id="idupdate">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label >Campo</label>                            
                                        <select class="select2me form-control"  id="itemsCampo">
                                            <option>------</option>                                             
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Tipo</label>                            
                                        <select class="select2me form-control"  id="itemsTipo">
                                            <option>------</option>                                             
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label >Caracteristicas</label>                            
                                        <textarea  class="form-control" placeholder="Caracteristicas " id="caracteristica" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>  
                        </div>             
                    
                    <div class="form-group">
                        <div class="col-md-10"> 
                            <button type="button" class="btn blue" onclick="metodoSaveUpdate()"><i class="fa fa-check"></i> Guardar</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn default" onclick="CleanInputs()">Cerrar</button>
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
<div id="static2" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
             ¿Desactivar/Activar Registro?<br>
             <br> ¡Afectara a todos los <h style="color: #cb5a5e;">Tramites</h> relacionados con la <h style="color: #cb5a5e;">Cuenta Banco</h>!
                </p>
                 <input hidden="true" type="text" name="idregistro" id="idregistro" class="idregistro">
                 <input hidden="true" type="text" name="idstatus" id="idstatus" class="idstatus">
            </div>
            <div class="modal-footer">
                <div id="AddbuttonDeleted">
         <button type="button" data-dismiss="modal" class="btn default">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="desactiveCuenta()">Confirmar</button>
        </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="assets/global/scripts/validar_img.js" type="text/javascript"></script>

<script>
    jQuery(document).ready(function() {       
      findTramites();
      findCampos();
      findTipos();
    });
    function findTramites()
    {     
        $.ajax({
           method: "get",           
           url: "{{ url('/traux-get-serv') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        var Resp=$.parseJSON(response);
            $("#itemsTramites option").remove();
            $("#itemsTramites").append("<option value='limpia'>-------</option>");
            $.each(Resp, function(i, item) {                
                $("#itemsTramites").append("<option value='"+item.id+"'>"+item.desc+"</option>");
            
            });
        
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
          
    }
     function findCampos()
    {     

        $.ajax({
           method: "get",           
           url: "{{ url('/traux-get-camp') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            console.log(response);
            var Resp=$.parseJSON(response);
            $("#itemsCampo option").remove();
            $("#itemsCampo").append("<option value='limpia'>-------</option>");
            $.each(Resp, function(i, item) {                
                $("#itemsCampo").append("<option value='"+item.id+"'>"+item.desc+"</option>");
            
            });
        
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
          
    }
    function findTipos()
    {     
        $.ajax({
           method: "get",           
           url: "{{ url('/traux-get-tcamp') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        var Resp=$.parseJSON(response);
            $("#itemsTipos option").remove();
            $("#itemsTipos").append("<option value='limpia'>-------</option>");
            $.each(Resp, function(i, item) {                
                $("#itemsTipos").append("<option value='"+item.id+"'>"+item.desc+"</option>");
            
            });
        
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
           
    }
  
    function changeTramites()
    {
        var tramite=$("#itemsTramites").val();
        var tramiteMember=$("#itemsTramites option:selected").text();
        if(tramite=="limpia")
        {
            //Command: toastr.warning("Tramite Sin Seleccionar, Requeridoo!", "Notifications")
            document.getElementById("nameTramite").textContent="Tramite ";
        }else{
           document.getElementById("nameTramite").textContent="Tramite "+tramiteMember;
        }
    }
   
    
    
 function saveCampos() 
 {           
            
           
    $.ajax({
        method: "POST",
        url: "{{ url('/traux-get-tcamp') }}",
        data: {_token:'{{ csrf_token() }}'}  })
    .done(function (response) {
        
     
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
            return false;
    }
    function FindTramiteCampos()
    {
        var items=$("#itemsTramites").val();
       if(items=='limpia')
       {
        
       }else{
        
        $.ajax({
           method: "POST",           
           url: "{{ url('/banco-find') }}",
           data: {id:items,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        var Resp=$.parseJSON(response);
        $.each(Resp, function(i, item) {                
            

        });
        
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        Cuentas(items);   
       }
    }
    

    function insertTramiteCampos()
    {
        var itemTramite=$("#items").val();
        var metodopago_=$("#itemMetodopago").val();
        var cuenta=$("#cuenta").val();

       if(itemTramite=="limpia")
        { 
            Command: toastr.warning("Tramite Sin Seleccionar", "Notifications")
            //limpiaCuentapago();
         }
        else{
        $.ajax({
           method: "POST",           
           url: "{{ url('/cuentasbanco-insert') }}",
           data: {banco_id:banco, metodopago:metodopago_,beneficiario:formdata, monto_min:monto_min_, monto_max:monto_max_, fechaIn:fechaIn_, _token:'{{ csrf_token() }}'}  
       })
        .done(function (response) {
        CleanInputs();
        Command: toastr.success("Success", "Notifications")     
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        }
    }
    function CleanInputs()
    {
         document.getElementById('caracteristica').value="";
         //document.getElementById('itemMetodopago').value="limpia";
         $("#itemsTipo").val("limpia").change();
         $("#itemsCampo").val("limpia").change();
         document.getElementById('idRelantion').value="";
        $("#checkbox30").prop("checked", false);            
        
    }
    function editarCuenta(id_)
    {
        document.getElementById('idCuenta').value=id_;

         $.ajax({
           method: "POST",           
           url: "{{ url('/cuentasbanco-edit') }}",
           data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        
            
            document.getElementById('cuenta').value=Cuent;
            document.getElementById('servicio').value=Serv;
            document.getElementById('leyenda').value=ley;
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        

    }

    function updatecuenta()
    {   
        var idCuenta=$("#idCuenta").val();        
        var metodopago_=$("#itemMetodopago").val();
        var cuenta=$("#cuenta").val();
        var cuenta=$("#cuenta").val();
        
       if(metodopago_=="limpia")
        { 
            Command: toastr.warning("No Success", "Notifications")
            limpiaCuentapago();
         }
        else{
        $.ajax({
           method: "POST",           
           url: "{{ url('/cuentasbanco-update') }}",
           data: {id:idCuenta, metodopago:metodopago_,beneficiario:formdata, monto_min:monto_min_, monto_max:monto_max_, fechaIn:fechaIn_, _token:'{{ csrf_token() }}'}  
       })
        .done(function (response) {
        if(response=="true"){
            Command: toastr.success("Success", "Notifications")
           limpiaCuentapago();
            CuentasBanco();
        }
        else{
            Command: toastr.warning("No Success", "Notifications") 
        }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        }
    }
    function metodoSaveUpdate()
    {
        var cuenta=$("#cuenta").val();
        var servicio=$("#servicio").val();
        var leyenda=$("#leyenda").val();
        if(idbacon=="limpia"){
           
       }else{
            validaExisteMtodoP();
      }
    }
    
</script>

@endsection
