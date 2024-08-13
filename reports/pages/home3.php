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
	else if(lprn=="Grafik"){window.location.href="?p=home4";}
	else if(lprn=="Detail Proses"){window.location.href="?p=home5";}
	else if(lprn=="Stoppage Mesin"){window.location.href="?p=home6";}

}
</script>
</head>

<body>
<form id="form1" name="form1" method="post" action="index.php?p=reports-adm2" >
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
              <option value="Detail In-Out" selected="selected">Detail In-Out</option>
              <option value="Grafik">Grafik</option>
              <option value="Detail Proses">Detail Proses</option>              
          </select></td>
        </tr>
        <tr>
          <td><strong>Kartu Kerja</strong></td>
          <td>:</td>
          <td><select name="jenis" id="jenis">
            <option value="">Pilih</option>
            <option value="Kurang Dari Dua Hari">Kurang Dari Dua Hari</option>
            <option value="Lebih Dari Dua Hari">Lebih Dari Dua Hari</option>
          </select></td>
        </tr>
        <tr>
          <td colspan="3"><input type="submit" name="button" id="button" value="Lihat Data" class="art-button" />            <input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='../index.php'" class="art-button"/></td>
        </tr>
      </table>
</form>
</body>
</html>