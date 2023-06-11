@extends('adminlte::page')

@section('title', 'Payments')

@section('content_header')
    <h1>Paiements</h1>
@stop



@section('content')
    @php
        $heads = [
            'ID',
            'user_id',
            'reservation_id', 
            'amount',
            'payment_method', 
            'status',
            ['label' => 'Actions', 'no-export' => true],
        ];

        $paymentsArray = [];

        foreach ($payments as $payment) {
            $btnEdit = "<a href='".route('payments.edit', $payment)."' class='btn btn-xs btn-default text-primary mx-1 shadow' title='Edit'>
                            <i class='fa fa-lg fa-fw fa-pen'></i>
                        </a>";
            $btnDetails = "<a href='".route('payments.show', $payment)."' class='btn btn-xs btn-default text-teal mx-1 shadow' title='Details'>
                            <i class='fa fa-lg fa-fw fa-eye'></i>
                        </a>";
            $btnDelete = "<form action='".route('payments.destroy', $payment)."' method='POST' style='display:inline'>
                            ".method_field('DELETE').csrf_field()."
                            <button type='submit' class='btn btn-xs btn-default text-danger mx-1 shadow' title='Delete'>
                                <i class='fa fa-lg fa-fw fa-trash'></i>
                            </button>
                          </form>";
          
            $paymentsArray[] = [$payment->id, $payment->user_id, $payment->reservation_id, $payment->amount, $payment->payment_method, $payment->status, $btnEdit.$btnDetails.$btnDelete];
        }

        $config = [
            'data' => $paymentsArray,
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null, null,null, ['orderable' => false]],
            'pageLength' => 15,
            'responsive' => true,
            'autoWidth' => false,
          
        ];
    @endphp

    <div class="mb-4" style="text-align: right;">
    <a href="{{ route('payments.create') }}" class="btn btn-primary">
        Create payment
    </a>
</div>


    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="dark" :config="$config" beautify striped hoverable bordered compressed/>
@stop
