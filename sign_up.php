<?php
// Include your database connection file (e.g., dbh.php)
include 'dbh.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data and sanitize
    $id = intval($_POST['id']); // Assuming id is an integer
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

     // Check if a file was uploaded
     if (isset($_FILES['photo'])) {
        $file = $_FILES['photo'];

        // Check if the file is an image
        if (getimagesize($file['tmp_name'])) {
            // Generate a unique filename
            $image_filename = uniqid() . '_' . $file['name'];

            // Define the upload path
            $upload_path = 'uploads/' . $image_filename; // Change 'uploads/' to your desired directory

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                // Insert data into the database
                $insert_query = "INSERT INTO user (firstname, lastname, email, password, photo) 
                    VALUES ('$firstname', '$lastname','$email','$password','$upload_path')";

                if (mysqli_query($conn, $insert_query)) {
                    // employee added successfully
                    echo '<script type="text/javascript">
                            window.onload = function () { 
                                alert("User Added!"); 
                                window.location.href = "login.php";
                            }
                        </script>'; // Redirect to view_employee.php
                    exit;
                } else {
                    // Database insertion failed
                    header('Location: error_page.php'); // Redirect to an error page
                    exit;
                }
            } else {
                // File upload failed
                header('Location: error_page.php'); // Redirect to an error page
                exit;
            }
        } else {
            // The uploaded file is not an image
            header('Location: error_page.php'); // Redirect to an error page
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add employee</title>
    <style>
       /* CSS for Update employee Form */

       body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 120px;
            background-image: url('bg.png');
            background-size: cover;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
        }
.container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

form {
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

label {
    font-weight: bold;
    margin-bottom: 10px;
    display: block;
    color: #333;
}

input[type="text"],
input[type="number"],
input[type="date"],
textarea {
    width: calc(100% - 22px);
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

img {
    display: block;
    margin-bottom: 10px;
    max-width: 100%;
    height: auto;
    border-radius: 5px;
}

button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}
    </style>
</head>
<body>
    
    <h1>Register Form</h1>

    <div class="container">
        <form action="sign_up.php" method="post" enctype="multipart/form-data">
            <label for="firstname">First Name</label>
            <input type="text" name="firstname" required>

            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" required>

            
            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" required>

            <label for="photo">Photo</label>
            <input type="file" name="photo" required>

            <button type="submit" name="submit">Register</button>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');

        form.addEventListener('submit', function(event) {
            let errorMessages = [];

            // Validation for Name With Initials and Full Name
            const firstname = form.querySelector('input[name="firstname"]').value;
            const lastname = form.querySelector('input[name="lastname"]').value;
            const nameRegex = /^[a-zA-Z\s]*$/; // Allows only letters and spaces
            if (!nameRegex.test(firstname) || !nameRegex.test(lastname)) {
                errorMessages.push('Name should only contain letters and spaces.');
            }
            
        });
    });
</script>

</body>
</html>
