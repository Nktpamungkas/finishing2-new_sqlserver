<?php
include("../../koneksi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Data Mesin</title>
</head>

<body>
  <?php
  if (isset($_POST['btnHapus'])) {
    $hapusSql = "DELETE FROM db_finishing.tbl_proses_keluar WHERE id='$_POST[id]'";
    sqlsrv_query($con, $hapusSql);

    // Refresh form
    echo "<meta http-equiv='refresh' content='0; url=data-proses.php?status=Data Sudah DiHapus'>";
  }
  if (isset($_POST['btnSimpan'])) {
    $proses = $_POST['proses'];
    $jns = $_POST['jns'];
    $ket = str_replace("'", "", $_POST['ket']);
    $simpanSql = "INSERT INTO db_finishing.tbl_proses_keluar (proses,jns,ket) VALUES ('$proses','$jns','$ket')";
    sqlsrv_query($con, $simpanSql);

    // Refresh form
    echo "<meta http-equiv='refresh' content='0; url=data-proses.php?status=Data Sudah DiSimpan'>";
  }
  if (isset($_POST['btnUbah'])) {
    $proses = $_POST['proses'];
    $ket = str_replace("'", "", $_POST['ket']);
    $simpanSql = "UPDATE db_finishing.tbl_proses_keluar SET 
    proses='$proses',
    ket='$ket'
    WHERE id='$_POST[id]'";
    sqlsrv_query($con, $simpanSql);

    // Refresh form
    echo "<meta http-equiv='refresh' content='0; url=data-proses.php?status=Data Sudah DiUbah'>";
  }
  ?>
  <form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
    <table width="100%" border="0">
      <tr>
        <th colspan="3" scope="row">Input Data Proses</th>
      </tr>
      <tr>
        <td colspan="3" align="center" scope="row">
          <font color="#FF0000"><?php echo $_GET['status']; ?></font>
        </td>
      </tr>
      <?php $qtampil = sqlsrv_query($con, "SELECT TOP 1 * FROM db_finishing.tbl_proses_keluar WHERE proses='$_GET[proses]' AND jns='$_GET[jns]'", array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
      $rt = sqlsrv_fetch_array($qtampil);
      $rc = sqlsrv_num_rows($qtampil);
      ?>
      <tr>
        <td width="21%" scope="row">Proses</td>
        <td width="1%">:</td>
        <td width="78%"><label for="proses"></label>
          <input type="text" name="proses" id="proses" onchange="window.location='data-proses.php?proses='+this.value" value="<?php echo $_GET['proses']; ?>" required="required" />
          <input type="hidden" name="id" value="<?php echo $rt['id']; ?>" />
        </td>
      </tr>
      <tr>
        <td valign="top" scope="row">Jenis Proses</td>
        <td valign="top">:</td>
        <td><select name="jns" id="jns" onchange="window.location='data-proses.php?proses=<?php echo $_GET['proses']; ?>&jns='+this.value" required="required">
            <option value="" <?php if ($_GET['jns'] == "") {
                                echo "SELECTED";
                              } ?>>Pilih</option>
            <option value="Normal" <?php if ($_GET['jns'] == "Normal") {
                                      echo "SELECTED";
                                    } ?>>Normal</option>
            <option value="Bantu" <?php if ($_GET['jns'] == "Bantu") {
                                    echo "SELECTED";
                                  } ?>>Bantu</option>
            <option value="Khusus" <?php if ($_GET['jns'] == "Khusus") {
                                      echo "SELECTED";
                                    } ?>>Khusus</option>
          </select></td>
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
    <h3>Data Detail Proses</h3>
    <table width="100%" border="0">
      <tr bgcolor="#0099CC">
        <th scope="row">No</th>
        <th bgcolor="#0099CC">No Proses</th>
        <th>Jenis</th>
        <th>Keterangan</th>
      </tr>
      <?php
      $qry = sqlsrv_query($con, "SELECT * FROM db_finishing.tbl_proses_keluar ORDER BY id ASC");
      $no = 1;
      while ($r = sqlsrv_fetch_array($qry)) {
        $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99'; ?>
        <tr bgcolor="<?php echo $bgcolor; ?>">
          <td align="center" scope="row"><?php echo $no; ?></td>
          <td align="center"><?php echo $r['proses']; ?></td>
          <td align="center"><?php echo $r['jns']; ?></td>
          <td><?php echo $r['ket']; ?></td>
        </tr>
      <?php $no++;
      } ?>
      <tr bgcolor="#0099CC">
        <td scope="row">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>

  </form>
</body>

</html>