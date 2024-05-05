
<?php

include '../header2.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    <<style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background-image: url('../image/userview.png');
    background-size: cover;
    background-repeat: no-repeat;
    font-family: Arial, sans-serif;
    background-color: rgba(255, 255, 255, 0.8);
    margin: 0;
    padding: 0;
}

h1 {
    
    text-align: center;
    margin: 20px ;
    background-color: white;
   
}

.contact-form {
    width: 70%;
    max-width: 600px;
    margin: 100px auto; /* Adjust the top margin to center vertically */
    background-color: rgba(255, 255, 255, 0.5); /* Make the form background transparent */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}


.form-group {
    margin: 10px 0;
}

label {
    display: block;
    font-weight: bold;
    color: #333;
}

input[type="text"],
input[type="email"],
input[type="phone"],
textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
}

textarea {
    resize: vertical;
}

button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
    

    <div class="contact-form">
        <form action="add_cdetails.php" method="post">
        <h1>Contact Us</h1>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="phone" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>
            </div>

            <button type="submit" name="submit">Submit</button>
        </form>
    </div>
</body>
</html>

<?php
include '../dbh.php';

if (isset($_POST['submit'])) {
    // Retrieve form data and sanitize
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Simple validation
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        echo '<script type="text/javascript">
            window.onload = function () { alert("Please fill in all fields."); }
            </script>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script type="text/javascript">
            window.onload = function () { alert("Invalid email format."); }
            </script>';
    } else {
        // Insert data into the database
        $sql = "INSERT INTO `contact` (`name`,`email`,`phone`, `message`)
        VALUES('$name', '$email', '$phone', '$message')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo '<script type="text/javascript">
            window.onload = function () { alert("Data Inserted !"); 
                window.location.href = "view_cdetails.php";}
            </script>';
        } else {
            echo "Failed";
        }
    }
}
?>
