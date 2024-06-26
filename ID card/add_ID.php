<?php
// Include your database connection file (e.g., dbh.php)
include '../dbh.php';

session_start();
$email = $_SESSION['email'];



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data and sanitize
    // Adjust according to your database schema
    $nameWithInitials = mysqli_real_escape_string($conn, $_POST['nameWithInitials']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $occupation = mysqli_real_escape_string($conn, $_POST['occupation']);
    $maritalStatus = mysqli_real_escape_string($conn, $_POST['maritalStatus']);
    $email = mysqli_real_escape_string($conn, $_POST['$email']);

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
                $insert_query = "INSERT INTO id_card (nameWithInitials, firstname, lastname, dob, nationality, gender, address, occupation, maritalStatus, photo, email) 
                    VALUES ('$nameWithInitials', '$firstname', '$lastname', '$dob', '$nationality', '$gender', '$address', '$occupation', '$maritalStatus', '$upload_path', '$email')";

                if (mysqli_query($conn, $insert_query)) {
                    // User added successfully
                    echo '<script type="text/javascript">
                            window.onload = function () { 
                                alert("ID card details Added!"); 
                                window.location.href = "../dashboard.php";
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
    
    margin: 0;
    padding: 120px;
    background-image: url('../image/id.jpg'); /* Adding background image */
    background-size: cover;
    background-repeat: no-repeat;
}

.container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.8); /* Making container transparent */
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
input[type="email"],
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
    
    
    <div class="container">
        <form action="add_ID.php" method="post" enctype="multipart/form-data">
        <h1>Register Form</h1>


            <label for="firstname">Name With Initials</label>
            <input type="text" name="nameWithInitials" required>

            <label for="firstname">First Name</label>
            <input type="text" name="firstname" required>

            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" required>

            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email;?>" required readonly >
            

            
            <label for="dob">Birthday</label>
            <input type="date" name="dob" required>

            <label for="nationality">nationality</label>
            <input type="text" name="nationality" required>

            <label for="nationality">Gender</label>
            <input type="text" name="gender" required>

            <label for="address">Address</label><br>
            <textarea id="address" name="address" rows="4" cols="50"></textarea><br><br>

            <label for="occupation">occupation</label>
            <input type="text" name="occupation" required>

            <label for="maritalStatus">marital Status</label>
            <input type="text" name="maritalStatus" required>

            <label for="photo">Birth Certificate</label>
            <input type="file" name="photo" required>

            <button type="submit" name="submit">Submit Details</button>
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

            // Validation for Birthday
            const dob = new Date(form.querySelector('input[name="dob"]').value);
            const currentDate = new Date();
            if (dob >= currentDate) {
                errorMessages.push('Birthday should be a date before the current date.');
            }

            if (errorMessages.length > 0) {
                event.preventDefault(); // Prevent form submission if there are errors
                alert(errorMessages.join('\n')); // Display error messages
            }
        });
    });
</script>


</body>
</html>
