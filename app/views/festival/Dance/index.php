<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Dance!!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="/css/festival/Dance/IndexPage.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/22097c36aa.js" crossorigin="anonymous"></script>
    <meta name="description" content="">
    <meta name="author" content="">
</head>
<body>
<div class="compartment-1 d-flex align-items-end">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 overflow-hidden p-0">
                <img src="<?php echo $this->getImageFullPath($dancePage->getContent()->getBodyHead()->getImage()) ?>"
                     class="img-fluid h-100 position-absolute top-0 start-0" alt="Cover Image">
                <span class="position-absolute bottom-0 start-0 mb-3 d-flex align-items-center"
                      style="z-index: 99; padding-left: 20px;">
          <h2 class="text-white fw-bold mb-0 ps-3 festivalFont"><?= $bodyHead->getH1()?></h2>
          <h5 class="text-white fw-bold mb-0 ms-3 danceFont"> <?= $bodyHead->getH2()?></h5>
        </span>
            </div>
        </div>
    </div>
</div>
<div class="px-4 my-5 text-center">
    <?php foreach($paragraphs as $paragraph){ ?>

    <h4 style="font-weight: 600"><?=$paragraph->getTitle() ?></h4>
    <div class="col-lg-10 mx-auto">
        <p class="lead mb-4"><?=$paragraph->getText() ?> </p>
    </div>
    <?php } ?>
</div>
<div id="product-carousel" class="carousel slide carousel-fade py-2" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="row">
                <div class="col-md-3">
                    <div class="card border-0">
                        <img src="https://via.placeholder.com/300x300.png?text=Product+1" class="card-img-top border"
                             alt="..." style="border-radius:50%;max-height: 409px;max-width: 409px ">
                        <div class="card-body text-center">
                            <h4 class="card-title">Product 1</h4>
                            <button class="btn btn-primary">Artist</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x300.png?text=Product+2" class="card-img-top"
                             alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Product 2</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                                blandit nunc vitae magna viverra, nec ultrices velit suscipit. </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x300.png?text=Product+3" class="card-img-top"
                             alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Product 3</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                                blandit nunc vitae magna viverra, nec ultrices velit suscipit. </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x300.png?text=Product+4" class="card-img-top"
                             alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Product 4</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                                blandit nunc vitae magna viverra, nec ultrices velit suscipit. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x300.png?text=Product+5" class="card-img-top"
                             alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Product 5</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                                blandit nunc vitae magna viverra, nec ultrices velit suscipit. </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x300.png?text=Product+7" class="card-img-top"
                             alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Product 7</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                                blandit nunc vitae magna viverra, nec ultrices velit suscipit. </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x300.png?text=Product+8" class="card-img-top"
                             alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Product 8</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                                blandit nunc vitae magna viverra, nec ultrices velit suscipit. </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x300.png?text=Product+9" class="card-img-top"
                             alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Product 9</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                                blandit nunc vitae magna viverra, nec ultrices velit suscipit. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#product-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#product-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<div class="d-flex align-items-center justify-content-center container-fluid py-3">
    <div class="breakingLine"></div>
</div>
<div class="container d-flex justify-content-center">
    <div class="card w-75 p-3 border-0" style="background-color:#D9D9D9;border-radius: 49px; ">
        <h4 class="text-center py-2" style="color:#CD3600; font-weight: bold;font-size: 36px; opacity: 1; ">PRICES</h4>
        <ul>

            <li class="list-group-item pb-3">
                <pre>Regular Participant:           <strong>€60,00 - €110,00</strong></pre>
            </li>
            <li class="list-group-item pb-3">
                <pre>All-access Pass (28 July):     <strong>€125,00</strong>   <button class="button">Buy</button></pre>
            </li>
            <li class="list-group-item pb-3">
                <pre>All-access Pass (29/30 July):  <strong>€150,00</strong>   <button class="button">Buy</button></pre>
            </li>
            <li class="list-group-item pb-3">
                <pre>All-access Pass (three days):  <strong>€250,00</strong>   <button class="button">Buy</button></pre>
            </li>
        </ul>
    </div>
