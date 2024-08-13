<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Laporan Detail <?php echo $_POST['mesin']; ?></title>
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
    $(document).ready(function() {
      $('#datatables').dataTable({
        "sScrollY": "300px",
        "sScrollX": "100%",
        "bScrollCollapse": true,
        "bPaginate": false,
        "bJQueryUI": true
      });
    })
  </script>
</head>

<body>
  <?php
  ini_set("error_reporting", 1);
  session_start();
  include('../koneksi.php');
  ?>
  <?php if ($_POST['mesin'] == "Stenter" or $_GET['mesin'] == "Stenter") {  ?>
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
      if ($_POST['shift2'] != "") {
        $shft2 = $_POST['shift2'];
      } else {
        $shft2 = $_GET['shift2'];
      }
      if ($tglakhir != "" and $tglawal != "") {
        $tgl = " DATE_FORMAT(a.`tgl_update`,'%Y-%m-%d') BETWEEN '$tglawal' AND '$tglakhir' ";
      } else {
        $tgl = " ";
      }
      if ($shft == "ALL") {
        $shift = " ";
      } else {
        $shift = " AND a.`shift2`='$shft' ";
      }
      if ($shft2 == "ALL") {
        $shift2 = " ";
      } else {
        $shift2 = " AND a.`shift`='$shft2' ";
      }
      $msn = str_replace("'", "''", $_POST['nama_mesin']);
      if ($_POST['nama_mesin'] == "") {
        $mesin = " ";
      } else {
        $mesin = " AND a.`no_mesin`='$msn' ";
      }

    ?>
    <input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='index.php'" class="art-button" />
    <input type="button" name="button3" id="button3" value="Cetak" onclick="window.open('pages/reports-detail-stenter.php?tglawal=<?php echo $tglawal; ?>&amp;tglakhir=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>&amp;shift2=<?php echo $shft2; ?>&amp;mesin=<?php echo $_POST['nama_mesin']; ?>', '_blank')" class="art-button" />
    <input type="button" name="button" id="button" value="Cetak Ke Excel" onClick="window.location.href='pages/reports-detail-stenter-excel.php?tglawal=<?php echo $tglawal; ?>&amp;tglakhir=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>&amp;shift2=<?php echo $shft2; ?>&amp;mesin=<?php echo $_POST['nama_mesin']; ?>'" class="art-button" />
    <br />
    <strong><br />
    </strong>
    <form id="form1" name="form1" method="post" action="">
      <strong> Periode: <?php echo $tglawal; ?> s/d <?php echo $tglakhir; ?></strong><br />
      <strong>Shift Group: <?php echo $shft2; ?></strong><br />
      <strong>Mesin : Stenter</strong><br />
      <strong>No Mesin : <?php echo $msn; ?></strong><br />
      <table width="100%" border="0" id="datatables" class="display">
        <thead>
          <tr>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">PROD. ORDER</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">PROD. DEMAND</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">TGL</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">SHIFT</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">OPERATOR</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">LANGGANAN</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">NO ORDER</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">NO HANGER</font>
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
                  <font size="-2">QUANTITY<br />
                    (Kg)
                  </font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">PANJANG KAIN ACTUAL (Yard)</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">PROSES</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2"> SUHU</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2"> SPEED</font>
                </strong></div>
            </th>
            <th colspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">MAHLO</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">OVERFEED</font>
                </strong>
              </div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">BUKA RANTAI</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">pH LARUTAN</font>
              </div>
            </th>
            <th colspan="10" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">pH LARUTAN</font>
              </div>
            </th>
            <th colspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">LEBAR (INCI)</font>
                </strong></div>
            </th>
            <th colspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">GRAMASI (gr/m2)</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">NO GROBAK</font>
                </strong></div>
            </th>
          </tr>
          <tr>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">VMT</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">OMT</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">CHEMICAL I</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">KONSENTRASI I</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">CHEMICAL II</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">KONSENTRASI II</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">CHEMICAL III</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">KONSENTRASI III</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">CHEMICAL IV</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">KONSENTRASI IV</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">CHEMICAL V</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">KONSENTRASI V</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">CHEMICAL VI</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">KONSENTRASI VI</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">CHEMICAL VII</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">KONSENTRASI VII</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">PERMINTAAN</font>
                </strong> </div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">ACTUAL</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">PERMINTAAN</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">ACTUAL</font>
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
                                        WHERE
                                          " . $tgl . $mesin . $shift2 . " ORDER BY a.`tgl_update` ASC ");

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
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['nokk']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['demandno']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['tgl_update']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['shift']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['acc_staff']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['langganan']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['no_order']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['no_item']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['jenis_kain']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['warna']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['lot']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['rol']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['qty']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['panjang_h']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['proses']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['suhu']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['speed']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['vmt'] . "&deg;
         X " . $rowd['t_vmt']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['omt']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['overfeed']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['buka_rantai']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['ph_larut']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['chemical_1']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['konsen_1']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['chemical_2']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['konsen_2']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['chemical_3']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['konsen_3']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['chemical_4']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['konsen_4']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['chemical_5']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['konsen_5']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['chemical_6']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['konsen_6']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['chemical_7']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['konsen_7']; ?></font>
                </div>
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
                  <font size="-2"><?php echo $rowd['no_gerobak']; ?></font>
                </div>
              </td>
            </tr>
          <?php

            $no++;
          } ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="5">&nbsp;</td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </tfoot>
      </table>
    </form>
  <?php } else if ($_POST['mesin'] == "Compact" or $_GET['mesin'] == "Compact") { ?>
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
    $msn = str_replace("'", "''", $_POST['nama_mesin']);
    if ($_POST['nama_mesin'] == "") {
      $mesin = " ";
    } else {
      $mesin = " AND a.`no_mesin`='$msn' ";
    }

    ?>
    <input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='index.php'" class="art-button" />
    <input type="button" name="button3" id="button3" value="Cetak" onclick="window.open('pages/reports-detail-compact.php?tglawal=<?php echo $tglawal; ?>&amp;tglakhir=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>&amp;mesin=<?php echo $_POST['nama_mesin']; ?>', '_blank')" class="art-button" />
    <input type="button" name="button" id="button" value="Cetak Ke Excel" onClick="window.location.href='pages/reports-detail-compact-excel.php?tglawal=<?php echo $tglawal; ?>&amp;tglakhir=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>&amp;mesin=<?php echo $_POST['nama_mesin']; ?>'" class="art-button" />
    <br />
    <strong><br />
    </strong>
    <form id="form1" name="form1" method="post" action="">
      <strong> Periode: <?php echo $tglawal; ?> s/d <?php echo $tglakhir; ?></strong><br />
      <strong>Shift: <?php echo $shft; ?></strong> <br />
      <strong>Mesin : Compact</strong><br />
      <table width="100%" border="0" id="datatables" class="display">
        <thead>
          <tr>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">TGL</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">SHIFT</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">OPERATOR</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">LANGGANAN</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">NO ORDER</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">NO HANGER</font>
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
                  <font size="-2">QUANTITY<br />
                    (Kg)
                  </font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">PANJANG KAIN ACTUAL (Yard)</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">PROSES</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2"> SUHU</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2"> SPEED</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">OVERFEED</font>
                </strong>
              </div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">BUKA RANTAI</font>
                </strong></div>
            </th>
            <th colspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">LEBAR (INCI)</font>
                </strong></div>
            </th>
            <th colspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">GRAMASI (gr/m2)</font>
                </strong></div>
            </th>
            <th rowspan="2" style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">NO GROBAK</font>
                </strong></div>
            </th>
          </tr>
          <tr>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">PERMINTAAN</font>
                </strong> </div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">ACTUAL</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">PERMINTAAN</font>
                </strong></div>
            </th>
            <th style="border:1px solid;vertical-align:middle;">
              <div align="center"><strong>
                  <font size="-2">ACTUAL</font>
                </strong></div>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php

          $sql = mysqli_query($con, " SELECT 
                                        *,a.`id` as `idp` 
                                      FROM
                                        `tbl_compact` a
                                      WHERE
                                        " . $tgl . $shift . " ORDER BY a.`tgl_update` ASC ");

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
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['tgl_update']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['shift']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['acc_staff']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['langganan']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['no_order']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['no_item']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['jenis_kain']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['warna']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['lot']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['rol']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['qty']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['panjang_h']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['proses']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['suhu']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <font size="-2"><?php echo $rowd['speed']; ?></font>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['overfeed']; ?></font>
                </div>
              </td>
              <td style="border:1px solid;vertical-align:middle;">
                <div align="center">
                  <font size="-2"><?php echo $rowd['buka_rantai']; ?></font>
                </div>
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
                  <font size="-2"><?php echo $rowd['no_gerobak']; ?></font>
                </div>
              </td>
            </tr>
          <?php

            $no++;
          } ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="5">&nbsp;</td>
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
          </tr>
        </tfoot>
      </table>
    </form>
  <?php } ?>

</body>

</html>