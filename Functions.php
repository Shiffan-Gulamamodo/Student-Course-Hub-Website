<?php

/* This is the getProgrammes Function used to get the list of programmes from the Programmes
   table inside the Database. This function retrieves all the programmes from the Programmes
   table along leader and the associated levels.*/
function getprogrammes()
{
    //This uses the Database Connection to interact with Database
    global $DB;
    /* This line here executes the query to fetch all the required details such as Programme name,
       Description, Level and Programme Leader */
    $query = $DB->query('SELECT
    ProgrammeID,
    ProgrammeName,
    Description,
    Name,
    LevelName AS Level  
    /* This Section with Databse query here joins Data from different table inside the database
       like in this function the Programmes, Staff and Levels tables are combined to get the 
       necessary information.*/
    FROM Programmes
    JOIN Staff ON StaffID = ProgrammeLeaderID
    JOIN Levels ON Levels.LevelID = Programmes.LevelID');

    //This line here returns fetched results
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/* This function here retrieves the detailed information about a specific programme, module,
   module leader, programme leader and the year each module will be taught in */
   function getprogrammeDetails($programme_id)
   {
       //This uses the Database Connection to interact with Database
       global $DB;
       /* This line here prepare the SQL query to get all the required details such as Programme details,
          modules, Level and Programme Leader */
       $query = $DB->prepare('
       SELECT
       p.ProgrammeName,
       p.Description AS ProgrammeDescription,
       s.Name AS ProgrammeLeaderName,
       m.ModuleID,
       m.ModuleName,
       m.Description AS ModuleDescription,
       sm.Name AS ModuleLeaderName,
       pm.Year AS ModuleYear
       /* This Section with Databse query here joins Data from different table inside the database 
          like in this function the Programme, ProgrammeModules, Staff and Modules table are combined 
          to get  the necessary details*/
       FROM Programmes p
       JOIN Staff s ON p.ProgrammeLeaderID = s.StaffID
       LEFT JOIN ProgrammeModules pm ON pm.ProgrammeID = p.ProgrammeID
       LEFT JOIN Modules m ON m.ModuleID = pm.ModuleID
       LEFT JOIN Staff sm ON sm.StaffID = m.ModuleLeaderID
       WHERE p.ProgrammeID = :programme_id
       ORDER BY pm.Year, m.ModuleName
       ');
   
       /* This section here binds the programme ID parameter to query to prevent SQL injection
          and execute the query */
       $query->bindParam(':programme_id', $programme_id, PDO::PARAM_INT);
       $query->execute();
   
       // This line here returns the fetched results
       return $query->fetchAll(PDO::FETCH_ASSOC);
   }
   