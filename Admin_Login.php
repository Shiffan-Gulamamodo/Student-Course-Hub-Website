<?php
// This line here starts the session to track admin login status across pages
session_start();
//Establishes Connection to the Database and includes it
include 'Connection.php';

/* This section here is the admin credentials needed for authentication and to log in to the
   Admin Dashboard to make any changes to course */
$admin_username = 'YOUR_ADMIN_USERNAME'; // This is the Current and set admin username
$admin_password = 'YOUR_ADMIN_PASSWORD'; // This is the Current and set admin password

/* This Section here checks if the Login form was submitted using POST method*/
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // This Check if the POST values are received correctly for debugging purpose
    error_log("Received username: " . $_POST['username']); //Logs the entered username
    
    /* This section here retrieves the submitted admin username and password from the form
       and stores the inputted username and password */
    $username = $_POST['username'];
    $password = $_POST['password'];

    /* This section here validates the entered details against the set admin details and stores session
       variables to show that the admin is logged in*/
    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true; // Mark the session as logged in
        $_SESSION['admin_username'] = $username;  //Stores the admin username

        /* This section here logs the successful login attempt and redirects the admin to the
           Admin Dashboard page after successful login and th exit stops further script execution
           after the admin is redirected */
        error_log("Login successful for user: " . $username);
        header("Location: Admin_D.php");
        exit();
    } else {
        /* This section here shows an alert message saying 'Invalid credentials. Please try again.'
           and redirects the user again to the Admin Login page to try again if the login details are
           incorrect */
        echo "<script type='text/javascript'>
                alert('Invalid credentials. Please try again.');
                window.location.href = 'AdminLogin.php';
              </script>";
        //This line here logs the failed login attempt for security monitoring purpose
        error_log("Invalid login attempt for username: " . $username);
    }
}
?>
