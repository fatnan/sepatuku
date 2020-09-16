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
            <a href="/sepatu/create" class="btn btn-primary mb-3">Tambah Sepatu</a>
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
                    <th scope="col">Gambar</th>
                    <th scope="col">Nama Sepatu</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Harga</th>
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
                            <td><?= $s['stock'] ?></td>
                            <td><?= $s['harga'] ?></td>
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