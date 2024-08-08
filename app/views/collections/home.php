<?php $this->layout("layouts/default", ["title" => APPNAME]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.css" rel="stylesheet">
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
  <button type="button" class="btn btn-primary" id="btnRefresh">Refresh images</button>
  <div class="row" id="gallery">

  </div>

  <!-- Modal -->
  <div class="modal fade" id="addToCollection" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Add To Collection</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <?php foreach ($collections as $collection): ?>

            <form class="form-inline ml-1" action="<?= '/mycollections/addToCollection/' . $this->e($collection->id) ?>"
              method="POST">
              <input type="hidden" name="urls" id="urls" value="">
              <button style="font-weight:bold; margin:5px" type="submit" class="btn btn-info w-100"
                name="addToCollection">
                <?= $this->e($collection->name) ?>
              </button>
            </form>

          <?php endforeach ?>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <button type="button" class="btn btn-light w-100" id="seeMore">See more</button>
</div>

<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
  $(async function () {
    const divResult = $('#gallery');
    const btnShowMore = $('#seeMore');
    const btnRefresh = $('#btnRefresh')
    const addToCollectionModal = $('#addToCollection');
    const imageUrlsInput = addToCollectionModal.find('input[name="urls"]');
    divResult.html('');
    // divResult.empty();
    let page = Math.floor(Math.random() * 120) + 1;
    let previousData = localStorage.getItem('previousData');

    const fetchImages = async () => {
      if (previousData) {
        // Nếu có dữ liệu fetch cũ trong localStorage, hiển thị nó trên trang
        const imageList = JSON.parse(previousData);
        imageList.forEach(function (photo) {
          const imagePoster = $('<div class="col-3 my-3"></div>');
          const image = $('<img />');
          image.attr({
            'src': photo.urls.regular,
            'class': 'w-100 h-100',
            'style': 'object-fit: cover; object-position: center;'
          });
          const button = $('<button class="btn btn-light btn-sm image-button" data-bs-toggle="modal" data-bs-target="#addToCollection">Add to collection</button>');
          button.click(function () {
            imageUrlsInput.val(photo.urls.regular);
          });
          imagePoster.append(image);
          imagePoster.append(button);
          divResult.append(imagePoster);
        });
        // Xóa dữ liệu fetch cũ trong localStorage
        //localStorage.removeItem('previousData');
      } else {
        const response = await fetch(
          `https://api.unsplash.com/search/photos/?client_id=B1MEAcq9sTZhPJ3wO0tel73QZPJ6GiXYooyL8sPZ0f4&collections=3330452&query=animals&page=${page}&per_page=16`
        );

        if (response.status === 404) {
          console.log('Không tìm thấy hình ảnh');
        } else {
          const data = await response.json();
          console.log(data);
          const imageList = data.results;
          imageList.forEach(function (photo) {
            const imagePoster = $('<div class="col-3 my-3"></div>');
            const image = $('<img />');
            image.attr({
              'src': photo.urls.regular,
              'class': 'w-100 h-100',
              'style': 'object-fit: cover; object-position: center; border-radius:10px;'
            });
            const button = $('<button class="btn btn-light btn-sm image-button" data-bs-toggle="modal" data-bs-target="#addToCollection">Add to collection</button>');
            button.click(function () {
              imageUrlsInput.val(photo.urls.regular);
            });
            imagePoster.append(image);
            imagePoster.append(button);
            divResult.append(imagePoster);
          });
          // Lưu trữ dữ liệu fetch mới vào localStorage
          localStorage.setItem('previousData', JSON.stringify(imageList));
          page++;
          if (page >= 120) page = 1;
        }
      }
    };

    fetchImages();

    btnShowMore.click(function () {
      fetchImages();
    });

    btnRefresh.click(function () {
      localStorage.removeItem('previousData');
      divResult.html('');
      fetchImages();
    });
  });
</script>

<?php $this->stop() ?>