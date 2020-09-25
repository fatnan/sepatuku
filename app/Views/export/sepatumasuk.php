<?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=sepatumasuk.xls");
?>

<html>
    <body>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Sepatu</th>
                <th scope="col">Waktu Transaksi</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Total Harga</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($data as $s) : ?>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td><?= $s['nama_sepatu'] ?></td>
                        <td> <?= date('d M Y',strtotime($s['waktu_transaksi'])) ?> </td>
                        <td> <?= $s['stock'] ?> </td>
                        <td> <?= $s['total_harga'] ?> </td>
                        <td>
                            <a href="/sepatumasuk/<?= $s['id'] ?>" class="btn btn-success">Detail</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>