@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <div class="d-flex justify-content-center">
        <div class="col-md-8">
            <x-adminlte-card theme="lime" theme-mode="outline">
                <h2>Modifier l'utilisateur</h2>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-md-8 col-sm-8 col-12">
            <x-adminlte-card title="Mise à jour des informations" theme="dark" icon="fas fa-user-edit">
                <form action="{{ route('web.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <x-adminlte-input name="name" label-class="text-lightblue" label="Nom & prénom" placeholder="Entrer le nom complet" value="{{ old('name', $user->name) }}" required/>
                        <x-adminlte-input name="email" type="email" label-class="text-lightblue" label="E-mail" placeholder="Entrer un email valide" value="{{ old('email', $user->email) }}" required/>
                        <x-adminlte-input id="phone_number" name="phone_number" label-class="text-lightblue" label="Numéro de télephone" placeholder="Introduire un numéro de telephone valide" value="{{ old('phone_number', $user->phone_number) }}" required/>
                        <span id="phone_number_error" class="text-danger"></span>
                        <x-adminlte-input name="password" type="password" label="Mot de passe" placeholder="Entrer un nouveau mot de passe pour le changer"  label-class="text-lightblue">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-lock text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>

                        <x-adminlte-select2 name="role_id" label-class="text-lightblue" label="Rôle utilisateur" data-placeholder="Selectionner un rôle" value="{{ old('role_id', $user->role_id) }}" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $role->id == $user->role_id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                    
                    <div class="card-footer d-flex justify-content-end">
                        <x-adminlte-button class="btn-flat" type="submit" theme="success" icon="fas fa-lg fa-save" label="Enregistrer"/>
                    </div>
                </form>
            </x-adminlte-card>
        </div>
    </div> 
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
