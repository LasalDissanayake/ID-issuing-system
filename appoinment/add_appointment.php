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
    background-image: url('3.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

h1 {
    
    text-align: center;
    margin: 20px 0;
    background-color: white;
    width: 60%;
    height: 50px;
    border-radius: 8px;
    margin-left: 270px;
}

.contact-form {
    width: 70%;
    max-width: 600px;
    margin: 0 auto;
    background-color: #fff;
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
    <h1>Contact Us</h1>

    <div class="contact-form">
        <form action="add_appointment.php" method="post">
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
