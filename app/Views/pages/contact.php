<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Our Contact</h1>
            <?php foreach($alamat as $a): ?>
                <ul>
                    <li> <?= $a['alamat']; ?> </li>
                    <li> <?= $a['kota']; ?> </li>
                    <li> <?= $a['telp']; ?> </li>
                </ul>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>