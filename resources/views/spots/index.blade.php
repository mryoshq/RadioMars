@extends('adminlte::page')

@section('title', 'Spots')

@section('content_header')
    <h1>Spots</h1>
@stop

@section('content')
    @php
        $heads = [
            'ID',
            'pack_id',
            'reservation_id', 
            'day_of_week', 
            'time_of_day', 
            'status',
            ['label' => 'Actions', 'no-export' => true],
        ];

        $spotsArray = [];
        
        foreach ($spots as $spot) {
            $btnEdit = "<a href='".route('spots.edit', $spot)."' class='btn btn-xs btn-default text-primary mx-1 shadow' title='Edit'>
                            <i class='fa fa-lg fa-fw fa-pen'></i>
                        </a>";
            $btnDetails = "<a href='".route('spots.show', $spot)."' class='btn btn-xs btn-default text-teal mx-1 shadow' title='Details'>
                            <i class='fa fa-lg fa-fw fa-eye'></i>
                        </a>";
            $btnDelete = "<form action='".route('spots.destroy', $spot)."' method='POST' style='display:inline'>
                            ".method_field('DELETE').csrf_field()."
                            <button type='submit' class='btn btn-xs btn-default text-danger mx-1 shadow' title='Delete'>
                                <i class='fa fa-lg fa-fw fa-trash'></i>
                            </button>
                          </form>";
          
            $spotsArray[] = [$spot->id, $spot->pack_id, $spot->reservation_id, $spot->day_of_week, $spot->time_of_day,$spot->status, $btnEdit.$btnDetails.$btnDelete];
        }

        $config = [
            'data' => $spotsArray,
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null, null, null,['orderable' => false]],
            'pageLength' => 15,
            'responsive' => true,
            'autoWidth' => false,
          
        ];
    @endphp

    <div class="mb-4" style="text-align: right;">
    <a href="{{ route('spots.create') }}" class="btn btn-primary">
        Create spot
    </a>
</div>


    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="dark" :config="$config" beautify striped hoverable bordered compressed/>
@stop
