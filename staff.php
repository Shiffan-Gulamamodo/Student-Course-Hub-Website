<?php

include 'connection.php';


// Fetch all staff members, optionally filtered by a search query
function getAllStaff($searchQuery = '') {
    global $DB;

    // Start with a basic SQL query to get all staff members from the 'Staff' table
    $sql = 'SELECT * FROM Staff';

    // If a search query is provided, add a WHERE clause to filter by the staff member's name
    if ($searchQuery) {
        $sql .= ' WHERE Name LIKE :searchQuery';
    }

    // Prepare the SQL statement to prevent SQL injection
    $query = $DB->prepare($sql);

    // Execute the query, passing in the search query as a parameter if it exists
    if ($searchQuery) {
        // If there is a search query, execute the prepared statement with the search parameter
        $query->execute([':searchQuery' => '%' . $searchQuery . '%']);
    } else {
        // If no search query is provided, execute the query without any filtering
        $query->execute();
    }

    // Return the results as an associative array (list of staff members)
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch the modules led by a specific staff member, identified by their staff ID
function getModulesLedByStaff($staffID) {
    global $DB;

    // Prepare an SQL query to fetch modules where the specified staff member is the leader
    $query = $DB->prepare('SELECT m.ModuleID, m.ModuleName, m.Description 
                           FROM Modules m
                           WHERE m.ModuleLeaderID = :staffID');

    // Execute the query, passing in the staff ID as a parameter
    $query->execute([':staffID' => $staffID]);

    // Return the result as an associative array (list of modules)
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch the programmes that contain modules led by a specific staff member
function getProgrammesByModulesLed($staffID) {
    global $DB;

    // Prepare an SQL query to fetch distinct programmes containing modules led by the specified staff member
    $query = $DB->prepare('SELECT DISTINCT p.ProgrammeID, p.ProgrammeName, p.Description
                           FROM Programmes p
                           JOIN ProgrammeModules pm ON p.ProgrammeID = pm.ProgrammeID
                           JOIN Modules m ON pm.ModuleID = m.ModuleID
                           WHERE m.ModuleLeaderID = :staffID');

    // Execute the query, passing in the staff ID as a parameter
    $query->execute([':staffID' => $staffID]);

    // Return the result as an associative array (list of programmes)
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// Get the search query from the URL if it's provided (using GET method)
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch all staff members based on the search query (if any)
$staffMembers = getAllStaff($searchQuery);

?>
