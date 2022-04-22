<!DOCTYPE html>
<html lang="en">
<?php require 'dbfuncs.php'; ?>

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="index.css" />
  <title>Weather Dashboard</title>
</head>

<body>
  <div class="top-navigation">
    <a style="text-decoration: none;" href="/index.php">
      <h1 class="dash-title">WEATHER DASHBOARD</h1>
    </a>
  </div>
  <div>
    <!-- Create from php-->
    <form class="container" action="index.php" , method="get">
      <?php
      if (isset($_GET['city'])) {
        $city = $_GET['city'];
        if ($city == "Parsippany") {
          echo '
          <input class="item item-selected" type="submit" name="city" value="Parsippany" disabled/>
          <input class="item" type="submit" name="city" value="Newark" />
          <input class="item" type="submit" name="city" value="Princeton" />
          <input class="item" type="submit" name="city" value="Atlantic City" />
          <input class="item" type="submit" name="city" value="Salem" />';
        } else if ($city == "Newark") {
          echo '
          <input class="item" type="submit" name="city" value="Parsippany" />
          <input class="item item-selected" type="submit" name="city" value="Newark" disabled/>
          <input class="item" type="submit" name="city" value="Princeton" />
          <input class="item" type="submit" name="city" value="Atlantic City" />
          <input class="item" type="submit" name="city" value="Salem" />';
        } else if ($city == "Princeton") {
          echo  '
          <input class="item" type="submit" name="city" value="Parsippany" />
          <input class="item" type="submit" name="city" value="Newark" />
          <input class="item item-selected" type="submit" name="city" value="Princeton" disabled />
          <input class="item" type="submit" name="city" value="Atlantic City" />
          <input class="item" type="submit" name="city" value="Salem" />';
        } else if ($city == "Atlantic City") {
          echo  '
          <input class="item" type="submit" name="city" value="Parsippany" />
          <input class="item" type="submit" name="city" value="Newark" />
          <input class="item" type="submit" name="city" value="Princeton" />
          <input class="item item-selected" type="submit" name="city" value="Atlantic City" disabled />
          <input class="item" type="submit" name="city" value="Salem" />';
        } else if ($city == "Salem") {
          echo  '
          <input class="item" type="submit" name="city" value="Parsippany" />
          <input class="item" type="submit" name="city" value="Newark" />
          <input class="item" type="submit" name="city" value="Princeton" />
          <input class="item" type="submit" name="city" value="Atlantic City" />
          <input class="item item-selected" type="submit" name="city" value="Salem" disabled />';
        } else {
          echo '
          <input class="item item-selected" type="submit" name="city" value="Parsippany" disabled />
          <input class="item" type="submit" name="city" value="Newark" />
          <input class="item" type="submit" name="city" value="Princeton" />
          <input class="item" type="submit" name="city" value="Atlantic City" />
          <input class="item" type="submit" name="city" value="Salem" />';
        }
      } else {
        echo '
        <input class="item item-selected" type="submit" name="city" value="Parsippany" disabled />
          <input class="item" type="submit" name="city" value="Newark" />
          <input class="item" type="submit" name="city" value="Princeton" />
          <input class="item" type="submit" name="city" value="Atlantic City" />
          <input class="item" type="submit" name="city" value="Salem" />';
      }
      ?>
    </form>
  </div>
  <div class="weather-dashboard">
    <?php
    if (isset($_GET['city'])) {
      $cities = array("Parsippany", "Newark", "Princeton", "Atlantic City", "Salem");
      $city = $_GET['city'];
      if (in_array($city, $cities)) {
        $cursor = getCityWeather($city);
        $row = $cursor->fetch_assoc();
        if (is_null($row)) {
          echo "SOME ERROR HAS OCCURED. PLEASE TRY AGAIN LATER";
        } else {
          echo "<div class='weather-item'>From PHP</div>";
          while ($row = $cursor->fetch_assoc()) {
            break;
          }
        }
      }
    }
    ?>
    <div class='weather-item'>
      <div>
        Day
      </div>
      <div>
        Tempeature
      </div>
      <div>
        Short Description
      </div>
      <div>
        Long Description
      </div>
    </div>
  </div>

</body>

</html>

<script></script>