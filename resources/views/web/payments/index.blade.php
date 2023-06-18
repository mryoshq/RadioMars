@extends('adminlte::page')

@section('title', 'Payments')

@section('content_header')

    <x-adminlte-card theme="lime" theme-mode="outline">
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
            'Publicité',
            ['label' => 'Actions', 'no-export' => true],
        ];

        $paymentsArray = [];

        foreach ($payments as $payment) {
            $btnEdit = "<a href='".route('web.payments.edit', $payment)."' class='btn btn-xs btn-default text-primary mx-1 shadow' title='Edit'>
                            <i class='fa fa-lg fa-fw fa-pen'></i>
                        </a>";
            $btnDetails = "<a href='".route('web.payments.show', $payment)."' class='btn btn-xs btn-default text-teal mx-1 shadow' title='Details'>
                            <i class='fa fa-lg fa-fw fa-eye'></i>
                        </a>";
            $btnDelete = "<form action='".route('web.payments.destroy', $payment)."' method='POST' style='display:inline'>
                            ".method_field('DELETE').csrf_field()."
                            <button type='submit' class='btn btn-xs btn-default text-danger mx-1 shadow' title='Delete'>
                                <i class='fa fa-lg fa-fw fa-trash'></i>
                            </button>
                          </form>";
          
            $paymentsArray[] = [$payment->id, $payment->payment_method, $payment->status,$payment-> advertiser_id,$payment->ad_id, $btnEdit.$btnDetails.$btnDelete];
        }

        $config = [
            'data' => $paymentsArray,
            'order' => [[0, 'asc']],
            'columns' => [ null, null, null, null,null, ['orderable' => false]],
            'pageLength' => 15,
            'responsive' => true,
            'autoWidth' => false,
          
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