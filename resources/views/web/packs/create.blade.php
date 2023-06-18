@extends('adminlte::page')

@section('title', 'Create Pack')

@section('content_header')
    <div class="d-flex justify-content-center">
        <div class="col-md-8">
            <x-adminlte-card theme="lime" theme-mode="outline">
                <h1>Créer un nouveau Pack</h1>
            </x-adminlte-card>
        </div>
    </div>
@stop 

@section('plugins.BootstrapSelect', true)

@section('content')
    <div class="d-flex justify-content-center">
    <div class="col-md-8 col-sm-8 col-12">
        <x-adminlte-card title="Informations du Pack" theme="dark" icon="fas fa-plus">
            <form action="{{ route('web.packs.store') }}" method="POST">
               
                @csrf 

                <x-adminlte-input name="name" label="Titre" label-class="text-lightblue" placeholder="Entrer le titre du Pack" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-user text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input name="price" type="number" label-class="text-lightblue" label="Prix" placeholder="Entrer le prix du Pack" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-dollar-sign text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input name="spots_number" type="number" label-class="text-lightblue" label="Nb de Spots" placeholder="Entrer le nombre de spots" required min="0">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-users text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                @php
                    $config = [ 
                        "title" => "Selectionner les jours du Pack",
                        "liveSearch" => false,
                        "liveSearchPlaceholder" => "Search...",
                        "showTick" => true,
                        "actionsBox" => true,
                    ];
                    $config2 = [
                        "title" => "Selectionner les horaires du Pack",
                        "liveSearch" => false,
                        "liveSearchPlaceholder" => "Search...",
                        "showTick" => true,
                        "actionsBox" => true,
                    ];
                @endphp
 
                <x-adminlte-select-bs id="days_of_week" name="days_of_week[]" label="Jours de la semaine " label-class="text-lightblue" :config="$config" multiple required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-calendar text-lightblue"></i>
                        </div>
                    </x-slot>
                    @foreach($daysOfWeek as $day)
                        <option value="{{ $day }}">{{ $day }}</option>
                    @endforeach
                </x-adminlte-select-bs>

                <x-adminlte-select-bs id="times_of_day" name="times_of_day[]" label="Horaires" label-class="text-lightblue" :config="$config2" multiple required>
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
                        <input class="custom-control-input" type="checkbox" id="availability" name="availability" >
                        <label for="availability" class="custom-control-label">Disponibilité</label>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <x-adminlte-button class="mr-2" type="submit" theme="success" icon="fas fa-lg fa-save" label="Enregistrer"/>
                  </div>
            </form>
        </x-adminlte-card>
    </div>
    </div>
@stop

@section('js')


@stop
