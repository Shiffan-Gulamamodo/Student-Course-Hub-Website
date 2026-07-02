<?php

/* This constant is specifying what the Database Type is which in this case is MySql. */
const DDBMS = "mysql";

/* This constant is specifying that the Database server  is running
on the same machine (known as the localhost) as the PHP Script will be run on. */
const HOST = "localhost";

/* This is the default port used by the MySql Server. */
const PORT = "3306";

/* This constant is defining the name of the Database. */
const DATABASE = "student_course_hub";

/* This is the Username required to log in to the Database. */
const USER = "YOUR_DATABASE_USERNAME";

/* This is the Password required to log in to the Database. */
const PASSWORD = "YOUR_DATABASE_PASSWORD";

/* This is a DSN String which is used for connecting to the MySql Database using PDO. */
const DSN_CONNECTION_STRING = DDBMS . ':host=' . HOST . ';port=' . PORT . ';dbname=' . DATABASE;

/* The try catch Statement below is trying to create a Database connection
using PDO. It will contain the DSN Connection String which will contain the
the Database type, host, port and database name. It also contains the User and
password needed to log into the Database. If the connection is successful
$DB will become an active connection. */
try {
    $DB = new PDO(DSN_CONNECTION_STRING, USER, PASSWORD);

    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "";
}
/* However if the connection is unsuccessful the catch statement will
execute displaying the error message below 'Connection failed'. */
catch (PDOException $e) {
    echo "Connection failed" . $e->getMessage();
}
