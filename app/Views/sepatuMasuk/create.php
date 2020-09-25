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
            <form action="/sepatumasuk/store" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="form-group row">
                    <label for="merk" class="col-sm-2 col-form-label ">Merk</label>
                    <div class="col-sm-10">
                        <select class="custom-select <?= ($validation->hasError('merk')) ? 'is-invalid' : '' ?>" id="merk" name="merk">
                            <option selected value="" >Merk</option>
                            <?php foreach ($merk as $k) : ?>
                                <option value="<?= $k['id'] ?>" <?= old('merk') == $k['id'] ? 'selected' : '' ?>><?= ucfirst($k['nama_merk']) ?> </option>
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
                            <?php foreach ($sepatu as $s) : ?>
                                <option value="<?= $s['id'] ?>" <?= old('sepatu') == $s['id'] ? 'selected' : '' ?>><?= ucfirst($s['nama_sepatu']) ?></option>
                            <?php endforeach ?>
                        </select>
                        <input type="hidden" name="sepatu_text" id="sepatu_text" value="<?= old('sepatu_text') ? old('sepatu_text') : '' ?>">
                        <input type="hidden" name="harga_text" id="harga_text" value="<?= old('harga_text') ? old('harga_text') : '' ?>">
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
                        <input type="text" class="form-control <?= ($validation->hasError('size')) ? 'is-invalid' : '' ?>" id="size" name="size" maxlength="2" value="<?= old('size') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('size') ?>
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
                    <label for="stock" class="col-sm-2 col-form-label">Jumlah</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('stock')) ? 'is-invalid' : '' ?>" id="stock" name="stock" maxlength="4" value="<?= old('stock')?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('stock') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="waktu_transaksi" class="col-sm-2 col-form-label">Tanggal Masuk</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control <?= ($validation->hasError('waktu_transaksi')) ? 'is-invalid' : '' ?>" id="waktu_transaksi" name="waktu_transaksi"><?= old('waktu_transaksi')?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('waktu_transaksi') ?>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

<script type="text/javascript">
        $(document).ready(function(){
            let old_merk = "<?php echo old('merk') ? old('merk') : '' ?>";
            let old_sepatu_id = "<?php echo old('sepatu') ? old('sepatu') : '' ?>";
            let old_sepatu_text = "<?php echo old('sepatu_text') ? old('sepatu_text') : '' ?>";
            let old_harga_text = "<?php echo old('harga_text') ? old('harga_text') : '' ?>";
            $('#sepatu').select2({
                placeholder: "--Pilih--"
            });

            $('#sepatu').attr('disabled',true);

            if(old_merk != ''){
                var merk_id = $('#merk').val();
                $('#sepatu').attr('disabled',false);
                getSepatu(merk_id,old_sepatu_id,old_sepatu_text,old_harga_text);
            }
            $('#merk').change(function() {
                if($(this).val()){
                    var merk_id = $('#merk').val();
                    getSepatu(merk_id);
                    $('#sepatu').attr('disabled',false);
                }
            })
            $('#sepatu').change(function() {
                if($(this).val()){
                    let sepatu= $('#sepatu').select2('data');
                    $('#sepatu_text').val(sepatu[0].text);
                    $('#harga_text').val(sepatu[0].harga);
                }
            })
            function getSepatu(id,old_id, old_text,old_harga) {
                route ="<?php echo base_url('sepatukeluar/combosepatu') ?>";
                $("#sepatu").select2({
                    placeholder: "--Pilih--",
                    ajax: {
                        url: route,
                        dataType: 'json',
                        type: "POST",
                        data: function (params) {
                            return {
                                search: params.term,
                                merk_id: id
                            };
                        },
                        // results: function (data, page) {
                        //     return { results: data.results };
                        // }
                        processResults: function(data){
                            console.log(data);
                            return {
                                results: data
                            };
                        },
                        cache: true
                    },
                    formatAjaxError:function(a,b,c){return"Not Found .."}
                });

                if((typeof old_id !== 'undefined') && (typeof old_text !== 'undefined') && (typeof old_harga !== 'undefined')){
                    // create the option and append to Select2
                    var option = new Option(old_text, old_id, true, true);
                    $('#sepatu').append(option).trigger('change');

                    const data = {id: old_id, text: old_text,harga:old_harga};
                    // manually trigger the `select2:select` event
                    $('#sepatu').trigger({
                        type: 'select2:select',
                        params: {
                            data: data
                        }
                    });
                }
            }
        });
    </script>

<?= $this->endSection(); ?>