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
        $e_time = ($_POST["hours"] * 3600) + ($_POST["minutes"] * 60) + $_POST["seconds"];
        $pace_time = ($_POST["p_minutes"] * 60) + $_POST["p_seconds"];
        $distance = $_POST["distance"];
        $time_result = $_POST["hours"] . ":" . $_POST["minutes"] . ":" . padNumbers($_POST["seconds"]);
        $pace_result = $_POST["p_minutes"] . ":" . padNumbers($_POST["p_seconds"]);

        // echo "Time: $e_time Pace: $pace_time Distance: $distance Time Result: $time_result Pace Result: $pace_result";
        $counter = 0;
        if ($e_time) {
            $counter++; };
        if ($pace_time) { $counter++; };
        if ($distance) { $counter++; };
     
        if ($counter === 3) {
            $error = "Leave one category blank so I can calculate it.";
        } elseif ($counter === 0 || $counter === 1) {
            $error = "Give me some data for two categories.";
        } else {
            if (!$distance) {
                $distance = calcDistance($e_time, $pace_time);
            } elseif (!$e_time) {
                $time_result = calcTime($pace_time, $distance);
            } elseif (!$pace_time) {
                $pace_result = calcPace($e_time, $distance);
            };
        }
    };

    function calcDistance($time, $pace) {
        // echo "Calculating disance...";
        return round($time / $pace, 2);
    };

    function calcTime($pace, $distance) {
        // echo "Calculating time...";
        $totalSeconds = $pace * $distance;
        $hrs = floor($totalSeconds/3600);
        $min = floor(($totalSeconds - ($hrs * 3600))/60);
        $sec = padNumbers(($totalSeconds - ($hrs * 3600)) - ($min * 60));
        return "$hrs:$min:$sec";
    };

    function calcPace($time, $distance) {
        // echo "Calculating pace...";
        $secondsPerUnit = $time / $distance;
        $min = floor($secondsPerUnit/60);
        $sec = padNumbers(round($secondsPerUnit - ($min * 60)));
        return "$min:$sec";
    };

    function padNumbers($num=0) {
        return sprintf('%02d', $num);
    }

?>
<div class="form-wrapper">
    <form method="post" class="ui form">
    <h1>Run Calculator</h1>
    <p>Enter values for two of the categories (Time/Distance/Pace) and I'll calculate the third.</p>
  
    <h4>Elasped Time</h4>
    <div class="three fields">
        <div class="field">
            <label>Hours</label>
            <input type="number" name="hours" min="0 value="<?php $hours;?>" placeholder="Hours">
        </div>
        <div class="field">
            <label>Minutes</label>
            <input type="number" name="minutes" min="0" max="59" maxlength="2" value="<?php $minutes;?>" placeholder="Minutes">
        </div>
        <div class="field">
            <label>Seconds</label>
            <input type="number" name="seconds" min="0" max="59" maxlength="2" value="<?php $seconds;?>" placeholder="Seconds">
        </div>
    </div>

    <div>
        <h4>Distance</h4>
        <div class="field">
            <label>Miles or Kilometers</label>
            <input type="number" step="0.01" min="0" name="distance" placeholder="Distance" value="<?php $distance;?>">
        </div>
    </div>


    <h4>Pace</h4>
    <div class="two fields">
        <div class="field">
            <label>Minutes</label>
            <input type="number" name="p_minutes" min="0" max="59" maxlength="2" placeholder="Minutes" value="<?php $p_minutes;?>">
        </div>
        <div class="field">
            <label>Seconds</label>
            <input type="number" name="p_seconds" min="0" max="59" maxlength="2" placeholder="Seconds" value="<?php $p_seconds;?>">
        </div>
    </div>

    <div class="button-wrapper">
        <button class="ui black button" type="submit">Submit</button>
        <button class="ui button" type="button"><a href="bmi/index.php">BMI Calculator</a></button>        
        <button class="ui button" type="button"><a href="https://github.com/dkmullen/php_calc" target="_blank">Repo</a></button>        
    </div>
    
    <br />
    <br />
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($error) {
            echo "<div class=\"ui error message\">
                <div class=\"header\">Oh no!</div>
                <p>$error</p>
            </div>";
        } else {
            echo "<h2>Results:</h2>";
            echo "Distance: $distance miles";
            echo "<br>";
            echo "Time: $time_result";
            echo "<br>";
            echo "Pace $pace_result";
        }
    }
    ?>
</div>

</body>
</html> 
