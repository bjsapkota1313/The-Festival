<?php function DisplayData($eventList, $day)
{ ?>

  <div id="schedule" class="border m-2 mt-5">

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
          <div class="g-col-11 grid text-center">

            <div class="border m-2 p-2 ">
              <?= $row['AvailableEvent']->getEventHour() ?>
            </div>

            <?php
            if ($row['AvailableEvent']->getEventTypeId() == 1) {

              ?>
              <div class="g-col-9 border m-2 p-2">
                <?= $row['AvailableEvent']->getEventDetails() ?>

              </div>
              <div class="g-col-2 border m-2 p-2">
                <?= $row['AvailableEvent']->getDeliveryPossibilities() ?>
              </div>

            <?php } else {
              if ($row['ParticipatingArtist'] != 0) { ?>
                <div class="g-col-11 border m-2 p-2">
                  <?= $row['ParticipatingArtist'] ?>

                </div>
              <?php } else { ?>
                <div class="g-col-11 border m-2 p-2">
                  <?= $row['AvailableEvent']->getEventDetails() ?>

                </div>

              <?php } ?>

            <?php } ?>


          </div>

        <?php } else { ?>
          <div class="g-col-5 grid text-center">

            <div class="border m-2 p-2">
              <?= $row['AvailableEvent']->getEventHour() ?>
            </div>

            <?php
            if ($row['AvailableEvent']->getEventTypeId() == 1) {

              ?>
              <div class="g-col-11 border m-2 p-2">
                <?= $row['AvailableEvent']->getEventDetails() ?>

              </div>
              <div class="g-col-4 border m-2 p-2">
                <?= $row['AvailableEvent']->getDeliveryPossibilities() ?>

              </div>
            <?php } else {
              if ($row['ParticipatingArtist'] != 0) { ?>

                <div class="g-col-11 border  m-2 p-2">
                  <?= $row['ParticipatingArtist'] ?>

                </div>

              <?php } else { ?>
                <div class="g-col-11 border m-2 p-2">
                  <?= $row['AvailableEvent']->getEventDetails() ?>

                </div>

              <?php } ?>
            <?php } ?>

          </div>
        <?php } ?>
        <div class="g-col-1 m-auto">

          <button type="button" class="btn btn-light m-1 mt-2 w-100" id="buyTicket"><img class="buyTicket w-100"
              src="../image/addTicket.png" alt=""><span id="availableEventId" style="display:none">
              <?php echo $row['AvailableEvent']->getEventId(); ?>
            </span></button>
        </div>


        <div id="ticketData" class="modal" style="display:none">
          <div id="ticket" class="p-2 grid text-center">

            <div id="data" class="g-col-10 my-5 d-flex flex-row">

              <img class="eventPageImg g-col-2 w-25" src="../image/Festival/EventAccess/imgPlaceholder.png" alt="">
              <div class="d-flex flex-column m-4" id="textData">
                <p class="display-5" id="eventType" class="g-col-8 m-4">
                </p>
                <p><span id="day"></span>&nbsp;<span id="dateTime"></span> </p>

                <div class="d-flex flex-row" id="translationOptions" style="display:none">
                  <label for="translationOptionsList" id="chooseTranslationOption">Choose language:</label>
                </div>

                <label for="ticketType" id="chooseTicketType">Select ticket type:</label>

                <select id="ticketTypes" class="form-select">
                  <option value="single">Single</option>
                  <option value="nonSingle">Non-Single</option>
                </select>

                <div class="btn-group" id="ticketOptionsControls">

                  <button type="button" class="btn btn-light " id="addToShoppingBasket"> Add to basket</button>
                  <button type="button" class="btn btn-light " data-dismiss="modal" id="cancelAddingNewTicket">
                    Cancel</button>
                </div>

              </div>
            </div>

          </div>
        </div>
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
        <div id="eventInfoRow" class="g-col-12 border d-flex flex-row"><img class="eventPageImg w-50"
            src="../image/Festival/EventAccess/imgPlaceholder.png" alt="">
          <p id="eventInfo" class="m-4">
            <?= $paragraph->getText() ?>
          </p>
        </div>
      <?php }
    } ?>
  </div>

  <?php DisplayData($availableEventsList1, $firstEventsDay);
  DisplayData($availableEventsList2, $secondEventsDay);
  DisplayData($availableEventsList3, $thirdEventsDay);
  DisplayData($availableEventsList4, $fourthEventsDay);
  ?>

</main>
</body>
<script src="/Javascripts/Festival/EventAccess/EventAccess.js"></script>

</html>
