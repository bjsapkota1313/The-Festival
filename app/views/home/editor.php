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
        selector: "#mytextarea",
        plugins: 'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking image wordcount save table contextmenu directionality emoticons template paste textcolor',
    });
    </script>
  </head>

  <body>
  <div class="row g-0">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-sm-12 col-md-6 col-lg-4 mx-auto">
    <h1>Create a new page with TinyCME editor</h1>
    <form action="/home/editorSubmitted" method="POST">
      <div class="form-floating mb-3">
        <textarea id="mytextarea" name="tinyMCEform">
          Hello, World!
        </textarea>
      </div>
      <div class="form-floating mb-3">
        <label for="floatingInput">Page Title</label>
        <input type="text" class="form-control" name="pageTitle" id="pageTitle" placeholder="Page Title"> 
      </div>
      <div class="form-floating mb-3">
        <button class="btn mb-2" name="formSubmit" type="submit">
          Submit
        </button>
      </div>
    </form>
    </div>
    </div>
    </div>
    </div>
  </body>
</html>
