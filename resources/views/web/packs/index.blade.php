@extends('adminlte::page')

@section('title', 'Packs')

@section('content_header')
    <x-adminlte-card theme="dark" theme-mode="outline">
    <h1>Packs</h1>
    </x-adminlte-card>
@stop



@section('content')
    @php
        $heads = [
            'ID',
            'Titre', 
            'Prix', 
            'Nb Spots', 
            'Jours', 
            'Horaires', 
            'Disponibilités',  ['label' => 'Actions', 'no-export' => true , 'width' => 5],
        ];

        $packsArray = [];

        foreach ($packs as $pack) {
            $btnEdit = "<a href='".route('web.packs.edit', $pack)."' class='btn btn-xs btn-default text-primary mx-1 shadow' title='Edit'>
                            <i class='fa fa-lg fa-fw fa-pen'></i>
                        </a>";
    
            $btnDelete = "<form action='".route('web.packs.destroy', $pack)."' method='POST' style='display:inline'>
                            ".method_field('DELETE').csrf_field()."
                            <button type='submit' class='btn btn-xs btn-default text-danger mx-1 shadow' title='Delete'>
                                <i class='fa fa-lg fa-fw fa-trash'></i>
                            </button>
                          </form>";
          
            $daysOfWeekTags = '';
            foreach (explode(',', $pack->days_of_week) as $dayOfWeek) {
                $dayOfWeek = str_replace(['[', ']', '"'], '', $dayOfWeek);
                $daysOfWeekTags .= "<span class='badge bg-primary'>$dayOfWeek</span>&nbsp;";
            }

            $timesOfDayTags = '';
            foreach (explode(',', $pack->times_of_day) as $timeOfDay) {
                $timeOfDay = str_replace(['[', ']', '"'], '', $timeOfDay);
                $timesOfDayTags .= "<span class='badge bg-primary'>$timeOfDay</span>&nbsp;";
            }

            $availabilityIcon = $pack->availability ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>';





            $packsArray[] = [$pack->id, $pack->name,$pack->price,$pack->spots_number, $daysOfWeekTags,$timesOfDayTags,$availabilityIcon , $btnEdit.$btnDelete];
        }


        $config = [
            'data' => $packsArray,
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null,null,null,null, ['orderable' => false]],
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
    <a href="{{ route('web.packs.create') }}" class="btn btn-primary">
        Create pack
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