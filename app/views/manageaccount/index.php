<?php
if (!isset($_SESSION)) {
    session_start();
}

include("../config/dbconfig.php");
require_once '../services/userService.php';


try {
  $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

 // echo "<p class='msg'>Connect successfully</p>" . "<br>";
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

?>

<?php
 include __DIR__ . '/../header.php';



echo '<main>
<br><h1>Manage account</h1>';
 


echo '<br><form method="POST">
<label>First name:</label>
 <input type="text" name="firstName"/><br>
 <label>Last name:</label>
 <input type="text" name="lastname"/><br>
 <label>Email:</label>
 <input type="email" name="email"/><br>
 <label>Password:</label>
 <input type="text" name="password"/><br><br>
<input type="submit" value="Update" name="updateUserInformation"/>
</form>
</div>

</main>';

include __DIR__ . '/../footer.php';
?>
