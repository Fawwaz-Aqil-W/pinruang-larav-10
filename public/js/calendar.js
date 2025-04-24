function initializeCalendar(ruanganId) {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        locale: 'id',
        weekends: true,
        slotMinTime: '00:00:00',
        slotMaxTime: '24:00:00',
        height: 450, // Lebih kecil dan responsive
        scrollTime: '07:00:00',
        allDaySlot: false,
        slotDuration: '01:00:00',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: `/ruangan/schedule/${ruanganId}`,
        nowIndicator: true,
        slotEventOverlap: false,
        eventDidMount: function(info) {
            info.el.setAttribute('data-status', info.event.extendedProps.status);
        }
    });
    calendar.render();
}