<?php
  include("config.php");

  // All parameters were not set
  if (!isset($_POST['id'])) {
    http_response_code(400); // Bad request http status
    $db->close();
    exit();
}

  $id = mysqli_real_escape_string($db, $_POST['id']);
  $email = $_SESSION['email'];

  $sql = "DELETE FROM Calendar WHERE id = '$id' AND email = '$email'";

  if ($db->query($sql) != TRUE) {
    http_response_code(500); // Server error
    $db->close();
    exit();
  }

  $db->close();
?>