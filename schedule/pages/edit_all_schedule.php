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
</head>

<body>
	<?php
	// Aktifkan laporan error untuk debugging
	ini_set("error_reporting",1 );
	session_start();
	include('../koneksi.php'); // Pastikan koneksi.php sudah benar
	
	function nourut()
	{
		global $con; // Mengakses variabel $con dari luar fungsi
	
		$format = date("ymd");
		// Menyiapkan query dengan parameter untuk mencegah SQL injection
		$sql = "SELECT TOP 1 nokk 
            FROM db_finishing.tbl_produksi 
            WHERE LEFT(nokk, 6) LIKE '%' +  + '%' 
            ORDER BY nokk DESC";

		// Eksekusi query dengan parameter
		$stmt = sqlsrv_query($con, $sql, array($format));

		if ($stmt === false) {
			die(print_r(sqlsrv_errors(), true));
		}

		// Ambil hasil query
		$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

		if ($row) {
			$d = $row['nokk'];
			$str = substr($d, 6, 2);
			$Urut = (int) $str;
		} else {
			$Urut = 0;
		}

		// Increment Urut
		$Urut = $Urut + 1;

		// Format angka dengan nol di depan
		$Nol = str_repeat("0", 2 - strlen($Urut));

		// Buat nomor dengan format yang diinginkan
		$nipbr = $format . $Nol . $Urut;
		return $nipbr;
	}

	$nou = nourut();

	// Periksa apakah `kk` ada di request dan ambil nilai idkk jika tidak ada
	$idkk = isset($_REQUEST['kk']) && $_REQUEST['kk'] != '' ? "" : (isset($_GET['idkk']) ? $_GET['idkk'] : "");

	// Tindakan berdasarkan nilai `typekk`
	if (isset($_GET['typekk'])) {
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
			$q_kkmasuk = sqlsrv_query($con, "SELECT * FROM db_finishing.tbl_schedule_new WHERE id = ?", array($_GET['id']));

			if ($q_kkmasuk === false) {
				die(print_r(sqlsrv_errors(), true));
			}

			$row_kkmasuk = sqlsrv_fetch_array($q_kkmasuk, SQLSRV_FETCH_ASSOC);

			if (empty($row_kkmasuk)) {
				echo "<script>
                    swal({
                        title: 'Kartu Kerja belum di input di KK MASUK',   
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
		$lastupdatedatetime = date('Y-m-d H:i:s');

		// Siapkan SQL dengan parameter placeholder
		$simpanSql = "UPDATE db_finishing.tbl_schedule_new 
                  SET no_mesin = ?, 
                      nourut = ?, 
                      group_shift = ?, 
                      catatan = ?, 
                      proses = ?, 
                      operation = ?, 
                      lastupdatedatetime = ?, 
                      lastupdatedateuser = ?
                  WHERE id = ?";

		// Buat array parameter
		$params = array(
			$_POST['no_mesin'],
			$_POST['no_urut'],
			$_POST['g_shift'],
			$_POST['catatan'],
			$_POST['proses'],
			$_POST['operation'],
			$lastupdatedatetime,
			$_SESSION['usr'],
			$_GET['id']
		);

		// Eksekusi query
		$stmt = sqlsrv_query($con, $simpanSql, $params);

		if ($stmt === false) {
			die(print_r(sqlsrv_errors(), true));
		}

		// Jika berhasil, tampilkan notifikasi dan arahkan pengguna
		echo "<script>
            swal({
                title: 'Data Terupdate',   
                text: 'Klik Ok untuk input data kembali',
                type: 'success',
            }).then((result) => {
                if (result.value) {
                    window.location.href = 'http://online.indotaichen.com/finishing2-new/schedule/index.php?p=LihatData'; 
                }
            });
          </script>";
	}elseif (isset($_POST['btnKembali'])){
        sqlsrv_query($con, "DELETE FROM db_finishing.active_lock WHERE id_schedule = '$_GET[id]'") or die("Gagal hapus" . sqlsrv_errors());

		echo "<script>window.location.href = 'http://online.indotaichen.com/finishing2-new/schedule/index.php?p=LihatData';</script>";
	}
	?>

	<!-- ACTIVE LOCK -->
	<?php
		if (!isset($_POST['btnKembali'])){ 
			if($_GET['activelock'] == 'true'){
				$check_activeLock = sqlsrv_query($con, "SELECT * FROM db_finishing.active_lock WHERE id_schedule = '$_GET[id]'");
				$dataMain_activeLock = sqlsrv_fetch_array($check_activeLock, SQLSRV_FETCH_ASSOC);

				if(empty($dataMain_activeLock)){
					$insertMain_activeLock = "INSERT INTO db_finishing.active_lock (nokk,
																					nodemand,
																					operation,
																					nama_mesin,
																					user_lock,
																					ipaddress,
																					creationdatetime,
																					id_schedule)
																	VALUES ('$row_kkmasuk[nokk]',
																	'$row_kkmasuk[nodemand]',
																	'$row_kkmasuk[operation]',
																	'$row_kkmasuk[nama_mesin]',
																	'$_SESSION[usr]',
																	'$_SERVER[REMOTE_ADDR]',
																	GETDATE(),
																	'$_GET[id]')";
					$exec_activeLock = sqlsrv_query($con, $insertMain_activeLock)  or die("Gagal insert active lock" . sqlsrv_errors());
				}
			}
		}
	?>

	<form id="form1" name="form1" method="post" action="">
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
							onchange="window.location='?typekk='+this.value" required disabled
							style="background-color: #BBBBBB;">
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
							value="<?= $row_kkmasuk['no_warna']; ?>" disabled style="background-color: #BBBBBB;">
					</td>
				</tr>
				<tr>
					<td width="13%" scope="row">
						<h4>Nokk</h4>
					</td>
					<td width="1%">:</td>
					<td width="26%">
						<input name="nokk" type="text" size="17" value="<?= $row_kkmasuk['nokk']; ?>" disabled
							style="background-color: #BBBBBB;">

						<input name="demand" value="<?= $row_kkmasuk['nodemand']; ?>" type="text" disabled
							style="background-color: #BBBBBB;">
					</td>


					<td width="14%"><strong>Quantity (Kg)</strong></td>
					<td width="1%">:</td>
					<td colspan="">
						<input name="qty" type="text" id="qty" size="5" value="<?= $row_kkmasuk['qty_order']; ?>"
							placeholder="0.00" disabled style="background-color: #BBBBBB;">

						<strong>Panjang (Yard)</strong>

						<input name="qty2" type="text" id="qty2" size="8" value="<?= $row_kkmasuk['qty_order_yd']; ?>"
							placeholder="0.00" onfocus="jumlah();" disabled style="background-color: #BBBBBB;">
					</td>
				</tr>
				<tr>
					<td scope="row">
						<h4>Langganan/Buyer</h4>
					</td>
					<td>:</td>
					<td>
						<input name="buyer" type="text" id="buyer" size="45"
							value="<?= $row_kkmasuk['langganan']; ?>/<?= $row_kkmasuk['buyer']; ?>" disabled
							style="background-color: #BBBBBB;">
					</td>
					<td scope="row">
						<h4>Lot</h4>
					</td>
					<td>:</td>
					<td><input name="lot" type="text" id="lot" size="5" value="<?= $row_kkmasuk['lot']; ?>" disabled
							style="background-color: #BBBBBB;"></td>
				</tr>
				<tr>
					<td scope="row">
						<h4>No. Order</h4>
					</td>
					<td>:</td>
					<td>
						<input type="text" name="no_order" id="no_order" value="<?= $row_kkmasuk['no_order']; ?>"
							disabled style="background-color: #BBBBBB;">
					</td>

					<td scope="row">
						<h4>Roll</h4>
					</td>
					<td>:</td>
					<td><input name="rol" type="text" id="rol" size="3" placeholder="0" pattern="[0-9]{1,}"
							value="<?= $row_kkmasuk['roll']; ?>" disabled style="background-color: #BBBBBB;"></td>
				</tr>
				<tr>
					<td valign="top" scope="row">
						<h4>Jenis Kain</h4>
					</td>
					<td valign="top">:</td>
					<td>
						<textarea name="jenis_kain" cols="35" id="jenis_kain" disabled
							style="background-color: #BBBBBB;"><?= $row_kkmasuk['jenis_kain']; ?></textarea>
					</td>

					<td style="color: red;"><strong>Nomor Mesin</strong></td>
					<td>:</td>
					<td>
						<select name="no_mesin">
							<option value="">Pilih</option>
							<?php
							$query_namamesin = "SELECT
															DISTINCT 
															TRIM(p.WORKCENTERCODE) AS WORKCENTERCODE,
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
															AND w.OPERATIONCODE = '$row_kkmasuk[operation]'";
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
								<option value="<?= $row_nomormesin['CODE']; ?>" <?php if ($row_nomormesin['CODE'] == $row_kkmasuk['no_mesin']) {
									  echo "SELECTED";
								  } ?>><?= $row_nomormesin['CODE']; ?> - <?= $row_nomormesin['LONGDESCRIPTION']; ?></option>
							<?php } ?>
						</select>

						<strong>Nama Mesin : </strong>
						<select name="nama_mesin" required="required" disabled style="background-color: #BBBBBB;">
							<option value="">Pilih</option>
							<?php
							while ($row_namamesin = db2_fetch_assoc($q_namamesin)) {
								?>
								<option value="<?php echo $row_namamesin['WORKCENTERCODE']; ?>" SELECTED>
									<?php echo $row_namamesin['WORKCENTERCODE']; ?> -
									<?php echo $row_namamesin['LONGDESCRIPTION']; ?></option>
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
					// Periksa apakah $row_schedule['tgl_delivery'] adalah objek DateTime
					if ($row_kkmasuk['tgl_delivery'] instanceof DateTime) {
						// Format objek DateTime ke 'Y-m-d'
						$tgl_delivery = $row_kkmasuk['tgl_delivery']->format('Y-m-d');
					} else {
						// Jika tidak, atur $tgl_delivery menjadi string kosong
						$tgl_delivery = ''; // Atau gunakan nilai default sesuai kebutuhan
					}
					?>
					<td>
						<input name="tgl_delivery" type="date" size="35" value="<?= $tgl_delivery; ?>" disabled
							style="background-color: #BBBBBB;">
					</td>

					<td>
						<h4 style="color: red;">Proses</h4>
					</td>
					<td>:</td>
					<td colspan="2">
						<select name="proses" id="proses" required>
							<option value="">Pilih</option>
							<?php
							$qry1 = sqlsrv_query($con, "SELECT proses, jns FROM db_finishing.tbl_proses ORDER BY id ASC");

							if ($qry1 === false) {
								die(print_r(sqlsrv_errors(), true));
							}
							while ($r = sqlsrv_fetch_array($qry1, SQLSRV_FETCH_ASSOC)) {
								$proses_value = htmlspecialchars($r['proses'] . " (" . $r['jns'] . ")");
								$selected = ($row_kkmasuk['proses'] === $proses_value) ? "selected" : "";
								?>
								<option value="<?= $proses_value; ?>" <?= $selected; ?>>
									<?= $proses_value; ?>
								</option>
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
							placeholder="0" disabled style="background-color: #BBBBBB;">
						<input name="gramasi" type="text" id="gramasi" size="6" value="<?= $row_kkmasuk['gramasi']; ?>"
							placeholder="0" disabled style="background-color: #BBBBBB;">
					</td>

					<td>
						<h4 style="color: red;">Operation</h4>
					</td>
					<td>:</td>
					<td>
						<select name="operation" id="operation" required>
							<option value="">Pilih</option>
							<?php
							$qry1 = db2_exec($conn_db2, "SELECT
                                                                DISTINCT 
                                                                p.STEPNUMBER,
                                                            --	p.GROUPSTEPNUMBER,
                                                                TRIM(o.OPERATIONGROUPCODE) AS DEPT,
                                                                CASE
                                                                    WHEN TRIM(w.PRODRESERVATIONLINKGROUPCODE) IS NOT NULL THEN TRIM(w.PRODRESERVATIONLINKGROUPCODE)
                                                                    ELSE TRIM(w.OPERATIONCODE)
                                                                END AS OPERATIONCODE,	
                                                                p.LONGDESCRIPTION
                                                            FROM
                                                                WORKCENTERANDOPERATTRIBUTES w
                                                            LEFT JOIN OPERATION o ON o.CODE = w.OPERATIONCODE 
                                                            LEFT JOIN PRODUCTIONDEMANDSTEP p ON p.OPERATIONCODE = o.CODE 
                                                            WHERE
                                                                NOT w.LONGDESCRIPTION = 'JANGAN DIPAKE'
                                                                AND TRIM(o.OPERATIONGROUPCODE) = 'FIN'
                                                                AND p.PRODUCTIONORDERCODE  = '$row_kkmasuk[nokk]' 
                                                                AND p.PRODUCTIONDEMANDCODE = '$row_kkmasuk[nodemand]'
                                                            ORDER BY 
                                                                p.STEPNUMBER ASC");
							while ($r = db2_fetch_assoc($qry1)) {
								?>
								<option value="<?php echo $r['OPERATIONCODE']; ?>" <?php if ($row_kkmasuk['operation'] == $r['OPERATIONCODE']) {
									   echo "SELECTED";
								   } ?>><?php echo $r['OPERATIONCODE']; ?> 	<?php echo $r['LONGDESCRIPTION']; ?></option>
							<?php } ?>
						</select>

						<strong style="color: red;">No Urut :</strong>
						<select name="no_urut" class="form-control select2" id="no_urut">
							<option value="">Pilih</option>
							<?php
							$sqlKap = sqlsrv_query($con, "SELECT no_urut FROM db_finishing.tbl_urut ORDER BY no_urut ASC");
							while ($rK = sqlsrv_fetch_array($sqlKap)) {
								?>
								<option value="<?php echo $rK['no_urut']; ?>" <?php if ($rK['no_urut'] == $row_kkmasuk['nourut']) {
									   echo "SELECTED";
								   } ?>><?php echo $rK['no_urut']; ?></option>
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
						<input name="warna" type="text" id="warna" size="35" value="<?= $row_kkmasuk['warna']; ?>"
							disabled style="background-color: #BBBBBB;">
					</td>

					<td scope="row" style="color: red;">
						<h4>Group Shift</h4>
					</td>
					<td>:</td>
					<td>
						<select name="g_shift" class="form-control select2">
							<option value="">Pilih</option>
							<option value="A" <?php if ("A" == $row_kkmasuk['group_shift']) {
								echo "SELECTED";
							} ?>>A</option>
							<option value="B" <?php if ("B" == $row_kkmasuk['group_shift']) {
								echo "SELECTED";
							} ?>>B</option>
							<option value="C" <?php if ("C" == $row_kkmasuk['group_shift']) {
								echo "SELECTED";
							} ?>>C</option>
						</select>
					</td>
				</tr>
				<tr>
					<td scope="row">
						<h4>Personil</h4>
					</td>
					<td>:</td>
					<td>
						<input type="text" name="personil" value="<?= $_SESSION['usr']; ?>" required disabled
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
			</table>
		</fieldset>
		<br>
		<input type="submit" name="btnSimpan" id="btnSimpan" value="Ubah" class="art-button" />
		<input type="submit" name="btnKembali" id="btnKembali" value="Kembali" class="art-button" />
	</form>
</body>

</html>