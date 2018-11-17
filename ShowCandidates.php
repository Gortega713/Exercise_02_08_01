<!DOCTYPE html>
<html lang="en" style="background-color: antiquewhite">

<head>
    <!-- 
     Author: Gabriel Ortega
     Date: 11.7.18
     
     Filename: ShowCandidates.php
     -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Show Candidates </title>
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>

    <h1>Candidates</h1>

    <?php
        // Database variables
        $hostName = "localhost";
        $userName = "adminer";
        $password = "quiet-Texas-16";
        $DBName = "interviews";
        $tableName = "candidates";
    
    function selectDB($DBConnect, $DBName) {
        $success = mysqli_select_db($DBConnect, $DBName);
        if ($success) {
            // Success; connect to database
            // echo "<p>Successfully selected the \"$DBName\" database.</p>\n";
        } else {
            // Failure; create database
            echo "<p>Could not select the \"$DBName\" database" . mysqli_error($DBConnect) . ", creating it.</p>\n";
            $sql = "CREATE DATABASE $DBName";
            if (mysqli_query($DBConnect, $sql)) {
                // Successfully created the database
                // echo "<p>Successfully created the \"$DBName\" database.</p>\n";
                $success = mysqli_select_db($DBConnect, $DBName);
                if ($success) {
                    // Go back and reselect the database like at the start of the function
                    // echo "<p.Successfully selected the \"$DBName\" database.</p>\n";
                }
            } else {
                // Total failure, something just isnt working
                echo "<p>Could not create the \"$DBName\" database: " . mysqli_error($DBConnect) . "</p>\n";
            }
        }
        // Return the connection
        return $success;
    }
    
    function createTable($DBConnect, $tableName) {
            $success = false;
            $sql = "SHOW TABLES LIKE '$tableName'";
            $result = mysqli_query($DBConnect, $sql);
            if (mysqli_num_rows($result) === 0) {
                echo "The <strong>$tableName</strong> table does not exist, creating table.<br>\n";
                $sql = "CREATE TABLE $tableName (candidateID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY," . 
                                                 " intFName VARCHAR(40), intLName VARCHAR(40)," . 
                                                 " intPos VARCHAR(40), date DATE," . 
                                                 " canFName VARCHAR(40), canLName VARCHAR(40)," . 
                                                 " commNum INT, appearance INT," . 
                                                 " compNum INT, business INT," . 
                                                 " comments VARCHAR(100))";
                $result = mysqli_query($DBConnect, $sql);
                if ($result === false) {
                    $success = false;
                    echo "<p>Unable to create the $tableName table.</p>";
                    // echo "<p>Error Code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>";
                } else {
                    $success = true;
                    // echo "<p>Successfully created the $tableName table.</p>";
                }
            } else {
                $success = true;
                // echo "<p>The $tableName table already exists.</p><br>\n";
            }
            return $success;
        }
    
        function connectToDB($hostName, $userName, $password) {
            $DBConnect = mysqli_connect($hostName, $userName, $password);
            if (!$DBConnect) {
                // Leave this error
                echo "<p>Connection error: " . mysqli_connect_error() . "</p>\n";
            }
            return $DBConnect;
        }
    
        $DBConnect = connectToDB($hostName, $userName, $password);
        if ($DBConnect) {
            if (selectDB($DBConnect, $DBName)) {
                if (createTable($DBConnect, $tableName)) {
                    // echo "<p>Connection Successful!</p>\n";
                    $sql = "SELECT * FROM $tableName";
                    $result = mysqli_query($DBConnect, $sql);
                    if (mysqli_num_rows($result) == 0) {
                        echo "<p>There are no entries in the candidates database!</p>";
                    } else {
                        echo "<table width='100%' border='1'>";
                        echo "<tr>";
                        echo "<th><em>Interview #</em></th>";
                        echo "<th><em>Interviewer First Name</em></th>";
                        echo "<th><em>Interviewer Last Name</em></th>";
                        echo "<th><em>Interviewer Position</em></th>";
                        echo "<th width='10%'><em>Date</em></th>";
                        echo "<th><em>Candidate First Name</em></th>";
                        echo "<th><em>Candidate Last Name</em></th>";
                        echo "<th width='10%'><em>Communication Rating</em></th>";
                        echo "<th width='10%'><em>Appearance Rating</em></th>";
                        echo "<th width='10%'><em>Computer Skills Rating</em></th>";
                        echo "<th width='10%'><em>Business Knowledge Rating</em></th>";
                        echo "<th><em>Comments</th>";
                        echo "</tr>";
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            foreach ($row as $key => $field) {
                                switch ($key) {
                                    case "commNum":
                                        echo "<td style='text-align: center; font-weight: bold'>{$field}</td>";
                                        break;
                                    case "appearance":
                                        echo "<td style='text-align: center; font-weight: bold'>{$field}</td>";
                                        break;
                                    case "compNum":
                                        echo "<td style='text-align: center; font-weight: bold'>{$field}</td>";
                                        break;
                                    case "business":
                                        echo "<td style='text-align: center; font-weight: bold'>{$field}</td>";
                                        break;
                                    default:
                                        echo "<td style='text-align: center'>{$field}</td>";
                                }
                            }
                            echo "</tr>\n";
                        }
                        echo "</table>";
                        mysqli_free_result($result);
                    }
                }
            }
            mysqli_close($DBConnect);
        }
    ?>
    
    <p>Click <a href="InterviewCandidates.php">here</a> to submit a new candidate for the job!</p>

</body>

</html>
