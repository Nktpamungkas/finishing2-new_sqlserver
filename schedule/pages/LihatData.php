<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include('../koneksi.php');
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>SCHEDULE FINISHING</title>
	<link rel="stylesheet" type="text/css" href="../css/datatable.css" />
	<link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" />
	<script src="../js/jquery.js" type="text/javascript"></script>
	<script src="../js/jquery.dataTables.js" type="text/javascript"></script>
	<script>
		$(document).ready(function () {
			$('#datatables').dataTable({
				"sScrollY": "500px",
				"sScrollX": "100%",
				"bScrollCollapse": false,
				"bPaginate": false,
				"bJQueryUI": true,
				"bSort": false
			});
		})

		$(document).ready(function () {
			$('#datatables_rangkuman').dataTable({
				"sScrollY": "100px",
				"sScrollX": "100%",
				"bScrollCollapse": false,
				"bPaginate": false,
				"bJQueryUI": true,
				"bSort": false
			});
		})
	</script>

	<style>
		.button {
			display: inline-block;
			padding: 5px 10px;
			background-color: #007bff;
			color: #fff;
			text-decoration: none;
			border-radius: 5px;
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
			background-color: rgba(0, 0, 0, 0.7);
		}

		.modal-content {
			background-color: #fff;
			margin: 10% auto;
			padding: 20px;
			border-radius: 8px;
			width: 30%;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
			animation: fadeIn 0.5s;
			font-size: 2rem;
			size: 20px;
		}

		.modal-header h2 {
			margin: 0;
			color: #333;
			font-size: 1.8rem; /* Ukuran judul lebih besar */
		}

		.modal-body p {
			font-size: 1.2rem; /* Ukuran teks lebih besar */
			color: #555;
			margin: 20px 0;
			line-height: 1.6; /* Spasi antar baris */
		}

		.modal-footer {
			text-align: right;
		}

		.modal-footer button {
			padding: 10px 20px;
			margin-left: 10px;
			border: none;
			border-radius: 5px;
			cursor: pointer;
		}

		#yesButton {
			background-color: #007BFF;
			color: white;
		}

		#yesButton:hover {
			background-color: #0056b3;
		}

		#noButton {
			background-color: #e0e0e0;
			color: black;
		}

		#noButton:hover {
			background-color: #c0c0c0;
		}

		@keyframes fadeIn {
			from {
				opacity: 0;
				transform: scale(0.9);
			}
			to {
				opacity: 1;
				transform: scale(1);
			}
		}

	</style>
</head>

