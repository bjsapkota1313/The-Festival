<?php
// session_start()
if(isset($model) && $model != null) {
  $restaurants = $model;
}
else {
  $restaurants = null;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Festival</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <script src="/Javascripts/tinymce/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        /* replace textarea having class .tinymce with tinymce editor */
        selector: "#mytextarea",
        plugins: 'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking image save table contextmenu directionality emoticons template paste textcolor',
    });
    </script>
  </head>

  <body>
    <div class="container col-sm-12 col-md-6 col-lg-4">
        <?php
        foreach ($restaurants as $restaurant) {
            include("showSingleRestaurant.php");
        }
        ?>
    </div>
  </body>
</html>
