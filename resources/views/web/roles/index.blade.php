@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <x-adminlte-card theme="dark" theme-mode="outline">
    <h1>Rôles</h1>
    </x-adminlte-card> 
@stop

@section('content')

    @php
        $heads = [
            'ID',
            'Name',
            'Permissions',
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        $rolesArray = [];

        foreach ($roles as $role) {
            $formattedPermissions = '';
            foreach ($role->permissions as $permission) {
                $formattedPermissions .= "<span class='badge bg-danger'>" . $permission . "</span>&nbsp;";
            }
          
            $btnEdit = "<a href='".route('web.roles.edit', $role)."' class='btn btn-xs btn-default text-primary mx-1 shadow' title='Edit'>
                            <i class='fa fa-lg fa-fw fa-pen'></i>
                        </a>";
            
            $btnDelete = "<form action='".route('web.roles.destroy', $role)."' method='POST' style='display:inline'>
                            ".method_field('DELETE').csrf_field()."
                            <button type='submit' class='btn btn-xs btn-default text-danger mx-1 shadow' title='Delete'>
                                <i class='fa fa-lg fa-fw fa-trash'></i>
                            </button>
                          </form>";
          
            $rolesArray[] = [$role->id, $role->name, $formattedPermissions, $btnEdit.$btnDelete];
        }

        $config = [
            'data' => $rolesArray,
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, ['orderable' => false]],
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
    <a href="{{ route('web.roles.create') }}" class="btn btn-primary">
        Create role
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
    <
@stop