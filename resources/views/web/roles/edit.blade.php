@extends('adminlte::page')

@section('title', 'Edit Role')

@section('content_header')
<div class="d-flex justify-content-center">
    <div class="col-md-8">
        <x-adminlte-card theme="lime" theme-mode="outline">
            <h2>Modifier le rôle</h2>
        </x-adminlte-card>
    </div>
</div>
@stop 
 
@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-md-8 col-sm-8 col-12">
            <x-adminlte-card title="Remplir les informations" theme="dark" icon="">
                <form action="{{ route('web.roles.update', $role) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="text-lightblue">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $role->name) }}">
                        </div>

                     
                        @foreach($allPermissions as $permission)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="{{ $permission }}" value="{{ $permission }}" {{ in_array($permission, old('permissions', $role->permissions)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $permission }}">
                                    {{ $permission }}
                                </label>
                            </div>
                        @endforeach


                    </div>

                    <div class="d-flex justify-content-end">
                    <x-adminlte-button class="mr-2" type="submit" theme="success" icon="fas fa-lg fa-save" label="Mettre à jour"/>
                </div>
                </form> 
            </x-adminlte-card>
        </div> 
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop
