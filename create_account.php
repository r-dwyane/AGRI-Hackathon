<?php 
include "connection.php";

session_start(); 

if(isset($_POST["submit"])){
    $fname = $_POST["first_name"];
    $lname = $_POST["last_name"];
    $contact_no = $_POST["contact_no"];
    $password = $_POST["password"];

    $select = "SELECT contact_no FROM farmers WHERE contact_no = ?";
    $stmt_select = mysqli_prepare($con, $select);
    mysqli_stmt_bind_param($stmt_select, "s", $contact_no);
    mysqli_stmt_execute($stmt_select);
    $result_select = mysqli_stmt_get_result($stmt_select);

    if($row = mysqli_fetch_assoc($result_select)){
        echo "<script>alert('Contact Number already exists.')</script>";
    } else {
        $sql = "INSERT INTO farmers (contact_no, password, f_name, l_name) VALUES (?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt_insert, "ssss", $contact_no, $password, $fname, $lname);
        
        if(mysqli_stmt_execute($stmt_insert)){
            $_SESSION['success_message'] = "Created Account Successfully.";
            header("Location: login.php");
            exit(); 
        } else {
            echo "Error: " . mysqli_error($con);
        }
       
    }

}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="create_account.css"/>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <title>Create Account</title>
    </head>
    <body>
        <main>
            <div class="create_container">
                <h1>Create Account</h1>
                <form class="form" action="" method="post">
                    <div class="first-last_name">
                        <label for="first_name">
                            <input id="first_name" type="text" name="first_name" placeholder="First name" required/>
                        </label>
                        <label for="last_name">
                            <input id="last_name" type="text" name="last_name" placeholder="Last name" required/>
                        </label>
                    </div> 
                    <label for="contact_number">
                        <input id="contact_number" name="contact_no" placeholder="Contact Number" required/>
                    </label>
                    <label for="password">
                        <input id="password" type="password" name="password" placeholder="Password" required/>
                    </label>
                    <label for="retype_password">
                        <input id="retype_password" type="password" name="retype_password" placeholder="Re-type password" required/>
                    </label>
                    <button id="btn_submit" type="submit" name="submit">Create Account</button>
                </form>
            </div>
        </main>
    </body>
</html>