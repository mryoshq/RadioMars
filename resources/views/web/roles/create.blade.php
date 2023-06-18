@extends('adminlte::page')

@section('title', 'Create Role')

@section('content_header')
    <div class="d-flex justify-content-center">
        <div class="col-md-8">
            <x-adminlte-card theme="lime" theme-mode="outline">
                <h2 >Créer un nouveau rôle</h2>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-md-8 col-sm-8 col-12">
            <x-adminlte-card title="Remplir les informations" theme="dark" icon="fas fa-plus">
                <form action="{{ route('web.roles.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <x-adminlte-input name="name" label-class="text-lightblue" label="Titre" placeholder="Entrer un titre" required>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-user text-lightblue"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>

                        <div class="form-group">
                            <x-adminlte-input name="permissions" label-class="text-lightblue" label="Permissions" placeholder="Entrer les permissions du rôle (e.g., &quot;permission1&quot;, &quot;permission2&quot;)" required>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-lock text-lightblue"></i>
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

@stop
