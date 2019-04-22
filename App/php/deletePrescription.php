<?php
  include("config.php");
  if (!isset($_SESSION)) {session_start();}
  
  // All parameters were not set
  if(!(isset($_POST['prescription']) && isset($_POST['email']))) {
    http_response_code(400); // Bad request http status
    $db->close();
    exit();
  }

  $prescription = mysqli_real_escape_string($db, $_POST['prescription']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $adderEmail = $_SESSION['email'];

  if ($_SESSION['isDoc']) {
    $sql = "DELETE FROM Prescription WHERE prescription = '$prescription' AND doctor = '$adderEmail' AND patient = '$email'";
  } else {
    $sql = "DELETE FROM Prescription WHERE prescription = '$prescription' AND doctor = '$email' AND patient = '$adderEmail'";
  }

  if ($db->query($sql) != TRUE) {
    http_response_code(500); // Server error
    $db->close();
    exit();
  }

  $db->close();
?>