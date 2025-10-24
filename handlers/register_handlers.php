<?php include '../config/db_connect.php';?>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $fullname=$_POST['fname'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    echo"Full Name".$fullname." Email ".$email." Password ".$password."<br>";
}
else{
    echo"Connection Failed";
}
?>
