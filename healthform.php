<?php
$ineligible = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $hiv = $_POST['hiv'];
    $alcohol = $_POST['alcohol'];
    $fever = $_POST['fever'];
    $covid = $_POST['covid'];
    $thalassemia = $_POST['thalassemia'];
    $hepatitis = $_POST['hepatitis'];


    if ($hiv == "yes" || $alcohol == "yes" || $fever == "yes" || $covid == "yes" || $thalassemia == "yes" || $hepatitis == "yes") {
   
        $ineligible = true;
    } else {
      
        header("Location: Donor_Registration.html");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation Eligibility</title>
    <style>
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f5f5f5;
            background-image: url(4.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            backdrop-filter: blur(8px);
        }
        header {
            width: 100%;
            padding: 10px 60px;
            background-color: rgb(255, 255, 255);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: absolute;
            top: 0;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
        }
        .logo {
            user-select: none;
            font-size: 25px; 
            color: rgb(148, 12, 12);
            text-align: left;
            margin-top: 22px;
            margin-left: 15px;
            text-shadow: 2px 2px 5px #928f8f;
        }
        .logoim {
            user-select: none;
            width: 70px;
            height: 70px;
            color: white;
        }
        .box {
            display: flex;
        }
        .navigation a {
            position: relative;
            font-size: 1.3em;
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
        main {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;

            padding: 20px;
            width: 80%;
            max-width: 800px;
            margin: 100px auto 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            flex: 1;
            margin-top: 150px;
        }
      
        h1 {
            color: white;
            margin-bottom: 20px;
            padding: 9px;
            font-family: "Anton SC", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        p {
            margin-bottom: 20px;
            font-size: 1.1em;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        #div{
            height: 60hv;
            width: 100%;
            background-color: #9f0000;
            border-top-left-radius: 30px;
            border-bottom-right-radius: 30px;
        }
        
        .question {
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .options {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        .submit {
            padding: 10px 20px; 
            background-color: #9f0000;
            color: white;
            border-radius: 8px; 
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
            align-self: center;
            font-size: 1.1em; 
            font-family: "Arvo", serif;
            font-weight: 700;
        }

        .submit:hover {
            background-color: rgb(255, 255, 255);
            color: #000000;
        }


        #popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            z-index: 1000;
        }
        #popup button {
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #721c24;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>

    <script>
        function checkEligibility() {
            <?php if ($ineligible): ?>
                document.getElementById('popup').style.display = 'block';    
            <?php endif; ?>
        }

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
        }
    </script>

</head>

<body onload="checkEligibility()">

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
      <a href="admin1.html"><button class="butt">back</button></a>
    </nav>
  </header>

  <main>
        <div id="div"><h1> 💌 💉💊 🩺🧬 Health Condition 🧬💉💊 🩺💌 </h1></div><br>
        <p style="color: #7a0000; font-family: Rokkitt, serif; font-weight: 600; font-size: 20px;">Please select the appropriate answer to each question</p>
        <div class="box"></div>

        <form method="POST"> 
            <div class="question">
                <label >➡ Do you have HIV?</label >
                <div class="options">
                    <label><input type="radio" name="hiv" value="yes" > Yes</label>
                    <label><input type="radio" name="hiv" value="no" > No</label>
                </div>
            </div>
            <div class="question">
                <label>➡ Do you consume alcohol?</label>
                <div class="options">
                    <label><input type="radio" name="alcohol" value="yes" > Yes</label>
                    <label><input type="radio" name="alcohol" value="no" > No</label>
                </div>
            </div>
            <div class="question">
                <label>➡ Do you have a recent fever?</label>
                <div class="options">
                    <label><input type="radio" name="fever" value="yes" > Yes</label>
                    <label><input type="radio" name="fever" value="no" > No</label>
                </div>
            </div>
            <div class="question">
                <label>➡ Have you recently tested positive for COVID-19?</label>
                <div class="options">
                    <label><input type="radio" name="covid" value="yes" > Yes</label>
                    <label><input type="radio" name="covid" value="no" > No</label>
                </div>
            </div>
            <div class="question">
                <label>➡ Do you have Thalassemia?</label>
                <div class="options">
                    <label><input type="radio" name="thalassemia" value="yes" > Yes</label>
                    <label><input type="radio" name="thalassemia" value="no" > No</label>
                </div>
            </div>
            <div class="question">
                <label>➡ Do you have any of the Hepatitis viruses?</label>
                <div class="options">
                    <label><input type="radio" name="hepatitis" value="yes" > Yes</label>
                    <label><input type="radio" name="hepatitis" value="no" > No</label>
                </div>
            </div>
           <button class="submit">Submit</button>
        </form>

    </main><br><br><br><br><br><br>

    <div id="popup">
        Sorry, you are not eligible for donating blood.
        <br>
        <button onclick="closePopup()">ok</button>
    </div>

</body>
</html>
