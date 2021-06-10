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
                <form action=" {{ url()->route('conciliacion-uploadfile') }}" method="POST" role="form" method="post" enctype="multipart/form-data" >
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
                                <h1>
                                    Archivo cargado correctamente
                                </h1>
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
@if(count($files) > 0)
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-files-o"></i>Archivos en el sistema de conciliación
                </div>
            </div>
            <div class="portlet-body">
                
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                <thead>
                <tr>
                    <th>
                         Nombre del archivo
                    </th>
                    <th>
                         Estatus
                    </th>
                    <!--
                    <th>
                         Acciones
                    </th>
                    -->
                </tr>
                </thead>
                <tbody>
                @foreach($files as $row)
                <tr>
                    <td>
                         {{$row["file"]}}
                    </td>
                    <td>
                        @if(strcmp($row["status"],'PR') == 0)
                            <span class="label label-success">
                                {{$row["status"]}}
                        @else
                            <span class="label label-danger">
                                {{$row["status"]}}
                        @endif
                            </span>
                    </td>
                    <!--
                    <td>
                        <a href="{{$row['path']}}" class="btn btn-icon-only default">
                            <i class="fa fa-cloud-download"></i>
                        </a>
                    </td>
                    -->
                </tr>
                @endforeach
                </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
@else
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <strong>Alerta!</strong> No existen archivos en el servidor.
        </div>
    </div>
</div>
@endif


@endsection

@section('scripts')
<script type="text/javascript">
    

</script>



@endsection
