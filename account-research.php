<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "ikiraro project");

if (!$conn) {
    die("Connection error: " . mysqli_connect_error());
} else {
    // Retrieve POST data
    $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
    $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
    $telephone = mysqli_real_escape_string($conn, $_POST["telephone"]);
    $continent = mysqli_real_escape_string($conn, $_POST["continent"]);
    $country = mysqli_real_escape_string($conn, $_POST["country"]);
    $city = mysqli_real_escape_string($conn, $_POST["city"]);
    $idcard = mysqli_real_escape_string($conn, $_POST["idcard"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);

    // Check if password and confirm password match
    if ($_POST["password"] === $_POST["confirmpassword"]) {
        // Hash the password before storing
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    } else {
        die("Passwords do not match.");
    }

    // Use prepared statements to prevent SQL injection
    $sql = "INSERT INTO `signup` (firstname, lastname, telephone, continent, country, city, idcard, email, password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sssssssss", $firstname, $lastname, $telephone, $continent, $country, $city, $idcard, $email, $password);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Redirect to another page on success
        header("Location: appreciate-research.html");
        exit();  // Ensure no further code is executed after redirect
    } else {
        die("Error inserting data: " . mysqli_error($conn));
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
