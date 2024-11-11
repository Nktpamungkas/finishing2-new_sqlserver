<?php
include "../../koneksi.php";
include "../../utils/helper.php";

error_reporting(0);

$params = [];

if ($_GET['nourut'] == 'without0') {
	$params[] = "NOT nourut = '0'";
} elseif ($_GET['nourut'] == 'with0') {
	$params[] = "nourut = '0'";
	// $params[] = "";
} else {
	$params[] = "nourut = '$_GET[nourut]'";
}

if ($_GET['no_mesin']) {
	$params[] = "no_mesin = '$_GET[no_mesin]'";
}

if ($_GET['nama_mesin']) {
	$params[] = "nama_mesin = '$_GET[nama_mesin]'";
}

if ($_GET['proses']) {
	$params[] = "proses = '$_GET[proses]'";
}

if ($_GET['awal']) {
	$params[] = "FORMAT(creationdatetime, 'yyyy-MM-dd') BETWEEN '$_GET[awal]' AND '$_GET[akhir]'";
}


$params[] = "status = 'SCHEDULE'";

if($_GET['cetak'] == "lihatData") {
	$params[] = "NOT EXISTS (
							SELECT 1
							FROM 
									db_finishing.tbl_produksi b
								WHERE
									b.nokk = a.nokk
									AND b.demandno = a.nodemand
									AND b.no_mesin = a.no_mesin
									AND b.nama_mesin = a.operation
						)
					";
}

if($_GET['params'] == 'viewreport'){
	$wheres	= "status = 'SCHEDULE' $_GET[where_nourut] $_GET[where_tgl] $_GET[where_nama_mesin] $_GET[where_proses] $_GET[where_no_mesin]";
}else{
	$wheres = implode(" AND ", $params);
}


$query_schedule = "SELECT 
						nama_mesin,
						no_mesin,
						nourut,
						STRING_AGG(langganan, ', ') WITHIN GROUP (ORDER BY lebar ASC, no_order ASC, nodemand ASC) AS langganan,
						STRING_AGG(COALESCE(no_order, 'Development'), ', ') WITHIN GROUP (ORDER BY lebar ASC, no_order ASC, nodemand ASC) AS no_order,
						STRING_AGG(jenis_kain, ', ') WITHIN GROUP (ORDER BY lebar ASC, no_order ASC, nodemand ASC) AS jenis_kain,
						STRING_AGG(warna, ', ') WITHIN GROUP (ORDER BY lebar ASC, no_order ASC, nodemand ASC) AS warna,
						STRING_AGG(no_warna, ', ') WITHIN GROUP (ORDER BY lebar ASC, no_order ASC, nodemand ASC) AS no_warna,
						STRING_AGG(TRIM(nodemand), ', ') WITHIN GROUP (ORDER BY lebar ASC, no_order ASC, nodemand ASC) AS nodemand,
						STRING_AGG(lot, ', ') WITHIN GROUP (ORDER BY lebar ASC, no_order ASC, nodemand ASC) AS lot,
						STRING_AGG(tgl_delivery, ', ') WITHIN GROUP (ORDER BY lebar ASC, no_order ASC, nodemand ASC) AS tgl_delivery,
						STRING_AGG(roll, ', ') WITHIN GROUP (ORDER BY lebar ASC, no_order ASC, nodemand ASC) AS roll,
						SUM(qty_order) AS qty_order,
						STRING_AGG(proses, ', ') WITHIN GROUP (ORDER BY lebar ASC, no_order ASC, nodemand ASC) AS proses,
						STRING_AGG(operation, ', ') WITHIN GROUP (ORDER BY lebar ASC, no_order ASC, nodemand ASC) AS operation,
						STRING_AGG(TRIM(nokk), ', ') WITHIN GROUP (ORDER BY lebar ASC, no_order ASC, nodemand ASC) AS nokk,
						STRING_AGG(lebar, ', ') WITHIN GROUP (ORDER BY lebar ASC, no_order ASC, nodemand ASC) AS lebar,
						STRING_AGG(gramasi, ', ') WITHIN GROUP (ORDER BY lebar ASC, no_order ASC, nodemand ASC) AS gramasi,
						STRING_AGG(personil, ', ') WITHIN GROUP (ORDER BY lebar ASC, no_order ASC, nodemand ASC) AS personil,
						STRING_AGG(catatan, ', ') WITHIN GROUP (ORDER BY lebar ASC, no_order ASC, nodemand ASC) AS catatan,
						STRING_AGG(kondisikain, ', ') WITHIN GROUP (ORDER BY lebar ASC, no_order ASC, nodemand ASC) AS kondisikain
					FROM
						db_finishing.tbl_schedule_new a
					WHERE 
						$wheres
					GROUP BY
						nama_mesin,
						no_mesin,
						nourut
					ORDER BY
						CONCAT(SUBSTRING(LTRIM(RTRIM(no_mesin)), LEN(LTRIM(RTRIM(no_mesin))) - 5 + 1, 2),
						SUBSTRING(LTRIM(RTRIM(no_mesin)), LEN(LTRIM(RTRIM(no_mesin))) - 2 + 1, 2)) ASC, nourut ASC";


