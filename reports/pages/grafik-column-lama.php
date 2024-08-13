<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Persentase Perbulan</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/ilmudetil.css">
	<script src="../assets/js1/highcharts.js"></script>
	<script src="../assets/js1/exporting.js"></script>
	<script src="../assets/js1/jquery-1.10.1.min.js"></script>
</head>

<body>
<?php 
	if($_POST[bulan]=="01"){$bln="Januari";}
	if($_POST[bulan]=="02"){$bln="Febuari";}
	if($_POST[bulan]=="03"){$bln="Maret";}
	if($_POST[bulan]=="04"){$bln="April";}
	if($_POST[bulan]=="05"){$bln="Mei";}
	if($_POST[bulan]=="06"){$bln="Juni";}
	if($_POST[bulan]=="07"){$bln="Juli";}
	if($_POST[bulan]=="08"){$bln="Agustus";}
	if($_POST[bulan]=="09"){$bln="September";}
	if($_POST[bulan]=="10"){$bln="Oktober";}
	if($_POST[bulan]=="11"){$bln="November";}
	if($_POST[bulan]=="12"){$bln="Desember";}
	$tgl=$_POST[tahun]."-".$_POST[bulan];
	$thn=substr($_POST[tahun],2,2);
$qry1=mysql_query("SELECT 
	if(DATE_FORMAT(tgl_out,'%m')='01',COUNT(qty),0) as `jan`,
    if(DATE_FORMAT(tgl_out,'%m')='02',COUNT(qty),0) as `feb`,
    if(DATE_FORMAT(tgl_out,'%m')='03',COUNT(qty),0) as `mar`,
	if(DATE_FORMAT(tgl_out,'%m')='04',COUNT(qty),0) as `apr`,
	if(DATE_FORMAT(tgl_out,'%m')='05',COUNT(qty),0) as `mei`,
	if(DATE_FORMAT(tgl_out,'%m')='06',COUNT(qty),0) as `jun`,
	if(DATE_FORMAT(tgl_out,'%m')='07',COUNT(qty),0) as `jul`,
    if(DATE_FORMAT(tgl_out,'%m')='08',COUNT(qty),0) as `agu`,
    if(DATE_FORMAT(tgl_out,'%m')='09',COUNT(qty),0) as `sep`,
	if(DATE_FORMAT(tgl_out,'%m')='10',COUNT(qty),0) as `okt`,
	if(DATE_FORMAT(tgl_out,'%m')='11',COUNT(qty),0) as `nov`,
	if(DATE_FORMAT(tgl_out,'%m')='12',COUNT(qty),0) as `des`
FROM
	`tbl_adm`
WHERE
	`status`='2' AND DATEDIFF(tgl_out,tgl_in) < 3 AND DATE_FORMAT(tgl_out,'%Y')='$_POST[tahun]' ORDER BY `tgl_in` ASC");
$r1=mysql_fetch_array($qry1);
$qry2=mysql_query("SELECT 
	if(DATE_FORMAT(tgl_out,'%m')='01',COUNT(qty),0) as `jan`,
    if(DATE_FORMAT(tgl_out,'%m')='02',COUNT(qty),0) as `feb`,
    if(DATE_FORMAT(tgl_out,'%m')='03',COUNT(qty),0) as `mar`,
	if(DATE_FORMAT(tgl_out,'%m')='04',COUNT(qty),0) as `apr`,
	if(DATE_FORMAT(tgl_out,'%m')='05',COUNT(qty),0) as `mei`,
	if(DATE_FORMAT(tgl_out,'%m')='06',COUNT(qty),0) as `jun`,
	if(DATE_FORMAT(tgl_out,'%m')='07',COUNT(qty),0) as `jul`,
    if(DATE_FORMAT(tgl_out,'%m')='08',COUNT(qty),0) as `agu`,
    if(DATE_FORMAT(tgl_out,'%m')='09',COUNT(qty),0) as `sep`,
	if(DATE_FORMAT(tgl_out,'%m')='10',COUNT(qty),0) as `okt`,
	if(DATE_FORMAT(tgl_out,'%m')='11',COUNT(qty),0) as `nov`,
	if(DATE_FORMAT(tgl_out,'%m')='12',COUNT(qty),0) as `des`
FROM
	`tbl_adm`
WHERE
	`status`='2' AND DATEDIFF(tgl_out,tgl_in) > 2 AND DATE_FORMAT(tgl_out,'%Y')='$_POST[tahun]' ORDER BY `tgl_in` ASC");
$r2=mysql_fetch_array($qry2);
	  if(($r1[jan]+$r2[jan])>0){$tot01r1=($r1[jan]/($r1[jan]+$r2[jan]))*100;}else{$tot01r1="0.00";}
	  if(($r1[jan]+$r2[jan])>0){$tot01r2=($r2[jan]/($r1[jan]+$r2[jan]))*100;}else{$tot01r2="0.00";}
	  if(($r1[feb]+$r2[feb])>0){$tot02r1=($r1[feb]/($r1[feb]+$r2[feb]))*100;}else{$tot02r1="0.00";}
	  if(($r1[feb]+$r2[feb])>0){$tot02r2=($r2[feb]/($r1[feb]+$r2[feb]))*100;}else{$tot02r2="0.00";}
	  if(($r1[mar]+$r2[mar])>0){$tot03r1=($r1[mar]/($r1[mar]+$r2[mar]))*100;}else{$tot03r1="0.00";}
	  if(($r1[mar]+$r2[mar])>0){$tot03r2=($r2[mar]/($r1[mar]+$r2[mar]))*100;}else{$tot03r2="0.00";}
	  if(($r1[apr]+$r2[apr])>0){$tot04r1=($r1[apr]/($r1[apr]+$r2[apr]))*100;}else{$tot04r1="0.00";}
	  if(($r1[apr]+$r2[apr])>0){$tot04r2=($r2[apr]/($r1[apr]+$r2[apr]))*100;}else{$tot04r2="0.00";}	
	  if(($r1[mei]+$r2[mei])>0){$tot05r1=($r1[mei]/($r1[mei]+$r2[mei]))*100;}else{$tot05r1="0.00";}
	  if(($r1[mei]+$r2[mei])>0){$tot05r2=($r2[mei]/($r1[mei]+$r2[mei]))*100;}else{$tot05r2="0.00";}
	  if(($r1[jun]+$r2[jun])>0){$tot06r1=($r1[jun]/($r1[jun]+$r2[jun]))*100;}else{$tot06r1="0.00";}
	  if(($r1[jun]+$r2[jun])>0){$tot06r2=($r2[jun]/($r1[jun]+$r2[jun]))*100;}else{$tot06r2="0.00";}
	  if(($r1[jul]+$r2[jul])>0){$tot07r1=($r1[jul]/($r1[jul]+$r2[jul]))*100;}else{$tot07r1="0.00";}
	  if(($r1[jul]+$r2[jul])>0){$tot07r2=($r2[jul]/($r1[jul]+$r2[jul]))*100;}else{$tot07r2="0.00";}
	  if(($r1[agu]+$r2[agu])>0){$tot08r1=($r1[agu]/($r1[agu]+$r2[agu]))*100;}else{$tot08r1="0.00";}
	  if(($r1[agu]+$r2[agu])>0){$tot08r2=($r2[agu]/($r1[agu]+$r2[agu]))*100;}else{$tot08r2="0.00";}	
	  if(($r1[sep]+$r2[sep])>0){$tot09r1=($r1[sep]/($r1[sep]+$r2[sep]))*100;}else{$tot09r1="0.00";}
	  if(($r1[sep]+$r2[sep])>0){$tot09r2=($r2[sep]/($r1[sep]+$r2[sep]))*100;}else{$tot09r2="0.00";}
	  if(($r1[okt]+$r2[okt])>0){$tot10r1=($r1[okt]/($r1[okt]+$r2[okt]))*100;}else{$tot10r1="0.00";}
	  if(($r1[okt]+$r2[okt])>0){$tot10r2=($r2[okt]/($r1[okt]+$r2[okt]))*100;}else{$tot10r2="0.00";}
	  if(($r1[nov]+$r2[nov])>0){$tot11r1=($r1[nov]/($r1[nov]+$r2[nov]))*100;}else{$tot11r1="0.00";}
	  if(($r1[nov]+$r2[nov])>0){$tot11r2=($r2[nov]/($r1[nov]+$r2[nov]))*100;}else{$tot11r2="0.00";}
	  if(($r1[des]+$r2[des])>0){$tot12r1=($r1[des]/($r1[des]+$r2[des]))*100;}else{$tot12r1="0.00";}
	  if(($r1[des]+$r2[des])>0){$tot12r2=($r2[des]/($r1[des]+$r2[des]))*100;}else{$tot12r2="0.00";}
	?>
<strong>PERSENTASE </strong> <strong>LAMA PROSES KARTU KERJA PADA DEPT FIN TAHUN <?php echo strtoupper($_POST[tahun]);?></strong>
<table width="100%" border="1">
    <tr bgcolor="#E49717">
      <th width="28%" height="25">Lama Proses</th>
      <th width="6%">Jan'<?php echo $thn;?></th>
      <th width="6%">Feb'<?php echo $thn;?></th>
      <th width="6%">Mar'<?php echo $thn;?></th>
      <th width="6%">Apr'<?php echo $thn;?></th>
      <th width="6%">Mei'<?php echo $thn;?></th>
      <th width="6%">Jun'<?php echo $thn;?></th>
      <th width="6%">Jul'<?php echo $thn;?></th>
      <th width="6%">Agu'<?php echo $thn;?></th>
      <th width="6%">Sep'<?php echo $thn;?></th>
      <th width="6%">Okt'<?php echo $thn;?></th>
      <th width="6%">Nov'<?php echo $thn;?></th>
      <th width="6%">Des'<?php echo $thn;?></th>
    </tr>
    <tr bgcolor="#A1F466">
      <td>Kartu Kerja Selesai Kurang Dari 2 Hari</td>
      <td align="right"><div align="center"> <?php echo $jan1=round($tot01r1,2);?></div></td>
      <td align="right"><div align="center"> <?php echo $feb1=round($tot02r1,2);?></div></td>
      <td align="right"><div align="center"> <?php echo $mar1=round($tot03r1,2);?></div></td>
      <td align="right"><div align="center"> <?php echo $apr1=round($tot04r1,2);?></div></td>
      <td align="right"><div align="center"> <?php echo $mei1=round($tot05r1,2);?></div></td>
      <td align="right"><div align="center"> <?php echo $jun1=round($tot06r1,2);?></div></td>
      <td align="right"><div align="center"> <?php echo $jul1=round($tot07r1,2);?></div></td>
      <td align="right"><div align="center"> <?php echo $agu1=round($tot08r1,2);?></div></td>
      <td align="right"><div align="center"> <?php echo $sep1=round($tot09r1,2);?></div></td>
      <td align="right"><div align="center"> <?php echo $okt1=round($tot10r1,2);?></div></td>
      <td align="right"><div align="center"> <?php echo $nov1=round($tot11r1,2);?></div></td>
      <td align="right"><div align="center"> <?php echo $des1=round($tot12r1,2);?></div></td>
    </tr>
    <tr bgcolor="#F3CACB">
      <td>Kartu Kerja Selesai Lebih Dari 2 Hari</td>
      <td align="right" bgcolor="#F3CACB"><div align="center"> <?php echo $jan2=round($tot01r2,2);?></div></td>
      <td align="right" bgcolor="#F3CACB"><div align="center"> <?php echo $feb2=round($tot02r2,2);?></div></td>
      <td align="right" bgcolor="#F3CACB"><div align="center"> <?php echo $mar2=round($tot03r2,2);?></div></td>
      <td align="right" bgcolor="#F3CACB"><div align="center"> <?php echo $apr2=round($tot04r2,2);?></div></td>
      <td align="right" bgcolor="#F3CACB"><div align="center"> <?php echo $mei2=round($tot05r2,2);?></div></td>
      <td align="right" bgcolor="#F3CACB"><div align="center"> <?php echo $jun2=round($tot06r2,2);?></div></td>
      <td align="right" bgcolor="#F3CACB"><div align="center"> <?php echo $jul2=round($tot07r2,2);?></div></td>
      <td align="right" bgcolor="#F3CACB"><div align="center"> <?php echo $agu2=round($tot08r2,2);?></div></td>
      <td align="right" bgcolor="#F3CACB"><div align="center"> <?php echo $sep2=round($tot09r2,2);?></div></td>
      <td align="right" bgcolor="#F3CACB"><div align="center"> <?php echo $okt2=round($tot10r2,2);?></div></td>
      <td align="right" bgcolor="#F3CACB"><div align="center"> <?php echo $nov2=round($tot11r2,2);?></div></td>
      <td align="right" bgcolor="#F3CACB"><div align="center"> <?php echo $des2=round($tot12r2,2);?></div></td>
    </tr>
    <tr bgcolor="#CFB8F5">
      <td>Total</td>
      <td align="right"><div align="center"><?php echo $jan1+$jan2;?></div></td>
      <td align="right"><div align="center"><?php echo $feb1+$feb2;?></div></td>
      <td align="right"><div align="center"><?php echo $mar1+$mar2;?></div></td>
      <td align="right"><div align="center"><?php echo $apr1+$apr2;?></div></td>
      <td align="right"><div align="center"><?php echo $mei1+$mei2;?></div></td>
      <td align="right"><div align="center"><?php echo $jun1+$jun2;?></div></td>
      <td align="right"><div align="center"><?php echo $jul1+$jul2;?></div></td>
      <td align="right"><div align="center"><?php echo $agu1+$agu2;?></div></td>
      <td align="right"><div align="center"><?php echo $sep1+$sep2;?></div></td>
      <td align="right"><div align="center"><?php echo $okt1+$okt2;?></div></td>
      <td align="right"><div align="center"><?php echo $nov1+$nov2;?></div></td>
      <td align="right"><div align="center"><?php echo $des1+$des2;?></div></td>
    </tr>
 </table>
 <script>
    var chart1; 
  $(document).ready(function() {
     chart1 = new Highcharts.Chart({
     chart: {
     renderTo: 'mygraph',
     type: 'column'
     },   
     title: {
     text: 'Kartu Kerja Selesai Proses Kurang Dari 2 Hari '
     },
     xAxis: {
     categories: ['Bulan']
     },
     yAxis: {
     title: {
        text: 'Persentase Actual'
     }
     },
       series:             
     [
      
       {
         name: 'Jan-<?php echo $thn;?>',
         data: [<?php echo $jan1;?>]
		 
       },
	    {
         name: 'Feb-<?php echo $thn;?>',
         data: [<?php echo $feb1;?>]
       },
		  {
         name: 'Mar-<?php echo $thn;?>',
         data: [<?php echo $mar1;?>]
       },
		  {
         name: 'Apr-<?php echo $thn;?>',
         data: [<?php echo $apr1;?>]
       },
	   {
         name: 'Mei-<?php echo $thn;?>',
         data: [<?php echo $mei1;?>]
       },
	    {
         name: 'Jun-<?php echo $thn;?>',
         data: [<?php echo $jun1;?>]
       },
		  {
         name: 'Jul-<?php echo $thn;?>',
         data: [<?php echo $jul1;?>]
       },
		  {
         name: 'Agu-<?php echo $thn;?>',
         data: [<?php echo $agu1;?>]
       },
	   {
         name: 'Sep-<?php echo $thn;?>',
         data: [<?php echo $sep1;?>]
       },
	    {
         name: 'Okt-<?php echo $thn;?>',
         data: [<?php echo $okt1;?>]
       },
		  {
         name: 'Nov-<?php echo $thn;?>',
         data: [<?php echo $nov1;?>]
       },
		  {
         name: 'Des-<?php echo $thn;?>',
         data: [<?php echo $des1;?>]
       },
       
      ]
     });
     });  
</script>
<script>
    var chart1; 
  $(document).ready(function() {
     chart1 = new Highcharts.Chart({
     chart: {
     renderTo: 'mygraph1',
     type: 'column'
     },   
     title: {
     text: 'Kartu Kerja Selesai Proses Lebih Dari 2 Hari '
     },
     xAxis: {
     categories: ['Bulan']
     },
     yAxis: {
     title: {
        text: 'Persentase Actual'
     }
     },
       series:             
     [
      
       {
         name: 'Jan-<?php echo $thn;?>',
         data: [<?php echo $jan2;?>]
       },
	    {
         name: 'Feb-<?php echo $thn;?>',
         data: [<?php echo $feb2;?>]
       },
		  {
         name: 'Mar-<?php echo $thn;?>',
         data: [<?php echo $mar2;?>]
       },
		  {
         name: 'Apr-<?php echo $thn;?>',
         data: [<?php echo $apr2;?>]
       },
	   {
         name: 'Mei-<?php echo $thn;?>',
         data: [<?php echo $mei2;?>]
       },
	    {
         name: 'Jun-<?php echo $thn;?>',
         data: [<?php echo $jun2;?>]
       },
		  {
         name: 'Jul-<?php echo $thn;?>',
         data: [<?php echo $jul2;?>]
       },
		  {
         name: 'Agu-<?php echo $thn;?>',
         data: [<?php echo $agu2;?>]
       },
	   {
         name: 'Sep-<?php echo $thn;?>',
         data: [<?php echo $sep2;?>]
       },
	    {
         name: 'Okt-<?php echo $thn;?>',
         data: [<?php echo $okt2;?>]
       },
		  {
         name: 'Nov-<?php echo $thn;?>',
         data: [<?php echo $nov2;?>]
       },
		  {
         name: 'Des-<?php echo $thn;?>',
         data: [<?php echo $des2;?>]
       },
       
      ]
     });
     });  
</script>
<!--- Bagian Judul--> 
<div class="container" style="margin-top:10px">
 <div class="col-md-7">
  <div class="panel panel-primary">
   <div class="panel-heading">The Graph of <?php echo strtoupper($_POST[tahun]);?></div>
    <div class="panel-body">
     <div id ="mygraph"></div>
    </div>
  </div>
 </div>
</div>
<!--- Bagian Judul--> 
<div class="container" style="margin-top:10px">
 <div class="col-md-7">
  <div class="panel panel-primary">
   <div class="panel-heading">The Graph of <?php echo strtoupper($_POST[tahun]);?></div>
    <div class="panel-body">
     <div id ="mygraph1"></div>
    </div>
  </div>
 </div>
</div>
</body>
</html>
