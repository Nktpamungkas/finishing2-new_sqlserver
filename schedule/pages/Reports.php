<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include('../koneksi.php');
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SCHEDULE FINISHING</title>
    <link rel="stylesheet" type="text/css" href="../css/datatable.css" />
    <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" />
    <script src="../js/jquery.js" type="text/javascript"></script>
    <script src="../js/jquery.dataTables.js" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('#datatables').dataTable({
                "sScrollY": "500px",
                "sScrollX": "100%",
                "bScrollCollapse": false,
                "bPaginate": false,
                "bJQueryUI": true,
                "bSort": false
            });
        })
    </script>
    
    <style>
        .button {
            display: inline-block;
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 20%;
        }

        .modal-content button {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <form id="form1" name="form1" method="POST" action="">
        <table width="650" border="0">
            <tr>
                <td colspan="3">
                    <div align="center"><strong>REPORTS SCHEDULE FINISHING</strong></div><br>
                </td>
            </tr>
            <tr>
                <td><strong>KK sudah Proses</strong></td>
                <td>:</td>
                <td>
                    <select name="kksudahproses" class="form-control select2" required>
                        <option value="" disabled selected>Pilih</option>
                        <option value="1" <?php if($_POST['kksudahproses'] == '1'){ echo "SELECTED"; } ?>>Tampilkan Semua</option>
                        <option value="2" <?php if($_POST['kksudahproses'] == '2'){ echo "SELECTED"; } ?>>Hanya tampilkan data sudah proses</option>
                        <option value="3" <?php if($_POST['kksudahproses'] == '3'){ echo "SELECTED"; } ?>>Hanya tampilkan data yang belum proses</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><strong>Nomor Urut</strong></td>
                <td>:</td>
                <td>
                    <select name="nourut" class="form-control select2" required>
                        <option value="" disabled selected>Pilih</option>
                        <option value="with0" <?php if($_POST['nourut'] == 'with0'){ echo "SELECTED"; } ?>>Semua nomor urut dengan 0</option>
                        <option value="without0" <?php if($_POST['nourut'] == 'without0'){ echo "SELECTED"; } ?>>Semua nomor urut tidak dengan 0</option>
                        <?php
                            $q_nourut    = mysqli_query($con, "SELECT
                                                                    DISTINCT
                                                                    nourut
                                                                FROM
                                                                    `tbl_schedule_new` 
                                                                ORDER BY
                                                                    nourut ASC");
                        ?>
                        <?php while ($row_nourut = mysqli_fetch_array($q_nourut)) : ?>
                            <option value="<?= $row_nourut['nourut']; ?>" <?php if ($row_nourut['nourut'] == $_POST['nourut']) {
                                                                                echo 'SELECTED';
                                                                            } ?>><?= $row_nourut['nourut']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><strong>Nomor Mesin</strong></td>
                <td>:</td>
                <td>
                    <select name="no_mesin" class="form-control select2">
                        <option value="-" disabled selected>Pilih</option>
                        <option value="">Semua Nomor Mesin</option>
                        <?php
                        $q_mesin    = mysqli_query($con, "SELECT
                                                                DISTINCT
                                                                no_mesin,
                                                                SUBSTR(TRIM(no_mesin), -5, 2) AS singaktan_mesin,
                                                                SUBSTR(TRIM(no_mesin), -2) AS nomesin
                                                            FROM
                                                                `tbl_schedule_new` 
                                                            ORDER BY
                                                                SUBSTR( TRIM( no_mesin ), - 5, 2 ) ASC,
	                                                            SUBSTR( TRIM( no_mesin ), - 2 ) ASC");
                        ?>
                        <?php while ($row_mesin = mysqli_fetch_array($q_mesin)) : ?>
                            <option value="<?= $row_mesin['no_mesin']; ?>" <?php if ($row_mesin['no_mesin'] == $_POST['no_mesin']) {
                                                                                echo 'SELECTED';
                                                                            } ?>><?= $row_mesin['no_mesin']; ?> - <?= $row_mesin['singaktan_mesin']; ?><?= $row_mesin['nomesin']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><strong>Nama Mesin</strong></td>
                <td>:</td>
                <td>
                    <select name="nama_mesin" class="form-control select2">
                        <option value="-" disabled selected>Pilih</option>
                        <option value="">Semua Nama Mesin</option>
                        <?php
                        $q_mesin    = mysqli_query($con, "SELECT
                                                                    DISTINCT
                                                                    nama_mesin 
                                                                FROM
                                                                    `tbl_schedule_new`");
                        ?>
                        <?php while ($row_mesin = mysqli_fetch_array($q_mesin)) : ?>
                            <option value="<?= $row_mesin['nama_mesin']; ?>" <?php if ($row_mesin['nama_mesin'] == $_POST['nama_mesin']) {
                                                                                    echo 'SELECTED';
                                                                                } ?>><?= $row_mesin['nama_mesin']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><strong>Proses</strong></td>
                <td>:</td>
                <td>
                    <select name="proses" class="form-control select2">
                        <option value="-" disabled selected>Pilih</option>
                        <option value="">Semua proses</option>
                        <?php
                            $q_proses    = mysqli_query($con, "SELECT
                                                                DISTINCT
                                                                proses 
                                                            FROM
                                                                `tbl_schedule_new`");
                        ?>
                        <?php while ($row_proses = mysqli_fetch_array($q_proses)) : ?>
                            <option value="<?= $row_proses['proses']; ?>" <?php if ($row_proses['proses'] == $_POST['proses']) {
                                                                                    echo 'SELECTED';
                                                                                } ?>><?= $row_proses['proses']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </td>
            </tr>
            <tr valign="middle">
                <td width="127"><strong>CreationDateTime Start</strong></td>
                <td width="3">:</td>
                <td width="280"><input name="awal" type="text" id="awal" value="<?= $_POST['awal'] ?>" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.awal);return false;" size="14" /><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.awal);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal" style="border:none" align="absmiddle" border="0" /></a></td>
            </tr>
            <tr>
                <td><strong>CreationDateTime Finish</strong></td>
                <td>:</td>
                <td width="280"><input name="akhir" type="text" id="akhir" value="<?= $_POST['akhir'] ?>" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.akhir);return false;" size="14" /><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.akhir);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal" style="border:none" align="absmiddle" border="0" /></a></td>
            </tr>
            <tr>
                <td colspan="3">
                    <button type="submit" name="submit" class="art-button">Filter Data</button>
                    <input type="button" name="batal" value="Reset" onclick="window.location.href='index.php?p=Reports'" class="art-button">
                    <input type="button" name="batal" value="Kembali" onclick="window.location.href='index.php?p=LihatData'" class="art-button">
                    <?php if(isset($_POST['submit'])) : ?>
                        <a href="pages/ExportData.php?kksudahproses=<?= urlencode($_POST['kksudahproses']); ?>&nourut=<?= urlencode($_POST['nourut']); ?>&no_mesin=<?= urlencode($_POST['no_mesin']); ?>&nama_mesin=<?= urlencode($_POST['nama_mesin']); ?>&proses=<?= urlencode($_POST['proses']); ?>&awal=<?= urlencode($_POST['awal']); ?>&akhir=<?= urlencode($_POST['akhir']); ?>" class="art-button">Cetak Ke Excel</a>
                        <a href="pages/cetak_schedule_p1.php?kksudahproses=<?= urlencode($_POST['kksudahproses']); ?>&nourut=<?= urlencode($_POST['nourut']); ?>&no_mesin=<?= urlencode($_POST['no_mesin']); ?>&nama_mesin=<?= urlencode($_POST['nama_mesin']); ?>&proses=<?= urlencode($_POST['proses']); ?>&awal=<?= urlencode($_POST['awal']); ?>&akhir=<?= urlencode($_POST['akhir']); ?>" class="art-button" target="_blank">Cetak Ke PDF</a>
                    <?php endif; ?>
                </td>
                <!-- <button type="submit" name="submit" class="art-button">Cetak Ke Excel</button>
                <a href="pages/cetak_schedule_p1.php?no_mesin=<?= $_POST['no_mesin'] ?>&nama_mesin=<?= $_POST['nama_mesin'] ?>&awal=<?= $_POST['awal'] ?>&akhir=<?= $_POST['akhir']; ?>" class="art-button" target="_blank">Cetak Ke PDF</a>
                <input type="button" name="batal" value="Kembali" onclick="window.location.href='index.php?p=LihatData'" class="art-button"> -->
            </tr>
        </table>
    </form>
    <?php if(isset($_POST['submit'])) : ?>
        <table width="100%" border="1" id="datatables" class="display">
            <thead>
                <tr>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">NO</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">NO URUT</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">NO MESIN</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">MESIN</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">GROUP SHIFT</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">NO KK</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">NO DEMAND</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">LANGGANAN</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">BUYER</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">NO ORDER</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">TGL DELIVERY</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">JENIS KAIN</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">LEBAR</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">GRAMASI</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">WARNA</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">NO WARNA</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">LOT</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">ROLL</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">QTY ORDER</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">QTY ORDER YARD</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">OPERATION</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">PROSES</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">PERSONIL</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">CATATAN</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">CREATION DATE TIME</th>
                    <th style="border:1px solid;vertical-align:middle; font-weight: bold;">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include('../../koneksi.php');
                    ini_set("error_reporting", 0);
                    if($_POST['nourut'] == 'without0'){
                        $where_nourut  = "AND NOT nourut = '0'";
                    }elseif($_POST['nourut'] == 'with0'){
                        $where_nourut  = "";
                    }else{
                        $where_nourut  = "AND nourut = '$_POST[nourut]'";
                    }
                    
                    if ($_POST['no_mesin']) {
                        $where_no_mesin  = "AND no_mesin = '$_POST[no_mesin]'";
                    } else {
                        $where_no_mesin  = "";
                    }

                    if ($_POST['nama_mesin']) {
                        $where_nama_mesin  = "AND nama_mesin = '$_POST[nama_mesin]'";
                    } else {
                        $where_nama_mesin  = "";
                    }
                    
                    if ($_POST['proses']) {
                        $where_proses  = "AND proses = '$_POST[proses]'";
                    } else {
                        $where_proses  = "";
                    }

                    if ($_POST['awal']) {
                        $where_tgl  = "AND SUBSTR(creationdatetime, 1, 10) BETWEEN '$_POST[awal]' AND '$_POST[akhir]'";
                    } else {
                        $where_tgl  = "";
                    }
                    $no = 1;
                    $query_schedule = "SELECT * FROM `tbl_schedule_new` WHERE `status` = 'SCHEDULE' $where_nourut $where_tgl $where_nama_mesin $where_proses $where_no_mesin";
                    $q_schedule     = mysqli_query($con, $query_schedule);
                ?>
                <?php while ($row_schedule  = mysqli_fetch_array($q_schedule)) : ?>
                    <?php
                        $cek_proses   = mysqli_query($con, "SELECT COUNT(*) AS jml FROM tbl_produksi WHERE nokk = '$row_schedule[nokk]' AND demandno = '$row_schedule[nodemand]' AND no_mesin = '$row_schedule[no_mesin]' AND nama_mesin = '$row_schedule[operation]'");
                        $data_proses  = mysqli_fetch_assoc($cek_proses);
                    ?>
                    <?php if(empty($data_proses['jml']) AND $_POST['kksudahproses'] == '3') : ?>
                        <tr>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $no++; ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['nourut'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['no_mesin']; ?> <br> <?= substr(TRIM($row_schedule['no_mesin']), -5, 2).substr(TRIM($row_schedule['no_mesin']), -2); ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['nama_mesin'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['group_shift'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['nokk'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['nodemand'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['langganan'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['buyer'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['no_order'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['tgl_delivery'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: left;"><?= $row_schedule['jenis_kain'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['lebar'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['gramasi'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: left;"><?= $row_schedule['warna'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['no_warna'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['lot'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['roll'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['qty_order'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['qty_order_yd'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['operation'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['proses'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['personil'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: left;"><?= $row_schedule['catatan'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['creationdatetime'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: left;">
                                <?php
                                    // CEK JIKA SUDAH PROSES MAKA MUNCULIN DI KETERANGAN
                                    $cek_hasilproses   = mysqli_query($con, "SELECT * FROM tbl_produksi WHERE nokk = '$row_schedule[nokk]' AND demandno = '$row_schedule[nodemand]' AND no_mesin = '$row_schedule[no_mesin]' AND nama_mesin = '$row_schedule[operation]'");
                                    $data_hasilproses  = mysqli_fetch_assoc($cek_hasilproses);
                                ?>
                                <?php if($data_hasilproses){ echo "<span style='color: red;'><b>Sudah Jalan</b></span>"; } ?><br>
                                <?= $data_hasilproses['tgl_buat']; ?><br>
                                <?= $data_hasilproses['no_mesin']; ?><br>
                                <?= $data_hasilproses['nama_mesin']; ?>-<?= $data_hasilproses['proses']; ?><br>
                                <?= $data_hasilproses['acc_staff']; ?>
                            </td>
                        </tr>
                    <?php elseif (!empty($data_proses['jml']) AND $_POST['kksudahproses'] == '2') : ?>
                        <tr>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $no++; ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['nourut'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['no_mesin']; ?> <br> <?= substr(TRIM($row_schedule['no_mesin']), -5, 2).substr(TRIM($row_schedule['no_mesin']), -2); ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['nama_mesin'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['group_shift'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['nokk'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['nodemand'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['langganan'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['buyer'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['no_order'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['tgl_delivery'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: left;"><?= $row_schedule['jenis_kain'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['lebar'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['gramasi'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: left;"><?= $row_schedule['warna'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['no_warna'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['lot'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['roll'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['qty_order'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['qty_order_yd'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['operation'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['proses'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['personil'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: left;"><?= $row_schedule['catatan'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['creationdatetime'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: left;">
                                <?php
                                    // CEK JIKA SUDAH PROSES MAKA MUNCULIN DI KETERANGAN
                                    $cek_hasilproses   = mysqli_query($con, "SELECT * FROM tbl_produksi WHERE nokk = '$row_schedule[nokk]' AND demandno = '$row_schedule[nodemand]' AND no_mesin = '$row_schedule[no_mesin]' AND nama_mesin = '$row_schedule[operation]'");
                                    $data_hasilproses  = mysqli_fetch_assoc($cek_hasilproses);
                                ?>
                                <?php if($data_hasilproses){ echo "<span style='color: red;'><b>Sudah Jalan</b></span>"; } ?><br>
                                <?= $data_hasilproses['tgl_buat']; ?><br>
                                <?= $data_hasilproses['no_mesin']; ?><br>
                                <?= $data_hasilproses['nama_mesin']; ?>-<?= $data_hasilproses['proses']; ?><br>
                                <?= $data_hasilproses['acc_staff']; ?>
                            </td>
                        </tr>
                    <?php elseif ((!empty($data_proses['jml']) OR empty($data_proses['jml'])) AND $_POST['kksudahproses'] == '1') : ?>
                        <tr>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $no++; ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['nourut'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['no_mesin']; ?> <br> <?= substr(TRIM($row_schedule['no_mesin']), -5, 2).substr(TRIM($row_schedule['no_mesin']), -2); ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['nama_mesin'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['group_shift'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['nokk'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['nodemand'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['langganan'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['buyer'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['no_order'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['tgl_delivery'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: left;"><?= $row_schedule['jenis_kain'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['lebar'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['gramasi'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: left;"><?= $row_schedule['warna'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['no_warna'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['lot'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['roll'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['qty_order'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['qty_order_yd'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['operation'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['proses'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['personil'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: left;"><?= $row_schedule['catatan'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['creationdatetime'] ?></td>
                            <td style="border:1px solid;vertical-align:middle; text-align: left;">
                                <?php
                                    // CEK JIKA SUDAH PROSES MAKA MUNCULIN DI KETERANGAN
                                    $cek_hasilproses   = mysqli_query($con, "SELECT * FROM tbl_produksi WHERE nokk = '$row_schedule[nokk]' AND demandno = '$row_schedule[nodemand]' AND no_mesin = '$row_schedule[no_mesin]' AND nama_mesin = '$row_schedule[operation]'");
                                    $data_hasilproses  = mysqli_fetch_assoc($cek_hasilproses);
                                ?>
                                <?php if($data_hasilproses){ echo "<span style='color: red;'><b>Sudah Jalan</b></span>"; } ?><br>
                                <?= $data_hasilproses['tgl_buat']; ?><br>
                                <?= $data_hasilproses['no_mesin']; ?><br>
                                <?= $data_hasilproses['nama_mesin']; ?>-<?= $data_hasilproses['proses']; ?><br>
                                <?= $data_hasilproses['acc_staff']; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>