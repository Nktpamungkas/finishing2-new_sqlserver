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

    // Data Dari POST
    $tglawal   = $_POST['awal'];
    $tglakhir  = $_POST['akhir'];
    $kode_obat = $_POST['kode_obat'];
    $nama_obat = $_POST['nama_obat'];

    $kode_obat_value = explode('-', $kode_obat);

    // Deklarasi Awal
    $header_nama_barang = null;
    $header_ukuran      = "0 Kg";
    $data               = [];

    // $data = [
    //     [
    //         'nama_supplier'        => 'nama_supplier',
    //         'stock_awal'           => 'stock_awal',
    //         'tanggal_masuk'        => 'tanggal masuk',
    //         'jumlah_masuk'         => 'jumlah masuk',
    //         'tanggal_keluar'       => 'tanggal keluar',
    //         'jumlah_keluar'        => 'jumlah keluar',
    //         'jumlah_keluar'        => 'jumlah keluar',
    //         'stock_akhir'          => 'stock akhir',
    //         'keterangan'           => 'keterangan',
    //         'tanda_tangan_pemakai' => 'tanda tangan pemakai',
    //     ],
    //     [
    //         'nama_supplier'        => 'nama_supplier',
    //         'stock_awal'           => 'stock_awal',
    //         'tanggal_masuk'        => 'tanggal masuk',
    //         'jumlah_masuk'         => 'jumlah masuk',
    //         'tanggal_keluar'       => 'tanggal keluar',
    //         'jumlah_keluar'        => 'jumlah keluar',
    //         'jumlah_keluar'        => 'jumlah keluar',
    //         'stock_akhir'          => 'stock akhir',
    //         'keterangan'           => 'keterangan',
    //         'tanda_tangan_pemakai' => 'tanda tangan pemakai',
    //     ],
    //     [
    //         'nama_supplier'        => 'nama_supplier',
    //         'stock_awal'           => 'stock_awal',
    //         'tanggal_masuk'        => 'tanggal masuk',
    //         'jumlah_masuk'         => 'jumlah masuk',
    //         'tanggal_keluar'       => 'tanggal keluar',
    //         'jumlah_keluar'        => 'jumlah keluar',
    //         'jumlah_keluar'        => 'jumlah keluar',
    //         'stock_akhir'          => 'stock akhir',
    //         'keterangan'           => 'keterangan',
    //         'tanda_tangan_pemakai' => 'tanda tangan pemakai',
    //     ],
    // ];

    // Execution query header
    $query_header       = "";
    $exec_query_header  = db2_exec($conn1, $query_header);
    $fetch_query_header = db2_fetch_assoc($exec_query_header);

    // Execution query header
    $query_data       = "";
    $exec_query_data  = db2_exec($conn1, $query_data);
    $fetch_query_data = db2_fetch_assoc($exec_query_data);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Stok Obat Finishing</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
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
                <td align="center" style="width: 15%;">Nama Supplier</td>
                <td align="center" style="width: 10%;">Stock Awal</td>
                <td align="center" style="width: 12%;">Tanggal Masuk</td>
                <td align="center" style="width: 10%;">Jumlah</td>
                <td align="center" style="width: 12%;">Tanggal Keluar</td>
                <td align="center" style="width: 10%;">Jumlah</td>
                <td align="center" style="width: 10%;">Stock Akhir</td>
                <td align="center" style="width: 15%;">Keterangan</td>
                <td align="center" style="width: 12%;">Tanda Tangan Pemakai</td>
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