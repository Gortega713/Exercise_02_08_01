<!DOCTYPE html>
<html lang="en">

<head>
    <!-- 
    Author: Gabriel Ortega
    Date: 11.5.18
    
    Filename: NewsletterSubscribers2.php (Associative Array)
    -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Newsletter Subscribers 2</title>
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>

    <h2>Newsletter Subscribers 2 (Associative Array)</h2>
    <?php
    $hostName = "localhost";
    $userName = "adminer";
    $password = "quiet-Texas-16";
    $DBName = "newsletter2";
    $tableName = "subscribers";
    // Resource that we have to return to MySQL, This piece connects to the LOCALHOST SERVER
    $DBConnect = mysqli_connect($hostName, $userName, $password);
    // Check to see if we got a connection
    if (!$DBConnect) {
        // Failure
        echo "<p>Connection error: " . mysqli_connect_error() . "</p>\n";
    } else {
        // Successfully connected to LOCALHOST SERVER
        // This piece selects a table within the database
        if (mysqli_select_db($DBConnect, $DBName)) {
            echo "<p>Successfully selected the \"$DBName\" database.</p>\n";
            $sql = "SELECT * FROM $tableName";
            $result = mysqli_query($DBConnect, $sql);
            // Disply number of rows in result set
            
            
            /* Start of Table */
            echo "<p>Number of rows in <strong>$tableName</strong>: " . mysqli_num_rows($result) . ".</p>\n";
            echo "<table width='100%' border='1'>";
            echo "<tr>";
            echo "<th>Subscriber ID</th>";
            echo "<th>Name</th>";
            echo "<th>Email</th>";
            echo "<th>Subscribe Date</th>";
            echo "<th>Confirmed Date</th>";
            echo "</tr>\n";
            // Put data into an associative array
            // Each row of data is a new element
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                foreach ($row as $field) {
                    echo "<td>{$field}</td>";
                }
                echo "</tr>\n";
            }
            echo "</table>\n";
            mysqli_free_result($result);
        }
         else {
            echo "<p>Could not select the \"$DBName\" database: " . mysqli_error($DBConnect) . "</p>\n";
        }
        mysqli_close($DBConnect);
    }
    ?>

</body>

</html>