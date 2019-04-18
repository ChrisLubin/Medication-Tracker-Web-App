<?php
    include("php/config.php");
    if (!isset($_SESSION)) {session_start();}

    if (!isset($_SESSION['email'])) {
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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Custom styles for this template -->
        <link href="css/cover.css" rel="stylesheet">
        <link href="css/appointments.css" rel="stylesheet">
    </head>

    <body class="text-center" style="background-image: url(images/doctor1.jpg); background-repeat: no-repeat; background-size: cover; background-position: center center;">
        <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
            <header class="masthead mb-5">
                <div class="inner">
                    <!-- Add logo here -->
                    <h3 class="masthead-brand">Team Overload</h3>
                    <nav class="nav nav-masthead justify-content-center">
                        <a class="nav-link" href="index.php">Home</a>
                        <a class="nav-link" href="calendar.php">Calendar</a>
                        <a class="nav-link" href="#">Prescriptions</a>
                        <a class="nav-link active" href="#">Appointments</a>
                        <a class='nav-link' id='logout' href='#'>Logout</a>
                    </nav>
                </div>
            </header>

            <div class="card text-center text-primary mt-5">
                <div class="card-header">
                  <ul class="nav nav-pills card-header-pills">
                    <li class="nav-item">
                      <a class="nav-link active" id="createAppointment" href="#">Create Appointment</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link inactive" id="viewAppointments" href="#">View Appointments</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                    <div id="create">
                        <div class="form-group">
                            <input type="email" class="start form-control dtp" id="from" aria-describedby="emailHelp" placeholder="From">
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="duration" placeholder="Duration (In Hours)">
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="title" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="content" placeholder="Content"></textarea>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="doctor" placeholder="Content">
                                <option selected value disabled>Please select your doctor</option>
                                <?php
                                    $sql = mysqli_query($db, "SELECT lastName FROM Users WHERE isDoc = 1");
                                    while($results = mysqli_fetch_object($sql)) {
                                        $doctor=$results->lastName;
                                        echo "<option>Dr. $doctor</option>";
                                    }
                                    // Don't close db here
                                ?>
                        </div>
                        <div class="form-group">
                            <input id="createBtn" type="submit" class="btn btn-primary mt-4" value="Create">
                        </div>
                    </div>
                    <div id="view" class="mt-4">
                        <div class="row">
                                <div class="col-4">
                                    <div class="list-group" id="list-tab" role="tablist">
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="tab-content" id="nav-tabContent">
                                    </div>
                                </div>
                        </div>
                    </div>
              </div>
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
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
        <script src="js/calendarSrc.js"></script>
        <script src="js/appointments.js"></script>
    </body>

</html>