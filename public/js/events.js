//calendar
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar-dates');
    var calendarHeaderEl = document.getElementById('month-year');
    var prevButton = document.getElementById('prev');
    var nextButton = document.getElementById('next');
    var currentDate = new Date();

    function renderCalendar(date) {
        calendarEl.innerHTML = '';
        var year = date.getFullYear();
        var month = date.getMonth();
        var firstDay = new Date(year, month, 1).getDay();
        var lastDate = new Date(year, month + 1, 0).getDate();

        calendarHeaderEl.innerText = `${date.toLocaleString('default', { month: 'long' })} ${year}`;

        for (let i = 0; i < firstDay; i++) {
            let emptyCell = document.createElement('div');
            emptyCell.className = 'calendar-cell empty';
            calendarEl.appendChild(emptyCell);
        }

        for (let i = 1; i <= lastDate; i++) {
            let dateCell = document.createElement('div');
            dateCell.className = 'calendar-cell';
            dateCell.innerText = i;
            calendarEl.appendChild(dateCell);
        }
    }

    renderCalendar(currentDate);

    prevButton.addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    });

    nextButton.addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });

	document.getElementById('event-form').addEventListener('submit', function(e) {
        e.preventDefault();
        var title = document.getElementById('event-title').value;
        var date = document.getElementById('event-date').value;

        // Add event to the event list
        var eventList = document.getElementById('event-list');
        var listItem = document.createElement('li');
        listItem.innerHTML = `${title} - ${date} <button class="delete-event" data-date="${date}">Delete</button>`;
        eventList.appendChild(listItem);

        // Submit form
        this.submit();
    });

    // Handle event deletion
    document.getElementById('event-list').addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-event')) {
            e.preventDefault();
            var date = e.target.getAttribute('data-date');
            // Make a request to delete the event
            fetch(`events/${date}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                if (response.ok) {
                    // Remove the event from the DOM
                    e.target.parentElement.remove();
                } else {
                    alert('Failed to delete the event.');
                }
            });
        }
    });
});
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar-dates');
    var calendarHeaderEl = document.getElementById('month-year');
    var prevButton = document.getElementById('prev');
    var nextButton = document.getElementById('next');
    var currentDate = new Date();

    function renderCalendar(date) {
        calendarEl.innerHTML = '';
        var year = date.getFullYear();
        var month = date.getMonth();
        var firstDay = new Date(year, month, 1).getDay();
        var lastDate = new Date(year, month + 1, 0).getDate();

        calendarHeaderEl.innerText = `${date.toLocaleString('default', { month: 'long' })} ${year}`;

        for (let i = 0; i < firstDay; i++) {
            let emptyCell = document.createElement('div');
            emptyCell.className = 'calendar-cell empty';
            calendarEl.appendChild(emptyCell);
        }

        for (let i = 1; i <= lastDate; i++) {
            let dateCell = document.createElement('div');
            dateCell.className = 'calendar-cell';
            dateCell.innerText = i;
            calendarEl.appendChild(dateCell);
        }
    }

    renderCalendar(currentDate);

    prevButton.addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    });

    nextButton.addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });

    // Event listener for adding events
    document.getElementById('event-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        var title = document.getElementById('event-title').value;
        var date = document.getElementById('event-date').value;

        fetch('/events', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ title: title, date: date })
        })
        .then(response => response.json())
        .then(data => {
            // Assuming data contains the newly added event information or a success message
            console.log(data); // Log response from server (for debugging)

            // Create list item to display the event
            var listItem = document.createElement('li');
            listItem.innerHTML = `${title} - ${date} <button class="delete-event" data-id="${data.id}">Delete</button>`;

            // Append list item to the event list
            var eventList = document.getElementById('event-list');
            eventList.appendChild(listItem);

            // Clear form inputs after adding event
            document.getElementById('event-title').value = '';
            document.getElementById('event-date').value = '';

            alert('Event added successfully'); // Optional: Show success message
        })
        .catch(error => {
            console.error('Error adding event:', error);
            alert('Failed to add event.');
        });
    });

    // Event delegation for deleting events
    document.getElementById('event-list').addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-event')) {
            e.preventDefault();
            var eventId = e.target.getAttribute('data-id');

            fetch(`/events/${eventId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (response.ok) {
                    // Remove the event item from the DOM
                    e.target.parentElement.remove();
                    alert('Event deleted successfully');
                } else {
                    alert('Failed to delete the event.');
                }
            })
            .catch(error => {
                console.error('Error deleting event:', error);
                alert('Failed to delete the event.');
            });
        }
    });
});
