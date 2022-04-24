<?php
function mysqlConnect()
{
    $cnx = new mysqli('sql5.freemysqlhosting.net', 'sql5487808', 'KPKuhE2A5u', 'sql5487808');
    if ($cnx->connect_error)
        die('Connection failed: ' . $cnx->connect_error);
    $cnx->set_charset('utf8');
    return $cnx;
}

function mysqlClose($cnx)
{
    $cnx->close();
}
