<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Medication Tracker App</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="css/cover.css" rel="stylesheet">
</head>

<body class="text-center" style="background-image: url(images/doctor1.jpg); background-repeat: no-repeat; background-size: cover; background-position: center center;">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <header class="masthead mb-auto">
            <div class="inner">
                <!-- Add logo here -->
                <h3 class="masthead-brand">Team Overload</h3>
                <nav class="nav nav-masthead justify-content-center">
                    <a class="nav-link active" href="#">Home</a>
                    <a class="nav-link" href="calendar.php">Calendar</a>
                    <a class='nav-link' href='prescriptions.php'>Prescriptions</a>
                    <?php
                        if (!isset($_SESSION)) {session_start();}

                        if (!isset($_SESSION['email'])) {
                            echo "<a class='nav-link' href='appointments.php'>Appointments</a>
                            <a class='nav-link' href='login.html'>Login</a>
                            <a class='nav-link' href='register.html'>Register</a>";
                        } else {
                            if ($_SESSION['isDoc']) {
                                echo "<a id='logout' class='nav-link' href='#'>Logout</a>";
                            } else {
                                echo "<a class='nav-link' href='appointments.php'>Appointments</a>
                                <a class='nav-link' href='patient.php'>Profile</a>
                                <a id='logout' class='nav-link' href='#'>Logout</a>";
                            }
                        }
                    ?>
                </nav>
            </div>
        </header>

        <main role="main" class="inner cover">
            <h1 class="cover-heading">Med Tracker</h1>
            <p class="lead">Easily keep track of any medication. Get notifications of scheduled prescriptions. Have real doctors help you with prescriptions too!</p>
            <p class="lead">
                <a href="#" class="btn btn-lg btn-secondary">Learn more</a>
            </p>
        </main>

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
    <script src="js/index.js"></script>
</body>

</html>