<?php
    include("php/config.php");
    if (!isset($_SESSION)) {session_start();}

    if (!isset($_SESSION['email'])) {
        header('Location: login.html');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Medication Tracker App</title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!-- Custom styles for this template -->
        <link href="css/profile.css" rel="stylesheet">
    </head>

<!--    <body class="text-center" style="background-color: #D8E9F4;">-->
    <body class="text-center" style="background-image: url(images/bg.jpg); background-repeat: no-repeat; background-size: cover; background-position: center center;">
        <div class="cover-container d-flex w-100 h-100 pt-3 mx-auto flex-column">
            <div class="cover-container masthead">
                <header class="masthead mb-auto">
                    <div class="inner">
                        <!-- Add logo here -->
                        <h3 class="masthead-brand">Team Overload</h3>
                        <nav class="nav nav-masthead justify-content-center">
                            <a class="nav-link" href="index.php">Home</a>
                            <a class="nav-link" href="calendar.php">Calendar</a>
                            <a class="nav-link" href="prescriptions.php">Prescriptions</a>
                            <a class="nav-link" href="appointments.php">Appointments</a>
                            <?php
                            if(!isset($_SESSION['email'])) {
                                echo "<a class='nav-link' href='login.html'>Login</a>
                              <a class='nav-link' href='register.html'>Register</a>";
                            } else {
                                
                                $email = $_SESSION['email'];
                                
                                // If a doctor
                                if($_SESSION['isDoc']) {
                                    echo "<a class='nav-link active' href='doctor.php'>Profile</a>";
                                } else {
                                    echo "<a class='nav-link active' href='patient.php'>Profile</a>";
                                }
                                echo "<a id='logout' class='nav-link' href='#'>Logout</a>";
                            }
                            ?>
                        </nav>
                    </div>
                </header> <!-- end header -->
            </div>
            
            <div class="row p-3">
                <?php
                    if(!isset($_SESSION['email'])) {
                        echo "<h4 class='d-flex'> Patient Name </h4>";
                    } else {
                        echo "<h4 class='d-flex'>";
                        echo $_SESSION['fullName']; 
                        echo "</h4>";
                    }
                ?>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <ul class="list-group">
                        <li class="list-group-item text-muted">
                            <img class="card-img-top" src="images/person.png" alt="Patient User Image">
                        </li>
                        <li class="list-group-item text-muted">
                            <p>Total Prescriptions:</p>
                            <p><?php
                                    $sql = "SELECT prescription FROM Prescription WHERE patient = '$email'"; 
                                    $result = mysqli_query($db, $sql);
                                    
                                    $counter = 0;
                                    while($results = mysqli_fetch_object($result)) {
                                        $counter = $counter + 1;
                                    }
                                    
                                    echo "
                                                <span class='badge badge-light'>
                                    ";
                                    echo $counter;
                                    echo "
                                            </span>
                                            <p>
                                                <a role='button' class='btn btn-info pt-1' href='prescriptions.php'>View</a>
                                            </p>
                                    ";
                            ?>
                            </p>
                        </li>
                        
                        <?php
                                $sql = "SELECT title FROM Calendar WHERE email = '$email' AND category LIKE 'Appointment%' ORDER BY start DESC"; 
                                $result = mysqli_query($db, $sql);
                                
                                $counter = 0;
                                while($results = mysqli_fetch_object($result)) {
                                    $counter = $counter + 1;
                                }
                                
                                echo "
                                    <li class='list-group-item text-muted'>
                                        <p>Appointments: 
                                            <span class='badge badge-light'>
                                ";
                                echo $counter;
                                echo "
                                        </span>
                                        </p>
                                        <p>
                                            <a role='button' class='btn btn-info pt-1' href='appointments.php'>View</a>
                                        </p>
                                    </li>
                                ";
                        ?>
                        
                    </ul>
                </div> <!-- end column 1 -->
                <div class="col-sm-9">
                    <div class="card w-200">
                        <div class="card-header">
                            <h4 class="d-flex">Your Medications</h4>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <p class="text-muted text-left">Need to update your prescriptions? Don't worry!</p>
                                <p class="text-muted text-left">
                                    <a role="button" class="btn btn-info" href="prescriptions.php">Add or edit your prescriptions here!</a>
                                </p>
                            </li>
                        </ul>
                    </div> <!-- end medication list -->
                </div> <!-- end column 2 -->
            </div>
            
            <?php
                $db->close();
            ?>

            <footer class="mastfoot mt-auto">
                <!--
<div class="inner">
<p>Cover template for <a href="https://getbootstrap.com/">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
</div>
-->
            </footer>
        </div>

        <!-- Bootstrap -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="js/index.js"></script>
    </body>

</html>