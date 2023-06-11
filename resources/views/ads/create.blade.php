@extends('adminlte::page')

@section('title', 'Create Pack')

@section('content_header')
    <h1>Create Pack</h1>
@stop

@section('content')
    <div class="col-md-6">
        <x-adminlte-card title="Pack Information" theme="dark" icon="fas fa-plus">
            <form action="{{ route('packs.store') }}" method="POST">
                @csrf

                <x-adminlte-input name="name" label="Name" placeholder="Enter name" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-user text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input name="price" type="number" label="Price" placeholder="Enter price" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-dollar-sign text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input name="spots_number" type="number" label="Spots Number" placeholder="Enter spots number" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-users text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-select2 name="days_of_week[]" label="Days of Week" label-class="text-lightblue" data-placeholder="Select days of week" multiple>
                    @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                        <option value="{{ $day }}">{{ $day }}</option>
                    @endforeach
                </x-adminlte-select2>

                <x-adminlte-select2 name="times_of_day[]" label="Times of Day" label-class="text-lightblue" data-placeholder="Select times of day" multiple>
                    @foreach (['07:25:00', '10:25:00', '14:55:00', '17:25:00', '19:10:00'] as $time)
                        <option value="{{ $time }}">{{ $time }}</option>
                    @endforeach
                </x-adminlte-select2>

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
