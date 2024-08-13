<?php
if (empty($_SESSION['usr'])) {
	echo "<script>alert('Silahkan login terlebih dahulu!'); window.location = '../login.php'</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Home</title>
	<script>
		function roundToTwo(num) {
			return +(Math.round(num + "e+2") + "e-2");
		}

		function jumlah() {
			var lebar = document.forms['form1']['lebar'].value;
			var berat = document.forms['form1']['gramasi'].value;
			var netto = document.forms['form1']['qty'].value;
			var x, yard;
			x = ((parseInt(lebar)) * parseInt(berat)) / 43.056;
			x1 = (1000 / x);
			yard = x1 * parseFloat(netto);
			document.form1.qty2.value = roundToTwo(yard).toFixed(2);

		}

		function jumlah1() {
			var lebar1 = document.forms['form1']['h_lebar'].value;
			var berat1 = document.forms['form1']['h_gramasi'].value;
			var netto1 = document.forms['form1']['qty'].value;
			var x1, yard1;
			x1 = ((parseInt(lebar1)) * parseInt(berat1)) / 43.056;
			x2 = (1000 / x1);
			yard1 = x2 * parseFloat(netto1);
			document.form1.qty3.value = roundToTwo(yard1).toFixed(2);

		}

		$(document).ready(function() {
			$('#proses_in').change(function() {
				var jam_proses_in = document.getElementById('proses_in').value;
				if (jam_proses_in.substring(0, 2) >= 24) {
					alert("Waktu pada MULAI PROSES tidak boleh melebihi batas 1 hari.");
				}
			});

			$('#stop_mulai').change(function() {
				var jam_stop_mulai = document.getElementById('stop_mulai').value;
				if (jam_stop_mulai.substring(0, 2) >= 24) {
					alert("Waktu pada MULAI STOP MESIN 1 tidak boleh melebihi batas 1 hari.");
				}
			});

			$('#stop_mulai2').change(function() {
				var jam_stop_mulai2 = document.getElementById('stop_mulai2').value;
				if (jam_stop_mulai2.substring(0, 2) >= 24) {
					alert("Waktu pada MULAI STOP MESIN 2 tidak boleh melebihi batas 1 hari.");
				}
			});

			$('#stop_mulai3').change(function() {
				var jam_stop_mulai3 = document.getElementById('stop_mulai3').value;
				if (jam_stop_mulai3.substring(0, 2) >= 24) {
					alert("Waktu pada MULAI STOP MESIN 3 tidak boleh melebihi batas 1 hari.");
				}
			});


			$('#proses_out').change(function() {
				var jam_proses_out = document.getElementById('proses_out').value;
				if (jam_proses_out.substring(0, 2) >= 24) {
					alert("Waktu pada SELESAI PROSES tidak boleh melebihi batas 1 hari.");
				}
			});

			$('#stop_selesai').change(function() {
				var jam_stop_selesai = document.getElementById('stop_selesai').value;
				if (jam_stop_selesai.substring(0, 2) >= 24) {
					alert("Waktu pada SELESAI STOP MESIN 1 tidak boleh melebihi batas 1 hari.");
				}
			});

			$('#stop_selesai2').change(function() {
				var jam_stop_selesai2 = document.getElementById('stop_selesai2').value;
				if (jam_stop_selesai2.substring(0, 2) >= 24) {
					alert("Waktu pada SELESAI STOP MESIN 2 tidak boleh melebihi batas 1 hari.");
				}
			});

			$('#stop_selesai3').change(function() {
				var jam_stop_selesai3 = document.getElementById('stop_selesai3').value;
				if (jam_stop_selesai3.substring(0, 2) >= 24) {
					alert("Waktu pada SELESAI STOP MESIN 3 tidak boleh melebihi batas 1 hari.");
				}
			});

		});
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
			background: #355FE7;
			/* Green */
			color: #FFFFFF;
			/* White */
			margin-bottom: 10px;
			padding: 0.5em 1em;
		}
	</style>
	<style>
		/* CSS untuk modal */
		.modal {
			display: none;
			/* Sembunyikan modal secara default */
			position: fixed;
			z-index: 1;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			overflow: auto;
			background-color: rgba(0, 0, 0, 0.4);
			/* Latar belakang semi-transparan */
		}

		/* CSS untuk konten modal */
		.modal-content {
			background-color: #FFE4E4;
			margin: 15% auto;
			padding: 20px;
			border: 1px solid #888;
			width: 80%; /* Lebar konten modal sebelum menyesuaikan */
			max-width: 100%; /* Maksimum lebar konten modal */
			overflow-x: auto; /* Scroll horizontal jika konten melebihi lebar modal */
		}

		/* CSS untuk tombol close */
		.close {
			color: #aaa;
			float: right;
			font-size: 28px;
			font-weight: bold;
		}

		.close:hover,
		.close:focus {
			color: black;
			text-decoration: none;
			cursor: pointer;
		}
	</style>
