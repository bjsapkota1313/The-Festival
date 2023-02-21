<?php
if (!isset($_SESSION)) {
  session_start();
}
//error_reporting(E_ALL | E_WARNING);

include("../config/dbconfig.php");


try {
  $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

?>

<?php
include __DIR__ . '/../header.php';

echo '<main>
 



 </main>
 </body>
 </html>
 ';
?>
