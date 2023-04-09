<section class="home-section">
    <script src="https://cdn.tiny.cloud/1/8q7yq04ylnzkpg8qr9ypmn6p2cmtaq2l0qe3spmlawy8b4qn/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>
    <div class="container-fluid pb-3 pt-3 ps-5">
        <div class="row ps-3">
            <div class="col-md-12" class="ps-5">
                <h1><?= $title ?></h1>
            </div>
        </div>
    </div>
    <div class="container">
    <textarea rows="35" id="pageEditor">
        This is the initial content of the editor
    </textarea>
    </div>
    <script>
        const image_upload_handler_callback = (blobInfo, progress) => new Promise((resolve, reject) => {
            let xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', 'http://localhost/api/infoPagesImages/uploadImage');
            xhr.onload = function () {
                let json;
                if (xhr.status != 200) {
                    reject('HTTP Error: ' + xhr.status);
                    return;
                }
                json = JSON.parse(xhr.responseText);
                if (!json || typeof json.location != 'string') {
                    reject('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                resolve(json.location);
            };
            formData = new FormData();
            formData.append('image', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        });

        tinymce.init({
            selector: '#pageEditor',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable ' +
                'advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss image ',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table ' +
                'mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist ' +
                'numlist bullist indent outdent | emoticons charmap | removeformat |image ',
            tinycomments_mode: 'embedded',
            images_upload_url: 'http://localhost/api/infoPagesImages/uploadImage',
            automaticUploads: false,
            mergetags_list: [
                {value: 'First.Name', title: 'First Name'},
                {value: 'Email', title: 'Email'},
            ],
            images_upload_handler: image_upload_handler_callback,
        });

    </script>
</section>

