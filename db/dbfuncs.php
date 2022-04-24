<?php

require __DIR__ . '/dbconn.php';


function getAllWeatherData()
{
    $cnx = mysqlConnect();
    $query = 'SELECT * FROM weather_data';
    $cursor = $cnx->query($query);
    mysqlClose($cnx);
    return $cursor;
}
function getCityWeather($city)
{
    $cnx = mysqlConnect();
    $query = 'SELECT * FROM weather_data WHERE city="' . $city . '"';
    $cursor = $cnx->query($query);
    mysqlClose($cnx);
    return $cursor;
}

function getUserInfo($ip)
{
    $cnx = mysqlConnect();
    $query = 'SELECT * FROM users WHERE ip_addr="' . $ip . '"';
    $cursor = $cnx->query($query);
    mysqlClose($cnx);
    if ($cursor->num_rows == 0) {
        return false;
    }
    return $cursor->fetch_assoc();
}

function insertUserIp($ip)
{
    $cnx = mysqlConnect();
    $query = 'INSERT INTO users (ip_addr) VALUES ("' . $ip . '")';
    $cnx->query($query);
    mysqlClose($cnx);
}

function updateUserCity($ip, $city)
{
    $cnx = mysqlConnect();
    $query = 'UPDATE users SET saved_city="' . $city . '" WHERE ip_addr="' . $ip . '"';
    $cnx->query($query);
    mysqlClose($cnx);
}
function updateUserColor($ip, $color)
{
    $cnx = mysqlConnect();
    $query = 'UPDATE users SET saved_color="' . $color . '" WHERE ip_addr="' . $ip . '"';
    $cnx->query($query);
    mysqlClose($cnx);
}
