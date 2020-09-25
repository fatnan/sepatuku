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
                            <?php foreach ($sepatu as $s) : ?>
                                <option value="<?= $s['id'] ?>" <?= old('sepatu') == $s['id'] ? 'selected' : '' ?> data-harga="<?= $s['harga'] ?>"><?= ucfirst($s['nama_sepatu']) ?></option>
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
                    <label for="size" class="col-sm-2 col-form-label">Batch</label>
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
            //bbbbbbbbbbb
            // $('#category_item').selectpicker();

            // $('#sub_category_item').selectpicker();

            // load_data('category_data');

            // function load_data(type, category_id = '')
            // {
            //     $.ajax({
            //     url:"load_data.php",
            //     method:"POST",
            //     data:{type:type, category_id:category_id},
            //     dataType:"json",
            //     success:function(data)
            //     {
            //         var html = '';
            //         for(var count = 0; count < data.length; count++)
            //         {
            //         html += '<option value="'+data[count].id+'">'+data[count].name+'</option>';
            //         }
            //         if(type == 'category_data')
            //         {
            //         $('#category_item').html(html);
            //         $('#category_item').selectpicker('refresh');
            //         }
            //         else
            //         {
            //         $('#sub_category_item').html(html);
            //         $('#sub_category_item').selectpicker('refresh');
            //         }
            //     }
            //     })
            // }

            // $(document).on('change', '#category_item', function(){
            //     var category_id = $('#category_item').val();
            //     load_data('sub_category_data', category_id);
            // });
            //aaaaaaaaaaaaaaa
            $('#stock').attr('disabled',true);
            $('#diskon').attr('disabled',true);
            $('#harga').attr('disabled',true);
            $('#sepatu').attr('disabled',true);
            $('#size').attr('disabled',true);
            $('#batch').attr('disabled',true);
            $('#merk').change(function() {
                if($(this).val()){
                    $('#sepatu').attr('disabled',false);
                }
            })
            $('#sepatu').change(function() {
                if($(this).val()){
                    $('#size').attr('disabled',false);
                }
            })
            $('#size').change(function() {
                if($(this).val()){
                    $('#batch').attr('disabled',false);
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
                    let harga_sepatu = parseInt($('#sepatu option:selected').attr('data-harga'));
                    let stock = parseInt($('#stock').val());
                    let diskon = parseInt($('#diskon').val())/100;
                    total_harga =  (harga_sepatu*stock)-(harga_sepatu*stock*diskon);
                    $('#harga').val(total_harga);
                }
            });
            
        });
    </script>

<?= $this->endSection(); ?>