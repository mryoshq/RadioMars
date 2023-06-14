@extends('adminlte::page')

@section('title', 'Advertisers')

@section('content_header')
    <h1>Advertisers</h1>
@stop

@section('content')
    @php
        $heads = [
            'ID', 
            'Nom & prénom',
            'Email',
            'numéro', 
            'firm',
            'domain',
            'user_id',
            ['label' => 'Actions', 'no-export' => true],
        ];

        $advertisersArray = [];

        foreach ($advertisers as $advertiser) {
            $btnEdit = "<a href='".route('advertisers.edit', $advertiser)."' class='btn btn-xs btn-default text-primary mx-1 shadow' title='Edit'>
                            <i class='fa fa-lg fa-fw fa-pen'></i>
                        </a>";
            $btnDetails = "<a href='".route('advertisers.show', $advertiser)."' class='btn btn-xs btn-default text-teal mx-1 shadow' title='Details'>
                            <i class='fa fa-lg fa-fw fa-eye'></i>
                        </a>";
            $btnDelete = "<form action='".route('advertisers.destroy', $advertiser)."' method='POST' style='display:inline'>
                            ".method_field('DELETE').csrf_field()."
                            <button type='submit' class='btn btn-xs btn-default text-danger mx-1 shadow' title='Delete'>
                                <i class='fa fa-lg fa-fw fa-trash'></i>
                            </button>
                          </form>";
          
            $user = $advertiser->user;
            $advertisersArray[] = [$advertiser->id, $user->name, $user->email, $user->phone_number,  $advertiser->firm, $advertiser->domain,$user->id, $btnEdit.$btnDetails.$btnDelete];
        }

        $config = [
            'data' => $advertisersArray,
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null, null,null, null, ['orderable' => false]],
            'pageLength' => 15,
            'responsive' => true,
            'autoWidth' => false,
          
        ];
    @endphp

    <div class="mb-4" style="text-align: right;">
        <a href="{{ route('advertisers.create') }}" class="btn btn-primary">
            Create User
        </a>
    </div>


    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="dark" :config="$config" beautify striped hoverable bordered compressed/>
@stop
