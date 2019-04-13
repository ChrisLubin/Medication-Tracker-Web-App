<?php
  session_start();

  if(!isset($_SESSION['email'])) {
    header('Location: login.html');
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="css/calendar.css">
  <title>Calendar</title>
</head>

<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Team Overload</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li><a class="nav-link" href="index.php">
              <h4>Home</h4>
            </a></li>
          <li><a class="nav-link active" href="#">
              <h4>Calendar</h4>
            </a></li>
          <li><a class="nav-link" href="#">
              <h4>Prescriptions</h4>
            </a></li>
          <li><a class="nav-link" href="#">
              <h4>Appointments</h4>
            </a></li>
          <li><a id="logout" class="nav-link" href="login.html">
              <h4>Logout</h4>
            </a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12">
        <!-- Button to open create modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
          <i class="glyphicon glyphicon-plus"></i> Create an event
        </button>
        <hr class="featurette-divider">
      </div>
    </div>
    <!-- The calendar -->
    <div class="row">
      <div class="col-xs-12">
        <div id="calendar"></div>
      </div>
    </div>
  </div>
  <!-- Create modal -->
  <div id="modal-create" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Create an event</h4>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-xs-12">
                <!-- Create form -->
                <form id="form-create" class="form">
                  <input type="text" placeholder="From" class="start form-control dtp">
                  <input type="text" placeholder="Duration (In Hours)" class="duration form-control">
                  <input type="text" placeholder="Title" class="title form-control">
                  <textarea placeholder="Content" class="content form-control"></textarea>
                  <input type="text" placeholder="Category" class="category form-control">
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
    </div>
  </div>
  <!-- Update and delete modal -->
  <div id="modal-update" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Update an event</h4>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-xs-12">
                <!-- Update form -->
                <form id="form-update" class="form">
                  <input type="hidden" class="_id">
                  <input type="hidden" class="_rev">
                  <input type="text" placeholder="From" class="start form-control dtp">
                  <input type="text" placeholder="Duration (In Hours)" class="duration form-control">
                  <input type="text" placeholder="Title" class="title form-control">
                  <textarea placeholder="Content" class="content form-control"></textarea>
                  <input type="text" placeholder="Category" class="category form-control">
                  <!-- Update button -->
                  <button type="submit" class="btn btn-warning">
                    <i class="glyphicon glyphicon-pencil"></i> Update
                  </button>
                  <!-- Update button -->
                  <button type="button" class="btn btn-danger pull-right delete">
                    <i class="glyphicon glyphicon-trash"></i> Delete
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.18/jquery.touchSwipe.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
  <script src="js/calendarSrc.js"></script>
  <script src="js/calendar.js"></script>
</body>

</html>