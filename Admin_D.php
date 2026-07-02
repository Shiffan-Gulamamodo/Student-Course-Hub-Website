<?php
/* Included the Connection file to connect this file to the Database. */
include 'Connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Admin Portal</title>
</head>
<body>
<!--Header Section of the Home Page Containing the Navigation bar-->

<header class="HomePage_Header">
    <nav>
<!-- Importing a logo from my teammates Navigation bar. -->
        <a href="#"><img src="https://play-lh.googleusercontent.com/H4eJrIZyQZpn_R2iYFkAOkdJk5HZW82dn3De9MaN1usqV0tGjhCeFgwLtB2DgXbjjg=w600-h300-pc0xffffff-pd"
                         alt="Logo for the Student Course Hub"></a>
        <label class="Header-Logo">Admin Dashboard</label>

        <!--Navigation bars for the Home Page-->
        <div class="nav-bars">
            <ul>
<!-- Creating the List of Sections that will be links to different pages across the Admin Dashboard -->
                <li><a href="Admin_D.php">Home</a></li>
                <li><a href="programme.index.php">Programmes</a></li>
                <li><a href="Modules_D.php">Modules</a></li>
                <li><a href="mailinglist.index.php">Mailing</a></li>
                <li><a href="AdminLogin.php" class="button">Log Out</a></li>
            </ul>
        </div>
    </nav>
</header>

<!-- This is a row class which will contain the buttons for each page such as the edit programmes page, 
 edit modules page, student mailing list and will be displayed in a row. -->
<div class="row">
    <button class="Programmes"> <a href="programme.index.php">EDIT PROGRAMMES</a></button>
    <button class="Modules"><a href="Modules_D.php">EDIT MODULES</a></button>
    <button class="Mailing"><a href="mailinglist.index.php">STUDENT MAILING LIST</a></button>
</div>
</body>
</html>

