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
            'Numéro',
            'Entreprise',
            'Domaine',
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
            if ($user) {
                $advertisersArray[] = [$advertiser->id, $user->name, $user->email, $user->phone_number, $advertiser->firm, $advertiser->domain, $btnEdit.$btnDetails.$btnDelete];
            } else {
                $advertisersArray[] = [$advertiser->id, '', '', '', $advertiser->firm, $advertiser->domain, $btnEdit.$btnDetails.$btnDelete];
            }
        }

        $config = [
            'data' => $advertisersArray,
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null, null, null, ['orderable' => false]],
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
        <a href="{{ route('advertisers.create') }}" class="btn btn-primary">
            Create Advertiser
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
