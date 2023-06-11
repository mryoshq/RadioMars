@extends('adminlte::page')

@section('title', 'Create Payment')

@section('content_header')
    <h1>Create Payment</h1>
@stop

@section('content')
    <div class="col-md-6">
        <x-adminlte-card title="Payment Information" theme="dark" icon="fas fa-plus">
            <form action="{{ route('payments.store') }}" method="POST">
                @csrf

                <x-adminlte-select2 name="user_id" label="User" label-class="text-lightblue" data-placeholder="Select a user" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </x-adminlte-select2>

                <x-adminlte-select2 name="reservation_id" label="Reservation" label-class="text-lightblue" data-placeholder="Select a reservation">
                    <option value="">No reservation</option>
                    @foreach ($reservations as $reservation)
                        <option value="{{ $reservation->id }}">{{ $reservation->id }}</option>
                    @endforeach
                </x-adminlte-select2>

                <x-adminlte-input name="amount" type="number" label="Amount" placeholder="Enter amount" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-dollar-sign text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-select2 name="payment_method" label="Payment Method" label-class="text-lightblue" data-placeholder="Select a payment method" required>
                    <option value="cc">Credit Card</option>
                    <option value="transfer">Bank Transfer</option>
                    <option value="wire">Wire Transfer</option>
                </x-adminlte-select2>

                <x-adminlte-select2 name="status" label="Status" label-class="text-lightblue" data-placeholder="Select a status" required>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="failed">Failed</option>
                </x-adminlte-select2>

                <div class="d-flex justify-content-end">
                    <x-adminlte-button class="mr-2" type="submit" theme="success" icon="fas fa-lg fa-save" label="Save"/>
                    <x-adminlte-button href="{{ route('payments.index') }}" type="button" theme="danger" icon="fas fa-lg fa-times" label="Cancel"/>
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
