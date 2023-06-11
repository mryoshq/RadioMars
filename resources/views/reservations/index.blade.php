@extends('adminlte::page')

@section('title', 'Reservation')

@section('content_header')
    <h1>Reservations</h1>
@stop




@section('content') 
    @php
        $heads = [
            'ID',
            'ad_id',
            'status',
            ['label' => 'Actions', 'no-export' => true],
        ];

        $reservationsArray = [];

        foreach ($reservations as $reservation) {
            $btnEdit = "<a href='".route('reservations.edit', $reservation)."' class='btn btn-xs btn-default text-primary mx-1 shadow' title='Edit'>
                            <i class='fa fa-lg fa-fw fa-pen'></i>
                        </a>";
            $btnDetails = "<a href='".route('reservations.show', $reservation)."' class='btn btn-xs btn-default text-teal mx-1 shadow' title='Details'>
                            <i class='fa fa-lg fa-fw fa-eye'></i>
                        </a>";
            $btnDelete = "<form action='".route('reservations.destroy', $reservation)."' method='POST' style='display:inline'>
                            ".method_field('DELETE').csrf_field()."
                            <button type='submit' class='btn btn-xs btn-default text-danger mx-1 shadow' title='Delete'>
                                <i class='fa fa-lg fa-fw fa-trash'></i>
                            </button>
                          </form>";
          
            $reservationsArray[] = [$reservation->id, $reservation->ad_id, $reservation->status, $btnEdit.$btnDetails.$btnDelete];
        }

        $config = [
            'data' => $reservationsArray,
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, ['orderable' => false]],
            'pageLength' => 15,
            'responsive' => true,
            'autoWidth' => false,
          
        ];
    @endphp

    <div class="mb-4" style="text-align: right;">
    <a href="{{ route('reservations.create') }}" class="btn btn-primary">
        Create reservation
    </a>
</div>


    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="dark" :config="$config" beautify striped hoverable bordered compressed/>
@stop
