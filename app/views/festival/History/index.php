<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="historyMainImage" style="background: url('<?= $this->getImageFullPath($historyEvent->getEventImages()['banner'][0]) ?>')">
    <span class="position-absolute bottom-0 start-0 mb-3 ps-3 d-flex align-items-center"
          style="z-index: 99; padding-left: 20px;">
          <h2 class="text-white fw-bold mb-0 ms-3"> <?= $historyEvent->getEventName() ?></h2>
        </span>
</div>
<h1 class="historyHeader"><?= $historyEvent->getEventName() ?></h1>
<div class="historyContainer">
    <?php if(!empty($historyEvent->getEventParagraphs())):
    ?>
    <div class="historyInformation">
        <?php
        foreach ($historyEvent->getEventParagraphs() as $paragraph) {
            ?>
            <h2><?= $paragraph->getTitle() ?></h2>
            <p><?= nl2br($paragraph->getText()) ?></p><br>
        <?php } ?>
    </div>
    <?php endif; ?>
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
                               value="<?= $allTourLocation->getTourLocation()->getAddress()->getPostCode() ?>">
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
<!--    tourContainers.forEach(function (tourContainer) {-->
<!--        const tourLanguages = Array.from(tourContainer.querySelectorAll('.tourLanguage'))-->
<!--            .map(lang => lang.textContent)-->
<!--            .join('<br>');-->
<!---->
<!--        const tourTime = tourContainer.querySelector('.tourTime');-->
<!--        const tourData = JSON.parse(tourContainer.querySelector('.tourLanguage').dataset.tour);-->
<!--        console.log(typeof tourData)-->
<!--        tourTime.style.marginTop = '4px';-->
<!---->
<!--        const extraInfo = document.createElement('div');-->
<!--        extraInfo.style.display = 'none';-->
<!--        extraInfo.style.position = 'absolute';-->
<!--        extraInfo.style.top = '0';-->
<!--        extraInfo.style.left = '0';-->
<!--        extraInfo.style.right = '0';-->
<!--        extraInfo.style.backgroundColor = 'white';-->
<!--        extraInfo.style.padding = '10px';-->
<!--        extraInfo.style.fontSize = '18px';-->
<!--        extraInfo.style.fontWeight = 'bold';-->
<!--        extraInfo.style.textAlign = 'center';-->
<!--        extraInfo.style.borderRadius = '20%';-->
<!--        extraInfo.style.border = '4px solid rgba(0, 0, 0, 1)';-->
<!--        extraInfo.style.width="220px";-->
<!---->
<!---->
<!---->
<!--        extraInfo.innerHTML =-->
<!--            `${tourData.tourDate} ${getDayOfWeek(tourData.tourDate)}<br>-->
<!--     Duration: ${tourData.duration}<br>-->
<!--     <button class="btn btn-primary btn-sm mt-3">Book Ticket</button>-->
<!--     <br><br>-->
<!--     ${tourLanguages}<br>-->
<!--     ${tourData.historyTourLocations}`;-->
<!---->
<!--        const bookButton = extraInfo.querySelector('.btn');-->
<!--        bookButton.addEventListener('click', function () {-->
<!--            alert(`Booking information for ${tourData.tourDate} ${getDayOfWeek(tourData.tourDate)} ${tourLanguages}: \n\n Name: \n Email: \n Phone: `);-->
<!--        });-->
<!---->
<!--        tourContainer.appendChild(extraInfo);-->
<!---->
<!--        tourContainer.addEventListener('mouseover', function () {-->
<!--            extraInfo.style.display = 'block';-->
<!--        });-->
<!---->
<!--        tourContainer.addEventListener('mouseout', function () {-->
<!--            extraInfo.style.display = 'none';-->
<!--        });-->
<!--    });-->
<!---->
<!--    function getDayOfWeek(dateString) {-->
<!--        const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];-->
<!--        const tourDate = new Date(dateString);-->
<!--        const dayOfWeek = daysOfWeek[tourDate.getDay()];-->
<!--        return dayOfWeek;-->
<!--    }-->
<!--</script>-->

<script> //working code with extra info on hovering container
    const tourContainers = document.querySelectorAll('.tourContainer');

    tourContainers.forEach(function (tourContainer) {
        const tourLanguages = Array.from(tourContainer.querySelectorAll('.tourLanguage'))
            .map(lang => lang.textContent)
            .join('<br>');

        const tourTime = tourContainer.querySelector('.tourTime');
        const tourData = JSON.parse(tourContainer.querySelector('.tourLanguage').dataset.tour);
        console.log(typeof tourData)
        tourTime.style.marginTop = '4px';

        const extraInfo = document.createElement('div');
        extraInfo.style.display = 'none';
        extraInfo.style.position = 'absolute';
        extraInfo.style.top = '0';
        extraInfo.style.left = '0';
        extraInfo.style.right = '0';
        extraInfo.style.backgroundColor = 'white';
        extraInfo.style.padding = '10px';
        extraInfo.style.fontSize = '18px';
        extraInfo.style.fontWeight = 'bold';
        extraInfo.style.textAlign = 'center';
        extraInfo.style.borderRadius = '20%';
        extraInfo.style.border = '4px solid rgba(0, 0, 0, 1)';
        extraInfo.style.width="220px";

        extraInfo.innerHTML =
            `${tourData.tourDate} ${getDayOfWeek(tourData.tourDate)}<br>
     Duration: ${tourData.duration}<br>
     <button class="btn btn-primary btn-sm mt-3">Book Ticket</button>
     <br><br>
     ${tourLanguages}<br>
     ${tourData.historyTourLocations}`;

        const bookButton = extraInfo.querySelector('.btn');
        bookButton.addEventListener('click', function () {
            // Store the booking information in localStorage
            const bookingInfo = {
                tourDate: tourData.tourDate,
                dayOfWeek: getDayOfWeek(tourData.tourDate),
                tourLanguages: tourLanguages,
                tourTime: tourData.time,
            };

            if (bookingInfo) {
                localStorage.setItem('bookingInfo', JSON.stringify(bookingInfo));
                // Navigate to the booking page
                window.location.href = '/festival/history/ticketSelection';
            } else {
                console.error('bookingInfo is null or undefined');
            }
        });


        tourContainer.appendChild(extraInfo);

        tourContainer.addEventListener('mouseover', function () {
            extraInfo.style.display = 'block';
        });

        tourContainer.addEventListener('mouseout', function () {
            extraInfo.style.display = 'none';
        });
    });

    function getDayOfWeek(dateString) {
        const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const tourDate = new Date(dateString);
        const dayOfWeek = daysOfWeek[tourDate.getDay()];
        return dayOfWeek;
    }
</script>







