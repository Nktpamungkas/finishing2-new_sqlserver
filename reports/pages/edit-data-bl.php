<?php /*if( !isset($_SESSION['usr']) || !isset($_SESSION['pass'])){
echo "<script>window.location='../login.php';</script>"; 
}*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home</title>
<script>
function roundToTwo(num) {    
    return +(Math.round(num + "e+2")  + "e-2");
}
function jumlah()
{
				var lebar = document.forms['form1']['lebar'].value;
				var berat = document.forms['form1']['gramasi'].value;
				var netto = document.forms['form1']['qty'].value;        
				var x,yard;
				x=((parseInt(lebar))*parseInt(berat))/43.056;
				x1=(1000/x);
				yard=x1*parseFloat(netto);
				document.form1.qty2.value=roundToTwo(yard).toFixed(2);
					
}		
	function jumlah1()
{
				var lebar1 = document.forms['form1']['h_lebar'].value;
				var berat1 = document.forms['form1']['h_gramasi'].value;
				var netto1 = document.forms['form1']['qty'].value;        
				var x1,yard1;
				x1=((parseInt(lebar1))*parseInt(berat1))/43.056;
				x2=(1000/x1);
				yard1=x2*parseFloat(netto1);
				document.form1.qty3.value=roundToTwo(yard1).toFixed(2);
					
}	
</script>
<style>
fieldset {
	width: 80%;
	border: 4px solid #C0BBBB;
	display: inline-block;
	font-size: 14px;
	padding: 1em 2em;
}

legend {
	background: #355FE7;  /* Green */
	color: #FFFFFF;          /* White */
	margin-bottom: 10px;
	padding: 0.5em 1em;
}
</style>
</head>

<body>     
<?php
ini_set("error_reporting", 1);
session_start();
include("../../koneksi.php");
	$sql=mysqli_query($con,"SELECT * FROM tbl_produksi WHERE id='$_GET[id]'");
	$rw=mysqli_fetch_array($sql);
