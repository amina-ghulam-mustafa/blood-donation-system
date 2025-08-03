<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Blood</title>
    <link rel="stylesheet" href="SearchDonor.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton+SC&family=Arvo:ital,wght@0,400;0,700;1,400;1,700&family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Crafty+Girls&display=swap" rel="stylesheet">
    <style>
         * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Poppins', sans-serif;
                font-size: 16px;              }

            body {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                background-image: url(needle2.jpg);
                background-size: cover;
            }
            header {
                position: relative;
                top: 0;
                left: 0;
                width: 100%;
                height: 20hv;
                padding: 20px 70px;
                background-color: rgb(255, 255, 255);
                display: flex;
                justify-content: space-between;
                align-items: center;
                z-index: 99;
                box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
            }
            .logo {
                user-select: none;
                font-size: 35px; 
                color: rgb(148, 12, 12);
                text-align: left;
                margin-top: 22px;
                margin-left: 10px;
                text-shadow: 0px 0px 4px #928f8f;
                font-family: "Chakra Petch", sans-serif;
                font-weight: 700;
            }
            .logoim {
                user-select: none;
                width: 80px;
                height: 80px;
                color: white;
            }
            .box {
                display: flex;
            }
            .navigation a {
                position: relative;
                font-size: 1.2em;
                color: #000000;
                text-decoration: none;
                font-weight: 500;
                margin-left: 40px;
                font-family: "Arvo", serif;
                font-weight: 400;
            }
            .navigation .butt {
                width: 100px;
                height: 40px;
                border-radius: 10px;
                cursor: pointer;
                font-size: 1em;
                color: rgb(0, 0, 0);
                margin-left: 40px;
                font-family: "Arvo", serif;
                font-weight: 700;
            }
            .navigation .butt:hover {
                background-color: rgb(0, 0, 0);
                color: #fff;
            }
        .dashboard {
            max-width: 100%;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(242, 242, 244, 0.1);
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-left: 100px;
        }
        .dashboard-header h1{
            color: black;
        }
        .dashboard h1 {
            font-size: 30px;
            color: #fff;
            margin-top: 20px;
            margin-left: 100px;
            letter-spacing: 2px;
            font-family: "Anton SC", sans-serif;
            font-weight: 400;
        }
        .donor-list {
            margin-top: 20px;
        }
        .donor-card {
            justify-content: space-between;
            background-color: white;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            width: 30%;
            border: 2px solid black;
            margin-left: 50px;      
        }
        .donor-card h2 {
            margin-top: 0;
        }
     
        .contacts-button {      
            background-color: #9e0000;
            color: white;
            border: none;
            padding: 10px;
            width: 30%;
            text-align: center;
            cursor: pointer;
            font-size: 16px;
            border-radius: 20px;
            box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.6);
            margin-left: 70%;
        }     
        .contacts-button:hover {
            background-color: #333;
        }
        .banks{
            background-color: white;
            padding: 10px;
            font-size: 16px;
            border-radius: 20px;   
            margin-right: 50px;
        }
        .banks:hover{
            background-color: black;
            color: white;
            border: 2px solid white;
        }

        #popup {
            display: none; 
            position: fixed; 
            top: 50%; 
            left: 50%; 
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: white;
            border: 2px solid #9e0000;
            z-index: 1000;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.5);
            border-radius: 10px;
            width: 80%; 
            max-width: 600px; 
            font-family: 'Poppins', sans-serif;
        }
        #popup-content {
            margin-bottom: 20px;
            font-size: 16px;
            color: black;
        }
        #popup button {
            background-color: #9e0000;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.3);
        }
        #popup button:hover {
            background-color: #333;
        }
        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }



    </style>
</head>
<body>
<header>    
        <div class="box">
            <img class="logoim" src="iconnn.jpg" alt="logo">
            <h2 class="logo">Donate Blood </h2>
        </div>
        <nav class="navigation">
            <a href="HomePage1st.html">Home</a>
            <a href="RecipientForm.html">Find Blood</a>
            <a href="health.html">Register Now</a>
            <a href="about.html">About Us</a>
            <a href="feedback.html">Feedback</a>
            <a href="admin1.html"><button class="butt">Log in</button></a> 
        </nav>
    </header>

    <div class="dashboard">
        <div class="dashboard-header">
            <h1 style="color: black">Donors Details</h1>
            <h2><div> <a href="searchBloodBank.html"><button class="banks">Contacts for relevant blood banks →</button></a>
            </h2>
            </div>
       <div>
    </div>

    <div class="container">
        <div class="donor-list">


        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "blood_donation";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $search = $_GET['search'] ?? '';
        $sql = "SELECT DonorId, D_firstName, D_lastName, D_email, D_bloodGroup, D_quantity FROM Donor WHERE D_firstName LIKE ? OR D_lastName LIKE ?";
        $stmt = $conn->prepare($sql);
        $search_param = '%' . $search . '%';
        $stmt->bind_param("ss", $search_param, $search_param);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $donorDetails = htmlspecialchars($row["D_firstName"]) . " " . htmlspecialchars($row["D_lastName"]) . "\\n" .
                                "Email: " . htmlspecialchars($row["D_email"]) . "\\n" .
                                "Blood Group: " . htmlspecialchars($row["D_bloodGroup"]) . "\\n" .
                                "Quantity: " . htmlspecialchars($row["D_quantity"]) . " ml";

                echo "<div class='donor-card'>";
                echo "<h2>" . htmlspecialchars($row["D_firstName"]) . " " . htmlspecialchars($row["D_lastName"]) . "</h2>";
                echo "<p>Email: " . htmlspecialchars($row["D_email"]) . "</p>";
                echo "<p>Blood Group: " . htmlspecialchars($row["D_bloodGroup"]) . "</p>";
                echo "<p>Quantity: " . htmlspecialchars($row["D_quantity"]) . " ml</p>";
                echo "<button class='contacts-button' onclick='showPopup(\"$donorDetails\")'>Click here to hire</button>";
                echo "</div>";
            }
        } else {
            echo "<p>No donors found.</p>";
        }

        $conn->close();
        ?>
        </div>
        </div>

        <div id="overlay"></div>

        <div id="popup">
            <div id="popup-content"></div>
            <p>has been Hired Successfully!</p>
            <button onclick="closePopup()">OK</button>
        </div>

</div>
    
<script>
function showPopup(details) {
    document.getElementById('popup-content').textContent = details ;
    document.getElementById('popup').style.display = 'block';
    document.getElementById('overlay').style.display = 'block'; // Show overlay
}

function closePopup() {
    document.getElementById('popup').style.display = 'none';
    document.getElementById('overlay').style.display = 'none'; // Hide overlay
}
</script>


</body>
</html>