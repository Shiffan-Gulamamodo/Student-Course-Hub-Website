<?php
//Establishes Connection to the Database
include 'Connection.php';
//Includes the functions files to use functions
include 'Functions.php';

/* This line retrieves the programme id from the url query string if it exits
   and checks if the programme id is set in the URL */
$programme_id = isset($_GET['programme_id']) ? $_GET['programme_id'] : null;

/* This section here fetches the programme details if the programme id exists and if the programme id
   doesn't exist it will show an error Message saying programme not found*/
if ($programme_id) {
    /* This line here calls the function from the Functions.php file to get the programme detail from
       the database using ID */
    $programme_details = getprogrammeDetails($programme_id);
} else {
    echo "Programme not found.";
    exit; //This stops executing the script if no programme is found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- This is the Link to the CSS StyleSheet file for the Programme Page-->
    <link rel="stylesheet" href="Programmes.css">

    <!-- This is the title for the Web Page -->
    <title>Programme Details</title>
</head>
<body>

<!--Header Section of the Home Page Containing the Navigation bar-->
<header class="HomePage_Header">
    <nav>
        <!-- This is the logo for the website-->
        <a href="#"><img src="https://play-lh.googleusercontent.com/H4eJrIZyQZpn_R2iYFkAOkdJk5HZW82dn3De9MaN1usqV0tGjhCeFgwLtB2DgXbjjg=w600-h300-pc0xffffff-pd"
                    alt="Logo for the Student Course Hub"></a>

        <!-- This is the logo text for the website-->
        <label class="Header-Logo">STUDENT HUB</label>

        <!-- Hamburger Icon for Mobile View -->
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Navigation bars for the Programme Page Desktop View -->
        <div class="nav-bars">
            <ul>
                <!-- Navigation links to Different Pages -->
                <li><a href="HomePage.php">Home</a></li>
                <li><a href="Course.php">Courses</a></li>
                <li><a href="#">Staff</a></li>
                <li><a href="AdminLogin.php">Admin</a></li>
                <li><a href="#">Events</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </div>
    </nav>
</header>

<!--Main Section with the content of the Programme Page-->

<!-- Programme Details Section of the Programme Page-->
<div class="programme-container">
    <!-- This Displays the Programme Title -->
    <h1><?php echo $programme_details[0]['ProgrammeName']; ?></h1> <!-- Gets the ProgrammeName from the Database -->

    <!-- This Displays the Programme Description -->
    <p><?php echo $programme_details[0]['ProgrammeDescription']; ?></p>  <!-- Gets the ProgrammeDescription from the Database -->

    <!-- This is the Programme Leader section where the programme leader name for the programme is displayed -->
    <h2>Programme Leader</h2>
    <p class="programme-leader"><?php echo $programme_details[0]['ProgrammeLeaderName']; ?></p>  <!-- Gets the ProgrammeLeader Name from the Database -->

    <!-- Modules Section of the Programme Page -->
    <h2>Modules</h2>
    <?php
    // This function here Groups the Module by year (Year 1 , Year 2 , Year 3)

    // This line here initialise the variable to track the current year
    $current_year = null;

    // This line here loops through each programme details to display its modules
    foreach ($programme_details as $detail) {

        // This section here displays the modules by year

        //This line here checks if the current module is different from the last
        if ($detail['ModuleYear'] != $current_year) {

            // This line here checks if it's not first year it will close the previous year's list
            if ($current_year !== null) {
                echo '</ul>';
            }

            // This line here updates the current year
            $current_year = $detail['ModuleYear'];

            //This line here starts a new list for new year
            echo "<h3>Year $current_year</h3><ul>";
        }

        // This section here displays the module name, leader and description for each module
        echo "<li class='Modules'><strong>" . $detail['ModuleName'] . "</strong> - Led by " . $detail['ModuleLeaderName'] . "<br>";
        echo "<em>" . $detail['ModuleDescription'] . "</em></li>";
    }
    echo '</ul>';
    ?>
</div>

<!-- Adding the Script for Mobile Hamburger Menu -->
<script src="HomePageNav.js"></script>


</body>
</html>