
<?php
include 'connect.php';

$team_id = 1;
if (isset($_POST['submit'])) { 
    if (empty($_POST['first_name'])) {
        echo "First name is required!<br>";
    } else {
        $firstName = trim($_POST['first_name']);
    }

    if (empty($_POST['last_name'])) {
        echo "Last name is required!<br>";
    } else {
        $lastName = trim($_POST['last_name']);
    }

    if (empty($_POST['gender'])) {
        echo "Gender is required!<br>";
    } else {
        $gender = trim($_POST['gender']);
    }

    if (empty($_POST['blood_group'])) {
        $errors[] = 'Blood group is required!';
    } else {
        $bloodGroup = $_POST['blood_group'];
    }
    

    if (empty($_POST['contact'])) {
        echo "Contact number is required!<br>";
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
        echo "Address is required!<br>";
    } else {
        $address = trim($_POST['address']);
    }

    if (!empty($firstName) && !empty($lastName) && !empty($gender) && !empty($bloodGroup) && !empty($contact) && !empty($address)) {

        // Insert into Recipient table
        $recipientSql = "INSERT INTO recipient (R_firstName, R_lastName, R_gender, R_address, R_bloodGroup, RTeam_id)
                     VALUES ('$firstName', '$lastName', '$gender', '$address', '$bloodGroup', $team_id)";
        
        if ($conn->query($recipientSql) === TRUE) {
            $recipientId = $conn->insert_id;
            $contactSql = "INSERT INTO recipientContact (RecipientId, R_contact) 
                           VALUES ('$recipientId', '$contact')";
            
            if ($conn->query($contactSql) === TRUE) {
                // Insert additional contacts if provided
                echo "Recipient registered successfully!<br>";
                echo "First Name: " . $firstName . "<br>";
                echo "Last Name: " . $lastName . "<br>";
                echo "Gender: " . $gender . "<br>";
                echo "Blood Group: " . $bloodGroup . "<br>";
                echo "Address: " . $address . "<br>";

            // Print the primary contact
                echo "Contact: " . $contact . "<br>";

                // Insert and print additional contacts if provided
                foreach ($contacts as $additionalContact) {
                    $contactSql = "INSERT INTO recipientContact (RecipientId, R_contact) 
                                   VALUES ('$recipientId', '$additionalContact')";
                    if ($conn->query($contactSql) === TRUE) {
                        echo "Additional Contact: " . $additionalContact . "<br>";
                    } else {
                        echo "Error inserting additional contact: " . $conn->error;
                    }
                }

            } else {
                echo "Error inserting contact: " . $conn->error;
            }
        } else {
            echo "Error inserting recipient: " . $conn->error;
        }
    } else {
        echo "<br>Due to empty fields, we cannot process the registration.<br>";
    }
} else {
    echo "Please submit the form first!";
}

?>
