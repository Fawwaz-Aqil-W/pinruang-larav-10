function initializeCalendar(ruanganId) {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        slotMinTime: '07:00:00',
        slotMaxTime: '18:00:00',
        allDaySlot: false,
        weekends: false,
        slotDuration: '01:00:00',
        expandRows: true,
        stickyHeaderDates: true,
        nowIndicator: true,
        slotEventOverlap: false,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'timeGridWeek,timeGridDay'
        },
        events: `/ruangan/schedule/${ruanganId}`, // Simplified events loading
        eventDidMount: function(info) {
            info.el.setAttribute('data-status', info.event.extendedProps.status);
        }
    });
    calendar.render();
}