<body>
	<form id="form1" name="form1" method="post" action="">
		<div style="display: flex; border: 0px solid black; height: 185px;">
			<div style="flex: 1;">
				<table width="650" border="0">
					<tr>
						<td colspan="3">
							<?php if (isset($_POST['kkbelumsusun'])): ?>
								<div align="center"><strong>SCHEDULE FINISHING BELUM TERSUSUN</strong></div>
							<?php else: ?>
								<div align="center"><strong>SCHEDULE FINISHING</strong></div>
							<?php endif; ?>
							<?php
							$user_name = $_SESSION['username'];
							date_default_timezone_set('Asia/Jakarta');
							$tgl = date("Y-M-d h:i:s A");
							echo $tgl;
							?>
							<br>
						</td>
					</tr>
					<tr>
						<td><strong>Nomor Mesin</strong></td>
						<td>:</td>
						<td>
							<select name="no_mesin" class="form-control select2">
								<option value="-" disabled selected>Pilih</option>
								<?php
								$q_mesin = sqlsrv_query($con, "SELECT *
                                                                    FROM (
                                                                        SELECT DISTINCT
                                                                            no_mesin,
                                                                            SUBSTRING(TRIM(no_mesin), LEN(TRIM(no_mesin)) - 4, 2) AS singaktan_mesin,
                                                                            SUBSTRING(TRIM(no_mesin), LEN(TRIM(no_mesin)) - 1, 2) AS nomesin
                                                                        FROM
                                                                            db_finishing.tbl_schedule_new
                                                                    ) AS subquery
                                                                    ORDER BY
                                                                        singaktan_mesin ASC,
                                                                        nomesin ASC");
								?>
								<?php while ($row_mesin = sqlsrv_fetch_array($q_mesin, SQLSRV_FETCH_ASSOC)): ?>
									<option value="<?= $row_mesin['no_mesin']; ?>" <?php if ($row_mesin['no_mesin'] == $_POST['no_mesin']) {
										  echo 'SELECTED';
									  } ?>>
										<?= $row_mesin['singaktan_mesin']; ?>	<?= $row_mesin['nomesin']; ?>
									</option>
								<?php endwhile; ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><strong>Nama Mesin</strong></td>
						<td>:</td>
						<td>
							<select name="nama_mesin" class="form-control select2">
								<option value="-" disabled selected>Pilih</option>
								<?php
								$q_mesin = sqlsrv_query(
									$con,
									"WITH cte AS (
                                                SELECT DISTINCT
                                                    nama_mesin,
                                                    SUBSTRING(LTRIM(RTRIM(no_mesin)), LEN(LTRIM(RTRIM(no_mesin))) - 4, 2) AS singaktan_mesin,
                                                    SUBSTRING(LTRIM(RTRIM(no_mesin)), LEN(LTRIM(RTRIM(no_mesin))) - 1, 2) AS nomesin
                                                FROM
                                                    db_finishing.tbl_schedule_new
                                            ),
                                            ranked AS (
                                                SELECT
                                                    nama_mesin,
                                                    singaktan_mesin,
                                                    nomesin,
                                                    ROW_NUMBER() OVER (PARTITION BY nama_mesin ORDER BY CONCAT(singaktan_mesin, nomesin)) AS rn
                                                FROM
                                                    cte
                                            )
                                            SELECT
                                                nama_mesin,
                                                singaktan_mesin,
                                                nomesin
                                            FROM
                                                ranked
                                            WHERE
                                                rn = 1
                                            ORDER BY
                                                CONCAT(singaktan_mesin, nomesin) ASC;

                                            "
											);
								?>
								<?php while ($row_mesin = sqlsrv_fetch_array($q_mesin, SQLSRV_FETCH_ASSOC)): ?>
									<option value="<?= $row_mesin['nama_mesin']; ?>" <?php if ($row_mesin['nama_mesin'] == $_POST['nama_mesin']) {
										  echo 'SELECTED';
									  } ?>>
										<?= $row_mesin['nama_mesin']; ?>
									</option>
								<?php endwhile; ?>
							</select>
						</td>
					</tr>
					<tr valign="middle">
						<td width="127"><strong>Tanggal Awal</strong></td>
						<td width="3">:</td>
						<td width="280"><input name="awal" type="text" id="awal" value="<?= $_POST['awal'] ?>"
								onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.awal);return false;"
								size="14" /><a href="javascript:void(0)"
								onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.awal);return false;"><img
									src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25"
									id="popcal" style="border:none" align="absmiddle" border="0" /></a></td>
					</tr>
					<tr>
						<td><strong>Tanggal Akhir</strong></td>
						<td>:</td>
						<td width="280"><input name="akhir" type="text" id="akhir" value="<?= $_POST['akhir'] ?>"
								onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.akhir);return false;"
								size="14" /><a href="javascript:void(0)"
								onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.akhir);return false;"><img
									src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25"
									id="popcal" style="border:none" align="absmiddle" border="0" /></a></td>
					</tr>
					<tr>
						<td colspan="3">
							<input type="submit" name="button" id="button" value="Cari data" class="art-button" />
							<input type="button" name="batal" value="Reset" onclick="window.location.href='index.php?p=LihatData'" class="art-button">
							<input type="button" name="batal" value="View Report" onclick="window.location.href='index.php?p=Reports'" class="art-button">

							<?php if (!isset($_POST['kkbelumsusun'])): ?>
								<input type="submit" name="kkbelumsusun" value="KK belum tersusun" class="art-button" />
								<a href="pages/cetak_schedule_p1.php?cetak=lihatData&nourut=<?=$urut?>&no_mesin=<?=$_POST['no_mesin']?>&nama_mesin=<?=$_POST['nama_mesin']?>&awal=<?=$_POST['awal']?>&akhir=<?=$_POST['akhir']?>&nourut=without0" target="_blank" class="art-button">Cetak</a>
							<?php endif; ?>

							<?php if (isset($_POST['kkbelumsusun'])): ?>
								<input type="button" name="button2" id="button2" value="Kembali"
									onclick="window.location.href='../schedule/index.php?p=LihatData'" class="art-button" />
								<a href="pages/cetak_schedule_p1.php?cetak=lihatData&nourut=<?=$urut?>&no_mesin=<?=$_POST['no_mesin']?>&nama_mesin=<?=$_POST['nama_mesin']?>&awal=<?=$_POST['awal']?>&akhir=<?=$_POST['akhir']?>&nourut=with0" target="_blank" class="art-button">Cetak</a>
							<?php endif; ?>

							<?php
							if(isset($_POST['button'])) {
								$urut = "without0";
							}
							
							if(isset($_POST['kkbelumsusun'])) {
								$urut = "";
							}
							?>

						</td>
					</tr>
				</table>
			</div>
			<div style="flex: 1;">
				<table width="100%" border="1" id="datatables_rangkuman" class="display">
					<thead>
						<tr>
							<th style="border:1px solid;vertical-align:middle; text-align: center; font-weight: bold;">
								No Mesin</th>
							<th style="border:1px solid;vertical-align:middle; text-align: center; font-weight: bold;">
								Jumlah KK</th>
							<th style="border:1px solid;vertical-align:middle; text-align: center; font-weight: bold;">
								Bruto</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (isset($_POST['kkbelumsusun'])) {
							$nourut = "AND a.nourut = 0";
						} else {
							$nourut = "AND NOT a.nourut = 0";
						}

						$q_rangkuman = sqlsrv_query($con, "WITH AggregatedData AS (
                                                                SELECT
                                                                    CONCAT(
                                                                        SUBSTRING(LTRIM(RTRIM(a.no_mesin)), LEN(LTRIM(RTRIM(a.no_mesin))) - 5 + 1, 2),
                                                                        SUBSTRING(LTRIM(RTRIM(a.no_mesin)), LEN(LTRIM(RTRIM(a.no_mesin))) - 2 + 1, 2)
                                                                    ) AS nomesin,
                                                                    a.nourut,
                                                                    COUNT(a.nokk) AS jml_kk,
                                                                    SUM(a.qty_order) AS bruto
                                                                FROM
                                                                    db_finishing.tbl_schedule_new a
                                                                WHERE
                                                                    NOT EXISTS (
                                                                        SELECT
                                                                            1
                                                                        FROM
                                                                            db_finishing.tbl_produksi b
                                                                        WHERE
                                                                            b.nokk = a.nokk
                                                                            AND b.demandno = a.nodemand
                                                                            AND b.nama_mesin = a.operation
                                                                            AND b.no_mesin = a.no_mesin
                                                                    )
                                                                    $nourut AND a.group_shift IS NOT NULL
                                                                    -- Replace with actual condition if $nourut is a specific value, e.g. a.nourut = <value>
                                                                    -- AND a.nourut = <value>
                                                                GROUP BY
                                                                    CONCAT(
                                                                        SUBSTRING(LTRIM(RTRIM(a.no_mesin)), LEN(LTRIM(RTRIM(a.no_mesin))) - 5 + 1, 2),
                                                                        SUBSTRING(LTRIM(RTRIM(a.no_mesin)), LEN(LTRIM(RTRIM(a.no_mesin))) - 2 + 1, 2)
                                                                    ),
                                                                    a.nourut
                                                            )
                                                            SELECT
                                                                nomesin,
                                                                SUM(jml_kk) AS total_jml_kk,
                                                                SUM(bruto) AS total_bruto
                                                            FROM
                                                                AggregatedData
                                                            GROUP BY
                                                                nomesin
                                                            ORDER BY
                                                                nomesin ASC;
                                                            ");
						$sum_totalkk = 0;
						$sum_totalQty = 0;
						?>
						<?php while ($row_rangkuman = sqlsrv_fetch_array($q_rangkuman, SQLSRV_FETCH_ASSOC)): ?>
							<?php $sum_totalkk += $row_rangkuman['total_jml_kk']; ?>
							<?php $sum_totalQty += $row_rangkuman['total_bruto']; ?>
							<tr>
								<td style="border:1px solid;vertical-align:middle; text-align: center;">
									<?= $row_rangkuman['nomesin']; ?>
								</td>
								<td style="border:1px solid;vertical-align:middle; text-align: center;">
									<?= $row_rangkuman['total_jml_kk']; ?>
								</td>
								<td style="border:1px solid;vertical-align:middle; text-align: center;">
									<?= number_format($row_rangkuman['total_bruto'], 2); ?>
								</td>
							</tr>
						<?php endwhile; ?>
					<tfoot>
						<td style="border:1px solid;vertical-align:middle; text-align: center; font-weight: bold;">TOTAL
						</td>
						<td style="border:1px solid;vertical-align:middle; text-align: center; font-weight: bold;">
							<?= $sum_totalkk; ?>
						</td>
						<td style="border:1px solid;vertical-align:middle; text-align: center; font-weight: bold;">
							<?= number_format($sum_totalQty, 2); ?>
						</td>
					</tfoot>
					</tbody>
				</table>
			</div> 
		</div>
	</form>
	<table width="100%" border="1" id="datatables" class="display">
		<thead>
			<tr>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">KETERANGAN</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">NO URUT</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">NO MESIN</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">PROSES</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">CATATAN</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">CREATION DATE TIME</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">LASTUPDATEDATETIME</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;" width="10%">OPSI</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">NAMA MESIN</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">OPERATION</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">GROUP SHIFT</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">NO KK</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">NO DEMAND</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">LANGGANAN</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">BUYER</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">NO ORDER</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">JENIS KAIN</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">NO HANGER</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">LEBAR X GRAMASI</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">NO WARNA</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">WARNA</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">LOT</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">ROL</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">QTY</th>
				<th style="border:1px solid;vertical-align:middle; font-weight: bold;">QTY YD</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if ($_POST['no_mesin']) {
				$where_no_mesin = "AND no_mesin = '$_POST[no_mesin]'";
			} else {
				$where_no_mesin = "";
			}

			if ($_POST['nama_mesin']) {
				$where_nama_mesin = "AND nama_mesin = '$_POST[nama_mesin]'";
			} else {
				$where_nama_mesin = "";
			}

			if ($_POST['awal']) {
				$awal = $_POST['awal'];
				$akhir = $_POST['akhir'];

				// Format tanggal ke format yang digunakan SQL Server, misalnya yyyy-mm-dd
				$where_tgl = "AND CONVERT(date, creationdatetime) BETWEEN '$awal' AND '$akhir'";
			} else {
				$where_tgl = "";
			}


			if (isset($_POST['kkbelumsusun'])) {
				$query_schedule = "SELECT
                                        * 
                                    FROM
                                        db_finishing.tbl_schedule_new a 
                                    WHERE
                                        status = 'SCHEDULE' 
                                    	$where_tgl $where_nama_mesin $where_no_mesin 
                                        AND nourut = 0 
                                        AND NOT EXISTS (
                                                        SELECT 1
                                                        FROM 
                                                                db_finishing.tbl_produksi b
                                                            WHERE
                                                                b.nokk = a.nokk
                                                                AND b.demandno = a.nodemand
                                                                AND b.no_mesin = a.no_mesin
                                                                AND b.nama_mesin = a.operation
                                        )
                                    ORDER BY
                                        CONCAT(SUBSTRING(LTRIM(RTRIM(no_mesin)), LEN(LTRIM(RTRIM(no_mesin))) - 5 + 1, 2),
										SUBSTRING(LTRIM(RTRIM(no_mesin)), LEN(LTRIM(RTRIM(no_mesin))) - 2 + 1, 2)) ASC, nourut ASC";
				$q_schedule = sqlsrv_query($con, $query_schedule);
			} elseif (isset($_POST['button'])) {
				$query_schedule = "SELECT
                                        * 
                                    FROM
                                        db_finishing.tbl_schedule_new a 
                                    WHERE
                                        status = 'SCHEDULE' 
                                    	$where_tgl $where_nama_mesin $where_no_mesin 
                                        AND NOT nourut = 0 
                                        AND NOT EXISTS (
                                                        SELECT 1
                                                        FROM 
                                                                db_finishing.tbl_produksi b
                                                            WHERE
                                                                b.nokk = a.nokk
                                                                AND b.demandno = a.nodemand
                                                                AND b.no_mesin = a.no_mesin
                                                                AND b.nama_mesin = a.operation
                                        )
                                    ORDER BY
                                        CONCAT(SUBSTRING(LTRIM(RTRIM(no_mesin)), LEN(LTRIM(RTRIM(no_mesin))) - 5 + 1, 2),
										SUBSTRING(LTRIM(RTRIM(no_mesin)), LEN(LTRIM(RTRIM(no_mesin))) - 2 + 1, 2)) ASC, nourut ASC";
				$q_schedule = sqlsrv_query($con, $query_schedule);
			} else {
				$query_schedule = "SELECT
                                        * 
                                    FROM
                                        db_finishing.tbl_schedule_new a 
                                    WHERE
                                        status = 'SCHEDULE' 
                                    	$where_tgl $where_nama_mesin $where_no_mesin 
                                        AND NOT nourut = 0 
                                        AND NOT EXISTS (
                                                        SELECT 1
                                                        FROM 
                                                                db_finishing.tbl_produksi b
                                                            WHERE
                                                                b.nokk = a.nokk
                                                                AND b.demandno = a.nodemand
                                                                AND b.no_mesin = a.no_mesin
                                                                AND b.nama_mesin = a.operation
                                        )
                                    ORDER BY
                                        CONCAT(SUBSTRING(LTRIM(RTRIM(no_mesin)), LEN(LTRIM(RTRIM(no_mesin))) - 5 + 1, 2),
										SUBSTRING(LTRIM(RTRIM(no_mesin)), LEN(LTRIM(RTRIM(no_mesin))) - 2 + 1, 2)) ASC, nourut ASC";
				$q_schedule = sqlsrv_query($con, $query_schedule);
			}
			$totalQty = 0;
			$totalRoll = 0;
			?>
			<?php while ($row_schedule = sqlsrv_fetch_array($q_schedule, SQLSRV_FETCH_ASSOC)): ?>
				<?php
				$q_cekposisikk = db2_exec($conn_db2, "SELECT
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
																ELSE LISTAGG(DISTINCT FLOOR(idqd.VALUEQUANTITY), ', ')
															END AS GEROBAK,
															iptip.MACHINECODE 
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
															p.PRODUCTIONORDERCODE  = '$row_schedule[nokk]' AND p.PRODUCTIONDEMANDCODE = '$row_schedule[nodemand]' AND TRIM(o.OPERATIONGROUPCODE) = 'FIN'
															AND CASE
																WHEN TRIM(p.PRODRESERVATIONLINKGROUPCODE) IS NULL OR TRIM(p.PRODRESERVATIONLINKGROUPCODE) = '' THEN TRIM(p.OPERATIONCODE)
																ELSE TRIM(p.PRODRESERVATIONLINKGROUPCODE)
															END = '$row_schedule[operation]'
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
															a.VALUEBOOLEAN,
															iptip.MACHINECODE
														ORDER BY p.STEPNUMBER ASC");
				$row_cekposisikk = db2_fetch_assoc($q_cekposisikk);

				$dataHanger	= db2_exec($conn_db2, "SELECT TRIM(SUBCODE02) AS SUBCODE02, TRIM(SUBCODE03) AS SUBCODE03 FROM PRODUCTIONDEMAND WHERE CODE = '$row_schedule[nodemand]'");
				$rowHanger	= db2_fetch_assoc($dataHanger);
				?>

				<tr <?php if ($row_cekposisikk['STATUS_OPERATION'] == 'Closed') { if(TRIM($row_cekposisikk['MACHINECODE']) != TRIM($row_schedule['no_mesin'])){ echo 'style="background-color: #F19CBB" class="blink"'; } } ?>>
					<td style="border:1px solid;vertical-align:middle; text-align: center;">
						<?= TRIM($row_cekposisikk['MACHINECODE']) . '<br>' . substr(TRIM($row_cekposisikk['MACHINECODE']), -5, 2) . substr(TRIM($row_cekposisikk['MACHINECODE']), -2); ?><br>
						<?= $row_cekposisikk['STATUS_OPERATION']; ?><br>
						<?= $row_cekposisikk['OP1']; ?> - <?= $row_cekposisikk['OP2']; ?><br>
						<?= $row_cekposisikk['MULAI']; ?> - <?= $row_cekposisikk['SELESAI']; ?>
					</td>
					<td style="border:1px solid;vertical-align:middle; text-align: center;"><?= $row_schedule['nourut']; ?></td>
					<td style="border:1px solid;vertical-align:middle; text-align: center;">
						<a href="?p=edit_schedule2&id=<?= $row_schedule['id']; ?>&typekk=NOW&activelock=true&no_mesin=<?= TRIM($row_schedule['no_mesin']) ?>&nourut=<?= $row_schedule['nourut']; ?>" target="_blank">
							<?= TRIM($row_schedule['no_mesin']) . '<br>' . substr(TRIM($row_schedule['no_mesin']), -5, 2) . substr(TRIM($row_schedule['no_mesin']), -2); ?>
						</a>
					</td>
					<td style="border:1px solid;vertical-align:middle;"><?= $row_schedule['proses'] ?></td>
					<td style="border:1px solid;vertical-align:middle; color:red;"><?= $row_schedule['catatan'] ?></td>
					<?php
					// Periksa apakah $row_schedule['creationdatetime'] kosong
					if (empty($row_schedule['creationdatetime'])) {
						// Jika kosong, atur $creationdatetime menjadi string kosong
						$creationdatetime = '';
					} else {
						// Periksa apakah $row_schedule['creationdatetime'] adalah objek DateTime
						if ($row_schedule['creationdatetime'] instanceof DateTime) {
							// Format objek DateTime ke 'Y-m-d H:i:s'
							$creationdatetime = $row_schedule['creationdatetime']->format('Y-m-d H:i:s');
						} else {
							// Jika bukan objek DateTime, anggaplah itu adalah string dan konversikan
							$creationdatetime = date('Y-m-d H:i:s', strtotime($row_schedule['creationdatetime']));
						}
					}
					?>

					<td style="border:1px solid;vertical-align:center;">
						<?= htmlspecialchars($row_schedule['personil'], ENT_QUOTES, 'UTF-8') ?><br><?= htmlspecialchars($creationdatetime, ENT_QUOTES, 'UTF-8') ?>
					</td>

					<?php
					// Periksa apakah $row_schedule['lastupdatedatetime'] kosong
					if (empty($row_schedule['lastupdatedatetime'])) {
						// Jika kosong, atur $lastupdatedatetime menjadi string kosong
						$lastupdatedatetime = '';
					} else {
						// Periksa apakah $row_schedule['lastupdatedatetime'] adalah objek DateTime
						if ($row_schedule['lastupdatedatetime'] instanceof DateTime) {
							// Format objek DateTime ke 'Y-m-d H:i:s'
							$lastupdatedatetime = $row_schedule['lastupdatedatetime']->format('Y-m-d H:i:s');
						} else {
							// Jika bukan objek DateTime, anggaplah itu adalah string dan konversikan
							$lastupdatedatetime = date('Y-m-d H:i:s', strtotime($row_schedule['lastupdatedatetime']));
						}
					}
					?>

					<td style="border:1px solid;vertical-align:center;">
						<?= htmlspecialchars($row_schedule['lastupdatedateuser'], ENT_QUOTES, 'UTF-8') ?><br><?= htmlspecialchars($lastupdatedatetime, ENT_QUOTES, 'UTF-8') ?>
					</td>

					<td style="border:1px solid;vertical-align:middle;">
						<?php if ($_SESSION['usr'] != 'husni'): ?>
							<a href="?p=edit_schedule&id=<?= $row_schedule['id']; ?>&typekk=NOW&activelock=true" class="button" target="_blank">Edit</a>
							<button class="button" style="background-color: #ff004c; color: #ffffff;" onclick="showConfirmation(<?= $row_schedule['id'] ?>);">Hapus</button>
						<?php endif; ?>
					</td>
					<td style="border:1px solid;vertical-align:middle; text-align: center;">
						<?= $row_schedule['nama_mesin'] ?>
					</td>
					<td style="border:1px solid;vertical-align:middle; text-align: center;">
						<?= $row_schedule['operation'] ?>
					</td>
					<td style="border:1px solid;vertical-align:middle; text-align: center;">
						<?= $row_schedule['group_shift']; ?>
					</td>
					<td style="border:1px solid;vertical-align:middle;"><a title="MEMO PENTING" target="_BLANK"
							href="http://online.indotaichen.com/laporan/ppc_filter.php?demand=<?= $row_schedule['nodemand']; ?>&prod_order=<?= $row_schedule['nokk']; ?>"><?= $row_schedule['nokk'] ?></a>
					</td>
					<td style="border:1px solid;vertical-align:middle;"><a title="POSISI KK" target="_BLANK"
							href="http://online.indotaichen.com/laporan/ppc_filter_steps.php?demand=<?= $row_schedule['nodemand']; ?>&prod_order=<?= $row_schedule['nokk']; ?>"><?= $row_schedule['nodemand'] ?></a>
					</td>
					<td style="border:1px solid;vertical-align:middle;"><?= $row_schedule['langganan'] ?></td>
					<td style="border:1px solid;vertical-align:middle;"><?= $row_schedule['buyer'] ?></td>
					<td style="border:1px solid;vertical-align:middle;"><?= $row_schedule['no_order'] ?></td>
					<td style="border:1px solid;vertical-align:middle;"><?= $row_schedule['jenis_kain'] ?></td>
					<td style="border:1px solid;vertical-align:middle;"><?= $rowHanger['SUBCODE02'].'-'.$rowHanger['SUBCODE03']; ?></td>
					<td style="border:1px solid;vertical-align:middle;"><?= $row_schedule['lebar'] ?> x
						<?= $row_schedule['gramasi'] ?>
					</td>
					<td style="border:1px solid;vertical-align:middle;"><?= $row_schedule['no_warna'] ?></td>
					<td style="border:1px solid;vertical-align:middle;"><?= $row_schedule['warna'] ?></td>
					<td style="border:1px solid;vertical-align:middle;"><?= $row_schedule['lot'] ?></td>
					<td style="border:1px solid;vertical-align:middle;"><?= $row_schedule['roll'] ?></td>
					<td style="border:1px solid;vertical-align:middle;"><?= $row_schedule['qty_order'] ?></td>
					<td style="border:1px solid;vertical-align:middle;"><?= $row_schedule['qty_order_yd'] ?></td>
					<?php $totalQty += $row_schedule['qty_order']; ?>
					<?php $totalRoll += $row_schedule['roll'] ? $row_schedule['roll'] : 0; ?>
				</tr>
			<?php endwhile; ?>
		</tbody>
		<tfoot>
			<tr>
				<td style="border:1px solid;vertical-align:middle; text-align: center; font-weight: bold;" colspan="22">
					TOTAL</td>
				<td style="border:1px solid;vertical-align:middle; text-align: center; font-weight: bold;">
					<?= $totalRoll; ?>
				</td>
				<td style="border:1px solid;vertical-align:middle; text-align: center; font-weight: bold;">
					<?= number_format($totalQty, 2); ?>
				</td>
				<!-- <td style="border:1px solid;vertical-align:middle; text-align: center;" colspan="4"></td> -->
			</tr>
		</tfoot>
	</table>
	<div id="confirmation-modal" class="modal">
		<div class="modal-content">
			<h1>Menghapus data Schedule akan berdampak pada penghapusan data terkait di KK Masuk. Apakah Anda yakin ingin melanjutkan ??</h1>
			<button id="deleteAllButton">Ya, hapus juga di KK Masuk</button>
			<button id="confirm-delete-button">Tidak, jangan hapus di KK Masuk</button>
			<button onclick="closeModal()">Cancel</button>
		</div>
	</div>
	<script>
		function showConfirmation(id) {
			document.getElementById('confirmation-modal').style.display = 'block';
			document.getElementById('confirm-delete-button').setAttribute('data-id', id);
			document.getElementById('deleteAllButton').setAttribute('data-id', id);
		}

		function closeModal() {
			document.getElementById('confirmation-modal').style.display = 'none';
		}

		document.getElementById('confirm-delete-button').addEventListener('click', function () {
			var id = this.getAttribute('data-id');
			confirmDelete(id);
		});
		
		document.getElementById('deleteAllButton').addEventListener('click', function () {
			var id = this.getAttribute('data-id');
			confirmDeleteAll(id);
		});

		function confirmDeleteAll(id) {
			$.ajax({
				url: '?p=delete_schedule_all',
				type: 'POST',
				data: {
					id: id
				},
				success: function (response) {
					// Tampilkan pesan sukses atau gagal
					swal({
						title: 'Data deleted successfully.',
						text: 'Klik Ok untuk input data kembali',
						type: 'warning',
					}).then((result) => {
						if (result.value) {
							window.location.href =
								'http://online.indotaichen.com/finishing2-new/schedule/index.php?p=LihatData';
						}
					});
					closeModal();
				},
				error: function (xhr, status, error) {
					// Tampilkan pesan kesalahan jika terjadi error
					alert('Failed to delete item. Please try again later.');
				}
			});
		}
		
		function confirmDelete(id) {
			$.ajax({
				url: '?p=delete_schedule',
				type: 'POST',
				data: {
					id: id
				},
				success: function (response) {
					var data = JSON.parse(response);
					if (data.status === "success") {
						swal({
							title: 'Success',
							text: data.message,
							type: 'success',
						}).then((result) => {
							if (result.value) {
								window.location.href = 'http://online.indotaichen.com/finishing2-new/schedule/index.php?p=LihatData';
							}
						});
					} else {
						swal({
							title: 'Error',
							text: data.message,
							type: 'error',
						});
					}
					closeModal();
				},
				error: function (xhr, status, error) {
					// Tampilkan pesan kesalahan jika terjadi error
					swal({
						title: 'Error',
						text: 'Failed to delete item. Please try again later.',
						type: 'error',
					});
				}
			});
		}
	</script>
</body>

</html>