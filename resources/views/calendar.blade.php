@extends('adminlte::page')

@section('title', 'recommendations') 

@section('content')
<x-adminlte-card theme-mode="outline">
    <div id='calendar'></div>
</x-adminlte-card>
@stop

@section('plugins.fullcalendar', true) 
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var ads = @json($ads); // Fetch the ads data from Laravel

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                themeSystem: 'bootstrap',
                locale: 'fr',
                dayMaxEvents: 3, // Set maximum events per day
                events: ads, // Pass the ads data to FullCalendar
                eventColor: function(arg) { // Set color based on pack id
                    return arg.event.extendedProps.color;
                },
                eventContent: function(arg) { // Render custom event content
                    var content = document.createElement('div');
                    content.innerHTML = 'Pub : ' + '<b>' + arg.event.title + '</b>' + '<br/>' +
                                        arg.event.extendedProps.packName + ' : ' + arg.event.extendedProps.variation + ' weeks';
                    return { html: content.outerHTML };
                }
            });

            calendar.render();

            setTimeout(function() {
                calendar.updateSize();
            }, 300);
        });
    </script>
@endsection
