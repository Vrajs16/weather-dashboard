<?php
function mysqlConnect()
{
    $DBHOST = getenv("DB_HOST");
    $PASSWORD = getenv("DB_PASSWORD");
    $cnx = new mysqli($DBHOST, 'sql5487808', $PASSWORD, 'sql5487808');
    if ($cnx->connect_error)
        die('Connection failed: ' . $cnx->connect_error);
    $cnx->set_charset('utf8');
    return $cnx;
}

function mysqlClose($cnx)
{
    $cnx->close();
}
