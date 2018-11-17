<!DOCTYPE html>
<html lang="en">

<head>
    <!-- 
    Author: Gabriel Ortega
    Date: 10.30.18
    
    Filename: MySQLInfo.php
    -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MySQL Info</title>
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>

    <h2>MySQL Database Server Information</h2>
    <?php
    $hostName = "localhost";
    $userName = "adminer";
    $password = "quiet-Texas-16";
    $DBConnect = mysqli_connect($hostName, $userName, $password);
    // Check to see if we got a connection
    if (!$DBConnect) {
        // Failure
        echo "<p>Connection Failed.</p>\n";
    } else {
        // Success
        echo "<p>Connection Successful.</p>\n";
        mysqli_close($DBConnect);
    }
    ?>

</body>

</html>
