<?php
    session_start();  // Memulai sesi

    if (empty($_SESSION['usr'])) {
        echo "<script>alert('Silahkan login terlebih dahulu!'); window.location = '../login.php'</script>";
        exit;
    }

    include('../koneksi.php');

    $id_schedule = $_GET['id'] ?? null;
    $no_mesin  = $_GET['no_mesin'] ?? null;

    if ($id_schedule !== null && $no_mesin !== null) {
        $check_activeLock = sqlsrv_query($con, "SELECT * FROM db_finishing.active_lock WHERE id_schedule = ?", [$id_schedule]);
        if ($check_activeLock === false) {
        } else {
            $dataMain_activeLock = sqlsrv_fetch_array($check_activeLock, SQLSRV_FETCH_ASSOC);
            if (empty($dataMain_activeLock)) {
                $insertMain_activeLock = "INSERT INTO db_finishing.active_lock (user_lock, ipaddress, creationdatetime, id_schedule, no_mesin)
                                        VALUES (?, ?, GETDATE(), ?, ?)";
                $exec_activeLock = sqlsrv_query($con, $insertMain_activeLock, [$_SESSION['usr'], $_SERVER['REMOTE_ADDR'], $id_schedule, $no_mesin]);
                if ($exec_activeLock === false) {
                    die("Gagal insert active lock: " . print_r(sqlsrv_errors(), true));
                }
            }
        }
    }

    $data  = [];
    $mesin = $_GET['no_mesin'] ?? '';
    $nourut = $_GET['nourut'] ?? null;

    if ($mesin !== '') {
        if ($nourut === '0') {
            $whereNourut = "AND nourut = 0";
        } else {
            $whereNourut = "AND nourut <> 0";
        }

        $query = "SELECT * FROM db_finishing.tbl_schedule_new
                WHERE status = 'SCHEDULE'
                    AND no_mesin = ?
                    $whereNourut
                    AND NOT EXISTS (
                        SELECT 1 FROM db_finishing.tbl_produksi b
                        WHERE b.nokk = db_finishing.tbl_schedule_new.nokk
                        AND b.demandno = db_finishing.tbl_schedule_new.nodemand
                        AND b.no_mesin = db_finishing.tbl_schedule_new.no_mesin
                        AND b.nama_mesin = db_finishing.tbl_schedule_new.operation
                    )
                ORDER BY nourut ASC";

        $result = sqlsrv_query($con, $query, [$mesin]);
        if ($result === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $data[] = $row;
        }
    }

    if (isset($_POST['json_data'])) {
        $rows = json_decode($_POST['json_data'], true);
        if (!is_array($rows)) {
            die("Data tidak valid (json_data).");
        }

        foreach ($rows as $row) {
            $id_row = $row['id'] ?? null;
            if ($id_row === null) continue;

            $update_query = "UPDATE db_finishing.tbl_schedule_new 
                                SET 
                                    nourut = ?, 
                                    no_mesin = ?, 
                                    operation = ?, 
                                    proses = ?, 
                                    group_shift = ?,
                                    catatan = ?,
                                    qty_order = ?,
                                    qty_order_yd = ?,
                                    roll = ?
                                WHERE id = ?";
            $params = [
                $row['nourut'] ?? null,
                $row['no_mesin_baru'] ?? null,
                $row['operation'] ?? null,
                $row['proses'] ?? null,
                $row['group_shift'] ?? null,
                $row['catatan'] ?? null,
                $row['qty_order'] ?? null,
                $row['qty_order_yd'] ?? null,
                $row['rol'] ?? null,
                $id_row
            ];
            $stmt = sqlsrv_query($con, $update_query, $params);
            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }
        }

        if ($id_schedule !== null) {
            sqlsrv_query($con, "DELETE FROM db_finishing.active_lock WHERE id_schedule = ?", [$id_schedule]);
        }

        echo "<script>
                swal({
                    title: 'Data Terupdate',
                    text: 'Klik Ok untuk input data kembali',
                    type: 'success',
                }).then(function() {
                    window.location.href = 'http://online.indotaichen.com/finishing2-new/schedule/index.php?p=LihatData';
                });
            </script>";
        exit;
    } elseif (isset($_POST['btnKembali'])) {
        if ($id_schedule !== null) {
            sqlsrv_query($con, "DELETE FROM db_finishing.active_lock WHERE id_schedule = ?", [$id_schedule]);
        }
        echo "<script>window.location.href = 'http://online.indotaichen.com/finishing2-new/schedule/index.php?p=LihatData';</script>";
        exit;
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

                $('#datatables_rangkuman').dataTable({
                    "sScrollY": "100px",
                    "sScrollX": "100%",
                    "bScrollCollapse": false,
                    "bPaginate": false,
                    "bJQueryUI": true,
                    "bSort": false
                });
            });
        </script>
    </head>
    <body>
        <!-- Tabel untuk menampilkan data -->
        <?php if (!empty($data)): ?>
            <form method="POST" action="" id="scheduleForm">
                <input type="hidden" name="json_data" id="json_data">
                <table width="100%" border="1" id="datatables" class="display">
                    <thead>
                        <tr>
                            <td style="text-align: center;">Nomor Uruttt</td>
                            <td style="text-align: center;">No Mesin</td>
                            <td style="text-align: center;">Operation</td>
                            <td style="text-align: center;">Proses</td>
                            <td style="text-align: center;">Group Shift</td>
                            <td style="text-align: center;">Catatan</td>
                            <td style="text-align: center;">Quantity (Kg)</td>
                            <td style="text-align: center;">Panjang (Yard)</td>
                            <td style="text-align: center;">Roll</td>
                            <td style="text-align: center;">Lebar x Gramasi</td>
                            <td style="text-align: center;">Hanger</td>
                            <td style="text-align: center;">No KK</td>
                            <td style="text-align: center;">No. Demand</td>
                            <td style="text-align: center;">No Order</td>
                            <td style="text-align: center;">Delivery Actual</td>
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
                                        while ($row_mesin = sqlsrv_fetch_array($q_mesin, SQLSRV_FETCH_ASSOC)):
                                        ?>
                                            <option value="<?= $row_mesin['no_mesin']; ?>" <?php if ($row_mesin['no_mesin'] == ($_GET['no_mesin'] ?? '')) echo 'SELECTED'; ?>>
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
                                                        AND p.PRODUCTIONORDERCODE  = '".$row['nokk']."' 
                                                        AND p.PRODUCTIONDEMANDCODE = '".$row['nodemand']."'
                                                    ORDER BY 
                                                        p.STEPNUMBER ASC");
                                            while ($r = db2_fetch_assoc($qry1)) {
                                                $sel = ($row['operation'] == $r['OPERATIONCODE']) ? "SELECTED" : "";
                                                echo "<option value=\"{$r['OPERATIONCODE']}\" $sel>{$r['OPERATIONCODE']} {$r['LONGDESCRIPTION']}</option>";
                                            }
                                        ?>
                                    </select>
                                </td>
                                <td style="text-align: center;">
                                    <select name="proses[]" id="proses" style="width: 150px;" >
                                        <option value="">Pilih</option>
                                        <?php
                                            $qry1 = sqlsrv_query($con, "SELECT proses, jns FROM db_finishing.tbl_proses ORDER BY id ASC");
                                            while ($r = sqlsrv_fetch_array($qry1, SQLSRV_FETCH_ASSOC)) {
                                                $proses_value = htmlspecialchars($r['proses'] . " (" . $r['jns'] . ")");
                                                $selected = ($row['proses'] === $proses_value) ? "selected" : "";
                                                echo "<option value=\"{$proses_value}\" {$selected}>{$proses_value}</option>";
                                            }
                                        ?>
                                    </select>
                                </td>
                                <td style="text-align: center;">
                                    <select name="group_shift[]" class="form-control select2" >
                                        <option value="">Pilih</option>
                                        <option value="A" <?php if ("A" == $row['group_shift']) echo "SELECTED"; ?>>A</option>
                                        <option value="B" <?php if ("B" == $row['group_shift']) echo "SELECTED"; ?>>B</option>
                                        <option value="C" <?php if ("C" == $row['group_shift']) echo "SELECTED"; ?>>C</option>
                                    </select>
                                </td>
                                <td style="text-align: center;">
                                    <textarea name="catatan[]" cols="10" rows="1" id="catatan"><?= htmlspecialchars($row['catatan']) ?></textarea>
                                </td>
                                <td style="text-align: center;">
                                    <input type="text" name="qty_order[]" value="<?= htmlspecialchars($row['qty_order']) ?>" style="width: 60px;" />
                                </td>
                                <td style="text-align: center;">
                                    <input type="text" name="qty_order_yd[]" value="<?= htmlspecialchars($row['qty_order_yd']) ?>" style="width: 60px;" />
                                </td>
                                <td style="text-align: center;">
                                    <input type="text" name="rol[]" value="<?= htmlspecialchars($row['roll']) ?>" style="width: 60px;" />
                                </td>
                                <td style="text-align: center;"><?= htmlspecialchars($row['lebar'].' x '. $row['gramasi']); ?></td>
                                <?php
                                    $hanger = db2_exec($conn_db2, "SELECT TRIM(SUBCODE02)||'-' || TRIM(SUBCODE03) AS HANGER, ORIGDLVSALORDLINESALORDERCODE, ORIGDLVSALORDERLINEORDERLINE FROM PRODUCTIONDEMAND p WHERE p.CODE = '".$row['nodemand']."'");
                                    $resultHanger = db2_fetch_assoc($hanger);
                                ?>
                                <td style="text-align: center;"><?= htmlspecialchars($resultHanger['HANGER'] ?? '') ?></td>
                                <td style="text-align: center;"><?= htmlspecialchars($row['nokk']) ?></td>
                                <td style="text-align: center;"><?= htmlspecialchars($row['nodemand']) ?></td>
                                <td style="text-align: center;"><?= htmlspecialchars($row['no_order']) ?></td>
                                <?php
                                    $q_actual_delivery = db2_exec($conn_db2, "SELECT
                                                                                    COALESCE(s2.CONFIRMEDDELIVERYDATE, s.CONFIRMEDDUEDATE) AS ACTUAL_DELIVERY
                                                                                FROM
                                                                                    SALESORDER s 
                                                                                LEFT JOIN SALESORDERDELIVERY s2 ON s2.SALESORDERLINESALESORDERCODE = s.CODE AND s2.SALORDLINESALORDERCOMPANYCODE = s.COMPANYCODE AND s2.SALORDLINESALORDERCOUNTERCODE = s.COUNTERCODE 
                                                                                WHERE
                                                                                    s2.SALESORDERLINESALESORDERCODE = '".($resultHanger['ORIGDLVSALORDLINESALORDERCODE'] ?? '')."'
                                                                                    AND s2.SALESORDERLINEORDERLINE = '".($resultHanger['ORIGDLVSALORDERLINEORDERLINE'] ?? '')."'");
                                    $row_actual_delivery = db2_fetch_assoc($q_actual_delivery);
                                ?>
                                <td style="text-align: center;"><?= htmlspecialchars($row_actual_delivery['ACTUAL_DELIVERY'] ?? '') ?></td>
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

            <script>
                (function(){
                    document.getElementById("SimpanPerubahan").addEventListener("click", function(e) {
                        e.preventDefault();

                        const rows = document.querySelectorAll("#datatables tbody tr");
                        const data = [];

                        rows.forEach(function(row) {
                            const getVal = (selector) => {
                                const el = row.querySelector(selector);
                                if (!el) return "";
                                return (el.value !== undefined) ? el.value : "";
                            };

                            let obj = {
                                nourut: getVal("input[name='nourut[]']"),
                                id: getVal("input[name='id[]']"),
                                no_mesin_baru: getVal("select[name='no_mesin_baru[]']"),
                                operation: getVal("select[name='operation[]']"),
                                proses: getVal("select[name='proses[]']"),
                                group_shift: getVal("select[name='group_shift[]']"),
                                catatan: getVal("textarea[name='catatan[]']"),
                                qty_order: getVal("input[name='qty_order[]']"),
                                qty_order_yd: getVal("input[name='qty_order_yd[]']"),
                                rol: getVal("input[name='rol[]']")
                            };
                            data.push(obj);
                        });

                        const jsonInput = document.getElementById("json_data");
                        jsonInput.value = JSON.stringify(data);

                        // Disable semua input asli supaya tidak dikirim
                        rows.forEach(function(row) {
                            row.querySelectorAll("input, select, textarea").forEach(function(el) {
                                el.disabled = true;
                            });
                        });

                        document.getElementById("scheduleForm").submit();
                    });
                })();
            </script>
        <?php else: ?>
            <p>No data available. Please select a machine.</p>
        <?php endif; ?>
    </body>
</html>