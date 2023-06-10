@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <h1>Rôles</h1>
@stop

@section('content')
    @php
        $heads = [
            'ID',
            'name',
            'permissions',
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        $rolesArray = [];

        foreach ($roles as $role) {
            $btnEdit = "<a href='".route('roles.edit', $role)."' class='btn btn-xs btn-default text-primary mx-1 shadow' title='Edit'>
                            <i class='fa fa-lg fa-fw fa-pen'></i>
                        </a>";
            $btnDetails = "<a href='".route('roles.show', $role)."' class='btn btn-xs btn-default text-teal mx-1 shadow' title='Details'>
                            <i class='fa fa-lg fa-fw fa-eye'></i>
                        </a>";
            $btnDelete = "<form action='".route('roles.destroy', $role)."' method='POST' style='display:inline'>
                            ".method_field('DELETE').csrf_field()."
                            <button type='submit' class='btn btn-xs btn-default text-danger mx-1 shadow' title='Delete'>
                                <i class='fa fa-lg fa-fw fa-trash'></i>
                            </button>
                          </form>";
          
            $rolesArray[] = [$role->id, $role->name, $role->permissions, $btnEdit.$btnDetails.$btnDelete];
        }

        $config = [
            'data' => $rolesArray,
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, ['orderable' => false]],
            'pageLength' => 15,
            'responsive' => true,
            'autoWidth' => false,
          
        ];
    @endphp

    <div class="mb-4" style="text-align: right;">
    <a href="{{ route('roles.create') }}" class="btn btn-primary">
        Create role
    </a>
</div>


    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="dark" :config="$config" beautify striped hoverable bordered compressed/>
@stop
