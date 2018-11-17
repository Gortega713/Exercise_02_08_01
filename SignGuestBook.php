<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Title </title>
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>

    <h1>Sign Guest Book</h1>
    <?php
    
    // Function to connect to database
    function connectToDB($hostName, $userName, $password) {
        $DBConnect = mysqli_connect($hostName, $userName, $password);
        if (!$DBConnect) {
            // Leave this error
            echo "<p>Connection error: " . mysqli_connect_error() . "</p>\n";
        }
        return $DBConnect;
    }
    
    // Function to select our current database
    function selectDB($DBConnect, $DBName) {
        $success = mysqli_select_db($DBConnect, $DBName);
        if ($success) {
            // Success; connect to database
            echo "<p>Successfully selected the \"$DBName\" database.</p>\n";
        } else {
            // Failure; create database
            // echo "<p>Could not select the \"$DBName\" database" . mysqli_error($DBConnect) . ", creating it.</p>\n";
            $sql = "CREATE DATABASE $DBName";
            if (mysqli_query($DBConnect, $sql)) {
                // Successfully created the database
                echo "<p>Successfully created the \"$DBName\" database.</p>\n";
                $success = mysqli_select_db($DBConnect, $DBName);
                if ($success) {
                    // Go back and reselect the database like at the start of the function
                    echo "<p.Successfully selected the \"$DBName\" database.</p>\n";
                }
            } else {
                // Total failure, something just isnt working
                // echo "<p>Could not create the \"$DBName\" database: " . mysqli_error($DBConnect) . "</p>\n";
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
            $sql = "CREATE TABLE $tableName (countID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY," . 
                                             " lastName VARCHAR(40), firstName VARCHAR(40))";
            $result = mysqli_query($DBConnect, $sql);
            if ($result === false) {
                $success = false;
                echo "<p>Unable to create the $tableName table.</p>";
                // echo "<p>Error Code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>";
            } else {
                $success = true;
                echo "<p>Successfully created the $tableName table.</p>";
            }
        } else {
            $success = true;
            echo "<p>The $tableName table already exists.</p><br>\n";
        }
        return $success;
    }
    
    // Global Variables
    $hostName = "localhost";
    $userName = "adminer";
    $password = "quiet-Texas-16";
    $DBName = "guestbook";
    $tableName = "visitors";
    $firstName = "";
    $lastName = "";
    $formErrorCount = 0;
    
    // Test for form submission
    if (isset($_POST['submit'])) {
        
        
        /* Start of form validation */
        
        $firstName = stripslashes($_POST['firstName']);
        $firstName = trim($_POST['firstName']);
        $lastName = stripslashes($_POST['lastName']);
        $lastName = trim($_POST['lastName']);
        if (empty($firstName) || empty($lastName)) {
            // Leave this error code
            echo "<p>You must enter your first and last <strong>name</strong>.</p>\n";
            ++$formErrorCount;
        }
        
        /* End of form validation */
        
        // Connect to database if there are no form errors
        if ($formErrorCount === 0) {
            $DBConnect = connectToDB($hostName, $userName, $password);
            // Successful connection
            if ($DBConnect) {
                if (selectDB($DBConnect, $DBName)) {
                    if (createTable($DBConnect, $tableName)) {
                        echo "<p>Connection Successful!</p>\n";
                        $sql = "INSERT INTO $tableName VALUES(NULL, '$lastName', '$firstName')";
                        $result = mysqli_query($DBConnect, $sql);
                        if ($result === false) {
                            echo "<p>Unable to execute the query.</p>";
                            // echo "Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>";
                        } else {
                            // Leave this success code
                            echo "<h3>Thank you for siging our guest book!</h3>";
                            $firstName = "";
                            $lastName = "";
                        }
                    }
                }
                // Give back resource
                mysqli_close($DBConnect);
            }
        }
    }
    
    ?>


    <!--  HTML Web Form  -->
    <form action="SignGuestBook.php" method="post">
        <!--   First Name Field    -->
        <p><strong>First Name:</strong><br>
            <input type="text" name="firstName" value="<?php echo $firstName; ?>">
        </p>
        <!--   Last Name Field    -->
        <p><strong>Last Name:</strong><br>
            <input type="text" name="lastName" value="<?php echo $lastName; ?>">
        </p>
        <!--   Submit Button    -->
        <p>
            <input type="submit" name="submit" value="Submit">
        </p>
    </form>

    <?php
    $DBConnect = connectToDB($hostName, $userName, $password);
    if ($DBConnect) {
        if (selectDB($DBConnect, $DBName)) {
            if (createTable($DBConnect, $tableName)) {
                echo "<p>Connection Successful!</p>\n";
                echo "<h2>Visitors Log</h2>";
                $sql = "SELECT * FROM $tableName";
                $result = mysqli_query($DBConnect, $sql);
                if (mysqli_num_rows($result) == 0) {
                    echo "<p>There are no entries in the quest book!</p>";
                } else {
                    echo "<table width='60%' border='1'>";
                    echo "<tr>";
                    echo "<th>Visitor</th>";
                    echo "<th>First Name</th>";
                    echo "<th>Last Name</th>";
                    echo "</tr>";
                    while ($row = mysqli_fetch_row($result)) {
                        echo "<tr>";
                        echo "<td width='10%' style='text-align: center'>$row[0]</td>";
                        echo "<td>$row[1]</td>";
                        echo "<td>$row[2]</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    mysqli_free_result($result);
                }
            }
        }
        mysqli_close($DBConnect);
    }
    ?>

</body>

</html>
