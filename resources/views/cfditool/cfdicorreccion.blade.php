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
    <div class="col-xs-12 col-sm-6 col-md-4">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-sunglo"><i class="fa fa-gear"></i>Información Solicitada</div>
                <div class="actions"><a href="" class="collapse" data-original-title="" title=""></a></div>
            </div>
            <div class="portlet-body form">
                <form role="form" id="myform">
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
            <div class="modal-body">
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
            var b = $('#myModal').find('#btnAdd');
            b.remove();

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
            if(!$('#btnAdd').length)
            {
                var b = $('#myModal').find('.modal-footer');
                b.append($('<button>',{id:'btnAdd'}).on('click',function(){addRow()}).addClass('btn btn-primary').text('Nuevo ').append($('<i>').addClass('fa fa-plus')));
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
                    });

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
    
    function addRow() 
    {
        var row = $('<tr>')
            .append($('<input>',{type:'hidden',value:0,name:'ids[]'}))
            .append($('<td>').append($('<input>',{name:'fun[]'}).addClass('form-control')))                                         // FolioUnico
            .append($('<td>').append($('<input>',{name:'can[]'}).addClass('form-control input-xsmall')))                            // Cantidad
            .append($('<td>').append($('<input>',{name:'uni[]',value:'Servicio'}).attr('readonly',true).addClass('form-control input-xsmall')))  // Unidad
            .append($('<td>').append($('<input>',{name:'con[]'}).addClass('form-control')))                                         // Concepto
            .append($('<td>').append($('<input>',{name:'pre[]'}).addClass('form-control')))                                         // PrecioUnitario
            .append($('<td>').append($('<input>',{name:'imp[]'}).addClass('form-control')))                                         // Importe
            .append($('<td>').append($('<input>',{name:'par[]'}).addClass('form-control input-xsmall')))                            // Partida
            .append($('<td>').append($('<input>',{name:'fec[]'}).addClass('form-control')))                                         // FechaRegistro

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
            if(data.length)
            {
                $('#edit-form input').attr('readonly',true);
                $('#btnUpd').attr('disabled',true);
            }
        });

        // console.log(reference.value);
    });

</script>
@endsection
