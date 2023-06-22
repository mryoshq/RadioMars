@extends('adminlte::page')

@section('title', 'Edit Pack')

@section('content_header')
    <div class="d-flex justify-content-center">
        <div class="col-md-8">
            <x-adminlte-card theme="lime" theme-mode="outline">
                 <h1>Modifier Pack</h1>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.BootstrapSelect', true)

@section('content')
    <div class="d-flex justify-content-center">
    <div class="col-md-8 col-sm-8 col-12">
        <x-adminlte-card title="Informations du Pack" theme="dark" icon="fas fa-plus">
            <form action="{{ route('web.packs.update', $pack) }}" method="POST">
                @csrf
                @method('PUT')
                <x-adminlte-input name="name" label="Titre" label-class="text-lightblue" placeholder="Entrer le titre du Pack" value="{{ $pack->name }}" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-user text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="description" label="Description" label-class="text-lightblue" placeholder="Enter the description of the Pack" value="{{ $pack->description }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-info text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                @php
    $nVariations = count($pack->period);
@endphp


<div id="variations-container">
    <div class="d-flex justify-content-center">
        <button id="add-variation-btn" type="button" class="btn btn-primary">Add Variation</button>
    </div>
    @for ($i = 0; $i < $nVariations; $i++)
        <details class="mb-4">
            <summary class="btn btn-dark">
                <span>Variation {{ $i + 1 }}</span>
            </summary> 
            
            <div class="card-body">
                <x-adminlte-input name="period[]" type="number" label-class="text-lightblue" label="Period" placeholder="Enter the period of the Pack" value="{{ $pack->period[$i] }}" required min="1" max="8">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-calendar-alt text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input name="price[]" type="number" label-class="text-lightblue" label="Prix" placeholder="Entrer le prix du Pack" value="{{ $pack->price[$i] }}" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-dollar-sign text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input name="spots_number[]" type="number" label-class="text-lightblue" label="Nb de Spots" placeholder="Entrer le nombre de spots" value="{{ $pack->spots_number[$i] }}" required min="0">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-users text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <div class="form-group">
        <div class="custom-control custom-checkbox">
            <input type="hidden" name="availability[{{ $i }}]" value="0">
            <input class="custom-control-input" type="checkbox" id="availability{{ $i }}" name="availability[{{ $i }}]" value="1" {{ $pack->availability[$i] ? 'checked' : '' }}>
            <label for="availability{{ $i }}" class="custom-control-label">Disponibilité</label>
        </div>
    </div>

            </div>
        </details>
    @endfor
  
</div>
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
                    <option value="{{ $day }}" {{ in_array($day, $packDaysOfWeek) ? 'selected' : '' }}>{{ $day }}</option>
                @endforeach 
                </x-adminlte-select-bs>

                <x-adminlte-select-bs id="times_of_day" name="times_of_day[]" label="Horaires" label-class="text-lightblue" :config="$config2" multiple required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-clock text-lightblue"></i>
                        </div>
                    </x-slot>
                    @foreach($timesOfDay as $time)
                    <option value="{{ $time }}" {{ in_array($time, $packTimesOfDay) ? 'selected' : '' }}>{{ $time }}</option>
                    @endforeach 
                </x-adminlte-select-bs>
 
             

                

                <div class="d-flex justify-content-end">
                    <x-adminlte-button class="mr-2" type="submit" theme="success" icon="fas fa-lg fa-save" label="Enregistrer"/>
                </div>
            </form>
        </x-adminlte-card>
    </div>
    </div> 
@stop


@section('js')
    <script>
        let variationCount = {!! $nVariations !!};
        
        function addVariation() {
            variationCount++;
            const html = `
            <details class="mb-4">
                    <summary class="btn btn-dark">
                        <span>Variation ${variationCount}</span>
                    </summary> 

                    <div>
                        <x-adminlte-input name="period[]" type="number" label-class="text-lightblue" label="Period" placeholder="Enter the period of the Pack" required min="1" max="8">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar-alt text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="price[]" type="number" label-class="text-lightblue" label="Prix" placeholder="Entrer le prix du Pack" required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-dollar-sign text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>

                        <x-adminlte-input name="spots_number[]" type="number" label-class="text-lightblue" label="Nb de Spots" placeholder="Entrer le nombre de spots" required min="0">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-users text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>


                        <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="hidden" id="availabilityHidden${variationCount}" name="availability[]" value="0">
                            <input class="custom-control-input" type="checkbox" id="availability${variationCount}" onchange="checkboxChanged(this, ${variationCount})">
                            <label for="availability${variationCount}" class="custom-control-label">Disponibilité</label>
                        </div>
                    </div>

                </div>
            </details>
            `;
                    let newHtml = html.replace(/{{ $i }}/g, variationCount)
                                .replace(/value="default value"/g, '');

                document.getElementById('variations-container').insertAdjacentHTML('beforeend', newHtml);
            }

            function checkboxChanged(checkbox, count) {
                if (checkbox.checked) {
                    checkbox.value = '1';
                    checkbox.name = 'availability[]';
                    document.getElementById('availabilityHidden' + count).name = '';
                } else {
                    checkbox.value = '';
                    checkbox.name = '';
                    document.getElementById('availabilityHidden' + count).name = 'availability[]';
                }
            }

            document.getElementById('add-variation-btn').addEventListener('click', addVariation);
        </script>
@stop


