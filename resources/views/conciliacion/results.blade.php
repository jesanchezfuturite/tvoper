@extends('layout.app')

@section('content')
<h3 class="page-title"> Conciliación <small>Resultados de conciliación</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Operación - Conciliación</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Resultados</a>
        </li>
    </ul>
</div>

<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Info:</strong> Esta herramienta muestra los resultados de la conciliación realizada por fecha específica.
</div>


<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-3">Consultar resultados conciliación</label>
            <div class="col-md-3">
                <input id="fecha" class="form-control form-control-inline input-medium date-picker" size="16" type="text" value="" autocomplete="off" placeholder="Selecciona una fecha">
                <span class="help-block">
                 </span>
                <button class="btn blue" id="busqueda" type="submit">
                    Buscar
                </button>
                <div id="corte_div" style="display: inline"></div>
            </div>
        </div>
    </div>
</div>
<div id="bancos_tabs" class="row" >
    <div class="alert alert-secondary" id="imageloading" style="display: none" role="alert"></div>
    <hr> 
    <div class="col-md-12" >
        <div class="tabbable-line boxless tabbable-reversed">
            <ul class="nav nav-tabs" id="d_tabs">
                <li class="active">
                    <a href="#tab_0" data-toggle="tab">Operaciones</a>
                </li>
                <li>
                    <a href="#tab_1" data-toggle="tab">Egobierno</a>
                </li>                            
            </ul>

            <div class="tab-content" id="c_tabs">
                <div class="tab-pane active" id="tab_0">
                    <div class="portlet-body" style="overflow-x: auto; white-space: nowrap;"> 
                        <table id="dtHorizontal" class="table table-striped table-bordered table-sm" cellspacing="0">
                            <thead>
                                <tr>
                                    <th></th> 
                                    <th></th> 
                                    <th colspan="5">Internet</th>
                                    <th colspan="5" style="background-color: #E9E9E9">Repositorio</th>
                                </tr>
                                <tr>
                                    <th>Alias</th>
                                    <th>Cuenta</th>  
                                    <th>Trámites</th>
                                    <th>Conciliados</th>
                                    <th>No conciliados</th>
                                    <th>Monto conciliado</th>
                                    <th>Monto no conciliado</th> 
                                    <th style="background-color: #E9E9E9">Trámites</th>
                                    <th style="background-color: #E9E9E9">Conciliados</th>
                                    <th style="background-color: #E9E9E9">No conciliados</th>
                                    <th style="background-color: #E9E9E9">Monto conciliado</th>
                                    <th style="background-color: #E9E9E9">Monto no conciliado</th> 
                                </tr>
                            </thead>
                            <tbody> 
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>                       
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="background-color: #E9E9E9"></td>
                                    <td style="background-color: #E9E9E9"></td>
                                    <td style="background-color: #E9E9E9"></td>
                                    <td style="background-color: #E9E9E9"></td>
                                    <td style="background-color: #E9E9E9"></td>
                                </tr>                                   
                            </tbody>
                        </table>                          
                    </div>      
                </div>            
                <div class="tab-pane" id="tab_1">
                
                </div>
            </div>
        </div>
    </div>
</div>
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
<div id="modalinfo" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="titulo_modal"></h4>
            </div>
            <div class="modal-body" id="detalleIncidencia">
                             
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/components-pickers.js" type="text/javascript"></script>