</head>

<body>
	<?PHP 
	include('../koneksi.php');
	$q_kkmasuk		= mysqli_query($con, "SELECT * FROM tbl_masuk WHERE id = '$_GET[id]'");
	$row_kkmasuk	= mysqli_fetch_assoc($q_kkmasuk);

	?>
	<!-- fungsi update kk masuk -->
	<?php
		 if (isset($_POST['btnSimpan'])) {
			$lastupdatedatetime	= date('Y-m-d H:i:s');
			$operation 			= mysqli_real_escape_string($con, $_POST['operation']);
			$proses 			= mysqli_real_escape_string($con, $_POST['proses']);
			$catatan 			= mysqli_real_escape_string($con, $_POST['catatan']);
			$prosesbc 			= mysqli_real_escape_string($con, $_POST['prosesbc']);
			$lastupdatedatetime = date('Y-m-d H:i:s');
			$akun 				= $_SESSION['usr'];
			$simpanSql 	= "UPDATE tbl_masuk
								SET operation = '$operation',
									proses = '$proses',
									catatan = '$catatan',
									lastupdatedatetime = '$lastupdatedatetime',
									akun = '$akun',
									prosesbc = '$prosesbc'
								WHERE id = " . $_GET['id']; 
			$simpan 	= mysqli_query($con, $simpanSql);

			if($simpan){
				echo 	"<script>
							swal({
								title: 'Data Terupdate',   
								text: 'Klik Ok untuk input data kembali',
								type: 'success',
							}).then((result) => {
								if (result.value) {
									window.location.href = 'https://online.indotaichen.com/finishing2-new/masuk/index.php?p=LihatData'; 
								}
							});
						</script>";
			}
		}
	?>
	<!--end update kk masuk -->
	<form id="form1" name="form1" method="post" action="">
		<?php if ($_SESSION['usr'] == 'husni') : ?>
			<input type="button" name="LihatData" value="Lihat Data" onclick="window.location.href='index.php?p=LihatData'" class="art-button green">
		<?php else : ?>
			<fieldset>
				<legend>Data KK MASUK yang akan di atur didalam schedule </legend>
				<table width="100%" border="0">
					<tr>
						<th colspan="7" scope="row">
							<font color="#FF0000"><?php echo $_GET['status']; ?></font>
						</th>
					</tr>
					<tr>
						<td scope="row">
							<h4>Pilih Asal Kartu Kerja</h4>
						</td>
						<td width="1%">:</td>
						<td>
							<select style="width: 50%" id="nokk" name="nokk" onchange="window.location='?nokk='+this.value" required disabled> 
								<option value="" disabled selected>-Pilih Tipe Kartu Kerja-</option>
								<option  value="<?= $row_kkmasuk['nokk']; ?>" disabled>KK Lama</option>
								<option value= "<?php echo $_GET['nodemand']; ?>" disabled>KK NOW</option>
								</select=>
						</td>
						<td>
							<h4 style="color: red;">Operation</h4>
						</td>
						<td>:</td>
						<td>
							<select name="operation" onchange="window.location='?typekk='+document.getElementById(`typekk`).value+'&idkk='+document.getElementById(`nokk`).value+'&demand='+document.getElementById(`demand`).value+'&shift=<?php echo $_GET['shift']; ?>&shift2=<?php echo $_GET['shift2']; ?>&operation='+this.value" required="required" >
								<option value="">Pilih</option>
								<?php
								$qry1 = db2_exec($conn_db2, "SELECT
																	p.PRODUCTIONORDERCODE,
																	p.STEPNUMBER AS STEPNUMBER,
																	CASE
																		WHEN TRIM(p.PRODRESERVATIONLINKGROUPCODE) IS NULL OR TRIM(p.PRODRESERVATIONLINKGROUPCODE) = '' THEN TRIM(p.OPERATIONCODE)
																		ELSE TRIM(p.PRODRESERVATIONLINKGROUPCODE)
																	END AS OPERATIONCODE,
																	TRIM(o.OPERATIONGROUPCODE) AS DEPT,
																	o.LONGDESCRIPTION,
																	CASE
																		WHEN p.PROGRESSSTATUS = 0 THEN 'Entered'
																		WHEN p.PROGRESSSTATUS = 1 THEN 'Planned'
																		WHEN p.PROGRESSSTATUS = 2 THEN 'Progress'
																		WHEN p.PROGRESSSTATUS = 3 THEN 'Closed'
																	END AS STATUS_OPERATION,
																	iptip.MULAI,
																	CASE
																		WHEN p.PROGRESSSTATUS = 3 THEN COALESCE(iptop.SELESAI, SUBSTRING(p.LASTUPDATEDATETIME, 1, 19) || '(Run Manual Closures)')
																		ELSE iptop.SELESAI
																	END AS SELESAI,
																	p.PRODUCTIONORDERCODE,
																	p.PRODUCTIONDEMANDCODE,
																	iptip.LONGDESCRIPTION AS OP1,
																	iptop.LONGDESCRIPTION AS OP2,
																	CASE
																		WHEN a.VALUEBOOLEAN = 1 THEN 'Tidak Perlu Gerobak'
																		ELSE LISTAGG(FLOOR(idqd.VALUEQUANTITY), ', ')
																	END AS GEROBAK 
																FROM 
																	PRODUCTIONDEMANDSTEP p 
																LEFT JOIN OPERATION o ON o.CODE = p.OPERATIONCODE 
																LEFT JOIN ADSTORAGE a ON a.UNIQUEID = o.ABSUNIQUEID AND a.FIELDNAME = 'Gerobak'
																LEFT JOIN ITXVIEW_POSISIKK_TGL_IN_PRODORDER iptip ON iptip.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND iptip.DEMANDSTEPSTEPNUMBER = p.STEPNUMBER
																LEFT JOIN ITXVIEW_POSISIKK_TGL_OUT_PRODORDER iptop ON iptop.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND iptop.DEMANDSTEPSTEPNUMBER = p.STEPNUMBER
																LEFT JOIN ITXVIEW_DETAIL_QA_DATA idqd ON idqd.PRODUCTIONDEMANDCODE = p.PRODUCTIONDEMANDCODE AND idqd.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE
																									-- AND idqd.OPERATIONCODE = COALESCE(p.PRODRESERVATIONLINKGROUPCODE, p.OPERATIONCODE)
																									AND idqd.OPERATIONCODE = CASE
																																WHEN TRIM(p.PRODRESERVATIONLINKGROUPCODE) IS NULL OR TRIM(p.PRODRESERVATIONLINKGROUPCODE) = '' THEN TRIM(p.OPERATIONCODE)
																																ELSE TRIM(p.PRODRESERVATIONLINKGROUPCODE)
																															END
																									AND (idqd.VALUEINT = p.STEPNUMBER OR idqd.VALUEINT = p.GROUPSTEPNUMBER) 
																									AND (idqd.CHARACTERISTICCODE = 'GRB1' OR
																										idqd.CHARACTERISTICCODE = 'GRB2' OR
																										idqd.CHARACTERISTICCODE = 'GRB3' OR
																										idqd.CHARACTERISTICCODE = 'GRB4' OR
																										idqd.CHARACTERISTICCODE = 'GRB5' OR
																										idqd.CHARACTERISTICCODE = 'GRB6' OR
																										idqd.CHARACTERISTICCODE = 'GRB7' OR
																										idqd.CHARACTERISTICCODE = 'GRB8')
																									AND NOT (idqd.VALUEQUANTITY = 9 OR idqd.VALUEQUANTITY = 999 OR idqd.VALUEQUANTITY = 1 OR idqd.VALUEQUANTITY = 9999 OR idqd.VALUEQUANTITY = 99999 OR idqd.VALUEQUANTITY = 99 OR idqd.VALUEQUANTITY = 91)
																WHERE
																	p.PRODUCTIONORDERCODE  = '$row_kkmasuk[nokk]' AND p.PRODUCTIONDEMANDCODE = '$row_kkmasuk[nodemand]' AND TRIM(o.OPERATIONGROUPCODE) = 'FIN'
																GROUP BY
																	p.PRODUCTIONORDERCODE,
																	p.STEPNUMBER,
																	p.OPERATIONCODE,
																	p.PRODRESERVATIONLINKGROUPCODE,
																	o.OPERATIONGROUPCODE,
																	o.LONGDESCRIPTION,
																	p.PROGRESSSTATUS,
																	iptip.MULAI,
																	iptop.SELESAI,
																	p.LASTUPDATEDATETIME,
																	p.PRODUCTIONORDERCODE,
																	p.PRODUCTIONDEMANDCODE,
																	iptip.LONGDESCRIPTION,
																	iptop.LONGDESCRIPTION,
																	a.VALUEBOOLEAN
																ORDER BY p.STEPNUMBER ASC");
								while ($r = db2_fetch_assoc($qry1)) {
								?>
									<option value="<?= $r['OPERATIONCODE']; ?>" <?php if ($row_kkmasuk['operation'] == $r['OPERATIONCODE']) {
																					echo "SELECTED";
																				} ?>>
										<?= $r['OPERATIONCODE']; ?> - <?= $r['LONGDESCRIPTION']; ?> (STATUS NOW : <?= $r['STATUS_OPERATION']; ?>)
									</option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td width="13%" scope="row">
							<h4>Nokk</h4>
						</td>
						<td width="1%">:</td>
						<td width="26%">
							<input name="nokk" type="text" id="nokk" size="17"  value="<?php echo $row_kkmasuk['nokk']; ?>" name="id" disabled style="background-color: #BBBBBB ;"/>
							<input name="nokk" type="text" id="nokk" size="17"  value="<?php echo $row_kkmasuk['nodemand']; ?>" name="id" disabled style="background-color: #BBBBBB;"/>
							
						</td>
						<td>
							<h4 style="color: red;">Proses</h4>
						</td>
						<td>:</td>
						<td colspan="2">
							<select name="proses" id="proses" required>
								<option value="">Pilih</option>
								<?php
								$qry1 = mysqli_query($con, "SELECT proses,jns,ket FROM tbl_proses ORDER BY ket, id ASC");
								while ($r = mysqli_fetch_array($qry1)) {
								?>
									<option value="<?php echo $r['proses'] . " (" . $r['jns'] . ")"; ?>" <?php if ($row_kkmasuk['proses'] == $r['proses'] . " (" . $r['jns'] . ")") {
																												echo "SELECTED";
																											} ?>><?= $r['ket'] ?> - <?= $r['proses'] . " (" . $r['jns'] . ")"; ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td scope="row">
							<h4>Langganan/Buyer</h4>
						</td>
						<td>:</td>
						<td>
				
							<input name="buyer" type="text" id="buyer" size="45" value="<?php echo $row_kkmasuk['langganan']; ?> / <?php echo $row_kkmasuk['buyer']; ?>" disabled style="background-color: #BBBBBB;"/>
						</td>

						<td><strong>Nama Mesin</strong></td>
						<td>:</td>
						<td>
							<select name="nama_mesin" required="required" disabled style="background-color: #BBBBBB;" >
								<option value="">Pilih</option>
								<?php
								$q_mesin = db2_exec($conn_db2, "SELECT
																	p.WORKCENTERCODE,
																	CASE
																		WHEN p.PRODRESERVATIONLINKGROUPCODE IS NULL THEN TRIM(p.OPERATIONCODE) 
																		WHEN TRIM(p.PRODRESERVATIONLINKGROUPCODE) = '' THEN TRIM(p.OPERATIONCODE) 
																		ELSE p.PRODRESERVATIONLINKGROUPCODE
																	END	AS OPERATIONCODE,
																	TRIM(o.OPERATIONGROUPCODE) AS OPERATIONGROUPCODE,
																	o.LONGDESCRIPTION,
																	iptip.MULAI,
																	iptop.SELESAI,
																	p.PRODUCTIONORDERCODE,
																	p.PRODUCTIONDEMANDCODE,
																	p.GROUPSTEPNUMBER AS STEPNUMBER,
																	CASE
																		WHEN iptip.MACHINECODE = iptop.MACHINECODE THEN iptip.MACHINECODE
																		ELSE iptip.MACHINECODE || '-' ||iptop.MACHINECODE
																	END AS MESIN   
																FROM 
																	PRODUCTIONDEMANDSTEP p 
																LEFT JOIN OPERATION o ON o.CODE = p.OPERATIONCODE 
																LEFT JOIN ITXVIEW_POSISIKK_TGL_IN_PRODORDER iptip ON iptip.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND iptip.DEMANDSTEPSTEPNUMBER = p.STEPNUMBER
																LEFT JOIN ITXVIEW_POSISIKK_TGL_OUT_PRODORDER iptop ON iptop.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND iptop.DEMANDSTEPSTEPNUMBER = p.STEPNUMBER
																WHERE
																	p.PRODUCTIONORDERCODE  = '$_GET[nokk]' AND p.PRODUCTIONDEMANDCODE = '$_GET[demand]' 
																	AND 
																	CASE
																		WHEN p.PRODRESERVATIONLINKGROUPCODE IS NULL THEN TRIM(p.OPERATIONCODE) 
																		WHEN TRIM(p.PRODRESERVATIONLINKGROUPCODE) = '' THEN TRIM(p.OPERATIONCODE) 
																		ELSE p.PRODRESERVATIONLINKGROUPCODE
																	END = '$_GET[operation]'
																ORDER BY iptip.MULAI ASC");
								$row_mesin = db2_fetch_assoc($q_mesin);

								$qry1 = db2_exec($conn_db2, "SELECT
																DISTINCT 
																SUBSTR(TRIM(p.WORKCENTERCODE), 1, 4) AS WORKCENTERCODE,
																w2.LONGDESCRIPTION 
															FROM
																WORKCENTERANDOPERATTRIBUTES w
															LEFT JOIN OPERATION o ON o.CODE = w.OPERATIONCODE 
															LEFT JOIN PRODUCTIONDEMANDSTEP p ON p.OPERATIONCODE = o.CODE 
															LEFT JOIN WORKCENTER w2 ON w2.CODE = p.WORKCENTERCODE 
															WHERE
																NOT w.LONGDESCRIPTION = 'JANGAN DIPAKE'
																AND TRIM(o.OPERATIONGROUPCODE) = 'FIN'
																AND p.PRODUCTIONORDERCODE  = '$row_kkmasuk[nokk]' 
																AND p.PRODUCTIONDEMANDCODE = '$row_kkmasuk[nodemand]' 
																AND w.OPERATIONCODE = '$row_kkmasuk[operation]'");
								while ($r = db2_fetch_assoc($qry1)) {
								?>
									<option value="<?php echo $r['WORKCENTERCODE']; ?>" SELECTED><?php echo $r['WORKCENTERCODE']; ?> - <?php echo $r['LONGDESCRIPTION']; ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td scope="row">
							<h4>No. Order</h4>
						</td>
						<td>:</td>
						<td>
							
							<input type="text" name="no_order" id="no_order" value="<?php echo $row_kkmasuk['no_order']; ?>" disabled style="background-color: #BBBBBB;"/>
						</td>

						<td scope="row">
							<h4>Personil</h4>
						</td>
						<td>:</td>
						<td>
							<input type="text" name="personil" value="<?= $_SESSION['usr']; ?>" required readonly style="background-color: #BBBBBB;">
						</td>
					</tr>
					<tr>
						<td scope="row">
							<h4>Tgl Delivery</h4>
						</td>
						<td>:</td>
						<td>
							<input type="date" name="tgl_delivery" value="<?= $row_kkmasuk['tgl_delivery']; ?>" disabled style="background-color: #BBBBBB;" />
						</td>

						<td scope="row">
							<h4>Roll</h4>
						</td>
						<td>:</td>
						<td><input name="roll" type="text" id="roll" size="3" placeholder="0" pattern="[0-9]{1,}" value="<?= $row_kkmasuk['roll']; ?>"disabled style="background-color: #BBBBBB;" /></td>
					</tr>
					<tr>
						<td valign="top" scope="row">
							<h4>Jenis Kain</h4>
						</td>
						<td valign="top">:</td>
						<td>
							<textarea name="jenis_kain" cols="35" id="jenis_kain"disabled style="background-color: #BBBBBB;"><?php echo $row_kkmasuk['jenis_kain']; ?></textarea>
						</td>
						<td valign="top">
							<h4 style="color: red;">Catatan</h4>
						</td>
						<td valign="top">:</td>
						<td colspan="2" valign="top">
							<textarea name="catatan" cols="35" id="catatan" ><?php echo $row_kkmasuk['catatan']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td scope="row">
							<h4>No. Warna</h4>
						</td>
						<td>:</td>
						<td>
							<input name="no_warna" type="text" id="no_warna" size="35" value="<?php echo $row_kkmasuk['no_warna']; ?>" disabled style="background-color: #BBBBBB;" />
						</td>

						<td width="14%"><strong>Quantity (Kg)</strong></td>
						<td width="1%">:</td>
						<td colspan="2">
							
							<input name="qty_order" type="text" id="qty_order" size="5" value="<?php echo $row_kkmasuk['qty_order']; ?>" placeholder="qty_order" disabled style="background-color: #BBBBBB;" />
							&nbsp;&nbsp;&nbsp;&nbsp;<strong>Gramasi</strong>:
							<input name="lebar" type="text" id="lebar" size="6" value="<?php echo $row_kkmasuk['gramasi']; ?>" placeholder="gramasi"disabled style="background-color: #BBBBBB;" />
							<input name="gramasi" type="text" id="gramasi" size="6" value="<?= $ngramasi; ?>" placeholder="0" disabled style="background-color: #BBBBBB;" />
						</td>
					</tr>
					<tr>
						<td scope="row">
							<h4>Warna</h4>
						</td>
						<td>:</td>
						<td>
							
							<input name="warna" type="text" id="warna" size="35" value="<?php echo $row_kkmasuk['warna']; ?>" disabled style="background-color: #BBBBBB;" />
						</td>
						<td width="14%"><strong>Panjang (Yard)</strong></td>
						<td>:</td>
						<td colspan="2"><input name="qty2" type="text" id="qty2" size="8" value="<?= $row_kkmasuk['qty_order_yd']; ?><?php echo $row_kkmasuk['panjang']; ?>" placeholder="0.00" onfocus="jumlah();" disabled style="background-color: #BBBBBB;" /></td>
					</tr>
					<tr>
						<td scope="row">
							<h4>Lot</h4>
						</td>
						<td>:</td>
						<td><input name="lot" type="text" id="lot" size="5" value="<?php echo $row_kkmasuk['lot']; ?>"disabled style="background-color: #BBBBBB;"/></td>
						<td>
							<h4 style="color: red;">Proses BC</h4>
						</td>
						<td>:</td>
						<td >
						<select name="prosesbc" id="prosesbc" required>
						<option value="">Pilih</option>
									<?php
										// Mengambil data dari tabel tbl_no_mesin
										$qry = mysqli_query($con, "SELECT no_mesin FROM tbl_mesinbc ORDER BY no_mesin ASC");
										while ($row = mysqli_fetch_array($qry)) {
									?>
									<option value="<?php echo $row['no_mesin']; ?>" 
									<?php if ($rw['no_mesin'] == $row['no_mesin']){echo "SELECTED";} ?>>
									<?php echo $row['no_mesin']; ?></option>
									<?php } ?>
								
							</select>
						</td>
					</tr>
				</table>
			</fieldset>
			
			<br><br>
			<input type="submit" name="btnSimpan" id="btnSimpan" value="Ubah" class="art-button" />
			<input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='../index.php'" class="art-button" />
			<input type="button" name="LihatData" value="Lihat Data" onclick="window.location.href='index.php?p=LihatData'" class="art-button green">
		<?php endif; ?>
	</form>
</body>
</html>