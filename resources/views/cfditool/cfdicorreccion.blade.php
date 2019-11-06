@extends('layout.app')

@section('content')

<h3 class="page-title"> CFDI <small></small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">CFDI</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Corrección de Documentos</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-6">
        <div class="portlet light bordered" style="height:250px;">
            <div class="portlet-title tabbable-line">
                <div class="caption"><i class="fa fa-gear"></i>Información Solicitada</div>
                <ul class="nav nav-tabs">
                    <li><a href="#portlet_tab2" data-toggle="tab" aria-expanded="true">FOLIO UNICO</a></li>
                    <li><a href="#portlet_tab1" data-toggle="tab" aria-expanded="true">RFC</a></li>
                </ul>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane" id="portlet_tab1">
                        <form role="form" id="myform" method="post">
                            <div class="form-body">
                                <div class="form-group form-md-line-input has-success form-md-floating-label">
                                    <div class="input-icon right">
                                        <input type="text" class="form-control" id="rfc" name="rfc" onkeyup="this.value = this.value.toUpperCase();">
                                        <label for="form_control_1"></label>
                                        <span class="help-block">12 o 13 posiciones</span>
                                        <i class="icon-user"></i>
                                    </div>
                                </div>                        
                            </div>
                            <div class="form-actions noborder">
                                <button type="submit" class="btn blue" id="buscar">Buscar <i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="portlet_tab2">
                        <form role="form" id="myform2" method="post">
                            <div class="form-body">
                                <div class="form-group form-md-line-input has-success form-md-floating-label">
                                    <div class="input-icon right">
                                        <input type="text" class="form-control" id="foliounico" name="foliounico">
                                        <label for="form_control_1"></label>
                                        <span class="help-block">30 posiciones maximo</span>
                                        <i class="icon-tag"></i>
                                    </div>
                                </div>                        
                            </div>
                            <div class="form-actions noborder">
                                <button type="submit" class="btn blue" id="buscarfolio">Buscar <i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-12">
        <div class="alert alert-secondary" id="imageloading" style="display: none" role="alert"></div>
        <div class="portlet" style="display: none" id="result-query">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-folder-open"></i>Información del Contribuyente</div>
                <div class="tools"><a href="javascript:;" class="collapse" data-original-title="" title=""></a></div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover" id="ops-cont">
                        <thead>
                            <tr class="row">
                                <th> Folio Unico</th>
                                <th>Folio Pago</th>
                                <th>Fecha de Transacción</th>
                                <th>Timbrado</th>
                                <th>Vigencia</th>
                                <th>Monto</th>
                                <th>Encabezado</th>
                                <th>Detalle</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalTitle"></h4>
            </div>
            <div class="modal-body" style="max-height: 800px;overflow-y: auto;">
                <div class="alert hidden" role="alert" id="modalAlert"></div>
                <input type="hidden" id="myModalID" name="myModalID" value="" />
                <p>Modal example.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar <i class="fa fa-close"></i></button>
                <button type="button" class="btn btn-success" id="btnUpd">Actualizar <i class="fa fa-refresh"></i></button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL -->


@endsection

