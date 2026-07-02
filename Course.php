<?php
//Establishes Connection to the Database
include 'Connection.php';
//Includes the functions files to use functions
include 'Functions.php';

/* Uses the function from Functions.php and fetches programmes with other information from the database */
$programmes = getprogrammes();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- This is the Link to the CSS StyleSheet file for the Course Page-->
    <link rel="stylesheet" href="Course.css">

    <!-- This is the title for the Web Page -->
    <title>Courses</title>
</head>
<body>

<!--Header Section of the Home Page Containing the Navigation bar-->
<header class="HomePage_Header">
    <nav>
        <!-- This is the logo for the website-->
        <a href="#"><img src="https://play-lh.googleusercontent.com/H4eJrIZyQZpn_R2iYFkAOkdJk5HZW82dn3De9MaN1usqV0tGjhCeFgwLtB2DgXbjjg=w600-h300-pc0xffffff-pd"
                    alt="Logo for the Student Course Hub" alt="Logo"></a>

        <!-- This is the logo text for the website-->
        <label class="Header-Logo">STUDENT HUB</label>

        <!-- Hamburger Icon for Mobile View -->
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Navigation bars for the Course Page Desktop View -->
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

<!--Main Section with the content of the Course Page-->

<div class="container">
    <h1>Student Hub Courses</h1>

    <!-- Search Bar and Filter Dropdown with course level for Course Page -->
    <div class="Search-Filter">
        <!-- This is the Input field for searching programmes -->
        <input type="text" id="searchBar" placeholder="Search for a programme..." onkeyup="filterProgrammes()">

        <!-- This is the Dropdown Filter for Programme Levels -->
        <select id="levelFilter" onchange="filterProgrammes()">
            <option value="">All Levels</option>
            <option value="Undergraduate">Undergraduate</option>
            <option value="Postgraduate">Postgraduate</option>
        </select>
    </div>

    <!-- This section displays the list of programmes that is retrieved from the database -->
    <ul id="programmeList">
        <!-- This line here starts the foreach loop that iterates over the $programmes array,
             assigning each programme to the $programme variable-->
        <?php foreach ($programmes as $programme): ?>

            <!-- Programme List items -->
            <li class="programme"  data-level="<?= strtolower($programme['Level']) ?>"
                data-programme-id="<?= $programme['ProgrammeID'] ?>">
            <!-- Stores the programmes 'Level' (like 'Undergraduate' or 'Postgraduate') as a lowercase value -->
                <!-- Stores the unique ID of the programme (ProgrammeID) -->

                <h2>
                    <!-- This line here creates a link to teh programme.php with the current programme ID
                         and displays the programme name -->
                    <a href="programme.php?programme_id=<?= $programme['ProgrammeID'] ?>"><?= $programme['ProgrammeName'] ?></a>
                </h2>
                <!-- This line here displays the programme's description in paragraph tag -->
                <p><?= $programme['Description'] ?></p>
                <!-- This line here displays the name of the staff leading the programme -->
                <p>Led by <?= $programme['Name'] ?></p>
            </li>
        <!-- This line here marks the end of foreach loop -->
        <?php endforeach; ?>
    </ul>

</div>


<!-- Register Interest Section -->
<div class="register-interest-section">
    <div class="overlay">
        <h1>Interested in a Programme?<br>Register your interest <br> below!</h1>
        <a href="RegisterInterest.php" class="register-btn">Register Interest</a>
    </div>
</div>

<!--Footer Section-->
<div class="social__media">
    <p class="website__rights">© SCH-2025. All Rights Reserved by Ace Coders</p>
</div>


<!-- Adding the Script for Mobile Hamburger Menu -->
<script src="HomePageNav.js"></script>

<!-- This is the script which has the function to filter programme based on level -->
<script>
    function filterProgrammes() {
        // This section here gets the value of search query and selected level filter
        // This line here Converts the search query to lowercase
        let searchQuery = document.getElementById('searchBar').value.toLowerCase();
        // This line here Converts the selected level to lowercase
        let selectedLevel = document.getElementById('levelFilter').value.toLowerCase();
        // This line here gets all the programme list items
        let programmes = document.querySelectorAll('.programme');

        // Then this section loops through each programme and filters the programme based on search level
        programmes.forEach(prog => {
            // This line here gets the name of the programme and convert to lowercase
            let name = prog.querySelector('h2').innerText.toLowerCase();
            // This line here gets the level of the programme and convert to lowercase
            let level = prog.getAttribute('data-level').toLowerCase();

            // This section here check if the programme matches the search query and selected level
            // This line here checks if the name includes the search query
            let matchesSearch = name.includes(searchQuery);
            // This line here checks if the level matches the selected level or if no level is selected
            let matchesLevel = !selectedLevel || level === selectedLevel;

            // If the search and level matches this section here will show or hide the section based on the filter criteria
            if (matchesSearch && matchesLevel) {
                prog.style.display = '';
            } else {
                // If it doesn't match this will hide the programme
                prog.style.display = 'none';
            }
        });
    }
</script>

</body>
</html>
