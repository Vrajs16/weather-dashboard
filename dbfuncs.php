<?php
require 'dbconn.php';

function getAllWeatherData()
{
    $cnx = mysqlConnect();
    $query = 'SELECT * FROM weather_data';
    $cursor = $cnx->query($query);
    mysqlClose($cnx);
    return $cursor;
}
