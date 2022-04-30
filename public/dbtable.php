<!DOCTYPE html>
<html lang="en">
<?php require __DIR__ . '/../db/dbfuncs.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Dashboard</title>
</head>

<body>
    <table align="center" border="1">
        <caption style="font-weight:600; font-size:30px">Weather Data Table</caption>
        <thead>
            <tr>
                <th>Day_id</th>
                <th>City</th>
                <th>State</th>
                <th>Day</th>
                <th>Day_or_night</th>
                <th>Temperature_text</th>
                <th>Temperature</th>
                <th>Short_description</th>
                <th>Long_description</th>
                <th>Last_forecast_update</th>
                <th>Last_update</th>
                <th>Script_ran</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cursor = getAllWeatherData();
            while ($row = $cursor->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['day_id'] . '</td>';
                echo '<td>' . $row['city'] . '</td>';
                echo '<td>' . $row['state'] . '</td>';
                echo '<td>' . $row['day'] . '</td>';
                $answer = (intval($row['day_or_night'])) ? 'TRUE' : 'FALSE';
                echo '<td>' . $answer . '</td>';
                echo '<td>' . $row['temperature_text'] . '</td>';
                echo '<td>' . $row['temperature'] . '</td>';
                echo '<td>' . $row['short_description'] . '</td>';
                echo '<td>' . $row['long_description'] . '</td>';
                echo '<td>' . $row['last_forecast_update'] . '</td>';
                echo '<td>' . $row['last_update'] . '</td>';
                echo '<td>' . $row['script_ran'] . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <br>
    <hr>
    <br>
    <table align="center" border="1">
        <caption style="font-weight:600; font-size:30px">Users Table</caption>
        <thead>
            <tr>
                <th>IP Address</th>
                <th>Saved City</th>
                <th>Saved Color</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cursor = getAllUserData();
            while ($row = $cursor->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['ip_addr'] . '</td>';
                echo '<td>' . $row['saved_city'] . '</td>';
                echo '<td>' . $row['saved_color'] . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</body>

</html>