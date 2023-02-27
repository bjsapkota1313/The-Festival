<?php
// session_start()
if(isset($model) && $model != null) {
  $page = $model;
}
else {
  $page = null;
}
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
    <?php
    if($page == null) {
      echo "<h1>Create a new page with TinyCME editor</h1>";
    }
    else {
      echo "<h1>Edit an existing page with TinyCME editor</h1>";
    }

    ?>

    <form action="/home/editorSubmitted" method="POST">
      <div class="form-floating mb-3">
        <textarea id="mytextarea" name="tinyMCEform">
          <?php 
          if($page == null) echo "Hello World!";
          else {
            echo $page->getBodyContentHTML();
          }
          ?>
        </textarea>
      </div>
      <div class="form-floating mb-3">
        <label for="floatingInput">Page Title</label>
        <input type="text"
        class="form-control"
        name="pageTitle"
        id="pageTitle"
        placeholder="Page Title"
        <?php 
        if($page !=null) echo "value=".$page->getTitle();
        ?>
        >
      </div>
      <?php
      if($page != null) {
        $pageId = $page->getId();
      ?>
        <div class="form-floating mb-3">
        <input type="hidden" class="form-control" name="pageID" id="pageID" value= <?php echo $pageId; ?> >
        </div>
      <?php
      }
      ?>
      <div class="form-floating mb-3">
        <button class="btn mb-2" name="formSubmit" type="submit">
        <?php 
        if($page == null) echo "Submit";
        else echo "Update";
        ?>
        </button>
      </div>
      <?php 
      if($page != null) {
      ?>
      <div class="form-floating mb-3">
        <button class="btn mb-2" name="formDelete" type="submit">
        Delete      
        </button>
      </div>
      <?php 
            }
      ?>
    </form>
    </div>
    </div>
    </div>
    </div>
  </body>
</html>
