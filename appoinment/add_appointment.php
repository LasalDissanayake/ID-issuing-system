<?php

include '../header2.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Make appointment</title>
    <style>
      * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background-image: url('../image/appointment.png');
    background-size: cover;
    background-repeat: no-repeat;
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.contact-form {
    width: 70%;
    max-width: 600px;
    margin: 0 auto;
    background-color: rgba(255, 255, 255, 0.8); /* Adjust the opacity by changing the alpha value (0.8 for 80% opacity) */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 20px; /* Increased margin for better separation between form groups */
}

label {
    display: block;
    font-weight: bold;
    color: #333;
    margin-bottom: 5px; /* Added margin below label for better spacing */
}
.contact-form {
    width: 70%;
    max-width: 600px;
    margin: 50px auto; /* Adjusted margin to center vertically and horizontally */
    background-color: rgba(255, 255, 255, 0.8);
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}


input[type="text"],
input[type="email"],
input[type="phone"],
input[type="date"],
input[type="aboutDoc"],
textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc; /* Slightly lighter border color for better contrast */
    border-radius: 4px;
    font-size: 16px;
    transition: border-color 0.3s ease; /* Smooth transition for better user experience */
}

input[type="text"]:focus,
input[type="email"]:focus,

textarea:focus {
    border-color: #007bff; /* Change border color on focus */
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
    transition: background-color 0.3s ease; /* Smooth transition for button hover effect */
}

button[type="submit"]:hover {
    background-color: #0056b3;
}


    </style>

    
</head>
<body>
    

    <div class="contact-form">
        <form action="add_appointment.php" method="post">
        <h1>Make Appointment</h1>
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
                <label for="Date">Appointment Date:</label>
                <input type="date" id="date" name="date" required>
            </div>

            <label for="aboutDoc">Document type:</label>
    <select id="aboutDoc" name="aboutDoc" required>
        <option value="Identity card">Identity card</option>
        <option value="Driving license">Driving license</option>
        <option value="Passport">Passport</option>
    </select>

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
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $aboutDoc = mysqli_real_escape_string($conn, $_POST['aboutDoc']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Simple validation
    if (empty($name) || empty($email) || empty($phone) || empty($date) || empty($aboutDoc) || empty($message)) {
        echo '<script type="text/javascript">
            window.onload = function () { alert("Please fill in all fields."); }
            </script>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script type="text/javascript">
            window.onload = function () { alert("Invalid email format."); }
            </script>';
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        echo '<script type="text/javascript">
            window.onload = function () { alert("Phone number should be a 10-digit number."); }
            </script>';
    } elseif (strtotime($date) < strtotime(date('Y-m-d'))) {
        echo '<script type="text/javascript">
            window.onload = function () { alert("Appointment date must be a future date."); }
            </script>';
    } else {
        // Insert data into the database
        $sql = "INSERT INTO `appointment` (`name`,`email`,`phone`,`date`, `aboutDoc`,  `message`)
        VALUES('$name', '$email', '$phone','$date', '$aboutDoc', '$message')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo '<script type="text/javascript">
            window.onload = function () { alert("Data Inserted !"); 
                window.location.href = "view_appointment.php";}
            </script>';
        } else {
            echo "Failed";
        }
    }
}


?>
