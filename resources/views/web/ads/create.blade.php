@extends('adminlte::page')

@section('title', 'Create Ad')

@section('content_header')
<div class="d-flex justify-content-center">
    <div class="col-md-8">
        <x-adminlte-card theme="lime" theme-mode="outline">
            <h2>Create Ad</h2>
        </x-adminlte-card>
    </div>
</div>

@stop

@section('plugins.BootstrapSelect', true)

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-md-8 col-sm-8 col-12">
            <x-adminlte-card title="Fill in the ad information" theme="dark" icon="fas fa-plus">
                <form action="{{ route('web.ads.store') }}" method="POST">
                    @csrf

                    @php
                        $config = [
                            "title" => "Select an advertiser",
                            "liveSearch" => true,
                            "liveSearchPlaceholder" => "Search",
                            "showTick" => true,
                            "actionsBox" => true,
                        ];
                        $config2 = [
                            "title" => "Select a pack",
                            "liveSearch" => true,
                            "liveSearchPlaceholder" => "Search",
                            "showTick" => true,
                            "actionsBox" => true,
                        ];
                    @endphp

                    <x-adminlte-select-bs name="advertiser_id" label="Advertiser" label-class="text-lightblue" data-placeholder="Select advertiser" required :config="$config">
                        @foreach($advertisers as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </x-adminlte-select-bs>

                    <x-adminlte-select-bs name="pack_id" id="pack_id" label="Pack" label-class="text-lightblue" data-placeholder="Select pack" required :config="$config2">
                        @foreach ($packs as $pack)
                            <option value="{{ $pack->id }}">{{ $pack->name }}</option>
                        @endforeach
                    </x-adminlte-select-bs>


                    <x-adminlte-select2 name="pack_variation" id="pack_variation" label="Pack Variation" label-class="text-lightblue" data-placeholder="Select Variation" required :config="$config">
                </x-adminlte-select2>


                    <div class="form-group">
                        <label for="text_content" class="text-lightblue">Text content</label>
                        <input type="text" name="text_content" id="text_content" class="form-control" placeholder="Enter the text of the ad">
                    </div>

                    <div class="form-group">
                        <label for="audio_content" class="text-lightblue">Audio content</label>
                        <input type="url" name="audio_content" id="audio_content" class="form-control" placeholder="Enter the URL of the audio">
                    </div>

                    <x-adminlte-select-bs name="status" label="Status" label-class="text-lightblue" data-placeholder="Select the status of the ad" required>
                        <option value="active">Active</option>
                        <option value="not_active">Not Active</option>
                        <option value="paused">Paused</option>
                    </x-adminlte-select-bs>

                    <div class="d-flex justify-content-end">
                        <x-adminlte-button class="mr-2" type="submit" theme="success" icon="fas fa-lg fa-save" label="Save"/>
                    </div>
                </form>
            </x-adminlte-card> 
        </div>
    </div>
@stop
@section('js')
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

    $('#pack_id').change(function() {
        var packId = $(this).val();
        if (packId) {
            $.ajax({ 
                url: '{{ route("web.ads.getVariations") }}',
                type: 'GET',
                data: { pack_id: packId },
                success: function(response) {
                    var variationsSelect = $('#pack_variation');
                    variationsSelect.empty();
                    $.each(response, function(index, variation) {
                        variationsSelect.append('<option value="' + variation + '">Variation ' + variation + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.log(error);
                } 
            });
        } else {
            $('#pack_variation').empty();
        } 
    });
});
</script>
@stop
