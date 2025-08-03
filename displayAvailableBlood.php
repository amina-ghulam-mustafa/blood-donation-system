<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listed Blood Group</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton+SC&family=Arvo:wght@400;700&display=swap" rel="stylesheet">
    <link href="listedStyle.css" rel="stylesheet">
    <style>
        * {
     margin: 0;
     padding: 0;
     box-sizing: border-box;
     font-family: 'Poppins', sans-serif;
    }
    img:hover{

transform: scale(1.2);
transition: all 2s;
}
    header {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
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
                font-size: 2em; 
                color: rgb(148, 12, 12);
                text-align: left;
                margin-top: 22px;
                margin-left: 10px;
                text-shadow: 2px 2px 5px #928f8f;
                font-family: "Arvo",serif;
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

            .box {
                display: flex;
            }

            .navigation a {
                position: relative;
                font-size: 1.4em;
                color: #000000;
                text-decoration: none;
                font-weight: 500;
                margin-left: 40px;
                font-family: "Arvo",serif;
                font-weight: 400;
            }

            .navigation .butt {
                width: 130px;
                height: 50px;
                background: transparent;
                border: 2px solid black;
                outline: none;
                border-radius: 6px;
                cursor: pointer;
                font-size: 1.5em;
                color: rgb(0, 0, 0);
                font-weight: 500;
                margin-left: 40px;
                transition: .5s;
                font-family: "Arvo",serif;
                font-weight: 700;
            }

            .navigation .butt:hover {
                background-color: rgb(46, 162, 65);
                color: #162938;
            }
            h1{
                color:white;
            }
        table {
            width: 100%;
            max-width: 800px;
            margin-top: 100px;
            margin-left: 22.5%;
            margin-bottom: 40px;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 16px;
            color: #333;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
            background-color: #9f0000;
            color: #fff;
        }

        th {
            background-color: #7a0000;
            font-optical-sizing: auto;
            font-style: normal;
            font-variation-settings: "wdth" 100;
        }

        td {
            font-family: "Baskervville SC", serif;
            font-weight: 400;
            font-style: normal;
            font-size: large;
        }

        .dashboard {
            max-width: 500%;
            margin-top: 130px;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(248, 247, 247, 0.927);
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .dashboard h1 {
            font-size: 24px;
            color: red;
            margin-top: 20px;
            margin-left: 41%;
            font-family: "Baskervville SC", serif;
            font-weight: 500;
            font-style: normal;
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
            <a href="admin2.html"><button class="butt">Back</button></a>
        </nav>
    </header>

    <div class="dashboard">
        <div class="dashboard-header">
        <h1 style="color:white;" >Blood Groups with Low Stock</h1>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>Blood Group</th>
                <th>Quantity</th>
            </tr>

            <?php
            include 'connect.php';
            
            // SQL Query to fetch blood groups
            $sql = "SELECT BB_id, available_blood FROM available_blood";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    // Extract the part before the colon (blood group) and the number (quantity)
                    $parts = explode(':', $row["available_blood"]);
                    if (count($parts) == 2) {
                        $blood_group = trim($parts[0]);
                        $quantity = intval(preg_replace('/[^0-9]/', '', $parts[1])); // Remove non-numeric characters and convert to integer
                        
                        // Check if the quantity is 5 or less
                        if ($quantity <= 5) {
                            echo "<tr><td>" . $row["BB_id"] . "</td><td>" . $blood_group . "</td><td>" . $quantity . " Bags</td></tr>";
                        }
                    }
                }
            } else {
                echo "<tr><td colspan='3'>No blood groups available</td></tr>";
            }
            
            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>
