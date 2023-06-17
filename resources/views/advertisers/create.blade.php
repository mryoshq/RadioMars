@extends('adminlte::page')

@section('title', 'Create Advertiser')

@section('content_header')
    <h1>Create Advertiser</h1>
@stop

@section('content')
<div class="d-flex justify-content-center">
<div class="col-md-6 col-sm-8 col-12">
<x-adminlte-card title="Fill in the information" theme="dark" icon="">
    <form action="{{ route('advertisers.store') }}" method="POST">
        @csrf

        <x-adminlte-input name="name" label="Nom & prénom" placeholder="Enter name" value="{{ old('name') }}" required>
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-user text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="email" type="email" label="E-mail" placeholder="Enter email" value="{{ old('email') }}" required>
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-envelope text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="password" type="password" label="Mot de passe" placeholder="Enter password" required>
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-lock text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="phone_number" id="phone_number" label="Numéro de téléphone" placeholder="Enter phone number" value="{{ old('phone_number') }}" required>
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-phone text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
        <span id="phone_number_error" class="text-danger"></span>

        <x-adminlte-input name="firm" label="Entreprise" placeholder="Enter company name" value="{{ old('firm') }}" maxlength="40" required>
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-building text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-select name="domain" label="Domaine" label-class="text-lightblue" data-placeholder="Select domain" required>
    <x-slot name="prependSlot">
        <div class="input-group-text">
            <i class="fas fa-globe text-lightblue"></i>
        </div>
    </x-slot>
    @foreach ($domains as $domain)
        <option value="{{ $domain }}">{{ $domain }}</option>
    @endforeach
</x-adminlte-select>

        <div class="mb-4" style="text-align: right;">
            <x-adminlte-button class="btn-flat" type="submit" theme="success" icon="fas fa-lg fa-save" label="Save"/>
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
