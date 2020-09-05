<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <style>
        .form-wrapper {
            max-width: 500px;
            margin: 10px auto;
            background-color: #e6e8e9; 
            padding: 15px;
        }
        /* Webkit - hide arrows on number inputs */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
            }

            /* Firefox */
            input[type=number] {
            -moz-appearance: textfield !important;
            }
    </style>
</head>
<body>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // print_r($_POST);
            $height_in_inches = ($_POST["feet"] * 12) + $_POST["inches"];
            if (!$height_in_inches || !$_POST["pounds"]) {
                $error  = "Please enter both height and weight";
            } else {
                $bmi = round(($_POST["pounds"] / ($height_in_inches * $height_in_inches)) * 703, 2);
            }

        }
    ?>

    <div class="form-wrapper">
        <form method="post" class="ui form">
        <h1>BMI Calculator</h1>
        <p>Enter your height and weight and I'll calculate your BMI.</p>
        <h4>Height</h4>
        <div class="three fields">
            <div class="field">
                <label>Feet</label>
                <input type="number" name="feet" min="0 value="<?php $feet;?>" placeholder="Feet">
            </div>
            <div class="field">
                <label>Inches</label>
                <input type="number" name="inches" min="0" max="59" maxlength="2" value="<?php $inches;?>" placeholder="Inches">
            </div>
        </div>

        <div>
            <h4>Weight</h4>
            <div class="field">
                <label>Pounds</label>
                <input type="number" step="0.01" min="0" name="pounds" placeholder="Pounds" value="<?php $pounds;?>">
            </div>
        </div>
        <br />
        <button class="ui black button" type="submit">Submit</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if($error) {
                echo "<div class=\"ui error message\">
                <div class=\"header\">Oh no!</div>
                <p>$error</p>
                </div>";
            } else {
                echo "<h2>Results:</h2>";
                echo "Your BMI: $bmi";
                echo "<br>";
                echo "Weight: " . $_POST['pounds'] . " pounds";
                echo "<br>";
                echo "Height: " . $_POST['feet'] . " feet" . $_POST['inches'] . " inches";
            }            
        }
        ?>
    </div>

</body>
</html> 
