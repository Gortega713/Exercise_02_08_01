<!DOCTYPE html>
<html lang="en">

<head>
    <!-- 
    Author: Gabriel Ortega
    Date: 11.1.18
    
    Filename: CreateSubscribersTable.php
    -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Subscribers Table</title>
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>

    <h2>Create Subscribers Table</h2>
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
        echo "<p>Connection Failed.</p>\n";
    } else {
        // Successfully connected to LOCALHOST SERVER
        // This piece selects a table within the database
        if (mysqli_select_db($DBConnect, $DBName)) {
            echo "<p>Successfully selected the \"$DBName\" database.</p>\n";
            // Embed SQL commands
            // Try to match tables that have the $tableName, name
            $sql = "SHOW TABLES LIKE '$tableName'";
            $result = mysqli_query($DBConnect, $sql);
            // Database is going to have the table, or its not; Success vs Failure
            
            if (mysqli_num_rows($result) == 0) {
                // If the result set has no rows, then it does not exist. If it does not exist:
                echo "The <strong>$tableName</strong>" . " table does not exists, creating it.<br>\n";
                // Create Table with data fields, primary key usually comes first, cannot be null (This is why we have the attribute NOT NULL)
                $sql = "CREATE TABLE $tableName " . "(subscriberID SMALLINT NOT NULL " . "AUTO_INCREMENT PRIMARY KEY," .  
                                                      " name VARCHAR(80), email VARCHAR(100)," . 
                                                      " subscribeDate DATE, confirmedDate DATE)";
                $result = mysqli_query($DBConnect, $sql);
                if (!$result) {
                    // Failure; TABLE was not created
                    echo "<p>Unable to create the <strong>$tableName</strong> table.</p>";
                    echo "<p>Error Code: " . mysqli_error($DBConnect) . "</p>";
                } else {
                    // Success
                    echo "<p>Successfully created the <strong>$tableName</strong> table.</p>";
                }
            } else {
                // If the result set has rows, then it exists. If it exist:
                echo "The <strong>$tableName</strong>" . " table already exists.<br>\n";
            }
        } else {
            echo "<p>Could not select the \"$DBName\" database: " . mysqli_error($DBConnect) . "</p>\n";
        }
        mysqli_close($DBConnect);
    }
    ?>

</body>

</html>