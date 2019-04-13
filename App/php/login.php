<?php
    include("config.php");

    // All parameters were not set
    if(!(isset($_POST['email']) && isset($_POST['password']))) {
        http_response_code(400); // Bad request http status
        $db->close();
        exit();
    }

    $email = strtolower(mysqli_real_escape_string($db, $_POST['email']));
    $password = mysqli_real_escape_string($db, $_POST['password']);

    $sql = "SELECT isDoc, password FROM Users WHERE email = '$email'";
    $result = mysqli_query($db, $sql);

    // Wrong email
    if($result->num_rows != 1){
        http_response_code(401); // Conflict error http status
        $db->close();
        exit();
    }

    $results = mysqli_fetch_object($result);
    $passwordHash = $results->password;
    
    // Wrong password
    if(!password_verify($password, $passwordHash)) {
        http_response_code(401); // Conflict error http status
        $db->close();
        exit();
    }

    session_start();

    $_SESSION['email'] = $email;
    $_SESSION['isDoc'] = $results->isDoc;
    
    $db->close();
?>