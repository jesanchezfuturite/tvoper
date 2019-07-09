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
    <div class="col-md-3">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-sunglo"><i class="fa fa-gear"></i>Información Solicitada</div>
                <div class="actions"><a href="" class="collapse" data-original-title="" title=""></a></div>
            </div>
            <div class="portlet-body form">
                <form role="form">
                    <div class="form-body">
                        <div class="form-group form-md-line-input has-success form-md-floating-label">
                            <div class="input-icon right">
                                <input type="text" class="form-control" id="rfc">
                                <label for="form_control_1">RFC Contribuyente</label>
                                <span class="help-block">12 o 13 posiciones</span>
                                <i class="icon-user"></i>
                            </div>
                        </div>                        
                    </div>
                    <div class="form-actions noborder">
                        <button type="button" class="btn blue" id="buscar">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="text-center" id="imageloading"></div>
        <div class="portlet" style="display: none" id="result-query">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-folder-open"></i>Información del Contribuyente</div>
                <div class="tools"><a href="javascript:;" class="collapse" data-original-title="" title=""></a></div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover" id="ops-cont">
                        <thead>
                            <tr>
                                <th> Folio Unico</th>
                                <th>Folio Pago</th>
                                <th>Fecha de Transacción</th>
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('scripts')
<script type="text/javascript">
    $('#buscar').click(function(){

        var rfc = $('#rfc').val();

        $.ajax({
            method: "post",
            beforeSend:  function(){
                $('#result-query').hide();
                $('#imageloading').html('Ubicando información.......');
            },
            url: "{{ url('/cfdi-correccion/busca-rfc') }}",
            data: { rfc: rfc, _token: '{{ csrf_token() }}' }
        })
        .done(function(data){
            var tb = $('#ops-cont').find("tbody");
            var d = JSON.parse(data);

            tb.html('');
            
            $.each(d,function(key,value){
                tb.append('<tr role="row"><td>'+value.folio_unico+'</td><td>'+value.folio_pago+'</td><td>'+value.fecha_transaccion+'</td><td>'+value.total+'</td></tr>');
            });
            $('#imageloading').html('');
            $('#result-query').show();
            // console.log(data);
        })        
    });
</script>
@endsection
