<?php
  
  include 'connect.php';


$username = $_POST['username'];
$password = $_POST['password'];

// Check if admin exists and password matches
$sql = "SELECT * FROM admin WHERE username='$username'";
$result = mysqli_query($conn, $sql);

if ($result) {
    // Verify the admin's details
    if (mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
        if ($admin['admin_password'] == $password) { 
            header('Location: admin2.html');
        } else {
            echo "Incorrect password. Please try again.";
        }
    } else {
        echo "No admin found with this username.";
    }
} else {
    // Display query error for debugging
    echo "Error in query: " . mysqli_error($conn);
}
    mysqli_close($conn);

?>