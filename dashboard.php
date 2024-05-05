<?php
session_start(); // Make sure to start the session
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department of Immigration & Emigration</title>
    <link rel="stylesheet" href="css/dash.css" />
</head>

<body>

    <div class="wrapper">

        <div class="sidebar">
            <div class="profile">
                <img style="width: 100px; " src="image/gov.png" alt="" />
                <h3>User Dashboard</h3>
                
            </div>
            <ul>
                <li>
                    <a href="#" class="active">
                        <span class="icon"><i class="fas fa-home"></i></span>
                        <span class="item">Home</span>
                    </a>
                </li>

                <li>
                    <a href="appoinment/add_appointment.php">
                        <span class="icon"><i class="fas fa-plus"></i></span>
                        <span class="item"> Make appointmnet</span>
                    </a>
                </li>

                <li>
                    <a href="appoinment/view_appointment.php">
                        <span class="icon"><i class="fa fa-bell" aria-hidden="true"></i></span>
                        <span class="item"> View My appointmnet</span>
                    </a>
                </li>

                <li>
                    <a href="ID card/add_ID.php">
                        <span class="icon"><i class="fas fa-id-card "></i></span>
                        <span class="item">Request for Create ID</span>
                    </a>
                </li>

                <li>
                    <a href="ID card/view_ID.php">
                        <span class="icon"><i class="fas fa-id-card"></i></span>
                        <span class="item">View ID</span>
                    </a>
                </li>

                <li>
                    <a href="passport/add_passport.php">
                        <span class="icon"><i class="fas fa-id-card"></i></span>
                        <span class="item">Request for Passport</span>
                    </a>
                </li>

                <li>
                    <a href="passport/view_passport.php">
                        <span class="icon"><i class="fas fa-id-card"></i></span>
                        <span class="item">View Passport</span>
                    </a>
                </li>

                <li>
                    <a href="view_User.php">
                        <span class="icon"><i class="fa fa-user-plus" aria-hidden="true"></i></span>
                        <span class="item">My Profile</span>
                    </a>
                </li>

                <li>
                    <a href="contact_us/add_cdetails.php">
                        <span class="icon"><i class="fas fa-comment "></i></span>
                        <span class="item">Contact us</span>
                    </a>
                </li>

                
                
                </ul>
        </div>
    </div>

    <div>
        <!-- <div style="margin-top: 100px; margin-left: 500px; position: absolute ">
            <img src="image/chch.png" alt="">
        </div> -->
      
        
    </div>

</body>

</html>