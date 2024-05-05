<?php
// Include the database connection file
include 'dbh.php';

// Initialize a variable to store error message
$Invalid = "";

// Check if the login form is submitted
if (isset($_POST['btnlogin'])) {
    // Check if email and password are provided
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Sanitize and store the entered email and password
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Query the database to select user with provided email and password
        $select = mysqli_query($conn, "SELECT * from `user` WHERE email = '$email' AND password = '$password'");

        // Check if the query returns any row (user found)
        if (mysqli_num_rows($select) > 0) {
            // Start a session
            session_start();
            // Fetch the user row from the result
            $row = mysqli_fetch_assoc($select);
            // Store user's ID in session variable
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['firstname'] = $row['firstname'];
            $_SESSION['email'] = $row['email'];
            // Redirect to dashboard page
            header('Location: dashboard.php');
            exit;
        } else {
            // Set error message for invalid email or password
            $Invalid = "Invalid Email or Password!";
        }
    } else {
        // Set error message if email or password is not provided
        $Invalid = "Email and Password are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="login.css">
    <script src="https://kit.fontawesome.com/b3ca95fff7.js" crossorigin="anonymous"></script>
    <title>Login page</title>
</head>
<body>

    <div class="fromebox">
    <p class="errorbox"> <?php echo $Invalid?></p>
    <h1 class="login">Log In</h1>

    <form class="form1" method="post" action="login.php">

            <div class="input">
            <i class=""></i>
                <input type="email" placeholder="Enter E-mail" name="email">
            </div>

            
            <div class="input">
            <i class=""></i>
                <input type="password" placeholder="Enter password" id="firstpas" name="password">
            </div>

            <button type="submit" name="btnlogin">Log In</button>

            <p class="p1">Don't have an account? <a class="click" href="sign_up.php">Sign Up</a></P>


    </form>

    </div>

</body>

</html>
