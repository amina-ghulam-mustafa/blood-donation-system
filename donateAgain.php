<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $donor_id = $_POST['donor_id'];
    $blood_group = $_POST['blood_group'];
    $quantity = $_POST['quantity'];

    // Check if donor_id exists in the Donor table
    $check_donor_query = "SELECT DonorId FROM Donor WHERE DonorId = ?";
    $stmt = $conn->prepare($check_donor_query);
    $stmt->bind_param("i", $donor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "Error: Donor with ID $donor_id does not exist.";
        exit; // Stop the script
    }

    // Insert a new blood record in the 'blood' table
    $insert_blood_query = "INSERT INTO blood (bloodGroup_type, bb_id) VALUES (?, 1)"; // Assuming bb_id = 1
    $stmt = $conn->prepare($insert_blood_query);
    $stmt->bind_param("s", $blood_group);

    if ($stmt->execute()) {
        // Retrieve the blood_id of the newly inserted blood record
        $blood_id = $stmt->insert_id;

        // Now insert into the DonorBlood table to link the donor with the blood_id
        $insert_donor_blood_query = "INSERT INTO DonorBlood (DonorId, blood_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_donor_blood_query);
        $stmt->bind_param("ii", $donor_id, $blood_id);

        if ($stmt->execute()) {
            echo "<script>alert('Donation recorded successfully'); window.location.href = 'Profile.php?email=" . urlencode($_GET['email']) . "';</script>";
        } else {
            echo "Error inserting into DonorBlood table: " . $stmt->error;
        }
    } else {
        echo "Error inserting into blood table: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
