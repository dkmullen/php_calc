<html>
<body>

<?php
    $hours, $minutes, $seconds, $distance, $p_minutes, $p_seconds = null;
    $error = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $e_time = ($_POST["hours"] * 3600) + ($_POST["minutes"] * 60) + $_POST["seconds"];
        $pace_time = ($_POST["p_minutes"] * 60) + $_POST["p_seconds"];
        
        if (!$_POST["distance"]) {
            calcDistance();
        } elseif (!$_POST["hours"] && !$_POST["minutes"] && !$_POST["seconds"]) {
            calcTime();
        } elseif (!$_POST["p_minutes"] && !$_POST["p_seconds"]) {
            calcPace();
        } else {
            $error = "Leave one category blank so I can calculate it.";
        }
    };

    function calcDistance() {
        echo "Calculating disance...";
        return round($e_time / $pace_time, 2);
    };

    function calcTime() {
        echo "Calculating time...";
        $totalSeconds = $pace_time * $distance;
        $hrs = Math.floor(totalSeconds/3600);
        $min = floor(($totalSeconds - ($hrs * 3600))/60);
        $sec = ($totalSeconds - ($hrs * 3600)) - ($min * 60);
        return $hrs, $min, $sec;
    };

    function calcPace() {
        echo "Calculating pace...";
        $secondsPerUnit = $e_time / $distance;
        $min = floor($secondsPerUnit/60);
        $sec = $secondsPerUnit - ($min * 60);
        return $min, $sec;
    };

?>

<form action="runcalc.php" method="post">
<div>
    <h4>Elasped Time</h4>
    Hours: <input type="number" name="hours" value="<?php $hours;?>"><br>
    Minutes: <input type="number" name="minutes" value="<?php $minutes;?>"><br>
    Seconds: <input type="number" name="seconds" value="<?php $seconds;?>"><br>
</div>

<div>
    <h4>Distance</h4>
    Miles: <input type="number" name="miles" value="<?php $distance;?>"><br>
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

</body>
</html> 
