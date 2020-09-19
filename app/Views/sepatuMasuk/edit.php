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
            <form action="/sepatumasuk/update/<?= $sepatu['id_sepatumasuk'] ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="merkLama" value="<?= $sepatu['id_merk']; ?>">
                <input type="hidden" name="sepatuLama" value="<?= $sepatu['id']; ?>">
                <input type="hidden" name="sizeLama" value="<?= $sepatu['size']; ?>">
                <input type="hidden" name="stockLama" value="<?= $sepatu['stock']; ?>">
                
                <div class="form-group row">
                    <label for="merk" class="col-sm-2 col-form-label ">Merk</label>
                    <div class="col-sm-10">
                        <select class="custom-select <?= ($validation->hasError('merk')) ? 'is-invalid' : '' ?>" id="merk" name="merk">
                            <option selected value="" >Merk</option>
                            <?php foreach ($merk as $k) : ?>
                                <option value="<?= $k['id'] ?>" <?= old('merk') ? (old('merk') == $k['id'] ? 'selected' : '') : $sepatu['id_merk'] == $k['id']  ? 'selected' : '' ?>><?= ucfirst($k['nama_merk']) ?> </option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('merk') ?>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sepatu" class="col-sm-2 col-form-label ">Sepatu</label>
                    <div class="col-sm-10">
                        <select class="custom-select <?= ($validation->hasError('sepatu')) ? 'is-invalid' : '' ?>" id="sepatu" name="sepatu">
                            <option selected value="" >Sepatu</option>
                            <?php foreach ($listsepatu as $s) : ?>
                                <option value="<?= $s['id'] ?>" <?= old('sepatu') ? (old('sepatu') == $s['id'] ? 'selected' : '') : $sepatu['id'] == $s['id']  ? 'selected' : '' ?>><?= ucfirst($s['nama_sepatu']) ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('sepatu') ?>
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
                    <label for="size" class="col-sm-2 col-form-label">Size</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('size')) ? 'is-invalid' : '' ?>" id="size" name="size" maxlength="2" value="<?= old('size') ? old('size') : $sepatu['size']; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('size') ?>
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
                    <label for="stock" class="col-sm-2 col-form-label">Jumlah</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('stock')) ? 'is-invalid' : '' ?>" id="stock" name="stock" maxlength="4" value="<?= old('stock') ? old('stock') : $sepatu['stock'];?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('stock') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="waktu_transaksi" class="col-sm-2 col-form-label">Tanggal Masuk</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control <?= ($validation->hasError('waktu_transaksi')) ? 'is-invalid' : '' ?>" id="waktu_transaksi" name="waktu_transaksi" value = <?= old('waktu_transaksi') ? old('waktu_transaksi') : $sepatu['waktu_transaksi'];?> >
                        <div class="invalid-feedback">
                            <?= $validation->getError('waktu_transaksi') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Ubah Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();
 if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 

today = yyyy+'-'+mm+'-'+dd;
document.getElementById("waktu_transaksi").setAttribute("max", today);
</script>

<?= $this->endSection(); ?>