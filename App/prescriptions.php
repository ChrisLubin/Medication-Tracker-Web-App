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
    <title>Medication Tracker App</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <!--===============================================================================================-->
    <link
      rel="stylesheet"
      type="text/css"
      href="css/prescriptions/animate.css"
    />
    <!--===============================================================================================-->
    <link
      rel="stylesheet"
      type="text/css"
      href="css/prescriptions/select2.min.css"
    />
    <!--===============================================================================================-->
    <link
      rel="stylesheet"
      type="text/css"
      href="css/prescriptions/perfect-scrollbar.css"
    />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/prescriptions/util.css" />
    <link rel="stylesheet" type="text/css" href="css/prescriptions.css" />
    <!--===============================================================================================-->
  </head>

  <body
    class="text-center"
    style="background-image: url(images/doctor1.jpg); background-repeat: no-repeat; background-size: cover; background-position: center center;"
  >
    <header class="masthead mb-auto">
      <div class="inner">
        <!-- Add logo here -->
        <nav class="nav nav-masthead justify-content-center">
          <h3 class="masthead-brand">Team Overload</h3>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <a class="nav-link" href="index.php">Home</a>
          <a class="nav-link" href="calendar.php">Calendar</a>
          <a class="nav-link active" href="prescriptions.php">Prescriptions</a>
          <?php
                        if (!isset($_SESSION)) {session_start();}

                        if (!$_SESSION['isDoc']) {
                            echo "<a class='nav-link' href='appointments.php'>Appointments</a>
                            <a class='nav-link' href='patient.php'>Profile</a>";
                        }
                    ?>
          <a class="nav-link" id="logout" href="#">Logout</a>
        </nav>
      </div>
    </header>

    <?php
      $email = $_SESSION['email'];

      if ($_SESSION['isDoc']) {
        echo '    <!-- Table and Contents -->
        <div>
          <div>
            <div class="d-flex flex-row justify-content-center mt-4">
              <div class="wrap-table100">
                <div class="form-group row ml-0">
                  <select id="patients" class="custom-select mr-sm-2 col-3">
                    <option value="blank">Chooose Patient</option> ';
                    $sql = mysqli_query($db, "SELECT DISTINCT patientFname, patientLname, patient FROM Prescription WHERE doctor = '$email' ORDER BY patientFname DESC");
                    while($results = mysqli_fetch_object($sql)) {
                      $email = $results->patient;
                      $fname = $results->patientFname;
                      $lname = $results->patientLname;
                      echo "<option id='$email'>$fname $lname</option>";
                    }
                    // Don't close db here
                    echo "</select>";

        echo '
                  </select>
                </div>
                <div class="table100 ver1 m-b-110">
                  <div class="table100-head">
                    <table>
                      <thead>
                        <tr class="row100 head">
                          <th class="cell100 column1">Prescriptions</th>
                          <th class="cell100 column2">Instructions</th>
                          <th class="cell100 column3">Dosage</th>
                          <th class="cell100 column5">
                            <button
                              type="button"
                              class="btn btn-success btn-sm"
                              data-toggle="modal"
                              data-target=".bd-example-modal-sm"
                              id="add"
                            >
                              <i class="fa fa-plus"></i> Add New
                            </button>
                          </th>
                        </tr>
                      </thead>
                    </table>
                  </div>
    
                  <div class="table100-body js-pscroll">
                    <table id="rows">
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>';
      } else {
        echo '    <!-- Table and Contents -->
        <div>
          <div>
            <div class="d-flex flex-row justify-content-center mt-4">
              <div class="wrap-table100 mt-5">
                <div class="table100 ver1 m-b-110">
                  <div class="table100-head">
                    <table>
                      <thead>
                        <tr class="row100 head">
                          <th class="cell100 column1">Prescriptions</th>
                          <th class="cell100 column2">Instructions</th>
                          <th class="cell100 column3">Dosage</th>
                          <th class="cell100 column4">Doctor</th>
                          <th class="cell100 column5">
                            <button
                              type="button"
                              class="btn btn-success btn-sm"
                              data-toggle="modal"
                              data-target=".bd-example-modal-sm"
                              id="add"
                            >
                              <i class="fa fa-plus"></i> Add New
                            </button>
                          </th>
                        </tr>
                      </thead>
                    </table>
                  </div>
    
                  <div class="table100-body js-pscroll">
                    <table id="rows">
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>';
      }
    ?>

    <!-- Small modal for Add button -->
    <div
      class="modal fade bd-example-modal-sm"
      tabindex="-1"
      role="dialog"
      aria-labelledby="mySmallModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Prescription</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="recipient-name">Prescriptions</label>
                <input type="text" class="form-control" id="prescription" />
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label"
                  >Instructions</label
                >
                <textarea
                  class="form-control"
                  row="5"
                  id="instructions"
                ></textarea>
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label"
                  >Dosage</label
                >
                <input type="text" class="form-control" id="dosage" />
              </div>
                <?php
                  $email = $_SESSION['email'];

                  if ($_SESSION['isDoc']) {
                    echo "<div class='form-group'>
                    <label for='recipient-name' class='col-form-label'
                      >Patient</label
                    ></div>
                    <select id='email' class='form-control'>
                    <option selected value disabled>Please select your patient</option>";
                    $sql = mysqli_query($db, "SELECT email, firstName, lastName FROM Users WHERE isDoc = 0");
                    while($results = mysqli_fetch_object($sql)) {
                      $email = $results->email;
                      $fname = $results->firstName;
                      $lname = $results->lastName;
                      echo "<option id='$email'>$fname $lname</option>";
                    }
                    // Don't close db here
                    echo "</select>";
                  } else {
                    echo "<div class='form-group'>
                    <label for='recipient-name' class='col-form-label'
                      >Doctor</label
                    ></div>
                    <select id='email' class='form-control'>
                    <option selected value disabled>Please select your doctor</option>";
                    $sql = mysqli_query($db, "SELECT email, lastName FROM Users WHERE isDoc = 1");
                    while($results = mysqli_fetch_object($sql)) {
                      $email = $results->email;
                      $lname = $results->lastName;
                      echo "<option id='$email'>Dr. $lname</option>";
                    }
                    // Don't close db here
                    echo "</select>";
                  }
                ?>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button id="addPrescription" type="button" class="btn btn-primary" data-dismiss="modal">
              Add
            </button>
          </div>
        </div>
      </div>
    </div>

        <!-- Small modal for Edit button -->
        <div
      class="modal fade bd-example-modal-smm"
      tabindex="-1"
      role="dialog"
      aria-labelledby="mySmallModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Prescription</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="recipient-name">Prescriptions</label>
                <input type="text" class="form-control" id="editPrescription" />
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label"
                  >Instructions</label
                >
                <textarea
                  class="form-control"
                  row="5"
                  id="editInstructions"
                ></textarea>
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label"
                  >Dosage</label
                >
                <input type="text" class="form-control" id="editDosage" />
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button id="edit" type="button" class="btn btn-primary" data-dismiss="modal">
              Edit
            </button>
          </div>
        </div>
      </div>
    </div>

    <!--Modal code for detele buttons-->
    <div
      class="modal fade"
      id="deleteModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete this patient's medication.
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button id="delete" type="button" class="btn btn-primary" data-dismiss="modal">
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>

    <!--===============================================================================================-->
    <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!--===============================================================================================-->
    <script src="js/prescriptions/perfect-scrollbar.min.js"></script>
    <!--===============================================================================================-->
    <script src="js/prescriptions.js"></script>
  </body>
</html>
