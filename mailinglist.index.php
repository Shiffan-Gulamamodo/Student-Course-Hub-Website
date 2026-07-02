<?php
include 'connection_A.php';
include 'mailinglist.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <title>Mailing List</title> <!-- Sets the title of the webpage -->
    <link rel="stylesheet" href="mailinglist.css"> <!-- Links to the external CSS file for styling the page -->
</head>
<body>

<h1>Mailing List of Interested Students</h1> <!-- Main header of the page -->

<!-- Link to export the mailing list as a CSV file -->
<a href="mailing_list.php?export=true">Export Mailing List (CSV)</a>

<hr> <!-- Horizontal line separating sections -->

<!-- Table to display the students' mailing list -->
<table border="1">
    <!-- Table headers -->
    <tr>
        <th>Student Name</th> <!-- Column for student's name -->
        <th>Email</th> <!-- Column for student's email -->s
        <th>Programme</th> <!-- Column for the associated programme name -->
        <th>Actions</th> <!-- Column for actions (e.g., delete) -->
    </tr>

    <?php
    session_start(); // Starts a session to allow access to session variables 
    
    // Loop through all the interested students to display them in the table
    foreach ($interestedStudents as $student):
        // Check if this student has been hidden in the session
        if (isset($_SESSION['hidden_students'][$student['InterestID']])) {
            continue; // Skip displaying this student if they're hidden
        }
        ?>
        <!-- Display each student in a new table row -->
        <tr>
            <!-- Display student name -->
            <td><?= $student['StudentName'] ?></td>

            <!-- Display student email -->
            <td><?= $student['Email'] ?></td>

            <!-- Display the associated programme name for the student -->
            <td>
                <?php
                // Query to fetch the programme name for this student based on their ProgrammeID
                $programmeQuery = "SELECT ProgrammeName FROM Programmes WHERE ProgrammeID = ?";
                $programmeStmt = $DB->prepare($programmeQuery); // Prepare the query
                $programmeStmt->execute([$student['ProgrammeID']]); // Execute the query with the ProgrammeID
                $programme = $programmeStmt->fetch(PDO::FETCH_ASSOC); // Fetch the programme data
                echo $programme['ProgrammeName']; // Display the programme name
                ?>
            </td>

            <!-- Actions column where the user can delete the student from the view -->
            <td>
                <!-- Form to submit a delete request -->
                <form method="POST" style="display:inline;">
                    <!-- Hidden input to pass the student's InterestID -->
                    <input type="hidden" name="interest_id" value="<?= $student['InterestID'] ?>">
                    <!-- Submit button to trigger the delete action -->
                    <button type="submit" name="delete_student">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
