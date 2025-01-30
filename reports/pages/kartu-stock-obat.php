<?php
    $hostname = "10.0.0.21";
                             // $database = "NOWTEST"; // SERVER NOW 20
    $database    = "NOWPRD"; // SERVER NOW 22
    $user        = "db2admin";
    $passworddb2 = "Sunkam@24809";
    $port        = "25000";
    $conn_string = "DRIVER={IBM ODBC DB2 DRIVER}; HOSTNAME=$hostname; PORT=$port; PROTOCOL=TCPIP; UID=$user; PWD=$passworddb2; DATABASE=$database;";
    // $conn1 = db2_pconnect($conn_string,'', '');
    $conn1 = db2_connect($conn_string, '', '');
    ini_set("error_reporting", 0);

    $tglawal   = $_POST['awal'];
    $tglakhir  = $_POST['akhir'];
    $nama_obat = $_POST['nama_obat'];

?>
<?php
    $query = "SELECT
                s.TRANSACTIONNUMBER,
                s.TRANSACTIONDATE AS TGL,
                s.TRANSACTIONTIME AS WAKTU,
                p.LONGDESCRIPTION AS NAMA_BARANG,
                CASE
                    WHEN TRIM(s.BASEPRIMARYUOMCODE) = 'm' OR TRIM(s.BASEPRIMARYUOMCODE) = 'un' THEN floor(SUM(s.BASEPRIMARYQUANTITY))
                    ELSE floor(SUM(s.USERPRIMARYQUANTITY))
                END AS QTY,
                CASE
                    WHEN TRIM(s.BASEPRIMARYUOMCODE) = 'm' THEN s.BASEPRIMARYUOMCODE
                    ELSE s.USERPRIMARYUOMCODE
                END AS SATUAN,
                CASE
                    WHEN s.TEMPLATECODE = '101' THEN 'MASUK 101'
                    WHEN s.TEMPLATECODE = 'OPN' THEN 'MASUK OPN'
                    WHEN s.TEMPLATECODE = 'QCT' THEN 'MASUK QCT'
                    WHEN s.TEMPLATECODE = '201' THEN 'KELUAR 201'
                    WHEN s.TEMPLATECODE = '098' THEN 'KELUAR 098'
                END AS TRANSAKSI,
                CASE
                    WHEN s.ORDERCODE IS NULL THEN s.TEMPLATECODE
                    ELSE s.TEMPLATECODE || ' - ' || s.ORDERCODE
                END	AS ORDERCODE_TEMPLATE
            FROM
                STOCKTRANSACTION s
            LEFT JOIN PRODUCT p ON p.ITEMTYPECODE = s.ITEMTYPECODE
                                AND p.SUBCODE01 = s.DECOSUBCODE01
                                AND p.SUBCODE02 = s.DECOSUBCODE02
                                AND p.SUBCODE03 = s.DECOSUBCODE03
                                AND p.SUBCODE04 = s.DECOSUBCODE04
                                AND p.SUBCODE05 = s.DECOSUBCODE05
                                AND p.SUBCODE06 = s.DECOSUBCODE06
            WHERE
                s.ITEMTYPECODE ='SPR'
                AND s.DECOSUBCODE01 = 'DIT'
                AND TRIM(s.DECOSUBCODE01) || '-' ||
                    TRIM(s.DECOSUBCODE02) || '-' ||
                    TRIM(s.DECOSUBCODE03) || '-' ||
                    TRIM(s.DECOSUBCODE04) || '-' ||
                    TRIM(s.DECOSUBCODE05) || '-' ||
                    TRIM(s.DECOSUBCODE06)  = '$kode_barang'
                AND (s.TEMPLATECODE = '101' OR s.TEMPLATECODE = 'OPN' OR s.TEMPLATECODE = 'QCT' OR s.TEMPLATECODE = '201' OR s.TEMPLATECODE = '098')
                AND (s.TRANSACTIONDATE) BETWEEN '$date1' AND '$date2'
            GROUP BY
                s.TRANSACTIONNUMBER,
                s.TRANSACTIONDATE,
                s.TRANSACTIONTIME,
                p.LONGDESCRIPTION,
                s.USERPRIMARYUOMCODE,
                s.BASEPRIMARYQUANTITY,
                s.BASEPRIMARYUOMCODE,
                s.TEMPLATECODE,
                s.ORDERCODE
            ORDER BY
                s.TRANSACTIONNUMBER
                -- s.TRANSACTIONDATE,
                -- s.TRANSACTIONTIME
            ASC";
    $q_stock_transaction         = db2_exec($conn1, $query);
    $q_stock_transaction_history = db2_exec($conn1, $query);
?>
<?php
    $d_stock_transaction = db2_fetch_assoc($q_stock_transaction);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Stok</title>
