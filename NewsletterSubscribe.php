<!DOCTYPE html>
<html lang="en">

<head>
    <!-- 
    Author: Gabriel Ortega
    Date: 11.1.18
    
    Filename: NewsletterSubscribe.php
    -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Newsletter Subscribe</title>
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>

    <h2>Newsletter Subscribe</h2>
    <?php
    $hostName = "localhost";
    $userName = "adminer";
    $password = "quiet-Texas-16";
    $DBName = "newsletter2";
    $tableName = "subscribers";
    $subscriberName = "";
    $subscriberEmail = "";
    $showForm = false;
    // Check if we got to the form by submission
    if (isset($_POST['submit'])) {
        $formErrorCount = 0;
        // Start of form validation
        
        /* Validation for Name */
        
        if (!empty($_POST['subName'])) {
            // Success
            $subscriberName = stripslashes($_POST['subName']);
            // Get rid of unnecessary white spaces
            $subscriberName = trim($subscriberName);
            // Check if, after trimming and stripping slashes, the field is empty
            if (strlen($subscriberName) === 0) {
                ++$formErrorCount;
                echo "<p>Must include your <strong>name</strong>!</p>\n";
            }
        } else {
            // Failure
            ++$formErrorCount;
            echo "<p>Form submittal error, no <strong>name</strong> field!</p>\n";
        }
        
        /* End of Validation for Name */
        
        /* Validation for Email */
        
        if (!empty($_POST['subEmail'])) {
            // Success
            $subscriberEmail = stripslashes($_POST['subEmail']);
            // Get rid of unnecessary white spaces
            $subscriberEmail = trim($subscriberEmail);
            // Check if, after trimming and stripping slashes, the field is empty
            if (strlen($subscriberEmail) === 0) {
                ++$formErrorCount;
                echo "<p>Must include your <strong>email</strong>!</p>\n";
            }
        } else {
            // Failure
            ++$formErrorCount;
            echo "<p>Form submittal error, no <strong>email</strong> field!</p>\n";
        }
        
        /* End of Validation for Email */
        
        
        if ($formErrorCount == 0) {
            $showForm = false;
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
                    $subscriberDate = date("Y-m-d");
                    // SQL Query
                    $sql = "INSERT INTO $tableName (name, email, subscribeDate)" .
                            " VALUES ('$subscriberName', '$subscriberEmail', '$subscriberDate')";
                    $result = mysqli_query($DBConnect, $sql);
                    // Check if query went wrong
                    if (!$result) {
                        // Failure
                        echo "<p>Unable to insert the values into the <strong>$tableName</strong>" .
                             " table.</p>\n";
                    } else {
                        // Success
                        $subscriberID = mysqli_insert_id($DBConnect);
                        echo "<p><strong>" . htmlentities($subscriberName) . "</strong>, you are now subscribed to our newsletter.<br>";
                        echo "Your subscriber ID is <strong>" . $subscriberID . "</strong>.<br>";
                        echo "Your email address is <strong>" . htmlentities($subscriberEmail) . "</strong></p>";
                    }
                } else {
                    echo "<p>Could not select the \"$DBName\" database: " . mysqli_error($DBConnect) . "</p>\n";
                }
                // Return Resource
                mysqli_close($DBConnect);
            } 
        } else {
                $showForm = true;
        }
    } else {
        // If data was not submitted, show form to ask for data
        $showForm = true;
    }
    if ($showForm) {
    ?>

    <!--  HTML All-In-One Form  -->
    <form action="NewsletterSubscribe.php" method="post">
        <!--   Name Field    -->
        <p><strong>Your Name: </strong><br>
            <!--     PHP embedded to create a sticky field      -->
            <input type="text" name="subName" value="<?php echo $subscriberName; ?>">
        </p>
        <!--   Name Field    -->
        <p><strong>Your Email Address: </strong><br>
            <!--     PHP embedded to create a sticky field      -->
            <input type="text" name="subEmail" value="<?php echo $subscriberEmail; ?>">
        </p>
        <!--    Submit Button    -->
        <p><input type="submit" name="submit" value="Submit"></p>
    </form>



</body>

</html>


<?php
    }
    ?>