</div>
<div class="container-fluid ps-3">
    <div class="container-fluid ps-5">
        <div class="container-fluid ps-5">
            <span class="align-left ps-5"><button class="button" data-bs-toggle="collapse"
                                                  data-bs-target="#FilterArtist" style="height:48px;!important; "><i
                    class="fa-solid fa-bars"></i>  Filter</button></span>
        </div>
        <div class="collapse" id="FilterArtist">
            <div class="container d-flex justify-content-center align-items-center" id="filterContainer"
                 style="display: none;">
                <div class="card ps-4 mx-auto"
                     style="border:7px solid rgba(205, 53, 0, 1); border-radius:49px; width:2000px;">
                    <div class="row md-auto pb-4 pt-5">
                        <div class="col-4 ps-4">
                            <h5 class="text-center" style="color: rgba(205, 53, 0, 1);font-size:40px;">
                                ARTIST</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="hardwell">
                                <label class="form-check-label" for="hardwell">
                                    Hardwell
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="armin">
                                <label class="form-check-label" for="armin">
                                    Armin van Buuren
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="garrix">
                                <label class="form-check-label" for="garrix">
                                    Martin Garrix
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="tiesto">
                                <label class="form-check-label" for="tiesto">
                                    Tiësto
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="romero">
                                <label class="form-check-label" for="romero">
                                    Nicky Romero
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="afrojack">
                                <label class="form-check-label" for="afrojack">
                                    Afrojack
                                </label>
                            </div>

                        </div>
                        <div class="col-4">
                            <h5 class="text-center" style="color: rgba(205, 53, 0, 1);font-size:40px; ">
                                VENUE</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="check1">
                                <label class="form-check-label" for="check1">
                                    <a href="#" class="link">Club Stalker</a>
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="check2">
                                <label class="form-check-label" for="check2">
                                    <a href="#" class="link">Caprera ..</a>
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="check3">
                                <label class="form-check-label" for="check3">
                                    <a href="#" class="link">Jopenkerk</a>
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="check4">
                                <label class="form-check-label" for="check4">
                                    <a href="#" class="link">Lichtfabriek</a>
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="check5">
                                <label class="form-check-label" for="check5">
                                    <a href="#" class="link">Club Ruis</a>
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="check6">
                                <label class="form-check-label" for="check6">
                                    <a href="#" class="link">XO the Club</a>
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <h5 class="text-center" style="color: rgba(205, 53, 0, 1);font-size:40px;">
                                STYLE</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="danceCheckbox">
                                <label class="form-check-label" for="danceCheckbox">
                                    Dance
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="houseCheckbox">
                                <label class="form-check-label" for="houseCheckbox">
                                    House
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="tranceCheckbox">
                                <label class="form-check-label" for="tranceCheckbox">
                                    Trance
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="technoCheckbox">
                                <label class="form-check-label" for="technoCheckbox">
                                    Techno
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="electronicCheckbox">
                                <label class="form-check-label" for="electronicCheckbox">
                                    Electronic
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="minimalCheckbox">
                                <label class="form-check-label" for="minimalCheckbox">
                                    Minimal
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
            <span class="float-start">
                <button class="btnRemoveFilter" type="reset">Remove filters</button>
            </span>
                            <span class="float-end">
                <button class="btnApplyFilter">Apply filters</button>
            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid  pt-5 ps-5">
            <div class="row">
                <div class="col-4">
                    <button class="lblButton w-100" disabled>28 july -Friday</button>
                </div>
                <div class="col-4">
                    <button class="lblButton w-100" disabled>28 july -Friday</button>
                </div>
                <div class="col-4">
                    <button class="lblButton  w-100" disabled>28 july -Friday</button>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-4">
                    <div class="MyContainer position-relative">
                        <div class="container d-flex align-items-center justify-content-center">
                            <span class="time position-absolute top-0 start-50 translate-middle-x">20:00</span>
                            <div class="line "></div>
                        </div>
                        <label class="artistName position-absolute bottom-3 start-50 translate-middle-x">Nicky Romero |
                            Afrojack</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="MyContainer position-relative">
                        <div class="container d-flex align-items-center justify-content-center">
                            <span class="time position-absolute top-0 start-50 translate-middle-x">20:00</span>
                            <div class="line "></div>
                        </div>
                        <label class="artistName position-absolute bottom-3 start-50 translate-middle-x">Nicky Romero |
                            Afrojack</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="MyContainer position-relative">
                        <div class="container d-flex align-items-center justify-content-center">
                            <span class="time position-absolute top-0 start-50 translate-middle-x">20:00</span>
                            <div class="line "></div>
                        </div>
                        <label class="artistName position-absolute bottom-3 start-50 translate-middle-x">Nicky Romero |
                            Afrojack</label>
                    </div>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-4">
                    <div class="MyContainer position-relative">
                        <div class="container d-flex align-items-center justify-content-center">
                            <span class="time position-absolute top-0 start-50 translate-middle-x">20:00</span>
                            <div class="line "></div>
                        </div>
                        <label class="artistName position-absolute bottom-3 start-50 translate-middle-x">Nicky Romero |
                            Afrojack</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="MyContainer position-relative">
                        <div class="container d-flex align-items-center justify-content-center">
                            <span class="time position-absolute top-0 start-50 translate-middle-x">20:00</span>
                            <div class="line "></div>
                        </div>
                        <label class="artistName position-absolute bottom-3 start-50 translate-middle-x">Nicky Romero |
                            Afrojack</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="MyContainer position-relative">
                        <div class="container d-flex align-items-center justify-content-center">
                            <span class="time position-absolute top-0 start-50 translate-middle-x">20:00</span>
                            <div class="line "></div>
                        </div>
                        <label class="artistName position-absolute bottom-3 start-50 translate-middle-x">Nicky Romero |
                            Afrojack</label>
                    </div>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-4">
                    <div class="MyContainer position-relative">
                        <div class="container d-flex align-items-center justify-content-center">
                            <span class="time position-absolute top-0 start-50 translate-middle-x">20:00</span>
                            <div class="line "></div>
                        </div>
                        <label class="artistName position-absolute bottom-3 start-50 translate-middle-x">Nicky Romero |
                            Afrojack</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="MyContainer position-relative">
                        <div class="container d-flex align-items-center justify-content-center">
                            <span class="time position-absolute top-0 start-50 translate-middle-x">20:00</span>
                            <div class="line "></div>
                        </div>
                        <label class="artistName position-absolute bottom-3 start-50 translate-middle-x">Nicky Romero |
                            Afrojack</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="MyContainer position-relative">
                        <div class="container d-flex align-items-center justify-content-center">
                            <span class="time position-absolute top-0 start-50 translate-middle-x">20:00</span>
                            <div class="line "></div>
                        </div>
                        <label class="artistName position-absolute bottom-3 start-50 translate-middle-x">Nicky Romero |
                            Afrojack</label>
                    </div>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-4">
                    <div class="MyContainer position-relative">
                        <div class="container d-flex align-items-center justify-content-center">
                            <span class="time position-absolute top-0 start-50 translate-middle-x">20:00</span>
                            <div class="line "></div>
                        </div>
                        <label class="artistName position-absolute bottom-3 start-50 translate-middle-x">Nicky Romero |
                            Afrojack</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="MyContainer position-relative">
                        <div class="container d-flex align-items-center justify-content-center">
                            <span class="time position-absolute top-0 start-50 translate-middle-x">20:00</span>
                            <div class="line "></div>
                        </div>
                        <label class="artistName position-absolute bottom-3 start-50 translate-middle-x">Nicky Romero |
                            Afrojack</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="MyContainer position-relative">
                        <div class="container d-flex align-items-center justify-content-center">
                            <span class="time position-absolute top-0 start-50 translate-middle-x">20:00</span>
                            <div class="line "></div>
                        </div>
                        <label class="artistName position-absolute bottom-3 start-50 translate-middle-x">Nicky Romero |
                            Afrojack</label>
                    </div>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-4">
                    <div class="MyContainer position-relative">
                        <div class="container d-flex align-items-center justify-content-center">
                            <span class="time position-absolute top-0 start-50 translate-middle-x">20:00</span>
                            <div class="line "></div>
                        </div>
                        <label class="artistName position-absolute bottom-3 start-50 translate-middle-x">Nicky Romero |
                            Afrojack</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="MyContainer position-relative">
                        <div class="container d-flex align-items-center justify-content-center">
                            <span class="time position-absolute top-0 start-50 translate-middle-x">20:00</span>
                            <div class="line "></div>
                        </div>
                        <label class="artistName position-absolute bottom-3 start-50 translate-middle-x">Nicky Romero |
                            Afrojack</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="MyContainer position-relative">
                        <div class="container d-flex align-items-center justify-content-center">
                            <span class="time position-absolute top-0 start-50 translate-middle-x">20:00</span>
                            <div class="line "></div>
                        </div>
                        <label class="artistName position-absolute bottom-3 start-50 translate-middle-x">Nicky Romero |
                            Afrojack</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid pt-5">
    <div class="px-4 my-3 text-center">
        <div class="col-lg-10 mx-auto">
            <p class="lead mb-4" style="color: #CD3600; font-weight: bold; font-size:36px; ">The capacity of the Club
                sessions is very limited. Availability for All-Access pas holders can not be guaranteed due to safety
                regulations</p>
        </div>
    </div>
    <div class="px-3 my-3 text-center">
        <div class="col-lg-10 mx-auto">
            <p class="lead mb-4" style="color: #CD3600; font-weight: bold; font-size:36px; ">Tiësto World is a special
                session spanning his career’s work. There will also be some special guests</p>
        </div>
    </div>
</div>
</body>