@extends('adminlte::page')

@section('title', 'Create Spot')

@section('content_header')
    <h1>Create Spot</h1>
@stop

@section('content') 
    <div class="col-md-6">
        <x-adminlte-card title="Spot Information" theme="dark" icon="fas fa-plus">
            <form action="{{ route('spots.store') }}" method="POST">
                @csrf

                <x-adminlte-select2 name="reservation_id" label="Reservation" label-class="text-lightblue" data-placeholder="Select a reservation" required>
                    @foreach ($reservations as $reservation)
                        <option value="{{ $reservation->id }}">{{ $reservation->id }}</option>
                    @endforeach
                </x-adminlte-select2>

                <x-adminlte-select2 name="pack_id" label="Pack" label-class="text-lightblue" data-placeholder="Select a pack">
                    <option value="">No pack</option>
                    @foreach ($packs as $pack)
                        <option value="{{ $pack->id }}">{{ $pack->name }}</option>
                    @endforeach
                </x-adminlte-select2>

                <x-adminlte-select2 name="time_of_day" label="Time of Day" label-class="text-lightblue" data-placeholder="Select a time" required>
                    @foreach ($packs as $pack)
                        @foreach (json_decode($pack->times_of_day) as $time)
                            <option value="{{ $time }}">{{ $time }}</option>
                        @endforeach
                    @endforeach
                </x-adminlte-select2>

                <x-adminlte-select2 name="day_of_week" label="Day of Week" label-class="text-lightblue" data-placeholder="Select a day" required>
                    @foreach ($packs as $pack)
                        @foreach (json_decode($pack->days_of_week) as $day)
                            <option value="{{ $day }}">{{ $day }}</option>
                        @endforeach
                    @endforeach
                </x-adminlte-select2>

                <x-adminlte-select2 name="status" label="Status" label-class="text-lightblue" data-placeholder="Select a status" required>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </x-adminlte-select2>

                <div class="d-flex justify-content-end">
                    <x-adminlte-button class="mr-2" type="submit" theme="success" icon="fas fa-lg fa-save" label="Save"/>
                    <x-adminlte-button href="{{ route('spots.index') }}" type="button" theme="danger" icon="fas fa-lg fa-times" label="Cancel"/>
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
