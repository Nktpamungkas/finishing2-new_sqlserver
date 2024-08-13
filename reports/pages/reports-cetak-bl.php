<?php
ini_set("error_reporting", 1);
include('../../koneksi.php');
?>
<?php

$tglawal = $_GET['tglawal'];
$tglakhir = $_GET['tglakhir'];
$shft = $_GET['shift'];
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
if ($_GET['mesin'] == "") {
  $mesin = " ";
} else {
  $mesin = " AND a.`no_mesin`='$_GET[mesin]' ";
}

?>
<html>

<head>
  <title>:: Cetak Reports Produksi Finishing</title>
  <link href="../../styles_cetak.css" rel="stylesheet" type="text/css">
  <style>
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
  <table width="100%" border="0" class="table-list1">
    <thead>
      <tr valign="top">
        <td colspan="16">
          <table width="100%" border="0" class="table-list1">
            <thead>
              <tr>
                <td width="6%" rowspan="3"><img src="Indo.jpg" alt="" width="60" height="60"></td>
                <td width="75%" rowspan="3">
                  <div align="center">
                    <h2>FORM PRODUKSI HARIAN DEPARTEMEN FINISHING</h2>
                  </div>
                </td>
                <td width="8%">No. Form</td>
                <td width="11%">: FW-14-FIN-01B</td>
              </tr>
              <tr>
                <td>No. Revisi</td>
                <td>: 02</td>
              </tr>
              <tr>
                <td>Tgl. Terbit</td>
                <td>: 02 April 2014</td>
              </tr>
              <thead>
          </table>
        </td>
      </tr>
      <tr valign="top">
        <td colspan="7">TANGGAL:<strong> <?php echo $tglawal; ?> s/d <?php echo $tglakhir; ?></strong></td>
        <td colspan="3">SHIFT:<strong><?php echo $shft; ?></strong></td>
        <td colspan="6">MESIN :<strong>
            <?php if ($_GET['mesin'] == "") {
              echo "ALL";
            } else {
              echo $_GET['mesin'];
            } ?>
          </strong></td>
      </tr>
      <tr>
        <td rowspan="2">
          <div align="center">
            <font size="-2">Langganan</font>
          </div>
        </td>
        <td rowspan="2">
          <div align="center">
            <font size="-2">No. Order</font>
          </div>
        </td>
        <td rowspan="2">
          <div align="center">
            <font size="-2">Jenis Kain</font>
          </div>
        </td>
        <td rowspan="2">
          <div align="center">
            <font size="-2">Warna</font>
          </div>
        </td>
        <td rowspan="2">
          <div align="center">
            <font size="-2">Lot</font>
          </div>
        </td>
        <td rowspan="2">
          <div align="center">
            <font size="-2">Roll</font>
          </div>
        </td>
        <td rowspan="2">
          <div align="center">
            <font size="-2">Quantity (Kg)</font>
          </div>
        </td>
        <td rowspan="2">
          <div align="center">
            <font size="-2">Pnjg Akt(Yard)</font>
          </div>
        </td>
        <td colspan="2">
          <div align="center">
            <font size="-2">Permintaan</font>
          </div>
        </td>
        <td colspan="2">
          <div align="center">
            <font size="-2">Hasil</font>
          </div>
        </td>
        <td colspan="2">
          <div align="center">
            <font size="-2">Waktu</font>
          </div>
        </td>
        <td rowspan="2">
          <div align="center">
            <font size="-2">Total Waktu</font>
          </div>
        </td>
        <td rowspan="2">
          <div align="center">
            <font size="-2">Keterangan</font>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div align="center">
            <font size="-2">Lebar (Inchi)</font>
          </div>
        </td>
        <td>
          <div align="center">
            <font size="-2">Gramasi (g/m2)</font>
          </div>
        </td>
        <td>
          <div align="center">
            <font size="-2">Lebar (Inchi)</font>
          </div>
        </td>
        <td>
          <div align="center">
            <font size="-2">Gramasi (g/m2)</font>
          </div>
        </td>
        <td>
          <div align="center">
            <font size="-2">Mulai</font>
          </div>
        </td>
        <td>
          <div align="center">
            <font size="-2">Selesai</font>
          </div>
        </td>
      </tr>
    </thead>
    <tbody>
      <?php
        $sql = mysqli_query($con, " SELECT 
                                          *
                                        FROM
                                          `tbl_produksi` a
                                        WHERE
                                          jns_mesin='$_GET[jnsmesin]' AND " . $tgl . $shift . $mesin . " ORDER BY a.`jam_in` ASC");
        $no = 1;
        $c = 0;
        while ($rowd = mysqli_fetch_array($sql)) {
          // hitung hari dan jam	 
          $awal  = strtotime($rowd['tgl_stop_l'] . ' ' . $rowd['stop_l']);
          $akhir = strtotime($rowd['tgl_stop_r'] . ' ' . $rowd['stop_r']);
          $diff  = ($akhir - $awal);
          $tmenit = round($diff / (60), 2);
          $tjam  = round($diff / (60 * 60), 2);
          $hari  = round($tjam / 24, 2);
      ?>
        <tr valign="top">
          <td bgcolor="<?php echo $bgcolor; ?>" class="display" style="border:1px solid;vertical-align:middle;">
            <font size="-2"><?php echo $rowd['langganan']; ?></font>
          </td>
          <td bgcolor="<?php echo $bgcolor; ?>" class="display" style="border:1px solid;vertical-align:middle;">
            <font size="-2"><?php echo $rowd['no_order']; ?></font>
          </td>
          <td bgcolor="<?php echo $bgcolor; ?>" class="display" style="border:1px solid;vertical-align:middle;">
            <font size="-2"><?php echo $rowd['jenis_kain']; ?></font>
          </td>
          <td bgcolor="<?php echo $bgcolor; ?>" class="display" style="border:1px solid;vertical-align:middle;">
            <font size="-2"><?php echo $rowd['warna']; ?></font>
          </td>
          <td bgcolor="<?php echo $bgcolor; ?>" class="display" style="border:1px solid;vertical-align:middle;">
            <div align="center">
              <font size="-2"><?php echo $rowd['lot']; ?></font>
            </div>
          </td>
          <td bgcolor="<?php echo $bgcolor; ?>" class="display" style="border:1px solid;vertical-align:middle;">
            <div align="center">
              <font size="-2"><?php echo $rowd['rol']; ?></font>
            </div>
          </td>
          <td bgcolor="<?php echo $bgcolor; ?>" class="display" style="border:1px solid;vertical-align:middle;">
            <div align="center">
              <font size="-2"><?php echo $rowd['qty']; ?></font>
            </div>
          </td>
          <td bgcolor="<?php echo $bgcolor; ?>" class="display" style="border:1px solid;vertical-align:middle;">
            <div align="center">
              <font size="-2"><?php echo $rowd['panjang']; ?></font>
            </div>
          </td>
          <td bgcolor="<?php echo $bgcolor; ?>" class="display" style="border:1px solid;vertical-align:middle;">
            <div align="center">
              <font size="-2"><?php echo $rowd['lebar']; ?></font>
            </div>
          </td>
          <td bgcolor="<?php echo $bgcolor; ?>" class="display" style="border:1px solid;vertical-align:middle;">
            <div align="center">
              <font size="-2"><?php echo $rowd['gramasi']; ?></font>
            </div>
          </td>
          <td bgcolor="<?php echo $bgcolor; ?>" class="display" style="border:1px solid;vertical-align:middle;">
            <div align="center">
              <font size="-2"><?php echo $rowd['lebar_h']; ?></font>
            </div>
          </td>
          <td bgcolor="<?php echo $bgcolor; ?>" class="display" style="border:1px solid;vertical-align:middle;">
            <div align="center">
              <font size="-2"><?php echo $rowd['gramasi_h']; ?></font>
            </div>
          </td>
          <td bgcolor="<?php echo $bgcolor; ?>" class="display" style="border:1px solid;vertical-align:middle;">
            <div align="center">
              <font size="-2"><?php echo $rowd['jam_in']; ?></font>
            </div>
          </td>
          <td bgcolor="<?php echo $bgcolor; ?>" class="display" style="border:1px solid;vertical-align:middle;">
            <div align="center">
              <font size="-2"><?php echo $rowd['jam_out']; ?></font>
            </div>
          </td>
          <td bgcolor="<?php echo $bgcolor; ?>" class="display" style="border:1px solid;vertical-align:middle;">
            <div align="center">
              <font size="-2">
                <?php
                  $total_waktu_awal         = date_create($rowd['jam_in']);
                  $total_waktu_akhir        = date_create($rowd['jam_out']);

                  $diff_total_waktu              = date_diff($total_waktu_awal, $total_waktu_akhir);

                  echo $diff_total_waktu->h . ' jam, '; echo $diff_total_waktu->i . ' menit '; 
                ?>  
              </font>
            </div>
          </td>
          <td>
            <font size="-2"><?php echo $rowd['catatan']; ?></font>
          </td>
        </tr>
      <?php
        $totrol += $rowd['rol'];
        $totberat += $rowd['qty'];
        $no++;
      } ?>
    </tbody>
    <tr>
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
    <tr>
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
  </table>
  <table width="100%" border="0" class="table-list1">
    <tr>
      <td width="15%">&nbsp;</td>
      <td width="31%">
        <div align="center">DIBUAT OLEH:</div>
      </td>
      <td width="27%">
        <div align="center">DIPERIKSA OLEH:</div>
      </td>
      <td width="27%">
        <div align="center">DIKETAHUI OLEH:</div>
      </td>
    </tr>
    <tr>
      <td>NAMA</td>
      <td>
        <div align="center">
          <input name=nama type=text placeholder="Ketik disini" size="33" maxlength="30">
        </div>
      </td>
      <td>
        <div align="center">
          <input name=nama3 type=text placeholder="Ketik disini" size="33" maxlength="30">
        </div>
      </td>
      <td>
        <div align="center">Yayan Tri B</div>
      </td>
    </tr>
    <tr>
      <td>JABATAN</td>
      <td>
        <div align="center">Operator</div>
      </td>
      <td>
        <div align="center">Supervisor / Asst. Supervisor</div>
      </td>
      <td>
        <div align="center">Manager / Asst. Manager</div>
      </td>
    </tr>
    <tr>
      <td>TANGGAL</td>
      <td>
        <div align="center">
          <input type="text" name="date" placeholder="dd-mm-yyyy" onKeyUp="
  var date = this.value;
  if (date.match(/^\d{2}$/) !== null) {
     this.value = date + '-';
  } else if (date.match(/^\d{2}\-\d{2}$/) !== null) {
     this.value = date + '-';
  }" maxlength="10">
        </div>
      </td>
      <td>
        <div align="center">
          <input type="text" name="date" placeholder="dd-mm-yyyy" onKeyUp="
  var date = this.value;
  if (date.match(/^\d{2}$/) !== null) {
     this.value = date + '-';
  } else if (date.match(/^\d{2}\-\d{2}$/) !== null) {
     this.value = date + '-';
  }" maxlength="10">
        </div>
      </td>
      <td>
        <div align="center">
          <input type="text" name="date" placeholder="dd-mm-yyyy" onKeyUp="
  var date = this.value;
  if (date.match(/^\d{2}$/) !== null) {
     this.value = date + '-';
  } else if (date.match(/^\d{2}\-\d{2}$/) !== null) {
     this.value = date + '-';
  }" maxlength="10">
        </div>
      </td>
    </tr>
    <tr>
      <td height="60" valign="top">TANDA TANGAN</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>

</body>

</html>