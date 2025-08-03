<?php
include 'connect.php';

// Get the email from URL parameter
if (!isset($_GET['email'])) {
    header('Location: submit_Donorlogin.php'); // Redirect to login if email is not set
    exit;
}

$email = $_GET['email'];

// Fetch donor details from the database
$sql = "SELECT * FROM donor WHERE D_email='$email'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $donor = mysqli_fetch_assoc($result);
} else {
    echo "No donor found.";
    exit;
}
// Fetch contacts
$contact_sql = "SELECT D_contact FROM DonorContact WHERE DonorId = " . $donor['DonorId'];
$contact_result = mysqli_query($conn, $contact_sql);
$contacts = [];
while ($row = mysqli_fetch_assoc($contact_result)) {
    $contacts[] = $row['D_contact'];
}
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the new values from the form
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $bloodGroup = $_POST['blood_group'];
    $quantity = $_POST['quantity'];

    // Update the donor information in the database
    $updateSql = "UPDATE donor SET 
                    D_firstName='$firstName', 
                    D_lastName='$lastName', 
                    D_gender='$gender',
                    D_email='$email',
                    D_password='$password',
                    D_address='$address',
                    D_bloodGroup='$bloodGroup', 
                    D_quantity='$quantity' 
                  WHERE D_email='$email'";

    if (mysqli_query($conn, $updateSql)) {
        // Redirect back to the profile page after successful update
        header('Location: Profile.php?email=' . urlencode($email));
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register as Donor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton+SC&family=Arvo:ital,wght@0,400;0,700;1,400;1,700&family=Baskervville+SC&family=Cabin:ital,wght@0,400..700;1,400..700&family=Caveat:wght@400..700&family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Crafty+Girls&family=Esteban&family=Great+Vibes&family=Merienda:wght@300..900&family=Odibee+Sans&family=Permanent+Marker&family=Rokkitt:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="editprofile.css" rel="stylesheet">
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
            <a href="donorLogin.html"><button class="butt">Back</button></a>
        </nav>
    </header>

        <div class="form-container">
        <h1>Edit Profile</h1>
        <form method="POST" action="edit_profileg.php">
            
            

            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" value="<?php echo htmlspecialchars($donor['D_firstName']); ?>" required>
            
            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" value="<?php echo htmlspecialchars($donor['D_lastName']); ?>" required>
            
            <label for="gender">Gender:</label>
            <select name="gender" required>
                <option value="Male" <?php if($donor['D_gender'] == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if($donor['D_gender'] == 'Female') echo 'selected'; ?>>Female</option>
            </select>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($donor['D_email']); ?>">
            
            <label for="password">Password:</label>
            <input type="password" name="password" value="<?php echo htmlspecialchars($donor['D_password']); ?>">
            
            <label for="address">Address:</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($donor['D_address']); ?>">

            <label for="blood_group">Blood Group:</label>
            <select id="blood_group" name="blood_group">
                <option value="" disabled>Select Blood Group</option>
                <option value="A+" <?php echo $donor['D_bloodGroup'] == 'A+' ? 'selected' : ''; ?>>A+</option>
                <option value="A-" <?php echo $donor['D_bloodGroup'] == 'A-' ? 'selected' : ''; ?>>A-</option>
                <option value="B+" <?php echo $donor['D_bloodGroup'] == 'B+' ? 'selected' : ''; ?>>B+</option>
                <option value="B-" <?php echo $donor['D_bloodGroup'] == 'B-' ? 'selected' : ''; ?>>B-</option>
                <option value="O+" <?php echo $donor['D_bloodGroup'] == 'O+' ? 'selected' : ''; ?>>O+</option>
                <option value="O-" <?php echo $donor['D_bloodGroup'] == 'O-' ? 'selected' : ''; ?>>O-</option>
                <option value="AB+" <?php echo $donor['D_bloodGroup'] == 'AB+' ? 'selected' : ''; ?>>AB+</option>
                <option value="AB-" <?php echo $donor['D_bloodGroup'] == 'AB-' ? 'selected' : ''; ?>>AB-</option>
            </select>

            <label for="quantity">Quantity:</label>
    <select id="quantity" name="quantity">
        <option value="350ml" <?php if($donor['D_quantity'] == '350ml') echo 'selected'; ?>>350ml</option>
        <option value="450ml" <?php if($donor['D_quantity'] == '450ml') echo 'selected'; ?>>450ml</option>
        <option value="500ml" <?php if($donor['D_quantity'] == '500ml') echo 'selected'; ?>>500ml</option>
        <option value="525ml" <?php if($donor['D_quantity'] == '525ml') echo 'selected'; ?>>525ml</option>
        <!-- Add other quantities as needed -->
    </select>


              <label for="contact">Contact:</label>
              <input type="tel" id="contact" name="contact" value="<?php echo isset($contacts[0]) ? htmlspecialchars($contacts[0]) : ''; ?>">
              
              <label for="contact2">Contact2:</label>
              <input type="tel" id="contact2" name="contact2" value="<?php echo isset($contacts[1]) ? htmlspecialchars($contacts[1]) : ''; ?>">
              
              <label for="contact3">Contact3:</label>
              <input type="tel" id="contact3" name="contact3" value="<?php echo isset($contacts[2]) ? htmlspecialchars($contacts[2]) : ''; ?>">

            <input type="submit" value="Update Profile">
            </form>
        </div>
    <br><br><br><br><br><br><br><br>

        <script src="" async defer></script>
    </body>
</html>