if(isset($_POST['btnUbah'])){
		$shift=$_POST['shift'];
		$shift2=$_POST['shift2'];
		$langganan=str_replace("'","''",$_POST['buyer']);
		$buyer=$_POST['kd_buyer'];
		$order=$_POST['no_order'];
		$item=$_POST['no_item'];
		$jenis_kain=str_replace("'","''",$_POST['jenis_kain']);
		$kain=$_POST['kondisi_kain'];
		$bahan=$_POST['jenis_bahan'];
		$warna=str_replace("'","''",$_POST['warna']);
		$nowarna=$_POST['no_warna'];
		$lot=$_POST['lot'];
		$qty=$_POST['qty'];
		$qty2=$_POST['qty2'];
		$qty3=$_POST['qty3'];
		$rol=$_POST['rol'];
		$mesin=$_POST['no_mesin'];
		$nmmesin=str_replace("'","''",$_POST['nama_mesin']);
		$proses=$_POST['proses'];
		$gerobak=$_POST['no_gerobak'];
		$jam_in=$_POST['proses_in'];
		$jam_out=$_POST['proses_out'];
		$proses_jam=$_POST['proses_jam'];
		$proses_menit=$_POST['proses_menit'];
		$tgl_proses_in=$_POST['tgl_proses_m'];
		$tgl_proses_out=$_POST['tgl_proses_k'];
		$mulai=$_POST['stop_mulai'];
	    $mulai2=$_POST['stop_mulai2'];
		$mulai3=$_POST['stop_mulai3'];
		$selesai=$_POST['stop_selesai'];
		$selesai2=$_POST['stop_selesai2'];
		$selesai3=$_POST['stop_selesai3'];
		$stop_jam=$_POST['stop_jam'];
		$stop_menit=$_POST['stop_menit'];
		$tgl_stop_m=$_POST['tgl_stop_m'];
	    $tgl_stop_m2=$_POST['tgl_stop_m2'];
		$tgl_stop_m3=$_POST['tgl_stop_m3'];
		$tgl_stop_s=$_POST['tgl_stop_s'];
		$tgl_stop_s2=$_POST['tgl_stop_s2'];
		$tgl_stop_s3=$_POST['tgl_stop_s3'];
		$kd=$_POST['kd_stop'];
	    $kd2=$_POST['kd_stop2'];
	    $kd3=$_POST['kd_stop3'];
		$tgl=$_POST['tgl'];
		$acc_kain=str_replace("'","''",$_POST['acc_kain']);
	    $catatan=str_replace("'","''",$_POST['catatan']);
		$suhu=$_POST['suhu'];
		$speed=$_POST['speed'];
		$omt=$_POST['omt'];
		$vmt=$_POST['vmt'];
		$vmt_time=$_POST['vmt_time'];
		$buka=$_POST['buka_rantai'];
		$overfeed=$_POST['overfeed'];
		$hlebar=$_POST['h_lebar'];
		$hgramasi=$_POST['h_gramasi'];
		$lebar=$_POST['lebar'];
		$gramasi=$_POST['gramasi'];
		$phlarutan=$_POST['pH_larutan'];
		$chemical1=$_POST['chemical_1'];
		$chemical2=$_POST['chemical_2'];
		$chemical3=$_POST['chemical_3'];
		$chemical4=$_POST['chemical_4'];
		$chemical5=$_POST['chemical_5'];
		$jmlKonsen1=$_POST['jmlKonsen1'];
		$jmlKonsen2=$_POST['jmlKonsen2'];
		$jmlKonsen3=$_POST['jmlKonsen3'];
		$jmlKonsen4=$_POST['jmlKonsen4'];
		$jmlKonsen5=$_POST['jmlKonsen5'];
	$simpanSql = "UPDATE tbl_produksi SET 
	`no_gerobak`='$gerobak',
	`no_mesin`='$mesin',
	`nama_mesin`='$nmmesin',
	`proses`='$proses',
	`jam_in`='$jam_in',
	`jam_out`='$jam_out',
	`tgl_proses_in`='$tgl_proses_in',
	`tgl_proses_out`='$tgl_proses_out',
	`stop_l`='$mulai',
	`stop_l2`='$mulai2',
	`stop_l3`='$mulai3',
	`stop_r`='$selesai',
	`stop_r2`='$selesai2',
	`stop_r3`='$selesai3',
	`tgl_stop_l`='$tgl_stop_m',
	`tgl_stop_l2`='$tgl_stop_m2',
	`tgl_stop_l3`='$tgl_stop_m3',
	`tgl_stop_r`='$tgl_stop_s',
	`tgl_stop_r2`='$tgl_stop_s2',
	`tgl_stop_r3`='$tgl_stop_s3',
	`kd_stop`='$kd',
	`kd_stop2`='$kd2',
	`kd_stop3`='$kd3',
	`acc_staff`='$acc_kain',
	`catatan`='$catatan',
	`suhu`='$suhu',
	`speed`='$speed',
	`omt`='$omt',
	`vmt`='$vmt',
	`t_vmt`='$vmt_time',
	`buka_rantai`='$buka',
	`overfeed`='$overfeed',
	`lebar`='$lebar',
	`gramasi`='$gramasi',
	`lebar_h`='$hlebar',
	`gramasi_h`='$hgramasi',
	`ph_larut`='$phlarutan',
	`chemical_1`='$chemical1',
	`chemical_2`='$chemical2',
	`chemical_3`='$chemical3',
	`chemical_4`='$chemical4',
	`chemical_5`='$chemical5',
	`konsen_1`='$jmlKonsen1',
	`konsen_2`='$jmlKonsen2',
	`konsen_3`='$jmlKonsen3',
	`konsen_4`='$jmlKonsen4',
	`konsen_5`='$jmlKonsen5'
	WHERE `id`='$_POST[id]'";
		mysqli_query($con,$simpanSql) or die ("Gagal Ubah".mysqli_error());
		
		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=?p=edit-data&id=$_GET[id]&status=Data Sudah DiUbah'>";
	}	
	?>
