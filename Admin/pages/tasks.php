<div class="container-fluid p-0 m-0" id="tasks" style="display: none;">
    <h1 class=""></h1>

    <!-- Add Training Modal Button -->
    <div class="text-end mb-3">
        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addTrainingModal">Add Training Session</button>
    </div>

    <!-- Training Schedule Table -->
    <table class="table table-bordered table-striped" id="trainingScheduleTable">
        <thead>
            <tr>
                <th>Training Date</th>
                <th>Time</th>
                <th>Sport Type</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody id="trainingScheduleTableBody">
            <!-- Rows will be added dynamically -->
        </tbody>
    </table>

    <!-- Add Training Modal -->
    <div class="modal fade" id="addTrainingModal" tabindex="-1" aria-labelledby="addTrainingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTrainingModalLabel">Add New Training Session</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="trainingForm">
                        <div class="mb-3">
                            <label for="trainingDate" class="form-label">Training Date</label>
                            <input type="date" class="form-control" id="trainingDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="trainingTime" class="form-label">Time</label>
                            <input type="text" class="form-control" id="trainingTime" placeholder="e.g. 10:00 AM - 12:00 PM" required>
                        </div>
                        <div class="mb-3">
                            <label for="sportType" class="form-label">Sport Type</label>
                            <select class="form-select" id="sportType" required>
                                <option value="basketball">Basketball</option>
                                <option value="volleyball">Volleyball</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveTrainingSession">Save Training Session</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// When the Save Training Session button is clicked
document.getElementById("saveTrainingSession").addEventListener("click", function() {
    // Get form data
    let trainingDate = document.getElementById("trainingDate").value;
    let trainingTime = document.getElementById("trainingTime").value;
    let sportType = document.getElementById("sportType").value;
    let location = document.getElementById("location").value;

    // Validate the inputs
    if (trainingDate && trainingTime && sportType && location) {
        // Send the data to the server using AJAX
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "controller/save_training_session.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Prepare data to send to the server
        let data = `trainingDate=${trainingDate}&trainingTime=${trainingTime}&sportType=${sportType}&location=${location}`;

        // Handle the response from the server
        xhr.onload = function() {
            if (xhr.status === 200) {
                // If the training session was saved successfully, update the table
                let response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Create a new row in the table
                    let table = document.getElementById("trainingScheduleTable");
                    let newRow = table.insertRow();
                    newRow.innerHTML = `
                        <td>${response.trainingDate}</td>
                        <td>${response.trainingTime}</td>
                        <td>${response.sportType}</td>
                        <td>${response.location}</td>
                    `;

                    // Close the modal after saving
                    $('#addTrainingModal').modal('hide');

                    // Clear the form fields
                    document.getElementById("trainingForm").reset();
                } else {
                    alert("Error saving training session!");
                }
            } else {
                alert("An error occurred!");
            }
        };

        // Send the data
        xhr.send(data);
    } else {
        alert("Please fill in all fields!");
    }
});
</script>