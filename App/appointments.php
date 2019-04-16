<?php
session_start();
include("php/config.php");

if(!isset($_SESSION['email'])) {
    header('Location: login.html');
    exit();
}
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>Medication Tracker App</title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!-- Custom styles for this template -->
        <link href="css/cover.css" rel="stylesheet">
        <link href="css/appointments.css" rel="stylesheet">
    </head>

    <body class="text-center" style="background-image: url(images/doctor1.jpg); background-repeat: no-repeat; background-size: cover; background-position: center center;">
        <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
            <header class="masthead mb-auto">
                <div class="inner">
                    <!-- Add logo here -->
                    <h3 class="masthead-brand">Team Overload</h3>
                    <nav class="nav nav-masthead justify-content-center">
                        <a class="nav-link" href="index.php">Home</a>
                        <a class="nav-link" href="calendar.php">Calendar</a>
                        <a class="nav-link" href="#">Prescriptions</a>
                        <a class="nav-link active" href="#">Appointments</a>
                        <?php
                        if(!isset($_SESSION['email'])) {
                            echo "<a class='nav-link' href='login.html'>Login</a>
                          <a class='nav-link' href='register.html'>Register</a>";
                        } else {
                            echo "<a id='logout' class='nav-link' href='#'>Logout</a>";
                        }
                        ?>
                    </nav>
                </div>
            </header>

            <!-- <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1> -->
            <div class="tab">
                <button class="tablinks" onclick="appt(event, 'createAppt')" id="defaultOpen">Create Appointment</button>
                <button class="tablinks" onclick="appt(event, 'viewAppt')">View Appointments</button>

            </div>
            <div id="createAppt" class="tabcontent">
                <h3>Please fill out form below.</h3>
                <div id="modal-create" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <!-- Create form -->
                                <form id="form-create" class="form">
                                    <input type="text" placeholder="From" class="start form-control dtp">
                                    <input type="text" placeholder="Duration (In Hours)" class="duration form-control">
                                    <input type="text" placeholder="Title" class="title form-control">
                                    <textarea placeholder="Content" class="content form-control"></textarea>
                                    <input type="text" placeholder="Appointment" value="Appointment" class="category form-control">
                                    <!-- Temporary -->
                                    <label>Select Doctor</label>
                                    <?php
                                    $sql = mysqli_query($db, "SELECT lastName FROM Users WHERE isDoc = 1")or die(mysql_error());
                                    echo '<select name="Doctor" class="category form-control">';
                                    while($results = mysqli_fetch_object($sql))
                                    {
                                        $doctor=$results->lastName;
                                        echo '<option value="'.$doctor.'">'.$doctor.'</option>';
                                        
                                    }
                                    echo '</select>';
                                    //don't close db here
                                    ?>

                                    <!-- Create button -->
                                    <button type="submit" class="btn btn-success">
                                        <i class="glyphicon glyphicon-plus"></i> Create
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="viewAppt" class="tabcontent">
                <h3>Appointments</h3>
                <?php
                
                $email = $_SESSION['email'];
                $sql = mysqli_query($db, "SELECT start, title, content FROM Calendar WHERE email = '$email' AND category = 'Appointment'")or die(mysql_error());
                echo  '<table id="Appointments" border="">';
                while($results = mysqli_fetch_object($sql))
                {
                    //start date needs converted to real date
                    $start=$results->start;
                    $title=$results->title;
                    $content=$results->content;

                    echo '<tr>
                    <td>'.$start.'</td>
                    <td>'.$title.'</td>
                    <td>'.$content.'</td>
                    </tr>';

                }
                echo ' </table>  ';
                $db->close();
                ?>
            </div>
            <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>

            <footer class="mastfoot mt-auto">
                <div class="inner">
                    <p>Cover template for <a href="https://getbootstrap.com/">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
                </div>
            </footer>
        </div>


        <!-- Bootstrap -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="js/calendarSrc.js"></script>
        <script src="js/calendar.js"></script>
        <script src="js/appointments.js"></script>
    </body>

</html>