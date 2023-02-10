<?php
if (getenv('DATABASE_URL') != "") {
    $dbopts = parse_url(getenv('DATABASE_URL'));
    $type = "pgsql";
    $servername = $dbopts["host"];
    $username = $dbopts["user"];
    $password = $dbopts["pass"];
    $database = ltrim($dbopts["path"], '/');
} else {
    $type = "mysql";
    $servername = "mysql"; # "127.0.0.1";
    $portnumber = "3306";
    $username = "root"; // "developer";
    $password = "secret123";
    $database = "TheFestivalDb";
}
?>