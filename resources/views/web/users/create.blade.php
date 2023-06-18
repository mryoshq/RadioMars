@extends('adminlte::page')

@section('title', 'Create User')

@section('content_header')
 <h1>Créer un nouveau utilisteur</h1>
@stop

@section('content')
<div class="d-flex justify-content-center">
<div class="col-md-8 col-sm-8 col-12">
<x-adminlte-card title="Remplir les informations" theme="dark" icon="">
    <form action="{{ route('web.users.store') }}" method="POST">
        @csrf
        <x-adminlte-input name="name" label="Nom & prénom" placeholder="Entrer le nom complet" label-class="text-lightblue" value="{{ old('name') }}" required>
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-user text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="email" type="email" label="E-mail" placeholder="Entrer un email valide" label-class="text-lightblue" value="{{ old('email') }}" required>
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-envelope text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="password" type="password" label="Mot de passe" placeholder="Entrer un mot de passe"  label-class="text-lightblue" required>
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-lock text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="phone_number" id="phone_number" label="Numéro de télephone" placeholder="Introduire un numéro de telephone valide" label-class="text-lightblue" value="{{ old('phone_number') }}" required>
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-phone text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
        <span id="phone_number_error" class="text-danger"></span>


        <x-adminlte-select2 name="role_id" label="Rôle utilisateur" label-class="text-lightblue" data-placeholder="Selectionner un rôle" required>
            <x-slot name="prependSlot">
                <div class="input-group-text bg-gradient-info">
                    <i class="fas fa-user-tag"></i>
                </div>
            </x-slot>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ $role->name == 'User' ? 'selected' : '' }}>{{ $role->name }}</option>
            @endforeach
        </x-adminlte-select2>

        <div class="mb-4" style="text-align: right;">
            <x-adminlte-button class="btn-flat" type="submit" theme="success" icon="fas fa-lg fa-save" label="Enregistrer"/>
        </div>
    </form>
    </x-adminlte-card>
</div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')

<script>
$(document).ready(function(){
    $('#phone_number').blur(function(){
        var error_phone_number = '';
        var phone_number = $('#phone_number').val();
        var _token = $('input[name="_token"]').val();

        if(!phone_number.match(/^0[67][0-9]{8}$/)){
            $('#phone_number_error').html('<label class="text-danger">Phone number format is invalid</label>');
        } else {
            $('#phone_number_error').html('');
        }
    });
});
</script>
@stop

