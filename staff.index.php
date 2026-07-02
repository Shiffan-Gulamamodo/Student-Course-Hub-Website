<?php
include 'connection.php';

include_once 'staff.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Linking to an external CSS file to style the webpage -->
    <link rel="stylesheet" href="coursework.css">

    <!-- This is the title for the Web Page -->
    <title>Staff Details</title>
</head>
<body>
    <!-- added a nav bar --> 
<header class="HomePage_Header">
    <nav>
        <!-- This is the logo for the website-->
        <a href="#"><img src="https://play-lh.googleusercontent.com/H4eJrIZyQZpn_R2iYFkAOkdJk5HZW82dn3De9MaN1usqV0tGjhCeFgwLtB2DgXbjjg=w600-h300-pc0xffffff-pd"
                         alt="Logo for the Student Course Hub"></a>

        <!-- This is the logo text for the website-->
        <label class="Header-Logo">STUDENT HUB</label>

        <!-- Navigation bars for the Home Page Desktop View -->
        <div class="nav-bars">
            <ul>
                <!-- Navigation links to Different Pages -->
                <li><a href="HomePage.html">Home</a></li>
                <li><a href="Courses.php">Courses</a></li>
                <li><a href="#">Staff</a></li>
                <li><a href="AdminLogin.html">Admin</a></li>
                <li><a href="#">Events</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </div>
    </nav>
</header>
<!-- This is the Header for the Staff Page -->
<h1>Staff Members and Their Modules/Programmes</h1>

<div>
    <!-- The form method is GET, which means the data will be added to the URL -->
    <form method="get" action="">
        <!-- Search bar to filter staff by their name -->
        <!-- Text input for the user to type in a search query. If there is an existing query, it will be displayed as the default value. -->
        <input type="text" name="search" placeholder="Search Staff by Name" value="<?php echo htmlspecialchars($searchQuery); ?>" />

        <!-- Submit button to submit the search from staff members -->
        <button type="submit">Search</button>
    </form>
</div>

<!-- Each button will, when clicked, direct the user to the specific section with that staff member's details -->
<div>
    <h3>Click to view staff details:</h3>
    <?php if ($staffMembers): ?>
        <?php foreach ($staffMembers as $staff): ?>
            <!-- Buttons for navigating to the details of specific staff members -->
            <!-- A button is generated for each staff member. The button's onclick event will scroll to the specific section
                 of the page where the staff's details are displayed (using their unique StaffID) -->
            <button onclick="location.href='#staff-<?php echo $staff['StaffID']; ?>'">
                <?php echo htmlspecialchars($staff['Name']); ?> <!-- Display the staff member's name on the button -->
            </button>
        <?php endforeach; ?>
    <?php else: ?>
        <!-- If no staff members are found in the array (perhaps due to an empty search result), it will display this message -->
        <p>No staff members found for your search.</p>
    <?php endif; ?>
</div>


<!-- This section will render the specific details of each staff member -->

<!-- Loop through all staff members and display their individual details -->
<?php foreach ($staffMembers as $staff): ?>
    <div id="staff-<?php echo $staff['StaffID']; ?>">
        <!-- This will display the name of the current staff member as a heading -->
        <h2>Staff: <?php echo htmlspecialchars($staff['Name']); ?></h2>

        <!-- this wll display the modules led by the current staff member -->
        <h3>Modules Led:</h3>
        <?php
        // Assuming this function retrieves a list of modules led by the current staff member based on their StaffID
        $modules = getModulesLedByStaff($staff['StaffID']);
        if ($modules): ?>
            <!-- If the staff member leads any modules,it will  display them in a table -->
            <table>
                <tr>
                    <!-- these are the table headers for the module and description  -->
                    <th>Module Name</th>
                    <th>Description</th>
                </tr>
                <?php foreach ($modules as $module): ?>
                    <!-- this block of code will loop through each module and display its name and description in the table by
                         fetching the data from the database -->
                    <tr>
                        <td><?php echo htmlspecialchars($module['ModuleName']); ?></td>
                        <td><?php echo htmlspecialchars($module['Description']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <!-- If no modules are found for this staff member, it will  display a message -->
            <p>No modules led by this staff member.</p>
        <?php endif; ?>

        <!-- this will display the programmes that include the modules led by the current staff member -->
        <h3>Programmes Containing These Modules:</h3>
        <?php
        // This function gets a list of programmes that include the modules led by the staff member.
        $programmes = getProgrammesByModulesLed($staff['StaffID']);
        if ($programmes): ?>
            <!-- If the staff member's modules are part of any programmes, display them in a table -->
            <table>
                <tr>
                    <!-- these are the table headers for programme names and descriptions -->
                    <th>Programme Name</th>
                    <th>Description</th>
                </tr>

                <!--this block of code will loop through each programme and display its name and description in the table -->
                <?php foreach ($programmes as $programme): ?>

                    <tr>
                        <td><?php echo htmlspecialchars($programme['ProgrammeName']); ?></td>
                        <td><?php echo htmlspecialchars($programme['Description']); ?></td>
                    </tr>
                <!-- This line Here ends the loop-->
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <!-- If no programmes are found for this staff member's modules, it will  display this message -->
            <p>This staff member does not lead modules in any programmes.</p>
        <?php endif; ?>

    </div>
    <hr>
    <!-- The horizontal rule (<hr>) is used to separate the sections for each staff member -->
<?php endforeach; ?>

</body>
</html>
