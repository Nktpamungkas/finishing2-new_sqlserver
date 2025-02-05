<?php

    // Koneksi SQL Server
    include '../../koneksi.php';

    // Koneksi DB2
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

    // Data Dari POST
    $tglawal   = $_POST['awal'];
    $tglakhir  = $_POST['akhir'];
    $kode_obat = $_POST['kode_obat'];
    $nama_obat = $_POST['nama_obat'];

    $kode_obat_value = explode('-', $kode_obat);
    $DECOSUBCODE01   = $kode_obat_value[0];
    $DECOSUBCODE02   = $kode_obat_value[1];
    $DECOSUBCODE03   = $kode_obat_value[2];

    // Deklarasi Awal
    $stock_awal    = 0;
    $stock_akhir   = 0;
    $stock_awal_db = 0;
    $total_masuk   = 0;
    $total_keluar  = 0;

    $header_nama_barang = null;
    $header_ukuran      = "0 Kg";
    $data               = [];

    // Stock awal hasil correction tanggal 15 januari 2025
    $query_stock_awal = sqlsrv_query($con, "SELECT stock_awal
    FROM db_finishing.tbl_obat
    WHERE kode='$kode_obat'");

    $row_query_stock_awal = sqlsrv_fetch_array($query_stock_awal, SQLSRV_FETCH_ASSOC);

    if ($row_query_stock_awal) {
        $stock_awal_db = $row_query_stock_awal['stock_awal'];
    }

    // Total Masuk
    $query_masuk = "SELECT SUM(USERPRIMARYQUANTITY) AS TOTAL
    FROM STOCKTRANSACTION
    WHERE (TEMPLATECODE ='304')
    AND LOGICALWAREHOUSECODE ='M512'
    AND DECOSUBCODE01 ='$DECOSUBCODE01'
    AND DECOSUBCODE02 ='$DECOSUBCODE02'
    AND DECOSUBCODE03 ='$DECOSUBCODE03'
    AND TRANSACTIONDATE BETWEEN '2025-01-15' AND '$tglawal'
    AND CREATIONDATETIME > '2025-01-15 13:00:00'";

    $exec_query_masuk  = db2_exec($conn1, $query_masuk);
    $fetch_query_masuk = db2_fetch_assoc($exec_query_masuk);

    if ($fetch_query_masuk) {
        $total_masuk = (float) $fetch_query_masuk['TOTAL'];
    }

    // Total Keluar
    $query_keluar = "SELECT SUM(USERPRIMARYQUANTITY) AS TOTAL
    FROM STOCKTRANSACTION
    WHERE (TEMPLATECODE ='120')
    AND LOGICALWAREHOUSECODE ='M512'
    AND DECOSUBCODE01 ='$DECOSUBCODE01'
    AND DECOSUBCODE02 ='$DECOSUBCODE02'
    AND DECOSUBCODE03 ='$DECOSUBCODE03'
    AND TRANSACTIONDATE BETWEEN '2025-01-15' AND '$tglawal'
    AND CREATIONDATETIME > '2025-01-15 13:00:00'";

    $exec_query_keluar  = db2_exec($conn1, $query_keluar);
    $fetch_query_keluar = db2_fetch_assoc($exec_query_keluar);

    if ($fetch_query_keluar) {
        $total_keluar = (float) ($fetch_query_keluar['TOTAL'] / 1000);
    }

    // Stock awal kalkulasi
    if ($tglawal == '2025-01-15') {
        $total_masuk  = 0;
        $total_keluar = 0;
    }

    $stock_awal = ($stock_awal_db + $total_masuk) - $total_keluar;

    $informasi = 'Informasi akumulasi stock awal dari 2025-01-15 - ' . $tglawal . ', stock awal db : ' . $stock_awal_db .
        ' total masuk: ' . $total_masuk .
        ' total keluar: ' . $total_keluar .
        ' stock awal: ' . $stock_awal;

    // Kalau mau makesure kalkulasi stock awal
    // echo $informasi;

    // List data
    $query_data = "SELECT * FROM STOCKTRANSACTION WHERE
        (TEMPLATECODE ='304'
        OR TEMPLATECODE ='120')
        AND LOGICALWAREHOUSECODE ='M512'
        AND DECOSUBCODE01 ='$DECOSUBCODE01'
        AND DECOSUBCODE02 ='$DECOSUBCODE02'
        AND DECOSUBCODE03 ='$DECOSUBCODE03'
        AND TRANSACTIONDATE BETWEEN '$tglawal' AND '$tglakhir'
        AND CREATIONDATETIME > '2025-01-15 13:00:00'
        ORDER BY TRANSACTIONDATE ASC";

    $exec_query_data = db2_exec($conn1, $query_data);

    while ($row = db2_fetch_assoc($exec_query_data)) {
        $nama_supplier        = '';
        $tanggal_masuk        = '';
        $jumlah_masuk         = '';
        $tanggal_keluar       = '';
        $jumlah_keluar        = '';
        $keterangan           = '';
        $tanda_tangan_pemakai = '';

        // Tanggal Masuk , Tanggal Keluar, Jumlah Masuk, Jumlah Keluar
        if ($row['TEMPLATECODE'] === '304') {
            $tanggal_masuk = $row['TRANSACTIONDATE'];
            $jumlah_masuk  = (float) $row['USERPRIMARYQUANTITY'];

            $stock_akhir = $stock_awal + $jumlah_masuk;
        } else if ($row['TEMPLATECODE'] === '120') {
            $tanggal_keluar = $row['TRANSACTIONDATE'];
            $jumlah_keluar  = (float) ($row['USERPRIMARYQUANTITY'] / 1000);

            $stock_akhir = $stock_awal - $jumlah_keluar;
        }

        // Keterangan
        $keterangan = $row['ORDERCODE'];

        // Array Data
        $data[] = [
            'nama_supplier'        => $nama_supplier,
            'stock_awal'           => $stock_awal,
            'tanggal_masuk'        => $tanggal_masuk,
            'jumlah_masuk'         => $jumlah_masuk,
            'tanggal_keluar'       => $tanggal_keluar,
            'jumlah_keluar'        => $jumlah_keluar,
            'stock_akhir'          => $stock_akhir,
            'keterangan'           => $keterangan,
            'tanda_tangan_pemakai' => $tanda_tangan_pemakai,
        ];

        $stock_awal = $stock_akhir;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Stok Obat Finishing</title>
    <style>
        @page {
            margin: 0;
            size: auto;
        }

        @media print {
            body {
                margin: 1cm;
            }
        }
    </style>
</head>
<body>
    <table border="1" width="100%" style="border-collapse: collapse;">
        <tr>
            <td width="10%" align="center">
                <img src="../../images/ITTI_Logo Option_Logogram ITTI.png" width="70">
            </td>
            <td width="60%" align="center">
                <strong style="font-size:x-large;">KARTU STOK</strong>
            </td>
            <td width="30%">
                <table>
                    <tr>
                        <td>No. Form</td>
                        <td>:</td>
                        <td>19-08</td>
                    </tr>
                    <tr>
                        <td>No. Revisi</td>
                        <td>:</td>
                        <td>01</td>
                    </tr>
                    <tr>
                        <td>Tgl. Terbit</td>
                        <td>:</td>
                        <td>27 Februari 2006</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td>Nama Barang</td>
            <td>:</td>
            <td>
                <?php echo $nama_obat ?>
            </td>
        </tr>
        <tr>
            <td>Type / Ukuran</td>
            <td>:</td>
            <td>
                <?php echo $kode_obat ?>
            </td>
        </tr>
    </table>
    <br>
    <table border="1" width="100%" style="border-collapse: collapse;">
        <thead>
            <tr>
                <td align="center" style="width: 7%; font-weight: bold;">Nama Supplier</td>
                <td align="center" style="width: 10%; font-weight: bold;">Stock Awal</td>
                <td align="center" style="width: 12%; font-weight: bold;">Tanggal Masuk</td>
                <td align="center" style="width: 10%; font-weight: bold;">Jumlah</td>
                <td align="center" style="width: 12%; font-weight: bold;">Tanggal Keluar</td>
                <td align="center" style="width: 10%; font-weight: bold;">Jumlah</td>
                <td align="center" style="width: 10%; font-weight: bold;">Stock Akhir</td>
                <td align="center" style="width: 15%; font-weight: bold;">Keterangan</td>
                <td align="center" style="width: 10%; font-weight: bold;">Tanda Tangan Pemakai</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td align="center"><?php echo $row['nama_supplier'] ?></td>
                    <td align="center"><?php echo $row['stock_awal'] ?></td>
                    <td align="center"><?php echo $row['tanggal_masuk'] ?></td>
                    <td align="center"><?php echo $row['jumlah_masuk'] ?></td>
                    <td align="center"><?php echo $row['tanggal_keluar'] ?></td>
                    <td align="center"><?php echo $row['jumlah_keluar'] ?></td>
                    <td align="center"><?php echo $row['stock_akhir'] ?></td>
                    <td align="center"><?php echo $row['keterangan'] ?></td>
                    <td align="center"><?php echo $row['tanda_tangan_pemakai'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>