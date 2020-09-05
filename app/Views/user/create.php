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
            <form action="/user/store" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= old('username') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('username') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= old('name') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('name') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email')?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('email') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>" id="password" name="password" value="<?= old('password')?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('password') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="repeatPassword" class="col-sm-2 col-form-label">Repeat Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control <?= ($validation->hasError('repeatPassword')) ? 'is-invalid' : '' ?>" id="repeatPassword" name="repeatPassword" value="<?= old('repeatPassword')?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('repeatPassword') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="avatar" class="col-sm-2 col-form-label">Avatar</label>
                    <div class="col-sm-2">
                        <img src="/img/avatar_default.jpg" class="img-thumbnail img-preview">
                    </div>
                    <div class="col-sm-8">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input <?= ($validation->hasError('avatar')) ? 'is-invalid' : '' ?>" id="avatar" name="avatar" onchange="previewImgAvatar()">
                            <div class="invalid-feedback">
                                <?= $validation->getError('avatar') ?>
                            </div>
                            <label class="custom-file-label" for="avatar">Pilih Gambar</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Tambah User</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>