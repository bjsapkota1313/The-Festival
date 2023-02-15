<?php
require_once __DIR__ . '/Headers.htm';
?>
<title>Edit User</title>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center pt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="card-title text-center mb-4">Edit Details of Selected User</h1>
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-4 text-center">
                                <div class="profile-img-container mb-3">
                                    <img src="<?= $editingUser->getPicture()?>" alt="Profile Picture" class="img-fluid">
                                    <label for="profile" class="btn btn-primary">Change your picture</label>
                                    <input type="file" class="form-control-file d-none" id="profile">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="first-name" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="first-name" value="<?= $editingUser->getFirstName() ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="last-name" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="last-name" value="<?= $editingUser->getLastName() ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" value="<?= $editingUser->getLastName() ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Role</label>
                                            <select class="form-select" id="role" required>
                                                <?php foreach (Roles::getEnumValues() as $value) : ?>
                                                    <?php $label = Roles::getLabel(new Roles($value)); ?>
                                                    <option value="<?= $value ?>" <?php if (strcasecmp(Roles::getLabel($editingUser->getRole()), $value) === 0) {
                                                        echo 'selected';
                                                    } ?>>
                                                        <?= $label ?><?php if (strcasecmp(Roles::getLabel($editingUser->getRole()), $value) === 0) {
                                                            echo ' (Current role in system)';
                                                        } ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control" id="dob" value="<?= $editingUser->getDateOfBirth()->format('Y-m-d') ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="registered-date" class="form-label">Registered Date</label>
                                            <input type="date" class="form-control" id="registered-date" value="<?= $editingUser->getRegistrationDate()->format('Y-m-d') ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-md-6">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary btn-lg" >Save Changes</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-grid gap-2">
                                            <button type="reset" class="btn btn-secondary btn-lg">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>






