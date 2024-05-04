<?php
// Include your database connection file (e.g., dbh.php)
include '../dbh.php';

// Check if the ID parameter is passed through the URL
if (isset($_GET['id'])) {
    // Retrieve the employee ID from the URL and sanitize it
    $id = intval($_GET['id']); // Assuming id is an integer

    // Delete the employee record from the database
    $sql = "DELETE FROM id_card WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        // Redirect to view_employee.php after successful deletion
        header("Location: ../dashboard.php");
        exit();
    } else {
        echo "Error deleting employee: " . mysqli_error($conn);
    }
} else {
    // ID parameter is not provided
    echo "Employee ID not specified.";
}
?>
