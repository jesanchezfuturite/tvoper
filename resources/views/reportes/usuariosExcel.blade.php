<!DOCTYPE html>
<html>
<head>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>Número Notaría</th>
        <th>CURP</th>
        <th>Nombre</th>
        <th>Apellido Paterno</th>
        <th>Apellido Materno</th>
        <th>RFC</th>
        <th>Número de Teléfono</th>
        <th>Correo Electrónico</th>
        <th>Usuario</th>
        <th>Perfil</th>
        <th>Estatus</th>       
        <th>Constancia SAT</th>
        <th>Constancia Notario</th>
    </tr>
    </thead>
    <tbody>
   @foreach ($users as $user)
        <tr>
           <td >{{ $user->notary_number }}</td>
           <td >{{ $user->curp }}</td>
           <td >{{ $user->name }}</td>
           <td >{{ $user->fathers_surname }}</td>
           <td >{{ $user->mothers_surname }}</td>
           <td >{{ $user->rfc }}</td>
           <td >{{ $user->phone }}</td>
           <td >{{ $user->email }}</td>
           <td >{{ $user->username }}</td>
           <td >{{ $user->role }}</td>
           @if($user->status==1)
                <td>Activo</td>
           @else 
                <td>Inactivo</td>
           @endif

           @if($user->role=="Notario Titular" && $user->status==1)
               @if($user->sat_constancy_file!=null)
                    <td><a href="{{url()->route('file', $user->sat_constancy_file) }}"></a>{{url()->route('file', $user->sat_constancy_file) }}</td>
               @else
                    <td></td>
               @endif
               
               @if($user->notary_constancy_file!=null)
                    <td><a href="{{url()->route('file', $user->notary_constancy_file) }}">{{url()->route('file', $user->notary_constancy_file) }}</a></td>
               @else
                    <td></td>
               @endif
           @else
           <td></td>
           <td></td>
           @endif
        </tr>
    @endforeach
    </tbody>
   </table>
 </body>