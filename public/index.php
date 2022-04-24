<?php require __DIR__ . '/../db/dbfuncs.php';
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
  $ip = $_SERVER['REMOTE_ADDR'];
}

$info = getUserInfo($ip);
if ($info == False) {
  insertUserIp($ip);
  $info = getUserInfo($ip);
}
$color = $info['saved_color'];
$city = $info['saved_city'];

$submit = $_GET['submit'];
if (!empty($submit)) {
  if ($submit == "Save Color") {
    $color = $_GET['color'];
    //Use regex to find if it is correct color
    if (!preg_match("/^#[a-f0-9]{6}$/i", $color))
      $color = $info['saved_color'];
    else
      updateUserColor($ip, $color);
  } else if ($submit == "Save City") {
    $cities = array("Parsippany", "Newark", "Princeton", "Atlantic City", "Salem");
    $city = $_GET['city'];
    if (!in_array($city, $cities))
      $city = $info['saved_city'];
    else
      updateUserCity($ip, $city);
  }
}

$city = $_GET['city'];
if (!empty($city)) {
  $cities = array("Parsippany", "Newark", "Princeton", "Atlantic City", "Salem");
  if (!in_array($city, $cities)) {
    $city = $info['saved_city'];
  }
} else
  $city = $info['saved_city'];

$cursor = getCityWeather($city);
$row = $cursor->fetch_assoc();

function iconToChoose($desc)
{
  $arr = explode(" ", $desc);
  $arr = array_map('strtolower', $arr);
  if (in_array("sunny", $arr)) {
    return '<i class="fa-solid fa-sun fa-4x"></i>';
  } else if (in_array("cloudy", $arr)) {
    return '<i class="fa-solid fa-cloud fa-4x"></i>';
  } else if (in_array("showers", $arr)) {
    return '<i class="fa-solid fa-cloud-rain fa-4x"></i>';
  } else if (in_array("rain", $arr)) {
    return '<i class="fa-solid fa-cloud-rain fa-4x"></i>';
  } else {
    return '<i class="fa-solid fa-temperature-half fa-4x"></i>';
  }
}

?>

<!DOCTYPE html>
<html id="main-html" lang="en" style="background-color: <?php echo $color ?>;">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="index.css" />
  <script src="https://kit.fontawesome.com/105c450497.js" crossorigin="anonymous"></script>
  <title>Weather Dashboard</title>
</head>

