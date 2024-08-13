<?php 
ini_set("error_reporting", 1);
session_start();
include ('../koneksi.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Detail Proses Actual Stenter</title>
<script>
function ganti()
{     

	var lprn= document.forms['form1']['jns'].value;  
	if(lprn=="Produksi Finishing"){window.location.href="?p=home";}
	else if(lprn=="Adm Finishing"){window.location.href="?p=home2";}
	else if(lprn=="Detail In-Out"){window.location.href="?p=home3";}
	else if(lprn=="Grafik"){window.location.href="?p=home4";}
	else if(lprn=="Stoppage Mesin"){window.location.href="?p=home6";}

}
</script>
</head>

<body>
<form id="form1" name="form1" method="post" action="index.php?p=reports-adm-detail-stenter" >
      <table width="470" border="0">
        <tr>
          <td colspan="3"><div align="center"><strong>LAPORAN DETAIL PROSES ACTUAL</strong></div> 
         </div>
          <?php 
          $user_name=$_SESSION['username'];
          date_default_timezone_set('Asia/Jakarta');
        $tgl=date("Y-M-d h:i:s A");
          echo $tgl;?><br /></td>
        </tr>
        <tr>
          <td><strong>Jenis Laporan</strong></td>
          <td>:</td>
          <td><label for="jns"></label>
            <select name="jns" id="jns" onchange="ganti();">
              <option value="Produksi Finishing">Produksi Finishing</option>
              <option value="Adm Finishing" >Adm Finishing</option>
              <option value="Detail In-Out">Detail In-Out</option>
              <option value="Grafik">Grafik</option>
              <option value="Detail Proses" selected="selected">Detail Proses</option>  
          </select></td>
        </tr>
	    <tr>
          <td><strong>Mesin</strong></td>
          <td>:</td>
          <td><select name="mesin" id="mesin" onChange="window.location='?p=home5&mesin='+this.value">
            <option value="">Pilih</option>
            <option value="Stenter"<?php if($_GET['mesin']=="Stenter"){ echo "SELECTED";}?>>Stenter</option>
            <option value="Compact"<?php if($_GET['mesin']=="Compact"){ echo "SELECTED";}?>>Compact</option>
			<option value="Oven"<?php if($_GET['mesin']=="Oven"){ echo "SELECTED";}?>>Oven</option>
			<option value="Belah"<?php if($_GET['mesin']=="Belah"){ echo "SELECTED";}?>>Belah</option>  
			<option value="Lipat"<?php if($_GET['mesin']=="Lipat"){ echo "SELECTED";}?>>Lipat</option>
          </select></td>
        </tr>
        <tr valign="middle">
          <td width="127"><strong>Tanggal Awal</strong></td>
          <td width="3">:</td>
          <td width="280"><input name="awal" type="text" id="awal" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.awal);return false;" size="14" required="required"/><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.awal);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal" style="border:none" align="absmiddle" border="0" /></a></td>
        </tr>
        <tr>
        
          <td><strong>Tanggal Akhir</strong></td>
          <td>:</td>
          <td width="280"><input name="akhir" type="text" id="akhir" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.akhir);return false;" size="14" required="required"/><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.akhir);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal" style="border:none" align="absmiddle" border="0" /></a></td>
        </tr>
        
	 <tr>
          <td><strong>No Mesin</strong></td>
          <td>:</td>
          <td><select name="nama_mesin" id="nama_mesin">
            <option value="">Pilih</option>
		  <?php $qnmc=mysqli_query($con,"SELECT no_mesin FROM tbl_no_mesin WHERE jenis LIKE '$_GET[mesin]%' ORDER BY no_mesin ASC");
			  while($rmc=mysqli_fetch_array($qnmc)){?>	  
            <option value="<?php echo $rmc['no_mesin']; ?>"><?php echo $rmc['no_mesin']; ?></option>
			  <?php } ?>
       </select></td>
        </tr>
        <tr>
          <td><strong>Group Shift</strong></td>
          <td>:</td>
          <td><select name="shift2" id="shift2">
            <option value="ALL">ALL</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
          </select></td>
        </tr>
        <!--<tr>
          <td><strong>Shift</strong></td>
          <td>:</td>
          <td><label for="shift"></label>
            <select name="shift" id="shift">
              <option value="ALL">ALL</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
          </select></td>
        </tr>-->
        <tr>
          <td colspan="3"><input type="submit" name="button" id="button" value="Lihat Data" class="art-button" />            <input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='../index.php'" class="art-button"/></td>
        </tr>
      </table>
</form>
</body>
</html>