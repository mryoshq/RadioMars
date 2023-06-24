@extends('adminlte::page')

@section('title', 'Recommendations')

@section('content_header')
    <x-adminlte-card theme="dark" theme-mode="outline">
    <h1>Recommendations</h1>
    </x-adminlte-card>

@stop
 
@section('content') 

<x-adminlte-card theme-mode="outline">
<div class="d-flex justify-content-center">   
<div class="col-md-10" >
   
       @if(isset($recommendations) && count($recommendations) > 0)
            <ul>    
            @foreach ($recommendations as $recommendation)
                    
                <x-adminlte-alert class="bg-yellow text-uppercase"  dismissable>
                {{ $recommendation }}
                </x-adminlte-alert>
                    @endforeach
            </ul>
        @endif
      
    </div>
    </div>
</x-adminlte-card>

@stop
  
