@extends('adminlte::page')

@section('title', 'Edit Advertiser')

@section('content_header')
    <div class="d-flex justify-content-center">
        <div class="col-md-8">
            <x-adminlte-card theme="lime" theme-mode="outline">
                <h1>Modifier Client</h1>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('content')
    <div class="d-flex justify-content-center">
    <div class="col-md-8 col-sm-8 col-12">
        <x-adminlte-card title="Remplir les informations" theme="dark" icon="fas fa-plus">
            <form action="{{ route('web.advertisers.update', $advertiser) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">

                
                   

                    <!-- User related fields -->
                    <div class="form-group">
                        <x-adminlte-input name="name" label="Nom & prénom" placeholder="Entrer le nom et prénom" value="{{ $user->name }}" required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-user text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>
                    <div class="form-group">
                        <x-adminlte-input name="email" label="Email" placeholder="Entrer l'email" type="email" value="{{ $user->email }}" required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-envelope text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>
                    <div class="form-group">
                        <x-adminlte-input name="phone_number" label="Numéro" placeholder="Entrer le numéro de téléphone" value="{{ $user->phone_number }}" required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-phone text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>
                    <span id="phone_number_error" class="text-danger"></span>
                    <div class="form-group">
                        <x-adminlte-input name="password" label="Password" placeholder="Entrer un nouveau mot de passe pour le changer" type="password">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-lock text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>
                    <x-adminlte-select name="domain" label="Domaine" label-class="text-lightblue" data-placeholder="Selectionner un domaine" required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-globe text-lightblue"></i>
                            </div>
                        </x-slot>
                        @foreach($domains as $domain)
                            <option value="{{ $domain }}" {{ $domain == old('domain', $advertiser->domain) ? 'selected' : '' }}>{{ $domain }}</option>
                        @endforeach
                    </x-adminlte-select>

 

                    <div class="form-group"> 
                        <x-adminlte-input name="firm" label="Entreprise" placeholder="Entrer le nom de l'entreprise" value="{{ $advertiser->firm }}" required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-building text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>
                    <div class="d-flex justify-content-end">
                        <x-adminlte-button class="mr-2" type="submit" theme="success" icon="fas fa-lg fa-save" label="Enregistrer"/>
                    </div>
                </div>
            </form>
        </x-adminlte-card>
    </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#phone_number').blur(function() {
                var error_phone_number = '';
                var phone_number = $('#phone_number').val();

                if (!phone_number.match(/^0[67][0-9]{8}$/)) {
                    error_phone_number = '<label class="text-danger">Phone number format is invalid</label>';
                }

                $('#phone_number_error').html(error_phone_number);
            });
        });
    </script>
@stop
