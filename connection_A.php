<?php

const DDBMS = "mysql";
 const HOST = "localhost";
 CONST PORT = 3306;
 CONST DATABASE = "student_course_hub";

 const USER = "YOUR_DATABASE_USERNAME";
 const PASSWORD = "YOUR_DATABASE_PASSWORD";

 const DSN_CONNECTION_STRING =  DDBMS . ':host=' .  HOST . ';port=' . PORT  .';dbname=' .  DATABASE;
  try{
      $DB = new PDO( DSN_CONNECTION_STRING, USER, PASSWORD );
      $DB ->setattribute (PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
      echo "";
  }catch (PDOException $e){
      echo "connection failed" . $e->getMessage();

  }


