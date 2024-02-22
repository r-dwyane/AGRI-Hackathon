<?php
session_start();
include "connection.php";

if(isset($_POST['contact_no']) && isset($_POST['password'])){
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $contact_no = validate($_POST['contact_no']);
    $password = validate($_POST['password']);

    $sql = "SELECT * FROM farmers WHERE contact_no= '$contact_no' AND password= '$password'";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) > 0){
        $_SESSION['contact_no'] = $contact_no;
        header("Location: HOME.php"); 
    } else {
       echo "<script> alert('INVALID CREDENTIALS') </script>";
       header("Location: login.php");
    }
} else {
    echo "Hello";
}$_SESSION['contact_no'] = $contact_no;
?>
