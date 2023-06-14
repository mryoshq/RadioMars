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

                <x-adminlte-input name="days_of_week" type="text" label="Days of Week" placeholder="Enter days of week (optional)">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-calendar text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input name="times_of_day" type="text" label="Times of Day" placeholder="Enter times of day (optional)">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-clock text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input name="availability" type="checkbox" label="Availability" :checked="old('availability', true)">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-check text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <div class="d-flex justify-content-end">
                    <x-adminlte-button class="mr-2" type="submit" theme="success" icon="fas fa-lg fa-save" label="Save"/>
                    <x-adminlte-button href="{{ route('packs.index') }}" type="button" theme="danger" icon="fas fa-lg fa-times" label="Cancel"/>
                </div>
            </form>
        </x-adminlte-card>
    </div>
@stop

@section('js')

@stop
