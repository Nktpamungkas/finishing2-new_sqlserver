<?php
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=laporan-SCHEDULE.xls"); //ganti nama sesuai keperluan
    header("Pragma: no-cache");
    header("Expires: 0");
?>
<table border="1">
    <thead>
        <tr>
            <th colspan="3" align="center">
                <img src="../../indo.jpg" width="40" height="40">
            </th>
            <th colspan="23" align="center" valign="middle">
                <strong>
                    <font size="+1">
                        SCHEDULE FINISHING <?php if(empty($_GET['no_mesin'])){ echo "SEMUA MESIN"; } ?>
                    </font>
                    <br>
                    FW-14-PPC-11/00
                </strong>
            </th>
        </tr>
        <tr>
            <th>NO</th>
            <th>KETERANGAN</th>
            <th>NO URUT</th>
            <th>NO MESIN</th>
            <th>MESIN</th>
            <th>GROUP SHIFT</th>
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
            <th>PROSES</th>
            <th>PERSONIL</th>
            <th>CATATAN</th>
            <th>CREATION DATE TIME</th>
            <th>KETERANGAN</th>
        </tr>
    </thead>
    <tbody>
        <?php
            include('../../koneksi.php');
            ini_set("error_reporting", 0);
            if($_GET['nourut'] == 'without0'){
                $where_nourut  = "AND NOT nourut = '0'";
            }elseif($_GET['nourut'] == 'with0'){
                $where_nourut  = "";
            }else{
                $where_nourut  = "AND nourut = '$_GET[nourut]'";
            }
            
            if ($_GET['no_mesin']) {
                $where_no_mesin  = "AND no_mesin = '$_GET[no_mesin]'";
            } else {
                $where_no_mesin  = "";
            }

            if ($_GET['nama_mesin']) {
                $where_nama_mesin  = "AND nama_mesin = '$_GET[nama_mesin]'";
            } else {
                $where_nama_mesin  = "";
            }
            
            if ($_GET['proses']) {
                $where_proses  = "AND proses = '$_GET[proses]'";
            } else {
                $where_proses  = "";
            }

            if ($_GET['awal']) {
                $where_tgl  = "AND SUBSTR(creationdatetime, 1, 10) BETWEEN '$_GET[awal]' AND '$_GET[akhir]'";
            } else {
                $where_tgl  = "";
            }
            $no = 1;
            $query_schedule = "SELECT * FROM `tbl_schedule_new` WHERE `status` = 'SCHEDULE' $where_nourut $where_tgl $where_nama_mesin $where_proses $where_no_mesin ORDER BY CONCAT(SUBSTR(TRIM(no_mesin), -5,2), SUBSTR(TRIM(no_mesin), -2)) ASC, nourut ASC";
            $q_schedule     = mysqli_query($con, $query_schedule);
        ?>
        <?php while ($row_schedule  = mysqli_fetch_array($q_schedule)) : ?>
            <?php
                $q_cekposisikk      = db2_exec($conn_db2, "SELECT
                                                        p.PRODUCTIONORDERCODE,
                                                        p.STEPNUMBER AS STEPNUMBER,
                                                        CASE
                                                            WHEN TRIM(p.PRODRESERVATIONLINKGROUPCODE) IS NULL OR TRIM(p.PRODRESERVATIONLINKGROUPCODE) = '' THEN TRIM(p.OPERATIONCODE)
                                                            ELSE TRIM(p.PRODRESERVATIONLINKGROUPCODE)
                                                        END AS OPERATIONCODE,
                                                        TRIM(o.OPERATIONGROUPCODE) AS DEPT,
                                                        o.LONGDESCRIPTION,
                                                        CASE
                                                            WHEN p.PROGRESSSTATUS = 0 THEN 'Entered'
                                                            WHEN p.PROGRESSSTATUS = 1 THEN 'Planned'
                                                            WHEN p.PROGRESSSTATUS = 2 THEN 'Progress'
                                                            WHEN p.PROGRESSSTATUS = 3 THEN 'Closed'
                                                        END AS STATUS_OPERATION,
                                                        iptip.MULAI,
                                                        CASE
                                                            WHEN p.PROGRESSSTATUS = 3 THEN COALESCE(iptop.SELESAI, SUBSTRING(p.LASTUPDATEDATETIME, 1, 19) || '(Run Manual Closures)')
                                                            ELSE iptop.SELESAI
                                                        END AS SELESAI,
                                                        p.PRODUCTIONORDERCODE,
                                                        p.PRODUCTIONDEMANDCODE,
                                                        iptip.LONGDESCRIPTION AS OP1,
                                                        iptop.LONGDESCRIPTION AS OP2,
                                                        CASE
                                                            WHEN a.VALUEBOOLEAN = 1 THEN 'Tidak Perlu Gerobak'
                                                            ELSE LISTAGG(DISTINCT FLOOR(idqd.VALUEQUANTITY), ', ')
                                                        END AS GEROBAK 
                                                    FROM 
                                                        PRODUCTIONDEMANDSTEP p 
                                                    LEFT JOIN OPERATION o ON o.CODE = p.OPERATIONCODE 
                                                    LEFT JOIN ADSTORAGE a ON a.UNIQUEID = o.ABSUNIQUEID AND a.FIELDNAME = 'Gerobak'
                                                    LEFT JOIN ITXVIEW_POSISIKK_TGL_IN_PRODORDER iptip ON iptip.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND iptip.DEMANDSTEPSTEPNUMBER = p.STEPNUMBER
                                                    LEFT JOIN ITXVIEW_POSISIKK_TGL_OUT_PRODORDER iptop ON iptop.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND iptop.DEMANDSTEPSTEPNUMBER = p.STEPNUMBER
                                                    LEFT JOIN ITXVIEW_DETAIL_QA_DATA idqd ON idqd.PRODUCTIONDEMANDCODE = p.PRODUCTIONDEMANDCODE AND idqd.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE
                                                                                        -- AND idqd.OPERATIONCODE = COALESCE(p.PRODRESERVATIONLINKGROUPCODE, p.OPERATIONCODE)
                                                                                        AND idqd.OPERATIONCODE = CASE
                                                                                                                    WHEN TRIM(p.PRODRESERVATIONLINKGROUPCODE) IS NULL OR TRIM(p.PRODRESERVATIONLINKGROUPCODE) = '' THEN TRIM(p.OPERATIONCODE)
                                                                                                                    ELSE TRIM(p.PRODRESERVATIONLINKGROUPCODE)
                                                                                                                END
                                                                                        AND (idqd.VALUEINT = p.STEPNUMBER OR idqd.VALUEINT = p.GROUPSTEPNUMBER) 
                                                                                        AND (idqd.CHARACTERISTICCODE = 'GRB1' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB2' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB3' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB4' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB5' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB6' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB7' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB8')
                                                                                        AND NOT (idqd.VALUEQUANTITY = 9 OR idqd.VALUEQUANTITY = 999 OR idqd.VALUEQUANTITY = 1 OR idqd.VALUEQUANTITY = 9999 OR idqd.VALUEQUANTITY = 99999 OR idqd.VALUEQUANTITY = 99 OR idqd.VALUEQUANTITY = 91)
                                                    WHERE
                                                        p.PRODUCTIONORDERCODE  = '$row_schedule[nokk]' AND p.PRODUCTIONDEMANDCODE = '$row_schedule[nodemand]' AND TRIM(o.OPERATIONGROUPCODE) = 'FIN'
                                                        AND CASE
                                                            WHEN TRIM(p.PRODRESERVATIONLINKGROUPCODE) IS NULL OR TRIM(p.PRODRESERVATIONLINKGROUPCODE) = '' THEN TRIM(p.OPERATIONCODE)
                                                            ELSE TRIM(p.PRODRESERVATIONLINKGROUPCODE)
                                                        END = '$row_schedule[operation]'
                                                    GROUP BY
                                                        p.PRODUCTIONORDERCODE,
                                                        p.STEPNUMBER,
                                                        p.OPERATIONCODE,
                                                        p.PRODRESERVATIONLINKGROUPCODE,
                                                        o.OPERATIONGROUPCODE,
                                                        o.LONGDESCRIPTION,
                                                        p.PROGRESSSTATUS,
                                                        iptip.MULAI,
                                                        iptop.SELESAI,
                                                        p.LASTUPDATEDATETIME,
                                                        p.PRODUCTIONORDERCODE,
                                                        p.PRODUCTIONDEMANDCODE,
                                                        iptip.LONGDESCRIPTION,
                                                        iptop.LONGDESCRIPTION,
                                                        a.VALUEBOOLEAN
                                                    ORDER BY p.STEPNUMBER ASC");
                $row_cekposisikk    = db2_fetch_assoc($q_cekposisikk);
            ?>
            <?php
                $cek_proses   = mysqli_query($con, "SELECT COUNT(*) AS jml FROM tbl_produksi WHERE nokk = '$row_schedule[nokk]' AND demandno = '$row_schedule[nodemand]' AND no_mesin = '$row_schedule[no_mesin]' AND nama_mesin = '$row_schedule[operation]'");
                $data_proses  = mysqli_fetch_assoc($cek_proses);
            ?>
            <?php if(empty($data_proses['jml']) AND $_GET['kksudahproses'] == '3') : ?>
                <tr>
                    <td style="white-space: nowrap;"><?= $no++; ?></td>
                    <td style="white-space: nowrap;">
                        <?= $row_cekposisikk['STATUS_OPERATION']; ?><br>
                        <?= $row_cekposisikk['OP1']; ?> - <?= $row_cekposisikk['OP2']; ?><br>
                        <?= $row_cekposisikk['MULAI']; ?> - <?= $row_cekposisikk['SELESAI']; ?>
                    </td>
                    <td style="white-space: nowrap;"><?= $row_schedule['nourut'] ?></td>
                    <td style="white-space: nowrap;"><?= substr(TRIM($row_schedule['no_mesin']), -5, 2).substr(TRIM($row_schedule['no_mesin']), -2); ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['nama_mesin'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['group_shift'] ?></td>
                    <td style="white-space: nowrap;">`<?= $row_schedule['nokk'] ?></td>
                    <td style="white-space: nowrap;">`<a target="_BLANK" href="http://online.indotaichen.com/laporan/ppc_filter_steps.php?demand=<?= $row_schedule['nodemand']; ?>&prod_order=<?= $row_schedule['nokk']; ?>"><?= $row_schedule['nodemand'] ?></a></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['langganan'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['buyer'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['no_order'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['tgl_delivery'] ?></td>
                    <td style="white-space: nowrap;" style="white-space: nowrap;"><?= $row_schedule['jenis_kain'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['lebar'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['gramasi'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['warna'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['no_warna'] ?></td>
                    <td style="white-space: nowrap;">`<?= $row_schedule['lot'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['roll'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['qty_order'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['qty_order_yd'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['operation'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['proses'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['personil'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['catatan'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['creationdatetime'] ?></td>
                    <td  style="white-space: nowrap;">
                        <?php
                            // CEK JIKA SUDAH PROSES MAKA MUNCULIN DI KETERANGAN
                            $cek_hasilproses   = mysqli_query($con, "SELECT * FROM tbl_produksi WHERE nokk = '$row_schedule[nokk]' AND demandno = '$row_schedule[nodemand]' AND no_mesin = '$row_schedule[no_mesin]' AND nama_mesin = '$row_schedule[operation]'");
                            $data_hasilproses  = mysqli_fetch_assoc($cek_hasilproses);
                        ?>
                        <?php if($data_hasilproses){ echo "Sudah Jalan"; } ?>,
                        <?= $data_hasilproses['tgl_buat']; ?>,
                        <?= $data_hasilproses['no_mesin']; ?>,
                        <?= $data_hasilproses['nama_mesin']; ?>-<?= $data_hasilproses['proses']; ?>
                    </td>
                </tr>
            <?php elseif (!empty($data_proses['jml']) AND $_GET['kksudahproses'] == '2') : ?>
                <tr>
                    <td style="white-space: nowrap;"><?= $no++; ?></td>
                    <td style="white-space: nowrap;">
                        <?= $row_cekposisikk['STATUS_OPERATION']; ?><br>
                        <?= $row_cekposisikk['OP1']; ?> - <?= $row_cekposisikk['OP2']; ?><br>
                        <?= $row_cekposisikk['MULAI']; ?> - <?= $row_cekposisikk['SELESAI']; ?>
                    </td>
                    <td style="white-space: nowrap;"><?= $row_schedule['nourut'] ?></td>
                    <td style="white-space: nowrap;"><?= substr(TRIM($row_schedule['no_mesin']), -5, 2).substr(TRIM($row_schedule['no_mesin']), -2); ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['nama_mesin'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['group_shift'] ?></td>
                    <td style="white-space: nowrap;">`<?= $row_schedule['nokk'] ?></td>
                    <td style="white-space: nowrap;">`<?= $row_schedule['nodemand'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['langganan'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['buyer'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['no_order'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['tgl_delivery'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['jenis_kain'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['lebar'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['gramasi'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['warna'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['no_warna'] ?></td>
                    <td style="white-space: nowrap;">`<?= $row_schedule['lot'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['roll'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['qty_order'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['qty_order_yd'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['operation'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['proses'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['personil'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['catatan'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['creationdatetime'] ?></td>
                    <td style="white-space: nowrap;">
                        <?php
                            // CEK JIKA SUDAH PROSES MAKA MUNCULIN DI KETERANGAN
                            $cek_hasilproses   = mysqli_query($con, "SELECT * FROM tbl_produksi WHERE nokk = '$row_schedule[nokk]' AND demandno = '$row_schedule[nodemand]' AND no_mesin = '$row_schedule[no_mesin]' AND nama_mesin = '$row_schedule[operation]'");
                            $data_hasilproses  = mysqli_fetch_assoc($cek_hasilproses);
                        ?>
                        <?php if($data_hasilproses){ echo "Sudah Jalan"; } ?>,
                        <?= $data_hasilproses['tgl_buat']; ?>,
                        <?= $data_hasilproses['no_mesin']; ?>,
                        <?= $data_hasilproses['nama_mesin']; ?>-<?= $data_hasilproses['proses']; ?>
                    </td>
                </tr>
            <?php elseif ((!empty($data_proses['jml']) OR empty($data_proses['jml'])) AND $_GET['kksudahproses'] == '1') : ?>
                <tr>
                    <td style="white-space: nowrap;"><?= $no++; ?></td>
                    <td style="white-space: nowrap;">
                        <?= $row_cekposisikk['STATUS_OPERATION']; ?><br>
                        <?= $row_cekposisikk['OP1']; ?> - <?= $row_cekposisikk['OP2']; ?><br>
                        <?= $row_cekposisikk['MULAI']; ?> - <?= $row_cekposisikk['SELESAI']; ?>
                    </td>
                    <td style="white-space: nowrap;"><?= $row_schedule['nourut'] ?></td>
                    <td style="white-space: nowrap;"><?= substr(TRIM($row_schedule['no_mesin']), -5, 2).substr(TRIM($row_schedule['no_mesin']), -2); ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['nama_mesin'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['group_shift'] ?></td>
                    <td style="white-space: nowrap;">`<?= $row_schedule['nokk'] ?></td>
                    <td style="white-space: nowrap;">`<?= $row_schedule['nodemand'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['langganan'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['buyer'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['no_order'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['tgl_delivery'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['jenis_kain'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['lebar'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['gramasi'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['warna'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['no_warna'] ?></td>
                    <td style="white-space: nowrap;">`<?= $row_schedule['lot'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['roll'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['qty_order'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['qty_order_yd'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['operation'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['proses'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['personil'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['catatan'] ?></td>
                    <td style="white-space: nowrap;"><?= $row_schedule['creationdatetime'] ?></td>
                    <td style="white-space: nowrap;">
                        <?php
                            // CEK JIKA SUDAH PROSES MAKA MUNCULIN DI KETERANGAN
                            $cek_hasilproses   = mysqli_query($con, "SELECT * FROM tbl_produksi WHERE nokk = '$row_schedule[nokk]' AND demandno = '$row_schedule[nodemand]' AND no_mesin = '$row_schedule[no_mesin]' AND nama_mesin = '$row_schedule[operation]'");
                            $data_hasilproses  = mysqli_fetch_assoc($cek_hasilproses);
                        ?>
                        <?php if($data_hasilproses){ echo "Sudah Jalan"; } ?>,
                        <?= $data_hasilproses['tgl_buat']; ?>,
                        <?= $data_hasilproses['no_mesin']; ?>,
                        <?= $data_hasilproses['nama_mesin']; ?>-<?= $data_hasilproses['proses']; ?>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endwhile; ?>
    </tbody>
</table