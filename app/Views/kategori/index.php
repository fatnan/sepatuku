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
        <div class="col-6">
            <a href="/kategori/create" class="btn btn-primary mb-3">Tambah Kategori</a>
        </div>
        <div class="col-6">
            <!-- <h1 class="mt-2">Daftar Orang</h1> -->
            <form action="" method="get">
                <div class="input-group mb-3 float-right">
                    <input type="text" class="form-control" placeholder="Masukan keyword pencarian.." name='keyword'>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" name="submit">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <!-- <div class="row">
                <div class="col-10"></div>
                <div class="col-2">
                    <a href="/sepatu/create" class="btn btn-primary mb-3">Tambah Sepatu</a>
                </div>
            </div> -->
            <?php if(session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Kategori</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($kategori as $s) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $s['nama_kategori'] ?></td>
                            <td>
                                <a href="/kategori/<?= $s['id'] ?>" class="btn btn-success">Detail</a>
                                <a href="/kategori/edit/<?= $s['id'] ?>" class="btn btn-success">Edit</a>
                                <form action="/kategori/delete/<?= $s['id']; ?>" method="post" class="d-inline">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Delete Kategori ini?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>