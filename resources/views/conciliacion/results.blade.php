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
                <input id="fecha" class="form-control form-control-inline input-medium date-picker" size="16" type="text" value="" autocomplete="off" placeholder="Selecciona una fecha" required="true">
                <span class="help-block">
                 </span>
                <button class="btn blue" id="busqueda" type="submit">
                    Buscar
                </button>
                <div id="corte_div" style="display: inline"></div>
            </div>
        </div>
    </div>
</div><div class="alert alert-secondary" id="imageloading" style="display: none" role="alert"></div>
<div id="bancos_tabs" class="row" >
    
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
             <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn default">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
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
        if(fecha=='')
        {
            Command: toastr.warning("Seleccione una fecha", "Notifications")
        }else{
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
            var nc;
            var dup;
            var difs;
            var dupl;
            var element = 0;
           
            var content;
            var accounts;
            if(data==0)
            {
                $("#corte_div").empty();
                $('#imageloading').html('');
            }
            // vaciar el contenido del ul para insertar los nuevos tab
            $("#d_tabs").empty();
            $("#c_tabs").empty();

            $.each(data,function(i,reg){
                nc =reg.noconciliado;
                difs =reg.difStatus;
                dupl =reg.duplicados;
            $.each(reg.final,function(i,info){
                 
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
                    internet += '<td align="right"><a href="#" onclick=conc("'+por_cuenta.alias+'","'+por_cuenta.cuenta+'",1,1) id="conc">'+int.conciliados+'</a></td>';
                    internet += '<td align="right"><a href="#" onclick=noconc("'+por_cuenta.alias+'","'+por_cuenta.cuenta+'",1,0) id="noconc">'+int.no_conciliados+'</a></td>';
                    internet += '<td align="right">'+int.monto_conciliado+'</td>';
                    internet += '<td align="right">'+int.monto_no_conciliado+'</td>';
                    internet += '</tr>';

                    rep = por_cuenta.repositorio;

                    internet += '<tr>';
                    internet += '<td>&nbsp;</td><td>&nbsp;</td><td>Repositorio</td>';
                    internet += '<td align="right">'+.tramites+'</td>';
                    internet += '<td align="right"><a href="#" onclick=conc("'+por_cuenta.alias+'","'+por_cuenta.cuenta+'",2,1) id="conc">'+rep.conciliados+'</a></td>';
                    internet += '<td align="right"><a href="#" onclick=noconc("'+por_cuenta.alias+'","'+por_cuenta.cuenta+'",2,0) id="noconc">'+rep.no_conciliados+'</a></td>';
                    internet += '<td align="right">'+rep.monto_conciliado+'</td>';
                    internet += '<td align="right">'+rep.monto_no_conciliado+'</td>';
                    internet += '</tr>';

                    as4 = por_cuenta.as400;

                    internet += '<tr>';
                    internet += '<td>&nbsp;</td><td>&nbsp;</td><td>AS400</td>';
                    internet += '<td align="right">'+as4.tramites+'</td>';
                    internet += '<td align="right"><a href="#" onclick=conc("'+por_cuenta.alias+'","'+por_cuenta.cuenta+'",3,1) id="conc">'+as4.conciliados+'</a></td>';
                    internet += '<td align="right"><a href="#" onclick=noconc("'+por_cuenta.alias+'","'+por_cuenta.cuenta+'",3,0) id="noconc">'+as4.no_conciliados+'</a></td>';
                    internet += '<td align="right">'+as4.monto_conciliado+'</td>';
                    internet += '<td align="right">'+as4.monto_no_conciliado+'</td>';
                    internet += '</tr>';

                    otr = por_cuenta.otros;

                    internet += '<tr>';
                    internet += '<td>&nbsp;</td><td>&nbsp;</td><td>Otros</td>';
                    internet += '<td align="right">'+otr.tramites+'</td>';
                    internet += '<td align="right"><a href="#" onclick=conc("'+por_cuenta.alias+'","'+por_cuenta.cuenta+'",4,1) id="conc">'+otr.conciliados+'</a></td>';
                    internet += '<td align="right"><a href="#" onclick=noconc("'+por_cuenta.alias+'","'+por_cuenta.cuenta+'",4,0) id="noconc">'+otr.no_conciliados+'</a></td>';
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
            //console.log(fc);
            boton = '<button class="btn blue" id="corte_button" onclick="enviarCorte(\''+fc+'\')"; type="button">Corte</button>';
            // boton = $('<button>',{text:'Corte',id:'corte_button',class: 'btn blue',click: function(){ alert('Proximamente') }});
            $("#corte_div").append(boton);
        
        });
        $("#d_tabs").append('<li><a href="#tab_resumen" data-toggle="tab">Resumen</a></li>');
        $("#c_tabs").append(' <div class="tab-pane" id="tab_resumen"><div class="portlet-body"></div> </div> ');
        if(dupl!=null){
        tabResumen(dupl);    
        }
        if(nc!=null){
        tabResumen2(nc);    
        }
        if(difs!=null){
        tabResumen3(difs);    
        }
        TableAdvanced.init();
        });
    }

    });
    function tabResumen(nc)
    {
         tbls = '<h3><strong>Pagos duplicados</strong></h3> <br><table id="sample_1" class="table table-hover"><thead><tr><th>Folio</th><th>Referencia</th><th>Banco</th><th>Alias</th><th>Fecha Pago</th><th>Monto</th></tr></thead><tbody>';
            $.each(nc,function(i,reg){
                  
                tbls += '<tr><td>'+reg.folio+'</td>';
                tbls += '<td>'+reg.referencia+'</td>';
                tbls += '<td>'+reg.banco+'</td>';
                tbls += '<td>'+reg.cuenta_alias+'</td>';
                tbls += '<td>'+reg.year+'-'+reg.month+'-'+reg.day+'</td>';
                tbls += '<td>'+ formatter.format(reg.monto)+'</td>';
                tbls += '</tr>';
            });
        
         tbls += '</tbody></table></div>';
        $("#tab_resumen").append(tbls);
        
    }
    function tabResumen2(nc)
    {

        
       tbls='<br><h3><strong>Tramites pagados sin conciliar</strong></h3>  <br>'
         tbls += '<table id="sample_2" class="table table-hover"><thead><tr><th>Folio</th><th>Referencia</th><th>Banco</th><th>Fecha Pago</th><th>Estatus</th><th>Monto</th></tr></thead><tbody>';
            $.each(nc,function(i,reg){
                  
                tbls += '<tr><td>'+reg.folio+'</td>';
                tbls += '<td>'+reg.referencia+'</td>';
                tbls += '<td>'+reg.banco+'</td>';
                tbls += '<td>'+reg.fecha_pago+'</td>';
                tbls += '<td>'+reg.status+'</td>';
                tbls += '<td>'+formatter.format(reg.monto)+'</td>';
                tbls += '</tr>';
            });
         tbls += '</tbody></table>';
        $("#tab_resumen").append(tbls);
    }
    function tabResumen3(nc)
    {

        
       tbls='<br><h3><strong>Tramites conciliados con estatus diferente a pagados</strong></h3>  <br>'
         tbls += '<table id="sample_3" class="table table-hover"><thead><tr><th>Folio</th><th>Referencia</th><th>Banco</th><th>Estatus</th><th>Monto</th></tr></thead><tbody>';
            $.each(nc,function(i,reg){
                  
                tbls += '<tr><td>'+reg.folio+'</td>';
                tbls += '<td>'+reg.referencia+'</td>';
                tbls += '<td>'+reg.banco+'</td>';
                tbls += '<td>'+reg.status+'</td>';
                tbls += '<td>'+formatter.format(reg.monto)+'</td>';
                tbls += '</tr>';
            });
         tbls += '</tbody></table>';
        $("#tab_resumen").append(tbls);
        //TableManaged.init();
        
    }

    const formatter = new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
      minimumFractionDigits: 2
    })
    function enviarCorte(fecha)
    {
        // deshabilitar el boton
        $("#corte_button").attr("disabled", true);
        var url = "{{ url('/') }}" + "/envio-corte/"+fecha;
        window.open( url, "_blank");

    }

    /* buscar el detalle de las transacciones de internet */ 
    function noconc(alias,cuenta,fuente,opcion)
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
                //console.log(info);
                 document.getElementById('jsonCode').value=JSON.stringify(info);

                var tabla = '<div class="portlet-body">' + '<div class="row"><span class="help-block"></span>  <div class="col-md-12 text-right">  <div class="form-group">    <button class="btn blue" onclick="GuardarExcel()"><i class="fa fa-file-excel-o"></i> Descargar CSV</button>   </div> </div><span class="help-block">&nbsp;</span> </div>' + '<table id="sample_7" class="table table-hover"><thead><tr><th>Índice de transacción</th><th>Referencia</th><th>Monto en archivo</th><th>Monto total</th><th>Monto de mensajeria</th><th>Archivo fuente</th><th>Fecha de carga para conciliar</th><th>Estatus</th></tr></thead><tbody>';
                    
                $.each(info, function(i,d){
                    
                    //var internet = d.internet;
                   //var repositorio = d.repositorio;

                    var monto = d.monto;
                    var tt = d.TotalTramite;
                    var cm = d.CostoMensajeria;

                    if(monto == ''){
                        monto = 0.00;
                    }

                    if(tt == ''){
                        tt = 0.00;
                    }

                    if(cm == null){
                        cm = 0.00;
                    }

                   // console.log(internet);
                    tabla += '<tr>';
                    tabla += '<td>'+d.idTrans+'</td>'
                    tabla += '<td>'+d.referencia+'</td>'
                    tabla += '<td class="moneyformat">'+monto+'</td>'
                    tabla += '<td class="moneyformat">'+tt+'</td>'
                    tabla += '<td class="moneyformat">'+cm+'</td>'
                    tabla += '<td>'+d.filename+'</td>'
                    tabla += '<td>'+d.created_at+'</td>'
                    tabla += '<td>'+d.status+'</td>'
                    tabla += '</tr>';

                });

                tabla += '</tbody></table></div></div>';
                $("#detalleIncidencia").empty();
                $("#detalleIncidencia").append(tabla);

                $('.moneyformat').formatCurrency();

                  TableAdvanced7.init();
            }else{
                $("#detalleIncidencia").empty();
                var mensaje = '<div class="alert alert-info alert-dismissable">';
                mensaje += '<strong>Info:</strong> Esta cuenta no presenta incidendencias.</div>'
                $("#detalleIncidencia").append(mensaje);
                document.getElementById('jsonCode').value=[];
            }

            // open modalbox

            $('#titulo_modal').empty();
            $('#titulo_modal').append(titleModal);

            $('#modalinfo').modal('show');

        });

    }
function GuardarExcel()
{
  var JSONData=$("#jsonCode").val();
  JSONToCSVConvertor(JSONData, "Detalle Incidencias", true)
  
  
}
function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
  var f = new Date();
  fecha =  f.getFullYear()+""+(f.getMonth() +1)+""+f.getDate()+"_";
    //var arrData = Object.values(JSONData);    
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
    var uri = 'data:text/csv;charset=utf-32,' + escape(CSV);
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
