<?php
session_start(); // Start the session at the beginning

include 'connect.php';

$team_id = 1;

if (isset($_POST['submit'])) { 
    $errors = [];

    if (empty($_POST['first_name'])) {
        $errors[] = "First name is required!";
    } else {
        $firstName = trim($_POST['first_name']);
    }

    if (empty($_POST['last_name'])) {
        $errors[] = "Last name is required!";
    } else {
        $lastName = trim($_POST['last_name']);
    }

    if (empty($_POST['gender'])) {
        $errors[] = "Gender is required!";
    } else {
        $gender = trim($_POST['gender']);
    }

    if (empty($_POST['blood_group'])) {
        $errors[] = "Blood group is required!";
    } else {
        $bloodGroup = $_POST['blood_group'];
    }

    if (empty($_POST['quantity'])) {
        $errors[] = "Quantity is required!";
    } else {
        $quantity = trim($_POST['quantity']);
    }

    if (empty($_POST['contact'])) {
        $errors[] = "Contact number is required!";
    } else {
        $contact = trim($_POST['contact']);
    }

    $contacts = [];
    if (!empty($_POST['contact2'])) {
        $contacts[] = trim($_POST['contact2']);
    }
    if (!empty($_POST['contact3'])) {
        $contacts[] = trim($_POST['contact3']);
    }

    if (empty($_POST['address'])) {
        $errors[] = "Address is required!";
    } else {
        $address = trim($_POST['address']);
    }
    if (empty($_POST['email'])) {
        $errors[] = "Email is required!";
    } else {
        $email = trim($_POST['email']);
    }

    if (empty($_POST['password'])) {
        $errors[] = "Password is required!";
    } else {
        $password = trim($_POST['password']);
    }

    if (empty($errors)) {
        // Insert into Donor table
        $donorSql = "INSERT INTO Donor (D_firstName, D_lastName, D_gender, D_address, D_quantity, D_bloodGroup, D_email, D_password, RTeam_id)
                     VALUES ('$firstName', '$lastName', '$gender', '$address', '$quantity', '$bloodGroup', '$email', '$password', $team_id)";
        
        if ($conn->query($donorSql) === TRUE) {
            // Get the last inserted donor ID and store it in the session
            $donorId = $conn->insert_id;
            $_SESSION['donor_id'] = $donorId; // Store donor ID in session

            // Insert primary contact into DonorContact table
            $contactSql = "INSERT INTO DonorContact (DonorId, D_contact) 
                           VALUES ('$donorId', '$contact')";
            if ($conn->query($contactSql) === TRUE) {
                echo "
                <!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Donor Registration Details</title>
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link href='https://fonts.googleapis.com/css2?family=Anton+SC&family=Arvo:ital,wght@0,400;0,700;1,400;1,700&family=Baskervville+SC&family=Cabin:ital,wght@0,400..700;1,400..700&family=Caveat:wght@400..700&family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Crafty+Girls&family=Esteban&family=Great+Vibes&family=Merienda:wght@300..900&family=Odibee+Sans&family=Permanent+Marker&family=Rokkitt:ital,wght@0,100..900;1,100..900&display=swap' rel='stylesheet'>
    <link href='detailDonor.css' rel='stylesheet'>
</head>
<body>

<header>    
    <div class='box'>
        <img class='logoim' src='iconnn.jpg' alt='logo'>
        <h2 class='logo'>Donate Blood</h2>
    </div>
    <nav class='navigation'>
        <a href='HomePage1st.html'>Home</a>
            <a href='RecipientForm.html'>Find Blood</a>
            <a href='health.html'>Register Now</a>
            <a href='about.html'>About Us</a>
            <a href='feedback.html'>Feedback</a> 
            <a href='Donor_registration.html'><button class='butt'>Back</button></a>
    </nav>
</header>
<div class='container'>
    <img src='success.png' alt='success' id='success-img'>
    <div class='success-message'>Congrats you are eligible to donate blood. Here are your donor details:</div>
                <table class='details-table'>
                    <tr>
                        <th>First Name:</th>
                        <td>$firstName</td>
                    </tr>
                    <tr>
                        <th>Last Name:</th>
                        <td>$lastName</td>
                    </tr>
                    <tr>
                        <th>Gender:</th>
                        <td>$gender</td>
                    </tr>
                    <tr>
                        <th>Blood Group:</th>
                        <td>$bloodGroup</td>
                    </tr>
                    <tr>
                        <th>Quantity:</th>
                        <td>$quantity</td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td>$address</td>
                    </tr>
                    <tr>
                        <th>Contact:</th>
                        <td>$contact</td>
                    </tr>
                ";

                // Insert and print additional contacts if provided
                foreach ($contacts as $additionalContact) {
                    $contactSql = "INSERT INTO DonorContact (DonorId, D_contact) 
                                   VALUES ('$donorId', '$additionalContact')";
                    if ($conn->query($contactSql) === TRUE) {
                        echo "<tr>
                                <th>Additional Contact:</th>
                                <td>$additionalContact</td>
                              </tr>";
                    } else {
                        echo "Error inserting additional contact: " . $conn->error;
                    }
                }
                echo "</table>
                ";
            } else {
                
                echo "Error inserting contact: " . $conn->error;
            }
        } else {
            echo "Error inserting donor: " . $conn->error;
        }
    } else {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo "<br>Due to empty fields, we cannot process the registration.<br>";
    }
} else {
    echo "Please submit the form first!";
}
?>
<div class="btn">
    <a href="registeredProfile.php"><button type="button">Next</button></a>
</div>