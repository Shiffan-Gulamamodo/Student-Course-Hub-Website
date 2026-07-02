<?php
include 'connection_A.php';
include 'admin.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <!-- This is the title of the Web Page -->
    <title>Admin Dashboard</title>

    <!-- This is the link to the CSS StyleSheet file for the homepage -->
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<h1>Programmes and Modules Management</h1>

<!-- this will add Programme Form -->
<form method="POST" action="admin.php">
    <h3>Add New Programme</h3>

    <!-- this block of code will create am input field for programme Name -->
    <label>Programme Name:</label><br>
    <input type="text" name="programme_name"><br><br>

    <!--this block of code will create a dropdown for selecting the Level (Undergraduate or Postgraduate) -->
    <label>Level:</label><br>
    <select name="level_id">
        <option value="1">Undergraduate</option>
        <option value="2">Postgraduate</option>
    </select><br><br>

    <!-- this will create a dropdown for selecting the Programme Leader from the staff -->
    <label>Programme Leader:</label><br>
    <select name="programme_leader_id">
        <?php
        // Query to fetch all staff members from the Staff table
        $staffQuery = "SELECT * FROM Staff";
        $staffStmt = $DB->query($staffQuery);
        $staffMembers = $staffStmt->fetchAll(PDO::FETCH_ASSOC);

        // this will loop through each staff member and display them as options for the Programme Leader dropdown
        foreach ($staffMembers as $staff) {
            echo "<option value='" . $staff['StaffID'] . "'>" . $staff['Name'] . "</option>";
        }
        ?>
    </select><br><br>

    <!-- this will create an input field for Programme Description -->
    <label>Description:</label><br>
    <textarea name="description"></textarea><br><br>

    <!-- this is a button to submit the new programme details -->
    <button type="submit" name="add_programme">Add Programme</button>
</form>

<hr>

<!-- this will create a form to select a Programme to update -->
<h3>Update Programme</h3>
<form method="POST" action="admin.php">
    <label>Select Programme to Update:</label><br>
    <select name="programme_id" required>
        <option value="">--Select Programme--</option>
        <?php foreach ($programmes as $programme): ?>
            <!-- Loop through each programme and create an option to select one for editing -->
            <option value="<?= $programme['ProgrammeID'] ?>"><?= $programme['ProgrammeName'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <!-- Button to load the selected programme's details for updating -->
    <button type="submit" name="load_programme">Load Programme</button>
</form>

<?php
// If a programme is selected for updating, it will fetch its details from the database
if (isset($_POST['load_programme']) && isset($_POST['programme_id'])) {
    $programmeId = $_POST['programme_id'];

    // SQL query to fetch the selected programme details by ProgrammeID
    $query = "SELECT * FROM Programmes WHERE ProgrammeID = ?";
    $stmt = $DB->prepare($query);
    $stmt->execute([$programmeId]);
    $programmeToUpdate = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($programmeToUpdate) {
        ?>
        <!-- Display the current programme details pre-filled for updating -->
        <form method="POST" action="admin.php">
            <label>Programme Name:</label><br>
            <input type="text" name="programme_name" value="<?= $programmeToUpdate['ProgrammeName'] ?>" required><br><br>

            <!--  this creates a dropdown to select the programme's level (Undergraduate/Postgraduate) -->
            <label>Level:</label><br>
            <select name="level_id" required>
                <option value="1" <?= $programmeToUpdate['LevelID'] == 1 ? 'selected' : '' ?>>Undergraduate</option>
                <option value="2" <?= $programmeToUpdate['LevelID'] == 2 ? 'selected' : '' ?>>Postgraduate</option>
            </select><br><br>

            <!--this creates a dropdown for selecting Programme Leader from the list of staff members -->
            <label>Programme Leader:</label><br>
            <select name="programme_leader_id" required>
                <?php
                // this is a  Loop, that will loop through staff members and mark the current leader as selected
                foreach ($staffMembers as $staff) {
                    echo "<option value='" . $staff['StaffID'] . "' " . ($programmeToUpdate['ProgrammeLeaderID'] == $staff['StaffID'] ? 'selected' : '') . ">" . $staff['Name'] . "</option>";
                }
                ?>
            </select><br><br>

            <!--  this creates a textarea for editing the programme description -->
            <label>Description:</label><br>
            <textarea name="description"><?= $programmeToUpdate['Description'] ?></textarea><br><br>

            <!-- Hidden input to store ProgrammeID for updating -->
            <input type="hidden" name="programme_id" value="<?= $programmeToUpdate['ProgrammeID'] ?>">

            <!-- Submit button to save changes -->
            <button type="submit" name="update_programme">Update Programme</button>
        </form>
        <?php
    }
}
?>

<hr>

<!-- List of Programmes -->
<h3>List of Programmes</h3>
<table border="1">
    <tr>
        <th>Programme Name</th>
        <th>Level</th>
        <th>Leader</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($programmes as $programme): ?>
        <?php
        // If the programme is marked as deleted in the session, show options to restore or permanently delete it
        if (isset($_SESSION['deleted_programmes']) && in_array($programme['ProgrammeID'], $_SESSION['deleted_programmes'])) {
            echo "<tr style='background-color: #f8d7da;'>"; // Highlight deleted programmes
            echo "<td colspan='5' style='text-align: center;'>This programme has been removed. 
              <form method='POST' action='admin.php' style='display:inline;'>
                <input type='hidden' name='programme_id' value='" . $programme['ProgrammeID'] . "'>
                <button type='submit' name='restore_programme'>Restore</button>
                <button type='submit' name='permanent_delete_programme'>Permanent Delete</button>
              </form></td>";
            echo "</tr>";
            continue;  // Skip normal display of this row since it's deleted
        }
        ?>
        <!-- Display programme details in a table row -->
        <tr>
            <td><?= $programme['ProgrammeName'] ?></td>
            <td><?= $programme['LevelID'] == 1 ? 'Undergraduate' : 'Postgraduate' ?></td>
            <td>
                <?php
                // Get the name of the Programme Leader from the Staff table
                $leaderQuery = "SELECT Name FROM Staff WHERE StaffID = ?";
                $leaderStmt = $DB->prepare($leaderQuery);
                $leaderStmt->execute([$programme['ProgrammeLeaderID']]);
                $leader = $leaderStmt->fetch(PDO::FETCH_ASSOC);
                echo $leader['Name'];
                ?>
            </td>
            <td><?= $programme['Description'] ?></td>
            <td>
                <!-- Button to delete the programme (temporarily hide it) -->
                <form method="POST" action="admin.php" style="display:inline;">
                    <input type="hidden" name="programme_id" value="<?= $programme['ProgrammeID'] ?>">
                    <button type="submit" name="delete_programme">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

</body>
</html>
