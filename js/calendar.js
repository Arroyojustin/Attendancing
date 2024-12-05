const calendarGrid = document.querySelector('.calendar-grid');
const currentMonthDisplay = document.getElementById('current-month');
const prevMonthButton = document.getElementById('prev-month');
const nextMonthButton = document.getElementById('next-month');

let date = new Date();

function renderCalendar() {
    const year = date.getFullYear();
    const month = date.getMonth();
    const firstDayOfMonth = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
  
    const monthNamesShort = [
        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
      ];
    
      currentMonthDisplay.textContent = `${monthNamesShort[month]} ${year}`; // Use short month names
    
      calendarGrid.innerHTML = `
      <div class="header">Sun</div>
      <div class="header">Mon</div>
      <div class="header">Tue</div>
      <div class="header">Wed</div>
      <div class="header">Thu</div>
      <div class="header">Fri</div>
      <div class="header">Sat</div>
    `;
  
    for (let i = 0; i < firstDayOfMonth; i++) {
        calendarGrid.innerHTML += `<div></div>`;
      }
  
      for (let day = 1; day <= daysInMonth; day++) {
        const dayElement = document.createElement('div');
        dayElement.textContent = day;
        dayElement.classList.add('day');
        dayElement.addEventListener('click', () => {
          document.querySelectorAll('.day').forEach(el => el.classList.remove('selected'));
          dayElement.classList.add('selected');
        });
        calendarGrid.appendChild(dayElement);
      }
    }
  

prevMonthButton.addEventListener('click', () => {
  date.setMonth(date.getMonth() - 1);
  renderCalendar();
});

nextMonthButton.addEventListener('click', () => {
  date.setMonth(date.getMonth() + 1);
  renderCalendar();
});

renderCalendar();
