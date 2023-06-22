@extends('adminlte::page')

@section('title', 'Edit Ad')

@section('content_header')
<div class="d-flex justify-content-center">
    <div class="col-md-8">
        <x-adminlte-card theme="lime" theme-mode="outline">
            <h1>Modifier Publicité</h1>
        </x-adminlte-card>
    </div>
</div>
@stop

@section('plugins.BootstrapSelect', true)

@section('content')
<div class="d-flex justify-content-center">
    <div class="col-md-8 col-sm-8 col-12">
        <x-adminlte-card title="Informations de la Publicité" theme="dark" icon="fas fa-plus">
            <form action="{{ route('web.ads.update', $ad) }}" method="POST">
                @csrf
                @method('PUT')

                @php
                    $config = [
                        "title" => "Sélectionner un Pack",
                        "liveSearch" => true,
                        "liveSearchPlaceholder" => "Chercher",
                        "showTick" => true,
                        "actionsBox" => true,
                    ];
                    $configAdv = [
                        "title" => "Sélectionner un client",
                        "liveSearch" => true,
                        "liveSearchPlaceholder" => "Chercher",
                        "showTick" => true,
                        "actionsBox" => true,
                    ];
                @endphp

                <x-adminlte-select-bs name="advertiser_id" label="Advertiser"  label-class="text-lightblue" data-placeholder="Select advertiser" :config="$configAdv">
                    @foreach($advertisers as $id => $name)
                        <option value="{{ $id }}" {{ $ad->advertiser_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </x-adminlte-select-bs>

                <input type="hidden" name="advertiser_id_disabled" id="advertiser_id_disabled" value="{{ empty($ad->advertiser_id) ? 'true' : '' }}">





                <x-adminlte-select-bs name="pack_id" id="pack_id" label="Pack" label-class="text-lightblue" data-placeholder="Select pack" :config="$config">
                    @foreach ($packs as $id => $name)
                       
                        <option value="{{ $id }}" {{ $ad->pack_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </x-adminlte-select-bs>


                <input type="hidden" name="pack_id_disabled" id="pack_id_disabled" value="{{ empty($ad->pack_id) ? 'true' : '' }}">

           

                <input type="hidden" name="pack_variation_initial" id="pack_variation_initial" value="{{ $ad->pack_variation }}">


                <x-adminlte-select2 name="pack_variation" id="pack_variation" label="Pack Variation" label-class="text-lightblue" data-placeholder="Select Variation" :config="$config">
                </x-adminlte-select2>

                <input type="hidden" name="pack_variation_disabled" id="pack_variation_disabled" value="{{ empty($ad->pack_variation) ? 'true' : '' }}">


                <div class="form-group">
    <label for="text_content" class="text-lightblue">Contenu Textuel</label>
    <input type="text" name="text_content" id="text_content" class="form-control" placeholder="Entrer le texte de la pub" value="{{ $ad->text_content }}">
    <input type="hidden" id="text_content_hidden" name="text_content_hidden" value="{{ $ad->text_content }}">
</div>

<div class="form-group">
    <label for="audio_content" class="text-lightblue">Audio content</label>
    <input type="url" name="audio_content" id="audio_content" class="form-control" placeholder="Enter the URL of the audio" value="{{ $ad->audio_content }}">
    <input type="hidden" id="audio_content_hidden" name="audio_content_hidden" value="{{ $ad->audio_content }}">
</div>


<!-- Add these hidden fields -->
<input type="hidden" name="final_text_content" id="final_text_content" value="{{ $ad->text_content }}">
<input type="hidden" name="final_audio_content" id="final_audio_content" value="{{ $ad->audio_content }}">

        <select name="status" id="status">
            <option value="active" {{ old('status', $ad->status) === 'active' ? 'selected' : '' }}>Active</option>
            <option value="not_active" {{ old('status', $ad->status) === 'not_active' ? 'selected' : '' }}>Not Active</option>
            <option value="paused" {{ old('status', $ad->status) === 'paused' ? 'selected' : '' }}>Paused</option>
        </select>


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
    $('#text_content').on('input', function() {
        let text = $(this).val().trim();
        if(text !== ''){
            $('#audio_content, #audio_content_hidden').prop('disabled', true).val('');
            // When text_content is filled, we clear the audio_content's value
            $('#final_audio_content').val('');
        } else {
            $('#audio_content, #audio_content_hidden').prop('disabled', false).val('{{ $ad->audio_content }}');
        }
        // Always sync the final_text_content value with the text_content's value
        $('#final_text_content').val(text);
    });

    $('#audio_content').on('input', function() {
        let audio = $(this).val().trim();
        if(audio !== ''){
            $('#text_content, #text_content_hidden').prop('disabled', true).val('');
            // When audio_content is filled, we clear the text_content's value
            $('#final_text_content').val('');
        } else {
            $('#text_content, #text_content_hidden').prop('disabled', false).val('{{ $ad->text_content }}');
        }
        // Always sync the final_audio_content value with the audio_content's value
        $('#final_audio_content').val(audio);
    });








    // Load pack variations when page is loaded
    loadPackVariations($('#pack_id').val(), $('#pack_variation_initial').val());


    // Load pack variations when pack selection changes
    $('#pack_id').change(function() {
    loadPackVariations($(this).val(), $('#pack_variation_initial').val());
});

    // Enable/disable advertiser id select field
    var advertiserIdSelect = $('#advertiser_id');
    var advertiserIdOldValue = advertiserIdSelect.val();
    advertiserIdSelect.on('changed.bs.select', function() {
        if ($('#advertiser_id_disabled').val() == 'true') {
            $(this).val(advertiserIdOldValue);
            $(this).selectpicker('refresh');
        } else {
            advertiserIdOldValue = $(this).val();
        }
    });

    // Enable/disable pack id select field
    var packIdSelect = $('#pack_id');
    var packIdOldValue = packIdSelect.val();
    packIdSelect.on('changed.bs.select', function() {
        if ($('#pack_id_disabled').val() == 'true') {
            $(this).val(packIdOldValue);
            $(this).selectpicker('refresh');
        } else {
            packIdOldValue = $(this).val();
        }
    });

    // Enable/disable pack variation select field
    var packVariationSelect = $('#pack_variation');
    var packVariationOldValue = packVariationSelect.val();
    packVariationSelect.on('changed.bs.select', function() {
        if ($('#pack_variation_disabled').val() == 'true') {
            $(this).val(packVariationOldValue);
            $(this).selectpicker('refresh');
        } else {
            packVariationOldValue = $(this).val();
        }
    });
});

// Function to load pack variations
// Function to load pack variations
function loadPackVariations(packId, selectedVariation) {
    if (packId) {
        $.ajax({
            url: '{{ route("web.ads.getVariations") }}',
            type: 'GET',
            data: { pack_id: packId },
            success: function(response) {
                var variationsSelect = $('#pack_variation');
                variationsSelect.empty();
                $.each(response, function(id, name) {
                    console.log('id: ', id, ' type of id: ', typeof id);
                    console.log('selectedVariation: ', selectedVariation, ' type of selectedVariation: ', typeof selectedVariation);
                    var selected = (parseInt(id) + 1) == selectedVariation ? 'selected' : '';
                    variationsSelect.append('<option value="' + (parseInt(id) + 1) + '"' + selected + '>' + name + '</option>');
                });
                // Refresh selectpicker after adding new options
                variationsSelect.selectpicker('refresh');
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    } else {
        $('#pack_variation').empty();
    }


}




</script>
@stop
