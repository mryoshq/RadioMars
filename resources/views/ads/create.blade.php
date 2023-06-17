@extends('adminlte::page')

@section('title', 'Create Ad')

@section('content_header')
    <h1>Créer une publicité</h1>
@stop

@section('plugins.BootstrapSelect', true)
 
@section('content')
    <div class="d-flex justify-content-center">
    <div class="col-md-6 col-sm-8 col-12">
        <x-adminlte-card title="Remplir les informations de la publicité" theme="dark" icon="fas fa-plus">
            <form action="{{ route('ads.store') }}" method="POST">
                @csrf

                @php
                    $config = [
                        "title" => "Sélectionner un Pack",
                        "liveSearch" => true,
                        "liveSearchPlaceholder" => "Chercher",
                        "showTick" => true,
                        "actionsBox" => true,
                    ];
                    $config2 = [
                        "title" => "Sélectionner un client",
                        "liveSearch" => true,
                        "liveSearchPlaceholder" => "Chercher",
                        "showTick" => true,
                        "actionsBox" => true,
                    ];
                @endphp

                <x-adminlte-select-bs name="advertiser_id" label="Client" label-class="text-lightblue" data-placeholder="Select advertiser" required :config="$config2">
                    @foreach($advertisers as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </x-adminlte-select-bs>

                <x-adminlte-select-bs name="pack_id" label="Pack" label-class="text-lightblue" data-placeholder="Select pack" required :config="$config">
                    @foreach ($packs as $pack)
                        <option value="{{ $pack->id }}">{{ $pack->name }}</option>
                    @endforeach
                </x-adminlte-select-bs>

                <div class="form-group">
                    <label for="text_content" class="text-lightblue">Contenu Textuel</label>
                    <input type="text" name="text_content" id="text_content" class="form-control" placeholder="Entrer le texte de la pub">
                </div>

                <div class="form-group">
                    <label for="audio_content" class="text-lightblue">Contenu Audio</label>
                    <input type="url" name="audio_content" id="audio_content" class="form-control" placeholder="Entrer l'url de l'audio">
                </div>

                <x-adminlte-select-bs name="status" label="Status" label-class="text-lightblue" data-placeholder="Selectionner le status de la pub" required>
                    <option value="active">Activée</option>
                    <option value="not_active">Non Activée</option>
                    <option value="paused">En pause</option>
                </x-adminlte-select-bs>

                <div class="d-flex justify-content-end">
                    <x-adminlte-button class="mr-2" type="submit" theme="success" icon="fas fa-lg fa-save" label="Save"/>
                </div>
            </form>
        </x-adminlte-card>
    </div>
    </div>
@stop

@push('js')
<script>
    $(document).ready(function() {
        // Disable audio_content if text_content is filled
        $('#text_content').on('input', function() {
            if ($(this).val().trim() !== '') {
                $('#audio_content').prop('disabled', true);
            } else {
                $('#audio_content').prop('disabled', false);
            }
        });

        // Disable text_content if audio_content is filled
        $('#audio_content').on('input', function() {
            if ($(this).val().trim() !== '') {
                $('#text_content').prop('disabled', true);
            } else {
                $('#text_content').prop('disabled', false);
            }
        });
    });
</script>
@endpush
