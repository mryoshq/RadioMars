@extends('adminlte::page')

@section('title', 'Create Role')

@section('content_header')
    <h1>Create Role</h1>
@stop

@section('content')
    <div class="col-md-6">
        <x-adminlte-card title="Role Information" theme="dark" icon="fas fa-plus">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf

                <x-adminlte-input name="name" label="Name" placeholder="Enter name" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-user text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input name="permissions" label="Permissions" placeholder="Enter permissions" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-lock text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <div class="d-flex justify-content-end">
                    <x-adminlte-button class="mr-2" type="submit" theme="success" icon="fas fa-lg fa-save" label="Save"/>
                </div>
            </form>
        </x-adminlte-card>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Add any additional JavaScript logic here
        });
    </script>
@stop
