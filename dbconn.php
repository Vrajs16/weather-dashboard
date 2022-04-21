<?php
function mysqlConnect()
{
    $cnx = new mysqli('localhost', 'root', 'testing', 'weather');
    if ($cnx->connect_error)
        die('Connection failed: ' . $cnx->connect_error);
    return $cnx;
}

function mysqlClose($cnx)
{
    $cnx->close();
}
