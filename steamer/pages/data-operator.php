<?php
ini_set("error_reporting", 1);
session_start();
include("../../koneksi.php");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Staff Acc Keluar Kain</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #0099CC; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
    </style>
    <script>
        function searchTable() {
            let input = document.getElementById("search").value.toLowerCase();
            let rows = document.querySelectorAll("#dataTable tbody tr");
            rows.forEach(row => {
                let nama = row.cells[1].textContent.toLowerCase();
                let jabatan = row.cells[2].textContent.toLowerCase();
                row.style.display = (nama.includes(input) || jabatan.includes(input)) ? "" : "none";
            });
        }
    </script>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'] ?? '';
        $nama = str_replace("'", "", $_POST['nama'] ?? '');
        $jabatan = str_replace("'", "", $_POST['jabatan'] ?? '');
        
        if (isset($_POST['btnHapus'])) {
            $hapusSql = "DELETE FROM db_finishing.tbl_staff WHERE id=?";
            $stmt = sqlsrv_query($con, $hapusSql, array($id));
            echo $stmt ? "<script>alert('Data berhasil dihapus!'); window.location.href='data-operator.php';</script>" 
                      : "<script>alert('Gagal menghapus data!');</script>";
        } elseif (isset($_POST['btnSimpan'])) {
            $simpanSql = "INSERT INTO db_finishing.tbl_staff (nama, jabatan) VALUES (?, ?)";
            $stmt = sqlsrv_query($con, $simpanSql, array($nama, $jabatan));
            echo $stmt ? "<script>alert('Data berhasil disimpan!'); window.location.href='data-operator.php';</script>" 
                      : "<script>alert('Gagal menyimpan data!');</script>";
        } elseif (isset($_POST['btnUbah'])) {
            $ubahSql = "UPDATE db_finishing.tbl_staff SET nama=?, jabatan=? WHERE id=?";
            $stmt = sqlsrv_query($con, $ubahSql, array($nama, $jabatan, $id));
            echo $stmt ? "<script>alert('Data berhasil diubah!'); window.location.href='data-operator.php';</script>" 
                      : "<script>alert('Gagal mengubah data!');</script>";
        }
    }
    ?>

    <h2>Input Data Operator</h2>
    <form method="POST">
        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" value="<?= $_GET['nama'] ?? ''; ?>" required>
        <input type="hidden" name="id" value="<?= $_GET['id'] ?? ''; ?>">
        
        <label for="jabatan">Jabatan:</label>
        <input type="text" name="jabatan" id="jabatan" value="<?= $_GET['jabatan'] ?? ''; ?>">
        
        <button type="submit" name="btnSimpan">Simpan</button>
        <button type="submit" name="btnUbah">Ubah</button>
    </form>

    <h3>Data Detail Operator</h3>
    <input type="text" id="search" onkeyup="searchTable()" placeholder="Cari nama atau jabatan...">
    <table id="dataTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $qry = sqlsrv_query($con, "SELECT * FROM db_finishing.tbl_staff ORDER BY nama ASC");
        $no = 1;
        while ($r = sqlsrv_fetch_array($qry)) {
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($r['nama']); ?></td>
            <td><?= htmlspecialchars($r['jabatan']); ?></td>
            <td>
                <form method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                    <input type="hidden" name="id" value="<?= $r['id']; ?>">
                    <button type="submit" name="btnHapus">Hapus</button>
                </form>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</body>
</html>