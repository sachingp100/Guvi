<?php

$email = $_POST['email'];
$password = $_POST['password'];

$serverName = 'localhost';
$userName = 'root';
$mysql_password = '';

$conn = new mysqli($serverName, $userName, $mysql_password, "register");


if ($conn) {
    $sql = "select * from user where email = '$email'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        if (password_verify($password, $row['password']))
            // echo 'success';
            echo json_encode((array('status' => true, 'uid' => $email)));
        else
            echo json_encode((array('status' => false, 'msg' => 'invalid password')));
    } else {
        // echo 'invalid credentials';
        echo json_encode((array('status' => false, 'msg' => 'invalid credentials')));
    }
} else {
    die('not connected' . mysqli_connect_error());
}
