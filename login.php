<?php
// Start a session to track user login status
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "ikiraro_project");  // Adjust as needed
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Get the input values from the form
    $telephone = mysqli_real_escape_string($conn, $_GET['telephone']);
    $email = mysqli_real_escape_string($conn, $_GET['email']);
    $password = mysqli_real_escape_string($conn, $_GET['password']);

    // Query to check if user exists with the provided telephone and email
    $sql = "SELECT * FROM create_account WHERE telephone = ? AND email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $telephone, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if any record matches the provided credentials
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password matches, login successful
            $_SESSION['user_id'] = $user['id']; // Store the user's ID in the session
            $_SESSION['email'] = $user['email'];
            $_SESSION['telephone'] = $user['telephone'];

            // Redirect to service page after successful login
            header("Location: service.html");
            exit();
        } else {
            // Password does not match
            echo "<script>alert('Invalid password. Please try again.');</script>";
        }
    } else {
        // No user found with the provided telephone and email
        echo "<script>alert('No user found with the provided telephone and email.');</script>";
    }

    // Close the statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
