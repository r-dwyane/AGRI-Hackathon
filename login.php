<?php
session_start();
if(isset($_SESSION['success_message'])) {
    echo "<script>alert('" . $_SESSION['success_message'] . "')</script>";
    unset($_SESSION['success_message']);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="login.css" />
        <title>Log In</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    </head>
    <body>
        <main>
             <div class="pic"><img src="icon_1.png" alt=""></div>
                <div class="login_container">
                    <h1>Log In</h1>
                    <form class="form" action="login_back.php" method="post">
                        <?php if(isset($_GET['error'])){?> <script>alert(<?php $_GET['error'] ?>)</script> <?php } ?>

                        <label for="contact_no">
                            <input id="username" name="contact_no" placeholder="Contact Number" required/>
                        </label>
        
                        <label for="password">
                            <input type="password" id="password" name="password" placeholder="Password" required/>
                        </label>
                        <h2>Don't have an account? <a href="create_account.php" class="create_href">Create account?</a></h2>
                        <button type="submit">Log In</button>
                    </form>
                </div>
        </main>
    </body>
</html>