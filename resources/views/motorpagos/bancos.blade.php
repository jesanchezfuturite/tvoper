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
<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Agregar Banco
            </div>
        </div>
        <div class="portlet-body">
            <form class="form-inline" role="form">
                <div class="form-group">
                    <label class="sr-only" for="bancoNombre">Nuevo Banco</label>
                    <input type="text" class="form-control" id="bancoNombre"name="bancoNombre" placeholder="Nuevo Banco">
                </div>
                <div class="form-group">
                <span class="btn green fileinput-button">
                                <i class="fa fa-plus"></i>
                                <span>
                                Add Logo... </span>
                                <input type="file" name="file" id="file">
                                </span>
                </div>
                <button type="button" class="btn btn-default" onclick="guardarBanco()">Agregar</button>
                <div class="form-group">
                    <label >&nbsp;&nbsp;Bancos Registrados (Selecciona para ver las cuentas)</label>             
                        <select class="form-control"name="items" id="items" onchange="CuentasBanco()">
                           <option value="limpia">------</option>
                           @foreach( $saved_banco as $sd)
                            <option value="{{$sd["id"]}}">{{$sd["nombre"]}}</option>
                            @endforeach
                        </select>            
                </div> 
            </form>
        </div>
    </div>
</div>
<div class="row">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption" id="headerTabla">
                  <div id="borraheader">  <i class="fa fa-cogs"></i>Cuentas Bancomer &nbsp;<span class="label label-sm label-success">
                            Activa </span></div>
                </div>
                <div class="tools">
                    <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="Agregar Cuenta">
                    </a>
                    <a href="javascript:;" class="remove" data-original-title="" title="Desactivar Banco">
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Configurar Nueva Cuenta</h4>
            </div>
            <div class="modal-body">
                 <form action="#" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Método de Pago</label>
                            <div class="col-md-4">
                                <select class="form-control"  >
                                    <option>------</option>
                                    <option>Tarjeta de Credito</option>
                                    <option>Tarjeta de Debito</option>
                                    <option>Referencia Bancaria</option>
                                </select>   
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Cuenta</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Enter text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Servicio / CIE / CLABE</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Enter text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Monto Mínimo</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Enter text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Monto Máximo</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Enter text">
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-6">
                                    <button type="submit" class="btn blue">Guardar</button>
                                    <button type="button" class="btn default">Cancelar</button>
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

@endsection

@section('scripts')
<script>
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
        var estadoBanco="";
        var estadolabel="";
       if(items=='limpia')
       {
        $("#borraheader").remove();
     
        $("#headerTabla").append(" <div id='borraheader'><i class='fa fa-cogs'></i>Cuentas &nbsp;<span class='label label-sm label-danger'>No Found</span></div></div>");   
        $("#table tbody tr").remove();
        $('#table tbody').append("<tr>"
            +"<td><span class='help-block'>No Found</span></td>"
            +"</tr>");
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
            });
        if(est==1)
        {
            estadoBanco="Activa";
            estadolabel="success";
        }
        else
        {
            estadoBanco="Inactiva";
            estadolabel="danger";
        }
       $("#headerTabla").append(" <div id='borraheader'><i class='fa fa-cogs'></i>Cuentas "+banco+"&nbsp;<span class='label label-sm label-"+estadolabel+"'>"+estadoBanco+"</span></div></div>");
         
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
        Command: toastr.success("Success", "Notifications")            
        var Resp=$.parseJSON(responseinfo);     
        tablacuentasbanco(Resp);
     })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }

    function tablacuentasbanco(Resp)
    { 
        console.log(Resp);
        var item="";
        var item2="";
        var status="";
        var label="";
        var msgg="";
        var icon="";
       
        $("#table tbody tr").remove();        
        $.each(Resp, function(i, item) {
         var Serv="";
        var Cuent=""; 
            var Mtdo=$.parseJSON(item.beneficiario);
            $.each(Mtdo, function(ii, item2) {
                Serv=item2.servicio;
                Cuent=item2.cuenta;
                console.log(Serv);
            });
            console.log(Mtdo);
        status=item.status;    
            if (status=='1') 
                { label="success";
                     msgg="Activa";
                     icon="red"; }
                else
               { label="danger";
                     msgg="Inactiva"; 
                     icon="green";  }
            $('#table tbody').append("<tr>"
            +"<td>"+Cuent+"</td>"
            +"<td >"+Serv+" &nbsp;<span class='label label-sm label-"+label+"'>"+msgg+"</span></td>"
            +"<td>"+item.metodopago+"</td>"
            +"<td>"+item.monto_min+"</td>"
            +"<td>"+item.monto_max+"</td>"
            +"<td><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='Editar' onclick='editarCuenta("+item.id+")'><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only "+icon+"' onclick='desactivarCuenta("+item.id+")'><i class='fa fa-power-off'></i></a></td>"
            +"</tr>");
        });
    }
    function desactivabanco()
    {
        var items=$("#items").val();
        var banco=$("#items option:selected").text();
         var est;
        var estadoBanco="";
        var estadolabel="";
         $("#borraheader").remove();
        $.ajax({
           method: "POST",           
           url: "{{ url('/banco-find') }}",
           data: {id:items,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        var Resp=$.parseJSON(response);
        $.each(Resp, function(i, item) {                
        est=item.status;         
            });
        if(est==1)
        {
            estadoBanco="Activa";
            estadolabel="success";
        }
        else
        {
            estadoBanco="Inactiva";
            estadolabel="danger";
        }
       $("#headerTabla").append(" <div id='borraheader'><i class='fa fa-cogs'></i>Cuentas "+banco+"&nbsp;<span class='label label-sm label-"+estadolabel+"'>"+estadoBanco+"</span></div></div>");
         
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
         "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "4000",
         "extendedTimeOut": "1000"
        }     
</script>

@endsection
