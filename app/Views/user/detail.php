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
            <h1 class="mt-2">Detail</h1>
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="/img/<?= $user->avatar ?>" class="card-img" alt="">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Name : <?= $user->name  ?></h5>
                                <p class="card-text">E-mail : <?= $user->email  ?></p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                

                                <a href="/user/edit/<?= $user->id; ?>" class="btn btn-warning">Edit</a>

                                <form action="/user/delete/<?= $user->id; ?>" method="post" class="d-inline">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Delete User ini?')">Delete</button>
                                </form>

                                <a href="/user" class="btn btn-success">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>