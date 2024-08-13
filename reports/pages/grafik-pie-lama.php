<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Persentase Perbulan</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/ilmudetil.css">
	<script src="../assets/js/highcharts.js"></script>
<script src="../assets/js/exporting.js"></script>
	<script src="../assets/js/jquery-1.10.1.min.js"></script>
	
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
$qry1=mysql_query("SELECT 
	COUNT(qty) as jml,sum(rol) as rol,sum(qty) as qty,sum(panjang) as panjang
FROM
	`tbl_adm`
WHERE
	`status`='2' AND DATEDIFF(tgl_out,tgl_in) < 3 AND DATE_FORMAT(tgl_out,'%Y-%m')='$tgl' ORDER BY `tgl_in` ASC");
$r1=mysql_fetch_array($qry1);
$qry2=mysql_query("SELECT 
	COUNT(qty) as jml,sum(rol) as rol,sum(qty) as qty,sum(panjang) as panjang
FROM
	`tbl_adm`
WHERE
	`status`='2' AND DATEDIFF(tgl_out,tgl_in) > 2 AND DATE_FORMAT(tgl_out,'%Y-%m')='$tgl' ORDER BY `tgl_in` ASC");
$r2=mysql_fetch_array($qry2);	
	  $totkk=$r1[jml]+$r2[jml];
      $totrol=$r1[rol]+$r2[rol];
      $totqty=$r1[qty]+$r2[qty];
      $totpjg=$r1[panjang]+$r2[panjang];	?>
<strong>PERSENTASE </strong> <strong>LAMA PROSES KARTU KERJA PADA DEPT FIN</strong><strong> BULAN <?php echo strtoupper($bln." ".$_POST[tahun]);?></strong>
<table width="60%" border="1">
    <tr bgcolor="#E49717">
      <th width="35%">Lama Proses KK </th>
      <th width="12%"><div align="right">Total KK</div></th>
      <th width="12%"><div align="right">Total Roll</div></th>
      <th width="15%"><div align="right">Total Qty(Kg)</div></th>
      <th width="14%"><div align="right">Total Panjang Kain (Yard)</div></th>
	  <th width="12%"><div align="right">Persentase (%)</div></th>
    </tr>
    <tr bgcolor="#A1F466">
      <td>Kartu Kerja Selesai Kurang Dari 2 Hari</td>
      <td align="right"><div align="right"><?php echo $r1[jml];?></div></td>
      <td align="right"><div align="right"><?php echo $r1[rol];?></div></td>
      <td align="right"><div align="right"><?php echo $r1[qty];?></div></td>
      <td align="right"><div align="right"><?php echo $r1[panjang];?></div></td>
      <td align="right"><div align="right"><?php if($totkk>0){echo $prs1=round(($r1[jml]/$totkk)*100,2);}else{$prs1="0.00";}?></div></td>
    </tr>
    <tr bgcolor="#F3CACB">
      <td>Kartu Kerja Selesai Lebih Dari 2 Hari</td>
      <td align="right"><div align="right"><?php echo $r2[jml];?></div></td>
      <td align="right"><div align="right"><?php echo $r2[rol];?></div></td>
      <td align="right"><div align="right"><?php echo $r2[qty];?></div></td>
      <td align="right"><div align="right"><?php echo $r2[panjang];?></div></td>
      <td align="right"><div align="right"><?php if($totkk>0){echo $prs2=round(($r2[jml]/$totkk)*100,2);}else{$prs2="0.00";}?></div></td>
    </tr>
    <tr bgcolor="#CFB8F5">
      <td>Total</td>
      <td align="right"><div align="right"><?php echo $totkk=$r1[jml]+$r2[jml];?></div></td>
      <td align="right"><div align="right"><?php echo $totrol=$r1[rol]+$r2[rol];?></div></td>
      <td align="right"><div align="right"><?php echo $totqty=$r1[qty]+$r2[qty];?></div></td>
      <td align="right"><div align="right"><?php echo $totpjg=$r1[panjang]+$r2[panjang];?></div></td>
      <td align="right"><div align="right"><?php echo $totprs=$prs1+$prs2;?></div></td>
    </tr>
 </table>
 <script>
		var chart; 
		$(document).ready(function() {
			  chart = new Highcharts.Chart(
			  {
				  
				 chart: {
					renderTo: 'mygraph',
					plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
        type: 'pie'
					 },   
				 title: {
					text: 'Perbandingan Jumlah Kartu Kerja Proses Pada Dept FIN '
				 }, tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Total',
        colorByPoint: true,
        data: [{
            name: 'Kurang 2 Hari',
            y: <?php echo $prs1; ?>,
        }, {
            name: 'Lebih 2 Hari',
            sliced: true,
            selected: true,
			y: <?php echo $prs2; ?>,
        }]
    }]
			  });
		});	
	</script>
</br>
<!--- Bagian Judul-->	
<div class="container" style="margin-top:20px">
	<div class="col-md-7">
		<div class="panel panel-primary">
			<div class="panel-heading">The Graph of <?php echo strtoupper($bln." ".$_POST[tahun]);?></div>
				<div class="panel-body">
					<div id ="mygraph"></div>
				</div>
		</div>
	</div>
</div>
</body>
</html>
