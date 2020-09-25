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
            <form action="/sepatukeluar/store" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="form-group row">
                    <label for="merk" class="col-sm-2 col-form-label ">Merk</label>
                    <div class="col-sm-10">
                        <select class="custom-select <?= ($validation->hasError('merk')) ? 'is-invalid' : '' ?>" id="merk" name="merk" data-live-search="true">
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
                        <select class="custom-select <?= ($validation->hasError('size')) ? 'is-invalid' : '' ?>" id="size" name="size">
                            <option selected value="" >Size</option>
                            <?php foreach ($listsize as $l) : ?>
                                <option value="<?= $l['size'] ?>" <?= old('size') == $l['size'] ? 'selected' : '' ?>><?= $l['size'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('size') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="batch" class="col-sm-2 col-form-label">Batch</label>
                    <div class="col-sm-10">
                        <select class="custom-select <?= ($validation->hasError('batch')) ? 'is-invalid' : '' ?>" id="batch" name="batch">
                            <option selected value="" >Batch</option>
                            <?php foreach ($listbatch as $lb) : ?>
                                <option value="<?= $lb['batch'] ?>" <?= old('batch') == $lb['batch'] ? 'selected' : '' ?>><?= $lb['batch'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('batch') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="stock" class="col-sm-2 col-form-label">Jumlah</label>
                    <div class="col-sm-10">
                        <input type="number" pattern="/^-?\d+\.?\d*$/" class="form-control <?= ($validation->hasError('stock')) ? 'is-invalid' : '' ?>" id="stock" name="stock" maxlength="3" value="<?= old('stock')?>" onchange="calculate(this.value)">
                        <div class="invalid-feedback">
                            <?= $validation->getError('stock') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="diskon" class="col-sm-2 col-form-label">Diskon</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control <?= ($validation->hasError('diskon')) ? 'is-invalid' : '' ?>" id="diskon" name="diskon" maxlength="4" value="<?= old('diskon')?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('diskon') ?>
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
                    <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-10">
                        <textarea class="form-control <?= ($validation->hasError('keterangan')) ? 'is-invalid' : '' ?>" id="keterangan" name="keterangan"><?= old('keterangan')?></textarea>
                        <div class="invalid-feedback">
                            <?= $validation->getError('keterangan') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="waktu_transaksi" class="col-sm-2 col-form-label">Tanggal Keluar</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control <?= ($validation->hasError('waktu_transaksi')) ? 'is-invalid' : '' ?>" id="waktu_transaksi" name="waktu_transaksi" value="<?= old('waktu_transaksi')?>" >
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
<script type="text/javascript">
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


function calculate(val){
    var stock = $('#stock').val();
    // console.log(stock);
}
</script>

<script type="text/javascript">
        $(document).ready(function(){
            let old_merk = "<?php echo old('merk') ? old('merk') : '' ?>";
            let old_sepatu_id = "<?php echo old('sepatu') ? old('sepatu') : '' ?>";
            let old_sepatu_text = "<?php echo old('sepatu_text') ? old('sepatu_text') : '' ?>";
            let old_harga_text = "<?php echo old('harga_text') ? old('harga_text') : '' ?>";
            let old_size = "<?php echo old('size') ? old('size') : '' ?>";
            let old_batch = "<?php echo old('batch') ? old('batch') : '' ?>";
            let old_jumlah = "<?php echo old('stock') ? old('stock') : '' ?>";
            let old_diskon = "<?php echo old('diskon') ? old('diskon') : '' ?>";
            let old_harga = "<?php echo old('harga') ? old('harga') : '' ?>";
            
            $('#sepatu').select2({
                placeholder: "--Pilih--"
            });
            $('#size').select2({
                placeholder: "--Pilih--"
            });
            $('#batch').select2({
                placeholder: "--Pilih--"
            });
            //aaaaaaaaaaaaaaa
            $('#stock').attr('disabled',true);
            $('#diskon').attr('disabled',true);
            $('#harga').attr('disabled',true);
            $('#sepatu').attr('disabled',true);
            $('#size').attr('disabled',true);
            $('#batch').attr('disabled',true);

            if(old_merk != ''){
                var merk_id = $('#merk').val();
                getSepatu(merk_id,old_sepatu_id,old_sepatu_text,old_harga);
                $('#sepatu').attr('disabled',false);
            }

            if(old_sepatu_id != ''){
                getSize(old_sepatu_id,old_size,old_size);
                $('#size').attr('disabled',false);
            }

            if(old_size != ''){
                getSize(old_sepatu_id,old_size,old_size);
                $('#batch').attr('disabled',false);
            }
            
            if(old_batch != ''){
                getBatch(old_sepatu_id,old_size,old_batch,old_batch);
                $('#stock').attr('disabled',false);
            }

            if(old_jumlah != ''){
                $('#diskon').attr('disabled',false);
            }

            if(old_diskon != ''){
                $('#harga').attr('disabled',false);
                $('#harga').attr('readonly',true);
                let harga_sepatu = parseInt($('#harga_text').val());
                let stock = parseInt($('#stock').val());
                let diskon = parseInt($('#diskon').val())/100;
                total_harga =  (harga_sepatu*stock)-(harga_sepatu*stock*diskon);
                $('#harga').val(total_harga);
            }

            $('#merk').change(function() {
                if($(this).val()){
                    var merk_id = $('#merk').val();
                    getSepatu(merk_id);
                    $('#sepatu').attr('disabled',false);
                    // load_data()
                }
            })
            $('#sepatu').change(function() {
                let sepatu= $('#sepatu').select2('data');
                $('#sepatu_text').val(sepatu[0].text);
                $('#harga_text').val(sepatu[0].harga);
                if($(this).val()){
                    var id_sepatu = $('#sepatu').val();
                    $('#size').attr('disabled',false);
                    getSize(id_sepatu);
                }
                
            })
            $('#size').change(function() {
                if($(this).val()){
                    var id_sepatu = $('#sepatu').val();
                    var size = $('#size').val();
                    $('#batch').attr('disabled',false);
                    getBatch(id_sepatu,size);
                }
            })
            $('#batch').change(function() {
                if($(this).val()){
                    $('#stock').attr('disabled',false);
                }
            })
            $( "#stock" ).change(function() {
                if($(this).val()<1){
                    $(this).val(1);
                }
                $('#diskon').attr('disabled',false);
            });
            $('#diskon').keypress(function(event){
                var key = event.keyCode || event.charCode;
                var charcodestring = String.fromCharCode(event.which);
                var txtVal = $(this).val();
                var diskonKey = parseInt(key)-48;
                var maxlength = $(this).attr('maxlength');
                var regex = new RegExp('^[0-9]+$');
                let total_harga = 0;
                // 8 = backspace 46 = Del 13 = Enter 39 = Left 37 = right Tab = 9
                if( key == 8 || key == 46 || key == 13 || key == 37 || key == 39 || key == 9 ){
                    return true;
                }
                // maxlength allready reached
                if(txtVal.length==maxlength){
                    event.preventDefault();
                    return false;
                }
                // pressed key have to be a number
                if( !regex.test(charcodestring) ){
                    event.preventDefault();
                    return false;
                }
                if(parseInt(txtVal+diskonKey)>100){
                    $(this).val(100);
                    return false;
                }
                return true;
            });
            $( "#diskon" ).change(function() {
                $('#harga').attr('disabled',false);
                $('#harga').attr('readonly',true);
                if($(this).val()<0){
                    $(this).val(0);
                }
                if($('#stock').val() && $('#sepatu').val()){
                    // let harga_sepatu = parseInt($('#sepatu option:selected').attr('harga'));
                    let harga_sepatu = parseInt($('#harga_text').val());
                    let stock = parseInt($('#stock').val());
                    let diskon = parseInt($('#diskon').val())/100;
                    total_harga =  (harga_sepatu*stock)-(harga_sepatu*stock*diskon);
                    $('#harga').val(total_harga);
                }
            });

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

            function getSize(id,old_id, old_text) {
                route ="<?php echo base_url('sepatukeluar/combosize') ?>";
                $("#size").select2({
                    placeholder: "--Pilih--",
                    ajax: {
                        url: route,
                        dataType: 'json',
                        type: "POST",
                        data: function (params) {
                            return {
                                search: params.term,
                                id_sepatu: id
                            };
                        },
                        // results: function (data, page) {
                        //     return { results: data.results };
                        // }
                        processResults: function(data){
                            return {
                                results: data
                            };
                        },
                        cache: true
                    },
                    formatAjaxError:function(a,b,c){return"Not Found .."}
                });

                if((typeof old_id !== 'undefined') && (typeof old_text !== 'undefined')){
                    // create the option and append to Select2
                    var option = new Option(old_text, old_id, true, true);
                    $('#size').append(option).trigger('change');

                    const data = {id: old_id, text: old_text};
                    // manually trigger the `select2:select` event
                    $('#size').trigger({
                        type: 'select2:select',
                        params: {
                            data: data
                        }
                    });
                }
            }

            function getBatch(id_sepatu,size, old_id,old_text) {
                route ="<?php echo base_url('sepatukeluar/combobatch') ?>";
                console.log("masuk");
                $("#batch").select2({
                    placeholder: "--Pilih--",
                    ajax: {
                        url: route,
                        dataType: 'json',
                        type: "POST",
                        data: function (params) {
                            return {
                                search: params.term,
                                id_sepatu: id_sepatu,
                                size:size
                            };
                        },
                        // results: function (data, page) {
                        //     return { results: data.results };
                        // }
                        processResults: function(data){
                            return {
                                results: data
                            };
                        },
                        cache: true
                    },
                    formatAjaxError:function(a,b,c){return"Not Found .."}
                });

                if((typeof old_id !== 'undefined') && (typeof old_text !== 'undefined')){
                    // create the option and append to Select2
                    var option = new Option(old_text, old_id, true, true);
                    $('#batch').append(option).trigger('change');

                    const data = {id: old_id, text: old_text};
                    // manually trigger the `select2:select` event
                    $('#batch').trigger({
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