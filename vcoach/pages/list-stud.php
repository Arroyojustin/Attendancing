<?php
// Include database connection and functions file (use include_once to avoid multiple inclusions)
include_once('./../Admin/dbconn.php'); // Include DB connection only once
include_once('./controller/function.php'); // Include functions file only once

// Fetch student data for volleyball
$students = getStudentDataBySportsType($conn, 'volleyball'); // Fetch volleyball students
?>

<div class="container-fluid p-0 m-0 profile-page" id="studlist" style="display: none;">
  <h2 class="mb-4"></h2>
  <table class="table table-striped table-bordered table-hover">
    <thead>
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Student No.</th>
        <th scope="col">Position</th>
        <th scope="col">Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Display student data dynamically
      foreach ($students as $student) {
          echo "<tr>";
          echo "<td>" . $student['firstname'] . " " . $student['lastname'] . "</td>";
          echo "<td>" . $student['student_no'] . "</td>";
          echo "<td>" . $student['position'] . "</td>"; // Display the position
          echo "<td>Unknown Status</td>"; // Placeholder for Status
          echo "</tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<?php
// Close the database connection
$conn->close();
?>
