<?php
$con = mysqli_connect("10.0.0.10", "dit", "4dm1n", "db_finishing");

// Periksa koneksi
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Cek ID yang diterima
    echo "ID yang diterima: " . $id . "<br>";

    if (mysqli_query($con, "DELETE FROM tbl_schedule_new WHERE id = '$id'")) {
        echo 'Item deleted successfully.';
    } else {
        echo 'Failed to delete item: ' . mysqli_error($con);
    }
} else {
    echo 'No item ID provided.';
}

mysqli_close($con);
?>
