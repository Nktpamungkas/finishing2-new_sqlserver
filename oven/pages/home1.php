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
function nourut(){
$format = date("ymd");
$sql=mysql_query("SELECT nokk FROM tbl_produksi WHERE substr(nokk,1,6) like '%".$format."%' ORDER BY nokk DESC LIMIT 1 ") or die (mysql_error());
$d=mysql_num_rows($sql);
if($d>0){
$r=mysql_fetch_array($sql);
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
    $qry=mysql_query("SELECT * FROM tbl_produksi WHERE nokk='$idkk' ORDER BY id DESC LIMIT 1");
	$rw=mysql_fetch_array($qry);
	$rc=mysql_num_rows($qry);
    $tglsvr= mssql_query("select CONVERT(VARCHAR(10),GETDATE(),105) AS  tgk",$conn);
    $sr=mssql_fetch_array($tglsvr);
	
	$sqlLot=mssql_query(" SELECT
			x.*,dbo.fn_StockMovementDetails_GetTotalWeightPCC(0, x.PCBID) as Weight,
      dbo.fn_StockMovementDetails_GetTotalRollPCC(0, x.PCBID) as RollCount
FROM( SELECT
				so.CustomerID, so.BuyerID, 
				sod.ID as SODID, sod.ProductID, sod.UnitID, sod.WeightUnitID, 
				pcb.ID as PCBID,pcb.UnitID as BatchUnitID,
				pcblp.DepartmentID,pcb.PCID,pcb.LotNo,pcb.ChildLevel,pcb.RootID
			FROM
				SalesOrders so INNER JOIN
				JobOrders jo ON jo.SOID=so.ID INNER JOIN
				SODetails sod ON so.ID = sod.SOID INNER JOIN
				SODetailsAdditional soda ON sod.ID = soda.SODID LEFT JOIN
				ProcessControlJO pcjo ON sod.ID = pcjo.SODID LEFT JOIN
				ProcessControlBatches pcb ON pcjo.PCID = pcb.PCID LEFT JOIN
				ProcessControlBatchesLastPosition pcblp ON pcb.ID = pcblp.PCBID LEFT JOIN
				ProcessFlowProcessNo pfpn ON pfpn.EntryType = 2 and pcb.ID = pfpn.ParentID AND pfpn.MachineType = 24 LEFT JOIN
				ProcessFlowDetailsNote pfdn ON pfpn.EntryType = pfdn.EntryType AND pfpn.ID = pfdn.ParentID
			WHERE pcb.DocumentNo='$idkk' AND pcb.Gross<>'0'
				GROUP BY
					so.SONumber, so.SODate, so.CustomerID, so.BuyerID, so.PONumber, so.PODate,jo.DocumentNo,
					sod.ID, sod.ProductID, sod.Quantity, sod.UnitID, sod.Weight, sod.WeightUnitID,
					soda.RefNo,pcb.DocumentNo,pcb.Dated,sod.RequiredDate,
					pcb.ID, pcb.DocumentNo, pcb.Gross,
					pcb.Quantity, pcb.UnitID, pcb.ScheduledDate, pcb.ProductionScheduledDate,
					pcblp.DepartmentID,pcb.LotNo,pcb.PCID,pcb.ChildLevel,pcb.RootID
				) x INNER JOIN
				ProductMaster pm ON x.ProductID = pm.ID LEFT JOIN
				Departments dep ON x.DepartmentID  = dep.ID LEFT JOIN
				Departments pdep ON dep.RootID = pdep.ID LEFT JOIN				
				Partners cust ON x.CustomerID = cust.ID LEFT JOIN
				Partners buy ON x.BuyerID = buy.ID LEFT JOIN
				UnitDescription udq ON x.UnitID = udq.ID LEFT JOIN
				UnitDescription udw ON x.WeightUnitID = udw.ID LEFT JOIN
				UnitDescription udb ON x.BatchUnitID = udb.ID
			ORDER BY
				x.SODID, x.PCBID ",$conn);
	   $sLot=mssql_fetch_array($sqlLot);
	   $cLot=mssql_num_rows($sqlLot);
	   $child=$sLot[ChildLevel];
		
		if($child > 0){
			$sqlgetparent=mssql_query("select ID,LotNo from ProcessControlBatches where ID='$sLot[RootID]' and ChildLevel='0'");
			$rowgp=mssql_fetch_assoc($sqlgetparent);
			
			//$nomLot=substr("$row2[LotNo]",0,1);
			$nomLot=$rowgp[LotNo];
			$nomorLot="$nomLot/K$sLot[ChildLevel]&nbsp;";				
								
		}else{
			$nomorLot=$sLot[LotNo];
				
		}
	   
		$sqlLot1="Select count(*) as TotalLot From ProcessControlBatches where PCID='$sLot[PCID]' and RootID='0' and LotNo < '1000'";
		$qryLot1 = mssql_query($sqlLot1) or die('A error occured : ');							
		$rowLot=mssql_fetch_assoc($qryLot1);
    $sqls=mssql_query("select processcontrolJO.SODID,salesorders.ponumber,processcontrol.productid,salesorders.customerid,joborders.documentno,
    salesorders.buyerid,processcontrolbatches.lotno,productcode,productmaster.color,colorno,description,weight,cuttablewidth from Joborders 
    left join processcontrolJO on processcontrolJO.joid = Joborders.id
    left join salesorders on soid= salesorders.id
    left join processcontrol on processcontrolJO.pcid = processcontrol.id
    left join processcontrolbatches on processcontrolbatches.pcid = processcontrol.id
    left join productmaster on productmaster.id= processcontrol.productid
    left join productpartner on productpartner.productid= processcontrol.productid
    where processcontrolbatches.documentno='$idkk'",$conn);
            $ssr=mssql_fetch_array($sqls);
			$cek=mssql_num_rows($sqls);
            $lgn1=mssql_query("select partnername from partners where id='$ssr[customerid]'",$conn);
            $ssr1=mssql_fetch_array($lgn1);
            $lgn2=mssql_query("select partnername from partners where id='$ssr[buyerid]'",$conn);
            $ssr2=mssql_fetch_array($lgn2);
   }
     //
     
     ?>
     
     <?php

if(isset($_POST['btnSimpan']) and $_POST[proses]!=$rw[proses]){
		if($_POST[nokk]!=""){
		$nokk=$_POST[nokk];
		$idkk=$_POST[nokk];
		}else{$nokk=$nou;$idkk=$nou;}
		$shift=$_POST[shift];
		$shift2=$_POST[shift2];
		$langganan=$_POST[buyer];
		$buyer=$_POST[kd_buyer];
		$order=$_POST[no_order];
		$item=$_POST[no_item];
		$jenis_kain=str_replace("'","''",$_POST[jenis_kain]);
		$kain=$_POST[kondisi_kain];
		$bahan=$_POST[jenis_bahan];
		$warna=str_replace("'","''",$_POST[warna]);
		$nowarna=$_POST[no_warna];
		$lot=$_POST[lot];
		$qty=$_POST[qty];
		$qty2=$_POST[qty2];
	    $qty3=$_POST[qty3];
		$rol=$_POST[rol];
		$mesin=$_POST[no_mesin];
		$nmmesin=str_replace("'","''",$_POST[nama_mesin]);
		$proses=$_POST[proses];
		$gerobak=$_POST[no_gerobak];
		$jam_in=$_POST[proses_in];
		$jam_out=$_POST[proses_out];
		$proses_jam=$_POST[proses_jam];
		$proses_menit=$_POST[proses_menit];
		$tgl_proses_in=$_POST[tgl_proses_m];
		$tgl_proses_out=$_POST[tgl_proses_k];
		$mulai=$_POST[stop_mulai];
	    $mulai2=$_POST[stop_mulai2];
		$mulai3=$_POST[stop_mulai3];
		$selesai=$_POST[stop_selesai];
		$selesai2=$_POST[stop_selesai2];
		$selesai3=$_POST[stop_selesai3];
		$stop_jam=$_POST[stop_jam];
		$stop_menit=$_POST[stop_menit];
		$tgl_stop_m=$_POST[tgl_stop_m];
	    $tgl_stop_m2=$_POST[tgl_stop_m2];
		$tgl_stop_m3=$_POST[tgl_stop_m3];
		$tgl_stop_s=$_POST[tgl_stop_s];
		$tgl_stop_s2=$_POST[tgl_stop_s2];
		$tgl_stop_s3=$_POST[tgl_stop_s3];
		$kd=$_POST[kd_stop];
	    $kd2=$_POST[kd_stop2];
	    $kd3=$_POST[kd_stop3];
		$tgl=$_POST[tgl];
		$acc_kain=str_replace("'","''",$_POST[acc_kain]);
	    $catatan=str_replace("'","''",$_POST[catatan]);
		$suhu=$_POST[suhu];
		$speed=$_POST[speed];
		$omt=$_POST[omt];
		$vmt=$_POST[vmt];
		$vmt_time=$_POST[vmt_time];
		$buka=$_POST[buka_rantai];
		$overfeed=$_POST[overfeed];
		$hlebar=$_POST[h_lebar];
		$hgramasi=$_POST[h_gramasi];
		$lebar=$_POST[lebar];
		$gramasi=$_POST[gramasi];
		$phlarutan=$_POST[pH_larutan];
		$chemical1=$_POST[chemical_1];
		$chemical2=$_POST[chemical_2];
		$chemical3=$_POST[chemical_3];
		$chemical4=$_POST[chemical_4];
		$chemical5=$_POST[chemical_5];
		$jmlKonsen1=$_POST[jmlKonsen1];
		$jmlKonsen2=$_POST[jmlKonsen2];
		$jmlKonsen3=$_POST[jmlKonsen3];
		$jmlKonsen4=$_POST[jmlKonsen4];
		$jmlKonsen5=$_POST[jmlKonsen5];
		
	$simpanSql = "INSERT INTO tbl_produksi SET 
	`nokk`='$nokk',
	`shift`='$shift',
	`shift2`='$shift2',
	`buyer`='$buyer',
	`no_item`='$item',
	`no_warna`='$nowarna',
	`jenis_bahan`='$bahan',
	`kondisi_kain`='$kain',
	`panjang`='$qty2',
	`panjang_h`='$qty3',
	`no_gerobak`='$gerobak',
	`no_mesin`='$mesin',
	`nama_mesin`='$nmmesin',
	`langganan`='$langganan',
	`no_order`='$order',
	`jenis_kain`='$jenis_kain',
	`warna`='$warna',
	`lot`='$lot',
	`rol`='$rol',
	`qty`='$qty',
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
	`tgl_buat`=now(),
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
	`konsen_5`='$jmlKonsen5',
	`tgl_update`='$tgl'
	";
		mysql_query($simpanSql) or die ("Gagal Simpan".mysql_error());
		
		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=?idkk=$idkk&status=Data Sudah DiSimpan'>";
	}else if(isset($_POST['btnSimpan']) and $_POST[proses]==$rw[proses]){
		$shift=$_POST[shift];
		$shift2=$_POST[shift2];
		$langganan=$_POST[buyer];
		$buyer=$_POST[kd_buyer];
		$order=$_POST[no_order];
		$item=$_POST[no_item];
		$jenis_kain=str_replace("'","''",$_POST[jenis_kain]);
		$kain=$_POST[kondisi_kain];
		$bahan=$_POST[jenis_bahan];
		$warna=str_replace("'","''",$_POST[warna]);
		$nowarna=$_POST[no_warna];
		$lot=$_POST[lot];
		$qty=$_POST[qty];
		$qty2=$_POST[qty2];
		$qty3=$_POST[qty3];
		$rol=$_POST[rol];
		$mesin=$_POST[no_mesin];
		$nmmesin=str_replace("'","''",$_POST[nama_mesin]);
		$proses=$_POST[proses];
		$gerobak=$_POST[no_gerobak];
		$jam_in=$_POST[proses_in];
		$jam_out=$_POST[proses_out];
		$proses_jam=$_POST[proses_jam];
		$proses_menit=$_POST[proses_menit];
		$tgl_proses_in=$_POST[tgl_proses_m];
		$tgl_proses_out=$_POST[tgl_proses_k];
		$mulai=$_POST[stop_mulai];
	    $mulai2=$_POST[stop_mulai2];
		$mulai3=$_POST[stop_mulai3];
		$selesai=$_POST[stop_selesai];
		$selesai2=$_POST[stop_selesai2];
		$selesai3=$_POST[stop_selesai3];
		$stop_jam=$_POST[stop_jam];
		$stop_menit=$_POST[stop_menit];
		$tgl_stop_m=$_POST[tgl_stop_m];
	    $tgl_stop_m2=$_POST[tgl_stop_m2];
		$tgl_stop_m3=$_POST[tgl_stop_m3];
		$tgl_stop_s=$_POST[tgl_stop_s];
		$tgl_stop_s2=$_POST[tgl_stop_s2];
		$tgl_stop_s3=$_POST[tgl_stop_s3];
		$kd=$_POST[kd_stop];
	    $kd2=$_POST[kd_stop2];
	    $kd3=$_POST[kd_stop3];
		$tgl=$_POST[tgl];
		$acc_kain=str_replace("'","''",$_POST[acc_kain]);
	    $catatan=str_replace("'","''",$_POST[catatan]);
		$suhu=$_POST[suhu];
		$speed=$_POST[speed];
		$omt=$_POST[omt];
		$vmt=$_POST[vmt];
		$vmt_time=$_POST[vmt_time];
		$buka=$_POST[buka_rantai];
		$overfeed=$_POST[overfeed];
		$hlebar=$_POST[h_lebar];
		$hgramasi=$_POST[h_gramasi];
		$lebar=$_POST[lebar];
		$gramasi=$_POST[gramasi];
		$phlarutan=$_POST[pH_larutan];
		$chemical1=$_POST[chemical_1];
		$chemical2=$_POST[chemical_2];
		$chemical3=$_POST[chemical_3];
		$chemical4=$_POST[chemical_4];
		$chemical5=$_POST[chemical_5];
		$jmlKonsen1=$_POST[jmlKonsen1];
		$jmlKonsen2=$_POST[jmlKonsen2];
		$jmlKonsen3=$_POST[jmlKonsen3];
		$jmlKonsen4=$_POST[jmlKonsen4];
		$jmlKonsen5=$_POST[jmlKonsen5];
	$simpanSql = "UPDATE tbl_produksi SET 
	`shift`='$shift',
	`shift2`='$shift2',
	`buyer`='$buyer',
	`no_item`='$item',
	`no_warna`='$nowarna',
	`jenis_bahan`='$bahan',
	`kondisi_kain`='$kain',
	`panjang`='$qty2',
	`panjang_h`='$qty3',
	`no_gerobak`='$gerobak',
	`no_mesin`='$mesin',
	`nama_mesin`='$nmmesin',
	`langganan`='$langganan',
	`no_order`='$order',
	`jenis_kain`='$jenis_kain',
	`warna`='$warna',
	`lot`='$lot',
	`rol`='$rol',
	`qty`='$qty',
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
	`konsen_5`='$jmlKonsen5',
	`tgl_update`='$tgl'
	WHERE `id`='$_POST[id]'";
		mysql_query($simpanSql) or die ("Gagal Ubah".mysql_error());
		
		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=?idkk=$idkk&status=Data Sudah DiUbah'>";
	}
	?>
<form id="form1" name="form1" method="post" action="" >
 <fieldset>
  <legend>Data Produksi Harian Finishing</legend>
  <table width="100%" border="0">
    <tr>
      <th colspan="7" scope="row"><font color="#FF0000"><?php echo $_GET['status'];?></font></th>
    </tr>
    <tr>
      <td width="13%" scope="row"><h4>Nokk</h4></td>
      <td width="1%">:</td>
      <td width="26%"><input name="nokk" type="text" id="nokk" size="17" onchange="window.location='?idkk='+this.value" value="<?php echo $_GET[idkk];?>"/><input type="hidden"  value="<?php echo $rw[id];?>" name="id"/></td>
      <td width="14%"><h4>Group Shift</h4></td>
      <td width="1%">:</td>
      <td colspan="2"><select name="shift" id="shift" required>
          <option value="">Pilih</option>
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
      </select></td>
    </tr>
    <tr>
      <td scope="row"><h4>Langganan/Buyer</h4></td>
      <td>:</td>
      <td><input name="buyer" type="text" id="buyer" size="30" value="<?php if($cek>0){echo $ssr1['partnername']."/".$ssr2['partnername'];}else{echo $rw[langganan];}?>"/></td>
      <td width="14%"><h4>Shift</h4></td>
      <td>:</td>
      <td colspan="2"><select name="shift2" id="shift2" required="required">
        <option value="">Pilih</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
      </select></td>
    </tr>
    <tr>
      <td scope="row"><h4>Kode Buyer</h4></td>
      <td>:</td>
      <td><select name="kd_buyer" id="kd_buyer" required="required">
        <option value="">Pilih</option>
        <option value="ADIDAS" <?php if($ssr2['partnername']=="ADIDAS"){echo "SELECTED";}?> >ADIDAS</option>
        <option value="NIKE" <?php if($ssr2['partnername']=="NIKE"){echo "SELECTED";}?>>NIKE</option>
        <option value="CAMPURAN" <?php if($ssr2['partnername']=="NIKE"){}else if($ssr2['partnername']=="ADIDAS"){}else{echo "SELECTED";}?>>CAMPURAN</option>
      </select></td>
      <td><h4>Tgl Proses</h4></td>
      <td>:</td>
      <td colspan="2"><input name="tgl" type="text" id="tgl" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl);return false;" size="10" placeholder="0000-00-00" required="required"/>
        <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal" style="border:none" align="absmiddle" border="0" /></a></td>
    </tr>
    <tr>
      <td scope="row"><h4>No. Order</h4></td>
      <td>:</td>
      <td><input type="text" name="no_order" id="no_order" value="<?php if($cek>0){echo $ssr['documentno'];}else{echo $rw[no_order];}?>"/>
      </td>
      <td><h4>Proses</h4></td>
      <td>:</td>
      <td colspan="2"><select name="proses" id="proses" required>
          <option value="">Pilih</option>
          <?php $qry1=mysql_query("SELECT proses,jns FROM tbl_proses ORDER BY id ASC"); 
		while($r=mysql_fetch_array($qry1)){
		?>
          <option value="<?php echo $r[proses]." (".$r[jns].")";?>" <?php if($rw[proses]==$r[proses]." (".$r[jns].")"){echo "SELECTED";}?>><?php echo $r[proses]." (".$r[jns].")";?></option>
          <?php } ?>
        </select>
        <?php if($_SESSION[lvl]=="SPV") { ?>
        <input type="button" name="btnproses" id="btnproses" value="..."  onclick="window.open('pages/data-proses.php','MyWindow','height=400,width=650');"/>
        <?php } ?>
        </td>
    </tr>
    <tr>
      <td valign="top" scope="row"><h4>Jenis Kain</h4></td>
      <td valign="top">:</td>
      <td><textarea name="jenis_kain" cols="30" id="jenis_kain"><?php if($cek>0){echo $ssr['productcode']." / ".$ssr['description'];}else{echo $rw[jenis_kain];}?></textarea></td>
      <td valign="top"><h4>Catatan</h4></td>
      <td valign="top">:</td>
      <td colspan="2" valign="top"><textarea name="catatan" cols="35" id="catatan"><?php echo $rw[catatan];?></textarea></td>
    </tr>
    <tr>
      <td scope="row"><h4>Hanger/Item</h4></td>
      <td>:</td>
      <td><input type="text" name="no_item" id="no_item" value="<?php if($cek>0){echo $ssr['productcode'];}else{echo $rw[no_item];}?>"/></td>
      <td><h4>Kondisi Kain</h4></td>
      <td>:</td>
      <td colspan="2"><select name="kondisi_kain" id="kondisi_kain" required="required">
        <option value="">Pilih</option>
        <option value="BASAH" <?php if($rw[kondisi_kain]=="BASAH"){echo "SELECTED";}?>>BASAH</option>
        <option value="KERING" <?php if($rw[kondisi_kain]=="KERING"){echo "SELECTED";}?>>KERING</option>
      </select></td>
    </tr>
    <tr>
      <td scope="row"><h4>No. Warna</h4></td>
      <td>:</td>
      <td><input name="no_warna" type="text" id="no_warna" size="30" value="<?php if($cek>0){echo $ssr['colorno'];}else{echo $rw[no_warna];}?>"/></td>
      <td><h4>No. Gerobak</h4></td>
      <td>:</td>
      <td colspan="2"><input type="text" name="no_gerobak" id="no_gerobak" value="<?php echo $rw[no_gerobak];?>"/></td>
    </tr>
    <tr>
      <td scope="row"><h4>Warna</h4></td>
      <td>:</td>
      <td><input name="warna" type="text" id="warna" size="30" value="<?php if($cek>0){echo $ssr['color'];}else{echo $rw[warna];}?>"/></td>
      <td width="14%"><strong>Quantity (Kg)</strong></td>
      <td width="1%">:</td>
      <td colspan="2"><input name="qty" type="text" id="qty" size="5" value="<?php if($cLot>0){echo $sLot[Weight];}else{echo $rw[qty];}?>" placeholder="0.00" />&nbsp;&nbsp;&nbsp;&nbsp;<strong>Gramasi</strong>:<input name="lebar" type="text" id="lebar" size="6" value="<?php if($cek>0){echo $ssr['cuttablewidth'];}?>" placeholder="0" />
         &quot;X
        <input name="gramasi" type="text" id="gramasi" size="6" value="<?php if($cek>0){echo $ssr['weight'];}?>" placeholder="0" /></td>
    </tr>
    <tr>
      <td scope="row"><h4>Jenis Bahan</h4></td>
      <td>:</td>
      <td><select name="jenis_bahan" id="jenis_bahan" required="required">
        <option value="">Pilih</option>
        <option value="Polyesyer" <?php if($rw[jenis_bahan]=="Polyesyer"){echo "SELECTED";}?>>Polyesyer</option>
        <option value="Cotton" <?php if($rw[janis_bahan]=="Cotton"){echo "SELECTED";}?>>Cotton</option>
      </select></td>
      <td width="14%"><strong>Panjang (Yard)</strong></td>
      <td>:</td>
      <td colspan="2"><input name="qty2" type="text" id="qty2" size="8" value="<?php echo $rw[panjang];?>" placeholder="0.00" onfocus="jumlah();"/></td>
    </tr>
    <tr>
      <td scope="row"><h4>Lot</h4></td>
      <td>:</td>
      <td><input name="lot" type="text" id="lot" size="5" value="<?php if($cLot>0){echo $rowLot[TotalLot]."-".$nomorLot;}else{echo $rw[lot];}?>"/></td>
      <td><h4>Nama Mesin</h4></td>
      <td>:</td>
      <td colspan="2"><select name="nama_mesin" id="nama_mesin" onchange="myFunction();" required="required">
        <option value="">Pilih</option>
        <?php $qry1=mysql_query("SELECT nama FROM tbl_mesin ORDER BY nama ASC"); 
		while($r=mysql_fetch_array($qry1)){
		?>
        <option value="<?php echo $r[nama];?>" <?php if($rw[nama_mesin]==$r[nama]){echo "SELECTED";}?> ><?php echo $r[nama];?></option>
        <?php } ?>
      </select>
        <?php if($_SESSION[lvl]=="SPV") { ?>
        <input type="button" name="btnmesin2" id="btnmesin2" value="..."  onclick="window.open('pages/mesin.php','MyWindow','height=400,width=650');"/>
        <?php } ?></td>
    </tr>
    <tr>
      <td scope="row"><h4>Roll</h4></td>
      <td>:</td>
      <td><input name="rol" type="text" id="rol" size="3" placeholder="0" pattern="[0-9]{1,}" value="<?php if($cLot>0){echo $sLot[RollCount];}else{echo $rw[rol];}?>" /></td>
      <td><strong>No. Mesin</strong></td>
      <td>:</td>
      <td colspan="2"><select name="no_mesin" id="no_mesin" onchange="myFunction();" required="required">
        <option value="">Pilih</option>
        <?php $qry1=mysql_query("SELECT no_mesin FROM tbl_no_mesin ORDER BY no_mesin ASC"); 
		while($r=mysql_fetch_array($qry1)){
		?>
        <option value="<?php echo $r[no_mesin];?>" <?php if($rw[no_mesin]==$r[no_mesin]){echo "SELECTED";}?> ><?php echo $r[no_mesin];?></option>
        <?php } ?>
      </select>
        <?php if($_SESSION[lvl]=="SPV") { ?>
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
  }" value="<?php echo $rw[jam_in]?>" size="5" maxlength="5" />
        <input name="tgl_proses_m" type="text" id="tgl_proses_m" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_proses_m);return false;" size="10" placeholder="0000-00-00" value="<?php echo $rw[tgl_proses_in];?>" />
        <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_proses_m);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal2" style="border:none" align="absmiddle" border="0" /></a></td>
      <td><h4>Selesai Proses</h4></td>
      <td>:</td>
      <td colspan="2"><input name="proses_out" type="text" id="proses_out"  placeholder="00:00" pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25 " onkeyup="
  var time = this.value;
  if (time.match(/^\d{2}$/) !== null) {
     this.value = time + ':';
  } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
     this.value = time + '';
  }" value="<?php echo $rw[jam_out]?>" size="5" maxlength="5" />
        <input name="tgl_proses_k" type="text" id="tgl_proses_k" placeholder="0000-00-00" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_proses_k);return false;" value="<?php echo $rw[tgl_proses_out]; ?>" size="10"/>
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
  }" value="<?php echo $rw[stop_l]?>" size="5" maxlength="5" />
        <input name="tgl_stop_m" type="text" id="tgl_stop_m" placeholder="0000-00-00" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_m);return false;" value="<?php echo $rw[tgl_stop_l];?>" size="10" />
      <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_m);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal4" style="border:none" align="absmiddle" border="0" /></a></td>
      <td><h4>Selesai Stop Mesin 1</h4></td>
      <td>:</td>
      <td width="21%"><input name="stop_selesai" type="text" id="stop_selesai"  placeholder="00:00" pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25 " onkeyup="
  var time = this.value;
  if (time.match(/^\d{2}$/) !== null) {
     this.value = time + ':';
  } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
     this.value = time + '';
  }" value="<?php echo $rw[stop_r]?>" size="5" maxlength="5" />
        <input name="tgl_stop_s" type="text" id="tgl_stop_s" placeholder="0000-00-00" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_s);return false;" value="<?php echo $rw[tgl_stop_r];?>" size="10"/>
        <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_s);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal5" style="border:none" align="absmiddle" border="0" /></a></td>
      <td width="24%"><h4>Kode1:
          <select name="kd_stop" id="kd_stop">
          <option value="">Pilih</option>
          <?php $qry1=mysql_query("SELECT kode FROM tbl_stop_mesin ORDER BY id ASC"); 
		while($r=mysql_fetch_array($qry1)){
		?>
          <option value="<?php echo $r[kode];?>" <?php if($rw[kd_stop]==$r[kode]){echo "SELECTED";}?>><?php echo $r[kode];?></option>
          <?php } ?>
        </select>
          <?php if($_SESSION[lvl]=="SPV") { ?>
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
  }" value="<?php echo $rw[stop_l]?>" size="5" maxlength="5" />
        <input name="tgl_stop_m2" type="text" id="tgl_stop_m2" placeholder="0000-00-00" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_m2);return false;" value="<?php echo $rw[tgl_stop_l];?>" size="10" />
        <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_m2);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal6" style="border:none" align="absmiddle" border="0" /></a></td>
      <td><h4>Selesai Stop Mesin 2</h4></td>
      <td>:</td>
      <td><input name="stop_selesai2" type="text" id="stop_selesai2"  placeholder="00:00" pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25 " onkeyup="
  var time = this.value;
  if (time.match(/^\d{2}$/) !== null) {
     this.value = time + ':';
  } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
     this.value = time + '';
  }" value="<?php echo $rw[stop_r]?>" size="5" maxlength="5" />
        <input name="tgl_stop_s2" type="text" id="tgl_stop_s2" placeholder="0000-00-00" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_s2);return false;" value="<?php echo $rw[tgl_stop_r];?>" size="10"/>
        <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_s2);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal7" style="border:none" align="absmiddle" border="0" /></a></td>
      <td><h4>Kode2:
          <select name="kd_stop2" id="kd_stop2">
          <option value="">Pilih</option>
          <?php $qry1=mysql_query("SELECT kode FROM tbl_stop_mesin ORDER BY id ASC"); 
		while($r=mysql_fetch_array($qry1)){
		?>
          <option value="<?php echo $r[kode];?>" <?php if($rw[kd_stop]==$r[kode]){echo "SELECTED";}?>><?php echo $r[kode];?></option>
          <?php } ?>
        </select>
          <?php if($_SESSION[lvl]=="SPV") { ?>
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
  }" value="<?php echo $rw[stop_l]?>" size="5" maxlength="5" />
        <input name="tgl_stop_m3" type="text" id="tgl_stop_m3" placeholder="0000-00-00" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_m3);return false;" value="<?php echo $rw[tgl_stop_l];?>" size="10" />
        <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_m3);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal8" style="border:none" align="absmiddle" border="0" /></a></td>
      <td><h4>Selesai Stop Mesin 3</h4></td>
      <td>:</td>
      <td><input name="stop_selesai3" type="text" id="stop_selesai3"  placeholder="00:00" pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25 " onkeyup="
  var time = this.value;
  if (time.match(/^\d{2}$/) !== null) {
     this.value = time + ':';
  } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
     this.value = time + '';
  }" value="<?php echo $rw[stop_r]?>" size="5" maxlength="5" />
        <input name="tgl_stop_s3" type="text" id="tgl_stop_s3" placeholder="0000-00-00" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_s3);return false;" value="<?php echo $rw[tgl_stop_r];?>" size="10"/>
        <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_s3);return false;"><img src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal9" style="border:none" align="absmiddle" border="0" /></a></td>
      <td><h4>Kode3:
          <select name="kd_stop3" id="kd_stop3">
          <option value="">Pilih</option>
          <?php $qry1=mysql_query("SELECT kode FROM tbl_stop_mesin ORDER BY id ASC"); 
		while($r=mysql_fetch_array($qry1)){
		?>
          <option value="<?php echo $r[kode];?>" <?php if($rw[kd_stop]==$r[kode]){echo "SELECTED";}?>><?php echo $r[kode];?></option>
          <?php } ?>
        </select>
          <?php if($_SESSION[lvl]=="SPV") { ?>
          <input type="button" name="btnstop3" id="btnstop3" value="..."  onclick="window.open('pages/data-stop.php','MyWindow','height=400,width=650');"/>
        <?php } ?>
      </h4></td>
    </tr>
    <tr>
      <td scope="row">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><h4>Operator</h4></td>
      <td>:</td>
      <td colspan="2"><select name="acc_kain" id="acc_kain">
        <option value="">Pilih</option>
        <?php $qryacc=mysql_query("SELECT nama FROM tbl_staff ORDER BY id ASC"); 
		while($racc=mysql_fetch_array($qryacc)){
		?>
        <option value="<?php echo $racc[nama];?>" <?php if($racc[nama]==$rw[acc_staff]){echo "SELECTED";}?>><?php echo $racc[nama];?></option>
        <?php } ?>
        </select>
        <?php if($_SESSION[lvl]=="SPV") { ?>
        <input type="button" name="btnacc" id="btnacc" value="..."  onclick="window.open('pages/data-operator.php','MyWindow','height=400,width=650');"/>
<?php } ?></td>
    </tr>
   </table>
 </fieldset>
 <br>
 <fieldset><legend>Data Proses Actual</legend>
 <table width="100%" border="0">
     <tr>
       <td width="17%" scope="row"><h4>Suhu Proses</h4></td>
       <td width="1%">:</td>
       <td width="20%"><input name="suhu" type="text" required id="suhu" value="<?php echo $rw[suhu];?>" size="10"/></td>
       <td width="17%">&nbsp;</td>
       <td width="1%">&nbsp;</td>
       <td width="44%">&nbsp;</td>
     </tr>
     <tr>
       <td scope="row"><h4>Speed Proses</h4></td>
       <td>:</td>
       <td><input name="speed" type="text" required id="speed" value="<?php echo $rw[speed];?>" size="10" /></td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     <tr>
       <td scope="row"><h4>OMT </h4></td>
       <td>:</td>
       <td><input name="omt" type="text" id="omt" value="<?php echo $rw[omt];?>" size="5" />
        <strong>&deg;</strong></td>
       <td scope="row"><h4>VMT</h4></td>
       <td>:</td>
       <td><input name="vmt" type="text" required id="vmt" value="<?php echo $rw[vmt];?>" size="5"/>
         <strong>&deg;
         X</strong>
         <input name="vmt_time" type="text" required id="vmt_time" value="<?php echo $rw[t_vmt];?>" size="5"/>
         <strong>second</strong></td>
     </tr>
     <tr>
       <td scope="row"><h4>Buka Rantai</h4></td>
       <td>:</td>
       <td><input name="buka_rantai" type="text" required id="buka_rantai" value="<?php echo $rw[buka_rantai];?>" size="10"/></td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     <tr>
       <td scope="row"><h4>Overfeed</h4></td>
       <td>:</td>
       <td><input name="overfeed" type="text" required id="overfeed" value="<?php echo $rw[overfeed];?>" size="10"/></td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     <tr>
       <td scope="row"><h4>Lebar X Gramasi</h4></td>
       <td>:</td>
       <td><input name="h_lebar" type="text" required id="h_lebar" value="<?php echo $rw[lebar_h];?>" size="5"/>
         &quot;X
        <input name="h_gramasi" type="text" required id="h_gramasi" value="<?php echo $rw[gramasi_h];?>" size="5"/></td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     <tr>
       <td scope="row"><strong>Panjang (Yard)</strong></td>
       <td>:</td>
       <td><input name="qty3" type="text" id="qty3" size="8" value="<?php echo $rw[panjang_h];?>" placeholder="0.00" onfocus="jumlah1();"/></td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     <tr>
       <td scope="row"><h4>pH Larutan Chemical</h4></td>
       <td>:</td>
       <td><input name="pH_larutan" type="text" required id="pH_larutan" value="<?php echo $rw[ph_larut];?>" size="5"/></td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     <tr>
       <td scope="row"><h4>Pemakaian Chemical</h4></td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     <tr>
       <td scope="row"><h4>Chemical I</h4></td>
       <td>:</td>
       <td><select name="chemical_1" id="chemical_1" required>
         <option value="">Pilih</option>
         <?php $qryche1=mysql_query("SELECT kode FROM tbl_chemical ORDER BY id ASC"); 
		while($rch1=mysql_fetch_array($qryche1)){
		?>
        <option value="<?php echo $rch1[kode];?>" <?php if($rch1[kode]==$rw[chemical_1]){echo "SELECTED";}?>><?php echo $rch1[kode];?></option>
        <?php } ?>
        </select>
         <?php if($_SESSION[lvl]=="SPV") { ?>
         <input type="button" name="btnChemical" id="btnChemical" value="..."  onclick="window.open('pages/data-chemical.php','MyWindow','height=400,width=650');"/>
        <?php } ?></td>
       <td><h4>Jumlah Konsentrasi I</h4></td>
       <td>:</td>
       <td><input name="jmlKonsen1" type="text" required id="jmlKonsen1" value="<?php echo $rw[konsen_1];?>" size="5"/></td>
     </tr>
     <tr>
       <td scope="row"><h4>Chemical II</h4></td>
       <td>:</td>
       <td><select name="chemical_2" id="chemical_2" required>
         <option value="">Pilih</option>
         <?php $qryche2=mysql_query("SELECT kode FROM tbl_chemical ORDER BY id ASC"); 
		while($rch2=mysql_fetch_array($qryche2)){
		?>
        <option value="<?php echo $rch2[kode];?>" <?php if($rch2[kode]==$rw[chemical_2]){echo "SELECTED";}?>><?php echo $rch2[kode];?></option>
        <?php } ?>
       </select>
         <?php if($_SESSION[lvl]=="SPV") { ?>
         <input type="button" name="btnChemical2" id="btnChemical2" value="..."  onclick="window.open('pages/data-chemical.php','MyWindow','height=400,width=650');"/>
        <?php } ?></td>
       <td><h4>Jumlah Konsentrasi II</h4></td>
       <td>:</td>
       <td><input name="jmlKonsen2" type="text" required id="jmlKonsen2" value="<?php echo $rw[konsen_2];?>" size="5"/></td>
     </tr>
     <tr>
       <td scope="row"><h4>Chemical III</h4></td>
       <td>:</td>
       <td><select name="chemical_3" id="chemical_3" required>
         <option value="">Pilih</option>
         <?php $qryche3=mysql_query("SELECT kode FROM tbl_chemical ORDER BY id ASC"); 
		while($rch3=mysql_fetch_array($qryche3)){
		?>
        <option value="<?php echo $rch3[kode];?>" <?php if($rch3[kode]==$rw[chemical_3]){echo "SELECTED";}?>><?php echo $rch3[kode];?></option>
        <?php } ?>
       </select>
         <?php if($_SESSION[lvl]=="SPV") { ?>
         <input type="button" name="btnChemical3" id="btnChemical3" value="..."  onclick="window.open('pages/data-chemical.php','MyWindow','height=400,width=650');"/>
<?php } ?></td>
       <td><h4>Jumlah Konsentrasi III</h4></td>
       <td>:</td>
       <td><input name="jmlKonsen3" type="text" required id="jmlKonsen3" value="<?php echo $rw[konsen_3];?>" size="5"/></td>
     </tr>
     <tr>
       <td scope="row"><h4>Chemical IV</h4></td>
       <td>:</td>
       <td><select name="chemical_4" id="chemical_4" required>
         <option value="">Pilih</option>
         <?php $qryche4=mysql_query("SELECT kode FROM tbl_chemical ORDER BY id ASC"); 
		while($rch4=mysql_fetch_array($qryche4)){
		?>
        <option value="<?php echo $rch4[kode];?>" <?php if($rch4[kode]==$rw[chemical_4]){echo "SELECTED";}?>><?php echo $rch4[kode];?></option>
        <?php } ?>
       </select>
         <?php if($_SESSION[lvl]=="SPV") { ?>
         <input type="button" name="btnChemical4" id="btnChemical4" value="..."  onclick="window.open('pages/data-chemical.php','MyWindow','height=400,width=650');"/>
        <?php } ?></td>
       <td><h4>Jumlah Konsentrasi IV</h4></td>
       <td>:</td>
       <td><input name="jmlKonsen4" type="text" required id="jmlKonsen4" value="<?php echo $rw[konsen_4];?>" size="5" /></td>
     </tr>
     <tr>
       <td scope="row"><h4>Chemical V</h4></td>
       <td>&nbsp;</td>
       <td><select name="chemical_5" id="chemical_5" required>
         <option value="">Pilih</option>
         <?php $qryche5=mysql_query("SELECT kode FROM tbl_chemical ORDER BY id ASC"); 
		while($rch5=mysql_fetch_array($qryche5)){
		?>
        <option value="<?php echo $rch5[kode];?>" <?php if($rch5[kode]==$rw[chemical_5]){echo "SELECTED";}?>><?php echo $rch5[kode];?></option>
        <?php } ?>
       </select>
         <?php if($_SESSION[lvl]=="SPV") { ?>
         <input type="button" name="btnChemical5" id="btnChemical5" value="..."  onclick="window.open('pages/data-chemical.php','MyWindow','height=400,width=650');"/>
        <?php } ?></td>
       <td><h4>Jumlah Konsentrasi V</h4></td>
       <td>:</td>
       <td><input name="jmlKonsen5" type="text" required id="jmlKonsen5" value="<?php echo $rw[konsen_5];?>" size="5" /></td>
     </tr>
 </table>
 </fieldset><br>
 <input type="submit" name="btnSimpan" id="btnSimpan" value="Simpan" class="art-button"/>
        <input type="button" name="batal" id="batal" value="Batal" onclick="window.location.href='index.php'" class="art-button"/>
        <input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='../index.php'" class="art-button"/>
</form>
</body>
</html>