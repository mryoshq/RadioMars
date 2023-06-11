@extends('adminlte::page')

@section('title', 'Campaign')

@section('content_header')
    <h1>Campagnes</h1>
@stop




@section('content') 
    @php
        $heads = [
            'ID',
            'user_id',
            'status',
            ['label' => 'Actions', 'no-export' => true],
        ];

        $campaignsArray = [];

        foreach ($campaigns as $campaign) {
            $btnEdit = "<a href='".route('campaigns.edit', $campaign)."' class='btn btn-xs btn-default text-primary mx-1 shadow' title='Edit'>
                            <i class='fa fa-lg fa-fw fa-pen'></i>
                        </a>";
            $btnDetails = "<a href='".route('campaigns.show', $campaign)."' class='btn btn-xs btn-default text-teal mx-1 shadow' title='Details'>
                            <i class='fa fa-lg fa-fw fa-eye'></i>
                        </a>";
            $btnDelete = "<form action='".route('campaigns.destroy', $campaign)."' method='POST' style='display:inline'>
                            ".method_field('DELETE').csrf_field()."
                            <button type='submit' class='btn btn-xs btn-default text-danger mx-1 shadow' title='Delete'>
                                <i class='fa fa-lg fa-fw fa-trash'></i>
                            </button>
                          </form>";
          
            $campaignsArray[] = [$campaign->id, $campaign->user_id, $campaign->status, $btnEdit.$btnDetails.$btnDelete];
        }

        $config = [
            'data' => $campaignsArray,
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, ['orderable' => false]],
            'pageLength' => 15,
            'responsive' => true,
            'autoWidth' => false,
          
        ];
    @endphp

    <div class="mb-4" style="text-align: right;">
    <a href="{{ route('campaigns.create') }}" class="btn btn-primary">
        Create campaign
    </a>
</div>


    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="dark" :config="$config" beautify striped hoverable bordered compressed/>
@stop
