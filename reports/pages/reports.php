<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Laporan Produksi Harian Finishing</title>
  <link rel="stylesheet" type="text/css" href="../css/datatable.css" />
  <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" />
  <script src="../js/jquery.js" type="text/javascript"></script>
  <script src="../js/jquery.dataTables.js" type="text/javascript"></script>
  <script>
    function confirmDelete(url) {
      if (confirm("Yakin Hapus data ini?")) {
        window.location.href = url;
      } else {
        false;
      }
    }

    function confirmEdit(url) {
      if (confirm("Yakin Ubah data ini?")) {
        window.location.href = url;
      } else {
        false;
      }
    }
    $(document).ready(function() {
      $('#datatables').dataTable({
        "sScrollY": "250px",
        "sScrollX": "100%",
        "bScrollCollapse": false,
        "bPaginate": false,
        "bJQueryUI": true
      });
    })
  </script>
</head>

<body onload="document.refresh();">
  <?php
  ini_set("error_reporting", 1);
  session_start();
  include('../koneksi.php');
  $jenis_mesin_now = substr($_POST['nama_mesin'], 2,2);
  if (($_POST['jns'] == "Produksi Finishing" or $_GET['jns'] == "Produksi Finishing" or $_POST['jns'] == "Produksi Finishing NOW")) {
  ?>
    <?php
      if ($_POST['awal'] != "") {
        $tglawal = $_POST['awal'];
        $tglakhir = $_POST['akhir'];
		$jamawal = $_POST['jam_awal'];
        $jamakhir = $_POST['jam_akhir'];  
        $jns = $_POST['jns'];
      } else {
        $tglawal = $_GET['tgl1'];
        $tglakhir = $_GET['tgl2'];
        $jns = $_GET['jns'];
      }
      if ($_POST['shift'] != "") {
        $shft = $_POST['shift'];
      } else {
        $shft = $_GET['shift'];
      }
      if ($_POST['nama_mesin'] != "") {
        $mesin1 = $_POST['nama_mesin'];
      } else {
        $mesin1 = $_GET['msn'];
      }
      if ($tglakhir != "" and $tglawal != "") {
        $tgl = " DATE_FORMAT(a.`tgl_update`,'%Y-%m-%d') BETWEEN '$tglawal' AND '$tglakhir' ";
      } else {
        $tgl = " ";
      }
//	  if ($tglakhir != "" and $tglawal != "" and $jamakhir != "" and $jamawal != "") {
//        $tgl = " DATE_FORMAT(a.`tgl_buat`,'%Y-%m-%d %H:%i') BETWEEN '$tglawal $jamawal' AND '$tglakhir $jamakhir' ";
//      } else {
//        $tgl = " ";
//      }
      if ($shft == "ALL") {
        $shift = " ";
      } else {
        $shift = " AND a.`shift`='$shft' ";
      }
      $msn = str_replace("'", "''", $mesin1);
      if ($msn == "") {
        $mesin = " ";
      } else {
        $mesin = " AND a.`no_mesin`='$msn' ";
      }
    ?>
    <input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='?p=home7'" class="art-button" />
    <a href="pages/reports-cetak.php?tglawal=<?php echo $tglawal; ?>&amp;jamawal=<?php echo $jamawal; ?>&amp;tglakhir=<?php echo $tglakhir; ?>&amp;jamakhir=<?php echo $jamakhir; ?>&amp;shift=<?php echo $shft; ?>&amp;mesin=<?php echo $msn; ?>&amp;jnsmesin=<?php echo $_POST['jnsmesin']; ?>" class="art-button" target="_blank">CETAK</a>
    <a href="pages/reports-excel.php?tglawal=<?php echo $tglawal; ?>&amp;jamawal=<?php echo $jamawal; ?>&amp;tglakhir=<?php echo $tglakhir; ?>&amp;jamakhir=<?php echo $jamakhir; ?>&amp;shift=<?php echo $shft; ?>&amp;mesin=<?php echo $msn; ?>&amp;jnsmesin=<?php echo $_POST['jnsmesin']; ?>" class="art-button">Cetak Ke Excel</a>
    <br />
    <strong><br />
    </strong>
    <form id="form1" name="form1" method="post" action="">
      <strong> Periode: <?php echo $tglawal." ".$jamawal; ?> s/d <?php echo $tglakhir." ".$jamakhir; ?></strong>
      <strong>Shift: <?php echo $shft; ?> Jenis Mesin: <?php echo $_POST['jnsmesin']; ?> No Mesin: <?php if ($msn == "") {
                                                                                                      echo "ALL";
                                                                                                    } else {
                                                                                                      echo $msn;
                                                                                                    } ?></strong><br />
      <table width="100%" border="0" id="datatables" class="display">
        <thead>
          <tr>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">AKSI</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">TGL</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">MC<br>OPERATION</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">B/K</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">LANGGANAN</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">NO. ORDER</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">NO. HANGER</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">JENIS KAIN</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">WARNA</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">LOT</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">ROLL</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">QUANTITY (Kg)</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">PANJANG AKTUAL(YARD)</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">PROSES</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">SUHU</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">SPEED</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">VMT</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">OVER FEED</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">BUKA RANTAI</font>
                </strong></div>
            </th>
            <th colspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">LEBAR (INCHI)</font>
                </strong></div>
            </th>
            <th colspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">GRAMASI(G/M2)</font>
                </strong></div>
            </th>
            <th colspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">WAKTU</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">TOTAL WAKTU</font>
                </strong></div>
            </th>
            <th colspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">STOP MESIN</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">TOTAL</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">KODE</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">OPERATOR</font>
              </div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">KETERANGAN</font>
              </div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">NOKK</font>
              </div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">NO DEMAND</font>
              </div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">NO GRBK</font>
              </div>
            </th>
          </tr>
          <tr>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">PERMINTAAN</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">HASIL</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">PERMINTAAN</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">HASIL</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">MULAI</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">SELESAI</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">MULAI STOP</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">MULAI PROSES KEMBALI</font>
                </strong></div>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php
            $sql = mysqli_query($con, "SELECT 
                                            *,a.`id` as `idp`, a.no_mesin AS no_mesin_now
                                          FROM
                                            `tbl_produksi` a
                                            LEFT JOIN `tbl_no_mesin` b ON a.no_mesin=b.no_mesin
                                          WHERE
                                             $tgl $shift $mesin ORDER BY a.`jam_in` ASC");
            $no = 1;
            $c = 0;
            while ($rowd = mysqli_fetch_array($sql)) {
              $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
              // hitung hari dan jam	 
              // $awal  = strtotime($rowd['tgl_stop_l'] . ' ' . $rowd['stop_l']);
              // $akhir = strtotime($rowd['tgl_stop_r'] . ' ' . $rowd['stop_r']);
              // $diff  = ($akhir - $awal);
              // $tmenit = round($diff / (60), 2);
          ?>
            <tr bgcolor="<?php echo $bgcolor; ?>">
              <td style="border:1px solid;vertical-align:middle;">
                <input type="button" name="ubah" id="ubah" value="Ubah" 
                  onClick="confirmEdit('?p=edit-data&id=<?php echo $rowd['idp']; ?>&nama_mesin=<?php echo $_POST['nama_mesin']; ?>');" />
                <input type="button" name="hapus" id="hapus" value="Hapus" onClick="confirmDelete('?p=hapus-report1&id=<?php echo $rowd['idp']; ?>&tgl1=<?php echo $tglawal; ?>&tgl2=<?php echo $tglakhir; ?>&shift=<?php echo $shft; ?>&jns=Produksi Finishing&msn=<?php echo $msn; ?>');" />
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['tgl_update']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['no_mesin_now']; ?> <br> <?php echo $rowd['nama_mesin']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['kondisi_kain']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['langganan']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['no_order']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['no_item']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['jenis_kain']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['warna']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['lot']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['rol']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['qty']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['panjang']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['proses']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2">
                <?php
                  if($rowd['suhu']){
                    echo $rowd['suhu'];
                  }else{
                    $q_QA_DATA = db2_exec($conn_db2, "SELECT
                                                        PRODUCTIONORDERCODE,
                                                        PRODUCTIONDEMANDCODE,
                                                        OPERATIONCODE,
                                                        CHARACTERISTICCODE,
                                                        VALUEQUANTITY 
                                                      FROM
                                                        ITXVIEW_DETAIL_QA_DATA
                                                      WHERE
                                                        PRODUCTIONORDERCODE = '$rowd[nokk]' AND 
                                                        PRODUCTIONDEMANDCODE = '$rowd[demandno]' AND
                                                        OPERATIONCODE = '$rowd[nama_mesin]' AND
                                                        CHARACTERISTICCODE = 'TMP'
                                                      ORDER BY
                                                        LINE ASC");
                    $row_QA_DATA = db2_fetch_assoc($q_QA_DATA);
                    echo round($row_QA_DATA['VALUEQUANTITY'], 2);
                  }
                ?>
                </font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2">
                  <?php
                    if($rowd['speed']){
                      echo $rowd['speed'];
                    }else{
                      $q_QA_DATA = db2_exec($conn_db2, "SELECT
                                                          PRODUCTIONORDERCODE,
                                                          PRODUCTIONDEMANDCODE,
                                                          OPERATIONCODE,
                                                          CHARACTERISTICCODE,
                                                          VALUEQUANTITY 
                                                        FROM
                                                          ITXVIEW_DETAIL_QA_DATA
                                                        WHERE
                                                          PRODUCTIONORDERCODE = '$rowd[nokk]' AND 
                                                          PRODUCTIONDEMANDCODE = '$rowd[demandno]' AND
                                                          OPERATIONCODE = '$rowd[nama_mesin]' AND
                                                          CHARACTERISTICCODE = 'SPEEDFIN'
                                                        ORDER BY
                                                          LINE ASC");
                      $row_QA_DATA = db2_fetch_assoc($q_QA_DATA);
                      echo round($row_QA_DATA['VALUEQUANTITY'], 2);
                    }
                  ?>
                </font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2">
                  <?php
                    if($rowd['vmt']){
                      echo $rowd['vmt'];
                    }else{
                      $q_QA_DATA = db2_exec($conn_db2, "SELECT
                                                          PRODUCTIONORDERCODE,
                                                          PRODUCTIONDEMANDCODE,
                                                          OPERATIONCODE,
                                                          CHARACTERISTICCODE,
                                                          VALUEQUANTITY 
                                                        FROM
                                                          ITXVIEW_DETAIL_QA_DATA
                                                        WHERE
                                                          PRODUCTIONORDERCODE = '$rowd[nokk]' AND 
                                                          PRODUCTIONDEMANDCODE = '$rowd[demandno]' AND
                                                          OPERATIONCODE = '$rowd[nama_mesin]' AND
                                                          CHARACTERISTICCODE = 'VMT'
                                                        ORDER BY
                                                          LINE ASC");
                      $row_QA_DATA = db2_fetch_assoc($q_QA_DATA);
                      echo round($row_QA_DATA['VALUEQUANTITY'], 2);
                    }
                  ?>
                </font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2">
                  <?php
                    if($rowd['overfeed']){
                      echo $rowd['overfeed'];
                    }else{
                      $q_QA_DATA = db2_exec($conn_db2, "SELECT
                                                          PRODUCTIONORDERCODE,
                                                          PRODUCTIONDEMANDCODE,
                                                          OPERATIONCODE,
                                                          CHARACTERISTICCODE,
                                                          VALUEQUANTITY 
                                                        FROM
                                                          ITXVIEW_DETAIL_QA_DATA
                                                        WHERE
                                                          PRODUCTIONORDERCODE = '$rowd[nokk]' AND 
                                                          PRODUCTIONDEMANDCODE = '$rowd[demandno]' AND
                                                          OPERATIONCODE = '$rowd[nama_mesin]' AND
                                                          CHARACTERISTICCODE = 'OVR'
                                                        ORDER BY
                                                          LINE ASC");
                      $row_QA_DATA = db2_fetch_assoc($q_QA_DATA);
                      echo round($row_QA_DATA['VALUEQUANTITY'], 2);
                    }
                  ?>
                </font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2">
                  <?php
                    if($rowd['buka_rantai']){
                      echo $rowd['buka_rantai'];
                    }else{
                      $q_QA_DATA = db2_exec($conn_db2, "SELECT
                                                          PRODUCTIONORDERCODE,
                                                          PRODUCTIONDEMANDCODE,
                                                          OPERATIONCODE,
                                                          CHARACTERISTICCODE,
                                                          VALUEQUANTITY 
                                                        FROM
                                                          ITXVIEW_DETAIL_QA_DATA
                                                        WHERE
                                                          PRODUCTIONORDERCODE = '$rowd[nokk]' AND 
                                                          PRODUCTIONDEMANDCODE = '$rowd[demandno]' AND
                                                          OPERATIONCODE = '$rowd[nama_mesin]' AND
                                                          CHARACTERISTICCODE = 'BK'
                                                        ORDER BY
                                                          LINE ASC");
                      $row_QA_DATA = db2_fetch_assoc($q_QA_DATA);
                      echo round($row_QA_DATA['VALUEQUANTITY'], 2);
                    }
                  ?>
                </font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['lebar']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2">
                    <?php
                      if($rowd['lebar_h']){
                        echo $rowd['lebar_h'];
                      }else{
                        $q_QA_DATA = db2_exec($conn_db2, "SELECT
                                                            PRODUCTIONORDERCODE,
                                                            PRODUCTIONDEMANDCODE,
                                                            OPERATIONCODE,
                                                            CHARACTERISTICCODE,
                                                            VALUEQUANTITY 
                                                          FROM
                                                            ITXVIEW_DETAIL_QA_DATA
                                                          WHERE
                                                            PRODUCTIONORDERCODE = '$rowd[nokk]' AND 
                                                            PRODUCTIONDEMANDCODE = '$rowd[demandno]' AND
                                                            OPERATIONCODE = '$rowd[nama_mesin]' AND
                                                            CHARACTERISTICCODE = 'LEBAR'
                                                          ORDER BY
                                                            LINE ASC");
                        $row_QA_DATA = db2_fetch_assoc($q_QA_DATA);
                        echo round($row_QA_DATA['VALUEQUANTITY'], 2);
                      }
                    ?>
                  </font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['gramasi']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2">
                    <?php
                      if($rowd['gramasi_h']){
                        echo $rowd['gramasi_h'];
                      }else{
                        $q_QA_DATA = db2_exec($conn_db2, "SELECT
                                                            PRODUCTIONORDERCODE,
                                                            PRODUCTIONDEMANDCODE,
                                                            OPERATIONCODE,
                                                            CHARACTERISTICCODE,
                                                            VALUEQUANTITY 
                                                          FROM
                                                            ITXVIEW_DETAIL_QA_DATA
                                                          WHERE
                                                            PRODUCTIONORDERCODE = '$rowd[nokk]' AND 
                                                            PRODUCTIONDEMANDCODE = '$rowd[demandno]' AND
                                                            OPERATIONCODE = '$rowd[nama_mesin]' AND
                                                            CHARACTERISTICCODE = 'GRAMASI'
                                                          ORDER BY
                                                            LINE ASC");
                        $row_QA_DATA = db2_fetch_assoc($q_QA_DATA);
                        echo round($row_QA_DATA['VALUEQUANTITY'], 2);
                      }
                    ?>
                  </font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['jam_in']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['jam_out']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <?php
                    $total_waktu_awal         = date_create($rowd['jam_in']);
                    $total_waktu_akhir        = date_create($rowd['jam_out']);

                    if ($rowd['jam_in'] & $rowd['jam_out']) {
                      $diff_total_waktu              = date_diff($total_waktu_awal, $total_waktu_akhir);

                      echo $diff_total_waktu->h . ' jam, ';
                      echo $diff_total_waktu->i . ' menit ';
                    }
                  ?>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['stop_l']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['stop_r']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2">
                    <?php
                      $awal         = date_create($rowd['tgl_stop_l'] . ' ' . $rowd['stop_l']);
                      $akhir        = date_create($rowd['tgl_stop_r'] . ' ' . $rowd['stop_r']);
        
                      $tmenit_stopmesin = date_diff($awal, $akhir);
        
                      $tmenit   = $tmenit_stopmesin->h . ' jam, ' . $tmenit_stopmesin->i . ' menit ';
        
                      $tjam  = round($diff / (60 * 60), 2);
                      $hari  = round($tjam / 24, 2);
                    ?>
                    <?php echo $tmenit; ?>
                  </font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['kd_stop']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['acc_staff']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="left">
                  <font size="-2"><?php echo $rowd['catatan']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="left">
                  <font size="-2"><?php echo $rowd['nokk']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="left">
                  <font size="-2"><?php echo $rowd['demandno']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="left">
                  <font size="-2"><?php echo $rowd['no_gerobak']; ?></font>
                </div>
              </td>
            </tr>
          <?php $no++; } ?>
        </tbody>
        <!--<tfoot>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2"><strong>Total</strong></td>
            <td><strong><?php echo $totqty; ?></strong></td>
            <td><strong><?php echo $totberat; ?></strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </tfoot>-->
      </table>
    </form>

    <!-- yang bawah ini udah gak kepakai lagi / belum ditambahin yang dibawah ada yg gak ada di atas apa enggak -->
  <?php } else if (($_POST['jns'] == "Produksi Finishing" or $_GET['jns'] == "Produksi Finishing" or $_GET['jns'] == "Produksi Finishing NOW") and ($_POST['jnsmesin'] == "belah" or $_POST['jnsmesin'] == "lipat")) {
  ?>
    <?php
    if ($_POST['awal'] != "") {
      $tglawal = $_POST['awal'];
      $tglakhir = $_POST['akhir'];
      $jns = $_POST['jns'];
    } else {
      $tglawal = $_GET['tgl1'];
      $tglakhir = $_GET['tgl2'];
      $jns = $_GET['jns'];
    }
    if ($_POST['shift'] != "") {
      $shft = $_POST['shift'];
    } else {
      $shft = $_GET['shift'];
    }
    if ($_POST['nama_mesin'] != "") {
      $mesin1 = $_POST['nama_mesin'];
    } else {
      $mesin1 = $_GET['msn'];
    }
    if ($tglakhir != "" and $tglawal != "") {
      $tgl = " DATE_FORMAT(a.`tgl_update`,'%Y-%m-%d') BETWEEN '$tglawal' AND '$tglakhir' ";
    } else {
      $tgl = " ";
    }
    if ($shft == "ALL") {
      $shift = " ";
    } else {
      $shift = " AND a.`shift`='$shft' ";
    }
    $msn = str_replace("'", "''", $mesin1);
    if ($msn == "") {
      $mesin = " ";
    } else {
      $mesin = " AND a.`no_mesin`='$msn' ";
    }
    ?>
    <input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='index.php'" class="art-button" />
    <a href="pages/reports-cetak-bl.php?tglawal=<?php echo $tglawal; ?>&amp;tglakhir=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>&amp;mesin=<?php echo $msn; ?>&amp;jnsmesin=<?php echo $_POST['jnsmesin']; ?>" class="art-button" target="_blank">CETAK</a>
    <a href="pages/reports-excel.php?tglawal=<?php echo $tglawal; ?>&amp;tglakhir=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>&amp;mesin=<?php echo $msn; ?>&amp;jnsmesin=<?php echo $_POST['jnsmesin']; ?>" class="art-button">Cetak Ke Excel</a>
    <strong><br />
    </strong>
    <form id="form1" name="form1" method="post" action="">
      <strong> Periode: <?php echo $tglawal; ?> s/d <?php echo $tglakhir; ?></strong><br />
      <strong>Shift: <?php echo $shft; ?> Jenis Mesin: <?php echo $_POST['jnsmesin']; ?> No Mesin:
        <?php if ($msn == "") {
          echo "ALL";
        } else {
          echo $msn;
        } ?>
      </strong><br />
      <table width="100%" border="0" id="datatables" class="display">
        <thead>
          <tr>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">#</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">TGL</font>
                </strong></div>
            </th>
            <?php if ($msn == "") { ?>
              <th rowspan="2" style="border:1px solid;vertical-align:middle;">
                <div align="center"><strong>
                    <font size="-2">MC</font>
                  </strong></div>
              </th>
            <?php } ?>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">LANGGANAN</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">NO. ORDER</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">NO. HANGER</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">JENIS KAIN</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">WARNA</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">LOT</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">ROLL</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">QUANTITY (Kg)</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">PANJANG AKTUAL (Yard)</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">PROSES</font>
                </strong></div>
            </th>
            <th colspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">LEBAR (INCHI)</font>
                </strong></div>
            </th>
            <th colspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">GRAMASI(G/M2)</font>
                </strong></div>
            </th>
            <th colspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">WAKTU</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">TOTAL WAKTU</font>
                </strong></div>
            </th>
            <th colspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">STOP MESIN</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">TOTAL</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">KODE</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">OPERATOR</font>
              </div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">KETERANGAN</font>
              </div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">NOKK</font>
              </div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">NO DEMAND</font>
              </div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">NO GRBK</font>
              </div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">AKSI</font>
                </strong></div>
            </th>
          </tr>
          <tr>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">PERMINTAAN</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">HASIL</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">PERMINTAAN</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">HASIL</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">MULAI</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">SELESAI</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">MULAI STOP</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">MULAI PROSES KEMBALI</font>
                </strong></div>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php
            $sql = mysqli_query($con, " SELECT 
                                              *,a.`id` as `idp` 
                                            FROM
                                              `tbl_produksi` a
                                              LEFT JOIN `tbl_no_mesin` b ON a.no_mesin=b.no_mesin
                                            WHERE
                                              $tgl $shift $mesin ORDER BY a.`jam_in` ASC");
            $no = 1;
            $c = 0;
            while ($rowd = mysqli_fetch_array($sql)) {
              $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
              // hitung hari dan jam	 
              $awal  = strtotime($rowd['tgl_stop_l'] . ' ' . $rowd['stop_l']);
              $akhir = strtotime($rowd['tgl_stop_r'] . ' ' . $rowd['stop_r']);
              $diff  = ($akhir - $awal);
              $tmenit = round($diff / (60), 2);
              $tjam  = round($diff / (60 * 60), 2);
              $hari  = round($tjam / 24, 2);
          ?>
            <tr bgcolor="<?php echo $bgcolor; ?>">
              <td style="border:1px solid;vertical-align:middle;">&nbsp;</td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['tgl_update']; ?></font>
                </div>
              </td>
              <?php if ($msn == "") { ?>
                <td style="border:1px solid;vertical-align:middle;">
                  <div align="center">
                    <font size="-2"><?php echo $rowd['no_mesin']; ?></font>
                  </div>
                </td>
              <?php } ?>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['langganan']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['no_order']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['no_item']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['jenis_kain']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['warna']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['lot']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['rol']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['qty']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['panjang']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['proses']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['lebar']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['lebar_h']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['gramasi']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['gramasi_h']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['jam_in']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['jam_out']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <?php
                  $total_waktu_awal         = date_create($rowd['jam_in']);
                  $total_waktu_akhir        = date_create($rowd['jam_out']);

                  if ($rowd['jam_in'] & $rowd['jam_out']) {
                    $diff_total_waktu              = date_diff($total_waktu_awal, $total_waktu_akhir);

                    echo $diff_total_waktu->h . ' jam, ';
                    echo $diff_total_waktu->i . ' menit ';
                  }
                  ?>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['stop_l']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['stop_r']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $tmenit; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['kd_stop']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['acc_staff']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="left">
                  <font size="-2"><?php echo $rowd['catatan']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="left">
                  <font size="-2"><?php echo $rowd['nokk']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="left">
                  <font size="-2"><?php echo $rowd['demandno']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="left">
                  <font size="-2"><?php echo $rowd['no_gerobak']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;"><input type="button" name="ubah" id="ubah" value="Ubah" onClick="confirmEdit('?p=edit-data-bl&id=<?php echo $rowd['idp']; ?>');" /><input type="button" name="hapus" id="hapus" value="Hapus" onClick="confirmDelete('?p=hapus-report1&id=<?php echo $rowd['idp']; ?>&tgl1=<?php echo $tglawal; ?>&tgl2=<?php echo $tglakhir; ?>&shift=<?php echo $shft; ?>&jns=Produksi Finishing&msn=<?php echo $msn; ?>');" /></td>
            </tr>
          <?php $no++; } ?>
        </tbody>
      </table>
    </form>
  <?php } else { echo $_POST['jns']; } ?>
</body>

</html>