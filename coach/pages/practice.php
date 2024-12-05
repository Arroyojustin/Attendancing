<?php
include('./../Admin/dbconn.php');

// Function to fetch training session data
function fetchTrainingSessions($conn) {
    $sql = "SELECT training_date, training_time, location FROM training_sessions";
    $result = $conn->query($sql);

    // Check if there are any results
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['training_date'] . "</td>";
            echo "<td>" . $row['training_time'] . "</td>";
            echo "<td>" . $row['location'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No training sessions found</td></tr>";
    }
}
?>

<div class="container-fluid p-0 m-0 profile-page" id="chome" style="display: none;">
    <h2 class="mb-4"></h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Training Date</th>
                <th>Time</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Call the function to fetch and display training sessions
            fetchTrainingSessions($conn);
            ?>
        </tbody>
    </table>
</div>

<?php
// Close the database connection
$conn->close();
?>
