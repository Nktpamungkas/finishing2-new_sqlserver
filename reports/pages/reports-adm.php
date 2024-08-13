<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan IN-OUT Kartu Kerja Finishing</title>
<link rel="stylesheet" type="text/css" href="../css/datatable.css" />
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" />
<script src="../js/jquery.js" type="text/javascript"></script>
<script src="../js/jquery.dataTables.js" type="text/javascript"></script>
<script>
function confirmDelete(url) {
    if (confirm("Yakin Hapus data ini?")) {
        window.location.href=url;
    } else {
        false;
    }       
}
	function confirmEdit(url) {
    if (confirm("Ubah data ini?")) {
        window.location.href=url;
    } else {
        false;
    }       
}
	$(document).ready(function(){
		$('#datatables').dataTable({
			"sScrollY": "300px",
			"sScrollX": "100%",
			"bScrollCollapse": true,
			"bPaginate": false,
			"bJQueryUI": true
		});			
	})
</script>
</head>

<body>
<?php 
ini_set("error_reporting", 1);
session_start();
include ('../koneksi.php'); 
if($_POST['jenis']=="Kartu IN" or $_GET['jenis']=="Kartu IN"){
?>
<?php
if($_POST['awal']!=""){
	$tglawal=$_POST['awal'];
	$tglakhir=$_POST['akhir'];
	$jns=$_POST['jenis'];
	}
	else{
	$tglawal=$_GET['tgl1'];
	$tglakhir=$_GET['tgl2'];
	$jns=$_GET['jenis'];	
		}
		if($_POST['shift']!=""){$shft=$_POST['shift'];}
		else{$shft=$_GET['shift'];}
	if($tglakhir != "" and $tglawal != "")
		{$tgl=" DATE_FORMAT(`tgl_in`,'%Y-%m-%d') BETWEEN '$tglawal' AND '$tglakhir' ";}else{$tgl=" ";}
	if($shft=="ALL"){ $shift=" ";}else{$shift=" AND `shift1`='$shft' ";}

?>
<input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='index.php'" class="art-button"/>
<input type="hidden" name="button3" id="button3" value="Cetak" onclick="window.open('pages/reports-adm-cetak.php?tglawal=<?php echo $tglawal; ?>&amp;tglakhir=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>', '_blank')" class="art-button"/>
<input type="button" name="button" id="button" value="Cetak Ke Excel" onClick="window.location.href='pages/reports-adm-excel.php?tgl1=<?php echo $tglawal; ?>&amp;tgl2=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>&amp;jenis=<?php echo $jns; ?>'" class="art-button"/>
<br />
<strong><br />
</strong>
<form id="form1" name="form1" method="post" action="">
<strong>  Periode: <?php echo $tglawal; ?> s/d <?php echo $tglakhir; ?></strong><br />
<strong>Shift: <?php echo $shft;?></strong>
<strong><br />
Kartu Kerja IN</strong>
<table width="100%" border="0" id="datatables" class="display">
   <thead>
    <tr>
      <th width="7%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">TGL MASUK</font></strong></div></th>
      <th width="7%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">JAM MASUK</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">SHIFT</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">NOKK</font></strong></div></th>
      <th width="8%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">LANGGANAN</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">ORDER</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">HANGER</font></strong></div></th>
      <th width="7%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">JENIS KAIN</font></strong></div></th>
      <th width="7%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">NO WARNA</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">WARNA</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">LOT</font></strong></div></th>
      <th width="3%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">ROLL</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99"><div align="center"><strong><font size="-2">QTY (Kg)</font></strong></div></th>
      <th width="6%" bgcolor="#99FF99"><div align="center"><strong><font size="-2">QTY (yard)</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99"><div align="center"><strong><font size="-2">PROSES</font></strong></div></th>
      <th width="9%" bgcolor="#99FF99"><div align="center"><strong><font size="-2">KONDISI KAIN</font></strong></div></th>
      <th width="9%" bgcolor="#99FF99"><div align="center"><strong><font size="-2">KETERANGAN</font></strong></div></th>
      <th width="9%" bgcolor="#99FF99"><div align="center"><strong><font size="-2">AKSI</font></strong></div></th>
    </tr>
    </thead>
    <tbody>
    <?php 
	
		$sql=mysqli_query($con," SELECT 
	*,`id` as `idp` 
FROM
	`tbl_adm`
WHERE
	`status`='1' AND ".$tgl.$shift." ORDER BY `tgl_in` ASC ");
   if($hal>0){
   $no=$hal+1;}else
   {$no=1;}
   
   $c=0;
    while($rowd=mysqli_fetch_array($sql)){
		 $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
	  		  ?>
      <tr >
      <td ><div align="center"><?php echo date('Y-m-d', strtotime($rowd['tgl_in']));?></div></td>
      <td ><div align="center"><?php echo date('H:i', strtotime($rowd['tgl_in']));?></div></td>
      <td ><div align="center"><?php echo $rowd['shift'].$rowd['shift1'];?></div></td>
      <td ><div align="center"><?php echo $rowd['nokk'];?></div></td>
      <td ><?php echo $rowd['langganan'];?></td>
      <td ><?php echo $rowd['no_order']; ?></td>
      <td ><div align="center"><?php echo $rowd['no_item'];?></div></td>
      <td ><?php echo $rowd['jenis_kain']; ?></td>
      <td ><?php echo $rowd['no_warna']; ?></td>
      <td ><?php echo $rowd['warna']; ?></td>
      <td ><div align="center"><?php echo $rowd['lot']; ?></div></td>
      <td ><div align="center"><?php echo $rowd['rol']; ?></div></td>
      <td ><div align="center"><?php echo $rowd['qty']; ?></div></td>
      <td ><div align="center"><?php echo $rowd['panjang']; ?></div></td>
      <td ><?php echo $rowd['proses']; ?></td>
      <td ><div align="center"><?php echo $rowd['kondisi_kain']; ?></div></td>
      <td ><?php echo $rowd['catatan']; ?></td>
      <td ><input type="button" name="hapus" id="hapus" value="Hapus" onClick="confirmDelete('?p=hapus-report&id=<?php echo $rowd['idp'];?>&tgl1=<?php echo $tglawal;?>&tgl2=<?php echo $tglakhir;?>&shift=<?php echo $shft;?>&jenis=Kartu IN');"/></td>
    </tr>
     <?php 
	 $totqty=$totqty+$rowd['rol'];
	 $totberat=$totberat+$rowd['qty'];
	 $totyard=$totyard+$rowd['panjang'];
	 $no++;} ?>
   </tbody>
   <tfoot>
    <tr >
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
      <td bgcolor="#99FF99"><strong>Total</strong></td>
      <td bgcolor="#99FF99"><strong><?php echo $totqty;?></strong></td>
      <td bgcolor="#99FF99"><strong><?php echo $totberat;?></strong></td>
      <td bgcolor="#99FF99"><strong><?php echo $totyard;?></strong></td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
    </tr>
    </tfoot>
  </table>
</form>
<?php }else if($_POST['jenis']=="Kartu OUT" or $_GET['jenis']=="Kartu OUT") { 
	
	if($_POST['awal']!=""){
	$tglawal=$_POST['awal'];
	$tglakhir=$_POST['akhir'];
	$jns=$_POST['jenis'];
	}
	else{
	$tglawal=$_GET['tgl1'];
	$tglakhir=$_GET['tgl2'];
	$jns=$_GET['jenis'];	
		}
		if($_POST['shift']!=""){$shft=$_POST['shift'];}
		else{$shft=$_GET['shift'];}
	if($tglakhir != "" and $tglawal != "")
		{$tgl=" DATE_FORMAT(`tgl_out`,'%Y-%m-%d') BETWEEN '$tglawal' AND '$tglakhir' ";}else{$tgl=" ";}
	if($shft=="ALL"){ $shift=" ";}else{$shift=" AND `shift1_out`='$shft' ";}
?>
<input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='index.php'" class="art-button"/>
<input type="hidden" name="button3" id="button3" value="Cetak" onclick="window.open('pages/reports-adm-cetak.php?tglawal=<?php echo $tglawal; ?>&amp;tglakhir=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>', '_blank')" class="art-button"/>
<input type="button" name="button" id="button" value="Cetak Ke Excel" onClick="window.location.href='pages/reports-adm-excel.php?tgl1=<?php echo $tglawal; ?>&amp;tgl2=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>&amp;jenis=<?php echo $jns; ?>'" class="art-button"/>
<br />
<strong><br />
</strong>
<form id="form1" name="form1" method="post" action="">
<strong>  Periode: <?php echo $tglawal; ?> s/d <?php echo $tglakhir; ?></strong><br />
<strong>Shift: <?php echo $shft;?></strong>
<strong><br />
Kartu Kerja OUT</strong>
<table width="100%" border="0" id="datatables" class="display" >
   <thead>
    <tr >
      <th width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">TGL MASUK</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">JAM MASUK</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">TGL KELUAR</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">JAM KELUAR</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">SHIFT MASUK</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">SHIFT KELUAR</font></strong></div></th>
      <th width="3%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">NOKK</font></strong></div></th>
      <th width="6%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">LANGGANAN</font></strong></div></th>
      <th width="3%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">ORDER</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">HANGER</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">JENIS KAIN</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">NO WARNA</font></strong></div></th>
      <th width="3%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">WARNA</font></strong></div></th>
      <th width="3%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">LOT</font></strong></div></th>
      <th width="3%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">ROLL</font></strong></div></th>
      <th width="3%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">QTY (Kg)</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">QTY (yard)</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">KONDISI KAIN</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">TOTAL JAM</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">TOTAL HARI</font></strong></div></th>
      <th width="9%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">PROSES DEPT. BERIKUTNYA</font></strong></div></th>
      <th width="9%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">KETERANGAN</font></strong></div></th>
      <th width="9%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">AKSI</font></strong></div></th>
    </tr>
    </thead>
    <tbody>
    <?php 
	
		$sql=mysqli_query($con," SELECT 
	*,`id` as `idp`,DATEDIFF(tgl_out,tgl_in) as 'Hari', TIMEDIFF(tgl_out,tgl_in) as 'Jam' 
FROM
	`tbl_adm`
WHERE
	`status`='2' AND ".$tgl.$shift." ORDER BY `tgl_in` ASC ");
   $no=1;
   $c=0;
    while($rowd=mysqli_fetch_array($sql)){
		 $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
	  		  ?>
      <tr >
      <td ><div align="center"><font size="-2"><?php echo date('Y-m-d', strtotime($rowd['tgl_in']));?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo date('H:i', strtotime($rowd['tgl_in']));?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo date('Y-m-d', strtotime($rowd['tgl_out']));?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo date('H:i', strtotime($rowd['tgl_out']));?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo $rowd['shift'].$rowd['shift1'];?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo $rowd['shift_out'].$rowd['shift1_out'];?></font></div></td>
      <td ><div align="center"><?php echo $rowd['nokk'];?></div></td>
      <td ><?php echo $rowd['langganan'];?></td>
      <td ><?php echo $rowd['no_order']; ?></td>
      <td ><div align="center"><?php echo $rowd['no_item'];?></div></td>
      <td ><?php echo $rowd['jenis_kain'];?></td>
      <td ><?php echo $rowd['no_warna']; ?></td>
      <td ><?php echo $rowd['warna']; ?></td>
      <td ><div align="center"><?php echo $rowd['lot']; ?></div></td>
      <td ><div align="center"><?php echo $rowd['rol']; ?></div></td>
      <td ><div align="center"><?php echo $rowd['qty']; ?></div></td>
      <td ><div align="center"><?php echo $rowd['panjang']; ?></div></td>
      <td ><div align="center"><?php echo $rowd['kondisi_kain']; ?></div></td>
      <td ><div align="center"><?php 
$awal  = strtotime($rowd['tgl_in']);
$akhir = strtotime($rowd['tgl_out']);
$diff  = ($akhir - $awal);

$jam   = floor($diff / (60 * 60));
$menit = $diff - $jam * (60 * 60);
$tjam=round($diff / (60 * 60),2);
$hari	 =round($tjam/24,2);
?><font size="-2" <?php if($jam < 0) {?> color="#E91013" <?php } ?>><?php echo $jam .  'H,' . floor( $menit / 60 ) . 'M';?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo $hari; ?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo $rowd['tujuan']; ?></font></div></td>
      <td ><font size="-2"><b title="<?php echo $rowd['warna']; ?>"><?php echo $rowd['catatan']; ?></b></font></td>
      <td ><input type="button" name="hapus" id="hapus" value="Hapus" onClick="confirmDelete('?p=hapus-report&id=<?php echo $rowd['idp'];?>&tgl1=<?php echo $tglawal;?>&tgl2=<?php echo $tglakhir;?>&shift=<?php echo $shft;?>&jenis=Kartu OUT');"/>
        <input type="button" name="ubah" id="ubah" value="ubah" onclick="confirmEdit('?p=edit-report&amp;id=<?php echo $rowd['idp'];?>&amp;tgl1=<?php echo $tglawal;?>&amp;tgl2=<?php echo $tglakhir;?>&amp;shift=<?php echo $shft;?>&amp;jenis=Kartu OUT');"/></td>
    </tr>
     <?php 
	 $totqty=$totqty+$rowd['rol'];
	 $totberat=$totberat+$rowd['qty'];
	 $totyard=$totyard+$rowd['panjang'];
	 $totjam=$totjam+$diff;	
	 $tothari=$tothari+$hari;	
	 $no++;} ?>
   </tbody>
   <tfoot>
    <tr >
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
      <td bgcolor="#99FF99"><strong>Total</strong></td>
      <td bgcolor="#99FF99"><strong><?php echo $totqty;?></strong></td>
      <td bgcolor="#99FF99"><strong><?php echo $totberat;?></strong></td>
      <td bgcolor="#99FF99"><strong><?php echo $totyard;?></strong></td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">
<?php $jam1   = floor($totjam / (60 * 60));
$menit1 = $totjam - $jam1 * (60 * 60);
echo $jam1 .  'H,' . floor( $menit1 / 60 ) . 'M';?></td>
      <td bgcolor="#99FF99"><strong><?php echo $tothari;?></strong></td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
    </tr>
    </tfoot>
  </table>
</form>
<?php }else if($_POST['jenis']=="Detail Kartu In" or $_GET['jenis']=="Detail Kartu In") { 
	
	if($_POST['awal']!=""){
	$tglawal=$_POST['awal'];
	$tglakhir=$_POST['akhir'];
	$jns=$_POST['jenis'];
	}
	else{
	$tglawal=$_GET['tgl1'];
	$tglakhir=$_GET['tgl2'];
	$jns=$_GET['jenis'];	
		}
		if($_POST['shift']!=""){$shft=$_POST['shift'];}
		else{$shft=$_GET['shift'];}
	if($tglakhir != "" and $tglawal != "")
		{$tgl=" DATE_FORMAT(`tgl_in`,'%Y-%m-%d') BETWEEN '$tglawal' AND '$tglakhir' ";}else{$tgl=" ";}
	if($shft=="ALL"){ $shift=" ";}else{$shift=" AND `shift1`='$shft' ";}

?>
<input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='index.php'" class="art-button"/>
<input type="hidden" name="button3" id="button3" value="Cetak" onclick="window.open('pages/reports-adm-cetak.php?tglawal=<?php echo $tglawal; ?>&amp;tglakhir=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>', '_blank')" class="art-button"/>
<input type="button" name="button" id="button" value="Cetak Ke Excel" onClick="window.location.href='pages/reports-adm-excel.php?tgl1=<?php echo $tglawal; ?>&amp;tgl2=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>&amp;jenis=<?php echo $jns; ?>'" class="art-button"/>
<br />
<strong><br />
</strong>
<form id="form1" name="form1" method="post" action="">
<strong>  Periode: <?php echo $tglawal; ?> s/d <?php echo $tglakhir; ?></strong><br />
<strong>Shift: <?php echo $shft;?></strong>
<strong><br />
Detail Kartu Kerja IN</strong>
<table width="100%" border="0" id="datatables" class="display">
   <thead>
    <tr>
      <th width="7%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">TGL MASUK</font></strong></div></th>
      <th width="7%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">JAM MASUK</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">SHIFT</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">TGL KELUAR</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">JAM KELUAR</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">SHIFT</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">NOKK</font></strong></div></th>
      <th width="8%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">LANGGANAN</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">ORDER</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">HANGER</font></strong></div></th>
      <th width="7%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">JENIS KAIN</font></strong></div></th>
      <th width="7%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">NO WARNA</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">WARNA</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">LOT</font></strong></div></th>
      <th width="3%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">ROLL</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99"><div align="center"><strong><font size="-2">QTY (Kg)</font></strong></div></th>
      <th width="6%" bgcolor="#99FF99"><div align="center"><strong><font size="-2">QTY (yard)</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99"><div align="center"><strong><font size="-2">PROSES</font></strong></div></th>
      <th width="9%" bgcolor="#99FF99"><div align="center"><strong><font size="-2">KONDISI KAIN</font></strong></div></th>
      <th width="9%" bgcolor="#99FF99"><div align="center"><strong><font size="-2">KETERANGAN</font></strong></div></th>
      <th width="9%" bgcolor="#99FF99"><div align="center"><strong><font size="-2">Status</font></strong></div></th>
    </tr>
    </thead>
    <tbody>
    <?php 
	
		$sql=mysqli_query($con," SELECT 
	*,`id` as `idp` 
FROM
	`tbl_adm`
WHERE
	(`status`='1' or `status`='2') AND ".$tgl.$shift." ORDER BY `tgl_in` ASC ");
   if($hal>0){
   $no=$hal+1;}else
   {$no=1;}
   
   $c=0;
    while($rowd=mysqli_fetch_array($sql)){
		 $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
	  		  ?>
      <tr >
      <td ><div align="center"><?php echo date('Y-m-d', strtotime($rowd['tgl_in']));?></div></td>
      <td ><div align="center"><?php echo date('H:i', strtotime($rowd['tgl_in']));?></div></td>
      <td ><div align="center"><?php echo $rowd['shift'].$rowd['shift1'];?></div></td>
      <td ><div align="center"><?php if($rowd['tgl_out']!=null){echo date('Y-m-d', strtotime($rowd['tgl_out']));} ?></div></td>
      <td ><div align="center"><?php if($rowd['tgl_out']!=null){echo date('H:i', strtotime($rowd['tgl_out']));}?></div></td>
      <td ><div align="center"><?php if($rowd['tgl_out']!=null){echo $rowd['shift_out'].$rowd['shift1_out'];}?></div></td>
      <td ><div align="center"><?php echo $rowd['nokk'];?></div></td>
      <td ><?php echo $rowd['langganan'];?></td>
      <td ><?php echo $rowd['no_order']; ?></td>
      <td ><div align="center"><?php echo $rowd['no_item'];?></div></td>
      <td ><?php echo $rowd['jenis_kain']; ?></td>
      <td ><?php echo $rowd['no_warna']; ?></td>
      <td ><?php echo $rowd['warna']; ?></td>
      <td ><div align="center"><?php echo $rowd['lot']; ?></div></td>
      <td ><div align="center"><?php echo $rowd['rol']; ?></div></td>
      <td ><div align="center"><?php echo $rowd['qty']; ?></div></td>
      <td ><div align="center"><?php echo $rowd['panjang']; ?></div></td>
      <td ><?php echo $rowd['proses']; ?></td>
      <td ><div align="center"><?php echo $rowd['kondisi_kain']; ?></div></td>
      <td ><?php echo $rowd['catatan']; ?></td>
      <td ><div align="center"><font size="-2">
        <?php if($rowd['status']=="2"){ echo "<font color='red'>Kartu Sudah Keluar Ke ".$rowd['tujuan']."</font>";}?>
      </font></div></td>
    </tr>
     <?php 
	 $totqty=$totqty+$rowd['rol'];
	 $totberat=$totberat+$rowd['qty'];
	 $totyard=$totyard+$rowd['panjang'];
	 $no++;} ?>
   </tbody>
   <tfoot>
    <tr >
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
      <td bgcolor="#99FF99"><strong>Total</strong></td>
      <td bgcolor="#99FF99"><strong><?php echo $totqty;?></strong></td>
      <td bgcolor="#99FF99"><strong><?php echo $totberat;?></strong></td>
      <td bgcolor="#99FF99"><strong><?php echo $totyard;?></strong></td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
    </tr>
    </tfoot>
  </table>
</form>
<?php }else if($_POST['jenis']=="Kartu Kurang" or $_GET['jenis']=="Kartu Kurang") { 
	
	if($_POST['awal']!=""){
	$tglawal=$_POST['awal'];
	$tglakhir=$_POST['akhir'];
	$jns=$_POST['jenis'];
	}
	else{
	$tglawal=$_GET['tgl1'];
	$tglakhir=$_GET['tgl2'];
	$jns=$_GET['jenis'];	
		}
		if($_POST['shift']!=""){$shft=$_POST['shift'];}
		else{$shft=$_GET['shift'];}
	if($tglakhir != "" and $tglawal != "")
		{$tgl=" DATE_FORMAT(`tgl_out`,'%Y-%m-%d') BETWEEN '$tglawal' AND '$tglakhir' ";}else{$tgl=" ";}
	if($shft=="ALL"){ $shift=" ";}else{$shift=" AND `shift1_out`='$shft' ";}
$row = 100;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = " SELECT 
	*
FROM
	`tbl_adm` 
WHERE
	`status`='2' AND DATEDIFF(tgl_out,tgl_in) < 3 AND ".$tgl.$shift." ORDER BY `tgl_in` ASC ";
$pageQry = mysqli_query($con,$pageSql) or die ("error: ".mysqli_error());
$jml	 = mysqli_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='index.php'" class="art-button"/>
<input type="hidden" name="button3" id="button3" value="Cetak" onclick="window.open('pages/reports-adm-cetak.php?tglawal=<?php echo $tglawal; ?>&amp;tglakhir=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>', '_blank')" class="art-button"/>
<input type="button" name="button" id="button" value="Cetak Ke Excel" onClick="window.location.href='pages/reports-adm-excel.php?tgl1=<?php echo $tglawal; ?>&amp;tgl2=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>&amp;jenis=<?php echo $jns; ?>'" class="art-button"/>
<br />
<strong><br />
</strong>
<form id="form1" name="form1" method="post" action="">
<strong>  Periode: <?php echo $tglawal; ?> s/d <?php echo $tglakhir; ?></strong><br />
<strong>Shift: <?php echo $shft;?></strong>
<strong><br />
Kartu Kerja Selesai Proses Kurang Dari 2 Hari</strong>
<table width="100%" border="0" id="datatables" class="display">
   <thead>
    <tr >
      <th width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">TGL MASUK</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">JAM MASUK</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">TGL KELUAR</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">JAM KELUAR</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">SHIFT MASUK</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">SHIFT KELUAR</font></strong></div></th>
      <th width="3%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">NOKK</font></strong></div></th>
      <th width="6%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">LANGGANAN</font></strong></div></th>
      <th width="3%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">ORDER</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">HANGER</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">JENIS KAIN</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">NO WARNA</font></strong></div></th>
      <th width="3%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">WARNA</font></strong></div></th>
      <th width="2%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">LOT</font></strong></div></th>
      <th width="3%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">ROLL</font></strong></div></th>
      <th width="3%" bgcolor="#99FF99"><div align="center"><strong><font size="-2">QTY (Kg)</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99"><div align="center"><strong><font size="-2">QTY (yard)</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99"><div align="center"><strong><font size="-2">KONDISI KAIN</font></strong></div></th>
      <th width="4%" bgcolor="#99FF99"><div align="center"><strong><font size="-2">TOTAL JAM</font></strong></div></th>
      <th width="5%" bgcolor="#99FF99"><div align="center"><strong><font size="-2">TOTAL HARI</font></strong></div></th>
      <th width="7%" bgcolor="#99FF99"><div align="center"><strong><font size="-2">PROSES DEPT. BERIKUTNYA</font></strong></div></th>
      <th width="7%" bgcolor="#99FF99"><div align="center"><strong><font size="-2">KETERANGAN</font></strong></div></th>
      </tr>
    </thead>
    <tbody>
    <?php 
	
		$sql=mysqli_query($con," SELECT 
	*,`id` as `idp`,DATEDIFF(tgl_out,tgl_in) as 'Hari', TIMEDIFF(tgl_out,tgl_in) as 'Jam' 
FROM
	`tbl_adm`
WHERE
	`status`='2' AND DATEDIFF(tgl_out,tgl_in) < 3 AND ".$tgl.$shift." ORDER BY `tgl_in` ASC ");
   if($hal>0){
   $no=$hal+1;}else
   {$no=1;}
   
   $c=0;
    while($rowd=mysqli_fetch_array($sql)){
		 $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
	  		  ?>
      <tr >
      <td ><div align="center"><?php echo date('Y-m-d', strtotime($rowd['tgl_in']));?></div></td>
      <td ><div align="center"><?php echo date('H:i', strtotime($rowd['tgl_in']));?></div></td>
      <td ><div align="center"><?php echo date('Y-m-d', strtotime($rowd['tgl_out']));?></div></td>
      <td ><div align="center"><?php echo date('H:i', strtotime($rowd['tgl_out']));?></div></td>
      <td ><div align="center"><?php echo $rowd['shift'].$rowd['shift1'];?></div></td>
      <td ><div align="center"><?php echo $rowd['shift_out'].$rowd['shift1_out'];?></div></td>
      <td ><div align="center"><?php echo $rowd['nokk'];?></div></td>
      <td ><?php echo $rowd['langganan'];?></td>
      <td ><?php echo $rowd['no_order']; ?></td>
      <td ><div align="center"><?php echo $rowd['no_item'];?></div></td>
      <td ><?php echo $rowd['jenis_kain'];?></td>
      <td ><?php echo $rowd['no_warna']; ?></td>
      <td ><?php echo $rowd['warna']; ?></td>
      <td ><div align="center"><?php echo $rowd['lot']; ?></div></td>
      <td ><div align="center"><?php echo $rowd['rol']; ?></div></td>
      <td ><div align="center"><?php echo $rowd['qty']; ?></div></td>
      <td ><div align="center"><?php echo $rowd['panjang']; ?></div></td>
      <td ><div align="center"><?php echo $rowd['kondisi_kain']; ?></div></td>
      <td ><div align="center">
        <?php 
$awal  = strtotime($rowd['tgl_in']);
$akhir = strtotime($rowd['tgl_out']);
$diff  = ($akhir - $awal);

$jam   = floor($diff / (60 * 60));
$menit = $diff - $jam * (60 * 60);
$tjam	 =round($diff / (60 * 60),2);
$hari	 =round($tjam/24,2);
		  ?>
        <font size="-2" <?php if($jam < 0) {?> color="#E91013" <?php } ?>><?php echo $jam .  'H,' . floor( $menit / 60 ) . 'M';?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo $hari; ?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo $rowd['tujuan']; ?></font></div></td>
      <td ><?php echo $rowd['catatan']; ?></td>
      </tr>
     <?php 
	 $totqty=$totqty+$rowd['rol'];
	 $totberat=$totberat+$rowd['qty'];
	 $totyard=$totyard+$rowd['panjang'];
	 $totjam=$totjam+$diff;	
	 $tothari=$tothari+$hari;	
	 $no++;} ?>
   </tbody>
   <tfoot>
    <tr >
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
      <td bgcolor="#99FF99"><strong>Total</strong></td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99"><strong><?php echo $totqty;?></strong></td>
      <td bgcolor="#99FF99"><strong><?php echo $totberat;?></strong></td>
      <td bgcolor="#99FF99"><strong><?php echo $totyard;?></strong></td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99"><?php $jam1   = floor($totjam / (60 * 60));
$menit1 = $totjam - $jam1 * (60 * 60);
echo $jam1 .  'H,' . floor( $menit1 / 60 ) . 'M';?></td>
      <td bgcolor="#99FF99"><strong><?php echo $tothari;?></strong></td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      </tr>
    </tfoot>
  </table>
</form>
<?php }else if($_POST['jenis']=="Kartu Lebih" or $_GET['jenis']=="Kartu Lebih") { 
	
	if($_POST['awal']!=""){
	$tglawal=$_POST['awal'];
	$tglakhir=$_POST['akhir'];
	$jns=$_POST['jenis'];
	}
	else{
	$tglawal=$_GET['tgl1'];
	$tglakhir=$_GET['tgl2'];
	$jns=$_GET['jenis'];	
		}
		if($_POST['shift']!=""){$shft=$_POST['shift'];}
		else{$shft=$_GET['shift'];}
	if($tglakhir != "" and $tglawal != "")
		{$tgl=" DATE_FORMAT(`tgl_out`,'%Y-%m-%d') BETWEEN '$tglawal' AND '$tglakhir' ";}else{$tgl=" ";}
	if($shft=="ALL"){ $shift=" ";}else{$shift=" AND `shift1_out`='$shft' ";}
$row = 100;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = " SELECT 
	*
FROM
	`tbl_adm` 
WHERE
	`status`='2' AND DATEDIFF(tgl_out,tgl_in) > 2 AND ".$tgl.$shift." ORDER BY `tgl_in` ASC ";
$pageQry = mysqli_query($con,$pageSql) or die ("error: ".mysqli_error());
$jml	 = mysqli_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='index.php'" class="art-button"/>
<input type="hidden" name="button3" id="button3" value="Cetak" onclick="window.open('pages/reports-adm-cetak.php?tglawal=<?php echo $tglawal; ?>&amp;tglakhir=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>', '_blank')" class="art-button"/>
<input type="button" name="button" id="button" value="Cetak Ke Excel" onClick="window.location.href='pages/reports-adm-excel.php?tgl1=<?php echo $tglawal; ?>&amp;tgl2=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>&amp;jenis=<?php echo $jns; ?>'" class="art-button"/>
<br />
<strong><br />
</strong>
<form id="form1" name="form1" method="post" action="">
<strong>  Periode: <?php echo $tglawal; ?> s/d <?php echo $tglakhir; ?></strong><br />
<strong>Shift: <?php echo $shft;?></strong>
<br />
<strong>Kartu Kerja Selesai Proses Lebih Dari 2 Hari</strong>
<table width="100%" border="0" id="datatables" class="display">
   <thead>
    <tr >
      <td width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">TGL MASUK</font></strong></div></td>
      <td width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">JAM MASUK</font></strong></div></td>
      <td width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">TGL KELUAR</font></strong></div></td>
      <td width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">JAM KELUAR</font></strong></div></td>
      <td width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">SHIFT MASUK</font></strong></div></td>
      <td width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">SHIFT KELUAR</font></strong></div></td>
      <td width="3%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">NOKK</font></strong></div></td>
      <td width="6%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">LANGGANAN</font></strong></div></td>
      <td width="3%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">ORDER</font></strong></div></td>
      <td width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">HANGER</font></strong></div></td>
      <td width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">JENIS KAIN</font></strong></div></td>
      <td width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">NO WARNA</font></strong></div></td>
      <td width="3%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">WARNA</font></strong></div></td>
      <td width="2%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">LOT</font></strong></div></td>
      <td width="3%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">ROLL</font></strong></div></td>
      <td width="3%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">QTY (Kg)</font></strong></div></td>
      <td width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">QTY (yard)</font></strong></div></td>
      <td width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">KONDISI KAIN</font></strong></div></td>
      <td width="4%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">TOTAL JAM</font></strong></div></td>
      <td width="5%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">TOTAL HARI</font></strong></div></td>
      <td width="7%" bgcolor="#99FF99" ><div align="center"><strong><font size="-2">PROSES DEPT. BERIKUTNYA</font></strong></div></td>
      </tr>
    </thead>
    <tbody>
    <?php 
	
		$sql=mysqli_query($con," SELECT 
	*,`id` as `idp`,DATEDIFF(tgl_out,tgl_in) as 'Hari', TIMEDIFF(tgl_out,tgl_in) as 'Jam' 
FROM
	`tbl_adm`
WHERE
	`status`='2' AND DATEDIFF(tgl_out,tgl_in) > 2 AND ".$tgl.$shift." ORDER BY `tgl_in` ASC ");
   $no=1;   
   $c=0;
    while($rowd=mysqli_fetch_array($sql)){
		 $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
	  		  ?>
      <tr bgcolor="<?php echo $bgcolor;?>" >
      <td ><div align="center"><font size="-2"><?php echo date('Y-m-d', strtotime($rowd['tgl_in']));?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo date('H:i', strtotime($rowd['tgl_in']));?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo date('Y-m-d', strtotime($rowd['tgl_out']));?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo date('H:i', strtotime($rowd['tgl_out']));?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo $rowd['shift'].$rowd['shift1'];?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo $rowd['shift_out'].$rowd['shift1_out'];?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo $rowd['nokk'];?></font></div></td>
      <td ><font size="-2"><b title="<?php echo $rowd['langganan'];?>"><?php echo substr($rowd['langganan'],0,20)."..";?></b></font></td>
      <td ><font size="-2"><?php echo $rowd['no_order']; ?></font></td>
      <td ><div align="center"><font size="-2"><?php echo $rowd['no_item'];?></font></div></td>
      <td ><font size="-2"><b title="<?php echo $rowd['jenis_kain'];?>"><?php echo substr($rowd['jenis_kain'],0,20)."..";?></b></font></td>
      <td ><font size="-2"><b title="<?php echo $rowd['warna']; ?>"><?php echo substr($rowd['no_warna'],0,10).".."; ?></b></font></td>
      <td ><font size="-2"><b title="<?php echo $rowd['warna']; ?>"><?php echo substr($rowd['warna'],0,10).".."; ?></b></font></td>
      <td ><div align="center"><font size="-2"><?php echo $rowd['lot']; ?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo $rowd['rol']; ?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo $rowd['qty']; ?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo $rowd['panjang']; ?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo $rowd['kondisi_kain']; ?></font></div></td>
      <td ><div align="center">
        <?php 
$awal  = strtotime($rowd['tgl_in']);
$akhir = strtotime($rowd['tgl_out']);
$diff  = ($akhir - $awal);

$jam   = floor($diff / (60 * 60));
$menit = $diff - $jam * (60 * 60);
$tjam	 =round($diff / (60 * 60),2);
$hari	 =round($tjam/24,2);		  
		  ?>
        <font size="-2" <?php if($jam < 0) {?> color="#E91013" <?php } ?>><?php echo $jam .  'H,' . floor( $menit / 60 ) . 'M';?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo $hari; ?></font></div></td>
      <td ><div align="center"><font size="-2"><?php echo $rowd['tujuan']; ?></font></div></td>
      </tr>
     <?php 
	 $totqty=$totqty+$rowd['rol'];
	 $totberat=$totberat+$rowd['qty'];
	 $totyard=$totyard+$rowd['panjang'];
	 $totjam=$totjam+$diff;	
	 $tothari=$tothari+$hari;	
	 $no++;} ?>
   </tbody>
   <tfoot>
    <tr >
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
      <td bgcolor="#99FF99"><strong>Total</strong></td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99"><strong><?php echo $totqty;?></strong></td>
      <td bgcolor="#99FF99"><strong><?php echo $totberat;?></strong></td>
      <td bgcolor="#99FF99"><strong><?php echo $totyard;?></strong></td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99"><?php $jam1   = floor($totjam / (60 * 60));
$menit1 = $totjam - $jam1 * (60 * 60);
echo $jam1 .  'H,' . floor( $menit1 / 60 ) . 'M';?></td>
      <td bgcolor="#99FF99"><strong><?php echo $tothari;?></strong></td>
      <td bgcolor="#99FF99">&nbsp;</td>
      </tr>
    </tfoot>
  </table>
</form>
<?php }?>

</body>
</html>