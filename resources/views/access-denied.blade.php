@extends('adminlte::page')

@section('title', 'Access Denied')


@section('content')

<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
     
    <div class="col-md-8">
    <x-adminlte-card title="Access Denied" theme="danger" disabled>
        <p>You do not have permission to access this page. Please contact the administrator.</p>
    </x-adminlte-card>
    </div>

</div>
    
@stop

@section('js')

@stop
