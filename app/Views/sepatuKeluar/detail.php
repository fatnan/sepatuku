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
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="/img/<?= $sepatu['gambar'] ?>" class="card-img" alt="">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $sepatu['nama_sepatu']  ?></h5>
                            <p class="card-text">Size : <?= $sepatu['size']  ?></p>
                            <p class="card-text">Batch : <?= $sepatu['batch']  ?></p>
                            <p class="card-text">Total Harga : <?= $sepatu['total_harga']  ?></p>
                            <p class="card-text">Jumlah : <?= $sepatu['stock']  ?></p>
                            <p class="card-text">Tanggal Keluar : <?= date('d M Y',strtotime($sepatu['waktu_transaksi']))  ?></p>
                            <p class="card-text">Keterangan : <?= $sepatu['keterangan']  ?></p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>

                            <a href="/sepatukeluar/edit/<?= $sepatu['id_sepatukeluar']; ?>" class="btn btn-warning">Edit</a>

                            <form action="/sepatukeluar/<?= $sepatu['id_sepatukeluar']; ?>" method="post" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Delete Sepatu ini?')">Delete</button>
                            </form>

                            <a href="/sepatu" class="btn btn-success">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>