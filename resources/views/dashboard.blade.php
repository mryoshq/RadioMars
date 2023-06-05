@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="col-md-10">
        <x-adminlte-card title="Dark Card" theme="dark" icon="fas fa-lg fa-moon">
        <canvas id="myChart"></canvas>
        </x-adminlte-card>
    </div>

    

    <x-adminlte-card title="Dark Card" theme="dark" icon="fas fa-lg fa-moon">
        <canvas id="myChart"></canvas>
    </x-adminlte-card>


@stop


@section('js')
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: @json($data),
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@stop
