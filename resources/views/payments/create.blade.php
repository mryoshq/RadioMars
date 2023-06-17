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

                @php
                    $config = [
                        "title" => "Select an Advertiser",
                        "liveSearch" => true,
                        "liveSearchPlaceholder" => "Search",
                        "showTick" => true,
                        "actionsBox" => true,
                    ];
                @endphp

                <x-adminlte-select2 name="advertiser_id" id="advertiser_id" label="Advertiser" label-class="text-lightblue" data-placeholder="Select an advertiser" required :config="$config">
                    @foreach ($advertisers as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </x-adminlte-select2>

                <x-adminlte-select2 name="ad_id" id="ad_id" label="Ad" label-class="text-lightblue" data-placeholder="Select an ad" required :config="$config">
                </x-adminlte-select2>

                <x-adminlte-select2 name="pack_id" label="Pack" label-class="text-lightblue" data-placeholder="Select a Pack" required :config="$config">
                    @foreach ($packs as $pack)
                        <option value="{{ $pack->id }}">{{ $pack->name }}</option>
                    @endforeach
                </x-adminlte-select2>

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
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Fetch ads based on the selected advertiser
            $('#advertiser_id').on('change', function() {
                var advertiserId = $(this).val();
               
                if (advertiserId) {
                    
                    $.ajax({
                        url: '{{ route("advertisers.getAds") }}', // Update the URL
                        type: 'GET',
                        
                        data: { advertiser_id: advertiserId },
                        success: function(response) {
                            var adsSelect = $('#ad_id');
                            adsSelect.empty();
                            $.each(response, function(id, name) {
                                adsSelect.append('<option value="' + id + '">' + name + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        } 
                    });
                } else {
                    $('#ad_id').empty();
                   
                } 
            });
        });
    </script>
@endsection

