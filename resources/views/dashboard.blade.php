@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <x-adminlte-card theme="dark" theme-mode="outline">
        <h1>Tableau de bord</h1>
    </x-adminlte-card>
 
@stop 
 
@section('content')
    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <x-adminlte-small-box :title="$newUsersCount" theme="teal" url="users" url-text="Voir la liste des clients"  id="sbUpdatable" text="Nouveau clients" icon="fas fa-lg fa-user-plus"/>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <x-adminlte-small-box :title="$pausedAdsCount" theme="primary" url="ads" url-text="Voir la liste des pubs" text="Publicités en pause" icon="fas fa-pause-circle"/>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <x-adminlte-small-box :title="$totalPaidPayments" theme="danger" url="payments" url-text="Voir la liste des paiements" id="sbUpdatable" text="Fonds collectés" icon="fas fa-money-bill-wave"/>
        </div>
    </div>

    


    <div class="row">
    <div class="col-md-10">
        <x-adminlte-card title="publicités" theme="dark" icon="fas fa-lg fa-moon">
            <canvas id="Chart2"></canvas>
        </x-adminlte-card>
    </div>
    <div class="col-md-2 d-flex align-items-stretch">
        <x-adminlte-card title="Payé" theme="dark" icon="fas fa-lg fa-moon" style="width: 100%;">
            <div class="d-flex flex-column justify-content-center " style="width: 100%; height: 100%;">
                @foreach ($packs2 as $pack)
                    <span>{{$pack-> name }}{{ $pack->pack_variation }}</span>
                    <x-adminlte-progress  theme="success" value="{{ $pack->confirmation_rate }}"  animated with-label/>
                @endforeach
            </div>
        </x-adminlte-card>
    </div>
</div>



    <div class="row">    

        <div class="col-md-6"> 
            <x-adminlte-card title="Paiements" theme="dark" icon="fas fa-lg fa-moon">
            <canvas id="Chart1"></canvas>
            </x-adminlte-card>
        </div>
        <div class="col-md-6">
    <x-adminlte-card title=" Utilisateurs" theme="dark" icon="fas fa-users">
        <canvas id="userRegistrationChart"></canvas>
    </x-adminlte-card>
</div>


       
    </div>
        


 
@stop
  
@section('css')
    <style>
        .large-font {
            font-size: 2em; /* Adjust this to your desired size */
        }
    </style>
@stop
@section('js')
    <script> 
        var ctx = document.getElementById('Chart1').getContext('2d');
        var myChart = new Chart(ctx, { 
            type: 'doughnut',
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
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        } 
    });
</script>
<script>
    new Chart(document.getElementById('userRegistrationChart'), {
        type: 'line',
        data: @json($registrationChartData),
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'User Registration Over Time'
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        },
    });
</script>


    
@stop
