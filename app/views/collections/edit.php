<?php $this->layout("layouts/default", ["title" => APPNAME]) ?>

<?php $this->start("page") ?>
<div class="container">
    <!-- SECTION HEADING -->
    <h2 class="text-center animate__animated  animate__faster animate__zoomIn">Collections</h2>
    <div class="row">
        <div class="col-md-6 offset-md-3 text-center">
            <p class="animate__animated animate__fast animate__fadeInLeft">Update your collections here.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <form action="<?= '/collections/' . $this->e($collection['id']) ?>" method="POST" class="col-md-6 offset-md-3">

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control<?= isset($errors['name']) ? ' is-invalid' : '' ?>" maxlen="255" id="name" placeholder="Enter Name" value="<?= $this->e($collection['name']) ?>" />

                    <?php if (isset($errors['name'])) : ?>
                        <span class="invalid-feedback">
                            <strong><?= $this->e($errors['name']) ?></strong>
                        </span>
                    <?php endif ?>
                </div>

                <!-- Notes -->
                <div class="form-group">
                    <label for="notes">Notes </label>
                    <textarea name="notes" id="notes" class="form-control<?= isset($errors['notes']) ? ' is-invalid' : '' ?>" placeholder="Enter notes (maximum character limit: 255)"><?= $this->e($collection['notes']) ?></textarea>

                    <?php if (isset($errors['notes'])) : ?>
                        <span class="invalid-feedback">
                            <strong><?= $this->e($errors['notes']) ?></strong>
                        </span>
                    <?php endif ?>
                </div>

                <!-- Submit -->
                <button type="submit" name="submit" id="submit" class="btn btn-primary">Update Collection</button>
            </form>

        </div>
    </div>
</div>
<?php $this->stop() ?>