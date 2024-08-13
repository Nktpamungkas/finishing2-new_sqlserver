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
			width: 80%;
			/* Lebar konten modal sebelum menyesuaikan */
			max-width: 100%;
			/* Maksimum lebar konten modal */
			overflow-x: auto;
			/* Scroll horizontal jika konten melebihi lebar modal */
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
	<?php
	ini_set("error_reporting", 1);
	session_start();
	include('../koneksi.php');
	function nourut()
	{
		include('../koneksi.php');
		$format = date("ymd");
		$sql = mysqli_query($con, "SELECT nokk FROM tbl_produksi WHERE substr(nokk,1,6) like '%" . $format . "%' ORDER BY nokk DESC LIMIT 1 ") or die(mysqli_error());
		$d = mysqli_num_rows($sql);

		if ($d > 0) {
			$r = mysqli_fetch_array($sql);
			$d = $r['nokk'];
			$str = substr($d, 6, 2);
			$Urut = (int)$str;
		} else {
			$Urut = 0;
		}
		$Urut = $Urut + 1;
		$Nol = "";
		$nilai = 2 - strlen($Urut);
		for ($i = 1; $i <= $nilai; $i++) {
			$Nol = $Nol . "0";
		}
		$nipbr = $format . $Nol . $Urut;
		return $nipbr;
	}
	$nou = nourut();
	if ($_REQUEST['kk'] != '') {
		$idkk = "";
	} else {
		$idkk = $_GET['idkk'];
	}
	if ($_GET['typekk'] == "KKLama") {
		echo 	"<script>
						swal({
							title: 'SYSTEM OFFLINE',   
							text: 'Klik Ok untuk input data kembali',
							type: 'success',
						}).then((result) => {
							if (result.value) {
								window.location.href = 'http://online.indotaichen.com/finishing2-new/masuk/?typekk=NOW'; 
							}
						});
					</script>";
	} elseif ($_GET['typekk'] == "NOW" or $_GET['operation']) {
		if ($idkk != "") {
			$q_kkproses		= mysqli_query($con, "SELECT * FROM `tbl_produksi` WHERE nokk = '$idkk' AND demandno = '$_GET[demand]' AND nama_mesin = '$_GET[operation]'");
			$row_kkproses	= mysqli_fetch_assoc($q_kkproses);

			$q_schedule		= mysqli_query($con, "SELECT * FROM tbl_schedule_new WHERE nokk = '$idkk' AND nodemand = '$_GET[demand]' AND operation = '$_GET[operation]'");
			$row_schedule	= mysqli_fetch_assoc($q_schedule);

			$q_kkmasuk		= mysqli_query($con, "SELECT * FROM `tbl_masuk` WHERE nokk = '$idkk' AND nodemand = '$_GET[demand]' AND operation = '$_GET[operation]'");
			$row_kkmasuk	= mysqli_fetch_assoc($q_kkmasuk);

			if ($row_kkproses) { // JIKA DATANYA SUDAH DI PROSES
				echo 	"<script>
								swal({
									title: 'Kartu kerja untuk operasi " . $_GET['operation'] . " sudah di proses.',   
									text: 'Klik Ok untuk input data kembali',
									type: 'warning',
								}).then((result) => {
									if (result.value) {
										window.location.href = 'http://online.indotaichen.com/finishing2-new/masuk/?typekk=NOW'; 
									}
								});
							</script>";
			} elseif ($row_schedule) { // JIKA DATANYA SUDAH ADA DI SCHEDULE
				echo "<script>
							swal({
								title: 'Kartu kerja untuk operasi " . $_GET['operation'] . " sudah sampai SHCEDULE.',   
								text: 'Klik Ok untuk input data kembali',
								type: 'warning',
							}).then((result) => {
								if (result.value) {
									window.location.href = 'http://online.indotaichen.com/finishing2-new/masuk/?typekk=NOW'; 
								}
							});
						</script>";
			} elseif ($row_kkmasuk) { // JIKA DATANYA SUDAH ADA DI KK MASUK
				echo 	"<script>
								swal({
									title: 'Kartu kerja untuk operasi " . $_GET['operation'] . " sudah pernah di input di KK MASUK.',   
									text: 'Klik Ok untuk input data kembali',
									type: 'warning',
								}).then((result) => {
									if (result.value) {
										window.location.href = 'http://online.indotaichen.com/finishing2-new/masuk/?typekk=NOW'; 
									}
								});
							</script>";
			}
			include_once("../now.php");
		}
	}
	?>
	<?php
	if (isset($_POST['btnSimpan'])) {
		$creationdatetime	= date('Y-m-d H:i:s');
		$jenis_kain		= addslashes($_POST['jenis_kain']);

		$q_kkproses		= mysqli_query($con, "SELECT * FROM `tbl_produksi` WHERE nokk = '$idkk' AND demandno = '$_GET[demand]' AND nama_mesin = '$_GET[operation]'");
		$row_kkproses	= mysqli_fetch_assoc($q_kkproses);

		$q_kkmasuk		= mysqli_query($con, "SELECT * FROM `tbl_masuk` WHERE nokk = '$idkk' AND nodemand = '$_GET[demand]' AND operation = '$_GET[operation]'");
		$row_kkmasuk	= mysqli_fetch_assoc($q_kkmasuk);

		if ($row_kkproses) {
			echo 	"<script>
							swal({
								title: 'Data tidak Tersimpan, karena Kartu kerja untuk operasi " . $_GET['operation'] . " sudah selesai diproses.<br> Tgl Proses : " . $row_kkproses['tgl_pro'] . "',   
								text: 'Klik Ok untuk input data kembali',
								type: 'warning',
							}).then((result) => {
								if (result.value) {
									window.location.href = 'http://online.indotaichen.com/finishing2-new/masuk/?typekk=NOW'; 
								}
							});
						</script>";
		} elseif ($row_kkmasuk) {
			$nokk	= $_POST['nokk'];
			$demand	= $_POST['demand'];
			mysqli_query($con, "INSERT INTO tbl_log	(akun, ipaddress, creationdatetime, catatan, `status`) VALUES('$_SESSION[usr]', '$_SERVER[REMOTE_ADDR]', '$creationdatetime', 'Aktivitas Illegal, Schedule input double. $nokk, $demand', 'kkmasuk')");
			echo 	"<script>
								swal({
									title: 'Anda telah dicatat melakukan aktivias ilegal memasukan kk masuk lebih dari 1x dengan operation yang sama. <br> Data tidak tersimpan',   
									text: 'Klik Ok untuk input data kembali',
									type: 'warning',
								}).then((result) => {
									if (result.value) {
										window.location.href = 'http://online.indotaichen.com/finishing2-new/masuk/?typekk=NOW'; 
									}
								});
							</script>";
		} else {
			$simpanSql = "INSERT INTO tbl_masuk (nokk,
													nodemand,
													operation,
													nama_mesin,
													langganan,
													buyer,
													no_order,
													tgl_delivery,
													jenis_kain,
													lebar,
													gramasi,
													warna,
													no_warna,
													qty_order,
													qty_order_yd,
													lot,
													roll,
													proses,
													personil,
													catatan,
													`status`,
													creationdatetime,
													ipaddress,
													prosesbc) 
										VALUES('$_POST[nokk]',
												'$_POST[demand]',
												'$_POST[operation]',
												'$_POST[nama_mesin]',
												'$dt_pelanggan_buyer[PELANGGAN]',
												'$dt_pelanggan_buyer[BUYER]',
												'$_POST[no_order]',
												'$_POST[tgl_delivery]',
												'$jenis_kain',
												'$_POST[lebar]',
												'$_POST[gramasi]',
												'$_POST[warna]',
												'$_POST[no_warna]',
												'$_POST[qty]',
												'$_POST[qty2]',
												'$_POST[lot]',
												'$_POST[rol]',
												'$_POST[proses]',
												'$_POST[personil]',
												'$_POST[catatan]',
												'KK MASUK',
												'$creationdatetime',
												'$_SERVER[REMOTE_ADDR]',
												'$_POST[prosesbc]')";
			mysqli_query($con, $simpanSql);

			// Refresh form
			// echo "<meta http-equiv='refresh' content='0; url=?typekk=NOW&idkk=$idkk&status=Data Sudah DiSimpan'>";
			echo 	"<script>
							swal({
								title: 'Data Tersimpan',   
								text: 'Klik Ok untuk input data kembali',
								type: 'success',
							}).then((result) => {
								if (result.value) {
									window.location.href = 'http://online.indotaichen.com/finishing2-new/masuk/?typekk=NOW'; 
								}
							});
						</script>";
		}
	}
	?>
	<!-- <button onclick="openModal()">Buka Modal</button> -->
	<!-- Modal -->
	<!-- <div id="myModal" class="modal">

		Konten modal
		<div class="modal-content">
			<span class="close" onclick="closeModal()">&times;</span>
			<center><h2>Data 2 hari tidak bergerak</h2></center>
			<div class="row">
			<table width="100%" border="1" id="datatables" class="display">
				<thead>
					<tr>
						<th style="border:1px solid;vertical-align:middle; font-weight: bold;">NAMA MESIN</th>
						<th style="border:1px solid;vertical-align:middle; font-weight: bold;">OPERATION</th>
						<th style="border:1px solid;vertical-align:middle; font-weight: bold;">NO KK</th>
						<th style="border:1px solid;vertical-align:middle; font-weight: bold;">NO DEMAND</th>
						<th style="border:1px solid;vertical-align:middle; font-weight: bold;">LANGGANAN</th>
						<th style="border:1px solid;vertical-align:middle; font-weight: bold;">BUYER</th>
						<th style="border:1px solid;vertical-align:middle; font-weight: bold;">NO ORDER</th>
						<th style="border:1px solid;vertical-align:middle; font-weight: bold;">LEBAR x GRAMASI</th>
						<th style="border:1px solid;vertical-align:middle; font-weight: bold;">NO WARNA</th>
						<th style="border:1px solid;vertical-align:middle; font-weight: bold;">WARNA</th>
						<th style="border:1px solid;vertical-align:middle; font-weight: bold;">LOT</th>
						<th style="border:1px solid;vertical-align:middle; font-weight: bold;">ROL</th>
						<th style="border:1px solid;vertical-align:middle; font-weight: bold;">QTY</th>
						<th style="border:1px solid;vertical-align:middle; font-weight: bold;">PROSES</th>
						<th style="border:1px solid;vertical-align:middle; font-weight: bold;">CATATAN</th>
						<th style="border:1px solid;vertical-align:middle; font-weight: bold;">CREATION DATE TIME</th>
					</tr>
				</thead>
				<tbody>
					<?php
					// Hitung tanggal dua hari kebelakang dari hari ini
					$dateTwoDaysAgo = date('Y-m-d', strtotime('-3 days'));
					$dateTwoDaysNow = date('Y-m-d');

					$q_tblmasuk     = mysqli_query($con, "SELECT 
																	* 
																FROM 
																	tbl_masuk a 
																WHERE
																	NOT EXISTS (
																			SELECT 1
																			FROM
																				tbl_schedule_new b
																			WHERE
																				b.nokk = a.nokk 
																				AND b.nodemand = a.nodemand 
																				AND b.operation = a.operation
																	)
																	AND NOT EXISTS (
																			SELECT 1
																			FROM
																				tbl_produksi c
																			WHERE
																				c.nokk = a.nokk 
																				AND c.demandno = a.nodemand 
																				AND c.nama_mesin = a.operation
																	) AND a.status = 'KK MASUK' 
																	AND SUBSTR(a.creationdatetime, 1, 10) BETWEEN '2024-04-10' AND '$dateTwoDaysAgo'
																ORDER BY a.id ASC");
					$totalQty = 0;
					$totalRoll = 0;
					?>
					<?php while ($row_tblmasuk  = mysqli_fetch_array($q_tblmasuk)) : ?>
						<tr>
							<td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_tblmasuk['nama_mesin'] ?></td>
							<td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_tblmasuk['operation'] ?></td>
							<td style="border:1px solid;vertical-align:middle;"><a title="MEMO PENTING" target="_BLANK" href="http://online.indotaichen.com/laporan/ppc_filter.php?demand=<?= TRIM($row_tblmasuk['nodemand']); ?>&prod_order=<?= $row_tblmasuk['nokk']; ?>"><?= $row_tblmasuk['nokk'] ?></a></td>
							<td style="border:1px solid;vertical-align:middle;"><a title="POSISI KK" target="_BLANK" href="http://online.indotaichen.com/laporan/ppc_filter_steps.php?demand=<?= $row_tblmasuk['nodemand']; ?>&prod_order=<?= $row_tblmasuk['nokk']; ?>"><?= $row_tblmasuk['nodemand'] ?></a></td>
							<td style="border:1px solid;vertical-align:middle;"><?= $row_tblmasuk['langganan'] ?></td>
							<td style="border:1px solid;vertical-align:middle;"><?= $row_tblmasuk['buyer'] ?></td>
							<td style="border:1px solid;vertical-align:middle;"><?= $row_tblmasuk['no_order'] ?></td>
							<td style="border:1px solid;vertical-align:middle;"><?= $row_tblmasuk['lebar'] ?> x <?= $row_tblmasuk['gramasi'] ?></td>
							<td style="border:1px solid;vertical-align:middle;"><?= $row_tblmasuk['no_warna'] ?></td>
							<td style="border:1px solid;vertical-align:middle;"><?= $row_tblmasuk['warna'] ?></td>
							<td style="border:1px solid;vertical-align:middle;"><?= $row_tblmasuk['lot'] ?></td>
							<td style="border:1px solid;vertical-align:middle;"><?= $row_tblmasuk['roll'] ?></td>
							<td style="border:1px solid;vertical-align:middle;"><?= $row_tblmasuk['qty_order'] ?></td>
							<td style="border:1px solid;vertical-align:middle;"><?= $row_tblmasuk['proses'] ?></td>
							<td style="border:1px solid;vertical-align:middle; color:red;"><?= $row_tblmasuk['catatan'] ?></td>
							<td style="border:1px solid;vertical-align:middle;"><?= $row_tblmasuk['personil'] ?><br><?= $row_tblmasuk['creationdatetime'] ?></td>
							<?php $totalQty += $row_tblmasuk['qty_order']; ?>
							<?php $totalRoll += $row_tblmasuk['roll']; ?>
						</tr>
					<?php endwhile; ?>
				</tbody>
				<tfoot>
					<tr>
						<td style="border:1px solid;vertical-align:middle; text-align: center; font-weight: bold;" colspan="11">TOTAL</td>
						<td style="border:1px solid;vertical-align:middle; text-align: center; font-weight: bold;"><?= $totalRoll; ?></td>
						<td style="border:1px solid;vertical-align:middle; text-align: center; font-weight: bold;"><?= number_format($totalQty, 2); ?></td>
						<td style="border:1px solid;vertical-align:middle; text-align: center;" colspan="5"></td>
					</tr>
				</tfoot>
			</table>
			</div>
		</div>
	</div> -->

	<script>
		// Fungsi untuk membuka modal
		function openModal() {
			document.getElementById("myModal").style.display = "block";
		}

		// Fungsi untuk menutup modal
		function closeModal() {
			document.getElementById("myModal").style.display = "none";
		}
	</script>

	<!-- Script untuk memanggil fungsi openModal() -->
	<script>
		// Fungsi untuk membuka modal
		function openModal() {
			document.getElementById("myModal").style.display = "block";
		}

		// Memanggil fungsi openModal() saat halaman selesai dimuat
		window.onload = openModal;
	</script>
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
							<select style="width: 50%" id="typekk" name="typekk" onchange="window.location='?typekk='+this.value" required>
								<option value="" disabled selected>-Pilih Tipe Kartu Kerja-</option>
								<option value="KKLama" <?php if ($_GET['typekk'] == "KKLama") {
															echo "SELECTED";
														} ?>>KK Lama</option>
								<option value="NOW" <?php if ($_GET['typekk'] == "NOW") {
														echo "SELECTED";
													} ?>>KK NOW</option>
								</select=>
						</td>
						<td>
							<h4>Operation</h4>
						</td>
						<td>:</td>
						<td>
							<select name="operation" onchange="window.location='?typekk='+document.getElementById(`typekk`).value+'&idkk='+document.getElementById(`nokk`).value+'&demand='+document.getElementById(`demand`).value+'&shift=<?php echo $_GET['shift']; ?>&shift2=<?php echo $_GET['shift2']; ?>&operation='+this.value" required="required">
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
																	p.PRODUCTIONORDERCODE  = '$_GET[idkk]' AND p.PRODUCTIONDEMANDCODE = '$_GET[demand]' AND TRIM(o.OPERATIONGROUPCODE) = 'FIN'
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
									<option value="<?= $r['OPERATIONCODE']; ?>" <?php if ($_GET['operation'] == $r['OPERATIONCODE']) {
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
							<input name="nokk" type="text" id="nokk" size="17" onchange="window.location='?typekk='+document.getElementById(`typekk`).value+'&idkk='+this.value" value="<?php echo $_GET['idkk']; ?>" /><input type="hidden" value="<?php echo $rw['id']; ?>" name="id" />

							<?php if ($_GET['typekk'] == 'NOW') {  ?>
								<select style="width: 40%" name="demand" id="demand" onchange="window.location='?typekk='+document.getElementById(`typekk`).value+'&idkk='+document.getElementById(`nokk`).value+'&demand='+this.value" required>
									<option value="" disabled selected>Pilih Nomor Demand</option>
									<?php
									$sql_ITXVIEWKK_demand  = db2_exec($conn_db2, "SELECT DEAMAND AS DEMAND FROM ITXVIEWKK WHERE PRODUCTIONORDERCODE = '$idkk'");
									while ($r_demand = db2_fetch_assoc($sql_ITXVIEWKK_demand)) :
									?>
										<option value="<?= $r_demand['DEMAND']; ?>" <?php if ($r_demand['DEMAND'] == $_GET['demand']) {
																						echo 'SELECTED';
																					} ?>><?= $r_demand['DEMAND']; ?></option>
									<?php endwhile; ?>
								</select>
							<?php } else { ?>
								<input name="demand" id="demand" type="text" placeholder="Nomor Demand">
							<?php } ?>
						</td>
						<td>
							<h4>Proses</h4>
						</td>
						<td>:</td>
						<td colspan="2">
							<select name="proses" id="proses" required>
								<option value="">Pilih</option>
								<?php
								$qry1 = mysqli_query($con, "SELECT proses,jns,ket FROM tbl_proses ORDER BY ket, id ASC");
								while ($r = mysqli_fetch_array($qry1)) {
								?>
									<option value="<?php echo $r['proses'] . " (" . $r['jns'] . ")"; ?>" <?php if ($rw['proses'] == $r['proses'] . " (" . $r['jns'] . ")") {
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
							<?php if ($_GET['typekk'] == "NOW") : ?>
								<?php $langganan_buyer =  $dt_pelanggan_buyer['PELANGGAN'] . '/' . $dt_pelanggan_buyer['BUYER']; ?>
							<?php else : ?>
								<?php if ($cek > 0) {
									$langganan_buyer =  $ssr1['partnername'] . "/" . $ssr2['partnername'];
								} else {
									$langganan_buyer =  $rw['langganan'];
								} ?>
							<?php endif; ?>
							<input name="buyer" type="text" id="buyer" size="45" value="<?= $langganan_buyer; ?>">
						</td>

						<td><strong>Nama Mesin</strong></td>
						<td>:</td>
						<td>
							<select name="nama_mesin" required="required">
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
																	p.PRODUCTIONORDERCODE  = '$_GET[idkk]' AND p.PRODUCTIONDEMANDCODE = '$_GET[demand]' 
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
																AND p.PRODUCTIONORDERCODE  = '$_GET[idkk]' 
																AND p.PRODUCTIONDEMANDCODE = '$_GET[demand]'
																AND w.OPERATIONCODE = '$_GET[operation]'");
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
							<?php if ($_GET['typekk'] == "NOW") : ?>
								<?php $no_order =  $dt_ITXVIEWKK['PROJECTCODE']; ?>
							<?php else : ?>
								<?php if ($cek > 0) {
									$no_order =  $ssr['documentno'];
								} else {
									$no_order =  $rw['no_order'];
								} ?>
							<?php endif; ?>
							<input type="text" name="no_order" id="no_order" value="<?= $no_order; ?>" />
						</td>
						<td scope="row">
							<h4>Personil</h4>
						</td>
						<td>:</td>
						<td>
							<input type="text" name="personil" value="<?= $_SESSION['usr']; ?>" required readonly style="background-color: #BBBBBB;">
						</td>
					</tr>
					<td scope="row">
						<h4>Tgl Delivery</h4>
					</td>
					<td>:</td>
					<td>
						<input type="date" name="tgl_delivery" value="<?= $dt_ITXVIEWKK['DELIVERYDATE']; ?>" />
					</td>

					<td scope="row">
						<h4>Roll</h4>
					</td>
					<td>:</td>
					<td><input name="rol" type="text" id="rol" size="3" placeholder="0" pattern="[0-9]{1,}" value="<?= $dt_roll['ROLL']; ?>" /></td>
					</tr>
					<tr>
						<td valign="top" scope="row">
							<h4>Jenis Kain</h4>
						</td>
						<td valign="top">:</td>
						<td>
							<?php if ($_GET['typekk'] == "NOW") : ?>
								<?php $jk = $dt_ITXVIEWKK['ITEMDESCRIPTION']; ?>
							<?php else : ?>
								<?php if ($cek > 0) {
									$jk = $ssr['productcode'] . " / " . $ssr['description'];
								} else {
									$jk = $rw['jenis_kain'];
								} ?>
							<?php endif; ?>
							<textarea name="jenis_kain" cols="35" id="jenis_kain"><?= $jk; ?></textarea>
						</td>
						<td valign="top">
							<h4>Catatan</h4>
						</td>
						<td valign="top">:</td>
						<td colspan="2" valign="top">
							<textarea name="catatan" cols="35" id="catatan"><?php echo $rw['catatan']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td scope="row">
							<h4>No. Warna</h4>
						</td>
						<td>:</td>
						<td>
							<?php if ($_GET['typekk'] == "NOW") : ?>
								<?php $nomor_warna = $dt_ITXVIEWKK['NO_WARNA']; ?>
							<?php else : ?>
								<?php if ($cek > 0) {
									$nomor_warna = $ssr['colorno'];
								} else {
									$nomor_warna = $rw['no_warna'];
								} ?>
							<?php endif; ?>
							<input name="no_warna" type="text" id="no_warna" size="35" value="<?= $nomor_warna; ?>" />
						</td>

						<td width="14%"><strong>Quantity (Kg)</strong></td>
						<td width="1%">:</td>
						<td colspan="2">
							<?php if ($_GET['typekk'] == "NOW") : ?>
								<?php $berat = $dt_qtyorder['QTY_ORDER']; ?>
							<?php else : ?>
								<?php if ($cLot > 0) {
									$berat = round($sLot['Weight'], 2);
								} else if ($rc > 0) {
									$berat = round($rw['qty'], 2);
								} else if ($rcAdm > 0) {
									$berat = $rwAdm['qty'];
								} ?>
							<?php endif; ?>
							<input name="qty" type="text" id="qty" size="5" value="<?= $berat; ?>" placeholder="0.00" />
							&nbsp;&nbsp;&nbsp;&nbsp;<strong>Gramasi</strong>:
							<?php if ($_GET['typekk'] == "NOW") : ?>
								<?php $nlebar = floor($dt_lg['LEBAR']); ?>
							<?php else : ?>
								<?php if ($cek > 0) {
									$nlebar = round($ssr['cuttablewidth'], 2);
								} else if ($rcAdm > 0) {
									$nlebar = $rwAdm['lebar'];
								} ?>
							<?php endif; ?>
							<input name="lebar" type="text" id="lebar" size="6" value="<?= $nlebar; ?>" placeholder="0" />
							<?php if ($_GET['typekk'] == "NOW") : ?>
								<?php $ngramasi = floor($dt_lg['GRAMASI']) ?>
							<?php else : ?>
								<?php if ($cek > 0) {
									$ngramasi = round($ssr['weight'], 2);
								} else if ($rcAdm > 0) {
									$ngramasi = $rwAdm['gramasi'];
								} ?>
							<?php endif; ?>
							<input name="gramasi" type="text" id="gramasi" size="6" value="<?= $ngramasi; ?>" placeholder="0" />
						</td>
					</tr>
					<tr>
						<td scope="row">
							<h4>Warna</h4>
						</td>
						<td>:</td>
						<td>
							<?php if ($_GET['typekk'] == "NOW") : ?>
								<?php $nama_warna = $dt_warna['WARNA']; ?>
							<?php else : ?>
								<?php if ($cek > 0) {
									$nama_warna = $ssr['color'];
								} else {
									$nama_warna = $rw['warna'];
								} ?>
							<?php endif; ?>
							<input name="warna" type="text" id="warna" size="35" value="<?= $nama_warna; ?>" />
						</td>
						<td width="14%"><strong>Panjang (Yard)</strong></td>
						<td>:</td>
						<td colspan="2"><input name="qty2" type="text" id="qty2" size="8" value="<?= $dt_qtyorder['QTY_ORDER_YARD']; ?><?php echo $rw['panjang']; ?>" placeholder="0.00" onfocus="jumlah();" /></td>
					</tr>
					<tr>
						<td scope="row">
							<h4>Lot</h4>
						</td>
						<td>:</td>
						<td><input name="lot" type="text" id="lot" size="5" value="<?= $dt_ITXVIEWKK['LOT']; ?>" /></td>

						<td>
							<h4>Proses BC</h4>
						</td>
						<td>:</td>
						<td>
							<select name="prosesbc" id="prosesbc">
								<option value="">Pilih</option>
								<?php
								// Mengambil data dari tabel tbl_no_mesin
								$qry = mysqli_query($con, "SELECT no_mesin FROM tbl_mesinbc ORDER BY no_mesin ASC");
								while ($row = mysqli_fetch_array($qry)) {
								?>
									<option value="<?php echo $row['no_mesin']; ?>" <?php if ($rw['no_mesin'] == $row['no_mesin']) {
																						echo "SELECTED";
																					} ?>>
										<?php echo $row['no_mesin']; ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
				<legend>KETENTUAN INPUT KK MASUK</legend>
				<li>Jika terdapat kesamaan antara <b>nomor kartu kerja, nomor demand, dan operation</b>, maka data tersebut tidak dapat disimpan atau dimasukkan ke dalam sistem.</li>
				<li>Jika terdapat kesamaan antara <b>nomor kartu kerja, nomor demand, dan operation</b> <span style="color: red;">sudah di susun schedule</span>, maka data tersebut tidak dapat disimpan atau dimasukkan ke dalam sistem.</li>
				<li>Jika terdapat kesamaan antara <b>nomor kartu kerja, nomor demand, dan operation</b> <span style="color: red;">sudah di proses</span>, maka data tersebut tidak dapat disimpan atau dimasukkan ke dalam sistem.</li>
			</fieldset>
			<br><br>
			<input type="submit" name="btnSimpan" id="btnSimpan" value="Simpan" class="art-button" />
			<input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='../index.php'" class="art-button" />
			<input type="button" name="LihatData" value="Lihat Data" onclick="window.location.href='index.php?p=LihatData'" class="art-button green">
		<?php endif; ?>
	</form>
</body>

</html>