<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
//request page
$page	= isset($_GET['p'])?$_GET['p']:'';
$act	= isset($_GET['act'])?$_GET['act']:'';
$id		= isset($_GET['id'])?$_GET['id']:'';
$page	= strtolower($page);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US"><head><!-- Created by Artisteer v4.3.0.60745 -->
    <meta charset="utf-8">
    <title>hapus</title>
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">

    <!--[if lt IE 9]><script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link rel="stylesheet" href="../style.css" media="screen">
    <!--[if lte IE 7]><link rel="stylesheet" href="style.ie7.css" media="screen" /><![endif]-->
    <link rel="stylesheet" href="../style.responsive.css" media="all">
</head>
<body>
<?php 
	if(isset($_POST['simpan'])){
	$sqlubah=mysqli_query($con,"UPDATE tbl_adm SET
	`shift_out`='$_POST[shift]',
	`shift1_out`='$_POST[shift2]',
	`tujuan`='$_POST[tujuan]'
	WHERE id='$_GET[id]'") or die("Query Gagal");
	if($sqlubah){
	  echo "<script>alert('Berhasil diubah');window.location.href='?p=reports-adm&tgl1=$_GET[tgl1]&tgl2=$_GET[tgl2]&shift=$_GET[shift]&jenis=$_GET[jenis]';</script>";
	}
	}
	$sql=mysqli_query($con," SELECT 
	* 
FROM
	`tbl_adm`
WHERE id='$_GET[id]' ");
	$rw=mysqli_fetch_array($sql);
?>
<form name="form1" action="" method="post" >
<table width="100%" border="0">
  <tbody>
    <tr>
      <td>Nokk</td>
      <td>:</td>
      <td><?php echo $rw['nokk']; ?></td>
    </tr>
    <tr>
      <td width="9%">Group Shift </td>
      <td width="1%">:</td>
      <td width="90%"><select name="shift" id="shift" required>
        <option value="">Pilih</option>
        <option value="A" <?php if($rw['shift_out']=="A"){echo "selected";} ?>>A</option>
        <option value="B" <?php if($rw['shift_out']=="B"){echo "selected";} ?>>B</option>
        <option value="C" <?php if($rw['shift_out']=="C"){echo "selected";} ?>>C</option>
      </select></td>
    </tr>
    <tr>
      <td>Shift</td>
      <td>:</td>
      <td><select name="shift2" id="shift2" required>
        <option value="">Pilih</option>
        <option value="1" <?php if($rw['shift1_out']=="1"){echo "selected";} ?>>1</option>
        <option value="2" <?php if($rw['shift1_out']=="2"){echo "selected";} ?>>2</option>
        <option value="3" <?php if($rw['shift1_out']=="3"){echo "selected";} ?>>3</option>
      </select></td>
    </tr>
    <tr>
      <td>Tujuan</td>
      <td>:</td>
      <td><select name="tujuan" id="tujuan" required>
        <option value="">Pilih</option>
        <?php $qry1=mysqli_query($con,"SELECT tujuan FROM tbl_tujuan ORDER BY id ASC"); 
		while($r=mysqli_fetch_array($qry1)){
		?>
        <option value="<?php echo $r['tujuan']; ?>" <?php if($rw['tujuan']==$r['tujuan']){echo "selected";}?>><?php echo $r['tujuan'];?></option>
        <?php } ?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input type="submit" name="simpan" id="simpan" value="Simpan" class="art-button"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
</form>

<div class="art-content-layout-row">
<div class="art-layout-cell art-content">
<article class="art-post art-article"> 

<div class="art-postcontent art-postcontent-0 clearfix">
<div class="art-content-layout-wrapper layout-item-0">
<div class="art-content-layout layout-item-1">
<!--script disini -->

 </div>

</div>
</article></div>
                    </div>
</body>
</html>