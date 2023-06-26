@extends('adminlte::page')

@section('title', 'Edit Payment')

@section('content_header')
    <div class="d-flex justify-content-center">
        <div class="col-md-8">
            <x-adminlte-card theme="lime" theme-mode="outline">
              <h1>Modifier un paiement</h1>
            </x-adminlte-card>
        </div>
    </div>
@stop
 
@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-md-8 col-sm-8 col-12">
            <x-adminlte-card title="Payment Information" theme="dark" icon="fas fa-edit">
                <form action="{{ route('web.payments.update', $payment->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Client - ID field -->

                    @php
                    $config = [
                        "title" => "Select an Advertiser",
                        "liveSearch" => true,
                        "liveSearchPlaceholder" => "Search",
                        "showTick" => true, 
                        "actionsBox" => true,
                    ];
               
                    switch ($ad_status) {
                        case 'active':
                            $displayStatus = 'Activée';
                            break;
                        case 'not_active':
                            $displayStatus = 'Désactivée';
                            break;
                        case 'paused':
                            $displayStatus = 'En pause';
                            break;
                        default:
                            $displayStatus = 'Unknown Status';
                    }
                @endphp

                    <!-- Client - ID field --> 

                    <x-adminlte-input name="advertiser_id" label="Client - ID" label-class="text-lightblue" placeholder="Advertiser ID" disabled value="{{ old('advertiser_id', $payment->advertiser_id ?? '') }}"/>

                    <!-- Ad ID field -->
                    <x-adminlte-input name="ad_id" label="ID de la pub" label-class="text-lightblue" placeholder="Ad ID" disabled value="{{ old('ad_id', $payment->ad_id ?? '') }}"/>

                 
                    <x-adminlte-input name="ad_status" label="Status de la pub" label-class="text-lightblue" placeholder="Ad Status" disabled value="{{ old('ad_status', $displayStatus ?? '') }}"/>


                    <!-- Hidden fields -->
                    <input type="hidden" name="advertiser_id_disabled" id="advertiser_id_disabled" value="{{ old('advertiser_id_disabled', $payment->ad ? 'true' : 'false') }}">
                    <input type="hidden" name="ad_id_disabled" id="ad_id_disabled" value="{{ old('ad_id_disabled', $payment->ad_id ? 'true' : 'false') }}">


                    
                    <x-adminlte-select2 name="payment_method" label="Méthode de paiement" label-class="text-lightblue" data-placeholder="Select a payment method" required>
                        <option value="cc" {{ $payment->payment_method == 'cc' ? 'selected' : '' }}>Carte de crédit</option>
                        <option value="transfer" {{ $payment->payment_method == 'transfer' ? 'selected' : '' }}>Transfert bancaire </option>
                        <option value="wire" {{ $payment->payment_method == 'wire' ? 'selected' : '' }}>Virement</option>
                    </x-adminlte-select2>

                    <x-adminlte-select2 name="status" label="Status" label-class="text-lightblue" data-placeholder="Select a status" required>
                        <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="paid" {{ $payment->status == 'paid' ? 'selected' : '' }}>Payé</option>
                        <option value="failed" {{ $payment->status == 'failed' ? 'selected' : '' }}>Échoué</option>
                    </x-adminlte-select2> 

                    <div class="d-flex justify-content-end">
                        <x-adminlte-button class="mr-2" type="submit" theme="success" icon="fas fa-lg fa-save" label="Enregistrer"/>
                    </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@stop
@section('js')

@endsection
