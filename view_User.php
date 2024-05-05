<?php
    // Include database connection
    include 'dbh.php';

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
    $sql = "SELECT * FROM user WHERE id = $userId";
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <style>
       body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    background-image: url('image/userview.png'); /* Background image */
    background-size: cover;
    background-repeat: no-repeat;
    margin: 0;
    padding: 120px;
}

.container {
    max-width: 800px;
    margin: 120px auto; /* Shifted to the center */
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.9); /* Transparent background */
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.7);
}

.user {
    
    padding: 30px;
    
    text-align: center;
    margin-bottom: 20px;
   
}

.user img {
    display: block;
    margin: 0 auto 20px;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 4px solid #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

.user p {
    margin: 10px 0;
    font-size: 18px;
}

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

.user button:hover {
    background-color: red; /* Corrected color */
}

.delete-btn {
    background-color: red;
}

.delete-btn:hover {
    background-color: blue; /* Corrected color */
}

        </style>
    
    <div class="container">
        <div class="user">
            <div class='user'>
                <!-- Display user details -->
                
                <img src="<?php echo htmlspecialchars($row['photo']); ?>" alt="user Image" width="100">
                <p><strong>First Name:</strong> <?php echo htmlspecialchars($row['firstname']); ?></p>
                <p><strong>Last Name:</strong> <?php echo htmlspecialchars($row['lastname']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                <p><strong>Password:</strong> <?php echo htmlspecialchars($row['password']); ?></p>

                <!-- Edit and delete buttons -->
                <a href='update_user.php?id=<?php echo $row['id']; ?>'><button>Edit</button></a>
                <a href='delete_user.php?id=<?php echo $row['id']; ?>'><button class="delete-btn">Delete</button></a>
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
