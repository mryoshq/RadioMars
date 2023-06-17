@extends('adminlte::page')

@section('title', 'Create Pack')

@section('content_header')
    <h1>Create Pack</h1>
@stop 

@section('plugins.BootstrapSelect', true)

@section('content')
    <div class="d-flex justify-content-center">
    <div class="col-md-6 col-sm-8 col-12">
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

                <x-adminlte-input name="spots_number" type="number" label="Spots Number" placeholder="Enter number of spots" required min="0">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-users text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                @php
                    $config = [
                        "title" => "Select multiple options...",
                        "liveSearch" => false,
                        "liveSearchPlaceholder" => "Search...",
                        "showTick" => true,
                        "actionsBox" => true,
                    ];
                @endphp
 
                <x-adminlte-select-bs id="days_of_week" name="days_of_week[]" label="Days of Week" label-class="text-lightblue" :config="$config" multiple required>
                
               
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-calendar text-lightblue"></i>
                        </div>
                    </x-slot>
                    @foreach($daysOfWeek as $day)
                        <option value="{{ $day }}">{{ $day }}</option>
                    @endforeach
                </x-adminlte-select-bs>

                <x-adminlte-select-bs id="times_of_day" name="times_of_day[]" label="Times of Day" label-class="text-lightblue" :config="$config" multiple required>
                     <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-clock text-lightblue"></i>
                        </div>
                    </x-slot>
                    @foreach($timesOfDay as $time)
                        <option value="{{ $time }}">{{ $time }}</option>
                    @endforeach
                </x-adminlte-select-bs>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="availability" name="availability" checked>
                        <label for="availability" class="custom-control-label">Availability</label>
                    </div>
                </div>

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
