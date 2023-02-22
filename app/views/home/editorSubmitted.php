<?php
// session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Festival</title>
    <script src="/Javascripts/tinymce/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        /* replace textarea having class .tinymce with tinymce editor */
        selector: "#mytextarea2",
        
        /* display statusbar */
        statubar: true,
        plugins: 'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking image wordcount save table contextmenu directionality emoticons template paste textcolor',
        // file_picker_types: 'file image media'
    });
    </script>
  </head>

  <body>
    <?php
        if(isset($model) && $model != null) echo $model;
    ?>
  </body>
</html>