<form id="form1" name="form1" method="post" action="" >
 <fieldset>
  <legend>Data Produksi Harian Belah &amp; lipat</legend>
  <table width="100%" border="0">
    <tr>
      <th colspan="7" scope="row"><font color="#FF0000"><?php echo $_GET['status'];?></font></th>
    </tr>
    <tr>
      <td width="13%" scope="row"><h4>Nokk</h4></td>
      <td width="1%">:</td>
      <td width="26%"><input name="nokk" type="text" id="nokk" size="17" value="<?php echo $rw['nokk'];?>"/><input type="hidden"  value="<?php echo $rw['id'];?>" name="id"/></td>
      <td width="14%"><h4>Group Shift</h4></td>
      <td width="1%">:</td>
      <td colspan="2"><select name="shift" id="shift" required>
          <option value="">Pilih</option>
          <option value="A" <?php if($rw['shift']=="A") {echo "SELECTED";} ?>>A</option>
          <option value="B" <?php if($rw['shift']=="B") {echo "SELECTED";} ?>>B</option>
          <option value="C" <?php if($rw['shift']=="C") {echo "SELECTED";} ?>>C</option>
      </select></td>
    </tr>
    <tr>
      <td scope="row"><h4>Langganan/Buyer</h4></td>
      <td>:</td>
      <td><input name="buyer" type="text" id="buyer" size="30" value="<?php echo $rw['langganan']; ?>"/></td>
      <td width="14%"><h4>Shift</h4></td>
      <td>:</td>
      <td colspan="2"><select name="shift2" id="shift2" required="required" >
        <option value="">Pilih</option>
        <option value="1" <?php if($rw['shift2']=="1") {echo "SELECTED";} ?> >1</option>
        <option value="2" <?php if($rw['shift2']=="2") {echo "SELECTED";} ?> >2</option>
        <option value="3" <?php if($rw['shift2']=="3") {echo "SELECTED";} ?> >3</option>
      </select></td>
    </tr>
    <tr>
      <td scope="row"><h4>Kode Buyer</h4></td>
      <td>:</td>
      <td><select name="kd_buyer" id="kd_buyer" required="required">
        <option value="">Pilih</option>
        <option value="ADIDAS" <?php if($rw['buyer']=="ADIDAS"){echo "SELECTED";}?> >ADIDAS</option>
        <option value="NIKE" <?php if($rw['buyer']=="NIKE"){echo "SELECTED";}?>>NIKE</option>
        <option value="CAMPURAN" <?php if($rw['buyer']=="CAMPURAN"){echo "SELECTED";}?>>CAMPURAN</option>
      </select></td>
      <td><h4>Tgl Proses</h4></td>
      <td>:</td>
      <td colspan="2"><input name="tgl" type="text" required="required" id="tgl" placeholder="0000-00-00" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl);return false;" value="<?php echo $rw['tgl_update'];?>" size="10"/>
        <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal" style="border:none" align="absmiddle" border="0" /></a></td>
    </tr>
    <tr>
      <td scope="row"><h4>No. Order</h4></td>
      <td>:</td>
      <td><input type="text" name="no_order" id="no_order" value="<?php echo $rw['no_order'];?>"/>
      </td>
      <td><h4>Proses</h4></td>
      <td>:</td>
      <td colspan="2"><select name="proses" id="proses" required>
          <option value="">Pilih</option>
          <?php $qry1=mysqli_query($con,"SELECT proses,jns FROM tbl_proses ORDER BY id ASC"); 
		while($r=mysqli_fetch_array($qry1)){
		?>
          <option value="<?php echo $r['proses']." (".$r['jns'].")";?>" <?php if($rw['proses']==$r['proses']." (".$r['jns'].")"){echo "SELECTED";}?>><?php echo $r['proses']." (".$r['jns'].")";?></option>
          <?php } ?>
        </select>
        <?php if($_SESSION['lvl']=="SPV") { ?>
        <input type="button" name="btnproses" id="btnproses" value="..."  onclick="window.open('pages/data-proses.php','MyWindow','height=400,width=650');"/>
        <?php } ?>
        </td>
    </tr>
    <tr>
      <td valign="top" scope="row"><h4>Jenis Kain</h4></td>
      <td valign="top">:</td>
      <td><textarea name="jenis_kain" cols="30" id="jenis_kain"><?php echo $rw['jenis_kain'];?></textarea></td>
      <td valign="top"><h4>Catatan</h4></td>
      <td valign="top">:</td>
      <td colspan="2" valign="top"><textarea name="catatan" cols="35" id="catatan"><?php echo $rw['catatan'];?></textarea></td>
    </tr>
    <tr>
      <td scope="row"><h4>Hanger/Item</h4></td>
      <td>:</td>
      <td><input type="text" name="no_item" id="no_item" value="<?php echo $rw['no_item'];?>"/></td>
      <td><h4>L X G ActualL X G ActualL X G Actual</h4></td>
      <td>:</td>
      <td colspan="2"><input name="h_lebar" type="text" required="required" id="h_lebar" value="<?php if($rw['lebar_h']!=""){ echo round($rw['lebar_h'],2);}?>" size="5"/>
        &quot;X
        <input name="h_gramasi" type="text" required="required" id="h_gramasi" value="<?php if($rw['gramasi_h']!=""){echo round($rw['gramasi_h'],2);}?>" size="5"/></td>
    </tr>
    <tr>
      <td scope="row"><h4>No. Warna</h4></td>
      <td>:</td>
      <td><input name="no_warna" type="text" id="no_warna" size="30" value="<?php echo $rw['no_warna'];?>"/></td>
      <td width="14%"><strong>Quantity (Kg)</strong></td>
      <td width="1%">:</td>
      <td colspan="2"><input name="qty" type="text" id="qty" size="5" value="<?php echo round($rw['qty'],2);?>" placeholder="0.00" />&nbsp;&nbsp;&nbsp;&nbsp;<strong>Gramasi</strong>:<input name="lebar" type="text" id="lebar" size="6" value="<?php echo round($rw['lebar'],2);?>" placeholder="0" />
         &quot;X
        <input name="gramasi" type="text" id="gramasi" size="6" value="<?php echo round($rw['gramasi'],2);?>" placeholder="0" /></td>
    </tr>
    <tr>
      <td scope="row"><h4>Warna</h4></td>
      <td>:</td>
      <td><input name="warna" type="text" id="warna" size="30" value="<?php echo $rw['warna'];?>"/></td>
      <td width="14%"><strong>Panjang (Yard)</strong></td>
      <td>:</td>
      <td colspan="2"><input name="qty2" type="text" id="qty2" size="8" value="<?php echo $rw['panjang'];?>" placeholder="0.00" onfocus="jumlah();"/></td>
    </tr>
    <tr>
      <td scope="row"><h4>Lot</h4></td>
      <td>:</td>
      <td><input name="lot" type="text" id="lot" size="5" value="<?php echo $rw['lot'];?>"/></td>
      <td><h4>Nama Mesin</h4></td>
      <td>:</td>
      <td colspan="2"><select name="nama_mesin" id="nama_mesin" onchange="myFunction();" required="required">
        <option value="">Pilih</option>
        <?php $qry1=mysqli_query($con,"SELECT nama FROM tbl_mesin WHERE jenis='belah' or jenis='lipat'  ORDER BY nama ASC"); 
		while($r=mysqli_fetch_array($qry1)){
		?>
        <option value="<?php echo $r['nama'];?>" <?php if($rw['nama_mesin']==$r['nama']){echo "SELECTED";}?> ><?php echo $r['nama'];?></option>
        <?php } ?>
      </select>
        <?php if($_SESSION['lvl']=="SPV") { ?>
        <input type="button" name="btnmesin2" id="btnmesin2" value="..."  onclick="window.open('pages/mesin.php','MyWindow','height=400,width=650');"/>
        <?php } ?></td>
    </tr>
    <tr>
      <td scope="row"><h4>Roll</h4></td>
      <td>:</td>
      <td><input name="rol" type="text" id="rol" size="3" placeholder="0" pattern="[0-9]{1,}" value="<?php if($cLot>0){echo $sLot['RollCount'];}else{echo $rw['rol'];}?>" /></td>
      <td><strong>No. Mesin</strong></td>
      <td>:</td>
      <td colspan="2"><select name="no_mesin" id="no_mesin" onchange="myFunction();" required="required">
        <option value="">Pilih</option>
        <?php $qry1=mysqli_query($con,"SELECT no_mesin FROM tbl_no_mesin WHERE jenis='belah' or jenis='lipat' ORDER BY no_mesin ASC"); 
		while($r=mysqli_fetch_array($qry1)){
		?>
        <option value="<?php echo $r['no_mesin'];?>" <?php if($rw['no_mesin']==$r['no_mesin']){echo "SELECTED";}?> ><?php echo $r['no_mesin'];?></option>
        <?php } ?>
      </select>
        <?php if($_SESSION['lvl']=="SPV") { ?>
        <input type="button" name="btnmesin" id="btnmesin" value="..."  onclick="window.open('pages/data-mesin.php','MyWindow','height=400,width=650');"/>
        <?php } ?></td>
    </tr>
    <tr>
      <td scope="row"><h4>Mulai Proses</h4></td>
      <td>:</td>
      <td><input name="proses_in" type="text" id="proses_in"  placeholder="00:00" pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25" onkeyup="
  var time = this.value;
  if (time.match(/^\d{2}$/) !== null) {
     this.value = time + ':';
  } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
     this.value = time + '';
  }" value="<?php echo $rw['jam_in']?>" size="5" maxlength="5" />
        <input name="tgl_proses_m" type="text" id="tgl_proses_m" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_proses_m);return false;" size="10" placeholder="0000-00-00" value="<?php if($rw['tgl_proses_in']!="0000-00-00"){echo $rw['tgl_proses_in'];} ?>" />
        <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_proses_m);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal2" style="border:none" align="absmiddle" border="0" /></a></td>
      <td><h4>Selesai Proses</h4></td>
      <td>:</td>
      <td colspan="2"><input name="proses_out" type="text" id="proses_out"  placeholder="00:00" pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25 " onkeyup="
  var time = this.value;
  if (time.match(/^\d{2}$/) !== null) {
     this.value = time + ':';
  } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
     this.value = time + '';
  }" value="<?php echo $rw['jam_out']?>" size="5" maxlength="5" />
        <input name="tgl_proses_k" type="text" id="tgl_proses_k" placeholder="0000-00-00" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_proses_k);return false;" value="<?php if($rw['tgl_proses_out']!="0000-00-00"){echo $rw['tgl_proses_out'];} ?>" size="10"/>
        <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_proses_k);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal3" style="border:none" align="absmiddle" border="0" /></a></td>
    </tr>
    <tr>
      <td scope="row"><h4>Mulai Stop Mesin 1</h4></td>
      <td>:</td>
      <td><input name="stop_mulai" type="text" id="stop_mulai"  placeholder="00:00" pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25 " onkeyup="
  var time = this.value;
  if (time.match(/^\d{2}$/) !== null) {
     this.value = time + ':';
  } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
     this.value = time + '';
  }" value="<?php echo $rw['stop_l']?>" size="5" maxlength="5" />
        <input name="tgl_stop_m" type="text" id="tgl_stop_m" placeholder="0000-00-00" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_m);return false;" value="<?php if($rw['tgl_stop_l']!="0000-00-00"){echo $rw['tgl_stop_l'];}?>" size="10" />
      <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_m);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal4" style="border:none" align="absmiddle" border="0" /></a></td>
      <td><h4>Selesai Stop Mesin 1</h4></td>
      <td>:</td>
      <td width="21%"><input name="stop_selesai" type="text" id="stop_selesai"  placeholder="00:00" pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25 " onkeyup="
  var time = this.value;
  if (time.match(/^\d{2}$/) !== null) {
     this.value = time + ':';
  } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
     this.value = time + '';
  }" value="<?php echo $rw['stop_r']?>" size="5" maxlength="5" />
        <input name="tgl_stop_s" type="text" id="tgl_stop_s" placeholder="0000-00-00" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_s);return false;" value="<?php if($rw['tgl_stop_r']!="0000-00-00"){echo $rw['tgl_stop_r'];}?>" size="10"/>
        <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_s);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal5" style="border:none" align="absmiddle" border="0" /></a></td>
      <td width="24%"><h4>Kode1:
          <select name="kd_stop" id="kd_stop">
          <option value="">Pilih</option>
          <?php $qry1=mysqli_query($con,"SELECT kode FROM tbl_stop_mesin ORDER BY id ASC"); 
		while($r=mysqli_fetch_array($qry1)){
		?>
          <option value="<?php echo $r['kode'];?>" <?php if($rw['kd_stop']==$r['kode']){echo "SELECTED";}?>><?php echo $r['kode'];?></option>
          <?php } ?>
        </select>
          <?php if($_SESSION['lvl']=="SPV") { ?>
          <input type="button" name="btnstop" id="btnstop" value="..."  onclick="window.open('pages/data-stop.php','MyWindow','height=400,width=650');"/>
        <?php } ?>
      </h4></td>
    </tr>
    <tr>
      <td scope="row"><h4>Mulai  Stop Mesin 2</h4></td>
      <td>:</td>
      <td><input name="stop_mulai2" type="text" id="stop_mulai2"  placeholder="00:00" pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25 " onkeyup="
  var time = this.value;
  if (time.match(/^\d{2}$/) !== null) {
     this.value = time + ':';
  } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
     this.value = time + '';
  }" value="<?php echo $rw['stop_l2']?>" size="5" maxlength="5" />
        <input name="tgl_stop_m2" type="text" id="tgl_stop_m2" placeholder="0000-00-00" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_m2);return false;" value="<?php if($rw['tgl_stop_l2']!="0000-00-00"){echo $rw['tgl_stop_l2'];} ?>" size="10" />
        <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_m2);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal6" style="border:none" align="absmiddle" border="0" /></a></td>
      <td><h4>Selesai Stop Mesin 2</h4></td>
      <td>:</td>
      <td><input name="stop_selesai2" type="text" id="stop_selesai2"  placeholder="00:00" pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25 " onkeyup="
  var time = this.value;
  if (time.match(/^\d{2}$/) !== null) {
     this.value = time + ':';
  } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
     this.value = time + '';
  }" value="<?php echo $rw['stop_r2']?>" size="5" maxlength="5" />
        <input name="tgl_stop_s2" type="text" id="tgl_stop_s2" placeholder="0000-00-00" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_s2);return false;" value="<?php if($rw['tgl_stop_r2']!="0000-00-00"){echo $rw['tgl_stop_r2'];}?>" size="10"/>
        <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_s2);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal7" style="border:none" align="absmiddle" border="0" /></a></td>
      <td><h4>Kode2:
          <select name="kd_stop2" id="kd_stop2">
          <option value="">Pilih</option>
          <?php $qry1=mysqli_query($con,"SELECT kode FROM tbl_stop_mesin ORDER BY id ASC"); 
		while($r=mysqli_fetch_array($qry1)){
		?>
          <option value="<?php echo $r['kode'];?>" <?php if($rw['kd_stop2']==$r['kode']){echo "SELECTED";}?>><?php echo $r['kode'];?></option>
          <?php } ?>
        </select>
          <?php if($_SESSION['lvl']=="SPV") { ?>
          <input type="button" name="btnstop2" id="btnstop2" value="..."  onclick="window.open('pages/data-stop.php','MyWindow','height=400,width=650');"/>
        <?php } ?>
      </h4></td>
    </tr>
    <tr>
      <td scope="row"><h4>Mulai  Stop Mesin 3</h4></td>
      <td>:</td>
      <td><input name="stop_mulai3" type="text" id="stop_mulai3"  placeholder="00:00" pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25 " onkeyup="
  var time = this.value;
  if (time.match(/^\d{2}$/) !== null) {
     this.value = time + ':';
  } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
     this.value = time + '';
  }" value="<?php echo $rw['stop_l3']?>" size="5" maxlength="5" />
        <input name="tgl_stop_m3" type="text" id="tgl_stop_m3" placeholder="0000-00-00" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_m3);return false;" value="<?php if($rw['tgl_stop_l3']!="0000-00-00"){echo $rw['tgl_stop_l3'];}?>" size="10" />
        <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_m3);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal8" style="border:none" align="absmiddle" border="0" /></a></td>
      <td><h4>Selesai Stop Mesin 3</h4></td>
      <td>:</td>
      <td><input name="stop_selesai3" type="text" id="stop_selesai3"  placeholder="00:00" pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25 " onkeyup="
  var time = this.value;
  if (time.match(/^\d{2}$/) !== null) {
     this.value = time + ':';
  } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
     this.value = time + '';
  }" value="<?php echo $rw['stop_r3']?>" size="5" maxlength="5" />
        <input name="tgl_stop_s3" type="text" id="tgl_stop_s3" placeholder="0000-00-00" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_s3);return false;" value="<?php if($rw['tgl_stop_r3']!="0000-00-00"){echo $rw['tgl_stop_r3'];}?>" size="10"/>
        <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_s3);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal9" style="border:none" align="absmiddle" border="0" /></a></td>
      <td><h4>Kode3:
          <select name="kd_stop3" id="kd_stop3">
          <option value="">Pilih</option>
          <?php $qry1=mysqli_query($con,"SELECT kode FROM tbl_stop_mesin ORDER BY id ASC"); 
		while($r=mysqli_fetch_array($qry1)){
		?>
          <option value="<?php echo $r['kode'];?>" <?php if($rw['kd_stop3']==$r['kode']){echo "SELECTED";}?>><?php echo $r['kode'];?></option>
          <?php } ?>
        </select>
          <?php if($_SESSION['lvl']=="SPV") { ?>
          <input type="button" name="btnstop3" id="btnstop3" value="..."  onclick="window.open('pages/data-stop.php','MyWindow','height=400,width=650');"/>
        <?php } ?>
      </h4></td>
    </tr>
    <tr>
      <td scope="row"><strong>No. Gerobak</strong></td>
      <td>:</td>
      <td><input type="text" name="no_gerobak" id="no_gerobak" value="<?php echo $rw['no_gerobak'];?>" required/></td>
      <td><h4>Operator</h4></td>
      <td>:</td>
      <td colspan="2"><select name="acc_kain" id="acc_kain">
        <option value="">Pilih</option>
        <?php $qryacc=mysqli_query($con,"SELECT nama FROM tbl_staff ORDER BY nama ASC"); 
		while($racc=mysqli_fetch_array($qryacc)){
		?>
        <option value="<?php echo $racc['nama'];?>" <?php if($racc['nama']==$rw['acc_staff']){echo "SELECTED";}?>><?php echo $racc['nama'];?></option>
        <?php } ?>
        </select>
        <?php if($_SESSION['lvl']=="SPV") { ?>
        <input type="button" name="btnacc" id="btnacc" value="..."  onclick="window.open('pages/data-operator.php','MyWindow','height=400,width=650');"/>
<?php } ?></td>
    </tr>
   </table>
 </fieldset>
 <br>
 <input type="submit" name="btnUbah" id="btnUbah" value="Ubah" class="art-button"/>
        <input type="button" name="batal" id="batal" value="Batal" onclick="window.history.go(-2);" class="art-button"/>
</form>
</body>
</html>