<?php
//Establishes Connection to the Database
include 'Connection.php';

//This section here Checks if the request method is POST to ensure the Form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /* This section here retrieves the input from the POST request made in RegisterInterest.php
       the inputs that are retrieved are selected Programme from the dropdown list, full name,
       and email address */
    $programmeID = $_POST['ProgrammeID'];
    $studentName = $_POST['StudentName'];
    $email = $_POST['Email'];

    //This uses the Database Connection to interact with Database to check and store student Interest
    global $DB;

    /* This section here prepare to check if the student who registered their interest
       already has registered their interest before or not and by binding email parameter securely to
       prevents SQL injection */
    $stmt = $DB->prepare("SELECT * FROM InterestedStudents WHERE Email = :email AND ProgrammeID = :programmeID");
    $stmt->bindParam(':email', $email);

    /* This section here binds ProgrammeID Parameter, executes the query and fetches any result for
       existing Interest */
    $stmt->bindParam(':programmeID', $programmeID);
    $stmt->execute();
    $existingInterest = $stmt->fetch(PDO::FETCH_ASSOC);

    /* This section here sends an alert to the user with a message if existing interest/user is found in
       the database and redirects the user back to the Course Page*/
    if ($existingInterest) {
        echo "<script type='text/javascript'>
            alert('You have already registered your interest for this programme.');
            window.location.href = 'Course.php';
          </script>";
    } else {
        /* This section here Prepare the query to insert the new interest registration from the user into
           the InterestedStudents table inside the Database */
        $stmt = $DB->prepare("INSERT INTO InterestedStudents (ProgrammeID, StudentName, Email) VALUES (:programmeID, :studentName, :email)");
        $stmt->bindParam(':programmeID', $programmeID);  //This Binds the ProgrammeID Parameter securely to prevent SQL injection
        $stmt->bindParam(':studentName', $studentName);  //This Binds the StudentName Parameter securely to prevent SQL injection
        $stmt->bindParam(':email', $email);  //This Binds the Email Parameter securely to prevent SQL injection

        /* This section here executes the insertion of new interest registration query and sends
           an alert to the user with a message on successful registration it then redirects the user
           to the Course Page */
        $stmt->execute();
        echo "<script type='text/javascript'>
            alert('Thank you for registering your interest!');
            window.location.href = 'Course.php';
          </script>";

    }

}else {
    /* This section here checks for the Request method and if the request method is nopt POST
       it will show an error message saying 'Invalid Request.' and redirects the user again to
       the registration page to try again.*/
    echo "<script type='text/javascript'>
                alert('Invalid Request.');
                window.location.href = 'RegisterInterest.php';
              </script>";
}
?>
