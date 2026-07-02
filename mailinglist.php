<?php
// mailing_list.php

// Include the connection file to set up the database connection
require_once 'connection_A.php';

try {
    // establish a database connection using PDO (PHP Data Objects)
    $DB = new PDO(DSN_CONNECTION_STRING, USER, PASSWORD);
    // Set the PDO error mode to exception to handle errors
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If the connection fails, catch the error and display the message
    echo "Connection failed: " . $e->getMessage();
}

// Query to fetch all interested students from the InterestedStudents table
$query = "SELECT * FROM InterestedStudents";
$stmt = $DB->query($query); // Execute the query
$interestedStudents = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all records as associative array

// Check if the request method is POST and if a delete_student action has been triggered
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_student'])) {
    // Save the InterestID of the student to hide it from the view
    $hiddenInterestId = $_POST['interest_id'];
    
    // Start the session to store hidden students in session
    session_start();
    // Set the flag in the session to hide the student by storing their InterestID
    $_SESSION['hidden_students'][$hiddenInterestId] = true;
}

// Check if the "export" GET parameter is set (meaning the user wants to export the mailing list)
if (isset($_GET['export'])) {
    // Set the headers to force download of the CSV file
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="mailing_list.csv"');

    // Open the output stream to write the CSV data
    $output = fopen('php://output', 'w');
    
    // Write the header row for the CSV file (column names)
    fputcsv($output, ['Student Name', 'Email', 'Programme Name']);

    // Loop through all interested students to write each student to the CSV file
    foreach ($interestedStudents as $student) {
        // Query to fetch the Programme Name associated with the student's ProgrammeID
        $programmeQuery = "SELECT ProgrammeName FROM Programmes WHERE ProgrammeID = ?";
        $programmeStmt = $DB->prepare($programmeQuery); // Prepare the query
        $programmeStmt->execute([$student['ProgrammeID']]); // Execute the query with the student's ProgrammeID
        $programme = $programmeStmt->fetch(PDO::FETCH_ASSOC); // Fetch the programme name

        // Write the student's data (name, email, programme) as a new row in the CSV file
        fputcsv($output, [$student['StudentName'], $student['Email'], $programme['ProgrammeName']]);
    }

    // Close the output stream after writing all data
    fclose($output);
    // Exit the script to prevent further processing
    exit;
}
?>
