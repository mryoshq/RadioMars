@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>Utilisateurs</h1>
@stop

@section('content')
    @php
        $heads = [
            'ID',
            'Nom & prénom',
            'Email',
            'numéro',
            'rôle',
            ['label' => 'Actions', 'no-export' => true],
        ];

        $usersArray = [];

        foreach ($users as $user) {
            $btnEdit = "<a href='".route('users.edit', $user)."' class='btn btn-xs btn-default text-primary mx-1 shadow' title='Edit'>
                            <i class='fa fa-lg fa-fw fa-pen'></i>
                        </a>";
            $btnDetails = "<a href='".route('users.show', $user)."' class='btn btn-xs btn-default text-teal mx-1 shadow' title='Details'>
                            <i class='fa fa-lg fa-fw fa-eye'></i>
                        </a>";
            $btnDelete = "<form action='".route('users.destroy', $user)."' method='POST' style='display:inline'>
                            ".method_field('DELETE').csrf_field()."
                            <button type='submit' class='btn btn-xs btn-default text-danger mx-1 shadow' title='Delete'>
                                <i class='fa fa-lg fa-fw fa-trash'></i>
                            </button>
                          </form>";
          
            $usersArray[] = [$user->id, $user->name, $user->email, $user->phone_number, $user->role_id, $btnEdit.$btnDetails.$btnDelete];
        }

        $config = [
            'data' => $usersArray,
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null, null, ['orderable' => false]],
            'pageLength' => 15,
            'responsive' => true,
            'autoWidth' => false,
          
        ];
    @endphp

    <div class="mb-4" style="text-align: right;">
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            Create User
        </a>
    </div>


    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="dark" :config="$config" beautify striped hoverable bordered compressed/>
@stop
