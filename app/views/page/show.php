
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Festival</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <script src="/Javascripts/tinymce/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
  <link href="/../css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
  <main>
    <span id="userId" style="display:none">
      <?php echo $currentUserId; ?>
    </span>
    <span id="pageId" style="display:none">
      <?php echo $pageId; ?>
    </span>


    <?php if (isset($model) && $model != null)  echo $model;?>

    <script src="/Javascripts/HomePage.js"></script>

  </main>
</body>

</html>
