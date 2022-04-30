<?php
function mysqlConnect()
{
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $server = $url["host"];
    $username = $url["user"];
    $password = $url["pass"];
    $db = substr($url["path"], 1);

    $cnx = new mysqli($server, $username, $password, $db);
    if ($cnx->connect_error)
        die('Connection failed: ' . $cnx->connect_error);
    $cnx->set_charset('utf8');
    return $cnx;
}

function mysqlClose($cnx)
{
    $cnx->close();
}
