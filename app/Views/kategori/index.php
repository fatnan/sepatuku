<?= $this->extend('admin/layouts/template'); ?>

<?= $this->section('title'); ?>
<?= $title; ?>
<?= $this->endSection();?>

<?= $this->section('breadcrumb'); ?>
<?= $title; ?>
<?= $this->endSection();?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
        <div class="row">
            <div class="col-10"></div>
            <div class="col-2">
                <a href="/sepatu/create" class="btn btn-primary mb-3">Tambah Kategori</a>
            </div>
        </div>
            <?php if(session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Logo</th>
                    <th scope="col">Nama Kategori</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($sepatu as $s) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td> <img src="/img/<?= $s['gambar'] ?>" alt="" class="logo-item"> </td>
                            <td><?= $s['nama_sepatu'] ?></td>
                            <td>
                                <a href="/sepatu/<?= $s['slug'] ?>" class="btn btn-success">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>