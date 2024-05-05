<?php
// Include your database connection file (e.g., dbh.php)
include '../dbh.php';

// Check if the ID parameter is passed through the URL
if (isset($_GET['id'])) {
    // Retrieve the Employee ID from the URL and sanitize it
    $id = intval($_GET['id']); // Assuming id is an integer

    // Fetch Employee details from the database
    $sql = "SELECT * FROM passport WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Assign Employee details to variables
        $TypeofService = $row['TypeofService'];
        
        $NIC = $row['NIC'];
        $Address = $row['Address'];
        $dob = $row['dob'];
       
        $gender = $row['gender'];
        $Occupation = $row['Occupation'];
        $DualCitizenship = $row['DualCitizenship'];
        $DualCitizenshipNo = $row['DualCitizenshipNo'];
        $Phone = $row['Phone'];
        $email = $row['email'];
        $photo = $row['photo']; // existing photo path
    } else {
        // Employee with the specified ID not found
        echo "Employee not found.";
        exit;
    }
} else {
    // ID parameter is not provided
    echo "Employee ID not specified.";
    exit;
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve updated data from the form
    $TypeofService = mysqli_real_escape_string($conn, $_POST['TypeofService']);
   
    $NIC = mysqli_real_escape_string($conn, $_POST['NIC']);
    $Address = mysqli_real_escape_string($conn, $_POST['Address']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $Occupation = mysqli_real_escape_string($conn, $_POST['Occupation']);
    $DualCitizenship = mysqli_real_escape_string($conn, $_POST['DualCitizenship']);
    $DualCitizenshipNo = mysqli_real_escape_string($conn, $_POST['DualCitizenshipNo']);
    $Phone = mysqli_real_escape_string($conn, $_POST['Phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Check if a new file is uploaded
    if ($_FILES['photo']['name']) {
        // Handle file upload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["photo"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                // Update employee data in the database with new photo path
                $photo = $target_file;
                $sql = "UPDATE passport SET 
                        TypeofService = '$TypeofService',
                        
                        NIC = '$NIC',
                        Address = '$Address',
                        dob = '$dob',
                       
                        gender = '$gender',
                        Occupation = '$Occupation',
                        DualCitizenship = '$DualCitizenship',
                        DualCitizenshipNo = '$DualCitizenshipNo',
                        Phone = '$Phone',
                        email = '$email',
                        photo = '$photo'
                        WHERE id = $id";

                if (mysqli_query($conn, $sql)) {
                    echo "Employee data updated successfully.";
                } else {
                    echo "Error updating employee data: " . mysqli_error($conn);
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // Update employee employeedata in the database without updating photo path
        $sql = "UPDATE passport SET 
                        TypeofService = '$TypeofService',
                       
                        NIC = '$NIC',
                        Address = '$Address',
                        dob = '$dob',
                       
                        gender = '$gender',
                        Occupation = '$Occupation',
                        DualCitizenship = '$DualCitizenship',
                        DualCitizenshipNo = '$DualCitizenshipNo',
                        Phone = '$Phone',
                        email = '$email'
                        WHERE id = $id";

    // Check if the update was successful
if (mysqli_query($conn, $sql)) {
    // Redirect to view_employee.php
    header("Location: view_passport.php?id=$id");
    exit(); // Ensure that code execution stops after redirection
} else {
    echo "Error updating employee data: " . mysqli_error($conn);
}

    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Employee</title>
    <style>

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    background-image: url('../image/passport.png');
    background-size: cover;
    background-repeat: no-repeat;
}

.container {
    max-width: 600px;
    margin: 120px auto; /* Shifted to the center */
    padding: 20px;
    background-color: rgba(248, 249, 250, 0.9); /* Transparent background */
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
    <!-- Update Employee Form -->
    <form method="POST" enctype="multipart/form-data">
    <h1>Edit Passport Details</h1>
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <label for="TypeofService">Type of Service</label>
        <input type="text" name="TypeofService" value="<?php echo $TypeofService; ?>" required>

        

        <label for="NIC">National ID Card Number</label>
        <input type="text" name="NIC" value="<?php echo $NIC; ?>" required>

       

        <label for="Address">Address</label>
        <input type="text" name="Address" value="<?php echo $Address; ?>" required>

        <label for="dob">Birthday</label>
        <input type="text" name="dob" value="<?php echo $dob; ?>" required>

        

        <label for="gender">Vocational Training Center</label>
        <input type="text" name="gender" value="<?php echo $gender; ?>" required>

        <label for="Occupation">Vocational Training Occupation</label>
        <input type="text" name="Occupation" value="<?php echo $Occupation; ?>" required>

        <label for="DualCitizenship">Experienced Years</label>
        <input type="text" name="DualCitizenship" value="<?php echo $DualCitizenship; ?>" required>

        <label for="DualCitizenshipNo">DualCitizenshipNo</label>
        <input type="DualCitizenshipNo" name="DualCitizenshipNo" value="<?php echo $DualCitizenshipNo; ?>" required>

        <label for="Phone">Phone</label>
        <input type="Phone" name="Phone" value="<?php echo $Phone; ?>" required>

        <label for="email">email</label>
        <input type="email" name="email" value="<?php echo $email; ?>" required>

        <label for="photo">Photo</label>
        <img src="<?php echo $photo; ?>" alt="Current Photo" style="max-width: 200px;">
        <input type="file" name="photo">

        <button type="submit" name="submit">Update Employee</button>
    </form>
</div>
</body>
</html>
