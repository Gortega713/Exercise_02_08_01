<!DOCTYPE html>
<html lang="en">

<head>
    <!-- 
    Author: Gabriel Ortega
    Date: 11.1.18
    
    Filename: CreateNewsletterDB.php
    -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Newsletter DB</title>
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>

    <h2>Create Newsletter DB</h2>
    <?php
    $hostName = "localhost";
    $userName = "adminer";
    $password = "quiet-Texas-16";
    $DBName = "newsletter2";
    // Resource that we have to return to MySQL, This piece connects to the LOCALHOST SERVER
    $DBConnect = mysqli_connect($hostName, $userName, $password);
    // Check to see if we got a connection
    if (!$DBConnect) {
        // Failure
        echo "<p>Connection Failed.</p>\n";
    } else {
        // Successfully connected to LOCALHOST SERVER
        // Embed SQL commands
        // This piece creates a database INSIDE of the server
        $sql = "CREATE DATABASE $DBName";
        if (mysqli_query($DBConnect, $sql)) {
            echo "<p>Successfully created the \"$DBName\" database.</p>\n";
        } else {
            echo "<p>Could not create the \"$DBName\" database: " . mysqli_error($DBConnect) . "</p>\n";
        }
        mysqli_close($DBConnect);
    }
    ?>

</body>

</html>