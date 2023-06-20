@extends('adminlte::page')

@section('title', 'Ads')

@section('content_header')
    <x-adminlte-card theme="dark" theme-mode="outline">
    <h1>Publicités </h1>
    </x-adminlte-card>
@stop




@section('content') 
    @php 
        $heads = [
            'ID',
             
             'Texte', 
             'Audio',
             'Status',
             'Pack - ID', 
             'Propriétaire - ID',
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        $adsArray = [];

        foreach ($ads as $ad) {
            $btnEdit = "<a href='".route('web.ads.edit', $ad)."' class='btn btn-xs btn-default text-primary mx-1 shadow' title='Edit'>
                            <i class='fa fa-lg fa-fw fa-pen'></i>
                        </a>";
   
            $btnDelete = "<form action='".route('web.ads.destroy', $ad)."' method='POST' style='display:inline'>
                            ".method_field('DELETE').csrf_field()."
                            <button type='submit' class='btn btn-xs btn-default text-danger mx-1 shadow' title='Delete'>
                                <i class='fa fa-lg fa-fw fa-trash'></i>
                            </button>
                          </form>";

            $status = $ad->status; 

            $statusTag = '';

            if ($status == 'active') {
                $statusTag = "<span class='badge bg-success' style='color: white;'>Activée</span>";
            } elseif ($status == 'paused') {
                $statusTag = "<span class='badge bg-warning' style='color: white;'>En pause</span>";
            } elseif ($status == 'not_active') {
                $statusTag = "<span class='badge bg-secondary' style='color: white;'>Désactivée</span>";
            }

            $pack = $ad->pack ? $ad->pack->name . ' - ' . $ad->pack->id : 'N/A';
            $owner = $ad->advertiser && $ad->advertiser->user ? $ad->advertiser->user->name . ' - ' . $ad->advertiser->id : 'N/A';
 
          
            $adsArray[] = [$ad->id, $ad->text_content, $ad->audio_content, $statusTag, $pack, $owner, $btnEdit.$btnDelete];
     }

        $config = [
            'data' => $adsArray,
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null, null, null, ['orderable' => false]],
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
    <a href="{{ route('web.ads.create') }}" class="btn btn-primary">
        Create ad
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