<?php
ini_set("error_reporting", 1);
session_start();
include('../koneksi.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Laporan Produksi Finishing</title>
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
      }else if (lprn == "Produksi Finishing NOW"){
        window.location.href = "?p=home7";
      }
    }

    function test(){
        alert('asd')
    }
  </script>
</head>

<body>
  <form id="form1" name="form1" method="post" action="index.php?p=reports" target="_blank">
    <table width="470" border="0">
      <tr>
        <td colspan="3">
          <div align="center"><strong>LAPORAN STOPPAGE MESIN</strong></div>
          </div>
          <?php
          $user_name = $_SESSION['username'];
          date_default_timezone_set('Asia/Jakarta');
          $tgl = date("Y-M-d h:i:s A");
          echo $tgl; ?><br />
        </td>
      </tr>
      <tr>
        <td><strong>Jenis Laporan</strong></td>
        <td>:</td>
        <td><label for="jns"></label>
          <select name="jns" id="jns" onchange="ganti();">
            <option value="Produksi Finishing">Produksi Finishing</option>
            <option value="Produksi Finishing NOW" selected="selected">Produksi Finishing NOW</option>
            <!-- <option value="Adm Finishing">Adm Finishing</option> -->
            <!-- <option value="Detail In-Out">Detail In-Out</option> -->
            <!-- <option value="Grafik">Grafik</option> -->
            <!-- <option value="Detail Proses">Detail Proses</option> -->
            <option value="Stoppage Mesin">Stoppage Mesin</option>
          </select>
        </td>
      </tr>
      <!-- <tr valign="middle">
        <td><strong>Jenis Mesin</strong></td>
        <td>:</td>
        <td><select name="jnsmesin" id="jnsmesin" onChange="window.location='?p=home7&jns='+this.value">
            <option value="">Pilih</option>
            <?php
                $q_operation = db2_exec($conn_db2, "SELECT DISTINCT 
                                                            TRIM(o.CODE) AS CODE,
                                                            o.LONGDESCRIPTION,
                                                            SUBSTR(w.WORKCENTERCODE, 1,4) AS KODE_MESIN
                                                        FROM
                                                            OPERATION o
                                                        LEFT JOIN WORKCENTERANDOPERATTRIBUTES w ON w.OPERATIONCODE = o.CODE
                                                        WHERE
                                                            o.OPERATIONGROUPCODE = 'FIN'");
            ?>
            <?php while ($r_operation = db2_fetch_assoc($q_operation)) { ?>
                <option value="<?= $r_operation['CODE']; ?>" <?php if ($_GET['jns'] == "$r_operation[CODE]") { echo "SELECTED"; } ?>><?= $r_operation['CODE']; ?> <?php echo $r_operation['LONGDESCRIPTION']; ?></option>
            <?php } ?>
            <option value="OVEN" <?php if("OVEN" == $_GET['jns']){ echo "SELECTED"; } ?>>OVEN</option>
          </select></td>
      </tr> -->
      <tr valign="middle">
        <td width="127"><strong>Tanggal Awal</strong></td>
        <td width="3">:</td>
        <td width="280">
			<input name="jam_awal" type="text" id="jam_awal" placeholder="23:00" pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 23:00" onkeyup="
            var time = this.value;
            if (time.match(/^\d{2}$/) !== null) {
              this.value = time + ':';
            } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
              this.value = time + '';
            }" value="<?= $_GET['jam1']; ?>" size="5" maxlength="5" onChange="window.location='?p=home7&jns=<?= $_GET['jns']; ?>&jam1='+this.value" hidden/>
            <input name="awal" type="date" id="awal" value="<?= $_GET['awal']; ?>" 
                onChange="window.location='?p=home7&jns=<?= $_GET['jns']; ?>&jam1=<?= $_GET['jam1']; ?>&awal='+this.value" size="14" required="required" />
        </td>
      </tr>
      <tr>

        <td><strong>Tanggal Akhir</strong></td>
        <td>:</td>
        <td width="280">
			<input name="jam_akhir" type="text" id="jam_akhir" placeholder="23:00" pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 23:00" onkeyup="
            var time = this.value;
            if (time.match(/^\d{2}$/) !== null) {
              this.value = time + ':';
            } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
              this.value = time + '';
            }" value="<?= $_GET['jam2']; ?>" size="5" maxlength="5" onChange="window.location='?p=home7&jns=<?= $_GET['jns']; ?>&jam1=<?= $_GET['jam1']; ?>&awal=<?= $_GET['awal']; ?>&jam2='+this.value" hidden/>
            <input name="akhir" type="date" id="akhir" value="<?= $_GET['akhir']; ?>" 
                onChange="window.location='?p=home7&jns=<?= $_GET['jns']; ?>&jam1=<?= $_GET['jam1']; ?>&awal=<?= $_GET['awal']; ?>&jam2=<?= $_GET['jam2']; ?>&akhir='+this.value" size="14" required="required" />
        </td>
      </tr>
      <tr>
        <td><strong>Mesin</strong></td>
        <td>:</td>
        <td><select name="nama_mesin" id="nama_mesin" onchange="myFunction();">
            <option value="">Pilih</option>
            <?php $qry1 = db2_exec($conn_db2, "SELECT
                                                  TRIM(CODE) AS CODE, LONGDESCRIPTION
                                                FROM
                                                  RESOURCES r
                                                WHERE
                                                  SUBSTR(CODE, 1,4) = 'P3ST' OR
                                                  SUBSTR(CODE, 1,4) = 'P3CP' OR
                                                  SUBSTR(CODE, 1,4) = 'P3BC' OR CODE = 'P3IN350' OR
                                                  SUBSTR(CODE, 1,4) = 'P3ST' OR SUBSTR(CODE, 1,4) = 'P3DR' OR
                                                  SUBSTR(CODE, 1,4) = 'P3SM'
                                                ORDER BY 
                                                  CODE 
                                                ASC");
            while ($r = db2_fetch_assoc($qry1)) {
            ?>
              <option value="<?php echo $r['CODE']; ?>"><?php echo $r['CODE']; ?> <?php echo $r['LONGDESCRIPTION']; ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><strong>Shift</strong></td>
        <td>:</td>
        <td><label for="shift"></label>
          <select name="shift" id="shift">
            <option value="ALL">ALL</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
          </select>
        </td>
      </tr>
      <tr>
        <td colspan="3"><input type="submit" name="button" id="button" value="Lihat Data" class="art-button" /> <input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='../index.php'" class="art-button" /></td>
      </tr>
    </table>
  </form>
</body>

</html>