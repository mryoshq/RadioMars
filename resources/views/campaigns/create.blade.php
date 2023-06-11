@extends('adminlte::page')

@section('title', 'Create Campaign')

@section('content_header')
    <h1>Create Campaign</h1>
@stop

@section('content')
    <div class="col-md-6">
        <x-adminlte-card title="Campaign Information" theme="dark" icon="fas fa-plus">
            <form action="{{ route('campaigns.store') }}" method="POST">
                @csrf

                <x-adminlte-select2 name="user_id" label="User" label-class="text-lightblue" data-placeholder="Select a user" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </x-adminlte-select2>

                <x-adminlte-select2 name="status" label="Status" label-class="text-lightblue" data-placeholder="Select a status" required>
                    <option value="planning">Planning</option>
                    <option value="active">Active</option>
                    <option value="ended">Ended</option>
                </x-adminlte-select2>

                <div class="d-flex justify-content-end">
                    <x-adminlte-button class="mr-2" type="submit" theme="success" icon="fas fa-lg fa-save" label="Save"/>
                    <x-adminlte-button href="{{ route('campaigns.index') }}" type="button" theme="danger" icon="fas fa-lg fa-times" label="Cancel"/>
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
