@extends('layout.app')

@section('content')
<h3 class="page-title"> Conciliación <small>Carga de Archivo</small></h3>
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
            <a href="#">Carga de Archivos</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12 ">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Carga de archivos para conciliación
                </div>
            </div>
            <div class="portlet-body form">
                <form action=" {{ url('/conciliacion-uploadfile') }}" method="POST" role="form" method="post" enctype="multipart/form-data" >
                    @csrf
                    <div class="form-body">
                        <div class="form-group">
                            <label for="exampleInputFile1">Cargar Archivo</label>
                            <input multiple="multiple" type="file" id="files[]" name="files[]">
                            <p class="help-block">

                                @if($valid == 1)
                                    Archivo para conciliar
                                @elseif($valid == 0)
                                    Archivo incorrecto - por favor verifique lo que intenta subir
                                @else
                                    Archivo cargado correctamente
                                @endif
                                 
                            </p>
                        </div>
                        
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Procesar</button>
                        <button type="button" class="btn default">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
@endsection

@section('scripts')

@endsection
