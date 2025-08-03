<?php
include 'connect.php';

// 2. Write SQL query to fetch recipient data
$sql = "SELECT R_firstName, R_lastName, R_gender, R_address, R_bloodGroup FROM recipient";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requested Blood Group</title>
<link href="requestedbgStyle.css" rel="stylesheet">
  
</head>
<body>
    <header>
    <div class="box">
            <img class="logoim" src="iconnn.jpg" alt="logo">
            <h2 class="logo">Donate Blood </h2>
        </div>
        <nav class="navigation">
            <a href="#">Home</a>
            <a href="#">Find Blood</a>
            <a href="#">Register Now</a>
            <a href="#">About Us</a>
            <a href="#">Feedback</a>
            <a href="admin2.html"><button class="butt">Back</button></a>
        </nav>
    </header>

    <div class="dashboard">
        <h1>Recipient Details</h1>

        <table>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Blood Group</th>
            </tr>

            <?php
            // 3. Display data from the database
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["R_firstName"] . "</td>
                            <td>" . $row["R_lastName"] . "</td>
                            <td>" . $row["R_gender"] . "</td>
                            <td>" . $row["R_address"] . "</td>
                            <td>" . $row["R_bloodGroup"] . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No recipients found</td></tr>";
            }

            $conn->close();
            ?>
        </table>
    </div>


</body>
</html>
