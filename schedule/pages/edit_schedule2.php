<?php
session_start();  // Memulai sesi
if (empty($_SESSION['usr'])) {
    echo "<script>alert('Silahkan login terlebih dahulu!'); window.location = '../login.php'</script>";
    exit;
}

include('../koneksi.php');
// Membuat query untuk CEK DATA DAN INSERT DATA 
// Memastikan bahwa id dan no_mesin tersedia
if (isset($_GET['id']) && isset($_GET['no_mesin'])) {
    $id_schedule = $_GET['id'];
    $no_mesin = $_GET['no_mesin'];
    
    // Cek apakah data sudah ada di active_lock
    $check_activeLock = sqlsrv_query($con, "SELECT * FROM db_finishing.active_lock WHERE id_schedule = '$id_schedule'");
    $dataMain_activeLock = sqlsrv_fetch_array($check_activeLock, SQLSRV_FETCH_ASSOC);

    if (empty($dataMain_activeLock)) {
        // Jika belum ada, insert data baru
        $insertMain_activeLock = "INSERT INTO db_finishing.active_lock (user_lock, ipaddress, creationdatetime, id_schedule, no_mesin)
                                   VALUES ('$_SESSION[usr]', '$_SERVER[REMOTE_ADDR]', GETDATE(), '$id_schedule', '$no_mesin')";
        $exec_activeLock = sqlsrv_query($con, $insertMain_activeLock) or die("Gagal insert active lock" . sqlsrv_errors());
    }
}


// Menangani form submit untuk menampilkan data
$data = [];
$mesin = '';  // Variabel untuk menyimpan mesin yang dipilih

