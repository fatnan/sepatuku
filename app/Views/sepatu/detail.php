<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-2">Sepatu</h1>
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="/img/<?= $sepatu['gambar'] ?>" class="card-img" alt="">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?= $sepatu['nama_sepatu']  ?></h5>
                                <p class="card-text"><?= $sepatu['deskripsi']  ?>.</p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>

                                <a href="" class="btn btn-warning">Edit</a>
                                <a href="" class="btn btn-danger">Delete</a>
                                <a href="/sepatu" class="btn btn-success">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>