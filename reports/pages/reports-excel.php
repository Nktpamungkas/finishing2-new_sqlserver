<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=report-produksi-" . date($_GET['tglawal']) . ".xls"); //ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");
//disini script laporan anda
?>
<?php
//$con=mysqli_connect("10.0.1.91","dit","4dm1n","db_finishing");
ini_set("error_reporting", 1);
include ('../../koneksi.php');
?>

<body>
  <?php
  $tglawal = $_GET['tglawal'];
  $tglakhir = $_GET['tglakhir'];
  $jamawal = $_GET['jamawal'];
  $jamakhir = $_GET['jamakhir'];
  $shft = $_GET['shift'];
  if ($tglakhir != "" and $tglawal != "") {
    $tgl = " DATE_FORMAT(a.`tgl_update`,'%Y-%m-%d') BETWEEN '$tglawal' AND '$tglakhir' ";
  } else {
    $tgl = " ";
  }
  // if ($tglakhir != "" and $tglawal != "" or $jamakhir != "" and $jamawal != "") {
  //   $tgl = " DATE_FORMAT(a.`tgl_buat`,'%Y-%m-%d %H:%i') BETWEEN '$tglawal $jamawal' AND '$tglakhir $jamakhir' ";
  // } else {
  //   $tgl = " ";
  // }	
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
  <table width="100%" border="1">
    <tr valign="top">
      <td colspan="<?php if ($_GET['mesin'] == "") {
        echo "7";
      } else {
        echo "8";
      } ?>">TANGGAL:<strong> <?php echo $tglawal . " " . $jamawal; ?> s/d
          <?php echo $tglakhir . " " . $jamakhir; ?></strong></td>
      <td colspan="9">GROUP SHIFT:<strong><?php echo $shft; ?></strong></td>
      <td colspan="12">NO MESIN :<strong>
          <?php if ($_GET['mesin'] == "") {
            echo "ALL";
          } else {
            echo $_GET['mesin'];
          } ?>
        </strong></td>
    </tr>
    <tr>
      <td colspan="4">
        <div align="center">
          <font size="-2">POTONG SAMPLE UNTUK QC</font>
        </div>
      <td rowspan="3">
        <div align="center">
          <font size="-2">PROD<br>ORDER</font>
        </div>
      </td>
      <td rowspan="3">
        <div align="center">
          <font size="-2">PROD<br>DEMAND</font>
        </div>
      <td rowspan="3">
        <div align="center">
          <font size="-2">B / K</font>
        </div>
      </td>
      <?php if ($_GET['mesin'] == "") { ?>
        <td rowspan="3">
          <div align="center">
            <font size="-2">MC</font>
          </div>
        </td>
      <?php } ?>
      <td rowspan="3">
        <div align="center">
          <font size="-2">Langganan</font>
        </div>
      </td>
      <td rowspan="3">
        <div align="center">
          <font size="-2">No. Order</font>
        </div>
      </td>
      <td rowspan="3">
        <div align="center">
          <font size="-2">No. Hanger</font>
        </div>
      </td>
      <td rowspan="3">
        <div align="center">
          <font size="-2">Jenis Kain</font>
        </div>
      </td>
      <td rowspan="3">
        <div align="center">
          <font size="-2">Warna</font>
        </div>
      </td>
      <td rowspan="3">
        <div align="center">
          <font size="-2">Lot</font>
        </div>
      </td>
      <td rowspan="3">
        <div align="center">
          <font size="-2">Roll</font>
        </div>
      </td>
      <td rowspan="3">
        <div align="center">
          <font size="-2">Quantity (Kg)</font>
        </div>
      </td>
      <td rowspan="3">
        <div align="center">
          <font size="-2">Panjang Aktual(Yard)</font>
        </div>
      </td>
      <td rowspan="3">
        <div align="center">
          <font size="-2">Proses</font>
        </div>
      </td>
      <td rowspan="3">
        <div align="center">
          <font size="-2">Suhu</font>
        </div>
      </td>
      <td rowspan="3">
        <div align="center">
          <font size="-2">Speed</font>
        </div>
      </td>
      <td rowspan="3">
        <div align="center">
          <font size="-2">VMT</font>
        </div>
      </td>
      <td rowspan="3">
        <div align="center">
          <font size="-2">OVER FEED</font>
        </div>
      </td>
      <td rowspan="3">
        <div align="center">
          <font size="-2">BUKA RANTAI</font>
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
      <td rowspan="3">
        <div align="center">
          <font size="-2">Total Waktu</font>
        </div>
      </td>
      <td colspan="2">
        <div align="center">
          <font size="-2">Stop Mesin</font>
        </div>
      </td>
      <td rowspan="3">
        <div align="center">
          <font size="-2">Total</font>
        </div>
      </td>
      <td rowspan="3">
        <div align="center">
          <font size="-2">Kode</font>
        </div>
      </td>
      <td rowspan="3">
        <div align="center">
          <font size="-2">Operator</font>
        </div>
      </td>
      <td rowspan="3">
        <div align="center">
          <font size="-2">Keterangan</font>
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <div align="center">
          <font size="-2">Shrinkage</font>
        </div>
      </td>
      <td colspan="2">
        <div align="center">
          <font size="-2">Cocok Warna</font>
        </div>
      </td>
      <td rowspan="2">
        <div align="center">
          <font size="-2">Lebar (Inchi)</font>
        </div>
      </td>
      <td rowspan="2">
        <div align="center">
          <font size="-2">Gramasi (g/m2)</font>
        </div>
      </td>
      <td rowspan="2">
        <div align="center">
          <font size="-2">Lebar (Inchi)</font>
        </div>
      </td>
      <td rowspan="2">
        <div align="center">
          <font size="-2">Gramasi (g/m2)</font>
        </div>
      </td>
      <td rowspan="2">
        <div align="center">
          <font size="-2">Mulai</font>
        </div>
      </td>
      <td rowspan="2">
        <div align="center">
          <font size="-2">Selesai</font>
        </div>
      </td>
      <td rowspan="2">
        <div align="center">
          <font size="-2">Mulai Stop</font>
        </div>
      </td>
      <td rowspan="2">
        <div align="center">
          <font size="-2">Mulai Proses Kembali</font>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div align="center">
          <font size="-2">QC 1</font>
        </div>
      </td>
      <td>
        <div align="center">
          <font size="-2">FIN</font>
        </div>
      </td>
      <td>
        <div align="center">
          <font size="-2">QC 2</font>
        </div>
      </td>
      <td>
        <div align="center">
          <font size="-2">FIN</font>
        </div>
      </td>
    </tr>
    <?php
    $sql = mysqli_query($con, " SELECT 
                                        *
                                      FROM
                                        `tbl_produksi` a
                                      WHERE
                                        $tgl $shift $mesin ORDER BY a.`jam_in` ASC");
    $no = 1;
    $c = 0;
    while ($rowd = mysqli_fetch_array($sql)) {
      // hitung hari dan jam	 
      // $awal  = strtotime($rowd['tgl_stop_l'] . ' ' . $rowd['stop_l']);
      // $akhir = strtotime($rowd['tgl_stop_r'] . ' ' . $rowd['stop_r']);
      // $diff  = ($akhir - $awal);
      // $tmenit = round($diff / (60), 2);
      $awal = date_create($rowd['tgl_stop_l'] . ' ' . $rowd['stop_l']);
      $akhir = date_create($rowd['tgl_stop_r'] . ' ' . $rowd['stop_r']);

      $tmenit_stopmesin = date_diff($awal, $akhir);

      $tmenit = $tmenit_stopmesin->h . ' jam, ' . $tmenit_stopmesin->i . ' menit ';

      $tjam = round($diff / (60 * 60), 2);
      $hari = round($tjam / 24, 2);
      ?>
      <tr valign="top">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>
          <font size="-2"><?php echo $rowd['nokk']; ?></font>
        </td>
        <td>
          <font size="-2"><?php echo $rowd['demandno']; ?></font>
        </td>
        <td>
          <div align="center">
            <font size="-2"><?php echo $rowd['kondisi_kain']; ?></font>
          </div>
        </td>
        <?php if ($_GET['mesin'] == "") { ?>
          <td>
            <font size="-2"><?php echo $rowd['no_mesin']; ?></font>
          </td>
        <?php } ?>
        <td>
          <font size="-2"><?php echo $rowd['langganan']; ?></font>
        </td>
        <td>
          <font size="-2"><?php echo $rowd['no_order']; ?></font>
        </td>
        <td>
          <div align="center">
            <font size="-2"><?php echo $rowd['no_item']; ?></font>
          </div>
        </td>
        <td>
          <font size="-2"><?php echo $rowd['jenis_kain']; ?></font>
        </td>
        <td>
          <font size="-2"><?php echo $rowd['warna']; ?></font>
        </td>
        <td>
          <div align="center">
            <font size="-2">'<?php echo $rowd['lot']; ?></font>
          </div>
        </td>
        <td>
          <div align="center">
            <font size="-2"><?php echo $rowd['rol']; ?></font>
          </div>
        </td>
        <td>
          <div align="center">
            <font size="-2"><?php echo $rowd['qty']; ?></font>
          </div>
        </td>
        <td>
          <div align="center">
            <font size="-2"><?php echo $rowd['panjang']; ?></font>
          </div>
        </td>
        <td>
          <font size="-2"><?php echo $rowd['proses']; ?></font>
        </td>
        <td>
          <font size="-2">
            <?php
            if ($rowd['suhu']) {
              echo $rowd['suhu'];
            } else {
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
        <td>
          <font size="-2">
            <?php
            if ($rowd['speed']) {
              echo $rowd['speed'];
            } else {
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
        <td>
          <font size="-2">
            <?php
            if ($rowd['vmt']) {
              echo $rowd['vmt'];
            } else {
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
        <td>
          <font size="-2">
            <?php
            if ($rowd['overfeed']) {
              echo $rowd['overfeed'];
            } else {
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
        <td>
          <font size="-2">
            <?php
            if ($rowd['buka_rantai']) {
              echo $rowd['buka_rantai'];
            } else {
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
        <td>
          <div align="center">
            <font size="-2"><?php echo $rowd['lebar']; ?></font>
          </div>
        </td>
        <td>
          <div align="center">
            <font size="-2"><?php echo $rowd['gramasi']; ?></font>
          </div>
        </td>
        <td>
          <div align="center">
            <font size="-2">
              <?php
              if ($rowd['lebar_h']) {
                echo $rowd['lebar_h'];
              } else {
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
        <td>
          <div align="center">
            <font size="-2">
              <?php
              if ($rowd['gramasi_h']) {
                echo $rowd['gramasi_h'];
              } else {
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
        <td>
          <div align="center">
            <font size="-2"><?php echo $rowd['jam_in']; ?></font>
          </div>
        </td>
        <td>
          <div align="center">
            <font size="-2"><?php echo $rowd['jam_out']; ?></font>
          </div>
        </td>
        <td>
          <div align="center">
            <font size="-2">
              <?php
              $total_waktu_awal = date_create($rowd['jam_in']);
              $total_waktu_akhir = date_create($rowd['jam_out']);

              $diff_total_waktu = date_diff($total_waktu_awal, $total_waktu_akhir);

              echo $diff_total_waktu->h . ' jam, ';
              echo $diff_total_waktu->i . ' menit ';
              ?>
            </font>
          </div>
        </td>
        <td>
          <div align="center">
            <font size="-2"><?php echo $rowd['stop_l']; ?></font>
          </div>
        </td>
        <td>
          <div align="center">
            <font size="-2"><?php echo $rowd['stop_r']; ?></font>
          </div>
        </td>
        <td>
          <div align="center">
            <font size="-2"><?php echo $tmenit; ?></font>
          </div>
        </td>
        <td>
          <div align="center">
            <font size="-2"><?php echo $rowd['kd_stop']; ?></font>
          </div>
        </td>
        <td>
          <div align="center">
            <font size="-2"><?php echo $rowd['acc_staff']; ?></font>
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
  </table>
</body>