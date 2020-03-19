@extends('layout.app')
@section('content')
<h3 class="page-title">Servicios Generales <small>Retenciones al Millar</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Servicios Generales </a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Retenciones al Millar</a>
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
                <i class="fa fa-cogs"></i>Retenciones al Millar
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
                                            <div class="col-md-6 ">
                                                <div class="row">
                                                    <div class="form-group">
                                                         <label for="ejercicio"class="col-md-6 control-label text-right"><strong>Ejercicio Fiscal:</strong></label>
                                                        <div class="col-md-6">
                                                            <select id="ejercicio" class="select2me form-control" onchange="changepartidas()">
                                                                <option value="limpia">Selecionar</option>
                                                                <option value="2015">2015</option>
                                                                <option value="2016">2016</option>
                                                                <option value="2017">2017</option>
                                                                <option value="2018">2018</option>
                                                                <option value="2019">2019</option>
                                                                <option value="2020">2020</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="identretenciones"class="col-md-6 control-label text-right"><strong>Identificación de las retenciones:</strong></label>
                                                        <div class="col-md-6">
                                                            <select id="identretenciones" class="select2me form-control" disabled>
                                                                <option value="limpia">Seleccionar</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="folio"class="col-md-6 control-label text-right"><strong>Folio SIE(PEI) Autorización:</strong></label>
                                                        <div class="col-md-6">
                                                            <input type="text" name="folio" id="folio" class="form-control" placeholder="Folio...">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="modejecucion"class="col-md-6 control-label text-right"><strong>Modalidad de Ejecución:</strong></label>
                                                        <div class="col-md-6">
                                                            <select id="modejecucion" class="select2me form-control" >
                                                                <option value="limpia">Seleccionar</option>
                                                                <option value="2">Contrato</option>
                                                                <option value=""></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="refcontrato"class="col-md-6 control-label text-right"><strong>Referencia del Contrato:</strong></label>
                                                        <div class="col-md-6">
                                                            <input type="text" name="refcontrato" id="refcontrato" class="form-control" placeholder="Referencia del Contrato...">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="nofactura"class="col-md-6 control-label text-right"><strong>Numero de Factura:</strong></label>
                                                        <div class="col-md-6">
                                                            <input type="text" name="nofactura" id="nofactura" class="form-control" placeholder="No. Factura...">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="estpagada"class="col-md-6 control-label text-right"><strong>Estimación Pagada: <br>(Numero de Control de Pago)</strong></label>
                                                        <div class="col-md-6">
                                                            <input type="text" name="estpagada" id="estpagada" class="form-control valida-decimal" placeholder="Estimación Pagada...">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="fecharet"class="col-md-6 control-label text-right"><strong>Fecha de Retención:</strong></label>
                                                        <div class="col-md-6">
                                                            <input type="text" name="fecharet" id="fecharet" class="form-control date-picker" data-date-format='yyyy-mm-dd' size="16" value="" placeholder="Selecciona..." />
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="montoret"class="col-md-6 control-label text-right"><strong>Monto Retenido:</strong></label>
                                                        <div class="col-md-6">
                                                            <input type="text" name="montoret" id="montoret" class="form-control valida-decimal" placeholder="Monto Retenido...">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="razonsoc"class="col-md-6 control-label text-right"><strong>Razón Social del Contratado:</strong></label>
                                                        <div class="col-md-6">
                                                            <input type="text" name="razonsoc" id="razonsoc" class="form-control" placeholder="Razón Social del Contratado...">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="depnomativa"class="col-md-6 control-label text-right"><strong>Dependencia Normativa:</strong></label>
                                                        <div class="col-md-6">
                                                            <input type="text" name="depnomativa"id="depnomativa" class="form-control" placeholder="Dependencia Normativa...">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="depejecutora"class="col-md-6 control-label text-right"><strong>Dependencia Ejecutora:</strong></label>
                                                        <div class="col-md-6">
                                                            <input type="text" name="depejecutora" id="depejecutora" class="form-control" placeholder="Dependencia Ejecutora...">
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="correo"class="col-md-6 control-label text-right"><strong>Correo Electronico:</strong></label>
                                                        <div class="col-md-6">
                                                            <input type="text" name="correo" id="correo" class="form-control" placeholder="Correo Electronico...">
                                                        </div>
                                                    </div>
                                                </div>  
                                            </div>                                           
                                            <div class="col-md-6">
                                                <dl>
                                                    <dt>Proyecto:</dt>
                                                    <dd><span class="help-block"><label id="proyecto">Sin Asignar</label></span></dd>

                                                    <dt>Descripción Proyecto:</dt>
                                                    <dd><span class="help-block"><label id="descproyecto"> Sin Asignar<label> </span></dd>

                                                    <dt>Programa:</dt>
                                                    <dd><span class="help-block"><label id="programa">Sin Asignar</label></span></dd>

                                                    <dt>Descripción Programa:</dt>
                                                    <dd><span class="help-block"><label id="descprograma">Sin Asignar</label></span></dd>

                                                    <dt>SubPrograma:</dt>
                                                    <dd><span class="help-block"><label id="subprograma">Sin Asignar</label></span></dd>

                                                    <dt>Descripción Subprograma:</dt>
                                                    <dd><span class="help-block"><label id="descsubprograma">Sin Asignar</label></span></dd>

                                                    <dt>Oficio:</dt>
                                                    <dd><span class="help-block"><label id="oficio">Sin Asignar</label></span></dd>

                                                    <dt>Descripción Oficio:</dt>
                                                    <dd><span class="help-block"><label id="descoficio">Sin Asignar</label></span></dd>

                                                    <dt>Descripción Clasificación Geografica:</dt>
                                                    <dd><span class="help-block"><label id="descgeografica">Sin Asignar</label></span></dd>

                                                    <dt>Descripción Dependecia Normativa:</dt>
                                                    <dd><span class="help-block"><label id="descnormativa">Sin Asignar</label></span></dd>

                                                    <dt>Descripción Dependecia Ejecutora:</dt>
                                                    <dd><span class="help-block"><label id="descejecutora">Sin Asignar</label></span></dd>
                                                </dl> 
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
                                                         <label class="col-md-6 text-right"><strong>Ejercicio Fiscal:</strong></label>
                                                         <label class="col-md-6" id="lbl_ejercicio">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-right"><strong>Identificación de las retenciones:</strong></label>
                                                        <label for="ejercicio"class="col-md-6" id="lbl_identretenciones">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-right"><strong>Folio SIE(PEI) Autorización:</strong></label>
                                                        <label class="col-md-6" id="lbl_folio">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-right"><strong>Modalidad de Ejecución:</strong></label>
                                                        <label class="col-md-6" id="lbl_modejecucion">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-right"><strong>Referencia del Contrato:</strong></label>
                                                        <label class="col-md-6" id="lbl_refcontrato">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-right"><strong>Numero de Factura:</strong></label>
                                                        <label class="col-md-6" id="lbl_nofactura">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-right"><strong>Estimación Pagada: <br>(Numero de Control de Pago)</strong></label>
                                                        <label class="col-md-6" id="lbl_estpagada">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-right"><strong>Fecha de Retención:</strong></label>
                                                        <label class="col-md-6" id="lbl_fecharet">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-right"><strong>Monto Retenido:</strong></label>
                                                        <label class="col-md-6" id="lbl_montoret">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-right"><strong>Razón Social del Contratado:</strong></label>
                                                        <label class="col-md-6" id="lbl_razonsoc">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-right"><strong>Dependencia Normativa:</strong></label>
                                                        <label class="col-md-6" id="lbl_depnomativa">Sin Asignar</label>
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-right"><strong>Dependencia Ejecutora:</strong></label>
                                                        <label class="col-md-6" id="lbl_depejecutora">Sin Asignar</label>        
                                                </div><br>
                                                <div class="row">
                                                        <label class="col-md-6 text-right"><strong>Correo Electronico:</strong></label>
                                                        <label class="col-md-6" id="lbl_correo">Sin Asignar</label>        
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <dl>
                                                    <dt>Proyecto:</dt>
                                                    <dd><span class="help-block"><label id="proyecto2">Sin Asignar</label></span></dd>

                                                    <dt>Descripción Proyecto:</dt>
                                                    <dd><span class="help-block"><label id="descproyecto2"> Sin Asignar<label> </span></dd>

                                                    <dt>Programa:</dt>
                                                    <dd><span class="help-block"><label id="programa2">Sin Asignar</label></span></dd>

                                                    <dt>Descripción Programa:</dt>
                                                    <dd><span class="help-block"><label id="descprograma2">Sin Asignar</label></span></dd>

                                                    <dt>SubPrograma:</dt>
                                                    <dd><span class="help-block"><label id="subprograma2">Sin Asignar</label></span></dd>

                                                    <dt>Descripción Subprograma:</dt>
                                                    <dd><span class="help-block"><label id="descsubprograma2">Sin Asignar</label></span></dd>

                                                    <dt>Oficio:</dt>
                                                    <dd><span class="help-block"><label id="oficio2">Sin Asignar</label></span></dd>

                                                    <dt>Descripción Oficio:</dt>
                                                    <dd><span class="help-block"><label id="descoficio2">Sin Asignar</label></span></dd>

                                                    <dt>Descripción Clasificación Geografica:</dt>
                                                    <dd><span class="help-block"><label id="descgeografica2">Sin Asignar</label></span></dd>

                                                    <dt>Descripción Dependecia Normativa:</dt>
                                                    <dd><span class="help-block"><label id="descnormativa2">Sin Asignar</label></span></dd>

                                                    <dt>Descripción Dependecia Ejecutora:</dt>
                                                    <dd><span class="help-block"><label id="descejecutora2">Sin Asignar</label></span></dd>
                                                </dl> 
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
<input type="text" name="consulta" id="consulta" hidden="true">
<input type="text" name="link" id="link" hidden="true">
@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {
        ComponentsPickers.init();
    });  
    $('#folio').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
             findprograma();
        }
    });
    function continuarthird()
    {   
        var link=$("#link").val();
        window.open(link, "ventana1" , "width=820,height=720,scrollbars=si");
        
    }
    function continuarsecondary()
    {
        var ejercicio_=$("#ejercicio option:selected").text();
        var partida_=$("#identretenciones").val();
        var folio_=$("#folio").val();        
        var modejecucion_=$("#modejecucion").val();
        var refcontrato_=$("#refcontrato").val();
        var nofactura_=$("#nofactura").val();
        var estpagada_=$("#estpagada").val();
        var fecharet_=$("#fecharet").val();
        var montoret_=$("#montoret").val();
        var razonsoc_=$("#razonsoc").val();
        var depnomativa_=$("#depnomativa").val();
        var depejecutora_=$("#depejecutora").val();
        var correo=$("#correo").val();
        
        $.ajax({
           method: "post",           
           url: "{{ url('/generate') }}",
           data: {ejercicio_fiscal:ejercicio_,partida:partida_,folio:folio_,modalidad_ejecucion:modejecucion_,referencia_contrato:refcontrato_,numero_factura:nofactura_,estimacion_pagada:estpagada_,fecha_retencion:fecharet_,monto_retencion:montoret_,razon_social:razonsoc_,dependencia_normativa:depnomativa_,dependencia_ejecutora:depejecutora_,email:correo,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            //console.log(response);
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
    function continuarprimary()
    {
        var ejercicio_=$("#ejercicio").val();
        var partida_=$("#identretenciones").val();
        var folio_=$("#folio").val();        
        var modejecucion_=$("#modejecucion").val();
        var refcontrato_=$("#refcontrato").val();
        var nofactura_=$("#nofactura").val();
        var estpagada_=$("#estpagada").val();
        var fecharet_=$("#fecharet").val();
        var montoret_=$("#montoret").val();
        var razonsoc_=$("#razonsoc").val();
        var depnomativa_=$("#depnomativa").val();
        var depejecutora_=$("#depejecutora").val();
        var consulta=$("#consulta").val();
        if(ejercicio_=="limpia")
        {
            Command: toastr.warning("Campo Ejercicio Fiscal, Requerido!", "Notifications")
        }else if(partida_=="limpia")
        { 
            Command: toastr.warning("Campo Identificación de las retenciones,Requerido!", "Notifications")
        }else if(folio_.length<1)
        { 
            Command: toastr.warning("Campo Folio SIE(PEI) Autorización, Requerido!", "Notifications")
        }else if(modejecucion_=="limpia")
        { 
            Command: toastr.warning("Campo Modalidad de Ejecución, Requerido!", "Notifications")
        }else if(refcontrato_.length<1)
        { 
          Command: toastr.warning("Campo Referencia del Contrato, Requerido!", "Notifications")  
        }else if(nofactura_.length<1)
        { 
            Command: toastr.warning("Campo Numero de Factura, Requerido!", "Notifications")
        }else if(estpagada_.length<1)
        { 
            Command: toastr.warning("Campo Estimación Pagada, Requerido!", "Notifications")
        }else if(fecharet_.length<1)
        { 
            Command: toastr.warning("Campo Fecha de Retención, Requerido!", "Notifications")
        }else if(montoret_.length<1)
        { 
            Command: toastr.warning("Campo Campo Monto Retenido, Requerido!", "Notifications")
        }else if(razonsoc_.length<1)
        { 
            Command: toastr.warning("Campo Razón Social del Contratado, Requerido!", "Notifications")
        }else if(depnomativa_.length<1)
        { 
            Command: toastr.warning("Campo Dependencia Normativa, Requerido!", "Notifications")
        }else if(depejecutora_.length<1)
        { 
             Command: toastr.warning("Campo Dependencia Ejecutora, Requerido!", "Notifications")
        }else if(consulta=="0")
        { 
             Command: toastr.warning("Consulta,Requerido!", "Notifications")
        }else{
            $('.nav-tabs a[href="#tab_1"]').tab('show');
            $("#circle_0 i").remove();
            $("#circle_0").append("<i class='fa fa-check-circle-o'></i>");
            confirmardatos();
        }
    }
    function confirmardatos()
    {
        var ejercicio_=$("#ejercicio option:selected").text();
        var partida_=$("#identretenciones option:selected").text();
        var folio_=$("#folio").val();        
        var modejecucion_=$("#modejecucion option:selected").text();
        var refcontrato_=$("#refcontrato").val();
        var nofactura_=$("#nofactura").val();
        var estpagada_=$("#estpagada").val();
        var fecharet_=$("#fecharet").val();
        var montoret_=$("#montoret").val();
        var razonsoc_=$("#razonsoc").val();
        var depnomativa_=$("#depnomativa").val();
        var depejecutora_=$("#depejecutora").val();
        var correo=$("#correo").val();
        $('#lbl_ejercicio').text(ejercicio_);
        $('#lbl_identretenciones').text(partida_);
        $('#lbl_folio').text(folio_);
        $('#lbl_modejecucion').text(modejecucion_);
        $('#lbl_refcontrato').text(refcontrato_);
        $('#lbl_nofactura').text(nofactura_);
        $('#lbl_estpagada').text(estpagada_);
        $('#lbl_fecharet').text(fecharet_);
        $('#lbl_montoret').text(montoret_);
        $('#lbl_razonsoc').text(razonsoc_);
        $('#lbl_depnomativa').text(depnomativa_);
        $('#lbl_depejecutora').text(depejecutora_);
        $('#lbl_correo').text(correo);

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
    function findprograma()
    {
        var partida_=$("#identretenciones").val();
        //var partida_="81800";
        var folio_=$("#folio").val();
        var ejercicio_=$("#ejercicio").val();
        $.ajax({
           method: "post",           
           url: "{{ url('/proyecto-programas') }}",
           data: {folio:folio_,partida:partida_,ejercicio:ejercicio_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
             //console.log(response);
            if(response=="[]")
            {
                limpialabels();
                document.getElementById('consulta').value="0";
                Command: toastr.warning("Registro No Encontrado!", "Notifications")

            }else{
                document.getElementById('consulta').value="1";
                Command: toastr.success("Registro Encontrado!", "Notifications")
                var Resp=$.parseJSON(response);
                $.each(Resp, function(i, item) {                
                    $('#proyecto').text(item.proyecto);
                    $('#descproyecto').text(item.descproyecto);
                    $('#programa').text(item.programa);
                    $('#descprograma').text(item.descprograma);
                    $('#subprograma').text(item.subprograma);
                    $('#descsubprograma').text(item.descsubprograma);
                    $('#oficio').text(item.oficio);
                    $('#descoficio').text(item.descoficio);
                    $('#descgeografica').text(item.descgeografica);
                    $('#descnormativa').text(item.descnormativa);
                    $('#descejecutora').text(item.descejecutora);
                    ///***////
                    $('#proyecto2').text(item.proyecto);
                    $('#descproyecto2').text(item.descproyecto);
                    $('#programa2').text(item.programa);
                    $('#descprograma2').text(item.descprograma);
                    $('#subprograma2').text(item.subprograma);
                    $('#descsubprograma2').text(item.descsubprograma);
                    $('#oficio2').text(item.oficio);
                    $('#descoficio2').text(item.descoficio);
                    $('#descgeografica2').text(item.descgeografica);
                    $('#descnormativa2').text(item.descnormativa);
                    $('#descejecutora2').text(item.descejecutora);          
                });
            }                
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Partidas");  });
    }
    function changepartidas()
    {
        var ejer=$("#ejercicio").val();
        if(ejer=="limpia")
        {
            $("#identretenciones").attr('disabled', true);
            $("#identretenciones").val("limpia").change();
        }else{
            partidas();
            $("#identretenciones").attr('disabled', false);

        }
    }
    function partidas()
    {
        var user_="andrea.gonzalez";
        $.ajax({
           method: "post",           
           url: "{{ url('/acceso-partidas') }}",
           data: {user:user_,_token:'{{ csrf_token() }}'}  })
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
    function limpiar()
    {
       
        //------limpia inputs-------//
        document.getElementById('folio').value="";
        $("#ejercicio").val("limpia").change();
        $("#identretenciones").val("limpia").change();
        $("#modejecucion").val("limpia").change();
        document.getElementById('refcontrato').value="";
        document.getElementById('nofactura').value="";
        document.getElementById('estpagada').value="";
        document.getElementById('fecharet').value="";
        document.getElementById('montoret').value="";
        document.getElementById('razonsoc').value="";
        document.getElementById('depnomativa').value="";
        document.getElementById('depejecutora').value="";
        document.getElementById('consulta').value="0";
        document.getElementById('link').value='';
        document.getElementById('correo').value='';
        limpialabels();

    }
    function limpialabels()
    {
        $('#proyecto').text("Sin Asignar");
        $('#descproyecto').text("Sin Asignar");
        $('#programa').text("Sin Asignar");
        $('#descprograma').text("Sin Asignar");
        $('#subprograma').text("Sin Asignar");
        $('#descsubprograma').text("Sin Asignar");
        $('#oficio').text("Sin Asignar");
        $('#descoficio').text("Sin Asignar");
        $('#descgeografica').text("Sin Asignar");
        $('#descnormativa').text("Sin Asignar");
        $('#descejecutora').text("Sin Asignar");
    }
    $('.valida-decimal').on('input', function () { 
        this.value = this.value.replace(/[^0-9.]/g,'');
    });
    function mayus(e) {
        e.value = e.value.toUpperCase();
        //onkeyup="mayus(this);"
    }

</script>
@endsection