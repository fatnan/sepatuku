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
            <a href="/user/create" class="btn btn-primary mb-3">Tambah User</a>
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
            <?php if(session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 + ($data_perpage * ($current_page-1)); ?>
                    <?php foreach ($user as $u) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $u->name ?></td>
                            
                            <td>
                                <a href="user/<?= $u->id ?>" class="btn btn-success">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= $pager->links('user','user_pagination') ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>