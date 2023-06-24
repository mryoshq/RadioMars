@extends('adminlte::page')

@section('title', 'Payments')

@section('content_header')

    <x-adminlte-card theme="dark" theme-mode="outline">
    <h1>Paiements</h1>
    </x-adminlte-card>
@stop
 


@section('content')
@php
    $heads = [
        'ID',
        'Méthode', 
        'Status', 
        'Propriétaire',
        'ID - Pub',
        'Ad Status', // Changed "Active" to "Ad Status"
        ['label' => 'Actions', 'no-export' => true],
    ];

    $paymentsArray = [];

    foreach ($payments as $payment) {
    $adStatusTag = '';
    $paymentStatusTag = '';
    $userName = isset($payment->ad->advertiser) ? $payment->ad->advertiser->user->name.' - '.$payment->ad->advertiser->id : 'No User';

    if(isset($payment->ad)) {
        switch ($payment->ad->status) {
            case 'active':
                $adStatusTag = "<span class='badge bg-success' style='color: white;'>Activée</span>";
                break;
            case 'paused':
                $adStatusTag = "<span class='badge bg-warning' style='color: white;'>En pause</span>";
                break;
            case 'not_active':
                $adStatusTag = "<span class='badge bg-secondary' style='color: white;'>Désactivée</span>";
                break;
            default:
                $adStatusTag = "<span class='badge bg-dark' style='color: white;'>No ad</span>";
                break;
        }

        if($payment->ad->trashed()) {
            $adStatusTag .= " <span class='badge bg-danger' style='color: white;'>Deleted</span>";
        }
    }

    switch ($payment->status) {
        case 'paid':
            $paymentStatusTag = "<span class='badge bg-success' style='color: white;'>Payé</span>";
            break;
        case 'failed':
            $paymentStatusTag = "<span class='badge bg-danger' style='color: white;'>Échoué</span>";
            break;
        case 'pending':
            $paymentStatusTag = "<span class='badge bg-warning' style='color: white;'>En attente</span>";
            break;
    }

 $btnEdit = "<a href='".route('web.payments.edit', ['payment' => $payment->id, 'page' => request()->get('page')])."' class='btn btn-xs btn-default text-primary mx-1 shadow' title='Edit'>
                    <i class='fa fa-lg fa-fw fa-pen'></i>
                </a>";

    $btnDelete = "<form action='".route('web.payments.destroy', $payment)."' method='POST' style='display:inline'>
                    ".method_field('DELETE').csrf_field()."
                    <button type='submit' class='btn btn-xs btn-default text-danger mx-1 shadow' title='Delete'>
                        <i class='fa fa-lg fa-fw fa-trash'></i>
                    </button>
                  </form>";

    switch ($payment->payment_method) {
        case 'cc':
            $paymentMethod = 'Carte de credit';
            break;

        case 'wire' :
            $paymentMethod = 'Virment';
            break;
        case 'transfer' :
            $paymentMethod = 'Wafa Cash';
            break;

    }

    $paymentsArray[] = [$payment->id, $paymentMethod, $paymentStatusTag, $userName, $payment->ad_id, $adStatusTag, $btnEdit.$btnDelete];
}

    $config = [
        'data' => $paymentsArray,
        'order' => [[0, 'asc']],
        'columns' => [ null, null, null, null, null, null, ['orderable' => false]],
        'pageLength' => 15,
        'responsive' => true,
        'autoWidth' => false,
        'stateSave' => true,
    ];
@endphp

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    @if(session('deleted'))
        <div class="alert alert-danger">
            {{ session('deleted') }}
        </div>
    @endif


    <div class="mb-4" style="text-align: right;">
    <a href="{{ route('web.payments.create') }}" class="btn btn-primary">
        Create payment
    </a>
</div>


    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="dark" :config="$config" beautify striped hoverable bordered compressed/>
@stop
 

@section('js')
  <script>
        $(document).ready(function() {
            // Automatically hide the success and deleted messages after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 5000);
        });
    </script>
@stop