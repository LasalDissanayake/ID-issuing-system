<?php
    // Include database connection
    include '../dbh.php';

    // Check if user is logged in (implement your own authentication logic)
    // For example, you might have session variables set after successful login
    session_start();
    if(!isset($_SESSION['user_id'])) {
        // Redirect the user to the login page if not logged in
        header("Location: login.php"); // Redirect to your login page
        exit();
    }

    // Retrieve logged-in user details from the database
    $userId = $_SESSION['user_id'];
    $sql = "SELECT * FROM id_card WHERE id = $userId";
    $result = mysqli_query($conn, $sql);

    // Check if user exists
    if(mysqli_num_rows($result) == 0) {
        // Redirect or display a message if the user doesn't exist
        echo "User not found!";
        exit();
    }

    // Fetch user details
    $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View User</title>
    <!-- <link rel="stylesheet" href="../css/viewcard.css"> -->
    <!-- custom css file link  -->
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>
<body>
    <style>
       /* Profile container */
.container {
    max-width: 800px;
    margin: 120px auto 20px; /* Shift container to the center */
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.8); /* Making container transparent */
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.7);
}

/* user details */
.user {
    padding: 30px;
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    background-image: url('../image/id.jpg'); /* Add background image */
    background-size: cover;
    background-repeat: no-repeat;
}

/* user image */
.user img {
    display: block;
    margin: 0 auto 20px;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 4px solid #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

/* user details paragraphs */
.user p {
    margin: 10px 0;
    font-size: 18px;
}

/* Edit and delete buttons */
.user button {
    padding: 10px 20px;
    background-color: blue;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 10px;
    transition: background-color 0.3s;
}

/* Edit button hover effect */
.user button:hover {
    background-color: red; /* Fixing typo, should be red not #red */
}

/* Delete button */
.delete-btn {
    background-color: red;
}

/* Delete button hover effect */
.delete-btn:hover {
    background-color: blue; /* Fixing typo, should be blue not #blue */
}


        </style>
   
    <div class="container">
        <div class="user">
            <div class='user'>
                <!-- Display user details -->
                
                <img src="<?php echo htmlspecialchars($row['photo']); ?>" alt="user Image" width="100">
                <p><strong>Name With Initials:</strong> <?php echo htmlspecialchars($row['nameWithInitials']); ?></p>
                <p><strong>First Name:</strong> <?php echo htmlspecialchars($row['firstname']); ?></p>
                <p><strong>Last Name:</strong> <?php echo htmlspecialchars($row['lastname']); ?></p>
                <p><strong>Birthday:</strong> <?php echo htmlspecialchars($row['dob']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($row['address']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($row['gender']); ?></p>
                <p><strong>occupation:</strong> <?php echo htmlspecialchars($row['occupation']); ?></p>
                <p><strong>marital Status:</strong> <?php echo htmlspecialchars($row['maritalStatus']); ?></p>

                <!-- Edit and delete buttons -->
                <a href='update_ID.php?id=<?php echo $row['id']; ?>'><button>Edit</button></a>
                <a href='delete_ID.php?id=<?php echo $row['id']; ?>'><button class="delete-btn">Delete</button></a>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    // Free result set
    mysqli_free_result($result);

    // Close connection
    mysqli_close($conn);
?>
