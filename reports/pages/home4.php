<?php 
ini_set("error_reporting", 1);
session_start();
include ('../koneksi.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Produksi Finishing</title>
<script>
function ganti()
{     

	var lprn= document.forms['form1']['jns'].value;  
	if(lprn=="Produksi Finishing"){window.location.href="?p=home";}
	else if(lprn=="Adm Finishing"){window.location.href="?p=home2";}
	else if(lprn=="Detail In-Out"){window.location.href="?p=home3";}
	else if(lprn=="Detail Proses"){window.location.href="?p=home5";}
	else if(lprn=="Stoppage Mesin"){window.location.href="?p=home6";}

}
	function ganti1()
{
	var jenis= document.forms['form1']['jenis'].value;
	var read=document.getElementById("bulan");
	if(jenis=="Tahun"){
		read.setAttribute("hidden",true);
		document.form1.bulan.selectedIndex="0";
		document.form1.tahun.selectedIndex="0";
	}
	else if(jenis=="Bulan"){
		read.removeAttribute("hidden");
		document.form1.bulan.selectedIndex="0";
		document.form1.tahun.selectedIndex="0";
	}
	
}
</script>
</head>

<body>
<form id="form1" name="form1" method="post" action="index.php?p=grafik" >
      <table width="470" border="0">
        <tr>
          <td colspan="3"><div align="center"><strong>LAPORAN ADM FINISHING</strong></div> 
         </div>
          <?php 
          $user_name=$_SESSION['username'];
          date_default_timezone_set('Asia/Jakarta');
        $tgl=date("Y-M-d h:i:s A");
          echo $tgl;?><br /></td>
        </tr>
        <tr>
          <td width="127"><strong>Jenis Laporan</strong></td>
          <td width="3">:</td>
          <td width="280"><label for="jns"></label>
            <select name="jns" id="jns" onchange="ganti();">
              <option value="Produksi Finishing">Produksi Finishing</option>
              <option value="Adm Finishing">Adm Finishing</option>
              <option value="Detail In-Out">Detail In-Out</option>
              <option value="Grafik" selected="selected">Grafik</option>
              <option value="Detail Proses">Detail Proses</option>              
          </select></td>
        </tr>
        <tr>
          <td><strong>Perbandingan</strong></td>
          <td>:</td>
          <td><select name="jenis" id="jenis" onchange="ganti1();">
            <option value="">Pilih</option>
            <option value="Tahun">Tahun</option>
            <option value="Bulan">Bulan</option>
          </select></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><select name="bulan" id="bulan">
            <option value="">Pilih</option>
            <option value="01">Januari</option>
            <option value="02">Febuari</option>
            <option value="03">Maret</option>
            <option value="04">April</option>
            <option value="05">Mei</option>
            <option value="06">Juni</option>
            <option value="07">Juli</option>
            <option value="08">Agustus</option>
            <option value="09">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
          </select>
            <select name="tahun" id="tahun">
              <option value="">Pilih</option>
              <option value="2017">2017</option>
              <option value="2018">2018</option>
              <option value="2019">2019</option>
              <option value="2020">2020</option>
              <option value="2021">2021</option>
              <option value="2022">2022</option>
              <option value="2023">2023</option>
              <option value="2024">2024</option>
              <option value="2025">2025</option>
          </select></td>
        </tr>
        <tr>
          <td colspan="3"><input type="submit" name="button" id="button" value="Lihat Data" class="art-button" />            <input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='../index.php'" class="art-button"/></td>
        </tr>
      </table>
</form>
</body>
</html>