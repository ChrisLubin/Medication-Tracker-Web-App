<?php
  include("config.php");
  session_start();

  $email = $_SESSION['email'];

  $sql = "SELECT id, start, duration, title, content, category FROM Calendar WHERE email = '$email'";
  $result = mysqli_query($db, $sql);
  $rows = array();

  if (mysqli_num_rows($result) == 0) {
    // No rows returned
    http_response_code(204); // No content
    $db->close();
    exit();
  }

  while($r = mysqli_fetch_assoc($result)) {
    $rows[] = $r;
  }

  echo json_encode($rows, JSON_PRETTY_PRINT);
  http_response_code(200); // OK
  
  $db->close();
?>