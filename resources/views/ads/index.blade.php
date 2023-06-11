@extends('adminlte::page')

@section('title', 'Ads')

@section('content_header')
    <h1>Publicités</h1>
@stop




@section('content') 
    @php 
        $heads = [
            'ID',
            'campaign_id',
             'pack_id', 
             'text_content', 
             'audio_content',
             'status',
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        $adsArray = [];

        foreach ($ads as $ad) {
            $btnEdit = "<a href='".route('ads.edit', $ad)."' class='btn btn-xs btn-default text-primary mx-1 shadow' title='Edit'>
                            <i class='fa fa-lg fa-fw fa-pen'></i>
                        </a>";
            $btnDetails = "<a href='".route('ads.show', $ad)."' class='btn btn-xs btn-default text-teal mx-1 shadow' title='Details'>
                            <i class='fa fa-lg fa-fw fa-eye'></i>
                        </a>";
            $btnDelete = "<form action='".route('ads.destroy', $ad)."' method='POST' style='display:inline'>
                            ".method_field('DELETE').csrf_field()."
                            <button type='submit' class='btn btn-xs btn-default text-danger mx-1 shadow' title='Delete'>
                                <i class='fa fa-lg fa-fw fa-trash'></i>
                            </button>
                          </form>";
          
            $adsArray[] = [$ad->id, $ad->campaign_id, $ad->pack_id, $ad->text_content, $ad->audio_content, $ad->status,  $btnEdit.$btnDetails.$btnDelete];
        }

        $config = [
            'data' => $adsArray,
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null, null, null, ['orderable' => false]],
            'pageLength' => 15,
            'responsive' => true,
            'autoWidth' => false,
          
        ];
    @endphp

    <div class="mb-4" style="text-align: right;">
    <a href="{{ route('ads.create') }}" class="btn btn-primary">
        Create ad
    </a>
</div>


    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="dark" :config="$config" beautify striped hoverable bordered compressed/>
@stop
