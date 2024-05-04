<?php
// Include your database connection file (e.g., dbh.php)
include '../dbh.php';

// Check if the ID parameter is passed through the URL
if (isset($_GET['id'])) {
    // Retrieve the Employee ID from the URL and sanitize it
    $id = intval($_GET['id']); // Assuming id is an integer

    // Fetch Employee details from the database
    $sql = "SELECT * FROM id_card WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Assign Employee details to variables
        $nameWithInitials= $row['nameWithInitials'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $dob = $row['dob'];
        $nationality = $row['nationality'];
        $gender = $row['gender'];
        $address = $row['address'];
        $nationality = $row['nationality'];
        $occupation = $row['occupation'];
        $maritalStatus = $row['maritalStatus'];
        $photo = $row['photo']; // existing photo path
    } else {
        // Employee with the specified ID not found
        echo "User not found.";
        exit;
    }
} else {
    // ID parameter is not provided
    echo "User ID not specified.";
    exit;
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve updated data from the form
    
    $nameWithInitials = mysqli_real_escape_string($conn, $_POST['nameWithInitials']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
    $occupation = mysqli_real_escape_string($conn, $_POST['occupation']);
    $maritalStatus = mysqli_real_escape_string($conn, $_POST['maritalStatus']);
    

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
                $sql = "UPDATE id_card SET 
                        
                        nameWithInitials =' $nameWithInitials'
                        firstname = '$firstname',
                        lastname = '$lastname',
                        dob = '$dob',
                        nationality = '$nationality',
                        gender = '$gender',
                        address = '$address',
                        nationality = '$nationality',
                        occupation = '$occupation',
                        maritalStatus = '$maritalStatus',
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
        // Update employee data in the database without updating photo path
        $sql = "UPDATE id_card SET 
        nameWithInitials = '$nameWithInitials',
        firstname = '$firstname',
        lastname = '$lastname',
        dob = '$dob',
        nationality = '$nationality',
        gender = '$gender',
        address = '$address',
        nationality = '$nationality',
        occupation = '$occupation',
        maritalStatus = '$maritalStatus',
        photo = '$photo'
        WHERE id = $id";


    // Check if the update was successful
if (mysqli_query($conn, $sql)) {
    // Redirect to view_ID.php
    header("Location: view_ID.php?id=$id");
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
    <title>Update User</title>
    <style>

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
        /* CSS for Update Employee Form */
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
<h1>Update Employee</h1>

<div class="container">
    <!-- Update Employee Form -->
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <label for="nameWithInitials">Name With Initials</label>
        <input type="text" name="nameWithInitials" value="<?php echo $nameWithInitials; ?>" required>

        <label for="firstname">First Name</label>
        <input type="text" name="firstname" value="<?php echo $firstname; ?>" required>

        <label for="lastname">Last Name</label>
        <input type="text" name="lastname" value="<?php echo $lastname; ?>" required>

        <label for="dob">Date of Birth</label>
        <input type="date" name="dob" value="<?php echo $dob; ?>" required>

        <label for="nationality">Nationality</label>
        <input type="text" name="nationality" value="<?php echo $nationality; ?>" required>

        <label for="gender">Gender</label>
        <input type="text" name="gender" value="<?php echo $gender; ?>" required>

        <label for="address">Address</label>
        <textarea name="address" required><?php echo $address; ?></textarea>

        <label for="occupation">Occupation</label>
        <input type="text" name="occupation" value="<?php echo $occupation; ?>" required>

        <label for="maritalStatus">Marital Status</label>
        <input type="text" name="maritalStatus" value="<?php echo $maritalStatus; ?>" required>

        <label for="photo">Photo</label>
        <img src="<?php echo $photo; ?>" alt="Current Photo" style="max-width: 200px;">
        <input type="file" name="photo">

        <button type="submit" name="submit">Update User</button>
    </form>
</div>
</body>
</html>
