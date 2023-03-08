<!DOCTYPE html>
<html>
<head>
    <title>Spotify Web Playback SDK Quick Start</title>
</head>
<body>
    <audio id="myAudio" controls loop>
            <source id="audioSource" src="<?php echo $track->preview_url; ?>" type="audio/mpeg">
    </audio>
<!--<audio id="myAudio" controls loop>-->
<!--    <source id="audioSource" src="--><?php //echo $track->preview_url; ?><!--" type="audio/mpeg">-->
<!--</audio>-->

<?php
echo '<div class="track">';
echo '<p>' . $track->name . '</p>';
echo '<p>' . $track->artists[0]->name . '</p>';
echo'<p>'.$track->uri.'</p>';
?>
<style>
    #myAudio::-webkit-media-controls-panel,
    #myAudio::-webkit-media-controls {
        background-color: #121D22 !important;
        border-radius: inherit !important;
        border: none !important;
    }

    #myAudio::-webkit-media-controls-play-button,
    #myAudio::-webkit-media-controls-start-playback-button,
    #myAudio::-webkit-media-controls-pause-button {
        filter: invert(100%);
        height: 50px !important;
        width: 50px !important;
    }

    #myAudio::-webkit-media-controls-timeline
    ,#myAudio::-webkit-media-controls-volume-control-container,
    #myAudio::-webkit-media-controls-current-time-display,
    #myAudio::-webkit-media-controls-time-remaining-display
    {
        display: none !important;;
    }




</style>
<!--<div class="container-fluid bg-dark text-light py-4">-->
<!--    <div class="row">-->
<!--        <div class="col-md-4 text-center">-->
<!--            <img src="--><?php //echo $track->album->images[0]->url; ?><!--" alt="--><?php //echo $track->album->name; ?><!--" class="img-fluid">-->
<!--            <h3 class="mt-3">--><?php //echo $track->name; ?><!--</h3>-->
<!--            <p class="mb-0">--><?php //echo $track->artists[0]->name; ?><!--</p>-->
<!--            <p class="mb-0">--><?php //echo $track->album->name; ?><!--</p>-->
<!--        </div>-->
<!--        <div class="col-md-4 text-center">-->
<!--            <audio id="myAudio" controls loop class="w-100">-->
<!--                <source id="audioSource" src="--><?php //echo $track->preview_url; ?><!--" type="audio/mpeg">-->
<!--            </audio>-->
<!--        </div>-->
<!--        <div class="col-md-4 text-center">-->
<!--            <div class="d-flex justify-content-center">-->
<!--                <button id="playButton" class="btn btn-light me-3"><i class="bi bi-play"></i></button>-->
<!--                <button id="pauseButton" class="btn btn-light"><i class="bi bi-pause"></i></button>-->
<!--            </div>-->
<!--            <div class="mt-3">-->
<!--                <span id="totalTime">--><?php //echo gmdate("i:s", round($track->duration_ms / 1000)); ?><!--</span>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!---->
<!--<script>-->
<!--    const audio = document.getElementById("myAudio");-->
<!--    const playButton = document.getElementById("playButton");-->
<!--    const pauseButton = document.getElementById("pauseButton");-->
<!---->
<!--    // Add click event listeners to play/pause buttons-->
<!--    playButton.addEventListener("click", () => {-->
<!--        audio.play();-->
<!--    });-->
<!---->
<!--    pauseButton.addEventListener("click", () => {-->
<!--        audio.pause();-->
<!--    });-->
<!--</script>-->


</body>
