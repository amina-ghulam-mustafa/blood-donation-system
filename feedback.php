<?php
session_start();

if (!isset($_SESSION['DonorId'])) {
    die("Error: No valid DonorId found.");
}

$donor_id = $_SESSION['DonorId'];

include 'connect.php'; 

$feedbackSubmitted = false;
$error = '';
$showForm = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feedback = isset($_POST['feedback']) ? trim($_POST['feedback']) : '';

    if (empty($feedback)) {
        $error = "Please enter your feedback before submitting.";
        $showForm = true;
    } else {
        $sql = "INSERT INTO Feedback (DonorId, FeedbackDescription) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("is", $donor_id, $feedback);

        if ($stmt->execute()) {
            $feedbackSubmitted = true;
            $showForm = false;
        } else {
            $error = "Error: " . $stmt->error;
            $showForm = true;
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback</title>
    <style>
        .confirmation-message {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
        #div {
            height: 50%;
            width: 50%;
            padding: 20px;
            margin: auto;
            margin-top: 250px;
            background-color: floralwhite;
            text-align: center;
        }
        .ok-button {
            padding: 10px 20px;
            background-color: green;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        .ok-button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function showAlert(message, redirectUrl) {
            alert(message);
            window.location.href = redirectUrl;
        }

        function showConfirmation(message, redirectUrl) {
            document.getElementById('confirmation-message').innerText = message;
            document.getElementById('confirmation-section').style.display = 'block';
            document.getElementById('ok-button').onclick = function() {
                window.location.href = redirectUrl;
            };
        }
    </script>
</head>
<body>

    <div class="feedback-form">
        <?php if ($feedbackSubmitted): ?>
            <div id="div">
                <script>
                    window.onload = function() {
                        showConfirmation("Thank you! Your feedback has been submitted successfully.", "feedback.html");
                    };
                </script>
                <div id="confirmation-section" style="display:none;">
                    <p id="confirmation-message" class="confirmation-message"></p>
                    <button id="ok-button" class="ok-button">OK</button>
                </div>
            </div>
        <?php else: ?>
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>