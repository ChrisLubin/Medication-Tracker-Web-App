<?php
    include("config.php");

    // All parameters were not set
    if(!(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['password']) && isset($_POST['isDoc']))) {
        http_response_code(400); // Bad request http status
        $db->close();
        exit();
    }

    $fname = mysqli_real_escape_string($db, $_POST['fname']);
    $lname = mysqli_real_escape_string($db, $_POST['lname']);
    $email = strtolower(mysqli_real_escape_string($db, $_POST['email']));
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $isDoc = mysqli_real_escape_string($db, $_POST['isDoc']);
    $hash = password_hash($password, PASSWORD_BCRYPT);

    $sql = "SELECT * FROM Users WHERE email = '$email'";
    $result = mysqli_query($db, $sql);

    // Email already exists in database
    if($result->num_rows != 0){
        http_response_code(409); // Conflict error http status
        $db->close();
        exit();
    }
    
    $sql = "INSERT INTO Users (email, password, firstName, lastName, phone, isDoc) VALUES ('$email', '$hash', '$fname', '$lname', $phone, $isDoc)";
    $db->query($sql);
    $db->close();
?>