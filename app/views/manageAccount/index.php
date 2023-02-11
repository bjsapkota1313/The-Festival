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

 $currentUserId = 4;// $_SESSION["id"];

 $GLOBALS['userService'] = new UserService();
 $currentUser = $GLOBALS['userService']->getUserToDisplayUserProfile($currentUserId);

 function DisplayUserData($currentUser){
    echo '<h2>'. $currentUser->getFirstName() . ' ' . $currentUser->getLastName(). '</h2><br>';
    $userImagePath = $currentUser->getPicture(); 
    echo  '<img src='. $userImagePath.'><br><br>';

   // echo 'Registered since: ' . $currentUser->getRegistrationDate();
    
 }

 function updateProfile($connection, $currentUserId)
{

  if (isset($_POST["updateProfile"])) {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    //$picture = $_POST['file'];
    //echo $picture;
    move_uploaded_file($_FILES["file"]["tmp_name"],"./img/".$_FILES["file"]["name"]);
    $path = "./img/" . $_FILES["file"]["name"];
    $GLOBALS["userService"]->updateUser($connection, $currentUserId, $firstName, $lastName, $email, $path);
    echo '<h5>Your profile was updated</h5><br>';
   
  }

}

echo '<main>
<br><h1>Manage account</h1><br><br>';

DisplayUserData($currentUser);


echo '<br><form method="POST" enctype="multipart/form-data">
<label>First name:</label>
 <input type="text" name="firstName" value='.$currentUser->getFirstName().'><br>
 <label>Last name:</label>
 <input type="text" name="lastName" value='.$currentUser->getLastName().'><br>
 <label>Email:</label>
 <input type="email" name="email" value='. $currentUser->getEmail().'><br>
 <label>Picture:</label>
 <input type="file" name="file" id="file"><br><br>
<input type="submit" value="Update" name="updateProfile"/>
</form>
</div>

</main>';



UpdateProfile($connection, $currentUserId);

//concatenate img dir if img folder is local
if (isset($_FILES["file"])){
  echo $_FILES["file"]["name"];}
  


include __DIR__ . '/../footer.php';
?>
