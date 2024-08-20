<?php
include('../koneksi.php');

// Periksa koneksi
if ($con === false) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Cek ID yang diterima
    echo "ID yang diterima: " . htmlspecialchars($id) . "<br>";

    // Query untuk menghapus data
    $sql = "DELETE FROM db_finishing.tbl_schedule_new WHERE id = ?";

    // Menyiapkan parameter
    $params = array($id);

    // Menyiapkan query
    $stmt = sqlsrv_query($con, $sql, $params);

    if ($stmt) {
        echo 'Item deleted successfully.';
    } else {
        echo 'Failed to delete item: ' . print_r(sqlsrv_errors(), true);
    }
} else {
    echo 'No item ID provided.';
}

// Menutup koneksi
sqlsrv_close($con);
?>
