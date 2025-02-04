<?php
ini_set("error_reporting", 1);
session_start();
include("../../koneksi.php");
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Data Staff Acc Keluar Kain</title>
</head>

<body>
    <?php
        if (isset($_POST['btnHapus'])) {
            $hapusSql = "DELETE FROM db_finishing.tbl_staff WHERE id='$_POST[id]'";
            sqlsrv_query($con, $hapusSql) or die("Gagal hapus" . sqlsrv_errors());

            // Refresh form
            echo "<meta http-equiv='refresh' content='0; url=data-operator.php?status=Data Sudah DiHapus'>";
        }

        if (isset($_POST['btnSimpan'])) {
            $nama = str_replace("'", "", $_POST['nama']);
            $jabatan = str_replace("'", "", $_POST['jabatan']);

            $simpanSql = "INSERT INTO db_finishing.tbl_staff (nama, jabatan) VALUES (?, ?)";

            $params = array($nama, $jabatan);

            $stmt = sqlsrv_query($con, $simpanSql, $params);

            if ($stmt === false) {
                die("Gagal Simpan: " . print_r(sqlsrv_errors(), true));
            }

            // Refresh form
            echo "<meta http-equiv='refresh' content='0; url=data-operator.php?status=Data Sudah DiSimpan'>";
        }

        if (isset($_POST['btnUbah'])) {
            $nama = str_replace("'", "", $_POST['nama']);
            $jabatan = str_replace("'", "", $_POST['jabatan']);
            $simpanSql = "UPDATE db_finishing.tbl_staff SET 
                                                `nama`='$nama',
                                                `jabatan`='$jabatan'
                                                WHERE `id`='$_POST[id]'";
            sqlsrv_query($con, $simpanSql) or die("Gagal Ubah" . sqlsrv_errors());

            // Refresh form
            echo "<meta http-equiv='refresh' content='0; url=data-operator.php?status=Data Sudah DiUbah'>";
        }

        if (isset($_POST['btnHapus'])){
            $hapusSql = "DELETE FROM db_finishing.tbl_staff WHERE id='$_POST[id]'";
            sqlsrv_query($con, $hapusSql) or die("Gagal hapus" . sqlsrv_errors());

            // Refresh form
            echo "<meta http-equiv='refresh' content='0; url=data-operator.php?status=Data Sudah DiHapus'>";
        }
    ?>
    <?php
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $recordsPerPage = 10;

        $offset = ($page - 1) * $recordsPerPage;

        $nama = isset($_GET['nama']) ? $_GET['nama'] : '';
        $sql = "SELECT TOP 1 * FROM db_finishing.tbl_staff WHERE nama = ?";
        $params = array($nama);
        $qtampil = sqlsrv_query($con, $sql, $params);
        $rt = sqlsrv_fetch_array($qtampil, SQLSRV_FETCH_ASSOC);
        $rc = sqlsrv_num_rows($qtampil);

        $sqlTable = "SELECT * FROM db_finishing.tbl_staff ORDER BY id ASC OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";
        $paramsTable = array($offset, $recordsPerPage);
        $qry = sqlsrv_query($con, $sqlTable, $paramsTable);

        $totalRecordsQuery = "SELECT COUNT(*) as total FROM db_finishing.tbl_staff";
        $totalRecordsResult = sqlsrv_query($con, $totalRecordsQuery);
        $totalRecords = sqlsrv_fetch_array($totalRecordsResult)['total'];
        $totalPages = ceil($totalRecords / $recordsPerPage);
    ?>

    <form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
        <table width="100%" border="0">
            <tr>
                <th colspan="3" scope="row">Input Data Operator</th>
            </tr>
            <tr>
                <td colspan="3" align="center" scope="row">
                    <font color="#FF0000"><?php echo isset($_GET['status']) ? $_GET['status'] : ''; ?></font>
                </td>
            </tr>

            <tr>
                <td width="21%" scope="row">Nama</td>
                <td width="1%">:</td>
                <td width="78%"><label for="nama"></label>
                    <input type="text" name="nama" id="nama"
                        onchange="window.location='data-operator.php?nama='+this.value"
                        value="<?php echo htmlspecialchars($nama); ?>" required="required" />
                    <input type="hidden" name="id" value="<?php echo isset($rt['id']) ? $rt['id'] : ''; ?>" />
                </td>
            </tr>
            <tr>
                <td valign="top" scope="row">Jabatan</td>
                <td valign="top">:</td>
                <td><label for="jabatan"></label>
                    <input name="jabatan" type="text" id="jabatan"
                        value="<?php echo isset($rt['jabatan']) ? $rt['jabatan'] : ''; ?>" size="45" />
                </td>
            </tr>
            <tr>
                <th colspan="3" scope="row"><?php if ($rc == 0) { ?>
                        <input type="submit" name="btnSimpan" id="btnSimpan" value="Simpan" /><?php } else { ?>
                        <input type="submit" name="btnUbah" id="btnUbah" value="Ubah" />
                        <input type="submit" name="btnHapus" id="btnHapus" value="Hapus" /><?php } ?>
                    <input type="button" name="tutup" id="tutup" value="Tutup" onclick="window.close();" />
                </th>
            </tr>
        </table>

        <h3>Data Detail Operator</h3>
        <table width="100%" border="0">
            <tr bgcolor="#0099CC">
                <th scope="row">No</th>
                <th bgcolor="#0099CC">Nama</th>
                <th>Jabatan</th>
                <th>Opsi</th>
            </tr>
            <?php
            $no = $offset + 1;
            $c = 0;

            while ($r = sqlsrv_fetch_array($qry)) {
                $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
            ?>
                <tr bgcolor="<?php echo $bgcolor; ?>">
                    <td align="center" scope="row"><?php echo $no; ?></td>
                    <td align="center"><?php echo $r['nama']; ?></td>
                    <td><?php echo $r['jabatan']; ?></td>
                    <td align="center">
                        <form method="POST" onsubmit="return confirmDelete()">
                            <input type="hidden" name="id" id="id" value="<?= $r['id']; ?>">
                            <input type="submit" name="btnHapus" id="btnHapus" value="Hapus">
                        </form>
                    </td>
                </tr>
            <?php $no++;
            } ?>
            <tr bgcolor="#0099CC">
                <td scope="row">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>

        <div align="center">
            <?php if ($page > 1) { ?>
                <a href="?page=<?php echo $page - 1; ?>">Prev</a>
            <?php } ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php } ?>

            <?php if ($page < $totalPages) { ?>
                <a href="?page=<?php echo $page + 1; ?>">Next</a>
            <?php } ?>
        </div>
    </form>

</body>
<script>
    function confirmDelete() {
        return confirm("Apakah Anda yakin ingin menghapus data ini?");
    }
</script>

</html>