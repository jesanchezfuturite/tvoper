@extends('layout.app')

@section('content')
<h3 class="page-title">Motor de pagos <small>Bancos</small></h3>
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
            <a href="#">Bancos</a>
        </li>
    </ul>
</div>
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Info:</strong> Esta configuración te permite la activación de un banco incluyendo el logo con el que ira a mostrarse en las fichas, asignar la cuenta o claves, método de pago y sus montos mínimo o máximo para pago. Esta misma es posible activar o desactivar en el momento que el usuario le solicite además de su edición.
</div>
<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Agregar Banco
            </div>
        </div>
        <div class="portlet-body">
        <div class="form-body">
        <div class="row">
            <div class="col-md-2 col-ms-12">
                <div class="form-group">
                    <label class="sr-only" for="bancoNombre">Nuevo Banco</label>
                    <input type="text" class="form-control" id="bancoNombre"name="bancoNombre" autocomplete="off"placeholder="Nuevo Banco">
                </div>
            </div>
            <div class="col-md-1 col-ms-12">
                <div class="form-group">
                <span class="btn green fileinput-button">
                                <i class="fa fa-plus"></i>&nbsp;
                                <span>
                                Logo... </span>
                                <input type="file" name="file" id="file">
                                </span>
                </div>
                </div>
                 <div class="col-md-1 col-ms-12">
                <div class="form-group">
                <button type="button" class="btn btn-default" onclick="SaveBanco()">Agregar</button>
              </div>
            </div>
                 <div class="col-md-3 col-ms-12">
                <div class="form-group">
                    <label >Bancos Registrados (Selecciona para ver las cuentas)</label>   
                  </div>
                </div>
                <div class="col-md-3 col-ms-12">
                <div class="form-group">           
                        <select class="select2me form-control"name="items" id="items" onchange="CuentasBanco()">
                           <option value="limpia">------</option>
                           @foreach( $saved_banco as $sd)
                            <option value="{{$sd["id"]}}">{{$sd["nombre"]}}</option>
                            @endforeach
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
            <div class="portlet-title">
                
                <div class="caption" id="headerTabla">
                  <div id="borraheader">  <i class="fa fa-cogs"></i> Cuentas &nbsp;<span class="label label-sm label-danger">
                    No Found </span>&nbsp;&nbsp;&nbsp;&nbsp;</div>
                </div>
                <div class="caption">              
                <div class="md-checkbox has-info" >
                   <input type="checkbox" id="checkbox10" class="md-check" onclick="Check()" >
                   <label for='checkbox10' style="color:white !important;"><span></span>
                    <span class='check'style="border-color: white !important;"></span><span class='box'style="border-color: white !important;"></span>Conciliar
                    </label>
                </div> 
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
                        <th>Cuenta</th>
                        <th>Servicio / CIE / CLABE</th>
                        <th>Leyenda</th>
                        <th>Alias</th>
                        <th>Método de pago</th>
                        <th>Monto Mínimo</th>
                        <th>Monto Máximo</th>
                        <th>&nbsp;</th>
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
<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiaCuentapago()"></button>
                <h4 class="modal-title">Configurar Nueva Cuenta</h4>
            </div>
            <div class="modal-body">
                 <form action="#" class="form-horizontal">
                    <div class="form-body">
                        <input hidden="true" type="text"  placeholder="Ingrese una Cuenta" id="idCuenta">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Método de Pago</label>
                            <div class="col-md-6">
                                <select class="select2me form-control"  id="itemMetodopago">
                                    <option>------</option>                                             
                                </select>   
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Cuenta</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Ingrese una Cuenta" id="cuenta">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Servicio / CIE / CLABE</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Ingrese el Servicio / CIE / CLABE " id="servicio" maxlength="18">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Leyenda</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Ingrese la Leyenda" id="leyenda">
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Alias</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Ingrese el Alias" id="alias">
                            </div>                            
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Monto Mínimo</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" placeholder="Ingrese el Monto" id="monto_min">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Monto Máximo</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" placeholder="Ingrese el Monto" id="monto_max" oninput="prueba(this);"min="1" max="999999999.99" step="0.01">
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-6">
                                    <button type="button" class="btn blue" onclick="metodoSaveUpdate()">Guardar</button>
                                    <button type="button" data-dismiss="modal" class="btn default" class="close" onclick="limpiaCuentapago()">Cancelar</button>
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
      itemMetodopago();
    });
    
    function Check()
    {
        var banco=$("#items").val();
        if(banco=="limpia")
        {
            Command: toastr.warning("Banco Sin Seleccionar, Requeridoo!", "Notifications")
        }else{
            updateStatusConciliacion();
        }
    }
   function updateStatusConciliacion()
   {
          var idbanco= $("#items").val();    
        $.ajax({
           method: "POST",           
           url: "{{ url('/banco-concilia-update') }}",
           data: {id:idbanco,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            
            if(response=="true")
            {
                Command: toastr.success("Actualizado Correctamente!", "Notifications")
            }else{
                Command: toastr.warning("Error al Actualizar!", "Notifications")
            }
        })
        .fail(function( msg ) {
         console.log("Error al Actualizar");  });
    }
    
    function SaveBanco()
    {
    var nombre=$("#bancoNombre").val();
    var file=$("#file").val();
    if(nombre.length==0)
    {
    Command: toastr.warning("Nombre del Banco Requerido!", "Notifications")
    }else if(file.length==0)
      { 
         Command: toastr.warning("Archivo Requerido!", "Notifications")
    }else{
          $.ajax({
           method: "get",           
           url: "{{ url('/banco-find-allWhere') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        var Resp=$.parseJSON(response);
        var Banco="";
        var coincidencia=0;
        $.each(Resp, function(i, item) {
          Banco=item.nombre;
         if(Banco.toLowerCase()==nombre.toLowerCase())
        {
          coincidencia=coincidencia+1;
        } 
        });
        if(coincidencia==0)
        {
          guardarBanco();
        }
        else{
          Command: toastr.warning("Banco Ya Se Encuentra Registrado!", "Notifications")
          
        }
      })
        .fail(function( msg ) {
         console.log("Error al Cargar items");  }); 
    }
 }

 function guardarBanco() 
 {           
            var imagenV = $("#file")[0].files[0];  
            var fecha_=new Date();
            var fechaIn=fecha_.getFullYear() + "-" + (fecha_.getMonth() + 1) + "-" + fecha_.getDate() + " " + fecha_.getHours() + ":" + fecha_.getMinutes() + ":" + fecha_.getSeconds();  
            var nombre=$("#bancoNombre").val();         
             var formdata = new FormData();
             formdata.append("file", imagenV);
             formdata.append("nombre", nombre);
             formdata.append("fechaIn", fechaIn);
             formdata.append("estatus", '1');
             formdata.append("_token", '{{ csrf_token() }}');
            $.ajax({
           method: "POST",
            contentType: false,
            processData: false,
           url: "{{ url('/banco-insert') }}",
           data: formdata  })
        .done(function (responseinfo) { 
            $("#items option").remove();
        var Resp=$.parseJSON(responseinfo);     
        Command: toastr.success("Success", "Notifications") 
        document.getElementById('bancoNombre').value="";
        document.getElementById('file').value="";
         $('#items').append(
                "<option value='limpia'>------</option>"
        );
        $.each(Resp, function(i, item) {                
                 $('#items').append(
                "<option value='"+item.id+"'>"+item.nombre+"</option>"
                   );
                });
     })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
            return false;
    }
    function CuentasBanco()
    {
        var items=$("#items").val();
        var banco=$("#items option:selected").text();
        var est;
        var concilia;
        var estadoBanco="";
        var estadolabel="";
        var iconB="";
       if(items=='limpia')
       {
        $("#borraheader").remove();     
        $("#headerTabla").append(" <div id='borraheader'><i class='fa fa-cogs'></i>Cuentas &nbsp;<span class='label label-sm label-danger'>No Found</span>&nbsp;&nbsp;&nbsp;&nbsp;</div></div>");   
        $("#table tbody tr").remove();
        $('#table tbody').append("<tr>"
            +"<td><span class='help-block'>No Found</span></td>"
            +"</tr>");
        $("#checkbox10").prop("checked", false);
       }
        else
       {
       
        $("#borraheader").remove();
        $.ajax({
           method: "POST",           
           url: "{{ url('/banco-find') }}",
           data: {id:items,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        var Resp=$.parseJSON(response);
        $.each(Resp, function(i, item) {                
        est=item.status;
        concilia=item.conciliacion;         
        });
        if(est==1)
        {
            estadoBanco="Activa";
            estadolabel="success";
            iconB="Desactivar Banco";
        }
        else
        {
            estadoBanco="Inactiva";
            estadolabel="danger";
            iconB="Activar Banco";
        }
        if(concilia==1)
        {
            $("#checkbox10").prop("checked", true);            
        }else{
            $("#checkbox10").prop("checked", false);            
        }
       $("#headerTabla").append(" <div id='borraheader'><i class='fa fa-cogs'></i>Cuentas "+banco+"&nbsp;<span class='label label-sm label-"+estadolabel+"'>"+estadoBanco+"</span>&nbsp;&nbsp;&nbsp;</div></div>");
          $("#Remov").remove();
        $("#removeBanco").append("<a id='Remov' href='javascript:;' data-original-title='' title='"+iconB+"' onclick='desactivabanco()'><i class='fa fa-remove' style='color:white !important;'></i> </a>");
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        Cuentas(items);   
       }
    }
    function Cuentas(items){
     $.ajax({
           method: "POST",           
           url: "{{ url('/cuentasbanco-find') }}",
           data: {id:items,_token:'{{ csrf_token() }}'}  
       })
        .done(function (responseinfo) {                    
        var Resp=$.parseJSON(responseinfo);     
        tablacuentasbanco(Resp);
     })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }

    function tablacuentasbanco(Resp)
    { 
        var item="";
        var item2="";
        var status="";
        var label="";
        var msgg="";
        var icon="";
         var min=0;
         var max=0;
        $("#table tbody tr").remove();        
        $.each(Resp, function(i, item) {
         var Serv="";
        var Cuent=""; 
        var Ley=""; 
        var ali=""; 
            var Mtdo=$.parseJSON(item.beneficiario);
            $.each(Mtdo, function(ii, item2) {
                Serv=item2.servicio;
                Cuent=item2.cuenta;                
                Ley=item2.leyenda;                
                ali=item2.alias;                
            });            
            status=item.status;    
            if (status=='1') 
                { label="success";
                     msgg="Activa";
                     icon="red"; }
                else
               { label="danger";
                     msgg="Inactiva"; 
                     icon="green";  }
                     max=item.monto_max;
                     min=item.monto_min;
            $('#table tbody').append("<tr>"
            +"<td>"+Cuent+"</td>"
            +"<td>"+Serv+" &nbsp;<span class='label label-sm label-"+label+"'>"+msgg+"</span></td>"
            +"<td>"+Ley+"</td>"
            +"<td>"+ali+"</td>"
            +"<td>"+item.metodopago+"</td>"
            +"<td>$"+min.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+"</td>"
            +"<td>$"+max.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+"</td>"
            +"<td><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='Editar' onclick='editarCuenta("+item.id+")'><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only "+icon+"' data-toggle='modal' href='#static2' onclick='desactivarCuenta("+item.id+","+item.status+")'><i class='fa fa-power-off'></i></a></td>"
            +"</tr>");
        });
    }

    function insertCuentaB()
    {
        var banco=$("#items").val();
        var metodopago_=$("#itemMetodopago").val();
        var cuenta=$("#cuenta").val();
        var servicio=$("#servicio").val();
        var leyenda=$("#leyenda").val();
        var alias=$("#alias").val();
        var monto_max_=$("#monto_max").val();
        var monto_min_=$("#monto_min").val();        
        var formdata = '[{"cuenta":"'+cuenta+'","servicio":"'+servicio+'","leyenda":"'+leyenda+'","alias":"'+alias+'"}]';             
        var fecha_=new Date();
        var fechaIn_=fecha_.getFullYear() + "-" + (fecha_.getMonth() + 1) + "-" + fecha_.getDate() + " " + fecha_.getHours() + ":" + fecha_.getMinutes() + ":" + fecha_.getSeconds();  


       if(banco=="limpia")
        { 
            Command: toastr.warning("Banco Sin Seleccionar", "Notifications")
            limpiaCuentapago();
         }
        else{
        $.ajax({
           method: "POST",           
           url: "{{ url('/cuentasbanco-insert') }}",
           data: {banco_id:banco, metodopago:metodopago_,beneficiario:formdata, monto_min:monto_min_, monto_max:monto_max_, fechaIn:fechaIn_, _token:'{{ csrf_token() }}'}  
       })
        .done(function (response) {
        limpiaCuentapago();
        CuentasBanco(); 
        Command: toastr.success("Success", "Notifications")     
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        }
    }
    function limpiaCuentapago()
    {
         document.getElementById('cuenta').value="";
         document.getElementById('servicio').value="";
         document.getElementById('leyenda').value="";
         document.getElementById('alias').value="";
         document.getElementById('monto_max').value="";
         document.getElementById('monto_min').value=""; 
         //document.getElementById('itemMetodopago').value="limpia";
         $("#itemMetodopago").val("limpia").change();
         document.getElementById('idCuenta').value="";
    }
    function itemMetodopago()
    {
        $.ajax({
           method: "get",           
           url: "{{ url('/metodopago-find') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            $("#itemMetodopago option").remove();
        var Resp=$.parseJSON(response);
        $('#itemMetodopago').append(
            "<option value='limpia'>------</option>"
        );
        $.each(Resp, function(i, item) {                
                 $('#itemMetodopago').append(
                "<option value='"+item.id+"'>"+item.nombre+"</option>"
                   );
                });
        })
        .fail(function( msg ) {
         console.log("Error al Cargar items");  }); 
    }
    function desactivarCuenta(id_,status_)
    {
        document.getElementById('idregistro').value=id_;
        document.getElementById('idstatus').value=status_;
    }
    function desactiveCuenta()
    {
      var id_=$("#idregistro").val();
      var status_=$("#idstatus").val();
      var estatus="";
        if(status_==1)
            {
                estatus=0;
            }else{ estatus=1;}

        $.ajax({
           method: "post",           
           url: "{{ url('/cuentasbanco-desactiva') }}",
           data: {id:id_,status:estatus,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            if(!response)
            {
                 Command: toastr.warning("No Success", "Notifications")
            }
            else{
              Command: toastr.success("Success", "Notifications")
              CuentasBanco();}
        })
        .fail(function( msg ) {
         console.log("Error al Cargar items");  });
    }
    function editarCuenta(id_)
    {
        document.getElementById('idCuenta').value=id_;

         $.ajax({
           method: "POST",           
           url: "{{ url('/cuentasbanco-edit') }}",
           data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        
            var item="";
            var item2="";             
            var Resp=$.parseJSON(response);      
            $.each(Resp, function(i, item) {
            var Serv="";
            var Cuent="";             
            var ley="";             
            var ali="";

            var Mtdo=$.parseJSON(item.beneficiario);
            $.each(Mtdo, function(ii, item2) {
                Serv=item2.servicio;
                Cuent=item2.cuenta;
                ley=item2.leyenda; 
                ali=item2.alias;               
            });
             document.getElementById('cuenta').value=Cuent;
            document.getElementById('servicio').value=Serv;
            document.getElementById('leyenda').value=ley;
            document.getElementById('alias').value=ali;
            document.getElementById('monto_max').value=item.monto_max;
             document.getElementById('monto_min').value=item.monto_min; 
            //document.getElementById('itemMetodopago').value=item.metodopago_id;
              $("#itemMetodopago").val(item.metodopago_id).change();

            });
          
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        

    }

    function updatecuenta()
    {   
        var idCuenta=$("#idCuenta").val();        
        var metodopago_=$("#itemMetodopago").val();
        var cuenta=$("#cuenta").val();
        var servicio=$("#servicio").val();
        var leyenda=$("#leyenda").val();
        var alias=$("#alias").val();
        var monto_max_=$("#monto_max").val();
        var monto_min_=$("#monto_min").val();        
        var formdata = '[{"cuenta":"'+cuenta+'","servicio":"'+servicio+'","leyenda":"'+leyenda+'","alias":"'+alias+'"}]';             
        var fecha_=new Date();
        var fechaIn_=fecha_.getFullYear() + "-" + (fecha_.getMonth() + 1) + "-" + fecha_.getDate() + " " + fecha_.getHours() + ":" + fecha_.getMinutes() + ":" + fecha_.getSeconds();     
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
        var alias=$("#alias").val();
        var monto_max=$("#monto_max").val();
        var monto_min=$("#monto_min").val();
        var metodP=$("#itemMetodopago").val();
        var idbacon=$("#items").val();
        if(idbacon=="limpia"){
            Command: toastr.warning("Banco Sin Seleccionar Requerido!", "Notifications")
            }else if(metodP=="limpia")
            {              
              Command: toastr.warning("Campo Metodo de Pago Requerido!", "Notifications")
              document.getElementById("itemMetodopago").focus(); 
            }else if(cuenta.length<8){
              Command: toastr.warning("Campo Cuenta Requerido! 8 Caracteres Min.", "Notifications")
              document.getElementById("cuenta").focus();
            }else if(servicio.length<1 ){
               Command: toastr.warning("Campo Servicio Requerido! 1 a 18 Caracteres.", "Notifications")
               document.getElementById("servicio").focus();
            }else if(leyenda.length<1 ){
               Command: toastr.warning("Campo Leyenda Requerido!", "Notifications")
               document.getElementById("leyenda").focus();
            }else if(alias.length<1 ){
               Command: toastr.warning("Campo Alias Requerido!", "Notifications")
               document.getElementById("alias").focus();
            }else if(monto_min.length<1){
              Command: toastr.warning("Campo Monto Min. Requerido! 1 Caracteres Min.", "Notifications")
              document.getElementById("monto_min").focus();
            }else if(monto_max.length<1){
             Command: toastr.warning("Campo Monto Max. Requerido! 1 Caracteres Min.", "Notifications")
             document.getElementById("monto_max").focus();
          }else if (parseFloat(monto_max) <= parseFloat(monto_min)) {
         Command: toastr.warning("Campo Monto Max. debe ser Mayor al Monto Min.", "Notifications")
       }else{
            validaExisteMtodoP();
      }
    }
    function validaExisteMtodoP()
    {
      var metodP=$("#itemMetodopago").val();
      var idbacon=$("#items").val();
      var cuenta_=$("#cuenta").val();
      var idcuenta=$("#idCuenta").val();      
      var monto_max=$("#monto_max").val();
      var monto_min=$("#monto_min").val();
      $.ajax({
           method: "POST",           
           url: "{{ url('/cuentasbanco-find-where') }}",
           data: {id:idbacon,metodopago:metodP,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        var item="";
        var item2="";
        var Resp=$.parseJSON(response);
        var cuenta="";
        var max="";
        var min="";
        //var contadorCuenta=0;
        //var ContadorMonto=0;
       /* $.each(Resp, function(i, item) {                
              var beneficiario=$.parseJSON(item.beneficiario);
              max=item.monto_max;
              min=item.monto_min;
               $.each(beneficiario, function(ii, item2) {  
                cuenta=item2.cuenta;
              });
               if(parseFloat(idcuenta)!==parseFloat(item.id)){
              if(cuenta==cuenta_)
               {
                contadorCuenta=contadorCuenta+1;
               }
              if(parseFloat(monto_min)>=parseFloat(min) && parseFloat(monto_min) <parseFloat(max))
               {
                ContadorMonto=ContadorMonto+1;
               }
              if(parseFloat(monto_max)>parseFloat(min) && parseFloat(monto_max)<=parseFloat(max)){
                ContadorMonto=ContadorMonto+1;
               }
             }
              //console.log(parseFloat(min)+"  "+parseFloat(max) +" -- " + parseFloat(monto_min)+"  "+parseFloat(monto_max) );

          });*/
        //console.log(" contador:"+ContadorMonto);
       // if(contadorCuenta>0)
       // {
        //   Command: toastr.warning("La Cuenta Ya Existe A Un Tipo de Metodo de Pago!", "Notifications") 
       // }else if(ContadorMonto>0){
        //  Command: toastr.warning("El Monto Minimo y Maximo se Cruza Con Otra Cuenta", "Notifications")
        //}else{
          if(idcuenta=="")
            {
            insertCuentaB();
             }
             else
            {
            updatecuenta();
            }
       // }
        })
        .fail(function( msg ) {
         console.log(msg);  });
    } 
    function desactivabanco()
    {
        var items=$("#items").val();
        var estatus="";
        var banco=$("#items option:selected").text();
         var est;       
        if(banco=="limpia")
        {
           Command: toastr.warning("No Success", "Notifications") 
        }
        else{ 
         $("#borraheader").remove();
        
        $.ajax({
           method: "POST",           
           url: "{{ url('/banco-find') }}",
           data: {id:items,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        var item="";
        var Resp=$.parseJSON(response);
        $.each(Resp, function(i, item) {                
        est=item.status;         
            });  
        if(est==1)
        {
            estatus="0";
            desactiva(estatus);         
        }
        else
        {
            estatus="1";
            desactiva(estatus);   
        }      
        
        })
        .fail(function( msg ) {
         console.log(msg);  });
        }
    }
    function desactiva(estatus)
    {
        var items=$("#items").val();
         var banco=$("#items option:selected").text();
        var estadoBanco="";
        var estadolabel="";
        var est;
        var iconB="";
         $.ajax({
           method: "POST",           
           url: "{{ url('/banco-status-update') }}",
           data: {id:items,status:estatus,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        var item="";
        var Resp=$.parseJSON(response);
        $.each(Resp, function(i, item) { 
            est=item.status;         
        });
        Command: toastr.success("Success", "Notifications")
        if(est==1)
        {
           estadoBanco="Activa";
            estadolabel="success";
            iconB="Desactivar Banco";           
        }
        else
        {
             estadoBanco="Inactiva";
            estadolabel="danger";
            iconB="Activar Banco";
        } 
        $("#borraheader").remove();
       $("#headerTabla").append(" <div id='borraheader'><i class='fa fa-cogs'></i>Cuentas "+banco+"&nbsp;<span class='label label-sm label-"+estadolabel+"'>"+estadoBanco+"</span>&nbsp;&nbsp;&nbsp;</div></div>");
        $("#Remov").remove();
        $("#removeBanco").append("<a id='Remov' href='javascript:;' data-original-title='' title='"+iconB+"' onclick='desactivabanco()'><i class='fa fa-remove' style='color:white !important;'></i></a>");
        
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  }); 
    }    
    function prueba(n) {
       var num = n.value;
        var vew;
       if (parseFloat(num) >= 1&& parseFloat(num) <= 999999999.99) {
         
       } else {  
            vew= num.substring(0,num.length-1)    
           document.getElementById('monto_max').value=vew;
 
       }
    }
</script>

@endsection
