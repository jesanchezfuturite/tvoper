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
            <a href="#">Cancelación de Documentos</a>
        </li>
    </ul>
</div>

<div class="row">
	<div class="col-md-5 col-sm-4 col-xs-3">
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
                                <th colspan="2">INFORMACION</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

	$.validator.addMethod("FOLIO",function(value, element){
        if(value !== ''){
            var patt = new RegExp("^[0-9,A-Z]{1,30}$");
            return patt.test(value);
        } else {
            return false;
        }
    }, "Ingrese Folio Unico valido");

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
</script>

@ensection