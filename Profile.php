<?php
session_start();
include 'connect.php';

// Check if DonorId is set in the session
if (!isset($_SESSION['DonorId'])) {
    header('Location: donorlogin.html'); // Redirect to login page if not logged in
    exit;
}

$donor_id = $_SESSION['DonorId'];

// Prepare and execute the SQL statement to fetch donor details
$sql = "SELECT D_firstName, D_lastName, D_bloodGroup, D_quantity FROM donor WHERE DonorId = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . htmlspecialchars($conn->error));
}

$stmt->bind_param("i", $donor_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $donor = $result->fetch_assoc();
} else {
    echo "No donor found.";
    exit;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Anton+SC&family=Arvo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Basic Styles */
        body, button, input, textarea {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Header Styles */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px 100px;
            background-color: #fff;
            display: flex;
            align-items: center;
            z-index: 99;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
        }

        .logo {
            font-size: 2em; 
            color: #940C0C;
            text-shadow: 2px 2px 5px #928f8f;
            font-family: "Chakra Petch", sans-serif;
            font-weight: 700;
        }

        .logoim {
            width: 80px;
            height: 80px;
        }

        .box {
            display: flex;
        }

        .navigation a {
            font-size: 1.4em;
            color: #000;
            text-decoration: none;
            margin-left: 40px;
            font-family: "Arvo", serif;
            font-weight: 400;
        }

        .navigation .butt {
            width: 130px;
            height: 50px;
            border: 2px solid black;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.5em;
            margin-left: 40px;
            transition: .5s;
            font-family: "Arvo", serif;
            font-weight: 700;
        }

        .navigation .butt:hover {
            background-color: #2EA241;
            color: #162938;
        }

        .banner {
            background-color: #8B0000;
            height: 50px;
            margin-top: 120px; /* Adjusted for fixed header */
        }

        /* Profile Container */
        .profile-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            text-align: center;
        }

        .profile-header {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        .profile-image img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 2px solid #940C0C;
        }

        .profile-name {
            margin-left: 20px;
        }

        .profile-name h1 {
            margin: 0;
            font-size: 2em;
            color: #940C0C;
        }

        .edit-profile {
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
            background-color: #940C0C;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .edit-profile:hover {
            background-color: #ff6347;
        }

        /* Donation History */
        .donation-history {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
        }

        .donation-history h3 {
            text-align: center;
            color: #940C0C;
        }

        .donation-history table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .donation-history th, .donation-history td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        .donation-history th {
            background-color: #940C0C;
            color: white;
        }

        .donation-history tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Feedback Prompt Styles */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 100;
        }

        .feedback-prompt {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
            z-index: 101;
        }

        .feedback-prompt h3 {
            margin: 0 0 10px;
        }

        .button {
            padding: 10px 20px;
            font-size: 1em;
            margin: 5px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #ff6347;
            color: #fff;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                padding: 20px;
            }

            .navigation a {
                margin-left: 10px;
                font-size: 1.2em;
            }

            .navigation .butt {
                margin-left: 10px;
                width: 100px;
                height: 40px;
                font-size: 1.2em;
            }

            .profile-header {
                flex-direction: column;
            }

            .profile-name {
                margin-left: 0;
                margin-top: 20px;
            }

            .donation-history {
                padding: 10px;
            }

            .donation-history table, .donation-history th, .donation-history td {
                font-size: 0.9em;
            }
        }
    </style>
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
            <a href="donorDetails.html"><button class="butt">Back</button></a>
        </nav>
    </header>

    <div class="banner"></div>

    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-image">
                <img src="profile.png" alt="Profile Image">
            </div>
            <div class="profile-name">
                <h1>Welcome, <?php echo htmlspecialchars($donor['D_firstName']) . ' ' . htmlspecialchars($donor['D_lastName']); ?></h1>
                <!-- Edit Profile Button -->
                <button class="edit-profile" onclick="location.href='edit_profileg.php'">Edit Profile</button>
            </div>
        </div>
    </div>

    <div class="donation-history">
        <h3>Donation History</h3>
        <table>
            <tr>
                <th>Blood Group</th>
                <th>Quantity</th>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($donor['D_bloodGroup']); ?></td>
                <td><?php echo htmlspecialchars($donor['D_quantity']); ?> units</td>
            </tr>
        </table>
    </div> 

    <!-- Feedback Prompt -->
    <div class="overlay" id="overlay"></div>
    <div class="feedback-prompt" id="feedbackPrompt">
        <h3>Would you like to provide feedback?</h3>
        <button class="button" onclick="window.location.href='feedback.html'">Yes</button>
        <button class="button" onclick="hideFeedbackPrompt()">No</button>
    </div>

    <script>
        setTimeout(function() {
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('feedbackPrompt').style.display = 'block';
        }, 5000);

        function hideFeedbackPrompt() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('feedbackPrompt').style.display = 'none';
        }
    </script> 

</body>
</html>