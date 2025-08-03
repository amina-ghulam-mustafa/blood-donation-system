<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood bank</title>
    <link href="listedStyle.css" rel="stylesheet">
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
            <a href="admin2.html"><button class="butt">Back</button></a>
        </nav>
    </header>
    <div class="dashboard">
        <div class="dashboard-header">
            <h1>Listed Blood Groups</h1>
        </div>
    </div>

    <table>
        <tr>
            <th>Blood Type</th>
            <th>Donor ID</th>
            <th>Quantity</th>
        </tr>

        <?php
        include 'connect.php';

        // SQL query to fetch blood group details
        $sql = "SELECT D_bloodGroup, DonorId, SUM(D_quantity) AS TotalQuantity
                FROM Donor
                GROUP BY D_bloodGroup, DonorId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data for each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['D_bloodGroup'] . "</td>";
                echo "<td>" . $row['DonorId'] . "</td>";
                echo "<td>" . $row['TotalQuantity'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }

        $conn->close();
        ?>
    </table>

    

    
</body>
</html>
