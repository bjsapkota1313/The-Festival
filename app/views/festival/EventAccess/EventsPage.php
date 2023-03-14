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

    <p> <?= $paragraphs[0]->getText() ?> </p>
    <?php ?>
  </div>


  <div id="eventInfoPanel" class="grid text-center m-5" style="row-gap: 0;">
    <?php
    foreach ($paragraphs as $count => $paragraph) {
      if ($count > 0) {
        ?>
        <div id="eventInfoRow" class="g-col-12  border d-flex flex-row"><img class="eventPageImg w-100"
            src="../image/Festival/EventAccess/imgPlaceholder.png" alt="">
          <p id="eventInfo" class="m-4"><?= $paragraph->getText() ?></p>
        </div>
      <?php }
    } ?>
  </div>

  <p class="text-center display-5">text placeholder</p>
  <div class="container border m-4" id="schedule1">
    <?php
    foreach ($availableEventsList1 as $availableEvent) {
      ?>
      <div class="row">

        <div class="col-2 border m-2">
          <?= $availableEvent->getEventHour() ?>
        </div>
        <div class="col border m-2">
          <?= $availableEvent->getEventName() ?>
        </div>
        <div class="col border m-2">
          <?= $availableEvent->getDeliveryPossibilities() ?>

        </div>
      </div>
    <?php } ?>
  </div>


  <p class="text-center display-5">text placeholder</p>
  <div class="container border m-4" id="schedule2">
    <?php
    foreach ($availableEventsList2 as $availableEvent) {
      ?>
      <div class="row">
        <div class="col-2 border m-2">
          <?= $availableEvent->getEventHour() ?>
        </div>
        <div class="col border m-2">
          <?= $availableEvent->getEventName() ?>
        </div>
        <div class="col border m-2">
          <?= $availableEvent->getDeliveryPossibilities() ?>

        </div>
      </div>
    <?php } ?>

  </div>


  <p class="text-center display-5">text placeholder</p>
  <div class="container border m-4" id="schedule3">
    <?php
    foreach ($availableEventsList3 as $availableEvent) {
      ?>

      <div class="row">

        <div class="col-2 border m-2">
          <?= $availableEvent->getEventHour() ?>
        </div>
        <div class="col border m-2">
          <?= $availableEvent->getEventName() ?>
        </div>
        <div class="col border m-2">
          <?= $availableEvent->getDeliveryPossibilities() ?>

        </div>
      </div>
    <?php } ?>

  </div>



  <p class="text-center display-5">text placeholder</p>
  <div class="container border m-4" id="schedule4">
    <?php
    foreach ($availableEventsList4 as $availableEvent) {
      ?>
      <div class="row">

        <div class="col-2 border m-2">
          <?= $availableEvent->getEventHour() ?>
        </div>
        <div class="col border m-2">
          <?= $availableEvent->getEventName() ?>
        </div>
        <div class="col border m-2">
          <?= $availableEvent->getDeliveryPossibilities() ?>

        </div>
      </div>
    <?php } ?>
  </div>

</main>
</body>

</html>
