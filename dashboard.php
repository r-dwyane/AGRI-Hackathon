<?php
include "connection.php";
session_start();

// Ensure $_SESSION['contact_no'] is set before accessing it
if(isset($_SESSION['contact_no'])) {
    $contact_no = $_SESSION['contact_no'];

} else {
    echo "<script>alert('Contact number not found.')</script>";
}

$sql = "SELECT f_name, password, contact_no FROM farmers WHERE contact_no=?";
$stmt_select2 = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt_select2, "s", $contact_no);
mysqli_stmt_execute($stmt_select2);
$result_select2 = mysqli_stmt_get_result($stmt_select2);
if ($row2 = mysqli_fetch_assoc($result_select2)) {
    $fname = $row2['f_name'];
    $password = $row2['password'];

    // Execute the first query to get the sum of planted crops
$sql3 = "SELECT SUM(planted) AS s FROM crops";
$stmt_select3 = mysqli_prepare($con, $sql3);
mysqli_stmt_execute($stmt_select3);
$result_select3 = mysqli_stmt_get_result($stmt_select3);
$row3 = mysqli_fetch_assoc($result_select3);
$sum_planted = $row3['s'];

// Execute the second query to get the sum of harvested crops
$sql4 = "SELECT SUM(harvested) AS su FROM crops";
$stmt_select4 = mysqli_prepare($con, $sql4);
mysqli_stmt_execute($stmt_select4);
$result_select4 = mysqli_stmt_get_result($stmt_select4);
$row4 = mysqli_fetch_assoc($result_select4);
$sum_harvested = $row4['su'];
    
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, inintial-scale=1.0"/>
        <link rel="stylesheet" href="dashboard.css"/>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link rel="icon" type="imgae/x-icon" href="logo_green.png"/>
        <title>Dashboard</title>
    </head>
    <body>
        <div class="navBar">
            <nav>
                <ul>
                    <li><a href="HOME.php">HOME</a></li>
                    <li><a href="dashboard.php">DASHBOARD</a></li>
                    <li><a href="AboutUs2.html">ABOUT</a></li>
                </ul>
            </nav>
        </div>
        <div class="sheet">
            <section class="container">
                <div class="weather">
                    <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
                    <div class="elfsight-app-e2e1211d-f8ce-4a59-ac5e-993b09eefe94" data-elfsight-app-lazy></div>
                </div>
                <div class="counter">
                    <h3>COUNTER</h3>
                    <div class="harvest-planted">
                        <span id="harvested_counter" name="harvested"><?php echo $sum_harvested; ?></span>
                        <h4>HARVESTED</h4>
                        <span id="planted_counter" name="planted"><?php echo $sum_planted; ?></span>
                        <h4>PLANTED</h4>
                    </div>
                </div>
                <div class="product">
                    <div class="crops">
                        <span>CROPS</span>
                        <i><img id="plus" src="plus.png"  class="plus" /></i>
                    </div>
                    <div class="garlic">
                        <div class="div_2">
                            <select name="" id="">
                            <option value="APPLE">APPLE</option>
                            <option value="BANANA">BANANA</option>
                            <option value="BLUEBERRY">BLUEBERRY</option>
                            <option value="GRAPES">GRAPES</option>
                            <option value="LEMON">LEMON</option>
                            <option value="MANGO">MANGO</option>
                            <option value="ORANGE">ORANGE</option>
                            <option value="PEACH">PEACH</option>
                            <option value="STRAWBERRY">STRAWBERRY</option>
                            <option value="AVOCADO">AVOCADO</option>
                            </select>
                            <form for="save_1" action="" method="post">
                                <button type="submit" id="save_1" name="save">SAVE</button>
                            </form>
                        </div>
                        
                        <form class="planted-harvest-water">
                            <div class="whitey">
                                <h5>PLANTED</h5>
                                <input type="date" id="PLANTED" name="PLANTED">
                            </div>
                            <div class="whitey">
                                <h5>HARVEST</h5>
                                <input type="date" id="HARVEST" name="HARVEST">
                            </div>
                            <div class="whitey">
                                <h5>WATER</h5>
                                <input type="time" id="WATER" name="WATER">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="footer">
                    <div class="footer_child">
                        <h5>NAME</h5>
                        <label for="name">
                            <input type="text" id="name" placeholder="<?php echo $fname; ?>"/>
                        </label>
                    </div>
                    <div class="footer_child">
                        <h5>CONTACT NUMBER</h5>
                        <label for="contact_number">
                            <input type="number" id="contact_number" placeholder="<?php echo $contact_no; ?>"/>
                        </label>
                    </div>
                    <div class="footer_child">
                        <h5>RESET PASSWORD</h5>
                        <label for="reset_password">
                            <input type="text" id="reset_password" placeholder="<?php echo $password; }?>"/>
                        </label>
                    </div>

                    <?php 
// Check if the form is submitted
if(isset($_POST['submit'])){
    // Retrieve form data
    $crop_name = $_POST['crop_name'];
    $soil = $_POST['soil'];
    $climate = $_POST['climate'];
    $water_days = $_POST['water_daily'];
    $pests = $_POST['common_pest'];

    // Prepare and execute the SQL query
    $select = "SELECT crop_name FROM farmers WHERE crop_name = ?";
    $stmt_select = mysqli_prepare($con, $select);
    mysqli_stmt_bind_param($stmt_select, "s", $crop_name);
    mysqli_stmt_execute($stmt_select);
    $result_select = mysqli_stmt_get_result($stmt_select);

    if($row = mysqli_fetch_assoc($result_select)){
        echo "<script>alert('Crop already added.')</script>";
    } else {
        $sql2= "INSERT INTO crops ('crop_name', 'soil', 'climate', 'water_days', 'pests', 'contact_no', 'planted', 'harvested') VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($con, $sql2);
        mysqli_stmt_bind_param($stmt_insert, "ssssssss", $crop_name, $soil, $climate, $water_days, $pests, $contact_no, null, null);

        if(mysqli_stmt_execute($stmt_insert)){
            echo "<script>alert('Added Crop Successfully.')</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "')</script>";
        }
    }
}
?>

                    <div class="footer_child">
                        <h5>DELETE ACCOUNT</h5>
                        <label for="delete_account">
                            <input type="text" id="delete_account" placeholder="Enter name: ">
                        </label>
                    </div>
                    <div class="footer_child">
                        <a href="login.php"><img src="signout.png" class="signout"></a>
                    </div>  
                </div>
            </section>
            <div class="popup_container" id="popup_container">
                <div class="popup">
                    <div class="plus"></div><img src="plus.png" class="x-close" id="x-close">
                    <h2>CROP DESCRIPTION</h2>
                    <form class="popup_form" action="" method="post">
                        <input name="crop_name" id="crop_name" type="text" placeholder="CROP NAME" class="popup_input">
                        <input name="soil" id="soil" type="text" placeholder="SUITABLE SOIL" class="popup_input">
                        <input name="climate" id="climate" type="text" placeholder="SUITABLE CLIMATE" class="popup_input">
                        <input name="pests" id="pests"  type="text" placeholder="COMMON PEST" class="popup_input">
                        <button type="submit">Add</button>
                    </form>
                </div>
            </div>
            <script>
                var plusIcon = document.querySelector(".plus");
                var popupContainer = document.querySelector(".popup_container");
            
                plusIcon.addEventListener("click", function() {
                    var isVisible = popupContainer.style.visibility === "visible";
            
                    popupContainer.style.visibility = isVisible ? "hidden" : "visible";
                });
            </script>
            <script>
                var plusIcon = document.querySelector(".x-close");
            
                var popupContainer = document.querySelector(".popup_container");
            
                plusIcon.addEventListener("click", function() {
                    var isVisible = popupContainer.style.visibility === "visible";
            
                    popupContainer.style.visibility = isVisible ? "hidden" : "visible";
                });
            </script>
        </div>
    </body>
</html>