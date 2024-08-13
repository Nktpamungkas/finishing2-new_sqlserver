<?php
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=laporan-KK-MASUK.xls"); //ganti nama sesuai keperluan
    header("Pragma: no-cache");
    header("Expires: 0");
?>
<table>
    <thead>
        <tr>
            <th>NO KK</th>
            <th>NO DEMAND</th>
            <th>LANGGANAN</th>
            <th>BUYER</th>
            <th>NO ORDER</th>
            <th>TGL DELIVERY</th>
            <th>JENIS KAIN</th>
            <th>LEBAR</th>
            <th>GRAMASI</th>
            <th>WARNA</th>
            <th>NO WARNA</th>
            <th>LOT</th>
            <th>ROLL</th>
            <th>QTY ORDER</th>
            <th>QTY ORDER YARD</th>
            <th>OPERATION</th>
            <th>MESIN</th>
            <th>PROSES</th>
            <th>PERSONIL</th>
            <th>CATATAN</th>
            <th>CREATION DATE TIME</th>
        </tr>
    </thead>
    <tbody>
        <?php
            include('../../koneksi.php');
            if($_GET['nama_mesin']){
                $where_nama_mesin  = "AND nama_mesin = '$_GET[nama_mesin]'";
            }else{
                $where_nama_mesin  = "";
            }
            
            if($_GET['awal']){
                $where_tgl  = "AND creationdatetime BETWEEN '$_GET[awal]' AND '$_GET[akhir]'";
            }else{
                $where_tgl  = "";
            }

            $q_tblmasuk     = mysqli_query($con, "SELECT * FROM tbl_masuk WHERE `status` = 'KK MASUK' $where_tgl $where_nama_mesin");
        ?>
        <?php while ($row_tblmasuk  = mysqli_fetch_array($q_tblmasuk)) : ?>
            <?php
                // CEK, JIKA KARTU KERJA SUDAH DIBIKIN SCHEDULE MAKA TIDAK AKAN MUNCUL DI KK MASUK. 
                $cek_schedule   = mysqli_query($con, "SELECT COUNT(*) AS jml FROM tbl_schedule_new WHERE nokk = '$row_tblmasuk[nokk]' AND nodemand = '$row_tblmasuk[nodemand]'");
                $data_schedule  = mysqli_fetch_assoc($cek_schedule);
            ?>
            <?php if(empty($data_schedule['jml'])) : ?>
            <tr>
                <td>`<?= $row_tblmasuk['nokk'] ?></td>
                <td><a target="_BLANK" href="http://online.indotaichen.com/laporan/ppc_filter_steps.php?demand=<?= $row_tblmasuk['nodemand']; ?>&prod_order=<?= $row_tblmasuk['nokk']; ?>">`<?= $row_tblmasuk['nodemand'] ?></a></td>
                <td><?= $row_tblmasuk['langganan'] ?></td>
                <td><?= $row_tblmasuk['buyer'] ?></td>
                <td><?= $row_tblmasuk['no_order'] ?></td>
                <td><?= $row_tblmasuk['tgl_delivery'] ?></td>
                <td><?= $row_tblmasuk['jenis_kain'] ?></td>
                <td><?= $row_tblmasuk['lebar'] ?></td>
                <td><?= $row_tblmasuk['gramasi'] ?></td>
                <td><?= $row_tblmasuk['warna'] ?></td>
                <td><?= $row_tblmasuk['no_warna'] ?></td>
                <td><?= $row_tblmasuk['lot'] ?></td>
                <td><?= $row_tblmasuk['roll'] ?></td>
                <td><?= $row_tblmasuk['qty_order'] ?></td>
                <td><?= $row_tblmasuk['qty_order_yd'] ?></td>
                <td><?= $row_tblmasuk['operation'] ?></td>
                <td><?= $row_tblmasuk['nama_mesin'] ?></td>
                <td><?= $row_tblmasuk['proses'] ?></td>
                <td><?= $row_tblmasuk['personil'] ?></td>
                <td><?= $row_tblmasuk['catatan'] ?></td>
                <td><?= $row_tblmasuk['creationdatetime'] ?></td>
            </tr>
            <?php endif; ?>
        <?php endwhile; ?>
    </tbody>
</table