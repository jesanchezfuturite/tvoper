@extends('layout.app')

@section('content')
<h3 class="page-title">Portal <small>Asignación de campos por trámite</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Portal</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Divisas</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-users"></i>Lista de usuarios
            </div>
        </div>
        <div class="portlet-body">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-3 col-ms-12">
                        <div class="form-group">
                            <select class="select2me form-control" name="usuarios" id="usuarios" onchange="changeTramites()">
                                <option value="limpia">------</option>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">

                <div class="caption" id="headerTabla">
                    <i class="fa fa-cogs"></i>&nbsp;<span id="divisas">Divisas</span> &nbsp;
                    <!--    <span class="label label-sm label-danger">
                            <label id='changeStatus'>No found</label>
                        </span>&nbsp;&nbsp;&nbsp;&nbsp;
                        --->

                </div>
                <div class="tools" id="divisasTools">
                    <!--
                    <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="Agregar Cuenta">
                    </a>
                   <a id="Remov" href="javascript:;" data-original-title="" title="Desactivar Tramite" onclick="desactivaTramite()"><i class='fa fa-remove' style="color:white !important;"></i>
                    </a>-->
                </div>
            </div>
            <div class="portlet-body" id="Removetable">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4 col-ms-12">
                            <div class="form-group">
                                <select class="select2me form-control" name="divisas" id="divisas">
                                    <option value="limpia">------</option>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->

</div>
@endsection

@section('scripts')
<script>


</script>

@endsection
