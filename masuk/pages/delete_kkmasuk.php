<?php
include('../koneksi.php');
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Cek ID yang diterima
    echo "ID yang diterima: " . $id . "<br>";

    if (sqlsrv_query($con, "DELETE FROM db_finishing.tbl_masuk WHERE id = '$id'")) {
        echo 'Item deleted successfully.';
    } else {
        echo 'Failed to delete item: ' . sqlsrv_errors($con);
    }
} else {
    echo 'No item ID provided.';
}

sqlsrv_close($con);
?>