<body id="main-body" style="background-color: <?php echo $color ?>;">
  <div class="top-navigation">
    <a style="text-decoration: none;" href="/index.php">
      <h1 id="weather-title" class="dash-title">WEATHER DASHBOARD</h1>
    </a>
  </div>
  <div>
    <!-- Create from php-->
    <form class="container" action="index.php" , method="get">
      <?php
      if ($city == "Newark") {
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
      ?>
    </form>
  </div>
  <!-- Preferences here -->
  <div class="wrapper">
    <div>
      <div class="top-navigation">
        <h2 id="background-title" class="dash-title">Change Background Color</h2>
      </div>
      <div>
        <form class="container" action="index.php" , method="get">
          <input type="hidden" name="city" value="<?php echo isset($city) ? $city : "Parsippany"; ?>" />
          <input id="colorPicker" class="color-selector" type="color" name="color" value="#0a1f44" />
          <input class="item" type="submit" name="submit" value="Save Color" />
        </form>
      </div>
    </div>
    <div>
      <div class="top-navigation">
        <h2 id="city-title" class="dash-title">Set As Default City</h2>
      </div>
      <div>
        <form class="container" action="index.php" , method="get">
          <input type="hidden" name="city" value="<?php echo isset($city) ? $city : "Parsippany"; ?>" />
          <input class="item" type="submit" name="submit" value="Save City" />
        </form>
      </div>
    </div>
  </div>
  <div class="top-navigation">
    <?php
    if (!empty($row['last_update'])) {
      $time = date('m-d-Y \a\t h:i A', strtotime($row['last_update']));
    } else {
      $time = "ERROR";
    }
    ?>
    <h2 id="scraper-title" class="dash-title">Web Scraper Last Ran: <?php echo $time ?></h2>
  </div>
  <div id="weather-container" class="weather-dashboard">
    <?php
    if (is_null($row)) {
      echo "SOME ERROR HAS OCCURED. PLEASE TRY AGAIN LATER OR NO DATA IN DB?";
    } else { ?>
      <div class='weather-item'>
        <div style="padding: 10px">
          <h1 style="text-align:center"> <?php echo $row['day'] ?></h1>
        </div>
        <div style="padding-bottom:10px;display:flex; align-items:stretch; justify-content: space-between; flex-wrap: wrap; gap: 10px">
          <div>
            <h2><?php echo $row['temperature_text'] ?></h2>
          </div>
          <div>
            <h2><?php echo $row['short_description'] ?></h2>
          </div>
        </div>
        <div>
          <h3>Description:</h3>
          <h3><?php echo substr($row['long_description'], strpos($row['long_description'], ":") + 1) ?></h3>
        </div>
        <div style="text-align: center; padding-top: 30px;">
          <?php echo iconToChoose($row['short_description']) ?>
        </div>
        <div style="text-align: center;padding-top:40px;">
          <?php
          $forecastTime = date('m-d-Y \a\t h:i A', strtotime($row['last_forecast_update'])); ?>
          <h4>Last Forecast Update<br><?php echo $forecastTime ?></h4>
        </div>
      </div>
      <?php
      while ($row = $cursor->fetch_assoc()) { ?>
        <div class='weather-item'>
          <div style="padding: 10px">
            <h1 style="text-align:center"> <?php echo $row['day'] ?></h1>
          </div>
          <div style="padding-bottom:10px;display:flex; align-items:stretch; justify-content: space-between; flex-wrap: wrap; gap: 10px">
            <div>
              <h2><?php echo $row['temperature_text'] ?></h2>
            </div>
            <div>
              <h2><?php echo $row['short_description'] ?></h2>
            </div>
          </div>
          <div>
            <h3>Description:</h3>
            <h3><?php echo substr($row['long_description'], strpos($row['long_description'], ":") + 1) ?></h3>
          </div>
          <div style="text-align: center; padding-top: 30px;">
            <?php echo iconToChoose($row['short_description']) ?>
          </div>
          <div style="text-align: center;padding-top:40px;">
            <?php
            $forecastTime = date('m-d-Y \a\t h:i A', strtotime($row['last_forecast_update'])); ?>
            <h4>Last Forecast Update<br><?php echo $forecastTime ?></h4>
          </div>
        </div>
    <?php
      }
    }
    ?>
  </div>

</body>

</html>

<script>
  let colorPicker = document.getElementById("colorPicker");
  let tagHtml = document.getElementById('main-html');
  let weatherTitle = document.getElementById('weather-title');
  let cityTitle = document.getElementById('city-title');
  let backgroundTitle = document.getElementById('background-title');
  let weatherContainer = document.getElementById('weather-container');
  let scraperTitle = document.getElementById('scraper-title');

  colorPicker.addEventListener("input", function() {
    let color = colorPicker.value;
    document.body.style.backgroundColor = color;
    tagHtml.style.backgroundColor = color;
    color = color.replace("#", "");
    var r = parseInt(color.substr(0, 2), 16);
    var g = parseInt(color.substr(2, 2), 16);
    var b = parseInt(color.substr(4, 2), 16);
    var ratio = ((r * 299) + (g * 587) + (b * 114)) / 1000;
    if (ratio >= 128) {
      //set the text to black
      weatherTitle.style.color = "black";
      cityTitle.style.color = "black";
      backgroundTitle.style.color = "black";
      scraperTitle.style.color = "black";
      weatherContainer.style.backgroundColor = "black";
    } else {
      //set the text to white
      weatherTitle.style.color = "white";
      cityTitle.style.color = "white";
      backgroundTitle.style.color = "white";
      scraperTitle.style.color = "white";
      weatherContainer.style.backgroundColor = "white";
    }
  });

  window.addEventListener('load', (event) => {
    let color = document.body.style.backgroundColor;
    color = color.replace(/[^\d,]/g, '').split(',');
    console.log(color);
    var r, g, b;
    [r, g, b] = color;
    var ratio = ((r * 299) + (g * 587) + (b * 114)) / 1000;
    if (ratio >= 128) {
      //set the text to black
      weatherTitle.style.color = "black";
      cityTitle.style.color = "black";
      backgroundTitle.style.color = "black";
      weatherContainer.style.backgroundColor = "black";
      scraperTitle.style.color = "black";
    } else {
      //set the text to white
      weatherTitle.style.color = "white";
      cityTitle.style.color = "white";
      backgroundTitle.style.color = "white";
      weatherContainer.style.backgroundColor = "white";
      scraperTitle.style.color = "white";
    }
  });
</script>