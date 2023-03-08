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
    <link href="/css/festival/Dance/ArtistPage.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/22097c36aa.js" crossorigin="anonymous"></script>
    <meta name="description" content="">
    <meta name="author" content="">
</head>
<body>
<div class="compartment-1 d-flex align-items-end">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 overflow-hidden p-0">
                <img src="/image/Festival/Dance/Matrix-Garrix.png"
                     class="img-fluid h-100 position-absolute top-0 start-0" alt="Cover Image" style="width: 100vw">
                <span class="position-absolute bottom-0 start-0 mb-3 d-flex align-items-center"
                      style="z-index: 99; padding-left: 20px;">
               <h2 class="text-white fw-bold mb-0 ps-3 DanceFont">Dance</h2>
               <h5 class="text-white fw-bold mb-0 ms-3 artistNameFont">Martin Garrix</h5>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid pt-3">
    <span class="float-left ps-3">
        <button class="BackButton" onclick="history.back()">
        <i class="fa-solid fa-arrow-left fa-xl"></i>
    </button>
    </span>
</div>
<div class="container-fluid px-md-5 ">
    <div class="container-fluid pt-3 ps-3 pb-3">
        <div class="row ps-3">
            <div class="col-6 ps-3">
                <p class="text-center" style="font-size: 24px;">
                    Martin Garrix is a top rated Dutch DJ and producer. He has performed at festivals such as Coachella,
                    Electric Daisy Carnival, Ultra Music Festival, Tomorrowland, and Creamfields. He made his debut at
                    age
                    17, when he was the youngest ever headliner of Ultra South Africa. Martin Garrix founded the label
                    Stmpd
                    Rcrds in 2016. He is best known for his singles “Animals”, “In the Name of Love”, and “Scared to be
                    Lonely”.
                </p>
            </div>
            <div class="col-6 justify-content-center">
                <svg class="pr-3">
                    <img src="/image/Festival/Dance/martinGarixx.png">
                </svg>
            </div>
        </div>
    </div>
    <div class="container-fluid pb-4 px-md-5">
        <div class="d-flex align-items-center justify-content-center">
            <img src="/image/Festival/Dance/martinGariixPotrait.png"
                 style="width: 100%; height: 100%; border-radius: 49px;">
        </div>
        <div class="container-fluid pt-5">
            <div class="row">
                <div class="col">
              <span class="float-start ps-1">
            <h5 style="font-weight: bold; font-size: 40px; margin-bottom: -25px;">Albums and Singles</h5><br>
             </span>
                </div>
            </div>
            <div class="row">
                <?php foreach ($artistAlbums->items as $album) { ?>
                    <div class="col-2">
                        <div class="podcast-card">
                            <div class="frame-117">
                                <img src="<?= $album->images[0]->url ?>" class="img-fluid" alt="<?= $album->name ?>">
                            </div>
                            <div class="text ps-3">
                                <p class="albumName"><?= $this->getFormattedStringToDisplay($album->name, 7) ?></p>
                                <p class="detail-Text"><?= date('Y', strtotime($album->release_date)) ?> <i
                                            class="fa-sharp fa-solid fa-circle fa-2xs"></i> <?= $album->album_type ?>
                                </p>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="container-fluid ps-5 pt-3">
        <div class="row">
            <div class="col-6">
                <div class="card ps-3" style="border: 2px solid #000000;border-radius: 49px;">
                    <div class="card-header text-center pb-4 pt-4"
                         style="background-color: transparent; border-bottom: none;">
                        <h5 style="font-weight: bold; font-size: 40px; margin-bottom: -25px;">Show times</h5>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-center text-center">
                        <div class="container pb-5">
                            <button class="DateShowButton mx-auto" disabled>Friday</button>
                            <br>
                            <label class="timeLabel">22:00 - 23:30 <a class="link">Club Ruis</a></label>
                            <br>
                            <button class="BookBtn mx-auto">Book Ticket <i class="fa-solid fa-circle-arrow-right"></i>
                            </button>
                            <br>
                        </div>
                        <div class="container pb-5">
                            <button class="DateShowButton mx-auto" disabled>Friday</button>
                            <br>
                            <label class="timeLabel">22:00 - 23:30 <a class="link">Club Ruis</a></label>
                            <br>
                            <button class="BookBtn mx-auto">Book Ticket <i class="fa-solid fa-circle-arrow-right"></i>
                            </button>
                            <br>
                        </div>
                        <div class="container pb-5">
                            <button class="DateShowButton mx-auto" disabled>Friday</button>
                            <br>
                            <label class="timeLabel">22:00 - 23:30 <a class="link">Club Ruis</a></label>
                            <br>
                            <button class="BookBtn mx-auto">Book Ticket <i class="fa-solid fa-circle-arrow-right"></i>
                            </button>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="container-fluid">
                    <p style="font-style: normal;font-weight: 700;font-size: 40px;line-height: 64px;text-align: center;">Check out tracks</p>
                </div>
                <div class="card" style="background-color:#121D22; border-radius: 30px; border: none">
                    <div class="container-fluid">

                        <div class="col">
                            <div class="hoverable">
                                <?php foreach ($artistTopTracks as $track) { ?>
                                    <div class="row-1">
                                        <div class="container text-light">
                                            <div class="container" style="margin-left:-20px">
                                                 <span class="float-start pt-2">
                                                <button id="playPauseButton<?= $track->id ?>" class="btn"
                                                        onclick="togglePlayPause('<?= $track->preview_url ?>', '<?= $track->id ?>')"
                                                        style="background-color:#121D22;color: white; border: none;padding:0;">
                                                  <i class="fa-solid fa-play fa-2xl"></i>
                                                </button>
                                                 </span>
                                            </div>
                                            <div class="row align-items-center">
                                                <div class="col-1">
                                                    <img src="<?= $track->album->images[0]->url ?>"
                                                         alt="<?= $track->name ?>"
                                                         class="img-fluid" style="width: 40px; height:38px;">
                                                </div>
                                                <div class="col-6 " style="margin-left: -15px">
                                                    <h2 class="pt-2 "><?= $this->getFormattedStringToDisplay($track->name, 20) ?></h2>
                                                </div>
                                                <div class="col-4">
                                                </div>
                                                <div class="col-1 ps-3">
                                                    <span class="float-end pt-1 ps-5 text-right">
                                                    <p class="ps-2 pt-3"
                                                       style="font-size:20px;color: #606161"><?= gmdate("i:s", round($track->duration_ms / 1000)) ?></p>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid pt-5 pb-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8" style="border-radius: 49px;">
                    <img src="/image/Festival/Dance/martinGariixPotrait.png" class="img-fluid" alt="ALBUM_NAME"
                         style="height:613px; width: 963px; border-radius: 49px;">
                </div>
                <div class="col-4" style="border-radius: 49px;">
                    <img src="/image/Festival/Dance/martinGariixPotrait.png" class="img-fluid" alt="ALBUM_NAME"
                         style="height: 613px; width: 524px; border-radius: 49px;">
                </div>
            </div>
        </div>
    </div>
    <style>
        .hoverable :hover {
            background-color: rgba(217, 217, 217, 0.2);
        }

    </style>
</div>

<script>
    // let audio =new Audio();
    // let isPlaying = false;
    // let currentTrackId = null;
    //
    // // Play a track
    // function playTrack(url, trackId) {
    //     if (!audio || audio.src !== url) {
    //         audio = new Audio(url);
    //         audio.addEventListener('ended', function() {
    //             stopTrack(trackId);
    //         });
    //         audio.addEventListener('pause', function() {
    //             stopTrack(trackId);
    //         });
    //     }
    //
    //     audio.src = url;
    //     audio.play();
    //     isPlaying = true;
    //     currentTrackId = trackId;
    //     updateButton(trackId);
    // }
    //
    // // Pause a track
    // function pauseTrack() {
    //     audio.pause();
    //     isPlaying = false;
    // }
    //
    // // Stop a track
    // function stopTrack(trackId) {
    //     audio.currentTime = 0;
    //     pauseTrack();
    //     updateButton(trackId);
    // }
    //
    // // Toggle play/pause button and audio playback
    // function togglePlayPause(url, trackId) {
    //     if (isPlaying && audio.paused && audio.src === url) {
    //         audio.play();
    //         isPlaying = true;
    //     } else if (isPlaying && !audio.paused && audio.src === url) {
    //         pauseTrack();
    //     } else {
    //         if (isPlaying && audio.src !== url) {
    //             pauseTrack();
    //             let playingButtonId = currentTrackId;
    //             let playingButton = document.getElementById("playPauseButton" + playingButtonId);
    //             playingButton.innerHTML = '<i class="fa-solid fa-play fa-2xl"></i>';
    //         }
    //         pauseTrack(); // pause current track
    //         playTrack(url, trackId); // play new track
    //     }
    // }
    //
    // // Update the play/pause button
    // function updateButton(trackId) {
    //     let button = document.getElementById("playPauseButton" + trackId);
    //     button.innerHTML = isPlaying ? '<i class="fa-solid fa-pause fa-2xl"></i>' : '<i class="fa-solid fa-play fa-2xl"></i>';
    // }
    let audio = null;
    let isPlaying = false;
    let currentTrackId = null;
    let isTrackPlaying = false;

    // Play a track
    function playTrack(url, trackId) {
        if (!audio || audio.src !== url) {
            audio = new Audio(url);
            audio.addEventListener('ended', function() {
                stopTrack(trackId);
            });
            audio.addEventListener('pause', function() {
                stopTrack(trackId);
            });
            audio.addEventListener('playing', function() {
                isTrackPlaying = true;
            });
        }

        audio.src = url;
        if (!isPlaying) {
            audio.play();
            isPlaying = true;
        }
        currentTrackId = trackId;
        updateButton(trackId);
    }

    // Pause a track
    function pauseTrack() {
        if (isTrackPlaying) {
            audio.pause();
            isPlaying = false;
            isTrackPlaying = false;
        }
    }

    // Stop a track
    function stopTrack(trackId) {
        audio.currentTime = 0;
        pauseTrack();
        updateButton(trackId);
    }

    // Toggle play/pause button and audio playback
    function togglePlayPause(url, trackId) {
        if (isPlaying && audio.paused && audio.src === url) {
            audio.play();
            isPlaying = true;
        } else if (isPlaying && !audio.paused && audio.src === url) {
            pauseTrack();
        } else {
            if (isPlaying && audio.src !== url) {
                pauseTrack();
                let playingButtonId = currentTrackId;
                let playingButton = document.getElementById("playPauseButton" + playingButtonId);
                playingButton.innerHTML = '<i class="fa-solid fa-play fa-2xl"></i>';
            }
            playTrack(url, trackId);
        }
    }

    // Update the play/pause button
    function updateButton(trackId) {
        let button = document.getElementById("playPauseButton" + trackId);
        if (trackId === currentTrackId) {
            button.innerHTML = isPlaying ? '<i class="fa-solid fa-pause fa-2xl"></i>' : '<i class="fa-solid fa-play fa-2xl"></i>';
        } else {
            button.innerHTML = '<i class="fa-solid fa-play fa-2xl"></i>';
        }
    }



</script>

</body>