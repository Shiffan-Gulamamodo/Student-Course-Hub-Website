<?php
// admin.php

// Start session to track deleted programmes (so we can temporarily hide them when delete button is presses )
session_start();

// this establishes the database connection
require_once 'connection_A.php';

// this will fetch all programmes from the database
$query = "SELECT * FROM Programmes";
$stmt = $DB->query($query);
$programmes = $stmt->fetchAll(PDO::FETCH_ASSOC);

//  this will fetch all modules from the database
$queryModules = "SELECT * FROM Modules";
$stmtModules = $DB->query($queryModules);
$modules = $stmtModules->fetchAll(PDO::FETCH_ASSOC);

// this will handle form submission (for adding, updating, or removing programmes)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // this will add a new programme to the database
    if (isset($_POST['add_programme'])) {
        // Get the details from the form
        $programmeName = $_POST['programme_name'];
        $levelId = $_POST['level_id'];
        $leaderId = $_POST['programme_leader_id'];
        $description = $_POST['description'];

        // this will prepare and execute the query to insert the new programme
        $query = "INSERT INTO Programmes (ProgrammeName, LevelID, ProgrammeLeaderID, Description) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $DB->prepare($query);
        $stmt->execute([$programmeName, $levelId, $leaderId, $description]);

        // this will redirect back to the admin page after adding a programme
        header("Location: admin.php");
        exit();  // Stop further code execution
    }

    // this block of code will update an existing programme from the database
    if (isset($_POST['update_programme'])) {
        // Get the updated details from the form
        $programmeId = $_POST['programme_id'];
        $programmeName = $_POST['programme_name'];
        $levelId = $_POST['level_id'];
        $leaderId = $_POST['programme_leader_id'];
        $description = $_POST['description'];

        // this will prepare and execute the query to update the programme
        $query = "UPDATE Programmes SET ProgrammeName = ?, LevelID = ?, ProgrammeLeaderID = ?, Description = ? 
                  WHERE ProgrammeID = ?";
        $stmt = $DB->prepare($query);
        $stmt->execute([$programmeName, $levelId, $leaderId, $description, $programmeId]);

        // this block of code will redirect back to the admin page after updating
        header("Location: admin.php");
        exit();
    }

    // this will temporarily "delete" a programme (hide it from the display, but not from the database)
    if (isset($_POST['delete_programme'])) {
        $programmeId = $_POST['programme_id'];

        // this will mark the programme as deleted by adding it to the session
        $_SESSION['deleted_programmes'][] = $programmeId;
    }

    // this will restore a programme (undo the "delete" action)
    if (isset($_POST['restore_programme'])) {
        $programmeId = $_POST['programme_id'];

        // Remove the programme from the session's deleted_programmes array to restore it
        if (($key = array_search($programmeId, $_SESSION['deleted_programmes'])) !== false) {
            unset($_SESSION['deleted_programmes'][$key]);
        }
    }

    //  this block of code will permanently delete a programme from the database
    if (isset($_POST['permanent_delete_programme'])) {
        $programmeId = $_POST['programme_id'];

        // Delete the programme completely from the database
        $query = "DELETE FROM Programmes WHERE ProgrammeID = ?";
        $stmt = $DB->prepare($query);
        $stmt->execute([$programmeId]);

        // Remove the programme from the session's deleted_programmes array if it exists
        if (($key = array_search($programmeId, $_SESSION['deleted_programmes'])) !== false) {
            unset($_SESSION['deleted_programmes'][$key]);
        }

        // Redirect back to the admin page after permanent deletion
        header("Location: admin.php");
        exit();
    }
}
?>


