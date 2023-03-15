<section class="home-section">
    <div class="container pb-3 pt-3">
        <div class="row">
            <div class="col-md-12">
                <h1> Add Artist Performance</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-6 col-xl-5">
                <form id="AddPerformance" class="mx-1 mx-md-4" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label" for="eventDate">Event Date</label>
                        <input type="date" name="eventDate" id="eventDate" class="form-control"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="startTime">Start Time</label>
                        <input type="time" name="startTime" id="startTime" class="form-control"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="endTime">End Time</label>
                        <input type="time" name="endTime" id="endTime" class="form-control"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="duration">Duration</label>
                        <label style="font-weight: bold" id="duration" class="d-block mb-0">90.00 min</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="SelectArtists"> select artists Participating In Performance</label>
                        <?php foreach ($allArtists as $artist):  ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="artists[]" value="<?= $artist->getArtistId() ?>" id="<?= $artist->getArtistId() ?>">
                                <label class="form-check-label" for="<?= $artist->getArtistId() ?>">
                                    <?= $artist->getArtistName() ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="sessionSelect">Select Session</label>
                        <select class="form-select" id="sessionSelect" name="session">
                            <?php foreach ($allPerformingSessions as $session) : ?>
                                <option value="<?= $session->getArtistPerformanceSessionId() ?>"><?= $session->getSessionName();
                                if(!empty($session->getSessionDescription())) :echo " (". $session->getSessionDescription() .") " ; endif;?>
                                    </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="VenueSelect">Select Venue</label>
                        <select class="form-select" id="VenueSelect" name="Venue">
                            <?php foreach ($allPerformingSessions as $session) : ?>
                                <option value="<?= $session->getArtistPerformanceSessionId() ?>"><?= $session->getSessionName();
                                    if(!empty($session->getSessionDescription())) :echo " (". $session->getSessionDescription() .") " ; endif;?>
                                </option>
                            <?php endforeach;?>
                        </select>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <button type="submit" name="btnRegister" class="btn btn-primary btn-lg w-100">Add Performance</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
