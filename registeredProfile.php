<?php
include 'connect.php';

session_start();
$donorId = $_SESSION['donor_id'];

// Fetch donor details
$sql = "SELECT D_firstName, D_lastName, D_gender, D_bloodGroup, D_quantity FROM Donor WHERE DonorId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $donorId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $firstName = $row['D_firstName'];
    $lastName = $row['D_lastName'];
    $gender = $row['D_gender'];
    $bloodGroup = $row['D_bloodGroup'];
    $quantity = $row['D_quantity'];
} else {
    echo "No details found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="profileStyle.css" rel="stylesheet">
</head>
<body>

<header>
    <div class="box">
        <img class="logoim" src="iconnn.jpg" alt="logo">
        <h2 class="logo">Donate Blood</h2>
    </div>
    <nav class="navigation">
        <a href="HomePage1st.html">Home</a>
        <a href="RecipientForm.html">Find Blood</a>
        <a href="health.html">Register Now</a>
        <a href="about.html">About Us</a>
        <a href="feedback.html">Feedback</a> 
    </nav>
</header>
<div class="banner"></div>

<div class="profile-container">
    <div class="profile-header">
        <div class="profile-image">
        <img src="profile.png" alt="Profile Image">
            </div>
            <div class="profile-name">
                <h1>Welcome <?php echo htmlspecialchars($firstName); ?></h1><br>
               <a href="editedregister.php" class="edit-profile">Edit Profile</a>
    </div>
        </div>
    </div>

<!-- <div class="profile-container"> -->
<div class="donation-history">
    <h1>Donation History</h1>
    <table>
        <tr>
            <th>Blood Group</th>
            <th>Blood Units</th>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($bloodGroup); ?></td>
            <td><?php echo htmlspecialchars($quantity); ?></td>
        </tr>
    </table>
    <!-- <a href="editedregister.php" class="edit-profile">Edit Profile</a> -->
</div>

<footer>
    <!-- Footer content here -->
</footer>
</body>
</html>