</head>

<body>
    <table border="1" width="100%" style="border-collapse: collapse;">
        <tr>
            <td width="10%" align="center">
                <img src="<?php echo base_url(); ?>assets\images\ITTI_Logo Option_Logogram ITTI.png" width="70">
            </td>
            <td width="60%" align="center">
                <strong style="font-size:x-large;">KARTU STOK</strong>
            </td>
            <td width="30%">
                <table>
                    <tr>
                        <td>No. Form</td>
                        <td>:</td>
                        <td>19-08B</td>
                    </tr>
                    <tr>
                        <td>No. Revisi</td>
                        <td>:</td>
                        <td>01</td>
                    </tr>
                    <tr>
                        <td>Tgl. Terbit</td>
                        <td>:</td>
                        <td>29-12-18</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td>Nama barang</td>
            <td>:</td>
            <td><?php echo $d_stock_transaction['NAMA_BARANG']; ?></td>
        </tr>
        <tr>
            <td>Satuan</td>
            <td>:</td>
            <td><?php echo $d_stock_transaction['SATUAN']; ?></td>
        </tr>
        <tr>
            <td>Stock Minimum</td>
            <td>:</td>
            <?php
                $q_min_stok = db2_exec($conn1, "SELECT * FROM ITEMWAREHOUSELINK WHERE ITEMTYPECODE ='SPR'
                                                                                        AND SUBCODE01 = 'DIT'
                                                                                        AND TRIM(SUBCODE01) || '-' ||
                                                                                            TRIM(SUBCODE02) || '-' ||
                                                                                            TRIM(SUBCODE03) || '-' ||
                                                                                            TRIM(SUBCODE04) || '-' ||
                                                                                            TRIM(SUBCODE05) || '-' ||
                                                                                            TRIM(SUBCODE06)  = '$kode_barang'
                                                                                    AND LOGICALWAREHOUSECODE = 'M231'");
                $row_min_stok = db2_fetch_assoc($q_min_stok);
            ?>
            <td><?php echo number_format($row_min_stok['SAFETYSTOCK'], 0); ?></td>
        </tr>
        <tr>
            <td>Kelompok</td>
            <td>:</td>
            <td>...</td>
        </tr>
    </table>
    <br>
    <table border="1" width="100%" style="border-collapse: collapse;">
        <thead>
            <tr>
                <td align="center">Tgl.</td>
                <td align="center">Stock Awal</td>
                <td align="center">Quantity Penerimaan</td>
                <td align="center">Quantity Pengeluaran</td>
                <td align="center">Stock Akhir</td>
                <td align="center">Surat Jalan/Bon Pengambilan barang</td>
                <td align="center">Nama</td>
                <td align="center">Paraf</td>
                <td align="center">Keterangan</td>
            </tr>
        </thead>
        <tbody>
            <?php
                $tanggal_hasil = date("Y-m-d", strtotime($date1 . " -1 day"));
                $q_qtyawal     = db2_exec($conn1, "SELECT
                                                    SUM(QTY_AWAL) AS QTYAWAL
                                                FROM
                                                (SELECT
                                                    CASE
                                                        WHEN s.TEMPLATECODE = '101' OR s.TEMPLATECODE = 'OPN' OR s.TEMPLATECODE = 'QCT' THEN
                                                            CASE
                                                                WHEN TRIM(s.BASEPRIMARYUOMCODE) = 'm' OR TRIM(s.BASEPRIMARYUOMCODE) = 'un' THEN floor(SUM(s.BASEPRIMARYQUANTITY))
                                                                ELSE floor(SUM(s.USERPRIMARYQUANTITY))
                                                            END
                                                        WHEN s.TEMPLATECODE = '201' OR s.TEMPLATECODE = '098' THEN -
                                                            CASE
                                                                WHEN TRIM(s.BASEPRIMARYUOMCODE) = 'm' THEN floor(SUM(s.BASEPRIMARYQUANTITY))
                                                                ELSE floor(SUM(s.USERPRIMARYQUANTITY))
                                                            END
                                                    END AS QTY_AWAL
                                                FROM
                                                    STOCKTRANSACTION s
                                                LEFT JOIN PRODUCT p ON p.ITEMTYPECODE = s.ITEMTYPECODE
                                                                    AND p.SUBCODE01 = s.DECOSUBCODE01
                                                                    AND p.SUBCODE02 = s.DECOSUBCODE02
                                                                    AND p.SUBCODE03 = s.DECOSUBCODE03
                                                                    AND p.SUBCODE04 = s.DECOSUBCODE04
                                                                    AND p.SUBCODE05 = s.DECOSUBCODE05
                                                                    AND p.SUBCODE06 = s.DECOSUBCODE06
                                                WHERE
                                                    s.ITEMTYPECODE ='SPR'
                                                    AND s.DECOSUBCODE01 = 'DIT'
                                                    AND TRIM(s.DECOSUBCODE01) || '-' ||
                                                        TRIM(s.DECOSUBCODE02) || '-' ||
                                                        TRIM(s.DECOSUBCODE03) || '-' ||
                                                        TRIM(s.DECOSUBCODE04) || '-' ||
                                                        TRIM(s.DECOSUBCODE05) || '-' ||
                                                        TRIM(s.DECOSUBCODE06)  = '$kode_barang'
                                                    AND (s.TEMPLATECODE = '101' OR s.TEMPLATECODE = 'OPN' OR s.TEMPLATECODE = 'QCT' OR s.TEMPLATECODE = '201' OR s.TEMPLATECODE = '098')
                                                    AND (s.TRANSACTIONDATE) BETWEEN '2024-01-10' AND '$tanggal_hasil'
                                                GROUP BY
                                                    s.TEMPLATECODE,
                                                    s.BASEPRIMARYUOMCODE)");
                $row_qtyawal = db2_fetch_assoc($q_qtyawal);
            ?>
<?php $no = 1;while ($row_stock_transaction = db2_fetch_assoc($q_stock_transaction_history)): ?>
            <tr>
                <td align="center"><?php echo $row_stock_transaction['TGL']; ?></td> <!-- Tgl -->

                <td align="center">
                    <?php
                        if ($no == 1) {
                            // Pertama Kali Deklarasi Debit
                            if ($row_qtyawal['QTYAWAL']) {
                                echo $saldo = $row_qtyawal['QTYAWAL'];
                            } else {
                                echo $saldo = '';
                            }
                        } else {
                            echo number_format($saldo);
                        }
                    ?>
                </td> <!-- Stock Awal -->

                <td align="center">
                    <?php if (strpos($row_stock_transaction['TRANSAKSI'], 'MASUK') !== false): ?>
<?php
    echo $row_stock_transaction['QTY'];
    $saldo_masuk = $row_stock_transaction['QTY'];
?>
<?php endif; ?>
                </td> <!-- Quantity Penerimaan -->

                <td align="center">
                    <?php if (strpos($row_stock_transaction['TRANSAKSI'], 'KELUAR') !== false): ?>
<?php
    echo $row_stock_transaction['QTY'];
    $saldo_keluar = $row_stock_transaction['QTY'];
?>
<?php endif; ?>
                </td align="center"> <!-- Quantity Pengeluaran -->

                <td align="center">
                    <?php
                        if ($no == 1) {
                            // Pertama Kali Deklarasi Debit
                            if ($row_qtyawal['QTYAWAL']) {
                                if (strpos($row_stock_transaction['TRANSAKSI'], 'MASUK') !== false) {
                                    $debit = $saldo + $row_stock_transaction['QTY'];
                                    $saldo = $saldo + $row_stock_transaction['QTY'];
                                    echo number_format($saldo);
                                } elseif (strpos($row_stock_transaction['TRANSAKSI'], 'KELUAR') !== false) {
                                    $debit = $saldo - $row_stock_transaction['QTY'];
                                    $saldo = $saldo - $row_stock_transaction['QTY'];
                                    echo number_format($saldo);
                                }
                            } else {
                                $debit = $row_stock_transaction['QTY'];
                                $saldo = $row_stock_transaction['QTY'];
                                echo number_format($saldo);
                            }
                        } else {
                            if (strpos($row_stock_transaction['TRANSAKSI'], 'MASUK') !== false) {
                                // Jika ada STOK MASUK
                                $debit = $debit + $row_stock_transaction['QTY'];
                                $saldo = $saldo + $row_stock_transaction['QTY'];
                                echo number_format($saldo);
                            } elseif (strpos($row_stock_transaction['TRANSAKSI'], 'KELUAR') !== false) {
                                // Jika ada STOK KELUAR
                                $kredit = 0;
                                $kredit = $kredit + $row_stock_transaction['QTY'];
                                $saldo  = $saldo - $row_stock_transaction['QTY'];
                                echo number_format($saldo);
                            }
                        }
                    ?>
                </td> <!-- Stock Akhir -->

                <td align="center"><?php echo $row_stock_transaction['ORDERCODE_TEMPLATE']; ?></td> <!-- Surat Jalan/Bon Pengambilan barang -->
                <td align="center">&nbsp;</td> <!-- Nama -->
                <td align="center">&nbsp;</td> <!-- Paraf-->
                <td align="center"><?php echo $row_stock_transaction['TRANSACTIONNUMBER']; ?></td> <!-- Keterangan -->
            </tr>
            <?php $no++; ?>
<?php endwhile; ?>
        </tbody>
    </table>
</body>

</html>