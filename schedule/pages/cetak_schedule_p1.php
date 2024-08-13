<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="../../styles_cetak.css" rel="stylesheet" type="text/css">
    <title>Cetak Schedule Page 1</title>
    <style>
        .hurufvertical {
            writing-mode: tb-rl;
            -webkit-transform: rotate(-90deg);
            -moz-transform: rotate(-90deg);
            -o-transform: rotate(-90deg);
            -ms-transform: rotate(-90deg);
            transform: rotate(180deg);
            white-space: nowrap;
            float: left;
        }

        input {
            text-align: center;
            border: hidden;
        }

        @media print {
            ::-webkit-input-placeholder {
                /* WebKit browsers */
                color: transparent;
            }

            :-moz-placeholder {
                /* Mozilla Firefox 4 to 18 */
                color: transparent;
            }

            ::-moz-placeholder {
                /* Mozilla Firefox 19+ */
                color: transparent;
            }

            :-ms-input-placeholder {
                /* Internet Explorer 10+ */
                color: transparent;
            }

            .pagebreak {
                page-break-before: always;
            }

            .header {
                display: block
            }

            table thead {
                display: table-header-group;
            }
        }
    </style>
</head>

<body>
    <table width="100%">
        <thead>
            <tr>
                <td>
                    <table width="100%" border="1" class="table-list1">
                        <tr>
                            <td width="9%" align="center"><img src="../../indo.jpg" width="40" height="40" /></td>
                            <td align="center" valign="middle"><strong>
                                    <font size="+1">SCHEDULE FINISHING <?php if(empty($_GET['no_mesin'])){ echo "SEMUA MESIN"; } ?></font><br>FW-14-PPC-11/00
                                </strong></td>
                        </tr>
                    </table>
                    <table width="100%" border="0">
                        <tbody>
                            <tr>
                                <td width="78%">
                                    <?php 
                                        // Set lokasi timezone ke Waktu Indonesia Barat
                                        date_default_timezone_set('Asia/Jakarta');

                                        // Tanggal dalam format Y-m-d H:i:s
                                        $date = date('Y-m-d H:i:s');

                                        // Array nama hari dalam bahasa Indonesia
                                        $hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");

                                        // Array nama bulan dalam bahasa Indonesia
                                        $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

                                        // Pisahkan tanggal, bulan, dan tahun
                                        $timestamp = strtotime($date);
                                        $hari_indonesia = $hari[date('w', $timestamp)];
                                        $bulan_indonesia = $bulan[date('n', $timestamp)];
                                        $tanggal_indonesia = date('d', $timestamp);
                                        $tahun_indonesia = date('Y', $timestamp);

                                        // Format tanggal dalam bahasa Indonesia
                                        $tanggal_lengkap        = $hari_indonesia . ', ' . $tanggal_indonesia . ' ' . $bulan_indonesia . ' ' . $tahun_indonesia;
                                        $tanggal_lengkap_ttd    = $tanggal_indonesia . ' ' . $bulan_indonesia . ' ' . $tahun_indonesia;

                                        // Tampilkan tanggal dengan format Indonesia
                                    ?>
                                    <font size="-1">Hari/Tanggal : <?=  $tanggal_lengkap ?></font><br />
                                </td>
                                <td width="22%" align="right"><!--Jam: <?php echo date('H:i:s', strtotime($jam)); ?>--></td>
                            </tr>
                            <tr>
                                <td>
                                    <?php if($_GET['kksudahproses'] == '1'){ echo "<li style='font-size: 10px;'>Hanya menampilkan data yang <b>belum</b> dan <b>sudah</b> selesai diproses.</li>"; } ?>
                                    <?php if($_GET['kksudahproses'] == '2'){ echo "<li style='font-size: 10px;'>Hanya menampilkan data yang <b>sudah</b> selesai diproses.</li>"; } ?>
                                    <?php if($_GET['kksudahproses'] == '3'){ echo "<li style='font-size: 10px;'>Hanya menampilkan data yang <b>belum</b> selesai diproses.</li>"; } ?>
                                    
                                    <?php if($_GET['nourut']){ echo "<li style='font-size: 10px;'>Hanya menampilkan dengan nomor urut <b>$_GET[nourut]</b>.</li>"; } ?>

                                    <?php if($_GET['no_mesin']){ echo "<li style='font-size: 10px;'>Hanya menampilkan dengan nomor mesin <b>$_GET[no_mesin] - ".substr(TRIM($_GET['no_mesin']), -5, 2).substr(TRIM($_GET['no_mesin']), -2)."</b>.</li>"; } ?>
                                
                                    <?php if($_GET['nama_mesin']){ echo "<li style='font-size: 10px;'>Hanya menampilkan dengan nama mesin <b>$_GET[nama_mesin]</b>.</li>"; } ?>

                                    <?php if($_GET['proses']){ echo "<li style='font-size: 10px;'>Hanya menampilkan dengan proses <b>$_GET[proses]</b>.</li>"; } ?>

                                    <?php if($_GET['awal'] && $_GET['akhir']){ echo "<li style='font-size: 10px;'>Hanya menampilkan dengan range tanggal <b>$_GET[awal]</b> s/d <b>$_GET[akhir]</b>.</li>"; } ?>
                                
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </thead>
        <tr>
            <td>
                <table width="100%" border="1" class="table-list1">
                    <thead>
                        <tr>
                            <td width="3%" rowspan="2" scope="col">
                                <div align="center">No. Urut</div>
                            </td>
                            <td width="3%" rowspan="2" scope="col">
                                <div align="center">Mesin</div>
                            </td>
                            <td width="3%" rowspan="2" scope="col">
                                <div align="center">Shift</div>
                            </td>
                            <td width="18%" rowspan="2" scope="col">
                                <div align="center">Langganan</div>
                            </td>
                            <td width="8%" rowspan="2" scope="col">
                                <div align="center">No. Order</div>
                            </td>
                            <td width="14%" rowspan="2" scope="col">
                                <div align="center">Jenis Kain</div>
                            </td>
                            <td width="8%" rowspan="2" scope="col">
                                <div align="center">Lebar/Grms</div>
                            </td>
                            <td width="8%" rowspan="2" scope="col">
                                <div align="center">Warna</div>
                            </td>
                            <td width="3%" rowspan="2" scope="col">
                                <div align="center">Lot</div>
                            </td>
                            <td width="6%" rowspan="2" scope="col">
                                <div align="center">Tanggal Delivery</div>
                            </td>
                            <td colspan="2" scope="col">
                                <div align="center">Quantity</div>
                            </td>
                            <td width="20%" rowspan="2" scope="col">
                                <div align="center">Keterangan</div>
                            </td>
                        </tr>
                        <tr>
                            <td width="3%">
                                <div align="center">Roll</div>
                            </td>
                            <td width="6%">
                                <div align="center">Kg</div>
                            </td>
                        </tr>
                    </thead>

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

                        $totalQty = 0;
                        $totalRoll = 0;
                    ?>
                    <?php while ($row_schedule  = mysqli_fetch_array($q_schedule)) : ?>
                        <?php
                            $cek_proses   = mysqli_query($con, "SELECT COUNT(*) AS jml FROM tbl_produksi WHERE nokk = '$row_schedule[nokk]' AND demandno = '$row_schedule[nodemand]' AND no_mesin = '$row_schedule[no_mesin]' AND nama_mesin = '$row_schedule[operation]'");
                            $data_proses  = mysqli_fetch_assoc($cek_proses);
                        ?>
                        <?php if(empty($data_proses['jml']) AND $_GET['kksudahproses'] == '3') : ?>
                            <tr>
                                <td align="center" valign="top" style="height: 0.35in;"><?= $row_schedule['nourut']; ?></td>
                                <td align="center" valign="top"><?= $row_schedule['no_mesin']; ?> <br> <?= substr(TRIM($row_schedule['no_mesin']), -5, 2).substr(TRIM($row_schedule['no_mesin']), -2); ?></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['group_shift']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['langganan'] . "/" . $row_schedule['buyer']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['no_order']; ?></span></td>
                                <td align="left" valign="top"><span style="height: 0.35in;"><?= $row_schedule['jenis_kain']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['lebar'] . "X" . $row_schedule['gramasi']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['warna']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['lot']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['tgl_delivery']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['roll']; ?></span></td>
                                <td align="right" valign="top"><span style="height: 0.35in;"><?= $row_schedule['qty_order']; ?></span></td>
                                <td valign="top">
                                    Nokk : <?= $row_schedule['nokk'] ?><br>
                                    No demand : <?= $row_schedule['nodemand'] ?><br>
                                    <?php
                                        // CEK JIKA SUDAH PROSES MAKA MUNCULIN DI KETERANGAN
                                        $cek_hasilproses   = mysqli_query($con, "SELECT * FROM tbl_produksi WHERE nokk = '$row_schedule[nokk]' AND demandno = '$row_schedule[nodemand]' AND no_mesin = '$row_schedule[no_mesin]' AND nama_mesin = '$row_schedule[operation]'");
                                        $data_hasilproses  = mysqli_fetch_assoc($cek_hasilproses);
                                    ?>
                                    <?php if($data_hasilproses){ echo "Sudah Jalan"; } ?><br>
                                    <?= $data_hasilproses['tgl_buat']; ?><br>
                                    <?= $data_hasilproses['no_mesin']; ?><br>
                                    <?= $data_hasilproses['nama_mesin']; ?><br>
                                    <?= $data_hasilproses['proses']; ?><br>
                                </td>
                            </tr>
                            <?php $totalQty += $row_schedule['qty_order']; ?>
                            <?php $totalRoll += $row_schedule['roll']; ?>
                        <?php elseif (!empty($data_proses['jml']) AND $_GET['kksudahproses'] == '2') : ?>
                            <tr>
                                <td align="center" valign="top" style="height: 0.35in;"><?= $row_schedule['nourut']; ?></td>
                                <td align="center" valign="top"><?= $row_schedule['no_mesin']; ?> <br> <?= substr(TRIM($row_schedule['no_mesin']), -5, 2).substr(TRIM($row_schedule['no_mesin']), -2); ?></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['group_shift']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['langganan'] . "/" . $row_schedule['buyer']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['no_order']; ?></span></td>
                                <td align="left" valign="top"><span style="height: 0.35in;"><?= $row_schedule['jenis_kain']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['lebar'] . "X" . $row_schedule['gramasi']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['warna']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['lot']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['tgl_delivery']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['roll']; ?></span></td>
                                <td align="right" valign="top"><span style="height: 0.35in;"><?= $row_schedule['qty_order']; ?></span></td>
                                <td valign="top">
                                    Nokk : <?= $row_schedule['nokk'] ?><br>
                                    No demand : <?= $row_schedule['nodemand'] ?><br>
                                    <?php
                                        // CEK JIKA SUDAH PROSES MAKA MUNCULIN DI KETERANGAN
                                        $cek_hasilproses   = mysqli_query($con, "SELECT * FROM tbl_produksi WHERE nokk = '$row_schedule[nokk]' AND demandno = '$row_schedule[nodemand]' AND no_mesin = '$row_schedule[no_mesin]' AND nama_mesin = '$row_schedule[operation]'");
                                        $data_hasilproses  = mysqli_fetch_assoc($cek_hasilproses);
                                    ?>
                                    <?php if($data_hasilproses){ echo "Sudah Jalan"; } ?><br>
                                    <?= $data_hasilproses['tgl_buat']; ?><br>
                                    <?= $data_hasilproses['no_mesin']; ?><br>
                                    <?= $data_hasilproses['nama_mesin']; ?><br>
                                    <?= $data_hasilproses['proses']; ?><br>
                                </td>
                            </tr>
                            <?php $totalQty += $row_schedule['qty_order']; ?>
                            <?php $totalRoll += $row_schedule['roll']; ?>
                        <?php elseif ((!empty($data_proses['jml']) OR empty($data_proses['jml'])) AND $_GET['kksudahproses'] == '1') : ?>
                            <tr>
                                <td align="center" valign="top" style="height: 0.35in;"><?= $row_schedule['nourut']; ?></td>
                                <td align="center" valign="top"><?= $row_schedule['no_mesin']; ?> <br> <?= substr(TRIM($row_schedule['no_mesin']), -5, 2).substr(TRIM($row_schedule['no_mesin']), -2); ?></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['group_shift']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['langganan'] . "/" . $row_schedule['buyer']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['no_order']; ?></span></td>
                                <td align="left" valign="top"><span style="height: 0.35in;"><?= $row_schedule['jenis_kain']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['lebar'] . "X" . $row_schedule['gramasi']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['warna']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['lot']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['tgl_delivery']; ?></span></td>
                                <td align="center" valign="top"><span style="height: 0.35in;"><?= $row_schedule['roll']; ?></span></td>
                                <td align="right" valign="top"><span style="height: 0.35in;"><?= $row_schedule['qty_order']; ?></span></td>
                                <td valign="top">
                                    Nokk : <?= $row_schedule['nokk'] ?><br>
                                    No demand : <?= $row_schedule['nodemand'] ?><br>
                                    <?php
                                        // CEK JIKA SUDAH PROSES MAKA MUNCULIN DI KETERANGAN
                                        $cek_hasilproses   = mysqli_query($con, "SELECT * FROM tbl_produksi WHERE nokk = '$row_schedule[nokk]' AND demandno = '$row_schedule[nodemand]' AND no_mesin = '$row_schedule[no_mesin]' AND nama_mesin = '$row_schedule[operation]'");
                                        $data_hasilproses  = mysqli_fetch_assoc($cek_hasilproses);
                                    ?>
                                    <?php if($data_hasilproses){ echo "Sudah Jalan"; } ?><br>
                                    <?= $data_hasilproses['tgl_buat']; ?><br>
                                    <?= $data_hasilproses['no_mesin']; ?><br>
                                    <?= $data_hasilproses['nama_mesin']; ?>-<?= $data_hasilproses['proses']; ?><br>
                                </td>
                            </tr>
                            <?php $totalQty += $row_schedule['qty_order']; ?>
                            <?php $totalRoll += $row_schedule['roll']; ?>
                        <?php endif; ?>
                    <?php endwhile; ?>
                        <tr>
                            <td align="center" valign="top" style="height: 0.35in;">&nbsp;</td>
                            <td align="center" valign="top">&nbsp;</td>
                            <td align="center" valign="top">&nbsp;</td>
                            <td align="center" valign="top">&nbsp;</td>
                            <td align="center" valign="top">&nbsp;</td>
                            <td align="center" valign="top">&nbsp;</td>
                            <td align="center" valign="top">&nbsp;</td>
                            <td align="center" valign="top">&nbsp;</td>
                            <td align="center" valign="top">&nbsp;</td>
                            <td align="right" valign="top"><strong>TOTAL</strong></td>
                            <td align="right" valign="top"><strong><span style="height: 0.35in;"><?= $totalRoll; ?></span></strong></td>
                            <td align="right" valign="top"><strong><span style="height: 0.35in;"><?= number_format($totalQty, 2); ?></span></strong></td>
                            <td valign="top">&nbsp;</td>
                        </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" border="1" class="table-list1">
                    <tr>
                        <td width="16%" scope="col">&nbsp;</td>
                        <td width="29%" scope="col">
                            <div align="center">Dibuat Oleh</div>
                        </td>
                        <td width="29%" scope="col">
                            <div align="center">DIperiksa Oleh</div>
                        </td>
                        <td width="26%" scope="col">
                            <div align="center">Diketahui Oleh</div>
                        </td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td align="center">Husni Jr</td>
                        <td align="center">Putri</td>
                        <td align="center">Yayan</td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td align="center">Staff Schedule</td>
                        <td align="center">SPV</td>
                        <td align="center"> Ast. Manager</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td align="center"><?=  $tanggal_lengkap_ttd ?></td>
                        <td align="center"><?=  $tanggal_lengkap_ttd ?></td>
                        <td align="center"><?=  $tanggal_lengkap_ttd ?></td>
                    </tr>
                    <tr>
                        <td valign="top" style="height: 0.5in;">Tanda Tangan</td>
                        <td align="center"><img src="../../ttd/husni.jpg" width="80" height="73" alt="" /></td>
                        <td align="center"><img src="../../ttd/putri.jpg" width="80" height="73" alt="" /></td>
                        <td align="center"><img src="../../ttd/yayan.jpg" width="80" height="73" alt="" /></td>
                    </tr>

                </table>
            </td>
        </tr>

    </table>
    <table width="100%" border="0">
        <tbody>
            <tr>
                <td width="87%">&nbsp;</td>
                <td width="13%">&nbsp;</td>
            </tr>
        </tbody>
    </table>
    <script>
        //alert('cetak');window.print();
    </script>
</body>

</html>