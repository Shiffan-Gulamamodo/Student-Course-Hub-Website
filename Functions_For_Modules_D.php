<?php

/* Fetch all the Modules from the Database and return them as
an Associative array. */
function getModules() {
    global $DB;
    global $modules;
    $queryModules = "SELECT * FROM Modules";
    $stmtModules = $DB->query($queryModules);
    $modules = $stmtModules->fetchAll(PDO::FETCH_ASSOC);
    return $modules;
}

/* Fetch all the Staff Members from the Database. */
function getStaffMembers() {
    global $DB;
    global $staffMembers;
    $staffQuery = "SELECT * FROM Staff";
    $staffStmt = $DB->query($staffQuery);
    $staffMembers = $staffStmt->fetchAll(PDO::FETCH_ASSOC);
    return $staffMembers;
}

/* Retrieve each Staff Member from the Staff Members in the Database via 'foreach'.
Echoes out the options available to select from in the Dropdown list
displaying the Staff Name which is held by the value of the Staff ID */
function generateStaffDropdown($staffMembers) {
    foreach ($staffMembers as $staff) {
        echo "<option value='" . $staff['StaffID'] . "'>" . $staff['Name'] . "</option>";
    }
}

/* The function takes the ModuleLeaderID from the $module which will
   query the Database via $DB allowing the Leaders Name to be retrieved. */
   function getModuleLeaderName($moduleLeaderID, $DB) {
    // SQL query to select the staff member's name based on their StaffID
    $leaderQuery = "SELECT Name FROM Staff WHERE StaffID = ?";

    /* This will prepare the SQL Query with the placeholders
    to then store it inside of the leaderStmt. */
    $leaderStmt = $DB->prepare($leaderQuery);

    /* Execute the Query. */
    $leaderStmt->execute([$moduleLeaderID]);

    // Fetch the result as an associative array
    $leader = $leaderStmt->fetch(PDO::FETCH_ASSOC);

    // Return the leader's name or a fallback if not found
    return $leader ? $leader['Name'] : "Unknown";
}

/* Retrieve each Module from the Modules stored in the Database via 'foreach'.
Echoes out the options available to select from in the Dropdown list
displaying the Module name which is held by the value of the Module ID along with
the other attributes like Module Leader ID, Description etc */
function generateModuleDropdown($modules) {
    foreach ($modules as $module) {
        echo "<option value='" . $module['ModuleID'] . "' 
              data-name='" . $module['ModuleName'] . "' 
              data-leader='" . $module['ModuleLeaderID'] . "' 
              data-description='" . htmlspecialchars($module['Description']) . "'>
              " . $module['ModuleName'] . "
          </option>";
    }
}

/* This is the addModule function which will take in the given parameters to prevent SQL Injection.
Contains the query to insert the Module Name, Leader ID and Description ID.
It will prepare the SQL statement using the Database connection. Execute the prepared Statement
and pass in the Module data as an array. */
function addModule($moduleName, $leaderId, $description, $DB) {
    $query = "INSERT INTO Modules (ModuleName, ModuleLeaderID, Description) 
              VALUES (?, ?, ?)";
    $stmt = $DB->prepare($query);
    $stmt->execute([$moduleName, $leaderId, $description]);

    /* Redirect to refresh the page after adding the module and then ensure the script stops
    executing after the redirect. */
    header("Location: Modules_D.php");
    exit();
}

/* This is an if statement function for the Add Module in which the 'isset'
will check if the button was clicked. If so, it will get the values from the form and call the
addModule function to insert the data to the Modules Page.*/
if (isset($_POST['add_module'])) {
    // Get the form values
    $moduleName = $_POST['module_name'];
    $leaderId = $_POST['module_leader_id'];
    $description = $_POST['module_description'];

    // Call the addModule function to insert the data and redirect
    addModule($moduleName, $leaderId, $description, $DB);
}

/* This is an if statement function for the Update Module in which the 'isset'
will check if the button was clicked. If so, it will get the values from the form and call the
addModule function to insert the data to the Modules Page to then update the selected module
data in the Database. */
if (isset($_POST['update_module'])) {
    $moduleId = $_POST['module_id'];
    $moduleName = $_POST['module_name'];
    $leaderId = $_POST['module_leader_id'];
    $description = $_POST['module_description'];

    /* The SQL query will update the module with the ModuleName, ModuleLeaderID, Description
    from the selected Module that is coming from its ModuleId. */
    $query = "UPDATE Modules SET ModuleName = ?, ModuleLeaderID = ?, Description = ? 
                  WHERE ModuleID = ?";
    /* Prepares the Query for execution. */
    $stmt = $DB->prepare($query);
    $stmt->execute([$moduleName, $leaderId, $description, $moduleId]);

    // Force page reload after updating it and then redirect it back to the Modules Page.
    header("Location: Modules_D.php");
    exit();
}

/* This is an if statement function for the Delete Module in which the 'isset'
will check if the button was clicked. If so, it will remove the values from the specified Module
ID which will contain the rest of the Modules Data.*/
if (isset($_POST['delete_module'])) {
    $moduleId = $_POST['module_id'];
    /* The SQL query will Delete the module data from
    the selected Module that is coming from its ModuleId. */
    $query = "DELETE FROM Modules WHERE ModuleID = ?";
    $stmt = $DB->prepare($query);
    $stmt->execute([$moduleId]);

    // Force page reload after deleting it and then redirect it back to the Modules Page.
    header("Location: Modules_D.php");
    exit();
}
