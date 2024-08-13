
<?php 
  	mysql_connect("10.0.0.10","dit","4dm1n");
    mysql_select_db("db_finishing")or die("Gagal Koneksi");
?>
<?php

	$tglawal=$_GET[tglawal];
	$tglakhir=$_GET[tglakhir];
	$shft=$_GET[shift];	
if($tglakhir != "" and $tglawal != "")
		{$tgl=" DATE_FORMAT(a.`tgl_update`,'%Y-%m-%d') BETWEEN '$tglawal' AND '$tglakhir' ";}else{$tgl=" ";}
		if($shft=="ALL"){$shift=" ";}else{$shift=" AND a.`shift`='$shft' ";}
		if($_GET[mesin]==""){$mesin=" ";}else{$mesin=" AND a.`no_mesin`='$_GET[mesin]' ";}

?>
<html>
<head>
<title>:: Cetak Reports Produksi Detail Stenter</title>
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
<table width="100%" border="0" class="table-list1">
  <thead>
<tr valign="top">
        <td colspan="35"><table width="100%" border="0" class="table-list1">
          <thead>
            <tr>
              <td width="6%" rowspan="4"><img src="Indo.jpg" alt="" width="60" height="60"></td>
              <td width="81%" rowspan="4"><div align="center">
                <h2>Data Detail Proses Actual Compact</h2>
              </div></td>
				<td width="5%"><font size="-2">No. Form</font></td>
			  <td width="8%">: <font size="-2">FW-14-FIN-01A</font></td>
            </tr>
            <tr>
			  <td><font size="-2">No. Revisi</font></td>
			  <td>: <font size="-2">03</font></td>
            </tr>
            <tr>
			  <td><font size="-2">Tgl. Terbit</font></td>
			  <td>: <font size="-2">18 Januari 2018</font></td>
            </tr>
          <thead>
        </table></td>
    </tr>
    <tr>
      <td rowspan="2"><div align="center"><strong><font size="-2">Tanggal</font></strong></div></td>
      <td rowspan="2" ><div align="center"><strong><font size="-2">Shift</font></strong></div></td>
      <td rowspan="2"   ><div align="center"><strong><font size="-2">Operator</font></strong></div></td>
      <td rowspan="2"   ><div align="center"><strong><font size="-2">Langganan</font></strong></div></td>
      <td rowspan="2"   ><div align="center"><strong><font size="-2">No Order</font></strong></div></td>
      <td rowspan="2"   ><div align="center"><strong><font size="-2">No Hanger</font></strong></div></td>
      <td rowspan="2"   ><div align="center"><strong><font size="-2">Jenis Kain</font></strong></div></td>
      <td rowspan="2"   ><div align="center"><strong><font size="-2">Warna</font></strong></div></td>
      <td rowspan="2" class="display"style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">Lot</font></strong></div></td>
      <td rowspan="2" class="display"style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">Roll</font></strong></div></td>
      <td rowspan="2" class="display"style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">Quantity<br />
        (Kg) </font></strong></div></td>
      <td rowspan="2" class="display"style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">Panjang Kain Actual (Yard)</font></strong></div></td>
      <td rowspan="2" class="display"style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">Proses</font></strong></div></td>
      <td rowspan="2" class="display"style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2"> Suhu</font></strong></div></td>
      <td rowspan="2" class="display"style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2"> Speed</font></strong></div></td>
      <td rowspan="2"   ><div align="center"><strong><font size="-2">Overfeed</font></strong> </div></td>
      <td rowspan="2" class="display"style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">Buka Rantai</font></strong></div></td>
      <td colspan="2" class="display"style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">Lebar (Inci)</font></strong></div></td>
      <td colspan="2" class="display"style="border:1px solid;vertical-align:middle;"><div align="center"><strong><font size="-2">Gramasi (gr/m2)</font></strong></div></td>
	  <td rowspan="2"><div align="center"><strong><font size="-2">No Gerobak</font></strong></div></td>
    </tr>
     <tr>
        <td><div align="center"><strong><font size="-2">Permintaan</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Actual</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Permintaan</font></strong></div></td>
       <td><div align="center"><strong><font size="-2">Actual</font></strong></div></td>
    </tr>
  </thead> 
    <tbody>
	<?php 
	
		$sql=mysql_query(" SELECT 
	*
FROM
	`tbl_compact` a

WHERE
	".$tgl.$shift." ORDER BY a.`tgl_update` ASC ");
  
   $no=1;
   
   $c=0;
   
    while($rowd=mysql_fetch_array($sql)){
		
		// hitung hari dan jam	 
$awal  = strtotime($rowd['tgl_stop_l'].' '.$rowd['stop_l']);
$akhir = strtotime($rowd['tgl_stop_r'].' '.$rowd['stop_r']);
$diff  = ($akhir - $awal);
$tmenit=round($diff / (60),2);		
$tjam  =round($diff / (60 * 60),2);
$hari  =round($tjam/24,2);
		   ?>
      <tr bgcolor="<?php echo $bgcolor;?>" class="display"  >
        <td style="border:1px solid;vertical-align:middle;"><div align="center"><font size="-2"><?php echo $rowd['tgl_update'];?></font></div></td>
        <td style="border:1px solid;vertical-align:middle;"><font size="-2"><?php echo $rowd['shift'];?></font></td>
        <td style="border:1px solid;vertical-align:middle;"><font size="-2"><?php echo $rowd['acc_staff']; ?></font></td>
        <td style="border:1px solid;vertical-align:middle;"><div align="center"><font size="-2"><?php echo $rowd['langganan'];?></font></div></td>
        <td style="border:1px solid;vertical-align:middle;"><font size="-2"><?php echo $rowd['no_order'];?></font></td>
        <td style="border:1px solid;vertical-align:middle;"><font size="-2"><?php echo $rowd['no_item']; ?></font></td>
        <td style="border:1px solid;vertical-align:middle;"><div align="center"><font size="-2"><?php echo $rowd['jenis_kain']; ?></font></div></td>
        <td style="border:1px solid;vertical-align:middle;"><div align="center"><font size="-2"><?php echo $rowd['warna']; ?></font></div></td>
        <td style="border:1px solid;vertical-align:middle;"><div align="center"><font size="-2"><?php echo $rowd['lot']; ?></font></div></td>
        <td style="border:1px solid;vertical-align:middle;"><font size="-2"><?php echo $rowd['rol']; ?></font></td>
        <td style="border:1px solid;vertical-align:middle;"><font size="-2"><?php echo $rowd['qty']; ?></font></td>
        <td style="border:1px solid;vertical-align:middle;"><font size="-2"><?php echo $rowd['panjang_h']; ?></font></td>
        <td style="border:1px solid;vertical-align:middle;"><font size="-2"><?php echo $rowd['proses']; ?></font></td>
        <td style="border:1px solid;vertical-align:middle;"><font size="-2"><?php echo $rowd['suhu']; ?></font></td>
        <td style="border:1px solid;vertical-align:middle;"><font size="-2"><?php echo $rowd['speed']; ?></font></td>
        <td style="border:1px solid;vertical-align:middle;"><div align="center"><font size="-2"><?php echo $rowd['overfeed'];?></font></div></td>
        <td style="border:1px solid;vertical-align:middle;"><div align="center"><font size="-2"><?php echo $rowd['buka_rantai'];?></font></div></td>
        <td style="border:1px solid;vertical-align:middle;"><div align="center"><font size="-2"><?php echo $rowd['lebar'];?></font></div></td>
        <td style="border:1px solid;vertical-align:middle;"><div align="center"><font size="-2"><?php echo $rowd['lebar_h'];?></font></div></td>
        <td style="border:1px solid;vertical-align:middle;"><div align="center"><font size="-2"><?php echo $rowd['gramasi'];?></font></div></td>
        <td style="border:1px solid;vertical-align:middle;"><div align="center"><font size="-2"><?php echo $rowd['gramasi_h'];?></font></div></td>
        <td style="border:1px solid;vertical-align:middle;"><div align="center"><font size="-2"><?php echo $rowd['no_gerobak'];?></font></div></td>
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
    </tr>
</table>
  <table width="100%" border="0" class="table-list1">
  <tr>
    <td width="15%">&nbsp;</td>
    <td width="31%"><div align="center">DIBUAT OLEH:</div></td>
    <td width="27%"><div align="center">DIPERIKSA OLEH:</div></td>
    <td width="27%"><div align="center">DIKETAHUI OLEH:</div></td>
    </tr>
  <tr>
    <td>NAMA</td>
    <td><div align="center">
      <input name=nama type=text placeholder="Ketik disini" size="33" maxlength="30">
    </div></td>
    <td><div align="center">
      <input name=nama3 type=text placeholder="Ketik disini" size="33" maxlength="30">
    </div></td>
    <td><div align="center">Yayan Tri B</div></td>
    </tr>
  <tr>
    <td>JABATAN</td>
    <td><div align="center">Operator</div></td>
    <td><div align="center">Supervisor / Asst. Supervisor</div></td>
    <td><div align="center">Manager / Asst. Manager</div></td>
    </tr>
  <tr>
    <td>TANGGAL</td>
    <td><div align="center">
      <input type="text" name="date" placeholder="dd-mm-yyyy" onKeyUp="
  var date = this.value;
  if (date.match(/^\d{2}$/) !== null) {
     this.value = date + '-';
  } else if (date.match(/^\d{2}\-\d{2}$/) !== null) {
     this.value = date + '-';
  }" maxlength="10">
    </div></td>
    <td><div align="center">
      <input type="text" name="date" placeholder="dd-mm-yyyy" onKeyUp="
  var date = this.value;
  if (date.match(/^\d{2}$/) !== null) {
     this.value = date + '-';
  } else if (date.match(/^\d{2}\-\d{2}$/) !== null) {
     this.value = date + '-';
  }" maxlength="10">
    </div></td>
    <td><div align="center">
      <input type="text" name="date" placeholder="dd-mm-yyyy" onKeyUp="
  var date = this.value;
  if (date.match(/^\d{2}$/) !== null) {
     this.value = date + '-';
  } else if (date.match(/^\d{2}\-\d{2}$/) !== null) {
     this.value = date + '-';
  }" maxlength="10">
    </div></td>
    </tr>
  <tr>
    <td height="60" valign="top">TANDA TANGAN</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
</table>

</body>
</html>