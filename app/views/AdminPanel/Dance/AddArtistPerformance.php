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
                        <label class="form-label" for="performanceDate">Event Date</label>
                        <input type="date" name="performanceDate" id="performanceDate" class="form-control"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="startTime">Start Time</label>
                        <input type="time" name="startTime" id="startTime" class="form-control" onchange="updateDuration()">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="endTime">End Time</label>
                        <input type="time" name="endTime" id="endTime" class="form-control" onchange="updateDuration()"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="duration">Duration</label>
                        <label style="font-weight: bold" id="duration" class="d-block mb-0">0.00 min</label>
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
                        <select class="form-select" id="performanceSession" name="performanceSession">
                            <?php foreach ($allPerformingSessions as $session) : ?>
                                <option value="<?= $session->getPerformanceSessionId() ?>"><?= $session->getSessionName();
                                if(!empty($session->getSessionDescription())) :echo " (". $session->getSessionDescription() .") " ; endif;?>
                                    </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="VenueSelect">Select Venue</label>
                        <select class="form-select" id="VenueSelect" name="VenueSelect" name="VenueSelect">
                            <?php foreach ($allLocations as $venue) : ?>
                                <option value="<?= $venue->getLocationId() ?>"><?= $venue->getLocationName()?>
                                </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="noOfTicket"> No of Ticket</label>
                        <input type="number" name="noOfTicket" id="noOfTicket" class="form-control"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="noOfTicket">Price</label>
                        <input type="number" name="price" id="price" step="0.01" name="price" placeholder="Price in Euro" class="form-control" required>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <button type="submit" name="AddArtistPerformance" class="btn btn-primary btn-lg w-100">Add Performance</button>
                        </div>
                    </div>
                    <script>
                        function updateDuration() {
                            const startTime = document.getElementById("startTime").value;
                            const endTime = document.getElementById("endTime").value;

                            if (startTime && endTime) {
                                const start = new Date(`2000-01-01T${startTime}:00`);
                                const end = new Date(`2000-01-01T${endTime}:00`);
                                const duration = (end.getTime() - start.getTime()) / (1000 * 60); // convert to minutes
                                document.getElementById("duration").textContent = duration.toFixed(2) + " min";
                            }
                        }
                    </script>
                </form>
            </div>
        </div>
    </div>
</section>