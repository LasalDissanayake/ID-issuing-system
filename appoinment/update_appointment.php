<?php

include '../header2.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update appointment</title>
    <style>
/* Reset default browser styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    background-image: url('../image/appointment.png'); /* Add background image */
    background-size: cover;
    background-repeat: no-repeat;
}

h1 {
    text-align: center;
    margin: 20px 0;
    color: #333;
}

form {
    width: 70%;
    max-width: 600px;
    margin: 100px auto; /* Shift form to the center */
    background-color: rgba(255, 255, 255, 0.8); /* Make form transparent */
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
input[type="date"],
input[type="aboutDoc"],
select,
textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd; /* Adjust border color */
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
    

    <?php
    // Include your database connection script (e.g., dbh.php)
    include '../dbh.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch the specific appointment entry from the database
        $query = "SELECT * FROM appointment WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            echo '<form action="update_appointment.php" method="post">
            <h1>Update appointment</h1>
                <input type="hidden" name="appointment_id" value="' . $row['id'] . '">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="' . $row['name'] . '" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="' . $row['email'] . '" required readonly>
                </div>

                <div class="form-group">
                    <label for="phone">phone:</label>
                    <input type="phone" id="phone" name="phone" value="' . $row['phone'] . '" required>
                </div>
                <div class="form-group">
                    <label for="date">date:</label>
                    <input type="date" id="date" name="date" value="' . $row['date'] . '" required>
                </div>
                <div class="form-group">
                    <label for="aboutDoc">aboutDoc:</label>
                    <input type="aboutDoc" id="aboutDoc" name="aboutDoc" value="' . $row['aboutDoc'] . '" required>
                </div>

                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="4" required>' . $row['message'] . '</textarea>
                </div>

                <button type="submit" name ="submit">Update </button>
            </form>';
        } else {
            echo 'appointment entry not found.';
        }
    }
    ?>
</body>
</html>

<?php
include '../dbh.php';
if (isset($_POST['submit'])) {
    $id = $_POST['appointment_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $aboutDoc = $_POST['aboutDoc'];
    $message = $_POST['message'];
    

    $sql = "UPDATE appointment SET name='$name', email='$email', phone='$phone', date='$date', aboutDoc='$aboutDoc', message='$message' WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo '<script type="text/javascript">
        window.onload = function () { alert("Data Updated !"); 
            window.location.href = "view_appointment.php";}
        </script>';
    } else {
        echo "Failed";
    }
}
?>
