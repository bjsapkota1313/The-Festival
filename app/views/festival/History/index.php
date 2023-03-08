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
                        <form method="GET" >
                            <input type="hidden" name="locationPostCode"value="<?=$allTourLocation->getPostCode()?>">
                            <button class="link" formaction="/festival/history/detail" type="submit" name="location"
                                    value="<?= $allTourLocation->getLocationName() ?>"><?= $allTourLocation->getLocationName() ?></button>
                        </form>
                    </li>
            <?php } ?>
        </ul>
    </div>
</div>
<h1 class="historyHeader">Showing all English tours</h1>

<div class="scheduleContainer">
    <div class="circleLine">
        <span class="tourDate">26 July - Thursday</span>
    </div>
    <div class="circleLine">
        <span class="tourDate">27 July - Friday</span></div>
    <div class="circleLine">
        <span class="tourDate">28 July - Saturday</span></div>
    <div class="circleLine">
        <span class="tourDate">29 July - Sunday</span></div>
</div>
<div class="tourContainerRow">
    <div class="tourContainerColumn">
        <div class="tourContainer">
            <div class="tourTime">10:00</div>
            <div class="tourLanguage">Dutch tour English tour</div>
        </div>
        <div class="tourContainer">
            <div class="tourTime">13:00</div>
            <div class="tourLanguage">Dutch tour English tour</div>
        </div>
        <div class="tourContainer">
            <div class="tourTime">16:00</div>
            <div class="tourLanguage">Dutch tour English tour</div>
        </div>
    </div>
    <div class="tourContainerColumn">
        <div class="tourContainer">
            <div class="tourTime">10:00</div>
            <div class="tourLanguage">Dutch tour English tour</div>
        </div>
        <div class="tourContainer">
            <div class="tourTime">10:00</div>
            <div class="tourLanguage">Dutch tour English tour</div>
        </div>
        <div class="tourContainer">
            <div class="tourTime">10:00</div>
            <div class="tourLanguage">Dutch tour English tour</div>
        </div>
    </div>
    <div class="tourContainerColumn">
        <div class="tourContainer">
            <div class="tourTime">10:00</div>
            <div class="tourLanguage">Dutch tour English tour</div>
        </div>
        <div class="tourContainer">
            <div class="tourTime">10:00</div>
            <div class="tourLanguage">Dutch tour English tour</div>
        </div>
        <div class="tourContainer">
            <div class="tourTime">10:00</div>
            <div class="tourLanguage">Dutch tour English tour</div>
        </div>
    </div>
    <div class="tourContainerColumn">
        <div class="tourContainer">
            <div class="tourTime">10:00</div>
            <div class="tourLanguage">Dutch tour English tour</div>
        </div>
        <div class="tourContainer">
            <div class="tourTime">10:00</div>
            <div class="tourLanguage">Dutch tour English tour</div>
        </div>
        <div class="tourContainer">
            <div class="tourTime">10:00</div>
            <div class="tourLanguage">Dutch tour English tour</div>
        </div>
    </div>
</div>

getAllHistoryTourLocation()
