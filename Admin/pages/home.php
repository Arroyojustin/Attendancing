<div class="container-fluid p-0 m-0" id="home" style="display: none;">
  <div class="flex-container">
    
    <!-- Calendar Section -->
    <div class="calendar-container col-12 col-md-7">
        <h3 id="calendar-month"></h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Sun</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                </tr>
            </thead>
            <tbody id="calendar-body">
                <!-- Dynamic Calendar Days will be inserted here -->
            </tbody>
        </table>
    </div>

    <!-- Clock Section -->
    <div class="clock-container col-12 col-md-4">
        <h3>Current Time</h3>
        <div id="clock"></div>
        <div class="time-date" id="time-date"></div>
    </div>
  </div>
</div>

<script>
    // Function to update the current time (Clock)
    function updateClock() {
        var currentTime = new Date();
        
        // 12-hour format
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes().toString().padStart(2, '0');
        var seconds = currentTime.getSeconds().toString().padStart(2, '0');
        var ampm = hours >= 12 ? 'PM' : 'AM';
        
        // Convert to 12-hour format
        hours = hours % 12;
        hours = hours ? hours : 12; // 0 becomes 12 for 12 AM/PM
        
        var timeString = hours + ':' + minutes + ':' + seconds + ' ' + ampm;
        
        // Update clock display
        document.getElementById('clock').textContent = timeString;

        // Update date below clock
        var dateString = currentTime.toLocaleDateString('en-US', {
            weekday: 'long',
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        });

        document.getElementById('time-date').textContent = dateString;
    }

    // Function to render the current month calendar
    function renderCalendar() {
        var currentDate = new Date();
        var currentMonth = currentDate.getMonth();
        var currentYear = currentDate.getFullYear();
        var currentDay = currentDate.getDate();
        
        // Set the month and year in the header
        var monthNames = [
            "January", "February", "March", "April", "May", "June", 
            "July", "August", "September", "October", "November", "December"
        ];
        document.getElementById('calendar-month').textContent = `${monthNames[currentMonth]} ${currentYear}`;
        
        // Get the first day of the month
        var firstDay = new Date(currentYear, currentMonth, 1);
        var startingDay = firstDay.getDay();
        
        // Get the number of days in the current month
        var lastDay = new Date(currentYear, currentMonth + 1, 0);
        var totalDays = lastDay.getDate();
        
        // Generate the calendar
        var calendarBody = document.getElementById('calendar-body');
        calendarBody.innerHTML = ''; // Clear any previous content
        
        var day = 1;
        for (var row = 0; row < 5; row++) {
            var tr = document.createElement('tr');
            for (var col = 0; col < 7; col++) {
                var td = document.createElement('td');
                
                // Fill in the days of the month
                if (row === 0 && col < startingDay) {
                    td.textContent = '';
                } else if (day <= totalDays) {
                    td.textContent = day;
                    if (day === currentDay) {
                        td.classList.add('today');
                    }
                    day++;
                } else {
                    td.textContent = '';
                }
                tr.appendChild(td);
            }
            calendarBody.appendChild(tr);
        }
    }

    // Initial clock update and set interval to update every second
    updateClock();
    setInterval(updateClock, 1000);

    // Render the current month's calendar
    renderCalendar();
</script>

<style>
    .today {
        background-color: #f39c12;
        font-weight: bold;
    }
</style>
