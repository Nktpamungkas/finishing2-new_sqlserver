<?php
ini_set("error_reporting", 1);
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
	$sqlhapus=mysqli_query($con,"DELETE FROM tbl_produksi WHERE id='$_GET[id]'") or die("Query Gagal");
	if($sqlhapus){
	  echo "<script>alert('Berhasil dihapus');window.location.href='?p=reports&tgl1=$_GET[tgl1]&tgl2=$_GET[tgl2]&shift=$_GET[shift]&msn=$_GET[msn]';</script>";
	}
		
	
?>
</body>
</html>