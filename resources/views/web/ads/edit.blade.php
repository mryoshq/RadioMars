@extends('adminlte::page')

@section('title', 'Edit Ad')

@section('content_header')
<div class="d-flex justify-content-center">
    <div class="col-md-8">
        <x-adminlte-card theme="lime" theme-mode="outline">
            <h1>Modifier la publicité</h1>
        </x-adminlte-card>
    </div>
</div>
@stop

@section('plugins.BootstrapSelect', true)

@section('content')
<div class="d-flex justify-content-center">
    <div class="col-md-8 col-sm-8 col-12">
        <x-adminlte-card title="Veuillez remplir Informations de cette publicité" theme="dark" icon="fas fa-plus">
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




                <div class="row">
    <div class="col-md-6">
        <x-adminlte-select-bs name="pack_id" id="pack_id" label="Pack" label-class="text-lightblue" data-placeholder="Select pack" :config="$config">
             @foreach ($packs as $id => $name)
                       
                        <option value="{{ $id }}" {{ $ad->pack_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </x-adminlte-select-bs>


                <input type="hidden" name="pack_id_disabled" id="pack_id_disabled" value="{{ empty($ad->pack_id) ? 'true' : '' }}">

                </div>
    <div class="col-md-6">

                <input type="hidden" name="pack_variation_initial" id="pack_variation_initial" value="{{ $ad->pack_variation }}">


                <x-adminlte-select2 name="pack_variation" id="pack_variation" label="Pack Variation" label-class="text-lightblue" data-placeholder="Select Variation" :config="$config">
                </x-adminlte-select2>

                <input type="hidden" name="pack_variation_disabled" id="pack_variation_disabled" value="{{ empty($ad->pack_variation) ? 'true' : '' }}">
                </div>
</div>

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

                <x-adminlte-select-bs name="status" id="status" label="Status de la Publicité" label-class="text-lightblue" data-placeholder="Select status">
 
            
        
                <option value="active" {{ old('status', $ad->status) === 'active' ? 'selected' : '' }}>Activée</option>
                <option value="not_active" {{ old('status', $ad->status) === 'not_active' ? 'selected' : '' }}>Désactivée</option>
                <option value="paused" {{ old('status', $ad->status) === 'paused' ? 'selected' : '' }}>En pause</option>
                </x-adminlte-select-bs>

                <div class="row">
                    <div class="col-md-6">
                    <!-- Decision field -->
                        <x-adminlte-select-bs name="decision" id="decision" label="Decision" label-class="text-danger" data-placeholder="Select decision">
                            <option value="accepted" {{ old('decision', $ad->decision) === 'accepted' ? 'selected' : '' }}>Acceptée</option>
                            <option value="in_queue" {{ old('decision', $ad->decision) === 'in_queue' ? 'selected' : '' }}>En attente</option>
                            <option value="rejected" {{ old('decision', $ad->decision) === 'rejected' ? 'selected' : '' }}>Rejetée</option>
                        </x-adminlte-select-bs>

                    </div>

                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="payment_status" class="text-lightblue" style="color: gold;">Statut de Paiement</label>
                        <input type="text" name="payment_status" id="payment_status" class="form-control" placeholder="Statut de Paiement" disabled value="{{ $paymentStatus }}">
                    </div>

                    </div>
               
                </div>



                <div class="row">
                    <div class="col-md-6">
                  <!-- Message field -->
                        <div class="form-group">
                            <label for="message" class="text-lightblue">Message</label>
                            <input type="text" name="message" id="message" class="form-control"  rows="3" placeholder="Enter a message" value="{{ old('message', $ad->message) }}">
                        </div>
                    </div>
                <!-- Programmed For field -->
                    <div class="col-md-6">
                    <!-- Programmed For field -->
                    <!-- Programmed For field --> 
                        <div class="form-group">
                            <label for="programmed_for" class="text-lightblue">Programmed For</label>
                            @php
                            $config3 = ['format' => 'YYYY-MM-DD'];
                            $value = old('programmed_for', $ad->programmed_for) ? (is_string($ad->programmed_for) ? Carbon\Carbon::parse($ad->programmed_for)->format('Y-m-d') : $ad->programmed_for->format('Y-m-d')) : '';
                            @endphp
                        
                            <x-adminlte-input-date name="programmed_for" id="programmed_for" :config="$config3" placeholder="Select Date" :value="$value">
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-gradient-danger">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
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
