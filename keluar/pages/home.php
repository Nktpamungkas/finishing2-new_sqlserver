<?php if( !isset($_SESSION['usr']) || !isset($_SESSION['pass'])){
echo "<script>window.location='../login.php';</script>"; 
}
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
include ('../koneksi.php');
function nourut(){
include ('../koneksi.php');
$format = date("ymd");
$sql=mysqli_query($con,"SELECT nokk FROM tbl_adm WHERE substr(nokk,1,6) like '%".$format."%' ORDER BY nokk DESC LIMIT 1 ") or die (mysqli_error());
$d=mysqli_num_rows($sql);
if($d>0){
$r=mysqli_fetch_array($sql);
$d=$r['nokk'];
$str=substr($d,6,2);
$Urut = (int)$str;
}else{
$Urut = 0;
}
$Urut = $Urut + 1;
$Nol="";
$nilai=2-strlen($Urut);
for ($i=1;$i<=$nilai;$i++){
$Nol= $Nol."0";
}
$nipbr =$format.$Nol.$Urut;
return $nipbr;
}
$nou=nourut();
if($_REQUEST['kk']!='')
    {$idkk="";}else{$idkk=$_GET['idkk'];}
   
   if($idkk!="")   {
    date_default_timezone_set('Asia/Jakarta');
	$qry1=mysqli_query($con,"SELECT * FROM tbl_adm WHERE nokk='$idkk' and status='2'  ORDER BY id DESC LIMIT 1");
	$rw1=mysqli_fetch_array($qry1);
	$rc1=mysqli_num_rows($qry1);
	   	   
    $qry=mysqli_query($con,"SELECT * FROM tbl_adm WHERE nokk='$idkk' and status='1' and ISNULL(tgl_out) ORDER BY id DESC LIMIT 1");
	$rw=mysqli_fetch_array($qry);
	$rc=mysqli_num_rows($qry);
	   if($rc>0){}else{ echo "<script>alert('Sudah Keluar $rw1[tgl_out] ke $rw1[tujuan]' );</script>";}
	 
   }
     //
     
     ?>
     
     <?php
     if(isset($_POST['btnSimpan'])){
		$shift=$_POST['shift'];
	    $shift1=$_POST['shift2'];
		$note=str_replace("'","''",$_POST['catatan']);
		$tujuan=$_POST['tujuan'];
		//$tglout=$_POST[tgl_proses_k]." ".$_POST[proses_out]; 
	$simpanSql = "UPDATE tbl_adm SET
	`shift_out`='$shift',
	`shift1_out`='$shift1',
	`catatan`='$note',
	`tujuan`='$tujuan',
	`tgl_update`=now(),
	`status`='2',
	`tgl_out`=now()
	WHERE `id`='$_POST[id]'";
		mysqli_query($con,$simpanSql) or die ("Gagal Ubah".mysqli_error());
		
		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=?idkk=$idkk&status=Data Sudah DiUbah'>";
	}
	?>
