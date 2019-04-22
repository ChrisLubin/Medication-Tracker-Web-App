<?php
  include("config.php");
  if (!isset($_SESSION)) {session_start();}

  // All parameters were not set
  if(!(isset($_POST['prescription']) && isset($_POST['instructions']) && isset($_POST['dosage']) && isset($_POST['email']))) {
    http_response_code(400); // Bad request http status
    $db->close();
    exit();
  }

  $prescription = mysqli_real_escape_string($db, $_POST['prescription']);
  $instructions = mysqli_real_escape_string($db, $_POST['instructions']);
  $dosage = mysqli_real_escape_string($db, $_POST['dosage']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $adderEmail = $_SESSION['email'];
  $adderFname = $_SESSION['firstName'];
  $adderLname = $_SESSION['lastName'];

  if ($_SESSION['isDoc']) {
    $firstName = mysqli_real_escape_string($db, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($db, $_POST['lastName']);

    $sql = "INSERT INTO Prescription (prescription, instruction, dosage, patient, patientFname, patientLname, doctor, doctorLname)
    VALUES('$prescription', '$instructions', '$dosage', '$email', '$firstName', '$lastName', '$adderEmail', '$adderLname')";
  } else {
    $lastName = mysqli_real_escape_string($db, $_POST['lastName']);

    $sql = "INSERT INTO Prescription (prescription, instruction, dosage, patient, patientFname, patientLname, doctor, doctorLname)
    VALUES('$prescription', '$instructions', '$dosage', '$adderEmail', '$adderFname', '$adderLname', '$email', '$lastName')";
  }

  if ($db->query($sql) != TRUE) {
    http_response_code(500); // Server error
    $db->close();
    exit();
  }

  $db->close();
?>