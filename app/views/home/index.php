<?php
if (!isset($_SESSION)) {
  session_start();
}
//error_reporting(E_ALL | E_WARNING);

include("../config/dbconfig.php");
include __DIR__ . '/../header.php';


try {
  $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}


echo '<main>
 
 <img src="./img/imgPlaceholder.png" alt="Home page picture" id="homePageImg">

 <div class="carousel-caption">
 <div class="d-inline p-2 display-2">PLACEHOLDER</div>
 <div class="d-inline p-2 display-1">TEXT</div>
 </div>

 <div class="container object-fit-fill border rounded" id="homePageImagesPanel">
 <div class="row object-fit-fill border rounded">
 <div class="col col-sm m-0 p-0">
 <img src="./img/panelImgPlaceholder.png" alt="" class="homePagePanelImg ">
 </div>
 <div class="col-sm m-0 p-0">
 <img src="./img/panelImgPlaceholder.png" alt="" class="homePagePanelImg">
 </div>
 <div class="col-sm m-0 p-0">
 <img src="./img/panelImgPlaceholder.png" alt="" class="homePagePanelImg">
 </div>
 <div class="col-sm m-0 p-0">
 <img src="./img/panelImgPlaceholder.png" alt="" class="homePagePanelImg">
 </div>
</div>
 </div>

 <div id="homePageVideoPanel">

 <div class="container object-fit-fill border rounded" id="homePageVideo">
 <div class="row object-fit-fill border rounded">
 <div class="col col-8 m-0 p-0" >
 <img src="./img/videoPlaceholder.gif" alt="" class="homePageVideoPlaceholder">

 </div>
 <div class="col col-4 m-0 p-0" id="homePageLinkToFestival">

 </div>
 </div>
 </div>
 </div>



 </main>
 </body>
 </html>
 ';
?>