$q_schedule = sqlsrv_query($con, $query_schedule);

$row_schedules = [];
while ($row = sqlsrv_fetch_array($q_schedule, SQLSRV_FETCH_ASSOC)) {

	// Mengambil dan membersihkan data dari no_mesin
	$noMesin = trim($row['no_mesin']);

	// Mengambil dua karakter dari posisi -5 dan dua karakter terakhir
	$nama_mesin_new = substr($noMesin, -5, 2) . substr($noMesin, -2);

	$row_schedules[$nama_mesin_new][trim($row['no_mesin'])][] = $row;
}

// Fungsi untuk mengurutkan array berdasarkan 'nourut'
function sortNourutInArray(&$data)
{
	// Function to sort the array by 'nourut'
	$sortNourut = function (&$array) {
		usort($array, function ($a, $b) {
			return $a['nourut'] <=> $b['nourut'];
		});
	};

	// Sort the inner arrays by 'nourut'
	foreach ($data as &$subArray) {
		// Sort the keys of each sub-array (P3ST103, P3ST206)
		ksort($subArray);

		foreach ($subArray as &$itemArray) {
			$sortNourut($itemArray);
		}
	}

	// Sort the outer array by keys (P3ST, P2ST)
	ksort($data);
}

// Call the function to sort
sortNourutInArray($row_schedules);

// Tanggal dalam format Y-m-d H:i:s
$date = date('Y-m-d H:i:s');

// Array nama hari dalam bahasa Indonesia
$hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");

// Array nama bulan dalam bahasa Indonesia
$bulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

// Pisahkan tanggal, bulan, dan tahun
$timestamp = strtotime($date);
$hari_indonesia = $hari[date('w', $timestamp)];
$bulan_indonesia = $bulan[date('n', $timestamp)];
$tanggal_indonesia = date('d', $timestamp);
$tahun_indonesia = date('Y', $timestamp);

// Format tanggal dalam bahasa Indonesia
$tanggal_lengkap = $hari_indonesia . ', ' . $tanggal_indonesia . ' ' . $bulan_indonesia . ' ' . $tahun_indonesia;
$tanggal_lengkap_ttd = $tanggal_indonesia . ' ' . $bulan_indonesia . ' ' . $tahun_indonesia;

