<?php
ini_set("error_reporting", 1);
include("../../koneksi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Data Energi</title>
</head>

<body>
  <?php
  if (isset($_POST['btnHapus'])) {
    $hapusSql = "DELETE FROM db_finishing.tbl_tujuan WHERE id='$_POST[id]'";
    sqlsrv_query($con, $hapusSql);

    // Refresh form
    echo "<meta http-equiv='refresh' content='0; url=data-tujuan.php?status=Data Sudah DiHapus'>";
  }
  if (isset($_POST['btnSimpan'])) {
    $tujuan = $_POST['tujuan'];
    $ket = str_replace("'", "", $_POST['ket']);
    $simpanSql = "INSERT INTO db_finishing.tbl_tujuan (tujuan, ket) VALUES ('$tujuan', '$ket')";
    sqlsrv_query($con, $simpanSql);

    // Refresh form
    echo "<meta http-equiv='refresh' content='0; url=data-tujuan.php?status=Data Sudah DiSimpan'>";
  }
  if (isset($_POST['btnUbah'])) {
    $tujuan = $_POST['tujuan'];
    $ket = str_replace("'", "", $_POST['ket']);
    $simpanSql = "UPDATE db_finishing.tbl_tujuan SET 
    tujuan='$tujuan',
    ket='$ket'
    WHERE id='$_POST[id]'";
    sqlsrv_query($con, $simpanSql);

    // Refresh form
    echo "<meta http-equiv='refresh' content='0; url=data-tujuan.php?status=Data Sudah DiUbah'>";
  }
  ?>
  <form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
    <table width="100%" border="0">
      <tr>
        <th colspan="3" scope="row">Input Data Tujuan</th>
      </tr>
      <tr>
        <td colspan="3" align="center" scope="row">
          <font color="#FF0000"><?php echo $_GET['status']; ?></font>
        </td>
      </tr>
      <?php $qtampil = sqlsrv_query($con, "SELECT TOP 1 * FROM db_finishing.tbl_tujuan WHERE tujuan='$_GET[tujuan]' ", array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
      $rt = sqlsrv_fetch_array($qtampil);
      $rc = sqlsrv_num_rows($qtampil);
      ?>
      <tr>
        <td width="21%" scope="row">Tujuan</td>
        <td width="1%">:</td>
        <td width="78%"><label for="tujuan"></label>
          <input type="text" name="tujuan" id="tujuan" onchange="window.location='data-tujuan.php?tujuan='+this.value" value="<?php echo $_GET['tujuan']; ?>" required="required" />
          <input type="hidden" name="id" value="<?php echo $rt['id']; ?>" />
        </td>
      </tr>
      <tr>
        <td valign="top" scope="row">Keterangan</td>
        <td valign="top">:</td>
        <td><label for="ket"></label>
          <textarea name="ket" cols="45" rows="3" id="ket"><?php echo $rt['ket']; ?></textarea>
        </td>
      </tr>
      <tr>
        <th colspan="3" scope="row"><?php if ($rc == 0) { ?><input type="submit" name="btnSimpan" id="btnSimpan" value="Simpan" /><?php } else { ?>
            <input type="submit" name="btnUbah" id="btnUbah" value="Ubah" />
            <input type="submit" name="btnHapus" id="btnHapus" value="Hapus" /><?php } ?>
          <input type="button" name="tutup" id="tutup" value="Tutup" onclick="window.close();" />
        </th>
      </tr>
    </table>
    <h3>Data Detail Tujuan</h3>
    <table width="100%" border="0">
      <tr bgcolor="#0099CC">
        <th scope="row">No</th>
        <th bgcolor="#0099CC">Tujuan</th>
        <th>Keterangan</th>
      </tr>
      <?php
      $qry = sqlsrv_query($con, "SELECT * FROM db_finishing.tbl_tujuan ORDER BY id ASC");
      $no = 1;
      while ($r = sqlsrv_fetch_array($qry)) {
        $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99'; ?>
        <tr bgcolor="<?php echo $bgcolor; ?>">
          <td align="center" scope="row"><?php echo $no; ?></td>
          <td align="center"><?php echo $r['tujuan']; ?></td>
          <td><?php echo $r['ket']; ?></td>
        </tr>
      <?php $no++;
      } ?>
      <tr bgcolor="#0099CC">
        <td scope="row">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>

  </form>
</body>

</html>