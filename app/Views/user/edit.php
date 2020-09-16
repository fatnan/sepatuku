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
            <form action="/user/update/<?= $user->id ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="id_lama" value="<?= $user->id; ?>">
                <input type="hidden" name="avatarLama" value="<?= $user->avatar; ?>">
                <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= old('username') ? old('username') : $user->username; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('username') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= old('name') ? old('name') : $user->name; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('name') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email') ? old('email') : $user->email; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('email') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>" id="password" name="password" value="<?= old('password') ?>">
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
                        <img src="/img/<?= $user->avatar; ?>" class="img-thumbnail img-preview">
                    </div>
                    <div class="col-sm-8">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input <?= ($validation->hasError('avatar')) ? 'is-invalid' : '' ?>" id="avatar" name="avatar" onchange="previewImgAvatar()">
                            <div class="invalid-feedback">
                                <?= $validation->getError('avatar') ?>
                            </div>
                            <label class="custom-file-label" for="avatar"><?= $user->avatar; ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="role" class="col-sm-2 col-form-label ">Role</label>
                    <div class="col-sm-10">
                        <select class="custom-select <?= ($validation->hasError('role')) ? 'is-invalid' : '' ?>" id="role" name="role">
                            <option selected value="" >Role</option>
                            <?php foreach ($role as $r) : ?>
                                <option value="<?= $r['id'] ?>" <?= old('role') ? (old('role') == $r['id'] ? 'selected' : '') : $user->id_role == $r['id']  ? 'selected' : '' ?>><?= ucfirst($r['role']) ?> </option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('role') ?>
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