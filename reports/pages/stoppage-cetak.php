
<?php 
ini_set("error_reporting", 1);
include ('../../koneksi.php'); 
?>
<?php

	$tglawal=$_POST['awal'];
	$tglakhir=$_POST['akhir'];
	$shft=$_POST['shift'];	
    $mc=$_POST['jnsmesin'];
	$no_mc=$_POST['nama_mesin'];
if($tglakhir != "" and $tglawal != "")
		{$tgl=" DATE_FORMAT(a.`tgl_update`,'%Y-%m-%d') BETWEEN '$tglawal' AND '$tglakhir' ";}else{$tgl=" ";}
		if($shft=="ALL"){$shift=" ";}else{$shift=" AND a.`shift`='$shft' ";}
        if($mc!=""){$mesin=" AND a.`jns_mesin`='$mc' ";}else{$mesin=" ";}
        if($no_mc!=""){$nomesin=" AND a.`no_mesin`='$no_mc' ";}else{$nomesin=" ";}

?>
<html>
<head>
<title>:: Cetak Reports STOPPAGE MESIN</title>
<link href="../../styles_cetak.css" rel="stylesheet" type="text/css">
<style>
input{
text-align:center;
border:hidden;
}
@media print {
  ::-webkit-input-placeholder { /* WebKit browsers */
      color: transparent;
  }
  :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
      color: transparent;
  }
  ::-moz-placeholder { /* Mozilla Firefox 19+ */
      color: transparent;
  }
  :-ms-input-placeholder { /* Internet Explorer 10+ */
      color: transparent;
  }
  .pagebreak { page-break-before:always; }
  .header {display:block}
  table thead 
   {
    display: table-header-group;
   }
}
</style>
</head>
<body>
<table width="812" border="0" class="table-list1" style="width:8.50in">
  <thead>
<tr valign="top">
        <td colspan="13"><table width="100%" border="0">
          <thead>
            <tr>
              <td width="8%" rowspan="4"><img src="Indo.jpg" alt="" width="60" height="60"></td>
              <td width="69%" rowspan="4"><div align="center">
                <h2>DATA STOPPAGE MESIN</h2>
              </div></td>
              <td width="11%">No. Form</td>
              <td width="12%">: 14-09</td>
            </tr>
            <tr>
              <td>No. Revisi</td>
              <td>: 02</td>
            </tr>
            <tr>
              <td>Tgl. Terbit</td>
              <td>: 30 Mei 2011</td>
            </tr>
          <thead>
        </table></td>
    </tr>
<tr valign="top">
  <td colspan="13" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;" ><strong>Departemen: FINISHING</strong></td>
  </tr>
<tr valign="top">
  <td colspan="13"><strong>Nama Mesin: <?php echo strtoupper($mc); ?></strong></td>
  </tr>
