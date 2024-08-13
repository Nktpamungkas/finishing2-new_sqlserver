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
if($_POST['jenis']=="Kurang Dari Dua Hari"){
?>
<input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='index.php'" class="art-button"/>
<input type="hidden" name="button3" id="button3" value="Cetak" onclick="window.open('pages/reports-adm2-cetak.php?tglawal=<?php echo $tglawal; ?>&amp;tglakhir=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>', '_blank')" class="art-button"/>
<input type="button" name="button" id="button" value="Cetak Ke Excel" onClick="window.location.href='pages/reports-adm2-excel.php?tgl1=<?php echo $tglawal; ?>&amp;tgl2=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>&amp;jenis=Kurang'" class="art-button"/>
<br />
<strong><br />
</strong>
<form id="form1" name="form1" method="post" action="">
  <strong>Kartu Kerja Masuk: <?php echo $_POST['jenis'];?></strong>
   <table width="100%" border="0" id="datatables" class="display">
   <thead>
    <tr bgcolor="#99FF99" >
      <th  ><div align="center"><strong><font size="-2">TGL MASUK</font></strong></div></th>
      <th  ><div align="center"><strong><font size="-2">JAM MASUK</font></strong></div></th>
      <th  ><div align="center"><strong><font size="-2">SHIFT</font></strong></div></th>
      <th  ><div align="center"><strong><font size="-2">NOKK</font></strong></div></th>
      <th  ><div align="center"><strong><font size="-2">LANGGANAN</font></strong></div></th>
      <th  ><div align="center"><strong><font size="-2">ORDER</font></strong></div></th>
      <th  ><div align="center"><strong><font size="-2">HANGER</font></strong></div></th>
      <th  ><div align="center"><strong><font size="-2">JENIS KAIN</font></strong></div></th>
      <th  ><div align="center"><strong><font size="-2">NO WARNA</font></strong></div></th>
      <th  ><div align="center"><strong><font size="-2">WARNA</font></strong></div></th>
      <th  ><div align="center"><strong><font size="-2">LOT</font></strong></div></th>
      <th  ><div align="center"><strong><font size="-2">ROLL</font></strong></div></th>
      <th  ><div align="center"><strong><font size="-2">QTY (Kg)</font></strong></div></th>
      <th  ><div align="center"><strong><font size="-2">QTY (yard)</font></strong></div></th>
      <th  ><div align="center"><strong><font size="-2">PROSES</font></strong></div></th>
      <th  ><div align="center"><strong><font size="-2">KONDISI KAIN</font></strong></div></th>
      <th  ><div align="center"><strong><font size="-2">KETERANGAN</font></strong></div></th>
    </tr>
    </thead><tbody>
    <?php 
	
		$sql=mysqli_query($con," SELECT 
	*,`id` as `idp` 
FROM
	`tbl_adm`
WHERE
	`status`='1' and DATEDIFF(now(),tgl_in) < 3 ORDER BY `tgl_in` ASC");
   $no=1;   
   $c=0;
    while($rowd=mysqli_fetch_array($sql)){
		 $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
	  		  ?>
      <tr>
      <td  ><div align="center"><?php echo date('Y-m-d', strtotime($rowd['tgl_in']));?></div></td>
      <td  ><div align="center"><?php echo date('H:i', strtotime($rowd['tgl_in']));?></div></td>
      <td  ><div align="center"><?php echo $rowd['shift'].$rowd['shift1'];?></div></td>
      <td  ><div align="center"><?php echo $rowd['nokk'];?></div></td>
      <td  ><?php echo $rowd['langganan'];?></td>
      <td  ><?php echo $rowd['no_order']; ?></td>
      <td  ><div align="center"><?php echo $rowd['no_item'];?></div></td>
      <td  ><?php echo $rowd['jenis_kain'];?></td>
      <td  ><?php echo $rowd['no_warna']; ?></td>
      <td  ><?php echo $rowd['warna']; ?></td>
      <td  ><div align="center"><?php echo $rowd['lot']; ?></div></td>
      <td  ><div align="center"><?php echo $rowd['rol']; ?></div></td>
      <td  ><div align="center"><?php echo $rowd['qty']; ?></div></td>
      <td  ><div align="center"><?php echo $rowd['panjang']; ?></div></td>
      <td  ><?php echo $rowd['proses']; ?></td>
      <td  ><div align="center"><?php echo $rowd['kondisi_kain']; ?></div></td>
      <td  ><?php echo $rowd['catatan']; ?></td>
      </tr>
      
     <?php 
	 $totqty=$totqty+$rowd['rol'];
	 $totberat=$totberat+$rowd['qty'];
	 $totyard=$totyard+$rowd['panjang'];
	 $no++;} ?>
   </tbody>
   <tfoot>
   <tr bgcolor="#99FF99">
        <td  >&nbsp;</td>
        <td  >&nbsp;</td>
        <td  >&nbsp;</td>
        <td  >&nbsp;</td>
        <td  >&nbsp;</td>
        <td  >&nbsp;</td>
        <td  >&nbsp;</td>
        <td  >&nbsp;</td>
        <td  >&nbsp;</td>
        <td  >&nbsp;</td>
        <td  ><strong>Total</strong></td>
        <td  ><strong><?php echo $totqty;?></strong></td>
        <td  ><strong><?php echo $totberat;?></strong></td>
        <td  ><strong><?php echo $totyard;?></strong></td>
        <td  >&nbsp;</td>
        <td  >&nbsp;</td>
        <td  >&nbsp;</td>
      </tr>
      </tfoot>
  </table>
      
</form>
<?php }else if($_POST['jenis']=="Lebih Dari Dua Hari") { 

$row = 100;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = " SELECT 
	*
FROM
	`tbl_adm` 
WHERE
	`status`='1' and DATEDIFF(now(),tgl_in) < 3 ORDER BY `tgl_in` ASC ";
$pageQry = mysqli_query($con,$pageSql) or die ("error: ".mysqli_error());
$jml	 = mysqli_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='index.php'" class="art-button"/>
<input type="hidden" name="button3" id="button3" value="Cetak" onclick="window.open('pages/reports-adm2-cetak.php?tglawal=<?php echo $tglawal; ?>&amp;tglakhir=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>', '_blank')" class="art-button"/>
<input type="button" name="button" id="button" value="Cetak Ke Excel" onClick="window.location.href='pages/reports-adm2-excel.php?tgl1=<?php echo $tglawal; ?>&amp;tgl2=<?php echo $tglakhir; ?>&amp;shift=<?php echo $shft; ?>&amp;jenis=Lebih'" class="art-button"/>
<br />
<strong><br />
</strong>
<form id="form1" name="form1" method="post" action="">
  <strong>Kartu Kerja Masuk: <?php echo $_POST['jenis'];?></strong>
  <table width="100%" border="0" id="datatables" class="display">
   <thead>
    <tr  >
      <th bgcolor="#99FF99"  ><div align="center"><strong><font size="-2">TGL MASUK</font></strong></div></th>
      <th bgcolor="#99FF99"  ><div align="center"><strong><font size="-2">JAM MASUK</font></strong></div></th>
      <th bgcolor="#99FF99"  ><div align="center"><strong><font size="-2">SHIFT</font></strong></div></th>
      <th bgcolor="#99FF99"  ><div align="center"><strong><font size="-2">NOKK</font></strong></div></th>
      <th bgcolor="#99FF99"  ><div align="center"><strong><font size="-2">LANGGANAN</font></strong></div></th>
      <th bgcolor="#99FF99"  ><div align="center"><strong><font size="-2">ORDER</font></strong></div></th>
      <th bgcolor="#99FF99"  ><div align="center"><strong><font size="-2">HANGER</font></strong></div></th>
      <th bgcolor="#99FF99"  ><div align="center"><strong><font size="-2">JENIS KAIN</font></strong></div></th>
      <th bgcolor="#99FF99"  ><div align="center"><strong><font size="-2">NO WARNA</font></strong></div></th>
      <th bgcolor="#99FF99"  ><div align="center"><strong><font size="-2">WARNA</font></strong></div></th>
      <th bgcolor="#99FF99"  ><div align="center"><strong><font size="-2">LOT</font></strong></div></th>
      <th bgcolor="#99FF99"  ><div align="center"><strong><font size="-2">ROLL</font></strong></div></th>
      <th bgcolor="#99FF99" ><div align="center"><strong><font size="-2">QTY (Kg)</font></strong></div></th>
      <th bgcolor="#99FF99" ><div align="center"><strong><font size="-2">QTY (yard)</font></strong></div></th>
      <th bgcolor="#99FF99" ><div align="center"><strong><font size="-2">PROSES</font></strong></div></th>
      <th bgcolor="#99FF99" ><div align="center"><strong><font size="-2">KONDISI KAIN</font></strong></div></th>
      <th bgcolor="#99FF99" ><div align="center"><strong><font size="-2">KETERANGAN</font></strong></div></th>
    </tr>
    </thead>
	  <tbody>
    <?php 
	
		$sql=mysqli_query($con," SELECT 
	*,`id` as `idp` 
FROM
	`tbl_adm`
WHERE
	`status`='1' and DATEDIFF(now(),tgl_in) > 2 ORDER BY `tgl_in` ASC LIMIT $hal, $row");
   if($hal>0){
   $no=$hal+1;}else
   {$no=1;}
   
   $c=0;
    while($rowd=mysqli_fetch_array($sql)){
		 $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
	  		  ?>
	 		  
      <tr  >
      <td  ><div align="center"><?php echo date('Y-m-d', strtotime($rowd['tgl_in']));?></div></td>
      <td  ><div align="center"><?php echo date('H:i', strtotime($rowd['tgl_in']));?></div></td>
      <td  ><div align="center"><?php echo $rowd['shift'].$rowd['shift1'];?></div></td>
      <td  ><div align="center"><?php echo $rowd['nokk'];?></div></td>
      <td  ><?php echo $rowd['langganan'];?></td>
      <td  ><?php echo $rowd['no_order']; ?></td>
      <td  ><div align="center"><font size="-2"><?php echo $rowd['no_item'];?></div></td>
      <td  ><?php echo $rowd['jenis_kain'];?></td>
      <td  ><?php echo $rowd['no_warna']; ?></td>
      <td  ><?php echo $rowd['warna']; ?></td>
      <td  ><div align="center"><?php echo $rowd['lot']; ?></div></td>
      <td  ><div align="center"><?php echo $rowd['rol']; ?></div></td>
      <td  ><div align="center"><?php echo $rowd['qty']; ?></div></td>
      <td  ><div align="center"><?php echo $rowd['panjang']; ?></div></td>
      <td  ><?php echo $rowd['proses']; ?></td>
      <td  ><div align="center"><?php echo $rowd['kondisi_kain']; ?></div></td>
      <td  ><?php echo $rowd['catatan']; ?></td>
      </tr>
     <?php 
	 
	 $no++;} ?>
   </tbody>
   <tfoot>
    <tr  >
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
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
    </tr>
    </tfoot>
  </table>
</form>

<?php }?>

</body>
</html>