@extends('layout.app')

@section('content')
<div class="row">
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="row">
  <div class="col-md-6">
    <chart-bar></chart-bar>    
  </div>
   <div class="col-md-6">
    <chart-bar></chart-bar>    
  </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
  jQuery(document).ready(function() {
    ComponentsPickers.init(); 
  });
</script>
@endsection
