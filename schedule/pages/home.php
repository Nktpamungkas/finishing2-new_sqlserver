<?php
if (empty($_SESSION['usr'])) {
	echo "<script>alert('Silahkan login terlebih dahulu!'); window.location = '../login.php'</script>";
}
?>
<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

		$(document).ready(function () {
			$('#proses_in').change(function () {
				var jam_proses_in = document.getElementById('proses_in').value;
				if (jam_proses_in.substring(0, 2) >= 24) {
					alert("Waktu pada MULAI PROSES tidak boleh melebihi batas 1 hari.");
				}
			});

			$('#stop_mulai').change(function () {
				var jam_stop_mulai = document.getElementById('stop_mulai').value;
				if (jam_stop_mulai.substring(0, 2) >= 24) {
					alert("Waktu pada MULAI STOP MESIN 1 tidak boleh melebihi batas 1 hari.");
				}
			});

			$('#stop_mulai2').change(function () {
				var jam_stop_mulai2 = document.getElementById('stop_mulai2').value;
				if (jam_stop_mulai2.substring(0, 2) >= 24) {
					alert("Waktu pada MULAI STOP MESIN 2 tidak boleh melebihi batas 1 hari.");
				}
			});

			$('#stop_mulai3').change(function () {
				var jam_stop_mulai3 = document.getElementById('stop_mulai3').value;
				if (jam_stop_mulai3.substring(0, 2) >= 24) {
					alert("Waktu pada MULAI STOP MESIN 3 tidak boleh melebihi batas 1 hari.");
				}
			});


			$('#proses_out').change(function () {
				var jam_proses_out = document.getElementById('proses_out').value;
				if (jam_proses_out.substring(0, 2) >= 24) {
					alert("Waktu pada SELESAI PROSES tidak boleh melebihi batas 1 hari.");
				}
			});

			$('#stop_selesai').change(function () {
				var jam_stop_selesai = document.getElementById('stop_selesai').value;
				if (jam_stop_selesai.substring(0, 2) >= 24) {
					alert("Waktu pada SELESAI STOP MESIN 1 tidak boleh melebihi batas 1 hari.");
				}
			});

			$('#stop_selesai2').change(function () {
				var jam_stop_selesai2 = document.getElementById('stop_selesai2').value;
				if (jam_stop_selesai2.substring(0, 2) >= 24) {
					alert("Waktu pada SELESAI STOP MESIN 2 tidak boleh melebihi batas 1 hari.");
				}
			});

			$('#stop_selesai3').change(function () {
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
	include ('../koneksi.php');
	function nourut()
	{
		include ('../koneksi.php');
		$format = date("ymd");
		$sql = mysqli_query($con, "SELECT nokk FROM tbl_produksi WHERE substr(nokk,1,6) like '%" . $format . "%' ORDER BY nokk DESC LIMIT 1 ") or die(mysqli_error());
		$d = mysqli_num_rows($sql);

		if ($d > 0) {
			$r = mysqli_fetch_array($sql);
			$d = $r['nokk'];
			$str = substr($d, 6, 2);
			$Urut = (int) $str;
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
		echo "<script>
						swal({
							title: 'SYSTEM OFFLINE',   
							text: 'Klik Ok untuk input data kembali',
							type: 'success',
						}).then((result) => {
							if (result.value) {
								window.location.href = 'http://online.indotaichen.com/finishing2-new/schedule/?typekk=NOW'; 
							}
						});
					</script>";
	} elseif ($_GET['typekk'] == "NOW") {
		if ($idkk != "") {
			if ($_GET['demand'] != "") {
				$nomordemand = $_GET['demand'];
				$anddemand = "AND nodemand = '$nomordemand'";
			} else {
				$anddemand = "";
			}
			$q_kkproses = mysqli_query($con, "SELECT * FROM `tbl_produksi` WHERE nokk = '$idkk' AND demandno = '$_GET[demand]' AND nama_mesin = '$_GET[operation]'");
			$row_kkproses = mysqli_fetch_assoc($q_kkproses);

			$q_schedule = mysqli_query($con, "SELECT * FROM tbl_schedule_new WHERE nokk = '$idkk' AND nodemand = '$_GET[demand]' AND operation = '$_GET[operation]'");
			$row_schedule = mysqli_fetch_assoc($q_schedule);

			$q_kkmasuk = mysqli_query($con, "SELECT * FROM `tbl_masuk` WHERE nokk = '$idkk' $anddemand ORDER BY id DESC LIMIT 1");
			$row_kkmasuk = mysqli_fetch_assoc($q_kkmasuk);

			if ($row_kkproses) { // JIKA DATANYA SUDAH DI PROSES
				echo "<script>
								swal({
									title: 'Kartu kerja untuk operasi " . $_GET['operation'] . " sudah di proses.',   
									text: 'Klik Ok untuk input data kembali',
									type: 'warning',
								}).then((result) => {
									if (result.value) {
										window.location.href = 'http://online.indotaichen.com/finishing2-new/schedule/?typekk=NOW'; 
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
									window.location.href = 'http://online.indotaichen.com/finishing2-new/schedule/?typekk=NOW'; 
								}
							});
						</script>";
			} elseif (empty($row_kkmasuk)) { // JIKA DATANYA BELUM ADA DI KK MASUK
				echo "<script>
								swal({
									title: 'Kartu kerja belum pernah di input di KK MASUK.',   
									text: 'Klik Ok untuk input data kembali',
									type: 'warning',
								}).then((result) => {
									if (result.value) {
										window.location.href = 'http://online.indotaichen.com/finishing2-new/schedule/?typekk=NOW'; 
									}
								});
							</script>";
			}
		}
	}
	?>
	<?php
	if (isset($_POST['btnSimpan'])) {
		$creationdatetime = date('Y-m-d H:i:s');
		$jenis_kain = addslashes($_POST['jenis_kain']);
		$q_schedule = mysqli_query($con, "SELECT * FROM tbl_schedule_new WHERE nokk = '$idkk' AND nodemand = '$nomordemand' AND operation = '$_GET[operation]'");
		$row_schedule = mysqli_fetch_assoc($q_schedule);
		if (!empty($row_schedule)) { // JIKA DATANYA SUDAH ADA DI SHCEDULE
			$nokk = $_POST['nokk'];
			$demand = $_POST['demand'];
			mysqli_query($con, "INSERT INTO tbl_log	(akun, ipaddress, creationdatetime, catatan) VALUES('$_SESSION[usr]', '$_SERVER[REMOTE_ADDR]', '$creationdatetime', 'Aktivitas Illegal, Schedule input double. $nokk, $demand')");
			echo "<script>
							swal({
								title: 'Anda telah dicatat melakukan aktivias ilegal memasukan schedule lebih dari 1x. Data tidak tersimpan',   
								text: 'Klik Ok untuk input data kembali',
								type: 'warning',
							}).then((result) => {
								if (result.value) {
									window.location.href = 'http://online.indotaichen.com/finishing2-new/schedule/?typekk=NOW'; 
								}
							});
						</script>";
		} else {
			$simpanSql = "INSERT INTO tbl_schedule_new (nokk,
														nodemand,
														nourut,
														langganan,
														buyer,
														no_order,
														jenis_kain,
														tgl_delivery,
														lebar,
														gramasi,
														warna,
														personil,
														no_warna,
														qty_order,
														qty_order_yd,
														lot,
														roll,
														no_mesin,
														nama_mesin,
														proses,
														operation,
														group_shift,
														catatan,
														`status`,
														creationdatetime,
														ipaddress,
														prosesbc) 
											VALUES('$_POST[nokk]',
													'$_POST[demand]',
													'$_POST[no_urut]',
													'$row_kkmasuk[langganan]',
													'$row_kkmasuk[buyer]',
													'$_POST[no_order]',
													'$jenis_kain',
													'$_POST[tgl_delivery]',
													'$_POST[lebar]',
													'$_POST[gramasi]',
													'$_POST[warna]',
													'$_POST[personil]',
													'$_POST[no_warna]',
													'$_POST[qty]',
													'$_POST[qty2]',
													'$_POST[lot]',
													'$_POST[rol]',
													'$_POST[no_mesin]',
													'$_POST[nama_mesin]',
													'$_POST[proses]',
													'$_POST[operation]',
													'$_POST[g_shift]',
													'$_POST[catatan]',
													'SCHEDULE',
													'$creationdatetime',
													'$_SERVER[REMOTE_ADDR]',
													'$_POST[prosesbc]')";
			$simpan = mysqli_query($con, $simpanSql);
			if ($simpan) {
				echo "<script>
								swal({
									title: 'Data Tersimpan',   
									text: 'Klik Ok untuk input data kembali',
									type: 'success',
								}).then((result) => {
									if (result.value) {
										window.location.href = 'http://online.indotaichen.com/finishing2-new/schedule/?typekk=NOW'; 
									}
								});
							</script>";
			}
		}
	}
	?>
	<!--hapus modal dan fungsi-->
	<form id="form1" name="form1" method="post" action="">
		<?php if ($_SESSION['usr'] == 'husni'): ?>
			<input type="button" name="LihatData" value="Lihat Data" onclick="window.location.href='index.php?p=LihatData'"
				class="art-button">
		<?php else: ?>
			<fieldset>
				<legend>Data KK MASUK yang akan di atur didalam schedule </legend>
				<table width="100%" border="0">
					<tr>
						<td scope="row">
							<h4>Pilih Asal Kartu Kerja</h4>
						</td>
						<td width="1%">:</td>
						<td>
							<select style="width: 50%" id="typekk" name="typekk"
								onchange="window.location='?typekk='+this.value" required>
								<option value="" disabled selected>-Pilih Tipe Kartu Kerja-</option>
								<option value="KKLama" <?php if ($_GET['typekk'] == "KKLama") {
									echo "SELECTED";
								} ?>>KK Lama
								</option>
								<option value="NOW" <?php if ($_GET['typekk'] == "NOW") {
									echo "SELECTED";
								} ?>>KK NOW
								</option>
								</select=>
						</td>

						<td scope="row">
							<h4>No. Warna</h4>
						</td>
						<td>:</td>
						<td>
							<input name="no_warna" type="text" id="no_warna" size="35"
								value="<?= $row_kkmasuk['no_warna']; ?>" />
						</td>
					</tr>
					<tr>
						<td width="13%" scope="row">
							<h4>Nokk</h4>
						</td>
						<td width="1%">:</td>
						<td width="26%">
							<input name="nokk" type="text" id="nokk" size="17"
								onchange="window.location='?typekk='+document.getElementById(`typekk`).value+'&idkk='+this.value"
								value="<?php echo $_GET['idkk']; ?>" /><input type="hidden" value="<?php echo $rw['id']; ?>"
								name="id" />

							<?php if ($_GET['typekk'] == 'NOW') { ?>
								<select style="width: 40%" name="demand" id="demand"
									onchange="window.location='?typekk='+document.getElementById(`typekk`).value+'&idkk='+document.getElementById(`nokk`).value+'&demand='+this.value+'&operation=<?= $row_kkmasuk['operation']; ?>'"
									required>
									<option value="" disabled selected>Pilih Nomor Demand</option>
									<?php
									$sql_ITXVIEWKK_demand = mysqli_query($con, "SELECT * FROM `tbl_masuk` WHERE nokk = '$idkk'");
									while ($r_demand = mysqli_fetch_array($sql_ITXVIEWKK_demand)):
										?>
										<?php
										// CEK, JIKA KARTU KERJA SUDAH DIBIKIN SCHEDULE MAKA TIDAK AKAN MUNCUL DI KK MASUK. 
										$cek_schedule = mysqli_query($con, "SELECT COUNT(*) AS jml FROM tbl_schedule_new WHERE nokk = '$r_demand[nokk]' AND nodemand = '$r_demand[nodemand]' AND operation = '$r_demand[operation]'");
										$data_schedule = mysqli_fetch_assoc($cek_schedule);
										?>
										<?php if (empty($data_schedule['jml'])): ?>
											<option value="<?= $r_demand['nodemand']; ?>" <?php if ($r_demand['nodemand'] == $_GET['demand']) {
												  echo 'SELECTED';
											  } ?>><?= $r_demand['nodemand']; ?></option>
										<?php endif; ?>
									<?php endwhile; ?>
								</select>
							<?php } else { ?>
								<input name="demand" id="demand" type="text" placeholder="Nomor Demand">
							<?php } ?>
						</td>


						<td width="14%"><strong>Quantity (Kg)</strong></td>
						<td width="1%">:</td>
						<td colspan="">
							<input name="qty" type="text" id="qty" size="5" value="<?= $row_kkmasuk['qty_order']; ?>"
								placeholder="0.00" />

							<strong>Panjang (Yard)</strong>

							<input name="qty2" type="text" id="qty2" size="8" value="<?= $row_kkmasuk['qty_order_yd']; ?>"
								placeholder="0.00" onfocus="jumlah();" />
						</td>
					</tr>
					<tr>
						<td scope="row">
							<h4>Langganan/Buyer</h4>
						</td>
						<td>:</td>
						<td>
							<input name="buyer" type="text" id="buyer" size="45"
								value="<?= $row_kkmasuk['langganan']; ?>/<?= $row_kkmasuk['buyer']; ?>">
						</td>
						<td scope="row">
							<h4>Lot</h4>
						</td>
						<td>:</td>
						<td><input name="lot" type="text" id="lot" size="5" value="<?= $row_kkmasuk['lot']; ?>" /></td>
					</tr>
					<tr>
						<td scope="row">
							<h4>No. Order</h4>
						</td>
						<td>:</td>
						<td>
							<input type="text" name="no_order" id="no_order" value="<?= $row_kkmasuk['no_order']; ?>" />
						</td>

						<td scope="row">
							<h4>Roll</h4>
						</td>
						<td>:</td>
						<td><input name="rol" type="text" id="rol" size="3" placeholder="0" pattern="[0-9]{1,}"
								value="<?= $row_kkmasuk['roll']; ?>" /></td>
					</tr>
					<tr>
						<td valign="top" scope="row">
							<h4>Jenis Kain</h4>
						</td>
						<td valign="top">:</td>
						<td>
							<textarea name="jenis_kain" cols="35"
								id="jenis_kain"><?= $row_kkmasuk['jenis_kain']; ?></textarea>
						</td>

						<td style="color: red;"><strong>Nomor Mesin</strong></td>
						<td>:</td>
						<td>
							<select name="no_mesin" required>
								<option value="">Pilih</option>
								<?php
								$query_namamesin = "SELECT
																DISTINCT 
																SUBSTR(TRIM(p.WORKCENTERCODE), 1, 4) AS WORKCENTERCODE,
																SUBSTR(TRIM(p.WORKCENTERCODE), 1,4) AS WORKCENTERCODE_CODE,
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
																AND w.OPERATIONCODE = '$_GET[operation]'";
								$q_namamesin = db2_exec($conn_db2, $query_namamesin);
								$workcenter = db2_exec($conn_db2, $query_namamesin);
								$data_workcenter = db2_fetch_assoc($workcenter);

								if ($data_workcenter['WORKCENTERCODE_CODE'] == 'P3ST') {
									$where_st_oven = "(SUBSTR(CODE, 1,4) = 'P3ST' OR SUBSTR(CODE, 1,4) = 'P3DR')";
								} else {
									$where_st_oven = "SUBSTR(CODE, 1,4) = '$data_workcenter[WORKCENTERCODE_CODE]'";
								}

								$q_nomormesin = db2_exec($conn_db2, "SELECT
																					*
																				FROM
																					RESOURCES r
																				WHERE
																					$where_st_oven
																				ORDER BY 
																					SUBSTR(CODE, 6,2) 
																				ASC");
								while ($row_nomormesin = db2_fetch_assoc($q_nomormesin)) {
									?>
									<option value="<?php echo $row_nomormesin['CODE']; ?>">
										<?php echo $row_nomormesin['CODE']; ?> -
										<?php echo $row_nomormesin['LONGDESCRIPTION']; ?>
									</option>
								<?php } ?>
							</select>

							<strong>Nama Mesin :</strong>
							<select name="nama_mesin" required="required">
								<option value="">Pilih</option>
								<?php
								while ($row_namamesin = db2_fetch_assoc($q_namamesin)) {
									?>
									<option value="<?php echo $row_namamesin['WORKCENTERCODE']; ?>" SELECTED>
										<?php echo $row_namamesin['WORKCENTERCODE']; ?> -
										<?php echo $row_namamesin['LONGDESCRIPTION']; ?>
									</option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td scope="row">
							<h4>Tgl. Delivery</h4>
						</td>
						<td>:</td>
						<td>
							<input name="tgl_delivery" type="date" size="35" value="<?= $row_kkmasuk['tgl_delivery']; ?>" />
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
									<option value="<?php echo $r['proses'] . " (" . $r['jns'] . ")"; ?>" <?php if ($row_kkmasuk['proses'] == $r['proses'] . " (" . $r['jns'] . ")") {
												 echo "SELECTED";
											 } ?>><?= $r['ket'] ?> - <?= $r['proses'] . " (" . $r['jns'] . ")"; ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td scope="row">
							<h4>Lebar x Gramasi</h4>
						</td>
						<td>:</td>
						<td>
							<input name="lebar" type="text" id="lebar" size="6" value="<?= $row_kkmasuk['lebar']; ?>"
								placeholder="0" />
							<input name="gramasi" type="text" id="gramasi" size="6" value="<?= $row_kkmasuk['gramasi']; ?>"
								placeholder="0" />
						</td>

						<td>
							<h4>Operation</h4>
						</td>
						<td>:</td>
						<td>
							<select name="operation" id="operation"
								onchange="window.location='?typekk='+document.getElementById(`typekk`).value+'&idkk='+document.getElementById(`nokk`).value+'&demand='+document.getElementById(`demand`).value+'&shift=<?php echo $_GET['shift']; ?>&shift2=<?php echo $_GET['shift2']; ?>&operation='+this.value"
								required="required">
								<option value="">Pilih</option>
								<?php
								$qry1 = mysqli_query($con, "SELECT * FROM tbl_masuk WHERE nokk = '$_GET[idkk]' AND nodemand = '$_GET[demand]' ORDER BY id ASC");
								while ($r = mysqli_fetch_array($qry1)) {
									?>
									<option value="<?= $r['operation']; ?>" <?php if ($_GET['operation'] == $r['operation']) {
										  echo "SELECTED";
									  } ?>>
										<?= $r['operation']; ?>
									</option>
								<?php } ?>
							</select>

							<strong style="color: red;">No Urut :</strong>
							<select name="no_urut" class="form-control select2" id="no_urut">
								<option value="">Pilih</option>
								<?php
								$q_nourut = mysqli_query($con, "SELECT
																			CONCAT('\'', GROUP_CONCAT(nourut ORDER BY nourut SEPARATOR '\', \''), '\'' ) AS nourut
																		FROM
																			`tbl_schedule_new` 
																		WHERE
																			nokk = '$row_kkmasuk[nokk]' 
																			AND nodemand = '$row_kkmasuk[nodemand]'");
								$data_nourut = mysqli_fetch_assoc($q_nourut);
								if ($data_nourut['nourut']) {
									$sqlKap = mysqli_query($con, "SELECT no_urut FROM tbl_urut WHERE NOT no_urut IN ($data_nourut[nourut]) ORDER BY no_urut ASC");
								} else {
									$sqlKap = mysqli_query($con, "SELECT no_urut FROM tbl_urut ORDER BY no_urut ASC");
								}
								while ($rK = mysqli_fetch_array($sqlKap)) {
									?>
									<option value="<?php echo $rK['no_urut']; ?>"><?php echo $rK['no_urut']; ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td scope="row">
							<h4>Warna</h4>
						</td>
						<td>:</td>
						<td>
							<input name="warna" type="text" id="warna" size="35" value="<?= $row_kkmasuk['warna']; ?>" />
						</td>

						<td scope="row" style="color: red;">
							<h4>Group Shift</h4>
						</td>
						<td>:</td>
						<td>
							<select name="g_shift" class="form-control select2">
								<option value="">Pilih</option>
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
							</select>
						</td>
					</tr>
					<tr>
						<td scope="row">
							<h4>Personil</h4>
						</td>
						<td>:</td>
						<td>
							<input type="text" name="personil" value="<?= $_SESSION['usr']; ?>" required readonly
								style="background-color: #BBBBBB;">
						</td>

						<td valign="top">
							<h4>Catatan</h4>
						</td>
						<td valign="top">:</td>
						<td colspan="2" valign="top">
							<textarea name="catatan" cols="35" id="catatan"><?= $row_kkmasuk['catatan']; ?></textarea>
						</td>
					</tr>
					<td>
						<input name="prosesbc" type="hidden" id="warna" size="35"
							value="<?= $row_kkmasuk['prosesbc']; ?>" />
					</td>
				</table>
			</fieldset>
			<fieldset>
				<legend>KETENTUAN INPUT SCHEDULE</legend>
				<li>Jika <b>tidak</b> terdapat kesamaan antara <b>nomor kartu kerja, nomor demand, dan operation</b> di KK
					MASUK, maka data tersebut tidak dapat ditampilkan ke dalam sistem.</li>
				<li>Jika terdapat kesamaan antara <b>nomor kartu kerja, nomor demand, dan operation</b> <span
						style="color: red;">sudah di susun schedule</span>, maka data tersebut tidak dapat ditampilkan ke
					dalam sistem.</li>
				<li>Jika terdapat kesamaan antara <b>nomor kartu kerja, nomor demand, dan operation</b> <span
						style="color: red;">sudah di proses</span>, maka data tersebut tidak dapat ditampilkan ke dalam
					sistem.</li>
			</fieldset>
			<br><br>
			<input type="submit" name="btnSimpan" id="btnSimpan" value="Simpan" class="art-button" />
			<input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='../index.php'"
				class="art-button" />
			<input type="button" name="LihatData" value="Lihat Data" onclick="window.location.href='index.php?p=LihatData'"
				class="art-button">
		<?php endif; ?>
	</form>
</body>

</html>