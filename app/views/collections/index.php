<?php $this->layout("layouts/default", ["title" => APPNAME]) ?>

<?php $this->start("page") ?>
<div class="container">

    <!-- SECTION HEADING -->
    <h2 class="text-center animate__animated  animate__faster animate__zoomIn">Collections</h2>
    <div class="col-md-6 offset-md-3 text-center">
        <p class="animate__animated animate__fast animate__fadeInLeft">View all of your collections here.</p>
    </div>

    <div class="row">
        <div class="col-12">

            <!-- FLASH MESSAGES -->

            <a href="/collections/create" class="btn btn-primary mb-3">
                <i class="fa fa-plus"></i> New Collection</a>

            <!-- Table Starts Here -->
            <table id="collections" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Date Created</th>
                        <th scope="col">Notes</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($collections as $collection): ?>
                        <tr>
                            <td><a style="font-weight:bold" href="<?= '/mycollections/' . $this->e($collection->id) ?>">
                                    <?= $this->e($collection->name) ?> </a></td>
                            <td><?= $this->e(date("d-m-Y", strtotime($collection->created_at))) ?></td>
                            <td><?= $this->e($collection->notes) ?></td>
                            <td class="d-flex justify-content-center">
                                <a href="<?= '/collections/edit/' . $this->e($collection->id) ?>"
                                    class="btn btn-xs btn-warning">
                                    <i alt="Edit" class="fa fa-pencil"></i> Edit</a>

                                <button class="btn btn-xs btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete-confirm-<?= $this->e($collection->id) ?>"
                                    name="delete-collection">
                                    <i alt="Delete" class="fa fa-trash"></i> Delete
                                </button>

                                <div id="delete-confirm-<?= $this->e($collection->id) ?>" class="modal fade" tabindex="-1" data-bs-backdrop="static"
                                    data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="staticBackdropLabel">Confirmation</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">Do you want to delete this collection?</div>
                                            <div class="modal-footer">
                                                <form class="form-inline ml-1"
                                                    action="<?= '/collections/delete/' . $this->e($collection->id) ?>"
                                                    method="POST">
                                                    <button type="submit" data-bs-dismiss="modal" class="btn btn-danger"
                                                        id="delete">Delete</button>
                                                </form>
                                                <button type="button" data-bs-dismiss="modal"
                                                    class="btn btn-default">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <!-- Table Ends Here -->
        </div>
    </div>
</div>

<?php $this->stop() ?>