@extends('adminlte::page')

@section('title', 'Create Role')

@section('content_header')
    <h1>Create Role</h1>
@stop

@section('content')
    <div class="d-flex justify-content-center">
    <div class="col-md-6 col-sm-8 col-12">
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

                <x-adminlte-input name="permissions" label="Permissions" placeholder="Enter permissions (e.g., &quot;permission1&quot;, &quot;permission2&quot;)" required>
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
    </div>
@stop


@section('js')

@stop
