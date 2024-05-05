<!DOCTYPE html>
<html>
<head>
    <title>Update Contact</title>
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
}

h1 {
    text-align: center;
    margin: 20px 0;
    color: #333;
}

form {
    width: 70%;
    max-width: 600px;
    margin: 0 auto;
    background-color: rgba(255, 255, 255, 0.7); /* Transparent background */
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
select,
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

/* Optional: Add a background image or texture */
body {
    background-image: url('../image/contact.png');
    background-size: cover;
    background-repeat: no-repeat;
}


    </style>
</head>
<body>
    <h1>Update Contact</h1>

    <?php
    // Include your database connection script (e.g., dbh.php)
    include '../dbh.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch the specific feedback entry from the database
        $query = "SELECT * FROM contact WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            echo '<form action="update_cdetails.php" method="post">
                <input type="hidden" name="feedback_id" value="' . $row['id'] . '">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="' . $row['name'] . '" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="' . $row['email'] . '" required>
                </div>

                <div class="form-group">
                    <label for="phone">phone:</label>
                    <input type="phone" id="phone" name="phone" value="' . $row['phone'] . '" required>
                </div>

                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="4" required>' . $row['message'] . '</textarea>
                </div>

                <button type="submit" name ="submit">Update </button>
            </form>';
        } else {
            echo 'Feedback entry not found.';
        }
    }
    ?>
</body>
</html>

<?php
include '../dbh.php';
if (isset($_POST['submit'])) {
    $id = $_POST['feedback_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    

    $sql = "UPDATE contact SET name='$name', email='$email', phone='$phone', message='$message' WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo '<script type="text/javascript">
        window.onload = function () { alert("Data Updated !"); 
            window.location.href = "view_cdetails.php";}
        </script>';
    } else {
        echo "Failed";
    }
}
?>
