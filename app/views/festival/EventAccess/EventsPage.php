<?php function DisplayData($eventList, $day)
{ ?>

  <div id="schedule" class="border m-2">

    <p class="text-center display-5">
      <?= $day->getEventDay() . " " . $day->getFormattedEventDate() ?>
    </p>

    <div class="grid text-center">
      <?php
      foreach ($eventList as $count => $row) {
        ?>

        <?php
        if ($row['AvailableEvent']->getSingleEvent() == 'True') {

          ?>
          <div class="g-col-2 border m-2 p-2 ">
            <?= $row['AvailableEvent']->getEventHour() ?>
          </div>

          <?php
          if ($row['AvailableEvent']->getEventTypeId() == 1) {

            ?>
            <div class="g-col-7 border m-2 p-2">
              <?= $row['AvailableEvent']->getEventDetails() ?>

            </div>
            <div class="g-col-2 border m-2 p-2">
              <?= $row['AvailableEvent']->getDeliveryPossibilities() ?>
            </div>

          <?php } else {
            if ($row['ParticipatingArtist'] != 0) { ?>
              <div class="g-col-8 border m-2 p-2">
                <?= $row['ParticipatingArtist'] ?>

              </div>
            <?php } else { ?>
              <div class="g-col-8 border m-2 p-2">
                <?= $row['AvailableEvent']->getEventDetails() ?>

              </div>

            <?php } ?>

          <?php } ?>


        <?php } else {


          if ($count % 2 != 0) {
            ?>
            <div class="g-col-2 border m-2 p-2 ">
              <?= $row['AvailableEvent']->getEventHour() ?>
            </div>
          <?php

          }

          ?>

          <div class="g-col-4 border">
            <div class="grid text-center">

              <?php
              if ($row['AvailableEvent']->getEventTypeId() == 1) {

                ?>
                <div class="g-col-6  m-2 p-2">
                  <?= $row['AvailableEvent']->getEventDetails() ?>

                </div>
                <div class="g-col-6 border m-2 p-2">
                  <?= $row['AvailableEvent']->getDeliveryPossibilities() ?>

                </div>
              <?php } else {
                if ($row['ParticipatingArtist'] != 0) { ?>



                  <div class="g-col-7 m-2 p-2">
                    <?= $row['ParticipatingArtist'] ?>

                  </div>

                <?php } else { ?>
                  <div class="g-col-7 m-2 p-2">
                    <?= $row['AvailableEvent']->getEventDetails() ?>

                  </div>

                <?php } ?>
              <?php } ?>

            </div>

          </div>
        <?php } ?>

        <p> <button type="button" class="btn btn-light mt-2" id="buyTicket"><img class="w-50" src="../image/addTicket.png"
              alt=""></button></p>

      <?php } ?>
    </div>

  </div>


<?php } ?>


<main>


  <img src="<?php echo $this->getImageFullPath($bodyHead->getImage()); ?>" alt="Cover Image" id="eventPageImg">
  <div class="carousel-caption" id="imgCaption">
    <div class="d-inline p-2 display-2">
      <? echo $bodyHead->getH1() ?>
    </div>
    <div class="d-inline p-2 display-1">
      <? echo $bodyHead->getH2() ?>
    </div>
  </div>


  <div class="px-4 my-5 text-center">

    <p>
      <?= $paragraphs[0]->getText() ?>
    </p>
    <?php ?>
  </div>


  <div id="eventInfoPanel" class="grid text-center m-5" style="row-gap: 0;">
    <?php
    foreach ($paragraphs as $count => $paragraph) {
      if ($count > 0) {
        ?>
        <div id="eventInfoRow" class="g-col-12 border d-flex flex-row"><img class="eventPageImg w-100"
            src="../image/Festival/EventAccess/imgPlaceholder.png" alt="">
          <p id="eventInfo" class="m-4">
            <?= $paragraph->getText() ?>
          </p>
        </div>
      <?php }
    } ?>
  </div>

  <?php DisplayData($availableEventsList1, $firstEventsDay);

  ?>



</main>
</body>

</html>
