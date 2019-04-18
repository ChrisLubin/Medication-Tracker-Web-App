<?php
  include("config.php");
  if (!isset($_SESSION)) {session_start();}

  // All parameters were not set
  if(!(isset($_POST['id']) && isset($_POST['start']) && isset($_POST['duration']) && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['category']))) {
    http_response_code(400); // Bad request http status
    $db->close();
    exit();
}

  $id = mysqli_real_escape_string($db, $_POST['id']);
  $email = $_SESSION['email'];
  $start = mysqli_real_escape_string($db, $_POST['start']);
  $duration = mysqli_real_escape_string($db, $_POST['duration']);
  $title = mysqli_real_escape_string($db, $_POST['title']);
  $content = mysqli_real_escape_string($db, $_POST['content']);
  $category = mysqli_real_escape_string($db, $_POST['category']);

  $sql = "INSERT INTO Calendar (id, email, start, duration, title, content, category)
  VALUES('$id', '$email', $start, $duration, '$title', '$content', '$category')";

  if ($db->query($sql) != TRUE) {
    http_response_code(500); // Server error
    $db->close();
    exit();
  }

  $db->close();
?>