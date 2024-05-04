<?php
// Include your database connection file (e.g., dbh.php)
include '../dbh.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data and sanitize
    // Adjust according to your database schema
    $TypeofService = mysqli_real_escape_string($conn, $_POST['TypeofService']);
    $TypeofTravelDocument = mysqli_real_escape_string($conn, $_POST['TypeofTravelDocument']);
    $NIC = mysqli_real_escape_string($conn, $_POST['NIC']);
    $Surname = mysqli_real_escape_string($conn, $_POST['Surname']);
    $Address = mysqli_real_escape_string($conn, $_POST['Address']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $PlaceofBirth = mysqli_real_escape_string($conn, $_POST['PlaceofBirth']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $Occupation = mysqli_real_escape_string($conn, $_POST['Occupation']);
    $DualCitizenship = mysqli_real_escape_string($conn, $_POST['DualCitizenship']);
    $DualCitizenshipNo = mysqli_real_escape_string($conn, $_POST['DualCitizenshipNo']);
    $Phone = mysqli_real_escape_string($conn, $_POST['Phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

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
                $insert_query = "INSERT INTO passport (TypeofService, TypeofTravelDocument, NIC, Surname, Address, dob, PlaceofBirth, gender, Occupation, DualCitizenship, DualCitizenshipNo, Phone, email, photo) 
                    VALUES ('$TypeofService', '$TypeofTravelDocument', '$NIC', '$Surname', '$Address', '$dob', '$PlaceofBirth', '$gender', '$Occupation', '$DualCitizenship', '$DualCitizenshipNo', '$Phone', '$email', '$upload_path')";

                if (mysqli_query($conn, $insert_query)) {
                    // User added successfully
                    echo '<script type="text/javascript">
                            window.onload = function () { 
                                alert("User Added!"); 
                                window.location.href = "view_passport.php";
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
        <form action="add_passport.php" method="post" enctype="multipart/form-data">
        
<label for="TypeofService">Type of Service</label>
<input type="text" name="TypeofService" required>

<label for="TypeofTravelDocument">Type of Travel Document</label>
<input type="text" name="TypeofTravelDocument" required>

<label for="NIC">NIC</label>
<input type="text" name="NIC" required>

<label for="Surname">Surname</label>
<input type="text" name="Surname" required>

<label for="Address">Address</label><br>
<textarea id="Address" name="Address" rows="4" cols="50" required></textarea><br><br>

<label for="dob">Date of Birth</label>
<input type="date" name="dob" required>

<label for="PlaceofBirth">Place of Birth</label>
<input type="text" name="PlaceofBirth" required>

<label for="gender">Gender</label>
<select name="gender" required>
    <option value="Male">Male</option>
    <option value="Female">Female</option>
    <option value="Other">Other</option>
</select>

<label for="Occupation">Occupation</label>
<input type="text" name="Occupation" required>

<label for="DualCitizenship">Dual Citizenship</label>
<input type="text" name="DualCitizenship" required>

<label for="DualCitizenshipNo">Dual Citizenship No</label>
<input type="text" name="DualCitizenshipNo" required>

<label for="Phone">Phone</label>
<input type="text" name="Phone" required>

<label for="email">Email</label>
<input type="email" name="email" required>

<label for="photo">Birth Certificate</label>
            <input type="file" name="photo" required>


<button type="submit" name="submit">Submit</button>
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
