<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-2">Barang</h1>
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="/img/<?= $barang['gambar'] ?>" class="card-img" alt="">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?= $barang['nama_barang']  ?></h5>
                                <p class="card-text"><?= $barang['deskripsi']  ?>.</p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>

                                <a href="/barang/edit/<?= $barang['slug']; ?>" class="btn btn-warning">Edit</a>

                                <form action="/barang/<?= $barang['id']; ?>" method="post" class="d-inline">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Delete Barang ini?')">Delete</button>
                                </form>

                                <a href="/barang" class="btn btn-success">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>