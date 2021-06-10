@extends('layout.app')
@section('content')
<h3 class="page-title">Servicios <small>Pago Arrendamiento</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Servicios </a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Pago Arrendamiento</a>
        </li>
    </ul>
</div>

<div class="row">
     <div hidden="true">
  <a href="javascript:;" class="btn green" id="blockui_sample_3_1" >Block</a>
  <a href="javascript:;" class="btn default" id="blockui_sample_3_1_1" >Unblock</a></div>
  <div id="blockui_sample_3_1_element">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box blue" id="Addtable">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs"></i>Pago Arrendamiento
            </div>
        </div>
        <div class="portlet-body" id="divRemove">            
            <div class="row">           
                    <div class="col-md-12">
                        <div class="tabbable-line boxless tabbable-reversed">
                            <ul class="nav nav-tabs">
                                <!-----style="pointer-events:none;"  -->
                                <li class="active" style="pointer-events:none;">
                                    <a href="#tab_0" data-toggle="tab"><div id="circle_0"><i class="fa fa-circle-o"></i></div></a>
                                </li>
                                <li style="pointer-events:none;">
                                    <a href="#tab_1" data-toggle="tab"><div id="circle_1"><i class="fa fa-circle-o"></i></div></a>
                                </li > 
                                <li style="pointer-events:none;">
                                    <a href="#tab_2" data-toggle="tab"><div id="circle_2"><i class="fa fa-circle-o"></i></div></a>
                                </li>                        
                            </ul>
                            <div class="tab-content">                               
                                <div class="tab-pane active" id="tab_0">
                                    <h4><strong>Llene la siguiente información:</strong></h4>
                                    <hr><br>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="form-group">
                                                         <label for="nombre"class="col-md-5 control-label text-left"><strong>Nombre, Razón o Denominación Social:</strong></label>
                                                        <div class="col-md-7">
                                                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre, Razón o Denominación Social..." autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="rfc"class="col-md-5 control-label text-left"><strong>R.F.C:</strong></label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" name="rfc" id="rfc" placeholder="R.F.C..."autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="curp"class="col-md-5 control-label text-left"><strong>CURP:</strong></label>
                                                        <div class="col-md-7">
                                                            <input type="text" name="curp" id="curp" class="form-control" placeholder="CURP..."autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="calle"class="col-md-5 control-label text-left"><strong>Calle:</strong></label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" name="calle" id="calle" placeholder="Calle..."autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="nointerior"class="col-md-5 control-label text-left"><strong>No. Interior:</strong></label>
                                                        <div class="col-md-7">
                                                            <input type="text" name="nointerior" id="nointerior" class="form-control" placeholder="No. Interior...">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="noexterior"class="col-md-5 control-label text-left"><strong>No. Exterior:</strong></label>
                                                        <div class="col-md-7">
                                                            <input type="text" name="noexterior" id="noexterior" class="form-control" placeholder="No. Exterior...">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="colonia"class="col-md-5 control-label text-left"><strong>Colonia:</strong></label>
                                                        <div class="col-md-7">
                                                            <input type="text" name="colonia" id="colonia" class="form-control" placeholder="Colonia o Municipio...">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="municipio"class="col-md-5 control-label text-left"><strong>Municipio o Delegación:</strong></label>
                                                        <div class="col-md-7">
                                                            <input type="text" name="municipio" id="municipio" class="form-control" placeholder="Colonia o Municipio...">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="estado"class="col-md-5 control-label text-left"><strong>Estado, País:</strong></label>
                                                        <div class="col-md-7">
                                                            <input type="text" name="estado" id="estado" class="form-control" placeholder="Estado, País..." />
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="cp"class="col-md-5 control-label text-left"><strong>CP:</strong></label>
                                                        <div class="col-md-7">
                                                            <input type="text" name="cp" id="cp" class="form-control valida-num" placeholder="Codigo Postal...">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="correo"class="col-md-5 control-label text-left"><strong>Correo Electronico:</strong></label>
                                                        <div class="col-md-7">
                                                            <input type="text" name="correo" id="correo" class="form-control" placeholder="Correo Electronico...">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <hr>
                                                    
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="monto"class="col-md-5 control-label text-left"><strong>Monto:</strong></label>
                                                        <div class="col-md-7">
                                                            <input type="text" name="monto" id="monto" class="form-control valida-decimal" placeholder="Monto...">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="partida"class="col-md-5 control-label text-left"><strong>Partida:</strong></label>
                                                        <div class="col-md-7">
                                                            <select id="partida" class="select2me form-control">
                                                                <option value="limpia">Selecionar</option>
                                                                 <option value="31800">31800</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="concepto"class="col-md-5 control-label text-left"><strong>Concepto:</strong></label>
                                                        <div class="col-md-7">
                                                            <input type="text" name="concepto" id="concepto" class="form-control" placeholder="Concepto...">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-md-5">
                                                        </div>
                                                        <div class="col-md-7">
                                                            <button type="button" class="btn grey" onclick="addRegistro()">Agregar Pagos <i class="fa  fa-plus-square"></i></button>
                                                        </div>
                                                    </div>
                                                </div><br> 
                                                <div class="row">
                                                    <div id="addtable">
                                                        
                                                    </div>
                                                    
                                                </div>                                           
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-5">
                                            <button type="button" class="btn green" onclick="limpiar()"><i class="fa fa-eraser"></i> limpiar</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn blue" onclick="continuarprimary()"><i class="fa fa-check"></i> Continuar</button>
                                        </div>
                                    </div>
                                </div>
                                <!--**********************************************************************------>  
                                <div class="tab-pane" id="tab_1">
                                    <h4><strong>Compruebe la información:</strong></h4>
                                    <hr><br>
                                    
                                     <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-6 ">
                                                <div class="row">
                                                         <label class="col-md-6 text-left"><strong>Nombre, Razón o Denominación Social:</strong></label>
                                                         <label class="col-md-6" id="lbl_nombre">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-left"><strong>R.F.C:</strong></label>
                                                        <label class="col-md-6" id="lbl_rfc">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-left"><strong>CURP:</strong></label>
                                                        <label class="col-md-6" id="lbl_curp">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-left"><strong>Calle:</strong></label>
                                                        <label class="col-md-6" id="lbl_calle">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-left"><strong>No. Interior:</strong></label>
                                                        <label class="col-md-6" id="lbl_nointerior">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-left"><strong>No. Exterior:</strong></label>
                                                        <label class="col-md-6" id="lbl_noexterior">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-left"><strong>Colonio:</strong></label>
                                                        <label class="col-md-6" id="lbl_colonia">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-left"><strong> Municipio:</strong></label>
                                                        <label class="col-md-6" id="lbl_municipio">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-left"><strong>Estado, País:</strong></label>
                                                        <label class="col-md-6" id="lbl_estado">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-left"><strong>CP:</strong></label>
                                                        <label class="col-md-6" id="lbl_cp">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-left"><strong>Correo Electronico:</strong></label>
                                                        <label class="col-md-6" id="lbl_correo">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                    <div id="addtable2">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-5">
                                            <button type="button" class="btn green" onclick="atras_primary()"><i class="fa fa-undo"></i> Atras</button>
                                        </div>
                                        <div class="col-md-6 ">
                                            <button type="button" class="btn blue"  data-toggle='modal' href='#static' ><i class="fa fa-check"></i> Continuar</button>
                                        </div>
                                     </div>
                                </div>

                                <div class="tab-pane" id="tab_2">
                                    <h4><strong>Generando Referencia Bancaria:</strong></h4>
                                    <hr><br>
                                    <div class="row">                                        
                                        
                                            <div class="col-md-12">
                                            
                                               <i class="fa fa-circle"></i> <label>El Formato de pago unico en ventanilla bancaria se emitiracon fecha de vencimiento del </label>
                                               <label id="resp_fecha" style="font-weight: bold;">--------</label>. 
                                               <br>
                                               <i class="fa fa-circle"></i> <label>Una vez efectuando el pago en ventanilla bancaria, despues de 3 dias habiles, podra imprimir su formato electronico, capturando el numero de folio &nbsp; </label><label id="resp_folio"  style="font-weight: bold;">0000000</label> <label>en la opcion consultar folio en el <a href="#">portal tesoreria virtual</a>.</label>
                                               <br>
                                               <i class="fa fa-circle"></i> <label>En Caso de NO recibir el pago, a la fecha de vencimiento, el formato de pago unico en ventanilla, sera cancelado automaticamente. </label> 
                                            </div>
                                    </div>
                                    
                                    <hr>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-5">
                                            <button type="button" class="btn green" data-toggle='modal' href='#static2' ><i class="fa fa-undo"></i> Inicio</button>
                                        </div>
                                        <div class="col-md-6 ">
                                            <button type="button" class="btn blue" onclick="continuarthird()" ><i class="fa fa-file-pdf-o"></i> Ver Recibo</button>
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal-dialog -->
<div id="static" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>¿Continuar?</p>
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default" >Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="continuarsecondary()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<div id="static2" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>¿Continuar?</p>
                
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default" >Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="atras_second()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<div id="static3" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Confirmation</h4>
                <input type="text" name="idregistro" id="idregistro"  hidden="true">
            </div>
            <div class="modal-body">
                <p>¿Eliminar Registro?</p>
                
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default" >Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="delRegistro()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<input type="text" name="arraypagos" id="arraypagos" value="[]" hidden="true">
<input type="text" name="link" id="link" hidden="true">
<input type="text" name="contar" id="contar" hidden="true" value="0">
@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {
        ComponentsPickers.init();
    }); 
    function continuarthird()
    {   
        var link=$("#link").val();
        window.open(link, "ventana1" , "width=820,height=720,scrollbars=si");
        
    } 
    function continuarsecondary()
    {
        var nombre_=$("#nombre").val();
        var rfc_=$("#rfc").val();
        var curp_=$("#curp").val();
        var calle_=$("#calle").val();
        var nointerior_=$("#nointerior").val();
        var noexterior_=$("#noexterior").val();
        var colonia_=$("#colonia").val();
        var municipio_=$("#municipio").val();
        var estado_=$("#estado").val();
        var cp_=$("#cp").val();
        var pagos_=$("#arraypagos").val();
        var correo=$("#correo").val();
        $.ajax({
           method: "post",           
           url: "{{ url()->('pagoarrendamiento-insert') }}",
           data:{nombre:nombre_,rfc:rfc_,curp:curp_,calle:calle_,nointerior:nointerior_,noexterior:noexterior_,colonia:colonia_,municipio:municipio_,estado:estado_,cp:cp_,email:correo,pagos:pagos_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {             
            if(response=='[]'){
                Command: toastr.warning("Error al Generar la Referencia", "Notifications")
            }else{
            $('.nav-tabs a[href="#tab_2"]').tab('show');
            $("#circle_1 i").remove();
            $("#circle_1").append("<i class='fa fa-check-circle-o'></i>");
            $("#circle_2 i").remove();
            $("#circle_2").append("<i class='fa fa-check-circle-o'></i>");
             Command: toastr.success("Referencia Generado Correctamente!", "Notifications")
            var Resp=$.parseJSON(response);          
            $.each(Resp, function(i, item) { 
               $('#resp_folio').text(item.folio);
               document.getElementById('link').value=item.url;
               window.open(item.url, "ventana1" , "width=820,height=720,scrollbars=si");

            });
            }
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Partidas");  });
    }
    function partidas()
    {
        
        $.ajax({
           method: "post",           
           url: "{{ url()->('acceso-partidas') }}",
           data: {user:'{{ Auth::user()->id }}',_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
             //console.log(response);
          var Resp=$.parseJSON(response);
          $("#identretenciones option").remove();
           $('#identretenciones').append(
                "<option value='limpia'>Seleccionar</option>"
                );
            $.each(Resp, function(i, item) {                
                 $('#identretenciones').append(
                "<option value='"+item.id+"'>"+item.nombre+"</option>"
                );
               
            });
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Partidas");  });
    }
    function atras_primary()
    {
        $('.nav-tabs a[href="#tab_0"]').tab('show');
        $("#circle_0 i").remove();
        $("#circle_0").append("<i class='fa fa-circle-o'></i>");
    }
    function atras_second()
    {
        $('.nav-tabs a[href="#tab_0"]').tab('show');
        $("#circle_0 i").remove();
        $("#circle_0").append("<i class='fa fa-circle-o'></i>");
        $("#circle_1 i").remove();
        $("#circle_1").append("<i class='fa fa-circle-o'></i>");
        $("#circle_2 i").remove();
        $("#circle_2").append("<i class='fa fa-circle-o'></i>");
        limpiar();
    }
    function continuarprimary()
    {
        var nombre_=$("#nombre").val();
        var arrayP=$("#arraypagos").val();
        arrayP = JSON.parse(arrayP);

        if(nombre_.length<3)
        {
            Command: toastr.warning("Campo Nombre, Razón o Denominación Social, Requerido!", "Notifications")
        }else if(arrayP.length==0)
        { 
             Command: toastr.warning("Pagos ,Requerido!", "Notifications")
        }else{
            $('.nav-tabs a[href="#tab_1"]').tab('show');
            $("#circle_0 i").remove();
            $("#circle_0").append("<i class='fa fa-check-circle-o'></i>");
            confirmardatos();
        }
    }
    function confirmardatos()
    {
        var nombre_=$("#nombre").val();
        var rfc_=$("#rfc").val();
        var curp_=$("#curp").val();
        var calle_=$("#calle").val();
        var nointerior_=$("#nointerior").val();
        var noexterior_=$("#noexterior").val();
        var colonia_=$("#colonia").val();
        var municipio_=$("#municipio").val();
        var estado_=$("#estado").val();
        var cp_=$("#cp").val();
        var correo=$("#correo").val();
        $('#lbl_nombre').text(nombre_);
        $('#lbl_rfc').text(rfc_);
        $('#lbl_curp').text(curp_);
        $('#lbl_calle').text(calle_);
        $('#lbl_nointerior').text(nointerior_);
        $('#lbl_noexterior').text(noexterior_);
        $('#lbl_colonia').text(colonia_);
        $('#lbl_municipio').text(municipio_);
        $('#lbl_estado').text(estado_);
        $('#lbl_cp').text(cp_);
        $('#lbl_correo').text(correo);

        var arrayP=$("#arraypagos").val();
         arrayP = JSON.parse(arrayP);
        
        $("#addtable2 table").remove();
        $("#addtable2").append('<table class="table" id="table2"><thead><tr><th>partida</th><th>Concepto</th> <th>Monto</th><th></th> </tr> </thead><tbody></tbody></table>');
        $.each(arrayP, function(i, item) {
            $("#table2 tbody").append('<tr>'
                +'<td>'+item.partida+'</td>'
                +'<td>'+item.concepto+'</td>'
                +'<td>'+item.monto+'</td>'
                +'</tr>'
            );
        });
        
    }
    function addRegistro()
    {
        var arrayP=$("#arraypagos").val();
        var partida_=$("#partida").val();
        var concepto_=$("#concepto").val();
        var monto_=$("#monto").val();
        if(partida_=="limpia")
        {
            Command: toastr.warning("Seleccione una Partida, Requerido!", "Notifications")
        }else if(concepto_.length<1)
        {
            Command: toastr.warning("Campo Concepto, Requerido!", "Notifications")
        }else if(monto_.length<1)
        {   
            Command: toastr.warning("Campo Monto, Requerido!", "Notifications")
        }else{
           
            
            var contador=$("#contar").val();
            contador=contador+1;
            document.getElementById('contar').value=contador;
            var nRegistro={id:contador,partida:partida_,concepto:concepto_,monto:monto_};
            if(arrayP.length ==0){
                arrayP = [];
            }else{
                arrayP = JSON.parse(arrayP);

            }
            var contador=arrayP.length;
            if(contador==2)
            {
                Command: toastr.warning("Maximo 2 Registros", "Notifications")
            }else{
                arrayP.push(nRegistro);
                var saveP=JSON.stringify(arrayP);
                document.getElementById('arraypagos').value=saveP;
                addTableRegistos();
                limpiaP();

            }
        }       

    }
    function limpiaP() {
        document.getElementById('monto').value="";
        $("#partida").val("limpia").change();
        document.getElementById('concepto').value="";
    }
    function eliminarpartida(id)
    {
        document.getElementById('idregistro').value=id;
    }
    function delRegistro()
    {
        var id=$("#idregistro").val();
        var arrayP=$("#arraypagos").val();        
        arrayP = JSON.parse(arrayP);
        for (var i =0; i < arrayP.length; i++){
            if (arrayP[i].id === id) {
            arrayP.splice(i,1);
            }
        }
        var saveP=JSON.stringify(arrayP);
        document.getElementById('arraypagos').value=saveP;

        addTableRegistos();
    }
    function addTableRegistos()
    {
         var arrayP=$("#arraypagos").val();
         arrayP = JSON.parse(arrayP);
        var contador=arrayP.length;
        if(contador==0){
            $("#addtable table").remove();
        }else{
            $("#addtable table").remove();
            $("#addtable").append('<table class="table" id="table"><thead><tr><th>partida</th><th>Concepto</th> <th>Monto</th><th></th> </tr> </thead><tbody></tbody></table>');
            $.each(arrayP, function(i, item) {
                $("#table tbody").append('<tr>'
                    +'<td>'+item.partida+'</td>'
                    +'<td>'+item.concepto+'</td>'
                    +'<td>'+item.monto+'</td>'
                    +'<td> <a class="btn btn-icon-only red" href="#static3" data-toggle="modal" data-original-title="" title="Quitar" onclick="eliminarpartida(\''+item.id+'\')"><i class="fa fa-trash-o"></i></a></td>'
                    +'</tr>'
                );
            });
        }
        
    }
    function limpiar()
    {
        document.getElementById('nombre').value="";
        document.getElementById('rfc').value="";
        document.getElementById('curp').value="";
        document.getElementById('calle').value="";
        document.getElementById('colonia').value="";
        document.getElementById('municipio').value="";
        document.getElementById('estado').value="";
        document.getElementById('nointerior').value="";
        document.getElementById('nointerior').value="";
        document.getElementById('cp').value="";
        document.getElementById('correo').value="";
        document.getElementById('arraypagos').value="[]";
        $("#addtable table").remove();
        limpiaP();

    }
    function limpialabels()
    {
        $('#proyecto').text("Sin Asignar");
        
    }
    $('.valida-decimal').on('input', function () { 
        this.value = this.value.replace(/[^0-9.]/g,'');
    });
    $('.valida-num').on('input', function () { 
        this.value = this.value.replace(/[^0-9]/g,'');
    });
    function mayus(e) {
        e.value = e.value.toUpperCase();
        //onkeyup="mayus(this);"
    }

</script>
@endsection