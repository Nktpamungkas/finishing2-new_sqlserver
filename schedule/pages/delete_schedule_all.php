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

    $paramsMain = array($id);
    $resultMain = "SELECT * FROM db_finishing.tbl_schedule_new WHERE id = ?";
    $stmtMain = sqlsrv_query($con, $resultMain, $paramsMain);
    $rowMain = sqlsrv_fetch_array($stmtMain, SQLSRV_FETCH_ASSOC);
    
    // Query untuk menghapus data KK MASUK
    $sqlMain = "DELETE FROM db_finishing.tbl_masuk WHERE nokk = '$rowMain[nokk]' AND nodemand = '$rowMain[nodemand]' AND operation = '$rowMain[operation]'";
    $stmtMain = sqlsrv_query($con, $sqlMain);

    // Query untuk menghapus data SCHEDULE
    $sql = "DELETE FROM db_finishing.tbl_schedule_new WHERE id = ?";
    $params = array($id);
    $stmt = sqlsrv_query($con, $sql, $params);

    if ($stmt AND $stmtMain) {
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
