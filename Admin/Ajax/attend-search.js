document.getElementById('searchBtn').addEventListener('click', function() {
    var surname = document.getElementById('surname').value.trim();
    
    // Redirect to the page with the surname as a query parameter
    window.location.href = "../pages/attendance.php?surname=" + surname;
});