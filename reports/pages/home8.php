<?php
    ini_set("error_reporting", 1);
    session_start();
    include '../koneksi.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Kartu Stock Obat / Chemical Finishing</title>
  <script>
    function ganti() {
      var lprn = document.forms['form1']['jns'].value;
      if (lprn == "Produksi Finishing") {
        window.location.href = "?p=home";	
	  } else if (lprn == "Adm Finishing") {
        window.location.href = "?p=home2";
      } else if (lprn == "Detail In-Out") {
        window.location.href = "?p=home3";
      } else if (lprn == "Grafik") {
        window.location.href = "?p=home4";
      } else if (lprn == "Detail Proses") {
        window.location.href = "?p=home5";
      } else if (lprn == "Stoppage Mesin") {
        window.location.href = "?p=home6";
      }else if (lprn == "Produksi Finishing NOW"){
        window.location.href = "?p=home7";
      }else if (lprn == "Kartu Stock Obat"){
        window.location.href = "?p=home8";
      }
    }
  </script>
</head>

<body>
  <form id="form1" name="form1" method="post" action="pages/kartu-stock-obat.php" target="_blank">
    <table width="470" border="0">
      <tr>
        <td colspan="3">
          <div align="center"><strong>Kartu Stock Obat / Chemical Finishing</strong></div>
          <br>
          </div>
          <?php
              $user_name = $_SESSION['username'];
              date_default_timezone_set('Asia/Jakarta');
              $tgl = date("Y-M-d h:i:s A");
          echo $tgl; ?>
        </td>
        <br>
      </tr>
      <tr>
        <td><strong>Jenis Laporan</strong></td>
        <td>:</td>
        <td><label for="jns"></label>
          <select name="jns" id="jns" onchange="ganti();">
            <option value="Produksi Finishing">Produksi Finishing</option>
            <option value="Produksi Finishing NOW">Produksi Finishing NOW</option>
            <!-- <option value="Adm Finishing">Adm Finishing</option> -->
            <!-- <option value="Detail In-Out">Detail In-Out</option> -->
            <!-- <option value="Grafik">Grafik</option> -->
            <!-- <option value="Detail Proses">Detail Proses</option> -->
            <option value="Stoppage Mesin">Stoppage Mesin</option>
            <option value="Kartu Stock Obat" selected="selected">Kartu Stock Obat</option>

          </select>
        </td>
      </tr>
      <tr valign="middle">
        <td><strong>Nama Obat</strong></td>
        <td>:</td>
        <td>
            <?php
                $sql  = "SELECT kode, name FROM db_finishing.tbl_obat ORDER BY kode";
                $stmt = sqlsrv_query($con, $sql);

                if ($stmt === false) {
                    die(print_r(sqlsrv_errors(), true));
                }
            ?>

            <select name="kode_obat" id="kode_obat" required onchange="updateHiddenInput(this)">
              <option value="">Pilih</option>
              <?php
                  while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                      echo '<option value="' . $row['kode'] . '" data-name="' . $row['name'] . '">(' . $row['kode'] . ') ' . $row['name'] . '</option>';
                  }
              ?>
            </select>

            <input type="hidden" name="nama_obat" id="nama_obat"/>
        </td>
      </tr>
      <tr valign="middle">
        <td width="127"><strong>Tanggal Awal</strong></td>
        <td width="3">:</td>
        <td width="280"><input name="awal" type="text" id="awal" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.awal);return false;" size="14" required="required" /><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.awal);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal" style="border:none" align="absmiddle" border="0" /></a></td>
      </tr>
      <tr>

        <td><strong>Tanggal Akhir</strong></td>
        <td>:</td>
        <td width="280"><input name="akhir" type="text" id="akhir" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.akhir);return false;" size="14" required="required" /><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.akhir);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal" style="border:none" align="absmiddle" border="0" /></a></td>
      </tr>
      <tr>
        <td colspan="3"><input type="submit" name="button" id="button" value="Lihat Data" class="art-button" /> <input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='../index.php'" class="art-button" /></td>
      </tr>
    </table>
  </form>
</body>
</html>

<script>
    function updateHiddenInput(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const nama_obat = document.getElementById('nama_obat');
        nama_obat.value = selectedOption.getAttribute('data-name');
    }
</script>