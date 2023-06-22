@extends('adminlte::page')

@section('title', 'Create Payment')

@section('content_header')
    
    <div class="d-flex justify-content-center">
        <div class="col-md-8">
            <x-adminlte-card theme="lime" theme-mode="outline">
                <h1>Créer un nouveau paiment</h1>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-md-8 col-sm-8 col-12">
        <x-adminlte-card title="Payment Information" theme="dark" icon="fas fa-plus">
            <form action="{{ route('web.payments.store') }}" method="POST">
                @csrf

                @php
                    $config = [
                        "title" => "Select an Advertiser",
                        "liveSearch" => true,
                        "liveSearchPlaceholder" => "Search",
                        "showTick" => true,
                        "actionsBox" => true,
                    ];
                @endphp
 
                <x-adminlte-select2 name="advertiser_id" id="advertiser_id" label="Client - ID" label-class="text-lightblue" data-placeholder="Select an advertiser" required :config="$config">
                    @foreach ($advertisers as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </x-adminlte-select2>
 
                <x-adminlte-select2 name="payment_method" label="Méthode de paiement" label-class="text-lightblue" data-placeholder="Select a payment method" required>
                    <option value="cc">Carte de crédit</option>
                    <option value="transfer">Transfert bancaire </option>
                    <option value="wire">Virement</option>
                </x-adminlte-select2>

                <x-adminlte-select2 name="status" label="Status" label-class="text-lightblue" data-placeholder="Select a status" required>
                    <option value="pending">En attente</option>
                    <option value="paid">Payé</option>
                    <option value="failed">Échoué</option>
                </x-adminlte-select2> 

                <div class="d-flex justify-content-end">
                    <x-adminlte-button class="mr-2" type="submit" theme="success" icon="fas fa-lg fa-save" label="Enregistrer"/>
                </div>
            </form>
        </x-adminlte-card>
    </div>
    </div>
@endsection 

@section('js')
    <script>
        $(document).ready(function() {
            // Fetch ads based on the selected advertiser
            $('#advertiser_id').on('change', function() {
                var advertiserId = $(this).val();
               
                if (advertiserId) {
                     
                    $.ajax({ 
                        url: '{{ route("web.payments.getAds") }}',
                        type: 'GET',
                        data: { advertiser_id: advertiserId },
                        success: function(response) {
                            var adsSelect = $('#ad_id');
                            adsSelect.empty();
                            $.each(response, function(id, name) {
                                adsSelect.append('<option value="' + id + '">' + name + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        } 
                    });
                } else {
                    $('#ad_id').empty();              
                } 
            });
        });
    </script>
@endsection

