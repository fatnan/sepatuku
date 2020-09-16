<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-3">Tambah Barang</h2>
            
            <form action="/barang/store" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="form-group row">
                    <label for="merk" class="col-sm-2 col-form-label ">Merk</label>
                    <div class="col-sm-10">
                        <select class="custom-select <?= ($validation->hasError('merk')) ? 'is-invalid' : '' ?>" id="merk" name="merk">
                            <option selected value="" >Merk</option>
                            <?php foreach ($merk as $k) : ?>
                                <option value="<?= $k['nama_merk'] ?>" <?= old('merk') == $k['nama_merk'] ? 'selected' : '' ?>><?= ucfirst($k['nama_merk']) ?> </option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('merk') ?>
                        </div>
                    </div>
                </div>

                <!-- <div class="form-group row">
                    <label for="kode_barang" class="col-sm-2 col-form-label">Kode Barang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="kode_barang" disabled>
                    </div>
                </div> -->
                <div class="form-group row">
                    <label for="nama_barang" class="col-sm-2 col-form-label">Nama Barang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('nama_barang')) ? 'is-invalid' : '' ?>" id="nama_barang" name="nama_barang" value="<?= old('nama_barang') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama_barang') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('harga')) ? 'is-invalid' : '' ?>" id="harga" name="harga" value="<?= old('harga')?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('harga') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                        <textarea class="form-control <?= ($validation->hasError('deskripsi')) ? 'is-invalid' : '' ?>" id="deskripsi" name="deskripsi"><?= old('deskripsi')?></textarea>
                        <div class="invalid-feedback">
                            <?= $validation->getError('deskripsi') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="photo" class="col-sm-2 col-form-label">Photo</label>
                    <div class="col-sm-2">
                        <img src="/img/item_default.png" class="img-thumbnail img-preview">
                    </div>
                    <div class="col-sm-8">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input <?= ($validation->hasError('photo')) ? 'is-invalid' : '' ?>" id="photo" name="photo" onchange="previewImg()">
                            <div class="invalid-feedback">
                                <?= $validation->getError('photo') ?>
                            </div>
                            <label class="custom-file-label" for="photo">Pilih Gambar</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>