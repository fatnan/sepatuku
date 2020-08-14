<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-2">Sepatu</h1>
            <a href="/sepatu/create" class="btn btn-primary mb-3">Tambah Sepatu</a>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Logo</th>
                    <th scope="col">Nama Sepatu</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($sepatu as $s) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td> <img src="/img/<?= $s['gambar'] ?>" alt="" class="logo"> </td>
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