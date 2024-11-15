<?php
session_start();  // Memulai sesi
if (empty($_SESSION['usr'])) {
    echo "<script>alert('Silahkan login terlebih dahulu!'); window.location = '../login.php'</script>";
    exit;
}

include('../koneksi.php');  // Pastikan koneksi.php sudah benar

// Menangani form submit untuk menampilkan data
$data = [];
$mesin = '';  // Variabel untuk menyimpan mesin yang dipilih

// Menangani filter mesin
if (isset($_POST['no_mesin'])) {
    $mesin = $_POST['no_mesin'];  // Mendapatkan pilihan mesin dari dropdown

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
    echo "<script>alert('Data berhasil diperbarui')</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Schedule</title>
</head>
<body>
    <h2>Menampilkan Data Schedule</h2>

    <!-- Form untuk memilih mesin -->
    <form method="POST" action="">
        <label for="no_mesin">Pilih Mesin:</label>
        <select id="no_mesin" name="no_mesin">
            <option value="">Pilih Mesin</option>
            <option value="P3BC103" <?php echo ($mesin == 'P3BC103') ? 'selected' : ''; ?>>P3BC103</option>
            <option value="P3CP101" <?php echo ($mesin == 'P3CP101') ? 'selected' : ''; ?>>P3CP101</option>
            <option value="P3CP102" <?php echo ($mesin == 'P3CP102') ? 'selected' : ''; ?>>P3CP102</option>
            <option value="P3CP103" <?php echo ($mesin == 'P3CP103') ? 'selected' : ''; ?>>P3CP103</option>
            <option value="P3DR101" <?php echo ($mesin == 'P3DR101') ? 'selected' : ''; ?>>P3DR101</option>
            <option value="P3IN350" <?php echo ($mesin == 'P3IN350') ? 'selected' : ''; ?>>P3IN350</option>
            <option value="P3SM101" <?php echo ($mesin == 'P3SM101') ? 'selected' : ''; ?>>P3SM101</option>
            <option value="P3ST103" <?php echo ($mesin == 'P3ST103') ? 'selected' : ''; ?>>P3ST103</option>
            <option value="P3ST109" <?php echo ($mesin == 'P3ST109') ? 'selected' : ''; ?>>P3ST109</option>
            <option value="P3ST205" <?php echo ($mesin == 'P3ST205') ? 'selected' : ''; ?>>P3ST205</option>
            <option value="P3ST206" <?php echo ($mesin == 'P3ST206') ? 'selected' : ''; ?>>P3ST206</option>
            <option value="P3ST208" <?php echo ($mesin == 'P3ST208') ? 'selected' : ''; ?>>P3ST208</option>
            <option value="P3ST301" <?php echo ($mesin == 'P3ST301') ? 'selected' : ''; ?>>P3ST301</option>
            <option value="P3ST302" <?php echo ($mesin == 'P3ST302') ? 'selected' : ''; ?>>P3ST302</option>
            <option value="P3ST304" <?php echo ($mesin == 'P3ST304') ? 'selected' : ''; ?>>P3ST304</option>
        </select>
        <button type="submit">Tampilkan Data</button>
    </form>

    <!-- Tabel untuk menampilkan data -->
    <?php if (!empty($data)): ?>
        <form method="POST" action="">
            <table border="1" cellspacing="9" cellpadding="5">
                <thead>
                    <tr>
                        <td style="text-align: center;">Nomor Urut</td>
                        <td style="text-align: center;">No KK</td>
                        <td style="text-align: center;">No. Demand</td>
                        <td style="text-align: center;">No Order</td>
                        <td style="text-align: center;">Nama Mesin</td>
                        <td style="text-align: center;">Langganan</td>
                        <td style="text-align: center;">Warna</td>
                        <td style="text-align: center;">Ubah No Urut</td>
                        <td style="text-align: center;">Pindah No Mesin</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $index => $row): ?>
                        <tr>
                            <td style="text-align: center;"><?= htmlspecialchars($row['nourut']) ?></td>
                            <td style="text-align: center;"><?= htmlspecialchars($row['nokk']) ?></td>
                            <td style="text-align: center;"><?= htmlspecialchars($row['nodemand']) ?></td>
                            <td style="text-align: center;"><?= htmlspecialchars($row['no_order']) ?></td>
                            <td style="text-align: center;"><?= htmlspecialchars($row['no_mesin']) ?></td>
                            <td style="text-align: center;"><?= htmlspecialchars($row['langganan']) ?></td>
                            <td style="text-align: center;"><?= htmlspecialchars($row['warna']) ?></td>
                            <td style="text-align: center;">
                                <input type="number" name="nourut[]" value="<?= htmlspecialchars($row['nourut']) ?>" min="1" max="30" />
                                <input type="hidden" name="id[]" value="<?= htmlspecialchars($row['id']) ?>" />
                            </td>
                            <td style="text-align: center;">
                                <select name="no_mesin_baru[]">
                                    <option value="P3BC103" <?= ($row['no_mesin'] == 'P3BC103') ? 'selected' : ''; ?>>P3BC103</option>
                                    <option value="P3CP101" <?= ($row['no_mesin'] == 'P3CP101') ? 'selected' : ''; ?>>P3CP101</option>
                                    <option value="P3CP102" <?= ($row['no_mesin'] == 'P3CP102') ? 'selected' : ''; ?>>P3CP102</option>
                                    <option value="P3CP103" <?= ($row['no_mesin'] == 'P3CP103') ? 'selected' : ''; ?>>P3CP103</option>
                                    <option value="P3DR101" <?= ($row['no_mesin'] == 'P3DR101') ? 'selected' : ''; ?>>P3DR101</option>
                                    <option value="P3IN350" <?= ($row['no_mesin'] == 'P3IN350') ? 'selected' : ''; ?>>P3IN350</option>
                                    <option value="P3SM101" <?= ($row['no_mesin'] == 'P3SM101') ? 'selected' : ''; ?>>P3SM101</option>
                                    <option value="P3ST103" <?= ($row['no_mesin'] == 'P3ST103') ? 'selected' : ''; ?>>P3ST103</option>
                                    <option value="P3ST109" <?= ($row['no_mesin'] == 'P3ST109') ? 'selected' : ''; ?>>P3ST109</option>
                                    <option value="P3ST205" <?= ($row['no_mesin'] == 'P3ST205') ? 'selected' : ''; ?>>P3ST205</option>
                                    <option value="P3ST206" <?= ($row['no_mesin'] == 'P3ST206') ? 'selected' : ''; ?>>P3ST206</option>
                                    <option value="P3ST208" <?= ($row['no_mesin'] == 'P3ST208') ? 'selected' : ''; ?>>P3ST208</option>
                                    <option value="P3ST301" <?= ($row['no_mesin'] == 'P3ST301') ? 'selected' : ''; ?>>P3ST301</option>
                                    <option value="P3ST302" <?= ($row['no_mesin'] == 'P3ST302') ? 'selected' : ''; ?>>P3ST302</option>
                                    <option value="P3ST304" <?= ($row['no_mesin'] == 'P3ST304') ? 'selected' : ''; ?>>P3ST304</option>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit">Simpan Perubahan</button>
        </form>
    <?php else: ?>
        <p>No data available. Please select a machine.</p>
    <?php endif; ?>

</body>
</html>
