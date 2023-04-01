<section class="home-section">
    <div class="container-fluid pb-3 pt-3 ps-5">
        <div class="row ps-3">
            <div class="col-md-12" class="ps-5">
                <h1><?= $title ?></h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-5">
                <div class="mb-3">
                    <label class="form-label" for="performanceDate">performance Date</label>
                    <input type="date" name="performanceDate" id="performanceDate" class="form-control"
                           value="<?= $editingPerformance->getDate()->format('Y-m-d') ?>"/>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="startTime">Start Time</label>
                    <input type="time" name="startTime" id="startTime" class="form-control"
                           value="<?= $editingPerformance->getDate()->format('H:i') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="endTime">End Time</label>
                    <input type="time" name="endTime" id="endTime" class="form-control"
                           value="<?= $editingPerformance->getEndDateTime()->format('H:i') ?>"/>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="duration">Duration</label>
                    <label style="font-weight: bold" id="duration"
                           class="d-block mb-0"><?= $editingPerformance->getDuration() ?></label>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="SelectArtists">Participating artists</label>
                    <?php if (!empty($errorMessage['artists'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $errorMessage['artists'] ?>
                        </div>
                    <?php else: ?>
                        <?php foreach ($allArtists as $artist): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="artists[]"
                                       value="<?= $artist->getArtistId() ?>"
                                    <?php if (in_array($artist, $editingPerformance->getArtists())): ?>
                                       checked
                                <?php endif; ?>
                                <label class="form-check-label" for="<?= $artist->getArtistId() ?>">
                                    <?= $artist->getArtistName() ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="sessionSelect">Select Session</label>
                    <?php if (!empty($errorMessage['sessions'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $errorMessage['sessions'] ?>
                        </div>
                    <?php else: ?>
                    <select class="form-select" id="performanceSession" name="performanceSession">
                        <?php foreach ($allSessions as $session) : ?>
                            <option value="<?= $session->getPerformanceSessionId(); ?>"
                                <?php if ($session == $editingPerformance->getSession()): ?>
                                    selected
                                <?php endif ?> >
                                <?= $session->getSessionName(); ?>
                                <?php if ($session->getSessionDescription()) : ?>
                                    (<?= $session->getSessionDescription(); ?>)
                                <?php endif; ?>
                                <?php if ($session == $editingPerformance->getSession()): ?>
                                    (Current)
                                <?php endif ?>
                            </option>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="VenueSelect">Select Venue</label>
                    <?php if (!empty($errorMessage['venues'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $errorMessage['venues'] ?>
                        </div>
                    <?php else: ?>
                        <select class="form-select" id="VenueSelect" name="Venue">
                            <?php foreach ($allVenues as $venue) : ?>
                                <option value="<?= $venue->getLocationId() ?>"
                                    <?php if ($venue == $editingPerformance->getVenue()): ?> selected <?php endif; ?>>
                                    <?= $venue->getLocationName() ?>  <?php if ($venue == $editingPerformance->getVenue()): ?> (Current Venue) <?php endif; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="noOfTicket"> No of Ticket<span style="font-size: 9px"> 10% will be for All access Pass</span></label>
                    <input type="number" name="noOfTicket" id="noOfTicket" class="form-control"
                           value="<?= $editingPerformance->getTotalTickets() ?>"/>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="noOfTicket">No of Available Ticket For Single Ticket</label>
                    <input type="number" name="noOfAllAccessPass" id="noOfAvailableTickets" class="form-control"
                           value="<?= $editingPerformance->getAvailableTickets() ?>"/>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="noOfTicket">Price <span
                                style="font-size: 9px">Included with 9% VAT</span></label>
                    <input type="number" name="price" id="price" step="0.01" name="price"
                           value="<?= number_format($editingPerformance->getTotalPrice(), 2) ?>"
                           placeholder="Price in Euro" class="form-control" required>
                </div>
                <div class="alert alert-danger" role="alert" id="errors" hidden>
                </div>
                <div class="row justify-content-center">
                    <div class="pb-3">
                        <button type="button"
                                class="btn btn-primary btn-lg w-100">Save Changes
                        </button>
                    </div>
                    <div class="pb-3">
                        <button type="reset" class="btn btn-secondary w-100"
                                onclick="location.href='/admin/dance/performances'">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="/Javascripts/AdminPanel/Dance/EditPerformance.js" type="text/javascript"></script>
