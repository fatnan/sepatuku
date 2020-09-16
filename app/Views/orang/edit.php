<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-3">Edit Sepatu</h2>
            
            <form action="/sepatu/update/<?= $sepatu['id'] ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="slug" value="<?= $sepatu['slug']; ?>">
                <input type="hidden" name="photoLama" value="<?= $sepatu['gambar']; ?>">
                <div class="form-group row">
                    <label for="merk" class="col-sm-2 col-form-label ">Merk</label>
                    <div class="col-sm-10">
                        <select class="custom-select <?= ($validation->hasError('merk')) ? 'is-invalid' : '' ?>" id="merk" name="merk">
                            <option selected value="" >Merk</option>
                            <?php $listK = array() ?>
                            <?php foreach ($merk as $k) : ?>
                                <?php array_push($listK,$k['nama_merk']); ?>
                                <option value="<?= $k['nama_merk'] ?>" <?= old('merk') ? (old('merk') == $k['nama_merk'] ? 'selected' : '') : $sepatu['merk'] == $k['nama_merk']  ? 'selected' : '' ?>><?= ucfirst($k['nama_merk']) ?> </option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('merk') ?>
                        </div>
                    </div>
                </div>

                <!-- <div class="form-group row">
                    <label for="kode_sepatu" class="col-sm-2 col-form-label">Kode Sepatu</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="kode_sepatu" disabled>
                    </div>
                </div> -->
                <div class="form-group row">
                    <label for="nama_sepatu" class="col-sm-2 col-form-label">Nama Sepatu</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('nama_sepatu')) ? 'is-invalid' : '' ?>" id="nama_sepatu" name="nama_sepatu" value="<?= old('nama_sepatu') ? old('nama_sepatu') : $sepatu['nama_sepatu']; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama_sepatu') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('harga')) ? 'is-invalid' : '' ?>" id="harga" name="harga" value="<?= old('harga') ? old('harga') : $sepatu['harga'];?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('harga') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                        <textarea class="form-control <?= ($validation->hasError('deskripsi')) ? 'is-invalid' : '' ?>" id="deskripsi" name="deskripsi"><?= old('deskripsi') ? old('deskripsi') : $sepatu['deskripsi'];?></textarea>
                        <div class="invalid-feedback">
                            <?= $validation->getError('deskripsi') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="photo" class="col-sm-2 col-form-label">Photo</label>
                    <div class="col-sm-2">
                        <img src="/img/<?= $sepatu['gambar']; ?>" class="img-thumbnail img-preview">
                    </div>
                    <div class="col-sm-8">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input <?= ($validation->hasError('photo')) ? 'is-invalid' : '' ?>" id="photo" name="photo" onchange="previewImg()">
                            <div class="invalid-feedback">
                                <?= $validation->getError('photo') ?>
                            </div>
                            <label class="custom-file-label" for="photo"><?= $sepatu['gambar']; ?></label>
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