<tr valign="top">
        <td colspan="13"><strong>No. Mesin: <?php echo $no_mc; ?></strong></td>
    </tr>
    <tr>
      <td width="59" rowspan="2"><div align="center">Tgl.</div></td>
      <td colspan="4"><div align="center">Shift Pagi</div></td>
      <td colspan="4"><div align="center">Shift Siang</div></td>
      <td colspan="4"><div align="center">Shift Malam</div></td>
    </tr>
     <tr>
       <td width="55"><div align="center">Stop</div></td>
       <td width="55"><div align="center">Start</div></td>
       <td width="59"><div align="center">Total</div></td>
       <td width="62"><div align="center">Kode</div></td>
       <td width="55"><div align="center">Stop</div></td>
       <td width="55"><div align="center">Start</div></td>
       <td width="59"><div align="center">Total</div></td>
       <td width="62"><div align="center">Kode</div></td>
       <td width="55"><div align="center">Stop</div></td>
      <td width="55"><div align="center">Start</div></td>
      <td width="59"><div align="center">Total</div></td>
      <td width="68"><div align="center">Kode</div></td>
    </tr>
  </thead> 
    <tbody>
	<?php 
	
		$sql=mysqli_query($con," SELECT 
	*
FROM
	`tbl_produksi` a

WHERE
	(not kd_stop='' or not kd_stop2='' or not kd_stop3='') AND ".$tgl.$shift.$mesin.$nomesin." ORDER BY a.`no_mesin` ASC");
  
   $no=1;
   
   $c=0;
   
    while($rowd=mysqli_fetch_array($sql)){
		   ?>
      <tr valign="top">
      <td><div align="center"><?php echo $rowd['tgl_update'];?></div></td>
      <td><div align="center"><?php if($rowd['shift2']=="1"){echo $rowd['stop_l'];}?></div></td>
      <td><div align="center"><?php if($rowd['shift2']=="1"){echo $rowd['stop_r'];} ?></div></td>
      <td><div align="center">
        <?php 
		date_default_timezone_set('Asia/Jakarta');
		$time1=strtotime($rowd['tgl_stop_l']." ".$rowd['stop_l']);
		$time2=strtotime($rowd['tgl_stop_r']." ".$rowd['stop_r']);
        $diff  = $time2 - $time1;

        $jam   = floor($diff / (60 * 60));
        $menit = $diff - $jam * (60 * 60);
        if($rowd['shift2']=="1"){echo  $jam .  ' jam ' . floor( $menit / 60 ) . ' menit';}
		  ?>
      </div></td>
      <td><div align="center"><?php if($rowd['shift2']=="1"){echo $rowd['kd_stop'];} ?></div></td>
      <td><div align="center"><?php if($rowd['shift2']=="2"){echo $rowd['stop_l'];}?></div></td>
      <td><div align="center"><?php if($rowd['shift2']=="2"){echo $rowd['stop_r'];} ?></div></td>
      <td><div align="center">
        <?php 
		date_default_timezone_set('Asia/Jakarta');
		$time1=strtotime($rowd['tgl_stop_l']." ".$rowd['stop_l']);
		$time2=strtotime($rowd['tgl_stop_r']." ".$rowd['stop_r']);
        $diff  = $time2 - $time1;

        $jam   = floor($diff / (60 * 60));
        $menit = $diff - $jam * (60 * 60);
        if($rowd['shift2']=="2"){echo  $jam .  ' jam ' . floor( $menit / 60 ) . ' menit';}
		  ?>
      </div></td>
      <td><div align="center"><?php if($rowd['shift2']=="2"){echo $rowd['kd_stop'];} ?></div></td>
      <td><div align="center"><?php if($rowd['shift2']=="3"){echo $rowd['stop_l'];}?></div></td>
      <td><div align="center"><?php if($rowd['shift2']=="3"){echo $rowd['stop_r'];} ?></div></td>
      <td><div align="center">
        <?php 
		date_default_timezone_set('Asia/Jakarta');
		$time1=strtotime($rowd['tgl_stop_l']." ".$rowd['stop_l']);
		$time2=strtotime($rowd['tgl_stop_r']." ".$rowd['stop_r']);
        $diff  = $time2 - $time1;

        $jam   = floor($diff / (60 * 60));
        $menit = $diff - $jam * (60 * 60);
        if($rowd['shift2']=="3"){echo  $jam .  ' jam ' . floor( $menit / 60 ) . ' menit';}
		  ?>
      </div></td>
      <td><div align="center"><?php if($rowd['shift2']=="3"){echo $rowd['kd_stop'];} ?></div></td>
      </tr>
     <?php 
	 $totrol +=$rowd['rol'];
	 $totberat +=$rowd['qty'];
	 $no++;} ?>
     <?php for ($i=$no; $i <= 31; $i++)
{ ?>
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
      </tr>
      <?php } ?>
    </tbody>
    <tr>
      <td>Total</td>
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
      <td colspan="13"style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"><table width="100%" border="0" >
        <tbody>
          <tr style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;">
            <td colspan="6" valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"><strong>Kode Data Stoppage Mesin :</strong></td>
          </tr>
          <tr>
            <td width="3%" valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"><strong>LM</strong></td>
            <td width="20%" valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;">: Listrik Mati</td>
            <td width="4%" valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;" ><strong>PM</strong></td>
            <td width="55%" valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;">: Pemeliharaan Mesin (Pemeliharaan rutin oleh departemen Maintenance)</td>
            <td width="3%" valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"><strong></strong></td>
            <td width="15%" valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"></td>
          </tr>
          <tr>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"><strong>KM</strong></td>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;">: Kerusakan Mesin</td>
            <td width="4%" valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"><strong>GT</strong></td>
            <td width="55%" valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;">: Gangguan Teknis (Gangguan yang disebabkan oleh kerusakan pada mesin<br>
&nbsp;&nbsp;pendukung proses produksi, misalnya: steam kecil, tekanan angin<br>
&nbsp;&nbsp;compressor kurang, dan lain sebagainya) </td>
            <td width="3%" valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"><strong></strong></td>
            <td width="15%" valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"></td>
          </tr>
          <tr>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"><strong>PT</strong></td>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;">: Pembersihan Teknis</td>
            <td width="4%" valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"><strong>TG</strong></td>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;">: Tunggu (misalnya: Oper produksi, Tunggu buka kain, tunggu grobak)</td>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;">&nbsp;</td>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"><strong>KO</strong></td>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;">: Kurang Order</td>
            <td width="4%" valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"><strong></strong></td>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"></td>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;">&nbsp;</td>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"><strong>AP</strong></td>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;">: Abnormal Produk</td>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"><strong></strong></td>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"></td>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;">&nbsp;</td>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"><strong>PA</strong></td>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;">: Pelaksanaan Apel</td>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"><strong></strong></td>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;"></td>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;">&nbsp;</td>
            <td valign="top" style="border-bottom:0px #000 solid;
	border-top:0px #000 solid;
	border-left:0px #000 solid;
	border-right:0px #000 solid;">&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    
</table>
</body>
</html>