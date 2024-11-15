<?php
session_start();  // Memulai sesi
if (empty($_SESSION['usr'])) {
    echo "<script>alert('Silahkan login terlebih dahulu!'); window.location = '../login.php'</script>";
    exit;
}

include('../koneksi.php'); 
 // Pastikan koneksi.php sudah benar

// Menangani form submit untuk menampilkan data
$data = [];
$mesin = '';  // Variabel untuk menyimpan mesin yang dipilih

// Menangani filter mesin
if (isset($_GET['no_mesin'])) {
    $mesin = $_GET['no_mesin'];  // Mendapatkan pilihan mesin dari dropdown

    // Query SQL untuk mengambil data berdasarkan no_mesin
    $query = "SELECT * FROM db_finishing.tbl_schedule_new
              WHERE status = 'SCHEDULE'
              AND no_mesin = ?
              AND nourut <> 0
              AND NOT EXISTS (
                  SELECT 1
                  FROM db_finishing.tbl_produksi b
                  WHERE b.nokk = db_finishing.tbl_schedule_new.nokk
                  AND b.demandno = db_finishing.tbl_schedule_new.nodemand
                  AND b.no_mesin = db_finishing.tbl_schedule_new.no_mesin
                  AND b.nama_mesin = db_finishing.tbl_schedule_new.operation
              )
              ORDER BY nourut ASC";

    // Menjalankan query dengan parameter
    $params = array($mesin);
    $result = sqlsrv_query($con, $query, $params);

    if ($result === false) {
        die(print_r(sqlsrv_errors(), true)); // Menampilkan error jika query gagal
    }

    // Menyimpan hasil query dalam array
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $data[] = $row;
    }
}

// Memperbarui data nomor urut dan nomor mesin setelah form disubmit
if (isset($_POST['nourut']) && isset($_POST['no_mesin_baru'])) {
    $nourut = $_POST['nourut'];  // Mengambil array nourut dari form
    $ids = $_POST['id'];  // Mengambil array id
    $no_mesin_baru = $_POST['no_mesin_baru'];  // Mengambil array no_mesin_baru

    // Proses update untuk setiap baris data
    for ($i = 0; $i < count($nourut); $i++) {
        // Ambil nilai dari array
        $new_nourut = $nourut[$i];
        $id = $ids[$i];
        $new_no_mesin = $no_mesin_baru[$i];

        // Query untuk memperbarui nomor urut dan nomor mesin
        $update_query = "UPDATE db_finishing.tbl_schedule_new 
                         SET nourut = ?, no_mesin = ? 
                         WHERE id = ?";

        // Menyiapkan parameter query
        $params = array($new_nourut, $new_no_mesin, $id);

        // Menjalankan query
        $stmt = sqlsrv_query($con, $update_query, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));  // Menampilkan error jika query gagal
        }
    }

    // Setelah update, memberikan pesan sukses dan refresh data
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Schedule</title>
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
</head>
<body>
    <!-- Tabel untuk menampilkan data -->
    <?php if (!empty($data)): ?>
        <form method="POST" action="">
            <table width="100%" border="1" id="datatables" class="display">
                <thead>
                    <tr>
                        <td style="text-align: center;">Nomor Urut</td>
                        <td style="text-align: center;">No Mesin</td>
                        <td style="text-align: center;">Operation</td>
                        <td style="text-align: center;">Proses</td>
                        <td style="text-align: center;">Group Shift</td>
                        <td style="text-align: center;">Catatan</td>
                        <td style="text-align: center;">No KK</td>
                        <td style="text-align: center;">No. Demand</td>
                        <td style="text-align: center;">No Order</td>
                        <td style="text-align: center;">Nama Mesin</td>
                        <td style="text-align: center;">Langganan</td>
                        <td style="text-align: center;">Warna</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $index => $row): ?>
                        <tr>
                            <td style="text-align: center;">
                                <input type="number" name="nourut[]" value="<?= htmlspecialchars($row['nourut']) ?>" min="1" max="30" />
                                <input type="hidden" name="id[]" value="<?= htmlspecialchars($row['id']) ?>" />
                            </td>
                            <td style="text-align: center;">
                                <select name="no_mesin_baru[]" class="form-control select2">

                                    <option value="-" disabled selected>Pilih</option>
                                    <?php
                                    $q_mesin = sqlsrv_query($con, "SELECT *
                                                                        FROM (
                                                                            SELECT DISTINCT
                                                                                TRIM(no_mesin) AS no_mesin,
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
                                        <option value="<?= $row_mesin['no_mesin']; ?>" <?php if ($row_mesin['no_mesin'] == $_GET['no_mesin']) {
                                            echo 'SELECTED';
                                        } ?>>
                                            <?= $row_mesin['no_mesin']; ?> (<?= $row_mesin['singaktan_mesin']; ?>	<?= $row_mesin['nomesin']; ?>)
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"><?= htmlspecialchars($row['nokk']) ?></td>
                            <td style="text-align: center;"><?= htmlspecialchars($row['nodemand']) ?></td>
                            <td style="text-align: center;"><?= htmlspecialchars($row['no_order']) ?></td>
                            <td style="text-align: center;"><?= htmlspecialchars($row['no_mesin']) ?></td>
                            <td style="text-align: center;"><?= htmlspecialchars($row['langganan']) ?></td>
                            <td style="text-align: center;"><?= htmlspecialchars($row['warna']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>
            <button class="art-button" id="button" style="background-color: #ff004c; color: #ffffff;" type="submit">Simpan Perubahan</button>
        </form>
    <?php else: ?>
        <p>No data available. Please select a machine.</p>
    <?php endif; ?>

</body>
</html>
