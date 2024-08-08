<?php $this->layout("layouts/default", ["title" => APPNAME]) ?>

<?php $this->start("page_specific_css") ?>
<style>
    .image-button {
        position: absolute;
        bottom: 10px;
        right: 25px;
        z-index: 1;
    }
</style>
<?php $this->stop() ?>

<?php $this->start("page") ?>
<div class="container">

    <!-- SECTION HEADING -->
    <h2 class="text-center animate__animated  animate__faster animate__zoomIn"><?= $this->e($collection->name) ?></h2>
    <div class="col-md-6 offset-md-3 text-center">
        <p class="animate__animated animate__fadeInLeft"><?= $this->e($collection->notes) ?></p>
    </div>

    <div class="row">
        <?php foreach ($images as $image): ?>
            <div class="col-3 my-3">
                <img class="w-100 h-100" style="object-fit: cover; object-position: center; border-radius:10px"
                    src="<?= $this->e($image->urls) ?>">
                <button class="btn btn-danger btn-sm image-button" data-bs-toggle="modal"
                    data-bs-target="#deleteFromCollection<?= $this->e($image->id) ?>">Remove</button>

                <!-- Modal -->
                <div class="modal fade" id="deleteFromCollection<?= $this->e($image->id) ?>" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title" id="staticBackdropLabel">Remove from collection</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Do you want to remove this images from <?= $this->e($collection->name) ?>?
                            </div>
                            <div class="modal-footer">
                                <form class="form-inline ml-1"
                                action="<?= '/mycollections/removeFromCollection/' . $this->e($collection->id) . '/' . $this->e($image->id) ?>"
                                    method="POST">
                                    <button type="submit" data-bs-dismiss="modal" class="btn btn-danger"
                                        id="delete">Delete</button>
                                </form>

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <?php endforeach ?>
    </div>
</div>

<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>

<?php $this->stop() ?>