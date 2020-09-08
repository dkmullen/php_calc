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
        .button-wrapper {
            display: inline-block;
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
                $bmi = round(($_POST["pounds"] / ($height_in_inches * $height_in_inches)) * 703, 1);
                $min_weight = round((18.5 * ($height_in_inches * $height_in_inches)) / 703, 0);
                $max_weight = round((24.9 * ($height_in_inches * $height_in_inches)) / 703, 0);
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
        <div class="button-wrapper">
            <button class="ui black button" type="submit">Submit</button>
            <button class="ui button" type="button"><a href="../index.php">Run Calculator</a></button>     
            <button class="ui button" type="button"><a href="https://github.com/dkmullen/php_calc" target="_blank">Repo</a></button>        
        </div>
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
                echo "<br><br>";
                echo "A healthy weight for this height is between $min_weight and $max_weight pounds.";

            }            
        }
        ?>
    </div>

</body>
</html> 
