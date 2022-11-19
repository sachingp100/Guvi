<?php

$username = $_POST['username'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$password = $_POST['password'];
$cpassword= $_POST['cpassword'];

$serverName = 'localhost';
$userName = 'root';
$userPassword = '';
$connection = new mysqli($serverName,$userName,$userPassword,"register");


// $email = filter_var($email, FILTER_SANITIZE_EMAIL);
// if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
//     echo"Invalid Email !!";
// }else{
//     $result = mysqli_query($success,"SELECT * FROM `users` WHERE email='$email'");
//     $data = mysqli_num_rows($result);
//     if(($data)==0){
//         $query = "INSERT INTO `users` (`username`,`email`,`password`) VALUES($username, $email, $password)";
//             if($connection->query($query)==TRUE){
//                 echo "Registration successful";
//             }else{
//              echo"Error";
//             }
//     }else{
//         echo "This mail is already registered, Please try another mail...";
//     }
// }

if($connection){
    $hashedPass = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $connection->prepare("INSERT INTO user(username,email,password) values(?, ?, ?)");
    $db_username = $username;
    $db_email = $email;
    $db_password = $hashedPass;

    $stmt->bind_param('sss',$db_username, $db_email, $db_password);
    if($stmt->execute()){
        require_once '../vendor/autoload.php';
        $client = new MongoDB\Client('mongodb://localhost:27017');
        $db = $client->register;
        $collection = $db->user;
        $collection->insertOne(
            [
                'name' => $username,
                'dob' => $dob,
                'gender' =>$gender,
                'contact' =>$contact,
                'email' => $email
            ]
            );
        echo "Account Registered successfully";
    }else{
        echo "Error";
    }
}
else{
        die('not connected' . mysqli_connect_error());
    }

?>
