@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Tableau de bord</h1>
@stop

@section('content')
    <div class="row">
    
        <div class="col-md-4 col-sm-6 col-12"><x-adminlte-small-box title="Utilisteurs" theme="teal" url="#" url-text="View details"  id="sbUpdatable" text="Nouveaux utilisteurs" icon="fas fa-star"/></div>
        <div class="col-md-4 col-sm-6 col-12"><x-adminlte-small-box title="Publicités" theme="primary" url="#" url-text="ads list " text="en attente de confirmation" icon="fas fa-star"/></div>
        <div class="col-md-4 col-sm-6 col-12"><x-adminlte-small-box title="Paiments" theme="danger" url="#" url-text="Payments history" id="sbUpdatable" text="fonds collectés" icon="fas fa-star"/></div>
    
    </div>

    <div class="row">
    <div class="col-md-6">
        <x-adminlte-card title="Paiements" theme="dark" icon="fas fa-lg fa-moon">
        <canvas id="Chart1"></canvas>
        </x-adminlte-card>
    </div>
    <div class="col-md-6">
        <x-adminlte-card title="publicités" theme="dark" icon="fas fa-lg fa-moon">
        <canvas id="Chart2"></canvas>
        </x-adminlte-card>
    </div>

    </div>
 
 
@stop
  
 
@section('js')
    <script> 
        var ctx = document.getElementById('Chart1').getContext('2d');
        var myChart = new Chart(ctx, { 
            type: 'pie',
            data: @json($chartData2),
            options: {
                
            } 
        });
    </script>
    <script> 
        var ctx = document.getElementById('Chart2').getContext('2d');
        var myChart = new Chart(ctx, { 
            type: 'bar',
            data: @json($chartData),
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