<script>
    jQuery(document).ready(function() {   
        $('#bancos_tabs').hide();    
        ComponentsPickers.init();

    }); 

    $("#busqueda").click(function(){

        var fecha = $("#fecha").val();

        $("#corte_div").empty();

        $.ajax({
            method: "post",
            beforeSend:  function(){
                
                $('#result-query').hide();
                $('#imageloading').html('Procesando ...').show();
            },
            url: "{{ url('/conciliacion-getinfo') }}",
            data: { f: fecha, _token: '{{ csrf_token() }}' }
        })
        .done(function(data){

            var element = 0;

            var content;
            var accounts;
            
            // vaciar el contenido del ul para insertar los nuevos tab
            $("#d_tabs").empty();
            $("#c_tabs").empty();


            $.each(data,function(i,info){
                 
                if(element == 0){
                    $("#d_tabs").append('<li class="active"><a href="#tab_'+element+'" data-toggle="tab">'+info.descripcion+'</a></li>');
                    content = '<div class="tab-pane active" id="tab_'+element+'">';    
                }else{
                    $("#d_tabs").append('<li><a href="#tab_'+element+'" data-toggle="tab">'+info.descripcion+'</a></li>');
                    content = '<div class="tab-pane" id="tab_'+element+'"><div class="portlet-body">';     
                }
                

                // aqui genero el resumen de cada banco por cuenta para internet
                r = info.resumen;
                g = info.grand;
                
                internet = '<table class="table table-hover"><thead><tr><th>Alias</th><th>Cuenta</th><th>Origen</th><th>Trámites</th><th>Conciliados</th><th>No conciliados</th><th>Monto conciliado</th><th>Monto no conciliado</th></tr></thead><tbody>';

                $.each(r,function(i,por_cuenta){
                    
                    res = por_cuenta.resumen;

                    
                    internet += '<tr style="background-color:#bce8f1">';
                    internet += '<td ><b>'+por_cuenta.alias+'</b></td><td><b>'+por_cuenta.cuenta+'</b></td><td><b>Total ('+ res.total +')</b></td>';
                    internet += '<td align="right"><b>'+res.tramites+'</b></td>';
                    internet += '<td align="right"><b>'+res.conciliados+'</b></td>';
                    internet += '<td align="right"><b>'+res.no_conciliados+'</b></td>';
                    internet += '<td align="right"><b>'+res.monto_conciliado+'</b></td>';
                    internet += '<td align="right"><b>'+res.monto_no_conciliado+'</b></td>';
                    internet += '</tr>';

                    int = por_cuenta.internet;

                    internet += '<tr>';
                    internet += '<td>&nbsp;</td><td>&nbsp;</td><td>Internet</td>';
                    internet += '<td align="right">'+int.tramites+'</td>';
                    internet += '<td align="right">'+int.conciliados+'</td>';
                    internet += '<td align="right"><a href="#" onclick=noconc("'+por_cuenta.alias+'","'+por_cuenta.cuenta+'",1) id="noconc">'+int.no_conciliados+'</a></td>';
                    internet += '<td align="right">'+int.monto_conciliado+'</td>';
                    internet += '<td align="right">'+int.monto_no_conciliado+'</td>';
                    internet += '</tr>';

                    rep = por_cuenta.repositorio;

                    internet += '<tr>';
                    internet += '<td>&nbsp;</td><td>&nbsp;</td><td>Repositorio</td>';
                    internet += '<td align="right">'+rep.tramites+'</td>';
                    internet += '<td align="right">'+rep.conciliados+'</td>';
                    internet += '<td align="right"><a href="#" onclick=noconc("'+por_cuenta.alias+'","'+por_cuenta.cuenta+'",2) id="noconc">'+rep.no_conciliados+'</a></td>';
                    internet += '<td align="right">'+rep.monto_conciliado+'</td>';
                    internet += '<td align="right">'+rep.monto_no_conciliado+'</td>';
                    internet += '</tr>';

                    as4 = por_cuenta.as400;

                    internet += '<tr>';
                    internet += '<td>&nbsp;</td><td>&nbsp;</td><td>AS400</td>';
                    internet += '<td align="right">'+as4.tramites+'</td>';
                    internet += '<td align="right">'+as4.conciliados+'</td>';
                    internet += '<td align="right"><a href="#" onclick=noconc("'+por_cuenta.alias+'","'+por_cuenta.cuenta+'",3) id="noconc">'+as4.no_conciliados+'</a></td>';
                    internet += '<td align="right">'+as4.monto_conciliado+'</td>';
                    internet += '<td align="right">'+as4.monto_no_conciliado+'</td>';
                    internet += '</tr>';

                    otr = por_cuenta.otros;

                    internet += '<tr>';
                    internet += '<td>&nbsp;</td><td>&nbsp;</td><td>Otros</td>';
                    internet += '<td align="right">'+otr.tramites+'</td>';
                    internet += '<td align="right">'+otr.conciliados+'</td>';
                    internet += '<td align="right"><a href="#" onclick=noconc("'+por_cuenta.alias+'","'+por_cuenta.cuenta+'",4) id="noconc">'+otr.no_conciliados+'</a></td>';
                    internet += '<td align="right">'+otr.monto_conciliado+'</td>';
                    internet += '<td align="right">'+otr.monto_no_conciliado+'</td>';
                    internet += '</tr>';

                    

                });

            
                grd = g;

                internet += '<tr style="background-color:#DFF0D8">';
                internet += '<td>&nbsp;</td><td>&nbsp;</td><td><b><i>GRAND TOTAL ('+ g.total  +') </i></b></td>';
                internet += '<td align="right"><b><i>'+g.tramites+'</i></b></td>';
                internet += '<td align="right"><b><i>'+g.conciliados+'</i></b></td>';
                internet += '<td align="right"><b><i>'+g.no_conciliados+'</i></b></td>';
                internet += '<td align="right"><b><i>'+g.monto_conciliado+'</i></b></td>';
                internet += '<td align="right"><b><i>'+g.monto_no_conciliado+'</i></b></td>';
                internet += '</tr>';

                content += internet;
                content += '</tbody></table></div></div>';

                $("#c_tabs").append(content);

                internet = ""; 
                repo = ""; 
                as400 = "";  
                otros = "";              

                element ++;
            });

            /* hide the loading */ 
            $('#imageloading').html('');
            /* append the results on result-query div */
            $('#bancos_tabs').show();        
            // poner el boton para enviar el corte
            var boton;

            var fecha_correcta = fecha.split("/");
            var fc = fecha_correcta[2]+"-"+fecha_correcta[0]+"-"+fecha_correcta[1];
            console.log(fc);
            // boton = '<button class="btn blue" id="corte_button" onclick="enviarCorte(\''+fc+'\')"; type="button">Corte</button>';
            boton = $('<button>',{text:'Corte',id:'corte_button',class: 'btn blue',click: function(){ alert('Proximamente') }});
            $("#corte_div").append(boton);

        });


    });

    function enviarCorte(fecha)
    {
        // deshabilitar el boton
        $("#corte_button").attr("disabled", true);
        var url = "{{ url('/') }}" + "/envio-corte/"+fecha;
        window.open( url, "_blank");

    }

    /* buscar el detalle de las transacciones de internet */ 
    function noconc(alias,cuenta,fuente)
    {
        // obtener la fecha 
        var fecha = $("#fecha").val();

        $.ajax({
            method: "post",
            beforeSend:  function(){
                
                $('#result-query').hide();
                $('#imageloading').html('Procesando ...').show();
            },
            url: "{{ url('/conciliacion-detalle-anomalia') }}",
            data: { f: fecha, fuente: fuente, alias: alias, cuenta: cuenta, _token: '{{ csrf_token() }}' }
        })
        .done(function(data){

            var titleModal = 'Detalles de incidencia en la cuenta ('+alias+') ' + cuenta;

            if(data.response == 1)
            {
                $("#detalleIncidencia").empty();
                var info = data.data;

                var tabla = '<div class="portlet-body"><table class="table table-hover"><thead><tr><th>Índice de transacción</th><th>Referencia</th><th>Monto en archivo</th><th>Monto total</th><th>Monto de mensajeria</th><th>Archivo fuente</th><th>Fecha de carga para conciliar</th><th>Estatus</th></tr></thead><tbody>';
                    
                $.each(info, function(i,d){
                    
                    var internet = d.internet;
                    var repositorio = d.repositorio;

                    var monto = repositorio.monto;
                    var tt = internet.TotalTramite;
                    var cm = internet.CostoMensajeria;

                    if(monto == ''){
                        monto = 0.00;
                    }

                    if(tt == ''){
                        tt = 0.00;
                    }

                    if(cm == null){
                        cm = 0.00;
                    }

                    console.log(internet);
                    tabla += '<tr>';
                    tabla += '<td>'+internet.idTrans+'</td>'
                    tabla += '<td>'+repositorio.referencia+'</td>'
                    tabla += '<td class="moneyformat">'+monto+'</td>'
                    tabla += '<td class="moneyformat">'+tt+'</td>'
                    tabla += '<td class="moneyformat">'+cm+'</td>'
                    tabla += '<td>'+repositorio.filename+'</td>'
                    tabla += '<td>'+repositorio.created_at+'</td>'
                    tabla += '<td>'+repositorio.status+'</td>'
                    tabla += '</tr>';

                });

                tabla += '</tbody></table></div></div>';
                $("#detalleIncidencia").empty();
                $("#detalleIncidencia").append(tabla);

                $('.moneyformat').formatCurrency();

            }else{
                $("#detalleIncidencia").empty();
                var mensaje = '<div class="alert alert-info alert-dismissable">';
                mensaje += '<strong>Info:</strong> Esta cuenta no presenta incidendencias.</div>'
                $("#detalleIncidencia").append(mensaje);
            }

            // open modalbox

            $('#titulo_modal').empty();
            $('#titulo_modal').append(titleModal);

            $('#modalinfo').modal('show');

        });

    }



</script>
@endsection
