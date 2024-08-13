<?php
ini_set("error_reporting", 1);
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=report-detail-stenter".date($_GET['tglawal']).".xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");
//disini script laporan anda
?>
<?php 
//$con=mysqli_connect("10.0.0.10","dit","4dm1n","db_finishing");
ini_set("error_reporting", 1);
include ('../../koneksi.php'); 
?>
<?php

	$tglawal=$_GET['tglawal'];
	$tglakhir=$_GET['tglakhir'];
	$shft=$_GET['shift'];
	$shft2=$_GET['shift2'];
	$msn=$_GET['mesin'];
    if($tglakhir != "" and $tglawal != "")
	{$tgl=" DATE_FORMAT(a.`tgl_update`,'%Y-%m-%d') BETWEEN '$tglawal' AND '$tglakhir' ";}else{$tgl=" ";}
	if($shft2=="ALL"){$shift=" ";}else{$shift=" AND a.`shift`='$shft2' ";}
	if($shft=="ALL"){$shift2=" ";}else{$shift2=" AND a.`shift2`='$shft' ";}
	if($msn==""){$mesin=" ";}else{$mesin=" AND a.`no_mesin`='$msn' ";}

?>
<html>
<head>
<title>:: Cetak Reports Produksi Detail Stenter</title>
</head>
<body>
<table width="100%" border="1" class="table-list1">
  <thead>
    <tr>
      <td rowspan="2"><div align="center"><strong><font size="-2">Prod Order</font></strong></div></td>
      <td rowspan="2"><div align="center"><strong><font size="-2">Prod Demand</font></strong></div></td>
      <td rowspan="2"><div align="center"><strong><font size="-2">Tanggal</font></strong></div></td>
      <td rowspan="2"><div align="center"><strong><font size="-2">Shift</font></strong></div></td>
      <td rowspan="2"><div align="center"><strong><font size="-2">Operator</font></strong></div></td>
      <td rowspan="2"><div align="center"><strong><font size="-2">Langganan</font></strong></div></td>
      <td rowspan="2"><div align="center"><strong><font size="-2">No Order</font></strong></div></td>
      <td rowspan="2"><div align="center"><strong><font size="-2">No Hanger</font></strong></div></td>
      <td rowspan="2"><div align="center"><strong><font size="-2">Jenis Kain</font></strong></div></td>
      <td rowspan="2"><div align="center"><strong><font size="-2">Warna</font></strong></div></td>
      <td rowspan="2"  ><div align="center"><strong><font size="-2">Lot</font></strong></div></td>
      <td rowspan="2"  ><div align="center"><strong><font size="-2">Roll</font></strong></div></td>
      <td rowspan="2"  ><div align="center"><strong><font size="-2">Quantity<br />
        (Kg) </font></strong></div></td>
      <td rowspan="2"  ><div align="center"><strong><font size="-2">Panjang Kain Actual (Yard)</font></strong></div></td>
      <td rowspan="2"  ><div align="center"><strong><font size="-2">Proses</font></strong></div></td>
      <td rowspan="2"  ><div align="center"><strong><font size="-2"> Suhu</font></strong></div></td>
      <td rowspan="2"  ><div align="center"><strong><font size="-2"> Speed</font></strong></div></td>
      <td colspan="2"   ><div align="center"><strong><font size="-2">MAHLO</font></strong></div></td>
      <td rowspan="2"   ><div align="center"><strong><font size="-2">Overfeed</font></strong> </div></td>
      <td rowspan="2"  ><div align="center"><strong><font size="-2">Buka Rantai</font></strong></div></td>
      <td rowspan="2"  ><div align="center"><strong><font size="-2">pH Larutan</font></div></td>
      <td colspan="10"  ><div align="center"><strong><font size="-2">Pemakaian Chemical</font></div></td>
      <td colspan="2"  ><div align="center"><strong><font size="-2">Lebar (Inci)</font></strong></div></td>
      <td colspan="2"  ><div align="center"><strong><font size="-2">Gramasi (gr/m2)</font></strong></div></td>
	  <td rowspan="2"><div align="center"><strong><font size="-2">No Gerobak</font></strong></div></td>
    </tr>
     <tr>
       <td><div align="center"><strong><font size="-2">VMT</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">OMT</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Chemical I</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Konsentrasi I</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Chemical II</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Konsentrasi II</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Chemical III</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Konsentrasi III</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Chemical IV</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Konsentrasi IV</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Chemical V</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Konsentrasi V</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Chemical VI</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Konsentrasi VI</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Chemical VII</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Konsentrasi VII</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Permintaan</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Actual</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Permintaan</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Actual</font></strong></div></td>
    </tr>
  </thead> 
    <tbody>
	<?php 
	
		$sql=mysqli_query($con," SELECT 
	*
FROM
	`tbl_produksi` a

WHERE
	".$tgl.$mesin.$shift." ORDER BY a.`tgl_update` ASC ");
  
   $no=1;
   $totrol=0;
   $totberat=0;
   $c=0;
   
    while($rowd=mysqli_fetch_array($sql)){
		
		// hitung hari dan jam	 
$awal  = strtotime($rowd['tgl_stop_l'].' '.$rowd['stop_l']);
$akhir = strtotime($rowd['tgl_stop_r'].' '.$rowd['stop_r']);
$diff  = ($akhir - $awal);
$tmenit=round($diff / (60),2);		
$tjam  =round($diff / (60 * 60),2);
$hari  =round($tjam/24,2);
		   ?>
      <tr class="display"  >
        <td  ><div align="center"><font size="-2">`<?php echo $rowd['nokk'];?></font></div></td>
        <td  ><div align="center"><font size="-2">`<?php echo $rowd['demandno'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['tgl_update'];?></font></div></td>
        <td  ><font size="-2"><?php echo $rowd['shift'];?></font></td>
        <td  ><font size="-2"><?php echo $rowd['acc_staff']; ?></font></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['langganan'];?></font></div></td>
        <td  ><font size="-2"><?php echo $rowd['no_order'];?></font></td>
        <td  ><font size="-2"><?php echo $rowd['no_item']; ?></font></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['jenis_kain']; ?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['warna']; ?></font></div></td>
        <td  ><div align="center"><font size="-2">'<?php echo $rowd['lot']; ?></font></div></td>
        <td  ><font size="-2"><?php echo $rowd['rol']; ?></font></td>
        <td  ><font size="-2"><?php echo $rowd['qty']; ?></font></td>
        <td  ><font size="-2"><?php echo $rowd['panjang_h']; ?></font></td>
        <td  ><font size="-2"><?php echo $rowd['proses']; ?></font></td>
        <td  ><font size="-2"><?php echo $rowd['suhu']; ?></font></td>
        <td  ><font size="-2"><?php echo $rowd['speed']; ?></font></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['vmt']."&deg;
         X ".$rowd['t_vmt']; ?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['omt'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['overfeed'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['buka_rantai'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['ph_larut'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['chemical_1'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['konsen_1'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['chemical_2'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['konsen_2'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['chemical_3'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['konsen_3'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['chemical_4'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['konsen_4'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['chemical_5'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['konsen_5'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['chemical_6'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['konsen_6'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['chemical_7'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['konsen_7'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['lebar'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['lebar_h'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['gramasi'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['gramasi_h'];?></font></div></td>
        <td  ><div align="center"><font size="-2"><?php echo $rowd['no_gerobak'];?></font></div></td>
      </tr>
     <?php 
	 $totrol +=$rowd['rol'];
	 $totberat +=$rowd['qty'];
	 $no++;} ?>
     </tbody>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
</table>
</body>
</html>