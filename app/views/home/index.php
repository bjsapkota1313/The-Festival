
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

 <div class="display-4 my-3 px-2  text-center">PLACEHOLDER TEXT</div>

 <div class="display-5 my-3 px-2  text-center">Placeholder text</div>
 <div class="display-5 my-3 px-2 text-center">Placeholder text</div>

 <div class="text-center">
 <button type="button" class="btn btn-outline-secondary my-3 ">Placeholder text</button>
</div>

 </div>
 </div>
 </div>
 </div>




 <div class="container object-fit-fill border rounded" id="homePageMap">
 <div class="row object-fit-fill border rounded">

 <div class="col col-8 m-0 p-0" >
 <div class="display-6 my-3"><strong>Placeholder text</strong></div>
 <img src="./img/mapPlaceholder.png" alt="" class="homePageMapPlaceholder">
 <div class="display-6 my-3 px-2 ">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce accumsan eros nisl, non laoreet est aliquam quis. Aliquam pulvinar, ex dignissim fringilla pulvinar, sem nulla vehicula magna, ac lacinia tellus nunc vel ligula. Nulla ut blandit nunc. Morbi suscipit sodales erat et interdum. Nunc vel ipsum augue.</div>


 </div>

 <div class="col col-4 m-0 p-0 " >
 <div class="display-6 my-3 px-4"><strong>Placeholder text</strong></div>
 <div class="border rounded mx-5 pt-2 pb-5 px-2"  id="homePageInfo" >
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce accumsan eros nisl, non laoreet est aliquam quis. 

 <div  class="mt-5 px-2 ">
 <p class="d-inline">Placeholder text</p>
 <img src="./img/iconPlaceholder.png" alt="" class="homePageInfoImg">

 </div>


 </div>
 </div>


 </div>
 </div>

 </main>
 </body>
 </html>
 ';
?>