<form id="form1" name="form1" method="post" action="" >
 <fieldset>
  <legend>Input Data Kartu Kerja Keluar</legend>
  <table width="100%" border="0">
    <tr>
      <th colspan="6" scope="row"><font color="#FF0000"><?php echo $_GET['status'];?></font></th>
    </tr>
    <tr>
      <td width="11%" scope="row"><h4>Nokk</h4></td>
      <td width="1%">:</td>
      <td width="28%"><input name="nokk" type="text" id="nokk" size="17" onchange="window.location='?idkk='+this.value" value="<?php echo $_GET['idkk'];?>"/><input type="hidden"  value="<?php echo $rw['id'];?>" name="id"/></td>
      <td width="14%"><h4>Group Shift</h4></td>
      <td width="1%">:</td>
      <td width="45%"><select name="shift" id="shift" required>
          <option value="">Pilih</option>
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
      </select></td>
    </tr>
    <tr>
      <td scope="row"><h4>Langganan/Buyer</h4></td>
      <td>:</td>
      <td><input name="buyer" type="text" id="buyer" size="45" value="<?php if($cek>0){echo $ssr1['partnername']."/".$ssr2['partnername'];}else{echo $rw['langganan'];}?>"/></td>
      <td><strong>Shift</strong></td>
      <td>:</td>
      <td><select name="shift2" id="shift2" required="required">
        <option value="">Pilih</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
      </select></td>
    </tr>
    <tr>
      <td scope="row"><h4>No. Order</h4></td>
      <td>:</td>
      <td><input type="text" name="no_order" id="no_order" value="<?php if($cek>0){echo $ssr['documentno'];}else{echo $rw['no_order'];}?>"/>
      </td>
      <td><strong>Tujuan</strong></td>
      <td>:</td>
      <td><select name="tujuan" id="tujuan" required="required">
        <option value="">Pilih</option>
        <?php $qry1=mysqli_query($con,"SELECT tujuan FROM tbl_tujuan ORDER BY id ASC"); 
		while($r=mysqli_fetch_array($qry1)){
		?>
        <option value="<?php echo $r['tujuan']; ?>" <?php if($rw['tujuan']==$r['tujuan']){echo "selected";}?>><?php echo $r['tujuan'];?></option>
        <?php } ?>
      </select>
      <input type="button" name="btnproses" id="btnproses" value="..."  onclick="window.open('pages/data-tujuan.php','MyWindow','height=400,width=650');"/></td>
    </tr>
    <tr>
      <td valign="top" scope="row"><h4>Jenis Kain</h4></td>
      <td valign="top">:</td>
      <td><textarea name="jenis_kain" cols="35" id="jenis_kain"><?php if($cek>0){echo $ssr['productcode']." / ".$ssr['description'];}else{echo $rw['jenis_kain'];}?></textarea></td>
      <td valign="top"><h4>Catatan</h4></td>
      <td valign="top">:</td>
      <td valign="top"><textarea name="catatan" cols="35" id="catatan"><?php echo $rw['catatan'];?></textarea></td>
    </tr>
    <tr>
      <td scope="row"><strong>Hanger/Item</strong></td>
      <td>:</td>
      <td><input type="text" name="no_item" id="no_item" value="<?php if($cek>0){echo $ssr['productcode'];}else{echo $rw['no_item'];}?>"/></td>
      <td width="14%"><strong>Lebar X Gramasi</strong></td>
      <td width="1%">:</td>
      <td><input name="lebar" type="text" id="lebar" size="6" value="<?php if($cek>0){echo $ssr['cuttablewidth'];}else{echo $rw['lebar'];}?>" placeholder="0" />
        &quot; X
        <input name="gramasi" type="text" id="gramasi" size="6" value="<?php if($cek>0){echo $ssr['weight'];}else{echo $rw['gramasi'];}?>" placeholder="0" /></td>
    </tr>
    <tr>
      <td scope="row"><strong>No Warna</strong></td>
      <td>:</td>
      <td><input name="no_warna" type="text" id="no_warna" size="35" value="<?php if($cek>0){echo $ssr['colorno'];}else{echo $rw['no_warna'];}?>"/></td>
      <td width="14%"><strong>Berat</strong></td>
      <td width="1%">:</td>
      <td><input name="qty" type="text" id="qty" size="8" value="<?php if($cLot>0){echo $sLot['Weight'];}else{echo $rw['qty'];}?>" placeholder="0.00" />
        <strong>Kg</strong></td>
    </tr>
    <tr>
      <td scope="row"><h4>Warna</h4></td>
      <td>:</td>
      <td><input name="warna" type="text" id="warna" size="35" value="<?php if($cek>0){echo $ssr['color'];}else{echo $rw['warna'];}?>"/></td>
      <td><strong>Panjang</strong></td>
      <td>:</td>
      <td><input name="qty2" type="text" id="qty2" size="8" value="<?php echo $rw['panjang'];?>" placeholder="0.00" onFocus="jumlah();" />
        <strong>Yard</strong></td>
    </tr>
    <tr>
      <td scope="row"><h4>Lot</h4></td>
      <td>:</td>
      <td><input name="lot" type="text" id="lot" size="7" value="<?php if($cLot>0){echo $rowLot['TotalLot']."-".$nomorLot;}else{echo $rw['lot'];}?>"/></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td scope="row"><h4>Roll</h4></td>
      <td>:</td>
      <td><input name="rol" type="text" id="rol" size="3" placeholder="0" pattern="[0-9]{1,}" value="<?php if($cLot>0){echo $sLot['RollCount'];}else{ echo $rw['rol'];}?>" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" scope="row"></td>
    </tr>
  </table>
  </fieldset>
  <br>
  <input type="submit" name="btnSimpan" id="btnSimpan" value="Simpan" class="art-button"/>
        <input type="button" name="batal" id="batal" value="Batal" onclick="window.location.href='index.php'" class="art-button"/>
      <input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='../index.php'" class="art-button"/>
</form>
</body>
</html>