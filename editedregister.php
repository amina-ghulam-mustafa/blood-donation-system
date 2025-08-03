<?php
session_start();
include 'connect.php'; 

if (!isset($_SESSION['donor_id'])) {
    header("Location: donorLogin.html");
    exit();
}

$donorId = $_SESSION['donor_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    $firstName = !empty($_POST['first_name']) ? trim($_POST['first_name']) : null;
    $lastName = !empty($_POST['last_name']) ? trim($_POST['last_name']) : null;
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $gender = !empty($_POST['gender']) ? trim($_POST['gender']) : null;
    $bloodGroup = !empty($_POST['blood_group']) ? trim($_POST['blood_group']) : null;
    $quantity = !empty($_POST['quantity']) ? trim($_POST['quantity']) : null;
    $contact = !empty($_POST['contact']) ? trim($_POST['contact']) : null;
    $contact2 = !empty($_POST['contact2']) ? trim($_POST['contact2']) : null;
    $contact3 = !empty($_POST['contact3']) ? trim($_POST['contact3']) : null;
    $address = !empty($_POST['address']) ? trim($_POST['address']) : null;

    if (!$firstName) $errors[] = "First name is required!";
    if (!$lastName) $errors[] = "Last name is required!";
    if (!$email) $errors[] = "Email is required!";
    if (!$password) $errors[] = "Password is required!";
    if (!$gender) $errors[] = "Gender is required!";
    if (!$bloodGroup) $errors[] = "Blood group is required!";
    if (!$quantity) $errors[] = "Quantity is required!";
    if (!$contact) $errors[] = "Primary contact is required!";
    if (!$address) $errors[] = "Address is required!";

    if (empty($errors)) {
        $updateDonorSql = "UPDATE Donor 
                           SET D_firstName=?, D_lastName=?, D_gender=?, D_address=?, D_quantity=?, D_bloodGroup=?, D_email=?, D_password=? 
                           WHERE DonorId=?";
        $stmt = $conn->prepare($updateDonorSql);
        $stmt->bind_param("ssssssssi", $firstName, $lastName, $gender, $address, $quantity, $bloodGroup, $email, $password, $donorId);

        if ($stmt->execute()) {
            $fetchContactsSql = "SELECT D_contact FROM DonorContact WHERE DonorId=?";
            $stmt = $conn->prepare($fetchContactsSql);
            $stmt->bind_param("i", $donorId);
            $stmt->execute();
            $existingContacts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $existingContactsMap = array_flip(array_column($existingContacts, 'D_contact'));

            $newContacts = [$contact, $contact2, $contact3];

            foreach ($newContacts as $index => $newContact) {
                if (!empty($newContact)) {
                    if (isset($existingContacts[$index])) {
                        if ($newContact != $existingContacts[$index]['D_contact']) {
                            $updateContactSql = "UPDATE DonorContact SET D_contact=? WHERE DonorId=? AND D_contact=?";
                            $stmt = $conn->prepare($updateContactSql);
                            $stmt->bind_param("sis", $newContact, $donorId, $existingContacts[$index]['D_contact']);
                            $stmt->execute();
                        }
                    } else {
                        $insertContactSql = "INSERT INTO DonorContact (DonorId, D_contact) VALUES (?, ?)";
                        $stmt = $conn->prepare($insertContactSql);
                        $stmt->bind_param("is", $donorId, $newContact);
                        $stmt->execute();
                    }
                } else {
                    if (isset($existingContacts[$index])) {
                        $deleteContactSql = "DELETE FROM DonorContact WHERE DonorId=? AND D_contact=?";
                        $stmt = $conn->prepare($deleteContactSql);
                        $stmt->bind_param("is", $donorId, $existingContacts[$index]['D_contact']);
                        $stmt->execute();
                    }
                }
            }

            header("Location: registeredProfile.php"); 
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
} else {
    $donorSql = "SELECT * FROM Donor WHERE DonorId=?";
    $stmt = $conn->prepare($donorSql);
    $stmt->bind_param("i", $donorId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $donor = $result->fetch_assoc();
        
        $fetchContactsSql = "SELECT D_contact FROM DonorContact WHERE DonorId=?";
        $stmt = $conn->prepare($fetchContactsSql);
        $stmt->bind_param("i", $donorId);
        $stmt->execute();
        $existingContacts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $contacts = array_column($existingContacts, 'D_contact');
        
        $contact = isset($contacts[0]) ? $contacts[0] : '';
        $contact2 = isset($contacts[1]) ? $contacts[1] : '';
        $contact3 = isset($contacts[2]) ? $contacts[2] : '';
    } else {
        echo "Error fetching donor data.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register as Donor</title>
    <link rel="stylesheet" href="editprofile.css">
    <link href="https://fonts.googleapis.com/css2?family=Arvo:wght@400;700&display=swap" rel="stylesheet">
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
    <h1>Edit Profile</h1><br><br>
    <form action="editedregister.php" method="post">

        <label for="first_name">Full Name:</label>
        <div class="first">
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($donor['D_firstName']); ?>" placeholder="First Name">
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($donor['D_lastName']); ?>" placeholder="Last Name">
        </div>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($donor['D_email']); ?>" placeholder="abc123@gmail.com">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" minlength="8" value="<?php echo htmlspecialchars($donor['D_password']); ?>">

        <label>Gender:</label>
        <div class="gender">
            <label><input type="radio" name="gender" value="Male" <?php if(isset($donor['D_gender']) && $donor['D_gender'] == 'Male') echo 'checked'; ?>> Male</label>
            <label><input type="radio" name="gender" value="Female" <?php if(isset($donor['D_gender']) && $donor['D_gender'] == 'Female') echo 'checked'; ?>> Female</label>
        </div>

        <div class="mother">
            <div class="c1">
                <label for="blood_group">Blood Group:</label>
                <select id="blood_group" name="blood_group" required>
                    <option value="" disabled selected>Blood type</option>
                    <option value="A+" <?php if($donor['D_bloodGroup'] == 'A+') echo 'selected'; ?>>A+</option>
                    <option value="A-" <?php if($donor['D_bloodGroup'] == 'A-') echo 'selected'; ?>>A-</option>
                    <option value="B+" <?php if($donor['D_bloodGroup'] == 'B+') echo 'selected'; ?>>B+</option>
                    <option value="B-" <?php if($donor['D_bloodGroup'] == 'B-') echo 'selected'; ?>>B-</option>
                    <option value="O+" <?php if($donor['D_bloodGroup'] == 'O+') echo 'selected'; ?>>O+</option>
                    <option value="O-" <?php if($donor['D_bloodGroup'] == 'O-') echo 'selected'; ?>>O-</option>
                    <option value="AB+" <?php if($donor['D_bloodGroup'] == 'AB+') echo 'selected'; ?>>AB+</option>
                    <option value="AB-" <?php if($donor['D_bloodGroup'] == 'AB-') echo 'selected'; ?>>AB-</option>
                </select>
            </div>
            <label for="quantity">Quantity:</label>
              <select id="quantity" name="quantity">
                <option value="" >select quantity</option>
                <option value="350ml" <?php echo $donor['D_quantity'] == '350ml' ? 'selected' : ''; ?>>350ml</option>
                <option value="450ml" <?php echo $donor['D_quantity'] == '450ml' ? 'selected' : ''; ?>>450ml</option>
                <option value="500ml" <?php echo $donor['D_quantity'] == '500ml' ? 'selected' : ''; ?>>500ml</option>
                <option value="525ml" <?php echo $donor['D_quantity'] == '525ml' ? 'selected' : ''; ?>>525ml</option>
              </select>
        </div>

        <label for="contact">Primary Contact:</label>
        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($contact); ?>" placeholder="+923XX-XXXXXXX" maxlength="13">
        
        <label for="contact2">Alternate Contact 1:</label>
        <input type="text" id="contact2" name="contact2" value="<?php echo htmlspecialchars($contact2); ?>" placeholder="+923XX-XXXXXXX" maxlength="13">
        
        <label for="contact3">Alternate Contact 2:</label>
        <input type="text" id="contact3" name="contact3" value="<?php echo htmlspecialchars($contact3); ?>" placeholder="+923XX-XXXXXXX" maxlength="13">

        <label for="address">Address:</label>
        <textarea id="address" name="address" rows="3"><?php echo htmlspecialchars($donor['D_address']); ?></textarea>

        <input type="submit" value="Update Profile" class="btn">
    </form>
</div>
</body>
</html>
