<?php

include("../config/dbconfig.php");
require_once '../services/userService.php';



try {
  $connection = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);


  echo "<p class='msg'>Connect successfully</p>" . "<br>";
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

?>
