<x-filament-panels::page>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.11/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.11/locales-all.global.min.js"></script>

    <div
        wire:ignore
        x-data="{
            init() {
                let calendar = new FullCalendar.Calendar(this.$refs.calendar, {
                    initialView: 'dayGridMonth',
                    locale: 'es',
                    height: 'auto',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,listWeek',
                    },
                    events: @js($events),
                    eventClick: function (info) {
                        if (info.event.url) {
                            info.jsEvent.preventDefault();
                            window.location.href = info.event.url;
                        }
                    },
                });
                calendar.render();
            }
        }"
    >
        <div x-ref="calendar"></div>
    </div>
</x-filament-panels::page>