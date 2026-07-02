<?php
//Establishes Connection to the Database
include 'Connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- This is the title for the Web Page -->
    <title>Register Interest</title>
    <!-- This is the Link to the CSS StyleSheet file for the Register Interest page-->
    <link rel="stylesheet" href="RegisterInterests.css">
</head>
<body>

<!--Header Section of the Register Interest Page Containing the Navigation bar-->
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

        <!-- Navigation bars for the Register Interest Page Desktop View -->
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

<!--Register Page Main Section a form to take the user Inputs-->

<div class="Container">
    <!-- Form Box for Register Interest Section-->
    <div class="Form-Box Register">
        <form action="regitser_interest.php" method="POST">
            <h1>Register Course <br> Interest</h1>

            <!-- Drop down list for the Programmes-->
            <div class="Input">
                <select name="ProgrammeID" id="Programmes" required>
                    <option value="" disabled selected><b>Select a Programme</b></option>
                    <!-- This Function here Populates the dropdown list with the list of programmes
                         from the Database-->
                    <?php
                    /* The global DB ensures a connection to database connection exists
                       Before executing the query */
                    global $DB;
                    /*This section fetches the programme IDs and Programme Names from the
                      Programme Table  and the Prepare query prevents SQL injection*/
                    $query = "SELECT ProgrammeID, ProgrammeName FROM Programmes";
                    $stmt = $DB->prepare($query);
                    /* This Section here executes the query and fetches all results*/
                    $stmt->execute();
                    $programmes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    /* This Section here loops through each programme and creates a dropdown list for Programmes */
                    foreach ($programmes as $programme) {
                        echo "<option value='{$programme['ProgrammeID']}'>{$programme['ProgrammeName']}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Input for the full name for registering interest -->
            <div class="Input">
                <input type="text" name="StudentName" placeholder="Full Name" required>
            </div>

            <!-- Input for the email for registering interest -->
            <div class="Input">
                <input type="email" name="Email" placeholder="Email" required>
            </div>

            <!-- Submit Button to Submit the details -->
            <button type="submit" class="btn">Submit</button>
        </form>
    </div>
</div>

<!-- Adding the Script for Mobile Hamburger Menu -->
<script src="HomePageNav.js"></script>

</body>
</html>
