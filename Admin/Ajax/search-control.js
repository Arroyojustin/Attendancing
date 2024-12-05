document.getElementById('searchBtn').addEventListener('click', function () {
    const surname = document.getElementById('surname').value;
    const studentNo = document.getElementById('studentNo').value;

    // Send AJAX request
    fetch('search_attendance.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ surname: surname, studentNo: studentNo })
    })
    .then(response => response.json())
    .then(data => {
        const attendanceTableBody = document.getElementById('attendanceTableBody');
        attendanceTableBody.innerHTML = ''; // Clear existing table rows

        // Populate table with search results
        data.forEach(student => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${student.studentNo}</td>
                <td>${student.name}</td>
                <td><input type="radio" name="attendance${student.id}" value="present"></td>
                <td><input type="radio" name="attendance${student.id}" value="absent"></td>
                <td><input type="radio" name="attendance${student.id}" value="excuse"></td>
            `;
            attendanceTableBody.appendChild(row);
        });
    })
    .catch(error => console.error('Error:', error));
});
