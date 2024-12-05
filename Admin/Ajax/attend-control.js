document.addEventListener("DOMContentLoaded", () => {
    const presentCountElem = document.querySelector(".present-card h6");
    const absentCountElem = document.querySelector(".absent-card h6");
    const totalStudentsElem = document.querySelector(".total-students-card h6");

    const attendanceTable = document.querySelector("#attendanceTable tbody");

    function updateSummary() {
        let presentCount = 0;
        let absentCount = 0;
        let totalCount = 0;

        // Iterate through all table rows in the tbody
        const rows = attendanceTable.querySelectorAll("tr");
        rows.forEach((row) => {
            const statusCell = row.cells[2]; // Status is in the 3rd column (index 2)
            const status = statusCell ? statusCell.textContent.trim().toLowerCase() : 'absent';

            totalCount++;

            if (status === 'present') {
                presentCount++;
            } else if (status === 'absent') {
                absentCount++;
            }
        });

        // Update the summary cards with the calculated counts
        presentCountElem.textContent = `${presentCount} Present Today`;
        absentCountElem.textContent = `${absentCount} Absent Today`;
        totalStudentsElem.textContent = `${totalCount} Total Students`;
    }

    // Call the function to update the summary as soon as the page is ready
    updateSummary();
});
