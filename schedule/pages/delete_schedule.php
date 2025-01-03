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

    // cek dulu jika sudah di proses maka tidak bisa delete
    $sql_check = "SELECT * FROM db_finishing.tbl_schedule_new WHERE id = ?";
    $params_check = array($id);
    $stmt_check = sqlsrv_query($con, $sql_check, $params_check);
    $row = sqlsrv_fetch_array($stmt_check, SQLSRV_FETCH_ASSOC);

    $nokk           = $row['nokk'];
    $demandno       = $row['nodemand'];
    $nama_mesin     = $row['operation'];

    $sql_check_proses = "SELECT * FROM [db_finishing].[tbl_produksi] WHERE nokk = ? AND demandno = ? AND nama_mesin = ?";
    $params_check_proses = array($nokk, $demandno, $nama_mesin);
    $stmt_check_proses = sqlsrv_query($con, $sql_check_proses, $params_check_proses);
    $row_proses = sqlsrv_fetch_array($stmt_check_proses, SQLSRV_FETCH_ASSOC);

    if ($row_proses['nokk']) {
        echo json_encode(array("status" => "success", "message" => "Schedule sudah diproses dan tidak bisa dihapus."));
        exit;
    }else{
        // Query untuk menghapus data
        $sql = "DELETE FROM db_finishing.tbl_schedule_new WHERE id = ?";

        // Menyiapkan parameter
        $params = array($id);

        // Menyiapkan query
        $stmt = sqlsrv_query($con, $sql, $params);
    }

    if ($stmt) {
        echo json_encode(array("status" => "success", "message" => "Item deleted successfully."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Failed to delete item: " . print_r(sqlsrv_errors(), true)));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "No item ID provided."));
}

// Menutup koneksi
sqlsrv_close($con);
?>
