<?php
session_start(); // Moved session_start() to the beginning of the script
if (empty($_SESSION['usr'])) {
	echo "<script>alert('Silahkan login terlebih dahulu!'); window.location = '../login.php'</script>";
	exit();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Home</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Added jQuery CDN -->
	<script>
	function roundToTwo(num) {
		return +(Math.round(num + "e+2") + "e-2");
	}

	function jumlah() {
		var lebar = document.forms['form1']['lebar'].value;
		var berat = document.forms['form1']['gramasi'].value;
		var netto = document.forms['form1']['qty'].value;
		var x = ((parseInt(lebar)) * parseInt(berat)) / 43.056;
		var x1 = (1000 / x);
		var yard = x1 * parseFloat(netto);
		document.form1.qty2.value = roundToTwo(yard).toFixed(2);
	}

	function jumlah1() {
		var lebar1 = document.forms['form1']['h_lebar'].value;
		var berat1 = document.forms['form1']['h_gramasi'].value;
		var netto1 = document.forms['form1']['qty'].value;
		var x1 = ((parseInt(lebar1)) * parseInt(berat1)) / 43.056;
		var x2 = (1000 / x1);
		var yard1 = x2 * parseFloat(netto1);
		document.form1.qty3.value = roundToTwo(yard1).toFixed(2);
	}

	$(document).ready(function() {
		$('#proses_in, #stop_mulai, #stop_mulai2, #stop_mulai3, #proses_out, #stop_selesai, #stop_selesai2, #stop_selesai3')
			.change(function() {
				var id = this.id;
				var value = $(this).val();
				if (value.substring(0, 2) >= 24) {
					alert("Waktu pada " + id.replace(/_/g, ' ').toUpperCase() +
						" tidak boleh melebihi batas 1 hari.");
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
		color: #FFFFFF;
		margin-bottom: 10px;
		padding: 0.5em 1em;
	}
	</style>
	<style>
	.modal {
		display: none;
		position: fixed;
		z-index: 1;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		overflow: auto;
		background-color: rgba(0, 0, 0, 0.4);
	}

	.modal-content {
		background-color: #FFE4E4;
		margin: 15% auto;
		padding: 20px;
		border: 1px solid #888;
		width: 80%;
		max-width: 100%;
		overflow-x: auto;
	}

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
	include('../koneksi.php');

	function nourut()
	{
		global $con;
		$format = date("ymd");
		$sql = "SELECT nokk FROM db_finishing.tbl_produksi WHERE SUBSTRING(nokk, 1, 6) LIKE ? ORDER BY nokk DESC";
		$params = array("%$format%");
		$stmt = sqlsrv_query($con, $sql, $params);

		if ($stmt === false) {
			die(print_r(sqlsrv_errors(), true));
		}

		$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
		$Urut = ($row) ? (int) substr($row['nokk'], 6, 2) + 1 : 1;
		$Nol = str_repeat("0", 2 - strlen($Urut));
		return $format . $Nol . $Urut;
	}

	$nou = nourut();
	$idkk = isset($_REQUEST['kk']) && $_REQUEST['kk'] != '' ? "" : $_GET['idkk'];

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
			$anddemand = isset($_GET['demand']) && $_GET['demand'] != "" ? "AND nodemand = ?" : "";

			// Query for tbl_produksi
			$sql_kkproses = "SELECT * FROM db_finishing.tbl_produksi WHERE nokk = ? AND demandno = ? AND nama_mesin = ?";
			$params_kkproses = array($idkk, $_GET['demand'], $_GET['operation']);
			$stmt_kkproses = sqlsrv_query($con, $sql_kkproses, $params_kkproses);
			$row_kkproses = sqlsrv_fetch_array($stmt_kkproses, SQLSRV_FETCH_ASSOC);

			// Query for tbl_schedule_new
			$sql_schedule = "SELECT * FROM db_finishing.tbl_schedule_new WHERE nokk = ? AND nodemand = ? AND operation = ?";
			$params_schedule = array($idkk, $_GET['demand'], $_GET['operation']);
			$stmt_schedule = sqlsrv_query($con, $sql_schedule, $params_schedule);
			$row_schedule = sqlsrv_fetch_array($stmt_schedule, SQLSRV_FETCH_ASSOC);

			// Query for tbl_masuk
			$sql_kkmasuk = "SELECT * FROM db_finishing.tbl_masuk WHERE nokk = ? " . $anddemand . " ORDER BY id DESC";
			$params_kkmasuk = array($idkk);
			if (!empty($_GET['demand'])) {
				$params_kkmasuk[] = $_GET['demand'];
			}
			$stmt_kkmasuk = sqlsrv_query($con, $sql_kkmasuk, $params_kkmasuk);
			$row_kkmasuk = sqlsrv_fetch_array($stmt_kkmasuk, SQLSRV_FETCH_ASSOC);

			if ($row_kkproses) {
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
			} elseif ($row_schedule) {
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
			} elseif (empty($row_kkmasuk)) {
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

		// Query untuk memeriksa keberadaan data di tbl_schedule_new
		$sql_schedule = "SELECT * FROM db_finishing.tbl_schedule_new WHERE nokk = ? AND nodemand = ? AND operation = ?";
		$params_schedule = array($_POST['nokk'], $_POST['demand'], $_POST['operation']);
		$stmt_schedule = sqlsrv_query($con, $sql_schedule, $params_schedule);

		if ($stmt_schedule === false) {
			die(print_r(sqlsrv_errors(), true));
		}

		$row_schedule = sqlsrv_fetch_array($stmt_schedule, SQLSRV_FETCH_ASSOC);

		if (!empty($row_schedule)) { // Jika data sudah ada di schedule
			$nokk = $_POST['nokk'];
			$demand = $_POST['demand'];

			// Log aktivitas ilegal
			$logSql = "INSERT INTO db_finishing.tbl_log (akun, ipaddress, creationdatetime, catatan) VALUES (?, ?, ?, ?)";
			$logParams = array($_SESSION['usr'], $_SERVER['REMOTE_ADDR'], $creationdatetime, "Aktivitas Illegal, Schedule input double. $nokk, $demand");
			$stmt_log = sqlsrv_query($con, $logSql, $logParams);

			if ($stmt_log === false) {
				die('a' . print_r(sqlsrv_errors(), true));
			}

			echo "<script>
            swal({
                title: 'Anda telah dicatat melakukan aktivitas ilegal memasukan schedule lebih dari 1x. Data tidak tersimpan',   
                text: 'Klik Ok untuk input data kembali',
                type: 'warning',
            }).then((result) => {
                if (result.value) {
                    window.location.href = 'http://online.indotaichen.com/finishing2-new/schedule/?typekk=NOW'; 
                }
            });
          </script>";
		} else {
			// Query untuk menyimpan data ke tbl_schedule_new
			$simpanSql = "INSERT INTO db_finishing.tbl_schedule_new (
            nokk,
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
            [status],
            creationdatetime,
            ipaddress,
            prosesbc
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";

			// Mengambil data tambahan dari tbl_masuk
			$sql_kkmasuk = "SELECT * FROM db_finishing.tbl_masuk WHERE nokk = ? ORDER BY id DESC";
			$stmt_kkmasuk = sqlsrv_query($con, $sql_kkmasuk, array($_POST['nokk']));
			$row_kkmasuk = sqlsrv_fetch_array($stmt_kkmasuk, SQLSRV_FETCH_ASSOC);

			$params_simpan = array(
				$_POST['nokk'],
				$_POST['demand'],
				$_POST['no_urut'],
				$row_kkmasuk['langganan'] ?? null,
				$row_kkmasuk['buyer'] ?? null,
				$_POST['no_order'],
				$jenis_kain,
				(string) $_POST['tgl_delivery'],
				$_POST['lebar'],
				$_POST['gramasi'],
				$_POST['warna'],
				$_POST['personil'],
				$_POST['no_warna'],
				$_POST['qty'],
				$_POST['qty2'],
				$_POST['lot'],
				$_POST['rol'],
				$_POST['no_mesin'],
				$_POST['nama_mesin'],
				$_POST['proses'],
				$_POST['operation'],
				$_POST['g_shift'],
				$_POST['catatan'],
				'SCHEDULE',
				$creationdatetime,
				$_SERVER['REMOTE_ADDR'],
				$_POST['prosesbc']
			);

			$stmt_simpan = sqlsrv_query($con, $simpanSql, $params_simpan);

			if ($stmt_simpan === false) {
				die('b' . print_r(sqlsrv_errors(), true));
			}

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
							<option value="KKLama" <?php if ($_GET['typekk'] == "KKLama")
									echo "SELECTED"; ?>>KK Lama
							</option>
							<option value="NOW" <?php if ($_GET['typekk'] == "NOW")
									echo "SELECTED"; ?>>KK NOW</option>
						</select>
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
							onchange="window.location='?typekk='+document.getElementById('typekk').value+'&idkk='+this.value"
							value="<?php echo htmlspecialchars($_GET['idkk']); ?>" />
						<input type="hidden" value="<?php echo htmlspecialchars($rw['id']); ?>" name="id" />

						<?php if ($_GET['typekk'] == 'NOW') { ?>
						<select style="width: 40%" name="demand" id="demand"
							onchange="window.location='?typekk='+document.getElementById('typekk').value+'&idkk='+document.getElementById('nokk').value+'&demand='+this.value+'&operation=<?= htmlspecialchars($row_kkmasuk['operation']); ?>'"
							required>
							<option value="" disabled selected>Pilih Nomor Demand</option>
							<?php
									$sql_ITXVIEWKK_demand = "SELECT * FROM db_finishing.tbl_masuk WHERE nokk = ?";
									$params_demand = array($_GET['idkk']);
									$stmt_ITXVIEWKK_demand = sqlsrv_query($con, $sql_ITXVIEWKK_demand, $params_demand);

									if ($stmt_ITXVIEWKK_demand === false) {
										die(print_r(sqlsrv_errors(), true));
									}

									while ($r_demand = sqlsrv_fetch_array($stmt_ITXVIEWKK_demand, SQLSRV_FETCH_ASSOC)):
										?>
							<?php
										// CEK, JIKA KARTU KERJA SUDAH DIBIKIN SCHEDULE MAKA TIDAK AKAN MUNCUL DI KK MASUK
										$cek_schedule_sql = "SELECT COUNT(*) AS jml FROM db_finishing.tbl_schedule_new WHERE nokk = ? AND nodemand = ? AND operation = ?";
										$params_schedule = array($r_demand['nokk'], $r_demand['nodemand'], $r_demand['operation']);
										$stmt_cek_schedule = sqlsrv_query($con, $cek_schedule_sql, $params_schedule);

										if ($stmt_cek_schedule === false) {
											die(print_r(sqlsrv_errors(), true));
										}

										$data_schedule = sqlsrv_fetch_array($stmt_cek_schedule, SQLSRV_FETCH_ASSOC);
										?>
							<?php if (empty($data_schedule['jml'])): ?>
							<option value="<?= htmlspecialchars($r_demand['nodemand']); ?>" <?php if ($r_demand['nodemand'] == $_GET['demand']) {
												  echo 'SELECTED';
											  } ?>>
								<?= htmlspecialchars($r_demand['nodemand']); ?>
							</option>
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
					<?php
						// Periksa apakah $row_kkmasuk['tgl_delivery'] kosong
						if (empty($row_kkmasuk['tgl_delivery'])) {
							// Jika kosong, atur $tanggal menjadi string kosong
							$tanggal = '';
						} else {
							// Periksa apakah $row_kkmasuk['tgl_delivery'] adalah objek DateTime
							if ($row_kkmasuk['tgl_delivery'] instanceof DateTime) {
								// Format objek DateTime ke 'Y-m-d'
								$tanggal = $row_kkmasuk['tgl_delivery']->format('Y-m-d');
							} else {
								// Jika bukan objek DateTime, anggaplah itu adalah string dan konversikan
								$tanggal = date('Y-m-d', strtotime($row_kkmasuk['tgl_delivery']));
							}
						}
						?>


					<td>
						<input name="tgl_delivery" type="date" size="35" value="<?= htmlspecialchars($tanggal); ?>"
							required />
					</td>

					<td>
						<h4>Proses</h4>
					</td>
					<td>:</td>
					<td colspan="2">
						<select name="proses" id="proses" required>
							<option value="">Pilih</option>
							<?php
								// Query SQL Server
								$sql_proses = "SELECT proses, jns, ket FROM db_finishing.tbl_proses ORDER BY ket, id ASC";
								$stmt_proses = sqlsrv_query($con, $sql_proses);

								if ($stmt_proses === false) {
									die(print_r(sqlsrv_errors(), true));
								}

								while ($r = sqlsrv_fetch_array($stmt_proses, SQLSRV_FETCH_ASSOC)) {
									$proses_value = $r['proses'] . " (" . $r['jns'] . ")";
									$selected = ($row_kkmasuk['proses'] == $proses_value) ? "SELECTED" : "";
									?>
							<option value="<?= htmlspecialchars($proses_value); ?>" <?= $selected; ?>>
								<?= htmlspecialchars($r['ket']) ?> - <?= htmlspecialchars($proses_value); ?>
							</option>
							<?php
								}
								?>
						</select>
					</td>
				</tr>
				<tr>
					<td scope="row">
						<h4>Lebar x Gramasi</h4>
					</td>
					<td>:</td>
					<td>
						<input name="lebar" type="text" id="lebar" size="6"
							value="<?= htmlspecialchars($row_kkmasuk['lebar']); ?>" placeholder="0" />
						<input name="gramasi" type="text" id="gramasi" size="6"
							value="<?= htmlspecialchars($row_kkmasuk['gramasi']); ?>" placeholder="0" />
					</td>

					<td>
						<h4>Operation</h4>
					</td>
					<td>:</td>
					<td>
						<select name="operation" id="operation"
							onchange="window.location='?typekk=' + document.getElementById('typekk').value + '&idkk=' + document.getElementById('nokk').value + '&demand=' + document.getElementById('demand').value + '&shift=<?= htmlspecialchars($_GET['shift']); ?>&shift2=<?= htmlspecialchars($_GET['shift2']); ?>&operation=' + this.value"
							required>
							<option value="">Pilih</option>
							<?php
								// Query SQL Server
								$sql_masuk = "SELECT operation FROM db_finishing.tbl_masuk WHERE nokk = ? AND nodemand = ? ORDER BY id ASC";
								$params_masuk = array($_GET['idkk'], $_GET['demand']);
								$stmt_masuk = sqlsrv_query($con, $sql_masuk, $params_masuk);

								if ($stmt_masuk === false) {
									die(print_r(sqlsrv_errors(), true));
								}

								while ($r = sqlsrv_fetch_array($stmt_masuk, SQLSRV_FETCH_ASSOC)) {
									$selected = ($_GET['operation'] == $r['operation']) ? "SELECTED" : "";
									?>
							<option value="<?= htmlspecialchars($r['operation']); ?>" <?= $selected; ?>>
								<?= htmlspecialchars($r['operation']); ?>
							</option>
							<?php
								}
								?>
						</select>

						<strong style="color: red;">No Urut :</strong>
						<select name="no_urut" class="form-control select2" id="no_urut">
							<option value="">Pilih</option>
							<?php
								// Query untuk mendapatkan daftar no_urut yang sudah ada
								$sql_nourut = "SELECT STRING_AGG(CONVERT(varchar, nourut), ',') AS nourut
                               FROM db_finishing.tbl_schedule_new 
                               WHERE nokk = ? 
                               AND nodemand = ?";
								$params_nourut = array($row_kkmasuk['nokk'], $row_kkmasuk['nodemand']);
								$stmt_nourut = sqlsrv_query($con, $sql_nourut, $params_nourut);

								if ($stmt_nourut === false) {
									die(print_r(sqlsrv_errors(), true));
								}

								$data_nourut = sqlsrv_fetch_array($stmt_nourut, SQLSRV_FETCH_ASSOC);

								// Jika ada no_urut yang ditemukan, query untuk mendapatkan no_urut yang belum terpakai
								if ($data_nourut['nourut']) {
									$nourut_list = explode(',', $data_nourut['nourut']);
									$placeholders = implode(',', array_fill(0, count($nourut_list), '?'));
									$sqlKap = "SELECT no_urut 
                               FROM db_finishing.tbl_urut 
                               WHERE no_urut NOT IN ($placeholders) 
                               ORDER BY no_urut ASC";
									$paramsKap = $nourut_list;
								} else {
									// Jika tidak ada no_urut yang ditemukan, ambil semua no_urut
									$sqlKap = "SELECT no_urut 
                               FROM db_finishing.tbl_urut 
                               ORDER BY no_urut ASC";
									$paramsKap = array();
								}

								$stmtKap = sqlsrv_query($con, $sqlKap, $paramsKap);

								if ($stmtKap === false) {
									die(print_r(sqlsrv_errors(), true));
								}

								// Mengambil hasil query dan menampilkan option
								while ($rK = sqlsrv_fetch_array($stmtKap, SQLSRV_FETCH_ASSOC)) {
									?>
							<option value="<?= htmlspecialchars($rK['no_urut']); ?>">
								<?= htmlspecialchars($rK['no_urut']); ?>
							</option>
							<?php
								}
								?>
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
						<input type="text" name="personil" value="<?= htmlspecialchars($_SESSION['usr']); ?>" required
							readonly style="background-color: #BBBBBB;" />
					</td>
					<td valign="top">
						<h4>Catatan</h4>
					</td>
					<td valign="top">:</td>
					<td colspan="2" valign="top">
						<textarea name="catatan" cols="35"
							id="catatan"><?= htmlspecialchars($row_kkmasuk['catatan']); ?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="7">
						<input name="prosesbc" type="hidden" id="warna"
							value="<?= htmlspecialchars($row_kkmasuk['prosesbc']); ?>" />
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset>
			<legend>KETENTUAN INPUT SCHEDULE</legend>
			<ul>
				<li>Jika <b>tidak</b> terdapat kesamaan antara <b>nomor kartu kerja, nomor demand, dan operation</b> di
					KK
					MASUK, maka data tersebut tidak dapat ditampilkan ke dalam sistem.</li>
				<li>Jika terdapat kesamaan antara <b>nomor kartu kerja, nomor demand, dan operation</b> <span
						style="color: red;">sudah di susun schedule</span>, maka data tersebut tidak dapat ditampilkan
					ke
					dalam sistem.</li>
				<li>Jika terdapat kesamaan antara <b>nomor kartu kerja, nomor demand, dan operation</b> <span
						style="color: red;">sudah di proses</span>, maka data tersebut tidak dapat ditampilkan ke dalam
					sistem.</li>
			</ul>
		</fieldset>
		<br><br>
		<input type="submit" name="btnSimpan" id="btnSimpan" value="Simpan" class="art-button" />
		<input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='../index.php'"
			class="art-button" />
		<input type="button" name="LihatData" value="Lihat Data" onclick="window.location.href='index.php?p=LihatData'"
			class="art-button" />
		<?php endif; ?>
	</form>
</body>

</html>