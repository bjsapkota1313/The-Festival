<section class="home-section">
    <script src="/Javascripts/tinymce/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
    <div class="container-fluid pb-3 pt-3 ps-5">
        <div class="row ps-3">
            <div class="col-md-12" class="ps-5">
                <h1><?= $title ?></h1>
            </div>
        </div>
    </div>
    <div class="container">
        <textarea rows="35" id="editingPage">
    <img src="/image/InstagramImage1.png" >
  </textarea>
        <script>
            tinymce.init({
                selector: 'textarea',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount button ',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | ' +
                    'link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | button',
            });
        </script>
    </div>
</section>
