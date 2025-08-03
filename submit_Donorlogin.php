<?php
session_start();

include 'connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email exists in the database
    $sql = "SELECT * FROM donor WHERE D_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $donor = $result->fetch_assoc();

        // Directly compare the entered password with the stored password (plain text)
        if ($password === $donor['D_password']) {
            // Password is correct, start a session
            $_SESSION['DonorId'] = $donor['DonorId'];
            header('Location: Profile.php');
            exit;
        } else {
            // Incorrect password
            echo "Incorrect password. Please try again.";
        }
    } else {
        // No donor found with this email
        echo "No donor found with this email.";
    }

    $stmt->close();
    $conn->close();
}
?>