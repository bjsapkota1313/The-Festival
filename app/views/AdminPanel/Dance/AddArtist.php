<section class="home-section">
    <div class="container pb-3 pt-3">
        <div class="row">
            <div class="col-md-12">
                <h1> <?= $title ?></h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-5">
                <form id="AddPerformance" class="mx-1 mx-md-4" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label" for="ArtistName">Artist Name</label>
                        <input type="text" name="artistName" id="artistName" class="form-control"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
