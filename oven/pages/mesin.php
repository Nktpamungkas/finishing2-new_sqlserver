<?php
ini_set("error_reporting", 1);
session_start();
include("../../koneksi.php");
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Data Mesin</title>
</head>

<body>
    <?php
if(isset($_POST['btnHapus'])){
		$hapusSql = "DELETE FROM db_finishing.tbl_mesin WHERE id='$_POST[id]'";
		sqlsrv_query($con,$hapusSql) or die ("Gagal hapus".sqlsrv_errors());
		
		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=mesin.php?status=Data Sudah DiHapus'>";
	}
if(isset($_POST['btnSimpan'])){
		$mesin=str_replace("'","",$_POST['nama']);
		$ket=str_replace("'","",$_POST['ket']);
	$simpanSql = "INSERT INTO tbl_mesin SET 
	`nama`='$mesin',
	`jenis`='$_POST[jenis]',
	`ket`='$ket'";
		sqlsrv_query($con,$simpanSql) or die ("Gagal Simpan".sqlsrv_errors());
		
		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=mesin.php?status=Data Sudah DiSimpan'>";
	}
if(isset($_POST['btnUbah'])){
		$mesin=str_replace("'","",$_POST['nama']);
		$ket=str_replace("'","",$_POST['ket']);
	$simpanSql = "UPDATE tbl_mesin SET 
	`nama`='$mesin',
	`jenis`='$_POST[jenis]',
	`ket`='$ket'
	WHERE `id`='$_POST[id]'";
		sqlsrv_query($con,$simpanSql) or die ("Gagal Ubah".sqlsrv_errors());
		
		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=mesin.php?status=Data Sudah DiUbah'>";
	}
	?>
    <form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
        <table width="100%" border="0">
            <tr>
                <th colspan="3" scope="row">Input Data Mesin</th>
            </tr>
            <tr>
                <td colspan="3" align="center" scope="row">
                    <font color="#FF0000"><?php echo $_GET['status'];?></font>
                </td>
            </tr>
            <?php $qtampil=sqlsrv_query($con,"SELECT TOP 1 * FROM db_finishing.tbl_mesin WHERE nama='$_GET[nama]'");
	$rt=sqlsrv_fetch_array($qtampil);
	$rc=sqlsrv_num_rows($qtampil);
	?>
            <tr>
                <td width="21%" scope="row">Nama Mesin</td>
                <td width="1%">:</td>
                <td width="78%"><label for="nama"></label>
                    <input type="text" name="nama" id="nama" onchange="window.location='mesin.php?nama='+this.value"
                        value="<?php echo $_GET['nama'];?>" required="required" />
                    <input type="hidden" name="id" value="<?php echo $rt['id'];?>" />
                </td>
            </tr>
            <tr>
                <td scope="row">Jenis</td>
                <td>:</td>
                <td><select name="jenis" id="jenis">
                        <option value="">pilih</option>
                        <option value="oven" <?php if($rt['jenis']=="oven"){echo "SELECTED";} ?>>oven</option>
                        <option value="stenter" <?php if($rt['jenis']=="stenter"){echo "SELECTED";} ?>>stenter</option>
                        <option value="compact" <?php if($rt['jenis']=="compact"){echo "SELECTED";} ?>>compact</option>
                        <option value="belah-lipat" <?php if($rt['jenis']=="belah"){echo "SELECTED";} ?>>belah</option>
                        <option value="belah-lipat" <?php if($rt['jenis']=="lipat"){echo "SELECTED";} ?>>lipat</option>
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
                <th colspan="3" scope="row"><?php if($rc==0){?><input type="submit" name="btnSimpan" id="btnSimpan"
                        value="Simpan" /><?php }else{ ?>
                    <input type="submit" name="btnUbah" id="btnUbah" value="Ubah" />
                    <input type="submit" name="btnHapus" id="btnHapus" value="Hapus" /><?php } ?>
                    <input type="button" name="tutup" id="tutup" value="Tutup" onclick="window.close();" />
                </th>
            </tr>
        </table>
        <h3>Data Detail Nama Mesin</h3>
        <table width="100%" border="0">
            <tr bgcolor="#0099CC">
                <th scope="row">No</th>
                <th bgcolor="#0099CC">Nama Mesin</th>
                <th>Keterangan</th>
            </tr>
            <?php 
  $qry=sqlsrv_query($con,"SELECT * FROM db_finishing.tbl_mesin ORDER BY nama ASC");
  $no=1;
  while($r=sqlsrv_fetch_array($qry))
  {
    $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99'; ?>
            <tr bgcolor="<?php echo $bgcolor;?>">
                <td align="center" scope="row"><?php echo $no;?></td>
                <td align="center"><?php echo $r['nama'];?></td>
                <td><?php echo $r['ket'];?></td>
            </tr>
            <?php $no++;} ?>
            <tr bgcolor="#0099CC">
                <td scope="row">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>

    </form>
</body>

</html>