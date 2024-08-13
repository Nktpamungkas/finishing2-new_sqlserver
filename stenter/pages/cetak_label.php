<?php
$con=mysqli_connect("10.0.1.91","dit","4dm1n","db_finishing");
//--
$idkk=$_REQUEST['idkk'];
$act=$_GET['g'];
$data=mysqli_query("SELECT * FROM tbl_produksi WHERE nokk='$idkk' and jns_mesin='stenter' and shift='$_GET[shift]' and shift2='$_GET[shift2]' ORDER BY id DESC LIMIT 1");
$r=mysqli_fetch_array($data);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="styles_cetak.css" rel="stylesheet" type="text/css">
<title>Cetak Label</title>
<style>
	td{
	border-top:0px #000000 solid; 
	border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; 
	border-right:0px #000000 solid;
	}
	</style>
</head>


<body>
<table width="100%" border="0"style="width: 7in;">
  <tbody>    
    <tr>
      <td align="left" valign="top" style="height: 1.6in;"><table width="100%" border="0" class="table-list1" style="width: 2.3in;">
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size: 8px;"><?php echo $r['nokk'];?></div></td>
        </tr>
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;">
            <?php echo $r['langganan'];?></div></td>
        </tr>
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><?php echo substr($r['no_po'],0,31);?></div></td>
        </tr>
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><strong><?php echo $r['no_order'];?></strong><?php echo " (".$r['no_item'].")";?></div></td>
        </tr>
        <tr>
          <td colspan="3" valign="top" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:6px;"><?php echo substr($r['jenis_kain'],0,100);?></div></td>
        </tr>
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><span style="font-size:7px;"><?php echo "<strong><span style='font-size:9px;'>".substr($r['warna'],0,60)."</span></strong>/".substr($r['no_warna'],0,15);?></span></div></td>
        </tr>
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><?php echo date('d-m-Y', strtotime(substr($r['tgl_update'],0,10)));?>&nbsp;/ &nbsp; &nbsp;<span style="font-size: 9px;"><?php echo $r['no_mesin'];?></span></div></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><?php echo $r['lot'];?></div></td>
          <td width="14%" align="right" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;">L&amp;G:</div></td>
          <td width="51%" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><?php echo $r['lebar_h']." x ".$r['gramasi_h'];?> &nbsp; &nbsp; YD: <span style="font-size: 9px;"><?php echo $r['panjang_h'];?></span></div></td>
        </tr>
        <tr>
          <td colspan="2" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><span style="font-size:9px;">&nbsp;<span style="font-size: 9px;"><?php echo $r['suhu'];?> x <?php echo $r['speed'];?> x <?php echo $r['overfeed'];?></span></span></td>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><span style="font-size: 9px;">Penyusutan:</span></td>
          </tr>
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">&nbsp;</td>
        </tr>
      </table></td>
      <td align="left" valign="top" style="height: 1.6in;"><table width="100%" border="0" class="table-list1" style="width: 2.3in;">
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size: 8px;"><?php echo $r['nokk'];?></div></td>
        </tr>
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><?php echo $r['langganan'];?></div></td>
        </tr>
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><?php echo substr($r['no_po'],0,31);?></div></td>
        </tr>
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><strong><?php echo $r['no_order'];?></strong><?php echo " (".$r['no_item'].")";?></div></td>
        </tr>
        <tr>
          <td colspan="3" valign="top" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:6px;"><?php echo substr($r['jenis_kain'],0,100);?></div></td>
        </tr>
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><span style="font-size:7px;"><?php echo "<strong><span style='font-size:9px;'>".substr($r['warna'],0,60)."</span></strong>/".substr($r['no_warna'],0,15);?></span></div></td>
        </tr>
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><?php echo date('d-m-Y', strtotime(substr($r['tgl_update'],0,10)));?>&nbsp;/ &nbsp; &nbsp;<span style="font-size: 9px;"><?php echo $r['no_mesin'];?></span></div></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><?php echo $r['lot'];?></div></td>
          <td width="14%" align="right" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;">L&amp;G:</div></td>
          <td width="51%" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><?php echo $r['lebar_h']." x ".$r['gramasi_h'];?> &nbsp; &nbsp; YD: <span style="font-size: 9px;"><?php echo $r['panjang_h'];?></span></div></td>
        </tr>
        <tr>
          <td colspan="2" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><span style="font-size:9px;">&nbsp;<span style="font-size: 9px;"><?php echo $r['suhu'];?> x <?php echo $r['speed'];?> x <?php echo $r['overfeed'];?></span></span></td>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><span style="font-size: 9px;">Penyusutan:</span></td>
          </tr>
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">&nbsp;</td>
        </tr>
      </table></td>
      <td align="left" valign="top" style="height: 1.6in;"><table width="100%" border="0" class="table-list1" style="width: 2.3in;">
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size: 8px;"><?php echo $r['nokk'];?></div></td>
        </tr>
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><?php echo $r['langganan'];?></div></td>
        </tr>
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><?php echo substr($r['no_po'],0,31);?></div></td>
        </tr>
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;'
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><strong><?php echo $r['no_order'];?></strong><?php echo " (".$r['no_item'].")";?></div></td>
        </tr>
        <tr>
          <td colspan="3" valign="top" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:6px;"><?php echo substr($r['jenis_kain'],0,100);?></div></td>
        </tr>
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><span style="font-size:7px;"><?php echo "<strong><span style='font-size:9px;'>".substr($r['warna'],0,60)."</span></strong>/".substr($r['no_warna'],0,15);?></span></div></td>
        </tr>
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><?php echo date('d-m-Y', strtotime(substr($r['tgl_update'],0,10)));?>&nbsp;/ &nbsp; &nbsp;<span style="font-size: 9px;"><?php echo $r['no_mesin'];?></span></div></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><?php echo $r['lot'];?></div></td>
          <td width="14%" align="right" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;">L&amp;G:</div></td>
          <td width="51%" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size:9px;"><?php echo $r['lebar_h']." x ".$r['gramasi_h'];?> &nbsp; &nbsp; YD: <span style="font-size: 9px;"><?php echo $r['panjang_h'];?></span></div></td>
        </tr>
        <tr>
          <td colspan="2" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><span style="font-size:9px;">&nbsp;<span style="font-size: 9px;"><?php echo $r['suhu'];?> x <?php echo $r['speed'];?> x <?php echo $r['overfeed'];?></span></span></td>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><span style="font-size: 9px;">Penyusutan:</span></td>
          </tr>
        <tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </tbody>
</table>
</body>
</html>