?>
<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="../../styles_cetak.css" rel="stylesheet" type="text/css">
	<title>Cetak Schedule</title>
	<script>
		// set portrait orientation

		jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);

		// set top margins in millimeters
		jsPrintSetup.setOption('marginTop', 0);
		jsPrintSetup.setOption('marginBottom', 0);
		jsPrintSetup.setOption('marginLeft', 0);
		jsPrintSetup.setOption('marginRight', 0);

		// set page header
		jsPrintSetup.setOption('headerStrLeft', '');
		jsPrintSetup.setOption('headerStrCenter', '');
		jsPrintSetup.setOption('headerStrRight', '');

		// set empty page footer
		jsPrintSetup.setOption('footerStrLeft', '');
		jsPrintSetup.setOption('footerStrCenter', '');
		jsPrintSetup.setOption('footerStrRight', '');

		// clears user preferences always silent print value
		// to enable using 'printSilent' option
		jsPrintSetup.clearSilentPrint();

		// Suppress print dialog (for this context only)
		jsPrintSetup.setOption('printSilent', 1);

		// Do Print 
		// When print is submitted it is executed asynchronous and
		// script flow continues after print independently of completetion of print process! 
		jsPrintSetup.print();

		window.addEventListener('load', function () {
			var rotates = document.getElementsByClassName('rotate');
			for (var i = 0; i < rotates.length; i++) {
				rotates[i].style.height = rotates[i].offsetWidth + 'px';
			}
		});
		// next commands
	</script>
	<style>
		.hurufvertical {
			writing-mode: tb-rl;
			-webkit-transform: rotate(-90deg);
			-moz-transform: rotate(-90deg);
			-o-transform: rotate(-90deg);
			-ms-transform: rotate(-90deg);
			transform: rotate(180deg);
			white-space: nowrap;
			float: left;
		}

		input {
			text-align: center;
			border: hidden;
		}

		@media print {
			::-webkit-input-placeholder {
				/* WebKit browsers */
				color: transparent;
			}

			:-moz-placeholder {
				/* Mozilla Firefox 4 to 18 */
				color: transparent;
			}

			::-moz-placeholder {
				/* Mozilla Firefox 19+ */
				color: transparent;
			}

			:-ms-input-placeholder {
				/* Internet Explorer 10+ */
				color: transparent;
			}

			.pagebreak {
				page-break-before: always;
			}

			.header {
				display: block
			}

			table thead {
				display: table-header-group;
			}
		}
	</style>
</head>

