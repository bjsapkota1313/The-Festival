<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="historyMainImage" style="background: url('<?= $this->getImageFullPath($bodyHead->getImage()) ?>')">
    <span class="position-absolute bottom-0 start-0 mb-3 ps-3 d-flex align-items-center"
          style="z-index: 99; padding-left: 20px;">
                  <h5 class="text-white fw-bold mb-0"><?= $bodyHead->getH2() ?></h5>
          <h2 class="text-white fw-bold mb-0 ms-3"> <?= $bodyHead->getH1() ?></h2>
        </span>
</div>
<h1 class="historyHeader"><?= $eventPage->getContent()->getH2() ?></h1>
<div class="historyContainer">
    <div class="historyInformation">
        <?php
        foreach ($paragraphs as $paragraph) {
            ?>
            <h2><?= $paragraph->getTitle() ?></h2>
            <p><?= nl2br($paragraph->getText()) ?></p><br>
        <?php } ?>
    </div>
    <div class="historyWalkingRoute">
    <span class="fw-bold fs-4">
    Location information
</span>
        <span>Take some time to read up on the locations you will visit on our history tours.</span><br>
        <p>The locations that will be visited are: </p>
        <ul>
            <?php
            foreach ($allTourLocations as $allTourLocation) {
                ?>
                <li>
                    <form method="GET" action="/festival/history/detail">
                        <input type="hidden" name="locationPostCode"
                               value="<?= $allTourLocation->getTourLocation()->getPostCode() ?>">
                        <input type="hidden" name="location"
                               value="<?= $allTourLocation->getTourLocation()->getLocationName() ?>">
                        <input type="hidden" name="locationId"
                               value="<?= $allTourLocation->getTourLocation()->getLocationId() ?>">
                        <button class="link"
                                type="submit"><?= $allTourLocation->getTourLocation()->getLocationName() ?></button>
                        <button><?= $allTourLocation->getLocationInfo() ?></button>
                    </form>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<h1 class="historyHeader">Showing all English tours</h1>

<!--<div class="container">-->
<!--    <div class="container-fluid pt-5 ps-5">-->
<!--        <div class="row">-->
<!--            --><?php //foreach ($timetable as $date => $toursByTime) { ?>
<!--                <div class="col-md-3 my-3 mx-auto">-->
<!--                    <button class="circleLine lblButton" disabled>--><? //= $date ?><!--</button>-->
<!--                    --><?php //foreach ($toursByTime as $time => $tours) { ?>
<!--                        <div class="tourContainer position-relative" data-date="--><? //= $date ?><!--">-->
<!--                            <div class="d-flex align-items-center justify-content-center h-100">-->
<!--                                <span class="align-self-center text-center text-lg tourTime">--><? //= $time ?><!--</span>-->
<!--                            </div>-->
<!--                            --><?php //foreach ($tours as $tour) { ?>
<!--                                <div class="container-fluid d-flex align-items-center justify-content-center tourLanguage">-->
<!--                                    --><? //= $tour->getTourLanguage()?>
<!--                                </div>-->
<!--                            --><?php //} ?>
<!--                        </div>-->
<!--                    --><?php //} ?>
<!--                </div>-->
<!--            --><?php //} ?>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!--<style>-->
<!--    .tourContainer:hover {-->
<!--        background-color: #f5f5f5;-->
<!--        cursor: pointer;-->
<!--    }-->
<!--</style>-->

<div class="container">
    <div class="container-fluid pt-5 ps-5">
        <div class="row">
            <?php foreach ($timetable as $date => $toursByTime) { ?>
                <div class="col-md-3 my-3 mx-auto">
                    <button class="circleLine lblButton" disabled><?= $date ?></button>
                    <?php foreach ($toursByTime as $time => $tours) { ?>
                        <div class="tourContainer position-relative">
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <span class="align-self-center text-center text-lg tourTime"><?= $time ?></span>
                            </div>
                            <?php foreach ($tours as $tour) { ?>
                                <div class="container-fluid d-flex align-items-center justify-content-center tourLanguage"
                                     data-tour='<?php echo json_encode($tour); ?>'>
                                    <?= $tour->getTourLanguage() ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!--<script> //working code with extra info on hovering container-->
<!--    const tourContainers = document.querySelectorAll('.tourContainer');-->
<!---->
<!--    tourContainers.forEach(function(tourContainer) {-->
<!--        const tourLanguage = tourContainer.querySelectorAll('.tourLanguage');-->
<!--        const tourTime = tourContainer.querySelector('.tourTime');-->
<!--        const tourData = JSON.parse(tourContainer.querySelector('.tourLanguage').dataset.tour);-->
<!---->
<!--        tourTime.style.marginTop = '4px';-->
<!---->
<!--        const extraInfo = document.createElement('div');-->
<!--        extraInfo.style.display = 'none';-->
<!--        extraInfo.innerHTML = "Language: " + tourData.tourLanguage + "<br>" +-->
<!--            "Duration: " + tourData.duration + "<br>" +-->
<!--            "Date: " + tourData.tourDate + "<br>" +-->
<!--            "Location: " + tourData.historyTourLocations;-->
<!--        tourContainer.appendChild(extraInfo);-->
<!---->
<!--        tourContainer.addEventListener('mouseover', function() {-->
<!--            tourContainer.style.backgroundColor = 'lightgray';-->
<!--            tourContainer.style.height = '220px';-->
<!--            tourLanguage.forEach(function(lang) {-->
<!--                lang.style.fontSize = '24px';-->
<!--                const icon = document.createElement('i');-->
<!--                icon.classList.add('fas', 'fa-globe');-->
<!--                lang.insertBefore(icon, lang.firstChild);-->
<!--            });-->
<!--            extraInfo.style.display = 'block';-->
<!--        });-->
<!---->
<!--        tourContainer.addEventListener('mouseout', function() {-->
<!--            tourContainer.style.backgroundColor = '';-->
<!--            tourContainer.style.height = '';-->
<!--            tourLanguage.forEach(function(lang) {-->
<!--                lang.style.fontSize = '';-->
<!--                lang.removeChild(lang.firstChild);-->
<!--            });-->
<!--            extraInfo.style.display = 'none';-->
<!--        });-->
<!--    });-->
<!--</script>-->

<script> //working code with extra info on hovering container
    const tourContainers = document.querySelectorAll('.tourContainer');

    tourContainers.forEach(function (tourContainer) {
        const tourLanguage = tourContainer.querySelectorAll('.tourLanguage');
        const tourTime = tourContainer.querySelector('.tourTime');
        const tourData = JSON.parse(tourContainer.querySelector('.tourLanguage').dataset.tour);
        console.log(typeof tourData)
        tourTime.style.marginTop = '4px';

        const extraInfo = document.createElement('div');
        extraInfo.style.display = 'none';

        const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const tourDate = new Date(tourData.tourDate);
        const dayOfWeek = daysOfWeek[tourDate.getDay()];

        extraInfo.innerHTML =
            "" + tourData.tourDate +"  "+ dayOfWeek + "<br>" +
            "Duration: " + tourData.duration + "<br>" +
            "Location: " + tourData.historyTourLocations +
            "" + tourData.time

        tourContainer.appendChild(extraInfo);

        tourContainer.addEventListener('mouseover', function () {
            tourContainer.style.backgroundColor = 'lightgray';
            tourContainer.style.height = '220px';
            tourLanguage.forEach(function (lang) {
                lang.style.fontSize = '24px';
                const icon = document.createElement('i');
                icon.classList.add('fas', 'fa-globe');
                lang.insertBefore(icon, lang.firstChild);
            });
            extraInfo.style.display = 'block';
        });

        tourContainer.addEventListener('mouseout', function () {
            tourContainer.style.backgroundColor = '';
            tourContainer.style.height = '';
            tourLanguage.forEach(function (lang) {
                lang.style.fontSize = '';
                lang.removeChild(lang.firstChild);
            });
            extraInfo.style.display = 'none';
        });
    });
</script>


<!--<script>-->
<!--    const tourContainers = document.querySelectorAll('.tourContainer');-->
<!---->
<!--    tourContainers.forEach(function(tourContainer) {-->
<!--        const tourLanguage = tourContainer.querySelectorAll('.tourLanguage');-->
<!--        const tourTime = tourContainer.querySelector('.tourTime');-->
<!--        const tourData = JSON.parse(tourContainer.querySelector('.tourLanguage').dataset.tour);-->
<!---->
<!--        tourTime.style.marginTop = '4px';-->
<!---->
<!--        const extraInfo = document.createElement('div');-->
<!--        extraInfo.style.display = 'none';-->
<!---->
<!--        // Print each language in a separate line-->
<!--        let languagesText = '';-->
<!--        tourData.tourLanguage.forEach(function(lang, index) {-->
<!--            if (index > 0) {-->
<!--                languagesText += "<br>";-->
<!--            }-->
<!--            languagesText += lang;-->
<!--        });-->
<!---->
<!--        extraInfo.innerHTML = "Language: " + languagesText + "<br>" +-->
<!--            "Duration: " + tourData.duration + "<br>" +-->
<!--            "Date: " + tourData.tourDate + "<br>" +-->
<!--            "Extra info: " + tourData.extra_info;-->
<!--        tourContainer.appendChild(extraInfo);-->
<!---->
<!--        tourContainer.addEventListener('mouseover', function() {-->
<!--            tourContainer.style.backgroundColor = 'lightgray';-->
<!--            tourContainer.style.height = '220px';-->
<!--            tourLanguage.forEach(function(lang) {-->
<!--                lang.style.fontSize = '24px';-->
<!--                const icon = document.createElement('i');-->
<!--                icon.classList.add('fas', 'fa-globe');-->
<!--                lang.insertBefore(icon, lang.firstChild);-->
<!--            });-->
<!--            extraInfo.style.display = 'block';-->
<!--        });-->
<!---->
<!--        tourContainer.addEventListener('mouseout', function() {-->
<!--            tourContainer.style.backgroundColor = '';-->
<!--            tourContainer.style.height = '';-->
<!--            tourLanguage.forEach(function(lang) {-->
<!--                lang.style.fontSize = '';-->
<!--                lang.removeChild(lang.firstChild);-->
<!--            });-->
<!--            extraInfo.style.display = 'none';-->
<!--        });-->
<!--    });-->
<!--</script>-->


<!--<script>-->
<!--    const tourContainers = document.querySelectorAll('.tourContainer');-->
<!---->
<!--    tourContainers.forEach(function(tourContainer) {-->
<!--        const tourLanguage = tourContainer.querySelectorAll('.tourLanguage');-->
<!--        const tourTime = tourContainer.querySelector('.tourTime');-->
<!---->
<!--        tourTime.style.marginTop = '4px';-->
<!---->
<!--        tourContainer.addEventListener('mouseover', function() {-->
<!--            tourContainer.style.backgroundColor = 'lightgray';-->
<!--            tourContainer.style.height = '220px';-->
<!--            tourLanguage.forEach(function(lang) {-->
<!--                lang.style.fontSize = '24px';-->
<!--                const icon = document.createElement('i');-->
<!--                icon.classList.add('fas', 'fa-globe');-->
<!--                lang.insertBefore(icon, lang.firstChild);-->
<!--            });-->
<!--            const date = tourContainer.dataset.date;-->
<!--            // display the date information as desired-->
<!--        });-->
<!---->
<!--        tourContainer.addEventListener('mouseout', function() {-->
<!--            tourContainer.style.backgroundColor = '';-->
<!--            tourContainer.style.height = '';-->
<!--            tourLanguage.forEach(function(lang) {-->
<!--                lang.style.fontSize = '';-->
<!--                lang.removeChild(lang.firstChild);-->
<!--            });-->
<!--            tourTime.style.fontSize = '';-->
<!--            // remove the displayed date information-->
<!--        });-->
<!--    });-->
<!--</script>-->

<!--<script>--> // kinda working code
<!--    const tourContainers = document.querySelectorAll('.tourContainer');-->
<!---->
<!--    tourContainers.forEach(function(tourContainer) {-->
<!--        const tourLanguage = tourContainer.querySelectorAll('.tourLanguage');-->
<!--        const tourTime = tourContainer.querySelector('.tourTime');-->
<!---->
<!--        tourTime.style.marginTop = '4px';-->
<!---->
<!--        const extraInfo = document.createElement('div');-->
<!--        extraInfo.style.display = 'none';-->
<!--        extraInfo.innerHTML = "Language: English<br>" +-->
<!--            "Duration: 2 hours<br>" +-->
<!--            "Guide: John Smith<br>" +-->
<!--            "Extra info: Lorem ipsum dolor sit amet, consectetur adipiscing elit.";-->
<!--        tourContainer.appendChild(extraInfo);-->
<!---->
<!--        tourContainer.addEventListener('mouseover', function() {-->
<!--            tourContainer.style.backgroundColor = 'lightgray';-->
<!--            tourContainer.style.height = '220px';-->
<!--            tourLanguage.forEach(function(lang) {-->
<!--                lang.style.fontSize = '24px';-->
<!--                const icon = document.createElement('i');-->
<!--                icon.classList.add('fas', 'fa-globe');-->
<!--                lang.insertBefore(icon, lang.firstChild);-->
<!--            });-->
<!--            extraInfo.style.display = 'block';-->
<!--        });-->
<!---->
<!--        tourContainer.addEventListener('mouseout', function() {-->
<!--            tourContainer.style.backgroundColor = '';-->
<!--            tourContainer.style.height = '';-->
<!--            tourLanguage.forEach(function(lang) {-->
<!--                lang.style.fontSize = '';-->
<!--                lang.removeChild(lang.firstChild);-->
<!--            });-->
<!--            extraInfo.style.display = 'none';-->
<!--        });-->
<!--    });-->
<!--</script>-->


<!--<div class="tooltip" style="display:none; position:absolute; z-index:999;"></div>-->

<!--<script>-->
<!--    var tourContainers = document.getElementsByClassName("tourContainer");-->
<!--    var tooltip = document.getElementsByClassName("tooltip")[0];-->
<!---->
<!--    for (var i = 0; i < tourContainers.length; i++) {-->
<!--        tourContainers[i].addEventListener("mouseover", function() {-->
<!--            var tourData = JSON.parse(this.getAttribute("data-tour"));-->
<!--            tooltip.style.display = "block";-->
<!--            tooltip.innerHTML = "Language: " + tourData.language + "<br>" +-->
<!--                "Duration: " + tourData.duration + "<br>" +-->
<!--                "Guide: " + tourData.guide;-->
<!--            // Add any other data you want to include in the tooltip-->
<!--        });-->
<!---->
<!--        tourContainers[i].addEventListener("mouseout", function() {-->
<!--            tooltip.style.display = "none";-->
<!--        });-->
<!--    }-->
<!--</script>-->

<?php
//$tour = array(
//    'name' => 'World Tour',
//    'locations' => array('New York', 'Paris', 'Tokyo'),
//    'dates' => array('2023-06-01', '2023-06-15', '2023-06-30')
//);
//?>


<?php
////$tour = array(
////    'name' => "World Tour",
////    'locations' => array("New York", "Paris", "Tokyo"),
////    'dates' => array("2023-06-01", "2023-06-15", "2023-06-30")
////);
////?>
<!--<button onmouseover="hoverDivv('--><?php //echo htmlspecialchars(json_encode($tour)); ?>//')">
//    Hover me
//</button>
//
//
<script>
    //    function hoverDivv(tour) {
    //        console.log('hoverDivv() function called!');
    //        tour = JSON.parse(tour);
    //        console.log(tour.name);
    //    }
    //</script>

<!---->
<!--<script>-->
<!--    const buttons = document.querySelectorAll('.circleLine');-->
<!--    const tourContainers = document.querySelectorAll('.tourContainer');-->
<!---->
<!--    tourContainers.forEach(function(tourContainer) {-->
<!--        const tourLanguage = tourContainer.querySelectorAll('.tourLanguage');-->
<!--        const tourTime = tourContainer.querySelector('.tourTime');-->
<!---->
<!--        tourTime.style.marginTop = '4px';-->
<!---->
<!--        tourContainer.addEventListener('mouseover', function() {-->
<!--            tourContainer.style.backgroundColor = 'lightgray';-->
<!--            tourContainer.style.height = '220px';-->
<!--            tourLanguage.forEach(function(lang) {-->
<!--                lang.style.fontSize = '24px';-->
<!--                const icon = document.createElement('i');-->
<!--                icon.classList.add('fas', 'fa-globe');-->
<!--                lang.insertBefore(icon, lang.firstChild);-->
<!--            });-->
<!--        });-->
<!---->
<!--        tourContainer.addEventListener('mouseout', function() {-->
<!--            tourContainer.style.backgroundColor = '';-->
<!--            tourContainer.style.height = '';-->
<!--            tourLanguage.forEach(function(lang) {-->
<!--                lang.style.fontSize = '';-->
<!--                lang.removeChild(lang.firstChild);-->
<!--            });-->
<!--            tourTime.style.fontSize = '';-->
<!--        });-->
<!--    });-->
<!--</script>-->

<!--<div class="col-md-3 my-3 mx-auto">-->
<!--    <button class="circleLine lblButton" disabled>--><? //= $date ?><!--</button>-->
<!--    --><?php //foreach ($toursByTime as $time => $tours) { ?>
<!--        <div class="tourContainer position-relative" data-date="--><? //= $date ?><!--">-->
<!--            <div class="d-flex align-items-center justify-content-center h-100">-->
<!--                <span class="align-self-center text-center text-lg tourTime">--><? //= $time ?><!--</span>-->
<!--            </div>-->
<!--            --><?php //foreach ($tours as $tour) { ?>
<!--                <div class="container-fluid d-flex align-items-center justify-content-center tourLanguage">-->
<!--                    --><? //= $tour->getTourLanguage() ?>
<!--                </div>-->
<!--            --><?php //} ?>
<!--        </div>-->
<!--    --><?php //} ?>
<!--</div>-->


<!---->
<!--<script>-->
<!--    function hoverDivv(tour) {-->
<!--        console.log(tour.name);-->
<!--        console.log(tour.locations);-->
<!--        console.log(tour.dates);-->
<!--    }-->
<!--</script>-->

<!--<script>-->
<!--    const buttons = document.querySelectorAll('.circleLine');-->
<!--    const tourContainers = document.querySelectorAll('.tourContainer');-->
<!---->
<!--    tourContainers.forEach(function(tourContainer) {-->
<!--        const tourLanguage = tourContainer.querySelectorAll('.tourLanguage');-->
<!--        const tourTime = tourContainer.querySelector('.tourTime');-->
<!---->
<!--        tourTime.style.marginTop = '4px';-->
<!---->
<!--        tourContainer.addEventListener('mouseover', function() {-->
<!--            tourContainer.style.backgroundColor = 'lightgray';-->
<!--            tourContainer.style.height = '220px';-->
<!--            tourLanguage.forEach(function(lang) {-->
<!--                lang.style.fontSize = '24px';-->
<!--                const icon = document.createElement('i');-->
<!--                icon.classList.add('fas', 'fa-globe');-->
<!--                lang.insertBefore(icon, lang.firstChild);-->
<!--            });-->
<!--            const date = tourContainer.getAttribute('data-date');-->
<!--            tourContainer.insertAdjacentHTML('afterbegin', `<div class="tourDate">${date}</div>`);-->
<!--        });-->
<!---->
<!--        tourContainer.addEventListener('mouseout', function() {-->
<!--            tourContainer.style.backgroundColor = '';-->
<!--            tourContainer.style.height = '';-->
<!--            tourLanguage.forEach(function(lang) {-->
<!--                lang.style.fontSize = '';-->
<!--                lang.removeChild(lang.firstChild);-->
<!--            });-->
<!--            tourTime.style.fontSize = '';-->
<!--            const tourDate = tourContainer.querySelector('.tourDate');-->
<!--            if (tourDate) {-->
<!--                tourDate.parentNode.removeChild(tourDate);-->
<!--            }-->
<!--        });-->
<!--    });-->
<!--</script>-->



