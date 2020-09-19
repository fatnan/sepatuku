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
        <div class="col-8">
            
            <form action="/kategori/update/<?= $kategori['id'] ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="form-group row">
                    <label for="nama_kategori" class="col-sm-2 col-form-label">Nama Kategori</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('nama_kategori')) ? 'is-invalid' : '' ?>" id="nama_kategori" name="nama_kategori" value="<?= old('nama_kategori') ? old('nama_kategori') : $kategori['nama_kategori'];?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama_kategori') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Edit Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>