<?php
/* Including the Connection file to create the Connection to the Database. */
include 'Connection_D.php';
/* Including the Functions file to include the functions in this file. */
include 'Functions_For_Modules_D.php';

$modules = getModules();
$staffMembers = getStaffMembers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="Modules_D.css">
</head>
<body>
    <header class="ModulesPage_Header">
<!-- Logo & Navigation Bar for the Modules Page. -->
        <nav>
            <a href="#"><img src="https://play-lh.googleusercontent.com/H4eJrIZyQZpn_R2iYFkAOkdJk5HZW82dn3De9MaN1usqV0tGjhCeFgwLtB2DgXbjjg=w600-h300-pc0xffffff-pd"
                alt="Logo for the Student Course Hub"></a>
            <label class="Header-Logo">Modules</label>
            <div class="nav-bars">
<!-- Creating the List of Sections that will be links to different pages across the Admin Dashboard -->
                <ul>
                    <li><a href="Admin_D">Home</a></li>
                    <li><a href="programme.index.php">Programmes</a></li>
                    <li><a href="Modules_D">Modules</a></li>
                    <li><a href="mailinglist.php">Mailing</a></li>
                    <li><a href="AdminLogin.php" class="button">Log Out</a></li>
                </ul>
            </div>
        </nav>
    </header>

<div class="main-container">
    <!-- Left Column: Add Module & Update Module -->
    <div class="left-column">
        <!-- Add Module Section -->
        <div class="container">
            <h3 class="title">Add New Module</h3>
            <!-- A form that will submit Data using POST that will display the Data back to this file. -->
            <form method="POST" action ="Modules_D.php">
                <label>Module Name:</label><br>
                <!-- Input box to Enter the Module Name -->
                <input type="text" name="module_name"><br><br>
                <!-- Dropdown List for Module Leaders -->
                <label>Module Leader:</label><br>
                <select name="module_leader_id">
                    <?php
                    /*Calls the generateStaffDropdown function that will populate the Dropdown list
                    with Staff Members. */
                    generateStaffDropdown($staffMembers);
                    ?>
                </select><br><br>

                <label>Description:</label><br>
                <textarea id="add_module_description" name="module_description"></textarea><br><br>
                <!-- Submit button to submit the Added Module. -->
                <button type="submit" name="add_module">Add Module</button>
            </form>
        </div>

        <!-- Update Module Section -->
        <div class="container" id="update-module-form">
            <h3 class="title">Update Module</h3>
            <form method="POST" action="Modules_D.php">
                <label>Select Module:</label><br>
                <!-- Dropdown List for Modules -->
                <select id="module_select" name="module_id" required>
                    <option value="">-- Select a Module --</option>

                    <?php
                    /*Calls the generateModuleDropdown function that will populate the Dropdown list
                    with Modules. */
                    generateModuleDropdown($modules);
                    ?>
                </select><br><br>

                <!-- Input Field for Module Name -->
                <label>Module Name:</label><br>
                <input type="text" id="module_name" name="module_name" required><br><br>
                <!-- Dropdown List to select the Module Leader -->
                <label>Module Leader:</label><br>
                <select id="module_leader_id" name="module_leader_id" required>
                    <?php
                    /*Calls the generateStaffDropdown function that will populate the Dropdown list
                    with Staff Members. */
                    generateStaffDropdown($staffMembers);
                    ?>
                </select><br><br>

                <label>Description:</label><br>
                <textarea id="add_module_description" name="module_description"></textarea><br><br>

                <button type="submit" name="update_module">Update Module</button>
            </form>
        </div>
    </div>

    <!-- Right Column: List of Modules -->
    <div class="right-column">
        <div class="container">
            <h3 class="title">List of Modules</h3>
            <table>
                <tr>
                    <!-- The <th> element stands for Table Header which will initially define each
                    columns header with e.g. The first column will be Module Name, Second will be Leader,
                    Third is Description and Fourth is Actions. -->
                    <th>Module Name</th>
                    <th>Leader</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                <?php
                // Retrieve each Module from Modules in the Database.
                foreach ($modules as $module):
                ?>
                    <!-- The <tr> element creates a new table row including the Module Name that is inside a Module. -->
                    <tr>
                        <!-- The <td> element will insert the Module Name inside the table data. -->
                        <td><?= $module['ModuleName'] ?></td>
                        <td>
                            <?php
                            global $DB;
                            // Calls the getModuleLeaderName function to retrieve the Staff Member that leads the Module.
                            // The function takes the ModuleLeaderID from the $module which will query the Database via $DB allowing the Leaders Name to be retrieved.
                            echo getModuleLeaderName($module['ModuleLeaderID'], $DB);
                            ?>
                        </td>
                        <td>
                            <!-- The <td> element will insert the Description of each Module into the Table. -->
                            <?= $module['Description'] ?>
                        </td>

                        <!-- This contains a form that allows the admin to delete a Module from the table. -->
                        <td>
                            <!-- The <form> method creates a form in HTML that uses
                            'POST' to send data back to this File Modules.php to remove
                            data from the table that is displayed on this Page.-->
                            <form method="POST" action="Modules_D.php" style="display:inline;">
                                <input type="hidden" name="module_id" value="<?= $module['ModuleID'] ?>">
                                <!-- This is the delete button which when clicked, it will
                                 remove the specified Module from the table. -->
                                <button type="submit" name="delete_module">Delete</button>
                            </form>
                        </td>
                    </tr>
                <!-- The 'endforeach' is marking the end of the foreach that was included before
                 when retrieving the Modules from the Database. -->
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
</body>
</html>