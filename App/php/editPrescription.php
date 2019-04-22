<?php
  include("config.php");
  if (!isset($_SESSION)) {session_start();}
  
  // All parameters were not set
  if(!(isset($_POST['prescription']) && isset($_POST['instructions']) && isset($_POST['dosage']) && isset($_POST['oldPrescription']) && isset($_POST['email']))) {
    http_response_code(400); // Bad request http status
    $db->close();
    exit();
  }

  $prescription = mysqli_real_escape_string($db, $_POST['prescription']);
  $instructions = mysqli_real_escape_string($db, $_POST['instructions']);
  $dosage = mysqli_real_escape_string($db, $_POST['dosage']);
  $oldPresciption = mysqli_real_escape_string($db, $_POST['oldPrescription']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $adderEmail = $_SESSION['email'];

  if ($_SESSION['isDoc']) {
    $sql = "UPDATE Prescription SET prescription = '$prescription', instruction = '$instructions', dosage = '$dosage' WHERE doctor = '$adderEmail' AND prescription = '$oldPresciption' AND patient = '$email'";
  } else {
    $sql = "UPDATE Prescription SET prescription = '$prescription', instruction = '$instructions', dosage = '$dosage' WHERE doctor = '$email' AND prescription = '$oldPresciption' AND patient = '$adderEmail'";
  }

  if ($db->query($sql) != TRUE) {
    http_response_code(500); // Server error
    $db->close();
    exit();
  }

  $db->close();
?>