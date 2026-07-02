<?php
// This is the file that calls upon other files and runs the Course webpage

//Establishes Connection to the Database
include 'Connection.php';
//Includes the functions files to use functions
include 'Functions.php';

// This function retrieve list of programmes from the database
$programmes =  getprogrammes();
//This is the Course Page Title
$title = "Student Course Hub Courses";

//Calls the Course File which holds all the HTML and CSS
include 'Course.php';