// Menangani filter mesin
if (isset($_GET['no_mesin']) && $_GET['nourut'] != '0') {
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
}elseif(isset($_GET['no_mesin']) && $_GET['nourut'] == '0'){
    $mesin = $_GET['no_mesin'];  // Mendapatkan pilihan mesin dari dropdown

    // Query SQL untuk mengambil data berdasarkan no_mesin
    $query = "SELECT * FROM db_finishing.tbl_schedule_new
              WHERE status = 'SCHEDULE'
              AND no_mesin = ?
              AND nourut = 0
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


if (isset($_POST['SimpanPerubahan'])) {
    $nourut             = $_POST['nourut'];
    $id                 = $_POST['id']; 
    $no_mesin_baru      = $_POST['no_mesin_baru'];
    $operation         = $_POST['operation'];
    $proses            = $_POST['proses'];
    $group_shift       = $_POST['group_shift'];
    $catatan           = $_POST['catatan'];

    for ($i = 0; $i < count($nourut); $i++) {
        $nouruts        = $nourut[$i];
        $no_mesin_barus = $no_mesin_baru[$i];
        $operations     = $operation[$i];
        $prosess        = $proses[$i];
        $group_shifts   = $group_shift[$i];
        $catatans       = $catatan[$i];
        $ids            = $id[$i];

        $update_query = "UPDATE db_finishing.tbl_schedule_new 
                            SET 
                                nourut = '$nouruts', 
                                no_mesin = '$no_mesin_barus', 
                                operation = '$operations', 
                                proses = '$prosess', 
                                group_shift = '$group_shifts',
                                catatan = '$catatans' 
                            WHERE 
                            id = '$ids'";

        $stmt = sqlsrv_query($con, $update_query);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));  
        }
    }
    sqlsrv_query($con, "DELETE FROM db_finishing.active_lock WHERE id_schedule = '$_GET[id]'") or die("Gagal hapus" . sqlsrv_errors());

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
}elseif (isset($_POST['btnKembali'])){
    sqlsrv_query($con, "DELETE FROM db_finishing.active_lock WHERE id_schedule = '$_GET[id]'") or die("Gagal hapus" . sqlsrv_errors());

    echo "<script>window.location.href = 'http://online.indotaichen.com/finishing2-new/schedule/index.php?p=LihatData';</script>";
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
        $(document).ready(function() {
            $('#datatables').dataTable({
                "sScrollY": "500px",
                "sScrollX": "100%",
                "bScrollCollapse": false,
                "bPaginate": false,
                "bJQueryUI": true,
                "bSort": false
            });
        })

        $(document).ready(function() {
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
                        <td style="text-align: center;">Lebar x Gramasi</td>
                        <td style="text-align: center;">Hanger</td>
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
                                <input type="number" name="nourut[]" value="<?= htmlspecialchars($row['nourut']) ?>" min="0" max="30" style="width: 35px;" />
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
                                            <?= $row_mesin['no_mesin']; ?> (<?= $row_mesin['singaktan_mesin']; ?> <?= $row_mesin['nomesin']; ?>)
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </td>
                            <td style="text-align: center;">
                                <select name="operation[]" id="operation" style="width: 100px;">
                                    <option value="">Pilih</option>
                                    <?php
                                    $qry1 = db2_exec($conn_db2, "SELECT
                                                                        DISTINCT 
                                                                        p.STEPNUMBER,
                                                                    --	p.GROUPSTEPNUMBER,
                                                                        TRIM(o.OPERATIONGROUPCODE) AS DEPT,
                                                                        CASE
                                                                            WHEN TRIM(w.PRODRESERVATIONLINKGROUPCODE) IS NOT NULL THEN TRIM(w.PRODRESERVATIONLINKGROUPCODE)
                                                                            ELSE TRIM(w.OPERATIONCODE)
                                                                        END AS OPERATIONCODE,	
                                                                        p.LONGDESCRIPTION
                                                                    FROM
                                                                        WORKCENTERANDOPERATTRIBUTES w
                                                                    LEFT JOIN OPERATION o ON o.CODE = w.OPERATIONCODE 
                                                                    LEFT JOIN PRODUCTIONDEMANDSTEP p ON p.OPERATIONCODE = o.CODE 
                                                                    WHERE
                                                                        NOT w.LONGDESCRIPTION = 'JANGAN DIPAKE'
                                                                        AND TRIM(o.OPERATIONGROUPCODE) = 'FIN'
                                                                        AND p.PRODUCTIONORDERCODE  = '$row[nokk]' 
                                                                        AND p.PRODUCTIONDEMANDCODE = '$row[nodemand]'
                                                                    ORDER BY 
                                                                        p.STEPNUMBER ASC");
                                    while ($r = db2_fetch_assoc($qry1)) {
                                        ?>
                                        <option value="<?php echo $r['OPERATIONCODE']; ?>" <?php if ($row['operation'] == $r['OPERATIONCODE']) { echo "SELECTED"; } ?>><?php echo $r['OPERATIONCODE']; ?> <?php echo $r['LONGDESCRIPTION']; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td style="text-align: center;">
                                <select name="proses[]" id="proses" style="width: 150px;" >
                                    <option value="">Pilih</option>
                                    <?php
                                    $qry1 = sqlsrv_query($con, "SELECT proses, jns FROM db_finishing.tbl_proses ORDER BY id ASC");

                                    if ($qry1 === false) {
                                        die(print_r(sqlsrv_errors(), true));
                                    }
                                    while ($r = sqlsrv_fetch_array($qry1, SQLSRV_FETCH_ASSOC)) {
                                        $proses_value = htmlspecialchars($r['proses'] . " (" . $r['jns'] . ")");
                                        $selected = ($row['proses'] === $proses_value) ? "selected" : "";
                                    ?>
                                        <option value="<?= $proses_value; ?>" <?= $selected; ?>>
                                            <?= $proses_value; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td style="text-align: center;">
                                <select name="group_shift[]" class="form-control select2" >
                                    <option value="">Pilih</option>
                                    <option value="A" <?php if ("A" == $row['group_shift']) {
                                                            echo "SELECTED";
                                                        } ?>>A</option>
                                    <option value="B" <?php if ("B" == $row['group_shift']) {
                                                            echo "SELECTED";
                                                        } ?>>B</option>
                                    <option value="C" <?php if ("C" == $row['group_shift']) {
                                                            echo "SELECTED";
                                                        } ?>>C</option>
                                </select>
                            </td>
                            <td style="text-align: center;">
                                <textarea name="catatan[]" cols="10" rows="1" id="catatan"><?= $row['catatan']; ?></textarea>
                            </td>
                            <td style="text-align: center;"><?= htmlspecialchars($row['lebar'].' x '. $row['gramasi']); ?></td>
                            <?php
                             $hanger = db2_exec($conn_db2, "SELECT TRIM(SUBCODE02)||'-' || TRIM(SUBCODE03) AS HANGER FROM PRODUCTIONDEMAND p WHERE p.CODE = '$row[nodemand]'");
                             $resultHanger = db2_fetch_assoc($hanger)
                            ?>
                            <td style="text-align: center;"><?= htmlspecialchars($resultHanger['HANGER']) ?></td>
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
            <button class="art-button" id="SimpanPerubahan" name="SimpanPerubahan" style="background-color: #ff004c; color: #ffffff;" type="submit">Simpan Perubahan</button>
            <input type="submit" name="btnKembali" id="btnKembali" value="Kembali" class="art-button" />
        </form>
    <?php else: ?>
        <p>No data available. Please select a machine.</p>
    <?php endif; ?>

</body>

</html>