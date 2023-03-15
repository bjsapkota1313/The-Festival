<section class="home-section">
    <div class="container pb-3 pt-5">
        <div class="row">
            <div class="col-md-12">
                <h1>Artist Performances</h1>
            </div>
        </div>
    </div>
    <div class="Container">
        <div class="d-flex flex-column flex-md-row justify-content-md-between">
            <div class="float-start"></div>
            <div class="container-fluid float-end text-end">
                <a class="btn btn-primary" href= "/admin/dance/addPerformance" >Add new Performance</a>
            </div>
        </div>

    </div>
    <div class="container-fluid">
        <div class="table-responsive-sm">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Date</th>
                    <th>start Time</th>
                    <th>End Time</th>
                    <th>Venue</th>
                    <th> Artist Name</th>
                    <th>Session</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="tableDataDisplay">
                <?php if (isset($errorMessage['artistPerformances'])) : ?>
                    <div class="alert alert-warning" role="alert">
                        <strong>Error:</strong> <?= $errorMessage['artistPerformances'] ?>
                    </div>
                <?php else: ?>
                <?php foreach ($artistPerformances as $performance) { ?>
                    <tr>
                        <td><?= $performance->getPerformanceId() ?></td>
                        <td><?= $performance->getDate()->format('Y-m-d') ?></td>
                        <td><?= $performance->getDate()->format('H:i') ?></td>
                        <td><?= $performance->getEndDateTime()->format('H:i') ?></td>
                        <td><?= $performance->getVenue()->getLocationName() ?></td>
                        <td><?= $this->formatArtistName($performance->getArtists()) ?></td>
                        <td><?= $performance->getSession()->getSessionName() ?></td>
                        <td>100.00</td>
                        <td>
                            <div class="d-inline-flex">
                                <form>
                                    <button href="/admin/dance/addNewArtistPerformance" class="btn btn-primary"><i
                                                class="fa-solid fa-file-pen"></i></button>
                                    <button href="/admin/manageusers/deleteUser/<?php echo $performance->id; ?>" class="btn btn-danger ms-3"><i
                                                class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>

                        </td>
                    </tr>
                <?php } ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
