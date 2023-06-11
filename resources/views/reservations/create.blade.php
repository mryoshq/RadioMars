@extends('adminlte::page')

@section('title', 'Create Reservation')

@section('content_header')
    <h1>Create Reservation</h1>
@stop

@section('content')
    <div class="col-md-6">
        <x-adminlte-card title="Reservation Information" theme="dark" icon="fas fa-plus">
            <form action="{{ route('reservations.store') }}" method="POST">
                @csrf

                <x-adminlte-select2 name="ad_id" label="Ad" label-class="text-lightblue" data-placeholder="Select an ad" required>
                    @foreach ($ads as $ad)
                        <option value="{{ $ad->id }}">{{ $ad->id }}</option>
                    @endforeach
                </x-adminlte-select2>

                <x-adminlte-select2 name="status" label="Status" label-class="text-lightblue" data-placeholder="Select a status" required>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="cancelled">Cancelled</option>
                </x-adminlte-select2>

                <div class="d-flex justify-content-end">
                    <x-adminlte-button class="mr-2" type="submit" theme="success" icon="fas fa-lg fa-save" label="Save"/>
                    <x-adminlte-button href="{{ route('reservations.index') }}" type="button" theme="danger" icon="fas fa-lg fa-times" label="Cancel"/>
                </div>
            </form>
        </x-adminlte-card>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Add any additional JavaScript logic here
        });
    </script>
@stop
