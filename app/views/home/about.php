<?php

include __DIR__ . '/../header.php';
?>
<!--    <!doctype html>-->
<!--    <html lang="en">-->
<!--    <head>-->
<!--        <meta charset="UTF-8">-->
<!--        <meta http-equiv="X-UA-Compatible" content="IE=edge">-->
<!--        <meta name="viewport" content="width=device-width, initial-scale=1.0">-->
<!--        <title>Bootstrap example</title>-->
<!--        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"-->
<!--              integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">-->
<!--        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" rel="stylesheet">-->
<!--        <link rel="stylesheet" href="/css/style.css">-->
<!--    </head>-->
<!--    <body>-->
    <form method="POST" enctype="multipart/form-data">
        <section class="vh-100 cardBackground" >
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-lg-12 col-xl-11">
                        <div class="card text-black h-100" style="border-radius: 25px;">
                            <div class="card-body p-md-5">
                                <div class="row justify-content-center">
                                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>
                                        <form class="mx-1 mx-md-4" method="post" enctype="multipart/form-data">
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="text" name="firstName" id="form3Example4c" class="form-control"/>
                                                    <label class="form-label" for="form3Example4c">First Name</label>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="text" name="lastName" id="form3Example4c" class="form-control"/>
                                                    <label class="form-label" for="form3Example4c">Last Name</label>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="date" name="dateOfBirth" id="form3Example3c"
                                                           class="form-control"/>
                                                    <label class="form-label" for="form3Example3c">Birte Date</label>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="email" name="email" id="form3Example4c" class="form-control"/>
                                                    <label class="form-label" for="form3Example4c">Email</label>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="password" name="password" id="form3Example4c" class="form-control"/>
                                                    <label class="form-label" for="form3Example4c">Password</label>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="password" name="passwordConfirm" id="form3Example4c" class="form-control"/>
                                                    <label class="form-label" for="form3Example4c">Confirm Password</label>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="file" name="createUserImage" id="form3Example3c" class="form-control" accept=".jpg, .jpeg, .png" value="" />
                                                    <label class="form-label" for="form3Example3c">Select Image</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="captcha-code">Captcha Code</label>
                                                <div><?php echo $captch; ?></div>
                                            </div>
                                            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                                <button type="submit" name="registerBtn" class="btn btn-primary btn-lg">Register</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
    </body>
    </html>
<?php

include __DIR__ . '/../footer.php';
