<!DOCTYPE html>
<html lang="en">

<head>
    <!-- 
     Author: Gabriel Ortega
     Date: 11.6.18
     
     filename: InterviewCandidates.php
     -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Interview Candidates </title>
    <link href="InterviewCandidates.css" rel="stylesheet">
</head>

<body>

    <?php
    // Entry for errors and processing
    // Test if data was submitted
    if (isset($_POST['submit'])) {
        // Global Variables
        $interviewerFName = stripslashes($_POST['interviewerFName']);  
        $interviewerLName = stripslashes($_POST['interviewerLName']);  
        $interviewerPosition = stripslashes($_POST['interviewerPosition']);  
        $date = stripslashes($_POST['date']);  
        $candidateFName = stripslashes($_POST['candidateFName']);  
        $candidateLName = stripslashes($_POST['candidateLName']);  
        $comms = stripslashes($_POST['comms']);  
        $appearance = stripslashes($_POST['appearance']);  
        $compSkills = stripslashes($_POST['compSkills']);  
        $businessKnowledge = stripslashes($_POST['businessKnowledge']);  
        $interviewerComments = stripslashes($_POST['interviewerComments']);
        
        // Database variables
        $hostName = "localhost";
        $userName = "adminer";
        $password = "quiet-Texas-16";
        $DBName = "interviews";
        $tableName = "candidates";
        $formErrorCount = 0;
        
        function connectToDB($hostName, $userName, $password) {
        $DBConnect = mysqli_connect($hostName, $userName, $password);
        if (!$DBConnect) {
            // Leave this error
            echo "<p>Connection error: " . mysqli_connect_error() . "</p>\n";
        }
        return $DBConnect;
    }
        
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
        
        // Connect to database if there are no form errors
        if ($formErrorCount === 0) {
            $DBConnect = connectToDB($hostName, $userName, $password);
            // Successful connection
            if ($DBConnect) {
                if (selectDB($DBConnect, $DBName)) {
                    if (createTable($DBConnect, $tableName)) {
                            // echo "<p>Connection Successful!</p>\n";
                            $sql = "INSERT INTO $tableName VALUES(NULL, '$interviewerFName', '$interviewerLName'," .
                                                                  " '$interviewerPosition', '$date', '$candidateFName'," .
                                                                  " '$candidateLName', '$comms', '$appearance'," .
                                                                  " '$compSkills', '$businessKnowledge', '$interviewerComments')";
                            $result = mysqli_query($DBConnect, $sql);
                            if ($result === false) {
                                echo "<p>Unable to execute the query.</p>";
                                // echo "Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>";
                            } else {
                                // Leave this success code
                                echo "<h3>Thank you for submitting your candidate, $interviewerFName!</h3>";
                            }
                        }
                    }
                }
                // Give back resource
                mysqli_close($DBConnect);
            }
        }
    // Connect to database
    // Select database
    // Select table
    // Enter data
    ?>

    <h1 id="interviewHeader">Candidate Interview Form</h1>

    <h2 id="interviewer"><em>Interviewer Section</em></h2>
    <!--  HTML Web Form  -->
    <form action="InterviewCandidates.php" method="post">
    <div id="interviewer">
        <!--  First Name of Interviewer  -->
        <p><strong>First Name of Interviewer: </strong>
            <input type="text" name="interviewerFName"></p>

        <!--  Last Name of Interviewer  <--></-->
        <p><strong>Last Name of Interviewer: </strong>
            <input type="text" name="interviewerLName"></p>

        <!--  Position of Interviewer  -->
        <p><strong>Position of Interviewer: </strong>
            <input type="text" name="interviewerPosition"></p>

        <!--  Date of interview  -->
        <p><strong>Date of Interview: </strong>
            <input type="date" name="date"></p>
    </div>
        <hr>
    <div id="candidate">
        <h2 id="candidate"><em>Candidate Section</em></h2>
        <!--  First Name of Candidate  -->
        <p><strong>First Name of Candidate: </strong>
            <input type="text" name="candidateFName"></p>

        <!--  Last Name of Candidate  -->
        <p><strong>Last Name of Candidate: </strong>
            <input type="text" name="candidateLName"></p>

        <!--  Communication abilities  -->
        <p><strong>Communication: </strong>
            <input type="number" name="comms" max="10" min="0"></p>

        <!--  Professional appearance  -->
        <p><strong>Professional Appearance: </strong>
            <input type="number" name="appearance" max="10" min="0"></p>

        <!--  Computer Skills  -->
        <p><strong>Computer Skills: </strong>
            <input type="number" name="compSkills" max="10" min="0"></p>

        <!--  Business Knowledge  -->
        <p><strong>Business Knowledge: </strong>
            <input type="number" name="businessKnowledge" max="10" min="0"></p>

        <!--  Interviewer Comments  -->
        <p style="margin-bottom: 1px"><strong>Interviewer Comments: </strong></p>
        <textarea name="interviewerComments" rows="4" cols="60" style="margin-top: 0px; resize: none;"></textarea>
    </div>
        <!--  Submit Button  -->
        <input type="submit" name="submit" value="Submit Candidate"><br><br>
    </form>

    <a href="ShowCandidates.php">Show Submitted Candidates</a>

</body>

</html>
