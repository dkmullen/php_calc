<html>
<body>

<!-- todo: Validation, decimals for miles, range limits for min sec -->
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $e_time = ($_POST["hours"] * 3600) + ($_POST["minutes"] * 60) + $_POST["seconds"];
        $pace_time = ($_POST["p_minutes"] * 60) + $_POST["p_seconds"];
        $distance = $_POST["distance"];
        $time_result = $_POST["hours"] . ":" . $_POST["minutes"] . ":" . padNumbers($_POST["seconds"]);
        $pace_result = $_POST["p_minutes"] . ":" . padNumbers($_POST["p_seconds"]);

        // echo "Time: $e_time Pace: $pace_time Distance: $distance Time Result: $time_result Pace Result: $pace_result";
     
        if ($distance && $e_time && $pace_time) {
            $error = "Leave one category blank so I can calculate it.";
        } elseif (!$distance && !$e_time && !$pace_time) {
            $error = "Give me some data for two categories.";
        } elseif (!$distance) {
            $distance = calcDistance($e_time, $pace_time);
        } elseif (!$e_time) {
            $time_result = calcTime($pace_time, $distance);
        } elseif (!$pace_time) {
            $pace_result = calcPace($e_time, $distance);
        };
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

<form method="post">
<h1>Run Calculator</h1>
<p>Enter values for two of the categories (Time/Distance/Pace) and I'll calculate the third.</p>
<div>
    <h4>Elasped Time</h4>
    Hours: <input type="number" name="hours" value="<?php $hours;?>"><br>
    Minutes: <input type="number" name="minutes" value="<?php $minutes;?>"><br>
    Seconds: <input type="number" name="seconds" value="<?php $seconds;?>"><br>
</div>

<div>
    <h4>Distance</h4>
    Miles: <input type="number" name="distance" value="<?php $distance;?>"><br>
</div>

<div>
    <h4>Pace</h4>
    Minutes: <input type="number" name="p_minutes" value="<?php $p_minutes;?>"><br>
    Seconds: <input type="number" name="p_seconds" value="<?php $p_seconds;?>"><br>
</div>

<input type="submit">
<br />
<br />
<div><?php $error;?></div>
</form>

<?php
echo "<h2>Results:</h2>";
echo "Distance: $distance miles";
echo "<br>";
echo "Time: $time_result";
echo "<br>";
echo "Pace $pace_result";
echo "<br>";
echo $error;
?>

</body>
</html> 
