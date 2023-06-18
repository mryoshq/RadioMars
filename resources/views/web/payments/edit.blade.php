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
<x-adminlte-input name="advertiser_id" id="advertiser_id" label="Client - ID" label-class="text-lightblue" :value="$payment->advertiser_id" readonly>
  <x-slot name="appendSlot">
        <div class="input-group-text">
            <button class="btn btn-sm" type="button" id="editAdvertiserBtn" style="background: none; padding: 0;">
                <i class="fas fa-edit text-lightblue"></i>
            </button>
        </div>
    </x-slot>
</x-adminlte-input>

<!-- ID de la pub field -->
<x-adminlte-input name="ad_id" id="ad_id" label="ID de la pub" label-class="text-lightblue" :value="$payment->ad_id" readonly>
    <x-slot name="appendSlot">
        <div class="input-group-text">
            <button class="btn btn-sm" type="button" id="editAdBtn" style="background: none; padding: 0;">
                <i class="fas fa-edit text-lightblue"></i>
            </button>
        </div>
    </x-slot>
</x-adminlte-input>

<!-- Hidden fields -->
<input type="hidden" name="advertiser_id_disabled" id="advertiser_id_disabled" :value="!$payment->ad ? 'true' : ''">
<input type="hidden" name="ad_id_disabled" id="ad_id_disabled" :value="!$payment->ad_id ? 'true' : ''">

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
    <script>
        $(document).ready(function() {
            $('#editAdvertiserBtn').click(function() {
                let input = $('#advertiser_id');
                let hiddenInput = $('#advertiser_id_disabled');
                if (input.attr('readonly')) {
                    input.removeAttr('readonly');
                    hiddenInput.val('false');
                    $(this).children('i').removeClass('fa-edit').addClass('fa-save');
                } else {
                    input.attr('readonly', true);
                    hiddenInput.val('true');
                    $(this).children('i').removeClass('fa-save').addClass('fa-edit');
                }
            });

            $('#editAdBtn').click(function() {
                let input = $('#ad_id');
                let hiddenInput = $('#ad_id_disabled');
                if (input.attr('readonly')) {
                    input.removeAttr('readonly');
                    hiddenInput.val('false');
                    $(this).children('i').removeClass('fa-edit').addClass('fa-save');
                } else {
                    input.attr('readonly', true);
                    hiddenInput.val('true');
                    $(this).children('i').removeClass('fa-save').addClass('fa-edit');
                }
            });
        });
    </script>
@endsection
