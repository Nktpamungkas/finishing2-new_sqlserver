<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=report-adm2-".$_GET['jenis'].".xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");
//disini script laporan anda
?>
<?php 
ini_set("error_reporting", 1);
include ('../../koneksi.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan IN-OUT Kartu Kerja Finishing</title>
</head>

<body>
<?php 
if($_GET['jenis']=="Kurang"){
?>
<form id="form1" name="form1" method="post" action="">
  <strong>Kartu Kerja Masuk: Kurang Dari Dua Hari</strong>
  <table width="100%" border="0" >
    <tr style="border:1px solid;">
      <td bgcolor="#99FF99" style="border:1px solid; vertical-align:middle;"><div align="center"><strong><font size="-2">NO.</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">TGL MASUK</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">JAM MASUK</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">SHIFT</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">NOKK</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">LANGGANAN</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">ORDER</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">HANGER</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">JENIS KAIN</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">NO WARNA</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">WARNA</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">LOT</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">ROLL</font></strong></div></td>
      <td bgcolor="#99FF99"style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">QTY (Kg)</font></strong></div></td>
      <td bgcolor="#99FF99"style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">QTY (yard)</font></strong></div></td>
      <td bgcolor="#99FF99"style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">PROSES</font></strong></div></td>
      <td bgcolor="#99FF99"style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">KONDISI KAIN</font></strong></div></td>
    </tr>
    <?php 
	
		$sql=mysqli_query($con," SELECT 
	*,`id` as `idp` 
FROM
	`tbl_adm`
WHERE
	`status`='1' and DATEDIFF(now(),tgl_in) < 3 ORDER BY `tgl_in` ASC ");
   $no=1;
   $c=0;
    while($rowd=mysqli_fetch_array($sql)){
		 $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
	  		  ?>
      <tr style="border:1px solid;">
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo $no;?></font></div></td>
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo date('Y-m-d', strtotime($rowd['tgl_in']));?></font></div></td>
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo date('H:i', strtotime($rowd['tgl_in']));?></font></div></td>
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo $rowd['shift'].$rowd['shift1'];?></font></div></td>
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo $rowd['nokk'];?></font></div></td>
      <td style="border:1px solid;"><font size="-2"><b title="<?php echo $rowd['langganan'];?>"><?php echo substr($rowd['langganan'],0,20)."..";?></b></font></td>
      <td style="border:1px solid;"><font size="-2"><?php echo $rowd['no_order']; ?></font></td>
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo $rowd['no_item'];?></font></div></td>
      <td style="border:1px solid;"><font size="-2"><b title="<?php echo $rowd['jenis_kain'];?>"><?php echo substr($rowd['jenis_kain'],0,20)."..";?></b></font></td>
      <td style="border:1px solid;"><font size="-2"><b title="<?php echo $rowd['warna']; ?>"><?php echo substr($rowd['no_warna'],0,10).".."; ?></b></font></td>
      <td style="border:1px solid;"><font size="-2"><b title="<?php echo $rowd['warna']; ?>"><?php echo substr($rowd['warna'],0,10).".."; ?></b></font></td>
      <td style="border:1px solid;"><div align="center"><font size="-2">'<?php echo $rowd['lot']; ?></font></div></td>
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo $rowd['rol']; ?></font></div></td>
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo $rowd['qty']; ?></font></div></td>
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo $rowd['panjang']; ?></font></div></td>
      <td style="border:1px solid;"><font size="-2"><?php echo $rowd['proses']; ?></font></td>
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo $rowd['kondisi_kain']; ?></font></div></td>
    </tr>
     <?php 
	 
	 $no++;} ?>
    <tr style="border:1px solid;">
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
    </tr>
    <tr style="border:1px solid;">
      <td colspan="9" bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99"><strong>Total</strong></td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99"><strong><?php echo $totqty;?></strong></td>
      <td bgcolor="#99FF99"><strong><?php echo $totberat;?></strong></td>
      <td bgcolor="#99FF99"><strong><?php echo $totyard;?></strong></td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
    </tr>
  </table>
</form>
<?php }else if($_GET['jenis']=="Lebih") { 
?>
<form id="form1" name="form1" method="post" action="">
  <strong>Kartu Kerja Masuk: Lebih Dari Dua Hari</strong>
  <table width="100%" border="0" >
    <tr style="border:1px solid;">
      <td bgcolor="#99FF99" style="border:1px solid; vertical-align:middle;"><div align="center"><strong><font size="-2">NO.</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">TGL MASUK</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">JAM MASUK</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">SHIFT</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">NOKK</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">LANGGANAN</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">ORDER</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">HANGER</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">JENIS KAIN</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">NO WARNA</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">WARNA</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">LOT</font></strong></div></td>
      <td bgcolor="#99FF99" style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">ROLL</font></strong></div></td>
      <td bgcolor="#99FF99"style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">QTY (Kg)</font></strong></div></td>
      <td bgcolor="#99FF99"style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">QTY (yard)</font></strong></div></td>
      <td bgcolor="#99FF99"style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">PROSES</font></strong></div></td>
      <td bgcolor="#99FF99"style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">KONDISI KAIN</font></strong></div></td>
    </tr>
    <?php 
	
		$sql=mysqli_query($con," SELECT 
	*,`id` as `idp` 
FROM
	`tbl_adm`
WHERE
	`status`='1' and DATEDIFF(now(),tgl_in) > 2 ORDER BY `tgl_in` ASC ");
   $no=1;
   $c=0;
    while($rowd=mysqli_fetch_array($sql)){
		 $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
	  		  ?>
      <tr style="border:1px solid;">
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo $no;?></font></div></td>
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo date('Y-m-d', strtotime($rowd['tgl_in']));?></font></div></td>
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo date('H:i', strtotime($rowd['tgl_in']));?></font></div></td>
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo $rowd['shift'].$rowd['shift1'];?></font></div></td>
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo $rowd['nokk'];?></font></div></td>
      <td style="border:1px solid;"><font size="-2"><b title="<?php echo $rowd['langganan'];?>"><?php echo substr($rowd['langganan'],0,20)."..";?></b></font></td>
      <td style="border:1px solid;"><font size="-2"><?php echo $rowd['no_order']; ?></font></td>
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo $rowd['no_item'];?></font></div></td>
      <td style="border:1px solid;"><font size="-2"><b title="<?php echo $rowd['jenis_kain'];?>"><?php echo substr($rowd['jenis_kain'],0,20)."..";?></b></font></td>
      <td style="border:1px solid;"><font size="-2"><b title="<?php echo $rowd['warna']; ?>"><?php echo substr($rowd['no_warna'],0,10).".."; ?></b></font></td>
      <td style="border:1px solid;"><font size="-2"><b title="<?php echo $rowd['warna']; ?>"><?php echo substr($rowd['warna'],0,10).".."; ?></b></font></td>
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo $rowd['lot']; ?></font></div></td>
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo $rowd['rol']; ?></font></div></td>
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo $rowd['qty']; ?></font></div></td>
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo $rowd['panjang']; ?></font></div></td>
      <td style="border:1px solid;"><font size="-2"><?php echo $rowd['proses']; ?></font></td>
      <td style="border:1px solid;"><div align="center"><font size="-2"><?php echo $rowd['kondisi_kain']; ?></font></div></td>
    </tr>
     <?php 
	 
	 $no++;} ?>
    <tr style="border:1px solid;">
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
       <td bgcolor="#99FF99">&nbsp;</td>
    </tr>
    <tr style="border:1px solid;">
      <td colspan="9" bgcolor="#99FF99"><strong>Jumlah Data : <?php echo $jml; ?>
      </strong></td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99"><strong>Total</strong></td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99"><strong><?php echo $totqty;?></strong></td>
      <td bgcolor="#99FF99"><strong><?php echo $totberat;?></strong></td>
      <td bgcolor="#99FF99"><strong><?php echo $totyard;?></strong></td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
    </tr>
  </table>
</form>

<?php }?>

</body>
</html>