@section('scripts')
<script type="text/javascript">    

    $.validator.addMethod("RFC", function (value, element) {
        if (value !== '') {
            var patt = new RegExp("^[A-Z,Ñ,&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9][A-Z,0-9]?[A-Z,0-9]?[0-9,A-Z]?$");
            
            return patt.test(value);
        } else {
            return false;
        }
    }, "Ingrese un RFC valido");

    $.validator.addMethod("FOLIO",function(value, element){
        if(value !== ''){
            var patt = new RegExp("^[0-9]{1,30}$");
            return patt.test(value);
        } else {
            return false;
        }
    }, "Ingrese Folio Unico valido");

    var sg = [];
    sg[-1] = "Error al solicitar CFDI";
    sg[0] = "Sin Solicitar";
    sg[1] = "CFDI Solicitado";
    sg[2] = "CFDI Generado";
    sg[3] = "CFDI Cancelado";
    sg[4] = "En Proceso de Cancelacion";

    var sd = [];
    sd[0] = "Vigente";
    sd[2] = "Cancelado";
    sd[3] = "Por Cancelar";
    
        
    $("#myform").validate({
        rules: {
            rfc: {
                required: true,
                RFC: true
            }
        },
        messages:{
            rfc: "Proporcione un RFC"
        },
        submitHandler: function(){
            
            var rfc = $('#rfc').val();

            $.ajax({
                method: "post",
                beforeSend:  function(){
                    
                    $('#result-query').hide();
                    $('#imageloading').html('UBICANDO INFORMACION.......').show();
                },
                url: "{{ url('/cfdi-correccion/busca-rfc') }}",
                data: { rfc: rfc, _token: '{{ csrf_token() }}' }
            })
            .done(function(data){
                var tb = $('#ops-cont').find("tbody");
                var d = JSON.parse(data);

                if(d && typeof d === "object")
                {
                    tb.html('');
                
                    $.each(d,function(key,value){

                        var btn_head = $('<button>')
                            .addClass('btn default btn-xs green')
                            .append($('<i>').addClass('fa fa-edit'))
                            .append(' Editar')
                            .on('click',
                                function(){
                                    loadHeader(value.folio_unico)
                                });
                        
                        var btn_detail = $('<button>')
                            .addClass('btn default btn-xs blue')
                            .append($('<i>').addClass('fa fa-edit'))
                            .append(' Editar')
                            .on('click',
                                function(){
                                    loadDetail(value.folio_unico)
                                });

                        tb.append($('<tr>').addClass('row')
                            .append($('<td>').text(value.folio_unico))
                            .append($('<td>').text(value.folio_pago))
                            .append($('<td>').text(value.fecha_transaccion))
                            .append($('<td>').text(sg[value.estatus_generacion]))
                            .append($('<td>').text(sd[value.estatus_documento]))
                            .append($('<td>').text(value.total))
                            .append($('<td>').append(btn_head))
                            .append($('<td>').append(btn_detail))
                        );                        
                    });

                    $('#imageloading').html('');
                    $('#result-query').show();
                }
                else
                {   
                    $('#imageloading').html('');
                    $('#result-query').html('<div class="alert alert-warning" role="alert">NO SE ENCONTRO INFORMACIÓN DEL RFC</div>').show();
                }                    
            });       
        }
    });

    $("#myform2").validate({
        rules: {
            foliounico:{    
                required: true,
                FOLIO: true
            }
        },
        messages:{
            foliounico: "Proporcione folio unico"
        },
        submitHandler: function(){

            var foliounico = $('#foliounico').val();

            $.ajax({
                method: "post",
                beforeSend:  function(){
                    
                    $('#result-query').hide();
                    $('#imageloading').html('UBICANDO INFORMACION.......').show();
                },
                url: "{{ url('/cfdi-correccion/busca-foliounico') }}",
                data: { fu: foliounico, _token: '{{ csrf_token() }}' }
            })
            .done(function(data){
                var tb = $('#ops-cont').find("tbody");
                var d = JSON.parse(data);

                if(d && typeof d === "object")
                {
                    tb.html('');
                
                    $.each(d,function(key,value){

                        var btn_head = $('<button>')
                            .addClass('btn default btn-xs green')
                            .append($('<i>').addClass('fa fa-edit'))
                            .append(' Editar')
                            .on('click',
                                function(){
                                    loadHeader(value.folio_unico)
                                });
                        
                        var btn_detail = $('<button>')
                            .addClass('btn default btn-xs blue')
                            .append($('<i>').addClass('fa fa-edit'))
                            .append(' Editar')
                            .on('click',
                                function(){
                                    loadDetail(value.folio_unico)
                                });

                        tb.append($('<tr>').addClass('row')
                            .append($('<td>').text(value.folio_unico))
                            .append($('<td>').text(value.folio_pago))
                            .append($('<td>').text(value.fecha_transaccion))
                            .append($('<td>').text(sg[value.estatus_generacion]))
                            .append($('<td>').text(sd[value.estatus_documento]))
                            .append($('<td>').text(value.total))
                            .append($('<td>').append(btn_head))
                            .append($('<td>').append(btn_detail))
                        );                        
                    });

                    $('#imageloading').html('');
                    $('#result-query').show();
                }
                else
                {   
                    $('#imageloading').html('');
                    $('#result-query').html('<div class="alert alert-warning" role="alert">NO SE ENCONTRO INFORMACIÓN DEL RFC</div>').show();
                }                    
            });
        }
    });

    function loadHeader(id)
    {
        if(id != "" && id != 'undefined')
        {   
            if($('#btnAdd').length)
            {
                var b = $('#myModal').find('#btnAdd');
                b.remove();
            }

            $.ajax({
                method: "get",
                url: "{{ url('/cfdi-correccion/encabezado') }}",
                data: { fu: id, _token: '{{ csrf_token() }}' }
            })
            .done(function(data){

                var mbody = $('#myModal').find('.modal-body');
                var mdata = JSON.parse(data);
                
                mbody.html('');
                $('#myModalTitle').html('Edición de Encabezado');
                mbody.append(
                    $('<form>',{ role: 'form',id:'edit-form' }).addClass('form-horizontal')
                        .append($('<div>').addClass('form-body')
                            .append($('<div>').addClass('form-group')
                                .append($('<label>').addClass('col-md-3 control-label').text('Folio Unico'))
                                .append($('<div>').addClass('col-md-9')
                                    .append($('<input>',{type:'hidden',name:'id',value:mdata[0].idcfdi_encabezados}))
                                    .append($('<input>',{value: mdata[0].folio_unico,name:'folio_unico'}).addClass('form-control').attr('readonly',true)))
                            )
                            .append($('<div>').addClass('form-group')
                                .append($('<label>').addClass('col-md-3 control-label').text('Folio Pago'))
                                .append($('<div>').addClass('col-md-9')
                                    .append($('<input>',{ value: mdata[0].folio_pago,name:'folio_pago' }).addClass('form-control').attr('readonly',true)))
                            )
                            .append($('<div>').addClass('form-group')
                                .append($('<label>').addClass('col-md-3 control-label').text('Fecha Transacción'))
                                .append($('<div>').addClass('col-md-9')
                                    .append($('<input>',{ value: mdata[0].fecha_transaccion,name:'fecha_transaccion' }).addClass('form-control').attr('readonly',true)))
                            )
                            .append($('<div>').addClass('form-group')
                                .append($('<label>').addClass('col-md-3 control-label').text('Total'))
                                .append($('<div>').addClass('col-md-9')
                                    .append($('<input>',{ value: mdata[0].total,name:'total' }).addClass('form-control').attr('readonly',true)))
                            )
                            .append($('<div>').addClass('form-group')
                                .append($('<label>').addClass('col-md-3 control-label').text('Metodo de Pago'))
                                .append($('<div>').addClass('col-md-9')
                                    .append($('<input>',{ value: mdata[0].metodo_de_pago,name:'metodo_pago' }).addClass('form-control')))
                            )
                        )
                        .append($('<input>',{type:'hidden',value:'header',name:'edit',id:'edit'}))
                        .append($('<input>',{type:'hidden',value:'{{ csrf_token() }}',name:'_token'}))
                    );
                $('.modal-dialog').removeClass('modal-full');
                $('#btnUpd').attr('disabled',false);
                $("#myModal").modal('show');
            });
        }
    }

    function loadDetail(id)
    {
        if(id != "" && id != 'undefined')
        {   
            if($('#btnAdd').length)
            {
                var b = $('#myModal').find('#btnAdd');
                b.remove();
            }           
            $.ajax({
                method: "get",
                url: "{{ url('/cfdi-correccion/detalle') }}",
                data: { fu: id, _token: '{{ csrf_token() }}' }
            })
            .done(function(data){
                
                var mbody = $('#myModal').find('.modal-body');
                var mdata = JSON.parse(data);
                var t = $('<table>',{id:'tblDetails'}).addClass('table table-hover');

                mbody.html('');

                $('#myModalTitle').html('Edición del Detalle');
                
                if(!mdata.length)
                {
                    alert('Elemento Vacio');
                }
                else
                {   
                    var thead = $('<thead>');
                    
                    thead.append($('<tr>')
                        .append($('<td>').append($('<b>').text('Folio Unico')))
                        .append($('<td>').append($('<b>').text('Cantidad')))
                        .append($('<td>').append($('<b>').text('Unidad')))
                        .append($('<td>').append($('<b>').text('Concepto')))
                        .append($('<td>').append($('<b>').text('Precio Unitario')))
                        .append($('<td>').append($('<b>').text('Importe')))
                        .append($('<td>').append($('<b>').text('Partida')))
                        .append($('<td>').append($('<b>').text('Fecha Registro')))
                    );
                    
                    var tbody = $('<tbody>');
                    var idrow = null;
                    var ferow = null;

                    $.each(mdata,function(i,item){
                        tbody.append($('<tr>')
                            .append($('<input>',{type:'hidden',value:item.idcfdi_detalle,name:'ids[]'}))
                            .append($('<td>').append($('<input>',{name:'fun[]',value:item.folio_unico}).attr('readonly',true).addClass('form-control')))
                            .append($('<td>').append($('<input>',{name:'can[]',value:item.cantidad}).attr('readonly',true).addClass('form-control input-xsmall')))
                            .append($('<td>').append($('<input>',{name:'uni[]',value:item.unidad}).attr('readonly',true).addClass('form-control input-xsmall')))
                            .append($('<td>').append($('<input>',{name:'con[]',value:item.concepto}).attr('readonly',false).addClass('form-control')))
                            .append($('<td>').append($('<input>',{name:'pre[]',value:item.precio_unitario}).attr('readonly',false).addClass('form-control')))
                            .append($('<td>').append($('<input>',{name:'imp[]',value:item.importe}).attr('readonly',false).addClass('form-control')))
                            .append($('<td>').append($('<input>',{name:'par[]',value:item.partida}).attr('readonly',false).addClass('form-control input-xsmall')))
                            .append($('<td>').append($('<input>',{name:'fec[]',value:item.fecha_registro}).attr('readonly',true).addClass('form-control')))
                        );
                        idrow = item.folio_unico;
                        ferow = item.fecha_registro;
                    });

                    var b = $('#myModal').find('.modal-footer');
                    b.append($('<button>',{id:'btnAdd'}).attr('disabled',false).on('click',function(){addRow(idrow,ferow)}).addClass('btn btn-primary').text('Nuevo ').append($('<i>').addClass('fa fa-plus')));

                    t.append(thead).append(tbody);
                    
                    mbody.append($('<form>',{ role: 'form',id: 'edit-form' }).addClass('form-horizontal')
                        .append($('<div>').addClass('form-body').append(t)
                            .append($('<input>',{type:'hidden',value:'detail',name:'edit',id:'edit'}))
                            .append($('<input>',{type:'hidden',value:'{{ csrf_token() }}',name:'_token'})))
                    )
                    $('.modal-dialog').addClass('modal-full');
                    $('#btnUpd').attr('disabled',false);
                    $("#myModal").modal('show');
                }
            });
        }
    }
    
    function addRow(id,fecha) 
    {   
        var row = $('<tr>')
            .append($('<input>',{type:'hidden',value:"-1",name:'ids[]'}))
            .append($('<td>').append($('<input>',{name:'fun[]',value:id}).attr('readonly',true).addClass('form-control')))                                         // FolioUnico
            .append($('<td>').append($('<input>',{name:'can[]',value:'1.00'}).attr('readonly',true).addClass('form-control input-xsmall')))                            // Cantidad
            .append($('<td>').append($('<input>',{name:'uni[]',value:'Servicio'}).attr('readonly',true).addClass('form-control input-xsmall')))  // Unidad
            .append($('<td>').append($('<input>',{name:'con[]'}).addClass('form-control')))                                         // Concepto
            .append($('<td>').append($('<input>',{name:'pre[]'}).addClass('form-control')))                                         // PrecioUnitario
            .append($('<td>').append($('<input>',{name:'imp[]'}).addClass('form-control')))                                         // Importe
            .append($('<td>').append($('<input>',{name:'par[]'}).addClass('form-control input-xsmall')))                            // Partida
            .append($('<td>').append($('<input>',{name:'fec[]',value:fecha}).attr('readonly',true).addClass('form-control')))                                         // FechaRegistro

        $('#tblDetails > tbody').append(row);    
    }

    $('#btnUpd').on('click',function(){
        var mbody = $('#myModal').find('.modal-body');
        
        $.ajax({
            method: "post",
            url: "{{ url('/cfdi-correccion/edit') }}",
            data: $('#edit-form').serialize(),
            beforeSend:function(){
                return confirm("¿Desea guardar los cambios?");
            },
        })
        .done(function(data){

            $('#edit-form input').attr('readonly',true);
            $('#btnUpd').attr('disabled',true);
            $('#btnAdd').attr('disabled',true);        

        })
        .fail(function(msg){
            console.log(msg);
        });

    });

</script>
@endsection
