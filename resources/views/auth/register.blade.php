@extends('layout.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">
                    <form method="POST" action="{{ url('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @if(session('is_admin') == 1)
                        
                            <div class="form-group row">
                                <label for="rol" class="col-md-4 col-form-label text-md-right">{{ __('Rol Usuario') }}</label>
                                <div class="col-md-6">
                                    <select class="select2me form-control"name="rol" id="rol" required>
                                        <option value="">Seleccionar Rol</option>
                                            <option value="0">Usuario</option>
                                            <option value="2">Administrador</option>                                       
                                      </select> 
                                </div>
                            </div>
                            
                            @else
                            <div class="form-group row" hidden="true">
                                <label for="rol" class="col-md-4 col-form-label text-md-right">{{ __('Rol Usuario') }}</label>
                                <div class="col-md-6">
                                    <select class="select2me form-control"name="rol" id="rol" required>
                                        <option value="0">Seleccionar Rol</option>                                       
                                     </select> 
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label for="comunidad" class="col-md-4 col-form-label text-md-right">{{ __('Comunidad') }}</label>
                            <div class="col-md-6">
                                <select class="select2me form-control"name="itemsComunidad" id="itemsComunidad" required>
                                    <option value="0">Seleccionar Comunidad</option>                                       
                                </select> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script type="text/javascript">
  jQuery(document).ready(function() {
    findiComunidad();
    });
  function findiComunidad()
  {

     $.ajax({
           method: "get",            
           url: "{{ url()->route('operacion-roles-get-rol') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {    
          $("#itemsComunidad option").remove();
          $("#itemsComunidad").append("<option value='0'>-------</option>");
            $.each(response, function(i, item) {                
               $("#itemsComunidad").append("<option value='"+item.id+"'>"+item.descripcion+"</option>");  
            });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
</script>
@endsection
