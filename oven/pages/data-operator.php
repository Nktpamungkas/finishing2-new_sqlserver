<?php
ini_set("error_reporting", 1);
session_start();
include("../../koneksi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Data Staff Acc Keluar Kain</title>
</head>

<body>
<?php
if(isset($_POST['btnHapus'])){
		$hapusSql = "DELETE FROM tbl_staff WHERE id='$_POST[id]'";
		mysqli_query($con,$hapusSql) or die ("Gagal hapus".mysqli_error());
		
		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=data-operator.php?status=Data Sudah DiHapus'>";
	}
if(isset($_POST['btnSimpan'])){
		$nama=str_replace("'","",$_POST['nama']);
		$jabatan=str_replace("'","",$_POST['jabatan']);
	$simpanSql = "INSERT INTO tbl_staff SET 
	`nama`='$nama',
	`jabatan`='$jabatan'";
		mysqli_query($con,$simpanSql) or die ("Gagal Simpan".mysqli_error());
		
		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=data-operator.php?status=Data Sudah DiSimpan'>";
	}
if(isset($_POST['btnUbah'])){
		$nama=str_replace("'","",$_POST['nama']);
		$jabatan=str_replace("'","",$_POST['jabatan']);
	$simpanSql = "UPDATE tbl_staff SET 
	`nama`='$nama',
	`jabatan`='$jabatan'
	WHERE `id`='$_POST[id]'";
		mysqli_query($con,$simpanSql) or die ("Gagal Ubah".mysqli_error());
		
		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=data-operator.php?status=Data Sudah DiUbah'>";
	}
	?>
<form id="form1" name="form1" method="post" action=""  enctype="multipart/form-data">
<table width="100%" border="0">
  <tr>
    <th colspan="3" scope="row">Input Data Operator</th>
  </tr>
  <tr>
    <td colspan="3" align="center" scope="row"><font color="#FF0000"><?php echo $_GET['status'];?></font></td>
    </tr>
    <?php $qtampil=mysqli_query($con,"SELECT * FROM tbl_staff WHERE nama='$_GET[nama]' LIMIT 1");
	$rt=mysqli_fetch_array($qtampil);
	$rc=mysqli_num_rows($qtampil);
	?>
  <tr>
    <td width="21%" scope="row">Nama</td>
    <td width="1%">:</td>
    <td width="78%"><label for="nama"></label>
      <input type="text" name="nama" id="nama" onchange="window.location='data-operator.php?nama='+this.value" value="<?php echo $_GET['nama'];?>" required="required"/>
      <input type="hidden" name="id" value="<?php echo $rt['id'];?>"/></td>
  </tr>
  <tr>
    <td valign="top" scope="row">Jabatan</td>
    <td valign="top">:</td>
    <td><label for="jabatan"></label>
      <input name="jabatan" type="text" id="jabatan" value="<?php echo $rt['jabatan']; ?>" size="45" /></td>
  </tr>
  <tr>
    <th colspan="3" scope="row"><?php if($rc==0){?><input type="submit" name="btnSimpan" id="btnSimpan" value="Simpan" /><?php }else{ ?>
      <input type="submit" name="btnUbah" id="btnUbah" value="Ubah" />
      <input type="submit" name="btnHapus" id="btnHapus" value="Hapus" /><?php } ?>
<input type="button" name="tutup" id="tutup" value="Tutup" onclick="window.close();"/></th>
  </tr>
</table>
<h3>Data Detail Operator</h3>
<table width="100%" border="0">
  <tr bgcolor="#0099CC">
    <th scope="row">No</th>
    <th bgcolor="#0099CC">Nama</th>
    <th>Jabatan</th>
    </tr>
  <?php 
  $qry=mysqli_query($con,"SELECT * FROM tbl_staff ORDER BY id ASC");
  $no=1;
  while($r=mysqli_fetch_array($qry))
  {
    $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99'; ?>
  <tr bgcolor="<?php echo $bgcolor;?>">
    <td align="center" scope="row"><?php echo $no;?></td>
    <td align="center"><?php echo $r['nama'];?></td>
    <td><?php echo $r['jabatan'];?></td>
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