<body>
	<table width="100%">
		<thead>
			<tr>
				<td>
					<table width="100%" border="1" class="table-list1">
						<tr>
							<td width="9%" align="center"><img src="../../indo.jpg" width="40" height="40" /></td>
							<td align="center" valign="middle"><strong>
									<font size="+1">
										<?php if($_GET['params'] == 'viewreport') : ?>
											SCHEDULE FINISHING STEAM, OVEN, STENTER, COMPACT, INSPEK
										<?php else : ?>
											<?php if($_GET['nourut'] == 'without0') : ?>
												SCHEDULE FINISHING STEAM, OVEN, STENTER, COMPACT, INSPEK
											<?php elseif($_GET['nourut'] == 'with0') : ?>
												SCHEDULE FINISHING STEAM, OVEN, STENTER, COMPACT, INSPEK BELUM TERSUSUN
											<?php endif; ?>
										<?php endif; ?>
									</font>
								</strong></td>
						</tr>
					</table>
					<table width="100%" border="0">
						<tbody>
							<tr>
							<td width="78%">
								<?php
									if($_GET['params'] == 'viewreport'){
										$date1 = date_create($_GET['datestart']);
										$date2 = date_create($_GET['datestop']);
										echo '<font size="-1">Hari/Tanggal : ' . date_format($date1, "d M Y") . ' s/d ' . date_format($date2, "d M Y") . '</font>';
									}else{
										if (empty($_GET['awal']) && empty($_GET['akhir'])) {
											// Jika 'awal' dan 'akhir' kosong, cetak tanggal hari ini
											echo '<font size="-1">Hari/Tanggal : ' . date('l, d F Y') . '</font>';
										} else {
											// Jika 'awal' dan 'akhir' ada isinya, cetak sesuai dengan input
											echo '<font size="-1">Hari/Tanggal : ' . $_GET['awal'] . ' - ' . $_GET['akhir'] . '</font>';
										}
									}
								?>
								<br />
							</td>
								<td width="22%" align="right">
									Jam: <?php echo date('H:i:s'); ?>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</thead>
		<tr>
			<td>
				<table width="100%" border="1" class="table-list1">
					<thead>
						<tr>
							<!-- <td width="5%" rowspan="2" scope="col">
								<div align="center">Kapasitas Mesin</div>
							</td> -->
							<td width="4%" rowspan="2" scope="col">
								<div align="center">Nomor<br>Mesin</div>
							</td>
							<td width="3%" rowspan="2" scope="col">
								<div align="center">No. Urut</div>
							</td>
							<td width="15%" rowspan="2" scope="col">
								<div align="center">Pelanggan</div>
							</td>
							<td width="8%" rowspan="2" scope="col">
								<div align="center">No. Order</div>
							</td>
							<td width="12%" rowspan="2" scope="col">
								<div align="center">Jenis Kain</div>
							</td>
							<td width="7%" rowspan="2" scope="col">
								<div align="center">Lebar x Gramasi</div>
							</td>
							<td width="9%" rowspan="2" scope="col">
								<div align="center">Warna</div>
							</td>
							<td width="4%" rowspan="2" scope="col">
								<div align="center">No. KK</div>
							</td>
							<td width="4%" rowspan="2" scope="col">
								<div align="center">No Demand</div>
							</td>
							<td width="4%" rowspan="2" scope="col">
								<div align="center">Lot</div>
							</td>
							<td width="7%" rowspan="2" scope="col">
								<div align="center">Tanggal Delivery</div>
							</td>
							<td colspan="2" scope="col">
								<div align="center">Quantity</div>
							</td>
							<td width="14%" rowspan="2" scope="col">
								<div align="center">Proses</div>
							</td>
							<td width="14%" rowspan="2" scope="col">
								<div align="center">Keterangan</div>
							</td>
						</tr>
						<tr>
							<td width="4%">
								<div align="center">Roll</div>
							</td>
							<td width="6%">
								<div align="center">Kg</div>
							</td>
						</tr>
					</thead>
					<?php

					$satu = 1;
					foreach ($row_schedules as $key0 => $value0) {
						foreach ($value0 as $key1 => $value1) {
							$no = 1;
							foreach ($value1 as $key2 => $value2) {
								?>
								<tr>
									<?php
									if ($satu > 0) {
										?>
										<!-- <td rowspan="<?= count($value1) ?>">
											<a class="hurufvertical">
												<h2>
													<div align="center"><?php echo ''// $rowd['kapasitas']; ?></div>
												</h2>
											</a>
										</td> -->
										<td rowspan="<?= count($value1) ?>">
											<div align="center" style="font-size: 18px;">
												<strong>
													<?php echo $key1; ?>
												</strong>
											</div>
											<div align="center" style="font-size: 12px;">
												(<?php echo $key0 ?>)
											</div>
										</td>
										<?php
										$satu = 0;
									}
									?>
									<td valign="top" style="height: 0.27in;">
										<div align="center"><?=  $value2['nourut']; ?></div>
									</td>
									<td align="left" valign="top">
										<?php 
											$data_langganan = $value2['langganan'];

											// Ubah string menjadi array
											$Array_langganan = explode(', ', $data_langganan);
											
											// Hapus duplikat menggunakan array_unique
											$dataUnique_langganan = array_unique($Array_langganan);
											
											// Gabungkan kembali menjadi string
											$dataClean_langganan = implode(',<br>', $dataUnique_langganan);
											
											echo $dataClean_langganan; // Output: DOM2401663
										?>
									</td>
									<td align="center" valign="top">
										<div style="font-size: 8px;">
											<?php 
												$data_no_order = $value2['no_order'];

												// Ubah string menjadi array
												$Array_no_order = explode(', ', $data_no_order);
												
												// Hapus duplikat menggunakan array_unique
												$dataUnique_no_order = array_unique($Array_no_order);
												
												// Gabungkan kembali menjadi string
												$dataClean_no_order = implode(',<br>', $dataUnique_no_order);
												
												echo $dataClean_no_order; // Output: DOM2401663
											?>
										</div>
									</td>
									<td valign="top">
										<div style="font-size: 8px;">
											<?php 
												$data_jenis_kain = $value2['jenis_kain'];

												// Ubah string menjadi array
												$Array_jenis_kain = explode(', ', $data_jenis_kain);
												
												// Hapus duplikat menggunakan array_unique
												$dataUnique_jenis_kain = array_unique($Array_jenis_kain);
												
												// Gabungkan kembali menjadi string
												$dataClean_jenis_kain = implode(',<br> ', $dataUnique_jenis_kain);
												
												echo $dataClean_jenis_kain; // Output: DOM2401663
											?>
										</div>
									</td>
									<td align="center" valign="top">
										<div style="font-size: 8px;">
											<?php

											 // Mengambil nilai lebar dan gramasi, misalnya dari database
											 $lebar = explode(", ", $value2['lebar']); // Array lebar
											 $gramasi = explode(", ", $value2['gramasi']); // Array gramasi
								 
											 // Mengiterasi elemen-elemen dari array lebar dan gramasi
											 for ($i = 0; $i < count($lebar); $i++) {
												 // Gabungkan lebar dan gramasi dengan format 'lebar x gramasi'
												 echo $lebar[$i] . ' x ' . $gramasi[$i];
								 
												 // Tambahkan koma dan line break jika bukan elemen terakhir
												 if ($i < count($lebar) - 1) {
													 echo ',<br>';
												 }
											 }
											?>
										</div>
									</td>
									<td align="center" valign="top">
										<div style="font-size: 8px;">
											<?php 
												$data_warna = $value2['warna'];

												// Ubah string menjadi array
												$Array_warna = explode(', ', $data_warna);
												
												// Hapus duplikat menggunakan array_unique
												$dataUnique_warna = array_unique($Array_warna);
												
												// Gabungkan kembali menjadi string
												$dataClean_warna = implode(',<br>', $dataUnique_warna);
												
												echo $dataClean_warna; // Output: DOM2401663
											?>
										</div>
									</td>
									<td align="center" valign="top">
										<div style="font-size: 8px;">
											<?php 
												$data_nokk = $value2['nokk'];

												// Ubah string menjadi array
												$Array_nokk = explode(', ', $data_nokk);
												
												// Hapus duplikat menggunakan array_unique
												$dataUnique_nokk = array_unique($Array_nokk);
												
												// Gabungkan kembali menjadi string
												$dataClean_nokk = implode(', ', $dataUnique_nokk);
												
												echo $dataClean_nokk; // Output: DOM2401663
											?>
										</div>
									</td>
									<td align="center" valign="top">
										<div style="font-size: 8px;">
											<?php 
												$data_nodemand = $value2['nodemand'];

												// Ubah string menjadi array
												$Array_nodemand = explode(', ', $data_nodemand);
												
												// Hapus duplikat menggunakan array_unique
												$dataUnique_nodemand = array_unique($Array_nodemand);
												
												// Gabungkan kembali menjadi string
												$dataClean_nodemand = implode(', ', $dataUnique_nodemand);
												
												echo $dataClean_nodemand; // Output: DOM2401663
											?>
										</div>
									</td>
									<td align="center" valign="top">
										<div style="font-size: 8px;">
											<?php 
												$data_lot = $value2['lot'];

												// Ubah string menjadi array
												$Array_lot = explode(', ', $data_lot);
												
												// Hapus duplikat menggunakan array_unique
												$dataUnique_lot = array_unique($Array_lot);
												
												// Gabungkan kembali menjadi string
												$dataClean_lot = implode(',<br>', $dataUnique_lot);
												
												echo $dataClean_lot; // Output: DOM2401663
											?>
										</div>
									</td>
									<td align="center" valign="top">
										<?php 
											$data_tgl_delivery = $value2['tgl_delivery'];

											// Ubah string menjadi array
											$Array_tgl_delivery = explode(', ', $data_tgl_delivery);
											
											// Hapus duplikat menggunakan array_unique
											$dataUnique_tgl_delivery = array_unique($Array_tgl_delivery);
											
											// Gabungkan kembali menjadi string
											$dataClean_tgl_delivery = implode(',<br>', $dataUnique_tgl_delivery);
											
											echo $dataClean_tgl_delivery; // Output: DOM2401663
										?>
									</td>
									<td align="center" valign="top">
										<?php 
											$data = cek($value2['roll']);
											// Pisahkan data berdasarkan karakter tertentu (misalnya, spasi atau koma) dan tampilkan setiap item pada baris baru
											$dataArray = explode(' ', $data); // Ubah pemisahan sesuai dengan karakter yang diinginkan
											foreach ($dataArray as $item) {
												echo $item . '<br>';
											}
										?>
									</td>

									<td align="center" valign="top">
										<?php echo $value2['qty_order']; ?>
									</td>
									<td align="left" valign="top">
									<?php 
										$data_proses = $value2['proses'];

										// Ubah string menjadi array
										$Array_proses = explode(', ', $data_proses);
										
										// Hapus duplikat menggunakan array_unique
										$dataUnique_proses = array_unique($Array_proses);
										
										// Gabungkan kembali menjadi string dengan koma dan baris baru setelah setiap item
										$dataClean_proses = implode(',<br>', $dataUnique_proses);
										
										// Output data yang sudah dibersihkan
										echo $dataClean_proses;
									?>

									</td>
									<td valign="top">
										<!-- <?php 
											$data_operation = $value2['operation'];

											// Ubah string menjadi array
											$Array_operation = explode(', ', $data_operation);
											
											// Hapus duplikat menggunakan array_unique
											$dataUnique_operation = array_unique($Array_operation);
											
											// Gabungkan kembali menjadi string
											$dataClean_operation = implode(', ', $dataUnique_operation);
											
											echo $dataClean_operation; // Output: DOM2401663
										?>
										<br> -->
										<?php 
											$data_personil = $value2['personil'];

											// Ubah string menjadi array
											$Array_personil = explode(', ', $data_personil);
											
											// Hapus duplikat menggunakan array_unique
											$dataUnique_personil = array_unique($Array_personil);
											
											// Gabungkan kembali menjadi string
											$dataClean_personil = implode(',<br>', $dataUnique_personil);
											
											echo $dataClean_personil; // Output: DOM2401663
										?>
										<br>
										<br>
										<?php 
											$data_kondisikain = $value2['kondisikain'];

											// Ubah string menjadi array
											$Array_kondisikain = explode(', ', $data_kondisikain);
											
											// Hapus duplikat menggunakan array_unique
											$dataUnique_kondisikain = array_unique($Array_kondisikain);
											
											// Gabungkan kembali menjadi string
											$dataClean_kondisikain = implode(', ', $dataUnique_kondisikain);
											
											echo $dataClean_kondisikain; // Output: DOM2401663
										?>
										<br>
										<br>
										<?php 
											$data_catatan = $value2['catatan'];

											// Ubah string menjadi array
											$Array_catatan = explode(', ', $data_catatan);
											
											// Hapus duplikat menggunakan array_unique
											$dataUnique_catatan = array_unique($Array_catatan);
											
											// Gabungkan kembali menjadi string
											$dataClean_catatan = implode(', ', $dataUnique_catatan);
											
											echo $dataClean_catatan; // Output: DOM2401663
										?>
										<br>
									</td>
								</tr>
								<?php
							}
							$satu = 1;
						}
					}
					?>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%" border="1" class="table-list1">
					<tr>
						<td width="16%" scope="col">&nbsp;</td>
						<td width="29%" scope="col">
							<div align="center">Dibuat Oleh</div>
						</td>
						<td width="29%" scope="col">
							<div align="center">Diperiksa Oleh</div>
						</td>
						<td width="26%" scope="col">
							<div align="center">Diketahui Oleh</div>
						</td>
					</tr>
					<tr>
						<td>Nama</td>
						<td align="center">Husni Jr</td>
						<td align="center">Aressa</td>
						<td align="center">Indra Cahya</td>
					</tr>
					<tr>
						<td>Jabatan</td>
						<td align="center">Staff Schedule</td>
						<td align="center">Ast. SPV</td>
						<td align="center"> Ast. Manager</td>
					</tr>
					<tr>
						<td>Tanggal</td>
						<td align="center"><?= $tanggal_lengkap_ttd ?></td>
						<td align="center"><?= $tanggal_lengkap_ttd ?></td>
						<td align="center"><?= $tanggal_lengkap_ttd ?></td>
					</tr>
					<tr>
						<td valign="top" style="height: 0.5in;">Tanda Tangan</td>
						<td align="center"><img src="../../ttd/husni.jpg" width="80" height="73" alt="" /></td>
						<td align="center"><img src="../../ttd/aressa.jpeg" width="80" height="73" alt="" /></td>
						<td align="center"><img src="../../ttd/indra_cahya.png" width="80" height="73" alt="" /></td>
					</tr>

				</table>
			</td>
		</tr>

	</table>
	<table width="100%" border="0">
		<tbody>
			<tr>
				<td width="73%" rowspan="4">
					<div style="font-size: 11px; font-family:sans-serif, Roman, serif;">
						
					</div>
				</td>
				<td width="20%">
					<pre>No. Form &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : 14-11</pre>
				</td>
			</tr>
			<tr>
				<td>
					<pre>No. Revisi	: 23</pre>
				</td>
			</tr>
			<tr>
				<td>
					<pre>Tgl. Terbit	: </pre>
				</td>
			</tr>
			<tr>
				<td>
					<pre></pre>
				</td>
			</tr>
		</tbody>
	</table>
	<script>
		//alert('cetak');window.print();
	</script>
</body>

</html>