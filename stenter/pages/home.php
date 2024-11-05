<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Home</title>
    <script>
    function roundToTwo(num) {
        return +(Math.round(num + "e+2") + "e-2");
    }

    function jumlah() {
        var lebar = document.forms['form1']['lebar'].value;
        var berat = document.forms['form1']['gramasi'].value;
        var netto = document.forms['form1']['qty'].value;
        var x, yard;
        x = ((parseInt(lebar)) * parseInt(berat)) / 43.056;
        x1 = (1000 / x);
        yard = x1 * parseFloat(netto);
        document.form1.qty2.value = roundToTwo(yard).toFixed(2);

    }

    function jumlah1() {
        var lebar1 = document.forms['form1']['h_lebar'].value;
        var berat1 = document.forms['form1']['h_gramasi'].value;
        var netto1 = document.forms['form1']['qty'].value;
        var x1, yard1;
        x1 = ((parseInt(lebar1)) * parseInt(berat1)) / 43.056;
        x2 = (1000 / x1);
        yard1 = x2 * parseFloat(netto1);
        document.form1.qty3.value = roundToTwo(yard1).toFixed(2);

    }

    $(document).ready(function() {
        $('#proses_in').change(function() {
            var jam_proses_in = document.getElementById('proses_in').value;
            if (jam_proses_in.substring(0, 2) >= 24) {
                alert("Waktu pada MULAI PROSES tidak boleh melebihi batas 1 hari.");
            }
        });

        $('#stop_mulai').change(function() {
            var jam_stop_mulai = document.getElementById('stop_mulai').value;
            if (jam_stop_mulai.substring(0, 2) >= 24) {
                alert("Waktu pada MULAI STOP MESIN 1 tidak boleh melebihi batas 1 hari.");
            }
        });

        $('#stop_mulai2').change(function() {
            var jam_stop_mulai2 = document.getElementById('stop_mulai2').value;
            if (jam_stop_mulai2.substring(0, 2) >= 24) {
                alert("Waktu pada MULAI STOP MESIN 2 tidak boleh melebihi batas 1 hari.");
            }
        });

        $('#stop_mulai3').change(function() {
            var jam_stop_mulai3 = document.getElementById('stop_mulai3').value;
            if (jam_stop_mulai3.substring(0, 2) >= 24) {
                alert("Waktu pada MULAI STOP MESIN 3 tidak boleh melebihi batas 1 hari.");
            }
        });


        $('#proses_out').change(function() {
            var jam_proses_out = document.getElementById('proses_out').value;
            if (jam_proses_out.substring(0, 2) >= 24) {
                alert("Waktu pada SELESAI PROSES tidak boleh melebihi batas 1 hari.");
            }
        });

        $('#stop_selesai').change(function() {
            var jam_stop_selesai = document.getElementById('stop_selesai').value;
            if (jam_stop_selesai.substring(0, 2) >= 24) {
                alert("Waktu pada SELESAI STOP MESIN 1 tidak boleh melebihi batas 1 hari.");
            }
        });

        $('#stop_selesai2').change(function() {
            var jam_stop_selesai2 = document.getElementById('stop_selesai2').value;
            if (jam_stop_selesai2.substring(0, 2) >= 24) {
                alert("Waktu pada SELESAI STOP MESIN 2 tidak boleh melebihi batas 1 hari.");
            }
        });

        $('#stop_selesai3').change(function() {
            var jam_stop_selesai3 = document.getElementById('stop_selesai3').value;
            if (jam_stop_selesai3.substring(0, 2) >= 24) {
                alert("Waktu pada SELESAI STOP MESIN 3 tidak boleh melebihi batas 1 hari.");
            }
        });

    });
    </script>
    <style>
    fieldset {
        width: 80%;
        border: 4px solid #C0BBBB;
        display: inline-block;
        font-size: 14px;
        padding: 1em 2em;
    }

    legend {
        background: #355FE7;
        /* Green */
        color: #FFFFFF;
        /* White */
        margin-bottom: 10px;
        padding: 0.5em 1em;
    }
    </style>
</head>

<body>
    <?php
    function cek($value)
    {
        if ($value == NULL || $value == '') {
            return NULL;
        }
        if ($value instanceof DateTime) {
            if ($value->format('Y-m-d') != '1900-01-01') {
                return $value->format('Y-m-d');
            } else {
                return NULL;
            }
        }
        if ($value == '1900-01-01') {
            return NULL;
        }
        return $value;
    }
        // ini_set("error_reporting", 1);
        session_start();
        include('../koneksi.php');
        function nourut()
        {
            include('../koneksi.php');
            $format = date("ymd");
            $sql = sqlsrv_query($con, "SELECT TOP 1 nokk FROM db_finishing.tbl_produksi WHERE SUBSTRING(nokk,1,6) like '%" . $format . "%' ORDER BY nokk DESC ", array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET)) or die(sqlsrv_errors());
            $d = sqlsrv_num_rows($sql);
            if ($d > 0) {
                $r = sqlsrv_fetch_array($sql);
                $d = $r['nokk'];
                $str = substr($d, 6, 2);
                $Urut = (int)$str;
            } else {
                $Urut = 0;
            }
            $Urut = $Urut + 1;
            $Nol = "";
            $nilai = 2 - strlen($Urut);
            for ($i = 1; $i <= $nilai; $i++) {
                $Nol = $Nol . "0";
            }
            $nipbr = $format . $Nol . $Urut;
            return $nipbr;
        }
        $nou = nourut();
        if ($_REQUEST['kk'] != '') {
            $idkk = "";
        } else {
            $idkk = $_GET['idkk'];
        }
        if ($_GET['typekk'] == "KKLama") {
            echo     "<script>
                            swal({
                                title: 'SYSTEM OFFLINE',   
                                text: 'Klik Ok untuk input data kembali',
                                type: 'warning',
                            }).then((result) => {
                                if (result.value) {
                                    window.location.href = 'http://online.indotaichen.com/finishing2-new/stenter/?typekk=SCHEDULE'; 
                                }
                            });
                        </script>";
        } elseif ($_GET['typekk'] == "NOW") {
            // if ($idkk != "") {
            //     include_once("../now.php");
            // }
            echo     "<script>
                            swal({
                                title: 'SYSTEM OFFLINE',   
                                text: 'Klik Ok untuk input data kembali',
                                type: 'warning',
                            }).then((result) => {
                                if (result.value) {
                                    window.location.href = 'http://online.indotaichen.com/finishing2-new/stenter/?typekk=SCHEDULE'; 
                                }
                            });
                        </script>";
        } elseif ($_GET['typekk'] == "SCHEDULE") {
            if ($idkk != "") {
                if ($_GET['demand'] != "") {
                    $nomordemand = $_GET['demand'];
                    $anddemand = "AND nodemand = '$nomordemand'";
                } else {
                    $anddemand = "";
                }
                // CEK JIKA blm ada nomor urut dan group shift kasih peringatan tidak bisa input saat operator mau proses
                $q_cekshedule    = sqlsrv_query($con, "SELECT * FROM db_finishing.tbl_schedule_new WHERE nokk = '$idkk' $anddemand AND NOT nourut = 0");
                $row_cekschedule = sqlsrv_fetch_array($q_cekshedule, SQLSRV_FETCH_ASSOC);
                if(empty($row_cekschedule['nourut']) AND $_GET['demand']){
                    echo     "<script>
                                swal({
                                    title: 'Silakan hubungi pemimpin (leader) Anda untuk pengaturan NOMOR URUT yang tepat.',   
                                    text: 'Klik Ok untuk input data kembali',
                                    type: 'warning',
                                }).then((result) => {
                                    if (result.value) {
                                        window.location.href = 'http://online.indotaichen.com/finishing2-new/stenter/?typekk=SCHEDULE'; 
                                    }
                                });
                            </script>";
                }elseif (empty($row_cekschedule['group_shift']) AND $_GET['demand']) {
                    echo     "<script>
                                swal({
                                    title: 'Silakan hubungi pemimpin (leader) Anda untuk pengaturan GROUP SHIFT yang tepat.',   
                                    text: 'Klik Ok untuk input data kembali',
                                    type: 'warning',
                                }).then((result) => {
                                    if (result.value) {
                                        window.location.href = 'http://online.indotaichen.com/finishing2-new/stenter/?typekk=SCHEDULE'; 
                                    }
                                });
                            </script>";
                }else{
                    if($_GET['operation']){
                        $andoperation   = "AND operation = '$_GET[operation]'";
                    }else{
                        $andoperation   = "";
                    }
                    if($_GET['kklanjutan']){
                        $q_kkmasuk      = sqlsrv_query($con, "SELECT
                                                                    *
                                                                FROM
                                                                    db_finishing.tbl_schedule_new
                                                                WHERE nokk = '$idkk' $anddemand $andoperation");
                        $row_kkmasuk    = sqlsrv_fetch_array($q_kkmasuk,SQLSRV_FETCH_ASSOC);
                        include_once("../now.php");
                    }else{
                        $q_kkmasuk      = sqlsrv_query($con, "SELECT
                                                                    a.*
                                                                FROM
                                                                    db_finishing.tbl_schedule_new a
                                                                WHERE
                                                                    NOT EXISTS (
                                                                            SELECT 1
                                                                            FROM
                                                                                db_finishing.tbl_produksi b
                                                                            WHERE
                                                                                b.nokk = a.nokk 
                                                                                AND b.demandno = a.nodemand 
                                                                                AND b.nama_mesin = a.operation
                                                                                AND b.no_mesin = a.no_mesin
                                                                    ) 
                                                                    AND NOT a.nourut = 0 AND NOT group_shift IS NULL
                                                                    AND nokk = '$idkk' $anddemand 
                                                                ORDER BY
                                                                    CONCAT(SUBSTRING(LTRIM(RTRIM(a.no_mesin)), LEN(LTRIM(RTRIM(a.no_mesin))) - 4, 2),SUBSTRING(LTRIM(RTRIM(a.no_mesin)), LEN(LTRIM(RTRIM(a.no_mesin))) - 1, 2)) ASC, 
                                                                    a.nourut ASC");
                        $row_kkmasuk    = sqlsrv_fetch_array($q_kkmasuk,SQLSRV_FETCH_ASSOC);
                        include_once("../now.php");
                    }
                }
            }
        }
    ?>

    <?php
        if (isset($_POST['btnSimpan']) and $_POST['shift'] == $rw['shift'] and $_POST['shift2'] == $rw['shift2'] and $_POST['proses'] == $rw['proses']) {
            $shift = $_POST['shift'];
            $shift2 = $_POST['shift2'];
            $langganan = str_replace("'", "''", $_POST['buyer']);
            $buyer = $_POST['kd_buyer'];
            $order = $_POST['no_order'];
            $item = $_POST['no_item'];
            $jenis_kain = str_replace("'", "''", $_POST['jenis_kain']);
            $kain = $_POST['kondisi_kain'];
            $bahan = $_POST['jenis_bahan'];
            $warna = str_replace("'", "''", $_POST['warna']);
            $nowarna = $_POST['no_warna'];
            $lot = $_POST['lot'];
            $qty = $_POST['qty'];
            $qty2 = $_POST['qty2'];
            $qty3 = $_POST['qty3'];
            $rol = $_POST['rol'];
            $mesin = $_POST['no_mesin'];
            $nmmesin = str_replace("'", "''", $_POST['nama_mesin']);
            $proses = $_POST['proses'];
            $gerobak = $_POST['no_gerobak'];
            $jam_in = $_POST['proses_in'];
            $jam_out = $_POST['proses_out'];
        if ($_POST['proses_jam'] != NULL or $_POST['proses_jam'] != '') {
            $proses_jam = $_POST['proses_jam'];
        } else
            $proses_jam = 0;
        if ($_POST['proses_menit'] != NULL or $_POST['proses_menit'] != '') {
            $proses_menit = $_POST['proses_menit'];
        } else
            $proses_menit = 0;
            // $proses_jam = $_POST['proses_jam'];
            // $proses_menit = $_POST['proses_menit'];
            $tgl_proses_in = $_POST['tgl_proses_m'];
            $tgl_proses_out = $_POST['tgl_proses_k'];
            $mulai = $_POST['stop_mulai'];
            $mulai2 = $_POST['stop_mulai2'];
            $mulai3 = $_POST['stop_mulai3'];
            $selesai = $_POST['stop_selesai'];
            $selesai2 = $_POST['stop_selesai2'];
            $selesai3 = $_POST['stop_selesai3'];

        if ($_POST['stop_jam'] != NULL or $_POST['stop_jam'] != '') {
            $stop_jam = $_POST['stop_jam'];
        } else
            $stop_jam = 0;
        if ($_POST['stop_menit'] != NULL or $_POST['stop_menit'] != '') {
            $stop_menit = $_POST['stop_menit'];
        } else
            $stop_menit = 0;
            // $stop_jam = $_POST['stop_jam'];
            // $stop_menit = $_POST['stop_menit'];
            $tgl_stop_m = $_POST['tgl_stop_m'];
            $tgl_stop_m2 = $_POST['tgl_stop_m2'];
            $tgl_stop_m3 = $_POST['tgl_stop_m3'];
            $tgl_stop_s = $_POST['tgl_stop_s'];
            $tgl_stop_s2 = $_POST['tgl_stop_s2'];
            $tgl_stop_s3 = $_POST['tgl_stop_s3'];
            $kd = $_POST['kd_stop'];
            $kd2 = $_POST['kd_stop2'];
            $kd3 = $_POST['kd_stop3'];
            $tgl = $_POST['tgl'];
            $acc_kain = str_replace("'", "''", $_POST['acc_kain']);
            $catatan = str_replace("'", "''", $_POST['catatan']);
            $suhu = $_POST['suhu'];
            $speed = $_POST['speed'];
            $omt = $_POST['omt'];
            $vmt = $_POST['vmt'];
            $vmt_time = $_POST['vmt_time'];
            $buka = $_POST['buka_rantai'];
            $overfeed = $_POST['overfeed'];
            $hlebar = $_POST['h_lebar'];
            $hgramasi = $_POST['h_gramasi'];
            $lebar = $_POST['lebar'];
            $gramasi = $_POST['gramasi'];
            $phlarutan = $_POST['pH_larutan'];
            $chemical1 = $_POST['chemical_1'];
            $chemical2 = $_POST['chemical_2'];
            $chemical3 = $_POST['chemical_3'];
            $chemical4 = $_POST['chemical_4'];
            $chemical5 = $_POST['chemical_5'];
            $chemical6 = $_POST['chemical_6'];
            $chemical7 = $_POST['chemical_7'];
            $jmlKonsen1 = $_POST['jmlKonsen1'];
            $jmlKonsen2 = $_POST['jmlKonsen2'];
            $jmlKonsen3 = $_POST['jmlKonsen3'];
            $jmlKonsen4 = $_POST['jmlKonsen4'];
            $jmlKonsen5 = $_POST['jmlKonsen5'];
            $jmlKonsen6 = $_POST['jmlKonsen6'];
            $jmlKonsen7 = $_POST['jmlKonsen7'];
            $simpanSql = "UPDATE db_finishing.tbl_produksi SET 
                    stop_jam=$stop_jam ,
                    stop_menit=$stop_menit,
                    proses_jam=$proses_jam,
                    proses_menit=$proses_menit,
                    shift='$shift',
                    shift2='$shift2',
                    buyer='$buyer',
                    no_item='$item',
                    no_warna='$nowarna',
                    jenis_bahan='$bahan',
                    kondisi_kain='$kain',
                    panjang='$qty2',
                    panjang_h='$qty3',
                    no_gerobak='$gerobak',
                    no_mesin='$mesin',
                    nama_mesin='$nmmesin',
                    langganan='$langganan',
                    no_order='$order',
                    jenis_kain='$jenis_kain',
                    warna='$warna',
                    lot='$lot',
                    rol='$rol',
                    qty='$qty',
                    proses='$proses',
                    jam_in='$jam_in',
                    jam_out='$jam_out',
                    tgl_proses_in='$tgl_proses_in',
                    tgl_proses_out='$tgl_proses_out',
                    stop_l='$mulai',
                    stop_l2='$mulai2',
                    stop_l3='$mulai3',
                    stop_r='$selesai',
                    stop_r2='$selesai2',
                    stop_r3='$selesai3',
                    tgl_stop_l='$tgl_stop_m',
                    tgl_stop_l2='$tgl_stop_m2',
                    tgl_stop_l3='$tgl_stop_m3',
                    tgl_stop_r='$tgl_stop_s',
                    tgl_stop_r2='$tgl_stop_s2',
                    tgl_stop_r3='$tgl_stop_s3',
                    kd_stop='$kd',
                    kd_stop2='$kd2',
                    kd_stop3='$kd3',
                    acc_staff='$acc_kain',
                    catatan='$catatan',
                    suhu='$suhu',
                    speed='$speed',
                    omt='$omt',
                    vmt='$vmt',
                    t_vmt='$vmt_time',
                    buka_rantai='$buka',
                    overfeed='$overfeed',
                    lebar='$lebar',
                    gramasi='$gramasi',
                    lebar_h='$hlebar',
                    gramasi_h='$hgramasi',
                    ph_larut='$phlarutan',
                    chemical_1='$chemical1',
                    chemical_2='$chemical2',
                    chemical_3='$chemical3',
                    chemical_4='$chemical4',
                    chemical_5='$chemical5',
                    chemical_6='$chemical6',
                    chemical_7='$chemical7',
                    konsen_1='$jmlKonsen1',
                    konsen_2='$jmlKonsen2',
                    konsen_3='$jmlKonsen3',
                    konsen_4='$jmlKonsen4',
                    konsen_5='$jmlKonsen5',
                    konsen_6='$jmlKonsen6',
                    konsen_7='$jmlKonsen7',
                    tgl_update='$tgl'
            WHERE id='$_POST[id]'";
            sqlsrv_query($con, $simpanSql) or die("Gagal Ubah" . sqlsrv_errors());

            // Refresh form
            echo "<meta http-equiv='refresh' content='0; url=?idkk=$idkk&status=Data Sudah DiUbah'>";
        } else if (isset($_POST['btnSimpan'])) {
            if ($_POST['nokk'] != "") {
                $nokk = $_POST['nokk'];
                $idkk = $_POST['nokk'];
            } else {
                $nokk = $nou;
                $idkk = $nou;
            }
            $shift = $_POST['shift'];
            $demand = $_POST['demand'];
            $shift2 = $_POST['shift2'];
            $langganan = str_replace("'", "''", $_POST['buyer']);
            $buyer = $_POST['kd_buyer'];
            $order = $_POST['no_order'];
            $item = $_POST['no_item'];
            $jenis_kain = str_replace("'", "''", $_POST['jenis_kain']);
            $kain = $_POST['kondisi_kain'];
            $bahan = $_POST['jenis_bahan'];
            $warna = str_replace("'", "''", $_POST['warna']);
            $nowarna = $_POST['no_warna'];
            $lot = $_POST['lot'];
            $qty = $_POST['qty'];
            $qty2 = $_POST['qty2'];
            $qty3 = $_POST['qty3'];
            $rol = $_POST['rol'];
            $mesin = $_POST['no_mesin'];
            $nmmesin = str_replace("'", "''", $_POST['nama_mesin']);
            $proses = $_POST['proses'];
            $gerobak = $_POST['no_gerobak'];
            $jam_in = $_POST['proses_in'];
            $jam_out = $_POST['proses_out'];
            if ($_POST['proses_jam']!=NULL or $_POST['proses_jam']!=''){
                $proses_jam = $_POST['proses_jam'];
            } else $proses_jam = 0;

            if ($_POST['proses_menit'] != NULL or $_POST['proses_menit'] != '') {
                $proses_menit = $_POST['proses_menit'];
            } else
                $proses_menit = 0;

            // $proses_jam = $_POST['proses_jam'];
            // $proses_menit = $_POST['proses_menit'];
            $tgl_proses_in = $_POST['tgl_proses_m'];
            $tgl_proses_out = $_POST['tgl_proses_k'];
            $mulai = $_POST['stop_mulai'];
            $mulai2 = $_POST['stop_mulai2'];
            $mulai3 = $_POST['stop_mulai3'];
            $selesai = $_POST['stop_selesai'];
            $selesai2 = $_POST['stop_selesai2'];
            $selesai3 = $_POST['stop_selesai3'];
        if ($_POST['stop_jam'] != NULL or $_POST['stop_jam'] != '') {
            $stop_jam = $_POST['stop_jam'];
        } else
            $stop_jam = 0;
        if ($_POST['stop_menit'] != NULL or $_POST['stop_menit'] != '') {
            $stop_menit = $_POST['stop_menit'];
        } else
            $stop_menit = 0;
            // $stop_jam = $_POST['stop_jam'];
            // $stop_menit = $_POST['stop_menit'];
            $tgl_stop_m = $_POST['tgl_stop_m'];
            $tgl_stop_m2 = $_POST['tgl_stop_m2'];
            $tgl_stop_m3 = $_POST['tgl_stop_m3'];
            $tgl_stop_s = $_POST['tgl_stop_s'];
            $tgl_stop_s2 = $_POST['tgl_stop_s2'];
            $tgl_stop_s3 = $_POST['tgl_stop_s3'];
            $kd = $_POST['kd_stop'];
            $kd2 = $_POST['kd_stop2'];
            $kd3 = $_POST['kd_stop3'];
            $tgl = $_POST['tgl'];
            $acc_kain = str_replace("'", "''", $_POST['acc_kain']);
            $catatan = str_replace("'", "''", $_POST['catatan']);
            $suhu = $_POST['suhu'];
            $speed = $_POST['speed'];
            $omt = $_POST['omt'];
            $vmt = $_POST['vmt'];
            $vmt_time = $_POST['vmt_time'];
            $buka = $_POST['buka_rantai'];
            $overfeed = $_POST['overfeed'];
            $hlebar = $_POST['h_lebar'];
            $hgramasi = $_POST['h_gramasi'];
            $lebar = $_POST['lebar'];
            $gramasi = $_POST['gramasi'];
            $phlarutan = $_POST['pH_larutan'];
            $chemical1 = $_POST['chemical_1'];
            $chemical2 = $_POST['chemical_2'];
            $chemical3 = $_POST['chemical_3'];
            $chemical4 = $_POST['chemical_4'];
            $chemical5 = $_POST['chemical_5'];
            $chemical6 = $_POST['chemical_6'];
            $chemical7 = $_POST['chemical_7'];
            $jmlKonsen1 = $_POST['jmlKonsen1'];
            $jmlKonsen2 = $_POST['jmlKonsen2'];
            $jmlKonsen3 = $_POST['jmlKonsen3'];
            $jmlKonsen4 = $_POST['jmlKonsen4'];
            $jmlKonsen5 = $_POST['jmlKonsen5'];
            $jmlKonsen6 = $_POST['jmlKonsen6'];
            $jmlKonsen7 = $_POST['jmlKonsen7'];
            $kklanjutan = $_GET['kklanjutan'];
            $jnsmesin ='stenter';
            // $dataInsertProduksi=[];
            $dataInsertProduksi=[
            $stop_jam,
            $stop_menit,
                $proses_jam,
$proses_menit,
                        cek($nokk),
                        cek($demand),
                        cek($kklanjutan),
                        cek($shift),
                        cek($shift2),
                        cek($buyer),
                        cek($item),
                        cek($nowarna),
                        cek($bahan),
                        cek($kain),
                        cek($qty2),
                        cek($qty3),
                        cek($gerobak),
                        cek($mesin),
                        cek($nmmesin),
                        cek($langganan),
                        cek($order),
                        cek($jenis_kain),
                        cek($warna),
                        cek($lot),
                        cek($rol),
                        cek($qty),
                        cek($proses),
                        cek($jam_in),
                        cek($jam_out),
                        cek($tgl_proses_in),
                        cek($tgl_proses_out),
                        cek($mulai),
                        cek($mulai2),
                        cek($mulai3),
                        cek($selesai),
                        cek($selesai2),
                        cek($selesai3),
                        cek($tgl_stop_m),
                        cek($tgl_stop_m2),
                        cek($tgl_stop_m3),
                        cek($tgl_stop_s),
                        cek($tgl_stop_s2),
                        cek($tgl_stop_s3),
                        cek($kd),
                        cek($kd2),
                        cek($kd3),
                        cek(date('Y-m-d H:i:s')),
                        cek(date('Y-m-d H:i:s')),
                        cek($acc_kain),
                        cek($catatan),
                        cek($suhu),
                        cek($speed),
                        cek($omt),
                        cek($vmt),
                        cek($vmt_time),
                        cek($buka),
                        cek($overfeed),
                        cek($lebar),
                        cek($gramasi),
                        cek($hlebar),
                        cek($hgramasi),
                        cek($phlarutan),
                        cek($chemical1),
                        cek($chemical2),
                        cek($chemical3),
                        cek($chemical4),
                        cek($chemical5),
                        cek($chemical6),
                        cek($chemical7),
                        cek($jmlKonsen1),
                        cek($jmlKonsen2),
                        cek($jmlKonsen3),
                        cek($jmlKonsen4),
                        cek($jmlKonsen5),
                        cek($jmlKonsen6),
                        cek($jmlKonsen7),
                        cek($jnsmesin),
                        cek($tgl)
                    ];
            
            $simpanSql = "INSERT INTO db_finishing.tbl_produksi (stop_jam,stop_menit,proses_jam,proses_menit,
                        nokk,
                        demandno,
                        kklanjutan ,
                        shift,
                        shift2,
                        buyer,
                        no_item,
                        no_warna,
                        jenis_bahan,
                        kondisi_kain,
                        panjang,
                        panjang_h,
                        no_gerobak,
                        no_mesin,
                        nama_mesin,
                        langganan,
                        no_order,
                        jenis_kain,
                        warna,
                        lot,
                        rol,
                        qty,
                        proses,
                        jam_in,
                        jam_out,
                        tgl_proses_in,
                        tgl_proses_out,
                        stop_l,
                        stop_l2,
                        stop_l3,
                        stop_r,
                        stop_r2,
                        stop_r3,
                        tgl_stop_l,
                        tgl_stop_l2,
                        tgl_stop_l3,
                        tgl_stop_r,
                        tgl_stop_r2,
                        tgl_stop_r3,
                        kd_stop,
                        kd_stop2,
                        kd_stop3,
                        tgl_buat,
                        tgl_pro,
                        acc_staff,
                        catatan,
                        suhu,
                        speed,
                        omt,
                        vmt,
                        t_vmt,
                        buka_rantai,
                        overfeed,
                        lebar,
                        gramasi,
                        lebar_h,
                        gramasi_h,
                        ph_larut,
                        chemical_1,
                        chemical_2,
                        chemical_3,
                        chemical_4,
                        chemical_5,
                        chemical_6,
                        chemical_7,
                        konsen_1,
                        konsen_2,
                        konsen_3,
                        konsen_4,
                        konsen_5,
                        konsen_6,
                        konsen_7,
                        jns_mesin,
                        tgl_update)VALUES(?,?,?,?,
                        ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,
                        ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,
                        ?,?,?,?,?,?,?,?,?,?
                        )";
            // // sqlsrv_query($con, $simpanSql) or die("Gagal Simpan" . sqlsrv_errors());
            // $stmt = $pdo->prepare($simpanSql);

            // // Define the data to be inserted
            // $data = $dataInsertProduksi;

            // // foreach ($data as $row) {
            //     // echo '<pre>';
    
            //     // print_r($data);
    
            //     // echo '</pre>';
    
            //     if (!$stmt->execute($data)) {
            //         // Handle error
            //         echo "Error: ";

            //         print_r($stmt->errorInfo());

            //         exit();

            //     }
            // // }

            // // echo "Data successfully inserted!";
            // } catch (PDOException $e) {
            // echo "xError: " . $e->getMessage();
            // }
        $stmt = sqlsrv_prepare($con, $simpanSql, $dataInsertProduksi);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        $result = sqlsrv_execute($stmt);

        if ($result === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        // echo 'Berhasil simpan';
            // $simpanSql = "INSERT INTO db_finishing.tbl_produksi SET 
            //             `nokk`='$nokk',
            //             `demandno`='$demand',
            //             `kklanjutan` = '$kklanjutan',
            //             `shift`='$shift',
            //             `shift2`='$shift2',
            //             `buyer`='$buyer',
            //             `no_item`='$item',
            //             `no_warna`='$nowarna',
            //             `jenis_bahan`='$bahan',
            //             `kondisi_kain`='$kain',
            //             `panjang`='$qty2',
            //             `panjang_h`='$qty3',
            //             `no_gerobak`='$gerobak',
            //             `no_mesin`='$mesin',
            //             `nama_mesin`='$nmmesin',
            //             `langganan`='$langganan',
            //             `no_order`='$order',
            //             `jenis_kain`='$jenis_kain',
            //             `warna`='$warna',
            //             `lot`='$lot',
            //             `rol`='$rol',
            //             `qty`='$qty',
            //             `proses`='$proses',
            //             `jam_in`='$jam_in',
            //             `jam_out`='$jam_out',
            //             `tgl_proses_in`='$tgl_proses_in',
            //             `tgl_proses_out`='$tgl_proses_out',
            //             `stop_l`='$mulai',
            //             `stop_l2`='$mulai2',
            //             `stop_l3`='$mulai3',
            //             `stop_r`='$selesai',
            //             `stop_r2`='$selesai2',
            //             `stop_r3`='$selesai3',
            //             `tgl_stop_l`='$tgl_stop_m',
            //             `tgl_stop_l2`='$tgl_stop_m2',
            //             `tgl_stop_l3`='$tgl_stop_m3',
            //             `tgl_stop_r`='$tgl_stop_s',
            //             `tgl_stop_r2`='$tgl_stop_s2',
            //             `tgl_stop_r3`='$tgl_stop_s3',
            //             `kd_stop`='$kd',
            //             `kd_stop2`='$kd2',
            //             `kd_stop3`='$kd3',
            //             `tgl_buat`=now(),
            //             `tgl_pro`=now(),
            //             `acc_staff`='$acc_kain',
            //             `catatan`='$catatan',
            //             `suhu`='$suhu',
            //             `speed`='$speed',
            //             `omt`='$omt',
            //             `vmt`='$vmt',
            //             `t_vmt`='$vmt_time',
            //             `buka_rantai`='$buka',
            //             `overfeed`='$overfeed',
            //             `lebar`='$lebar',
            //             `gramasi`='$gramasi',
            //             `lebar_h`='$hlebar',
            //             `gramasi_h`='$hgramasi',
            //             `ph_larut`='$phlarutan',
            //             `chemical_1`='$chemical1',
            //             `chemical_2`='$chemical2',
            //             `chemical_3`='$chemical3',
            //             `chemical_4`='$chemical4',
            //             `chemical_5`='$chemical5',
            //             `chemical_6`='$chemical6',
            //             `chemical_7`='$chemical7',
            //             `konsen_1`='$jmlKonsen1',
            //             `konsen_2`='$jmlKonsen2',
            //             `konsen_3`='$jmlKonsen3',
            //             `konsen_4`='$jmlKonsen4',
            //             `konsen_5`='$jmlKonsen5',
            //             `konsen_6`='$jmlKonsen6',
            //             `konsen_7`='$jmlKonsen7',
            //             `jns_mesin`='stenter',
            //             `tgl_update`='$tgl'
            //             ";
            // sqlsrv_query($con, $simpanSql) or die("Gagal Simpan" . sqlsrv_errors());

            //Simpan ke schedule
            $posisi = strpos($langganan, "/");
            $cus = substr($langganan, 0, $posisi);
            $byr = substr($langganan, ($posisi + 1), 100);
            $sqlData = sqlsrv_query($con, "INSERT INTO db_finishing.tbl_schedule SET
                                            nokk='$nokk',
                                            nodemand='$demand',
                                            langganan='$cus',
                                            buyer='$byr',
                                            no_order='$order',
                                            no_hanger='$item',
                                            no_item='$item',
                                            jenis_kain='$jenis_kain',
                                            lebar='$lebar',
                                            gramasi='$gramasi',
                                            warna='$warna',
                                            no_warna='$nowarna',
                                            bruto='$qty',
                                            lot='$lot',
                                            rol='$rol',
                                            shift='$shift',
                                            g_shift='$shift2',
                                            no_mesin='$mesin',
                                            proses='$proses',
                                            revisi='0',
                                            tgl_masuk=GETDATE(),
                                            personil='Operator Fin',
                                            [target]='0',
                                            catatan='data diinput dari finishing',
                                            tgl_update=GETDATE(),
                                            tampil='1'");

            // Refresh form
            echo "<meta http-equiv='refresh' content='0; url=?idkk=$idkk&status=Data Sudah DiSimpan'>";
        }
    ?>
    <form id="form1" name="form1" method="post" action="">
        <fieldset>
            <legend>Data Produksi Harian Stenter</legend>
            <table width="100%" border="0">
                <tr>
                    <th colspan="7" scope="row">
                        <font color="#FF0000"><?php echo $_GET['status']; ?></font>
                    </th>
                </tr>
                <tr>
                    <td scope="row">
                        <h4>Pilih Asal Kartu Kerja</h4>
                    </td>
                    <td width="1%">:</td>
                    <td>
                        <select style="width: 50%" id="typekk" name="typekk"
                            onchange="window.location='?typekk='+this.value" required>
                            <option value="" disabled selected>-Pilih Tipe Kartu Kerja-</option>
                            <option value="KKLama" <?php if ($_GET['typekk'] == "KKLama") {
                                                        echo "SELECTED";
                                                    } ?>>KK Lama</option>
                            <!-- <option value="NOW" <?php if ($_GET['typekk'] == "NOW") {
                                                    echo "SELECTED";
                                                } ?>>KK NOW</option> -->
                            <option value="SCHEDULE" <?php if ($_GET['typekk'] == "SCHEDULE") {
                                                            echo "SELECTED";
                                                        } ?>>SCHEDULE</option>
                        </select>

                        <input type="checkbox" name="kklanjutan" id="kklanjutan"
                            value="<?php if($_GET['kklanjutan']){ echo "1"; }else{echo "0";} ?>"
                            <?php if($_GET['kklanjutan']){ echo "checked"; } ?>
                            onchange="window.location='?typekk='+document.getElementById(`typekk`).value+'&kklanjutan=1'">
                        KK LANJUTAN
                    </td>
                </tr>
                <tr>
                    <td width="13%" scope="row">
                        <h4>Nokk</h4>
                    </td>
                    <td width="1%">:</td>
                    <td width="26%">
                        <input name="nokk" type="text" id="nokk" size="17"
                            onchange="window.location='?typekk='+document.getElementById(`typekk`).value+'&kklanjutan='+document.getElementById(`kklanjutan`).value+'&idkk='+this.value"
                            value="<?php echo $_GET['idkk']; ?>" /><input type="hidden" value="<?php echo $rw['id']; ?>"
                            name="id" />

                        <?php if ($_GET['typekk'] == 'NOW') {  ?>
                        <select style="width: 40%" name="demand" id="demand"
                            onchange="window.location='?typekk='+document.getElementById(`typekk`).value+'&idkk='+document.getElementById(`nokk`).value+'&kklanjutan='+document.getElementById(`kklanjutan`).value+'&demand='+this.value"
                            required>
                            <option value="" disabled selected>Pilih Nomor Demand</option>
                            <?php
                                    $sql_ITXVIEWKK_demand  = db2_exec($conn_db2, "SELECT DEAMAND AS DEMAND FROM ITXVIEWKK WHERE PRODUCTIONORDERCODE = '$idkk'");
                                    while ($r_demand = db2_fetch_assoc($sql_ITXVIEWKK_demand)) :
                                ?>
                            <option value="<?php echo $r_demand['DEMAND']; ?>" <?php if ($r_demand['DEMAND'] == $_GET['demand']) {
                                                                                    echo 'SELECTED';
                                                                                } ?>><?php echo $r_demand['DEMAND']; ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                        <?php }elseif($_GET['typekk'] == 'SCHEDULE'){ ?>
                        <select style="width: 40%" name="demand" id="demand"
                            onchange="window.location='?typekk='+document.getElementById(`typekk`).value+'&idkk='+document.getElementById(`nokk`).value+'&kklanjutan='+document.getElementById(`kklanjutan`).value+'&demand='+this.value"
                            required>
                            <option value="" disabled selected>Pilih Nomor Demand</option>
                            <?php
                                    $sql_ITXVIEWKK_demand  = sqlsrv_query($con, "SELECT * FROM db_finishing.tbl_schedule_new WHERE nokk = '$idkk'");
									while ($r_demand = sqlsrv_fetch_array($sql_ITXVIEWKK_demand)) :
                                ?>
                            <?php if($_GET['kklanjutan']) : ?>
                            <?php echo $r_demand['nodemand'];?>
                            <option value="<?= htmlspecialchars($r_demand['nodemand'], ENT_QUOTES, 'UTF-8'); ?>" <?php if (isset($_GET['demand']) && $r_demand['nodemand'] == $_GET['demand']) {
                                    echo 'selected';
                                } ?>>
                                <?= htmlspecialchars($r_demand['nodemand'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                            <?php else : ?>
                            <?php
                                        // CEK, JIKA KARTU KERJA SUDAH DIPROSES MAKA TIDAK AKAN MUNCUL. 
                                        $cek_proses   = sqlsrv_query($con, "SELECT COUNT(*) AS jml FROM db_finishing.tbl_produksi WHERE nokk = '$r_demand[nokk]' AND demandno = '$r_demand[nodemand]' AND nama_mesin = '$r_demand[operation]'");
                                        $data_proses  = sqlsrv_fetch_array($cek_proses,SQLSRV_FETCH_ASSOC);
                                       
                                    ?>
                            <?php if(empty($data_proses['jml'])) : ?>
                            <option value="<?php echo $r_demand['nodemand']; ?>"
                                <?php if ($r_demand['nodemand'] == $_GET['demand']) { echo 'SELECTED'; } ?>>
                                <?php echo $r_demand['nodemand']; ?></option>
                            <?php endif; ?>
                            <?php endif; ?>
                            <?php endwhile; ?>
                        </select>
                        <?php } else { ?>
                        <input name="demand" id="demand" type="text" placeholder="Nomor Demand">
                        <?php } ?>
                    </td>
                    <td width="14%">
                        <h4>Group Shift</h4>
                    </td>
                    <td width="1%">:</td>
                    <td colspan="2"><select name="shift" id="shift">
                            <option value="">Pilih</option>
                            <option value="A" <?php if ($row_kkmasuk['group_shift'] == "A") { echo "SELECTED"; } ?>>A
                            </option>
                            <option value="B" <?php if ($row_kkmasuk['group_shift'] == "B") { echo "SELECTED"; } ?>>B
                            </option>
                            <option value="C" <?php if ($row_kkmasuk['group_shift'] == "C") { echo "SELECTED"; } ?>>C
                            </option>
                        </select></td>
                </tr>
                <tr>
                    <td>
                        <h4>Operation</h4>
                    </td>
                    <td>:</td>
                    <td>
                        <input type="text" name="nama_mesin" id="nama_mesin"  value="<?php echo $row_kkmasuk['operation']; ?>" readonly required>

                        <!-- <select name="nama_mesin" id="nama_mesin"
                            onchange="window.location='?typekk='+document.getElementById(`typekk`).value+'&idkk='+document.getElementById(`nokk`).value+'&kklanjutan='+document.getElementById(`kklanjutan`).value+'&demand='+document.getElementById(`demand`).value+'&shift=<?php echo $_GET['shift']; ?>&shift2=<?php echo $_GET['shift2']; ?>&operation='+this.value"
                            required="required" disabled>
                            <option value="">Pilih</option>
                            <?php
                                if($_GET['kklanjutan'] == '1'){
                                    $wherecekproses = "";
                                }else{
                                    $wherecekproses = "NOT EXISTS (
                                        SELECT 1
                                        FROM
                                            db_finishing.tbl_produksi c
                                        WHERE
                                            c.nokk = a.nokk 
                                            AND c.demandno = a.nodemand 
                                            AND c.nama_mesin = a.operation
                                        )
                                AND";
                                }
								$qry1 = sqlsrv_query($con, "SELECT 
                                                                * 
                                                            FROM 
                                                                db_finishing.tbl_schedule_new a
                                                            WHERE
                                                            $wherecekproses
                                                                a.nokk = '$idkk' 
                                                                AND NOT a.nourut = 0");
                                                                // var_dump($row_kkmasuk['operation']);
								
								if($_GET['typekk'] == 'NOW'){
									$if_operation   = "$_GET[operation]";
								}elseif($_GET['typekk'] == 'SCHEDULE'){
									if($_GET['operation']){
										$if_operation   = "$_GET[operation]";
									}else{
										$if_operation   = "$row_kkmasuk[operation]";
									}
								}
								while ($r = sqlsrv_fetch_array($qry1)) {
							?>
                            <?php 
									$q_desc_op 	= db2_exec($conn_db2, "SELECT * FROM OPERATION WHERE OPERATIONGROUPCODE = 'FIN' AND CODE = '$r[operation]'");
									$desc_op	= db2_fetch_assoc($q_desc_op);
								?>
                            <option value="<?= $r['operation']; ?>"
                                <?php if ($if_operation == $r['operation']) { echo "SELECTED"; } ?>>
                                <?= $r['operation']; ?> <?= $desc_op['LONGDESCRIPTION']; ?></option>
                            <?php } ?> -->
                        </select>
                        <!-- <?php if ($_SESSION['lvl'] == "SPV") { ?>
                            <input type="button" name="btnmesin2" id="btnmesin2" value="..." onclick="window.open('pages/mesin.php','MyWindow','height=400,width=650');" />
                        <?php } ?> -->
                    </td>
                    <td width="14%">
                        <h4>Shift</h4>
                    </td>
                    <td>:</td>
                    <td colspan="2">
                        <select name="shift2" id="shift2" required="required">
                            <option value="">Pilih</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>No. Mesin</strong></td>
                    <td>:</td>
                    <td>
                        <input  name="no_mesin" id="no_mesin" type="text" required value="<?php echo $row_kkmasuk['no_mesin'] ?>" readonly>
                        <!-- <select name="no_mesin" id="no_mesin" onchange="myFunction();" required="required" disabled>
                            <option value="">Pilih</option>
                            <?php
                            
                            $q_mesin = db2_exec($conn_db2, "SELECT DISTINCT
                                                                p.WORKCENTERCODE,
                                                                CASE
                                                                    WHEN p.PRODRESERVATIONLINKGROUPCODE IS NULL THEN TRIM(p.OPERATIONCODE) 
                                                                    WHEN TRIM(p.PRODRESERVATIONLINKGROUPCODE) = '' THEN TRIM(p.OPERATIONCODE) 
                                                                    ELSE p.PRODRESERVATIONLINKGROUPCODE
                                                                END	AS OPERATIONCODE,
                                                                TRIM(o.OPERATIONGROUPCODE) AS OPERATIONGROUPCODE,
                                                                o.LONGDESCRIPTION,
                                                                iptip.MULAI,
                                                                iptop.SELESAI,
                                                                p.PRODUCTIONORDERCODE,
                                                                p.PRODUCTIONDEMANDCODE,
                                                                p.GROUPSTEPNUMBER AS STEPNUMBER,
                                                                CASE
                                                                    WHEN iptip.MACHINECODE = iptop.MACHINECODE THEN iptip.MACHINECODE
                                                                    ELSE iptip.MACHINECODE || '-' ||iptop.MACHINECODE
                                                                END AS MESIN   
                                                            FROM 
                                                                PRODUCTIONDEMANDSTEP p 
                                                            LEFT JOIN OPERATION o ON o.CODE = p.OPERATIONCODE 
                                                            LEFT JOIN ITXVIEW_POSISIKK_TGL_IN_PRODORDER iptip ON iptip.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND iptip.DEMANDSTEPSTEPNUMBER = p.STEPNUMBER
                                                            LEFT JOIN ITXVIEW_POSISIKK_TGL_OUT_PRODORDER iptop ON iptop.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND iptop.DEMANDSTEPSTEPNUMBER = p.STEPNUMBER
                                                            WHERE
                                                                p.PRODUCTIONORDERCODE  = '$_GET[idkk]' AND p.PRODUCTIONDEMANDCODE = '$_GET[demand]' 
                                                                AND 
                                                                CASE
                                                                    WHEN p.PRODRESERVATIONLINKGROUPCODE IS NULL THEN TRIM(p.OPERATIONCODE) 
                                                                    WHEN TRIM(p.PRODRESERVATIONLINKGROUPCODE) = '' THEN TRIM(p.OPERATIONCODE) 
                                                                    ELSE p.PRODRESERVATIONLINKGROUPCODE
                                                                END = '$_GET[operation]'
                                                            ORDER BY iptip.MULAI ASC");
                            $row_mesin = db2_fetch_assoc($q_mesin);
                            if($_GET['typekk'] == 'SCHEDULE'){
                                $where_schedule     = "AND CODE = '$row_kkmasuk[no_mesin]'";
                                $selected           = "SELECTED";
                            }else{
                                $where_schedule     = "";
                                $selected           = "";
                            }

                            $qry1 = db2_exec($conn_db2, "SELECT
                                                            *
                                                            FROM
                                                                RESOURCES r
                                                            WHERE
                                                                SUBSTR(CODE, 1,4) = 'P3ST' $where_schedule
                                                            ORDER BY 
                                                                SUBSTR(CODE, 6,2) 
                                                            ASC");
                            while ($r = db2_fetch_assoc($qry1)) {
                            ?>
                            <option value="<?= $r['CODE']; ?>"
                                <?php if ($row_mesin['MESIN'] == $r['CODE']) { echo "SELECTED"; } ?> <?= $selected ?>>
                                <?= $r['CODE']; ?></option>
                            <?php } ?>
                        </select>
                        <?php if ($_SESSION['lvl'] == "SPV") { ?>
                        <input type="button" name="btnmesin" id="btnmesin" value="..."
                            onclick="window.open('pages/data-mesin.php','MyWindow','height=400,width=650');" />
                        <?php } ?> -->
                    </td>
                    <td>
                        <h4>Tgl Proses</h4>
                    </td>
                    <td>:</td>
                    <td colspan="2"><input name="tgl" type="text" id="tgl"
                            onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl);return false;" size="10"
                            placeholder="0000-00-00" required="required" />
                        <a href="javascript:void(0)"
                            onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl);return false;"><img
                                src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal"
                                style="border:none" align="absmiddle" border="0" /></a>
                    </td>
                </tr>

                <tr>
                    <td scope="row">
                        <h4>Langganan/Buyer</h4>
                    </td>
                    <td>:</td>
                    <td>
                        <?php if ($_GET['typekk'] == "NOW") : ?>
                        <?php $langganan_buyer =  $dt_pelanggan_buyer['PELANGGAN'] . '/' . $dt_pelanggan_buyer['BUYER']; ?>
                        <?php else : ?>
                        <?php if ($cek > 0) {
                                $langganan_buyer =  $ssr1['partnername'] . "/" . $ssr2['partnername'];
                            } else {
                                $langganan_buyer =  $rw['langganan'];
                            } ?>
                        <?php endif; ?>

                        <?php if ($_GET['typekk'] == "SCHEDULE") : ?>
                        <?php $langganan_buyer  = $row_kkmasuk['langganan'].'/'.$row_kkmasuk['buyer']; ?>
                        <?php endif; ?>

                        <input name="buyer" type="text" id="buyer" size="45" value="<?= $langganan_buyer; ?>">
                    </td>
                    <td>
                        <h4>Proses</h4>
                    </td>
                    <td>:</td>
                    <td colspan="2"><select name="proses" id="proses" required>
                            <option value="">Pilih</option>
                            <?php
                            $qry1 = sqlsrv_query($con, "SELECT proses, jns FROM db_finishing.tbl_proses WHERE ket='stenter' ORDER BY proses ASC");
                            while ($r = sqlsrv_fetch_array($qry1)) {
                            ?>
                            <option value="<?php echo $r['proses'] . " (" . $r['jns'] . ")"; ?>" <?php if ($row_kkmasuk['proses'] == $r['proses'] . " (" . $r['jns'] . ")") {
                                                                                                            echo "SELECTED";
                                                                                                        } ?>>
                                <?php echo $r['proses'] . " (" . $r['jns'] . ")"; ?></option>
                            <?php } ?>
                        </select>
                        <?php if ($_SESSION['lvl'] == "SPV") { ?>
                        <input type="button" name="btnproses" id="btnproses" value="..."
                            onclick="window.open('pages/data-proses.php','MyWindow','height=400,width=650');" />
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <h4>Kode Buyer</h4>
                    </td>
                    <td>:</td>
                    <td>
                        <?php if ($_GET['typekk'] == "NOW") : ?>
                        <select name="kd_buyer" id="kd_buyer" required="required">
                            <option value="">Pilih</option>
                            <option value="ADIDAS" <?php if ($rw_kk['BUYER'] == "ADIDAS") {
                                                            echo "SELECTED";
                                                        } ?>>ADIDAS</option>
                            <option value="NIKE" <?php if ($rw_kk['BUYER'] == "NIKE") {
                                                            echo "SELECTED";
                                                        } ?>>NIKE</option>
                            <option value="CAMPURAN" <?php if ($rw_kk['BUYER'] == "NIKE") {
                                                            } else if ($rw_kk['BUYER'] == "ADIDAS") {
                                                            } else {
                                                                echo "SELECTED";
                                                            } ?>>CAMPURAN</option>
                        </select>
                        <?php else : ?>
                        <select name="kd_buyer" id="kd_buyer" required="required">
                            <option value="">Pilih</option>
                            <option value="ADIDAS" <?php if ($row_kkmasuk['buyer'] == "ADIDAS") { echo "SELECTED"; } ?>>
                                ADIDAS</option>
                            <option value="NIKE" <?php if ($row_kkmasuk['buyer'] == "NIKE") { echo "SELECTED"; } ?>>NIKE
                            </option>
                            <option value="CAMPURAN" <?php if ($row_kkmasuk['buyer'] == "NIKE") { 
                                                            } else if ($row_kkmasuk['buyer'] == "ADIDAS") {
                                                            } else {
                                                                echo "SELECTED";
                                                            } ?>>CAMPURAN</option>
                        </select>
                        <?php endif; ?>
                    </td>
                    <td>
                        <h4>No. Gerobak</h4>
                    </td>
                    <td>:</td>
                    <td colspan="2">
                        <input type="text" name="no_gerobak" id="no_gerobak" value="<?= $rw['no_gerobak']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <h4>No. Order</h4>
                    </td>
                    <td>:</td>
                    <td>
                        <?php if ($_GET['typekk'] == "NOW") : ?>
                        <?php $no_order =  $dt_ITXVIEWKK['PROJECTCODE']; ?>
                        <?php else : ?>
                        <?php if ($cek > 0) {
                                $no_order =  $ssr['documentno'];
                            } else {
                                $no_order =  $rw['no_order'];
                            } ?>
                        <?php endif; ?>

                        <?php if ($_GET['typekk'] == "SCHEDULE") : ?>
                        <?php $no_order =  $row_kkmasuk['no_order']; ?>
                        <?php endif; ?>
                        <input type="text" name="no_order" id="no_order" value="<?= $no_order; ?>" />
                    </td>
                    <td>
                        <h4>Kondisi Kain</h4>
                    </td>
                    <td>:</td>
                    <td colspan="2">
                        <select name="kondisi_kain" id="kondisi_kain" required="required">
                            <option value="">Pilih</option>
                            <option value="BASAH" <?php if ($rw['kondisi_kain'] == "BASAH") {
                                                        echo "SELECTED";
                                                    } ?>>BASAH</option>
                            <option value="KERING" <?php if ($rw['kondisi_kain'] == "KERING") {
                                                        echo "SELECTED";
                                                    } ?>>KERING</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td valign="top" scope="row">
                        <h4>Jenis Kain</h4>
                    </td>
                    <td valign="top">:</td>
                    <td>
                        <?php if ($_GET['typekk'] == "NOW") : ?>
                        <?php $jk = $dt_ITXVIEWKK['ITEMDESCRIPTION']; ?>
                        <?php else : ?>
                        <?php if ($cek > 0) {
                                $jk = $ssr['productcode'] . " / " . $ssr['description'];
                            } else {
                                $jk = $rw['jenis_kain'];
                            } ?>
                        <?php endif; ?>

                        <?php if ($_GET['typekk'] == "SCHEDULE") : ?>
                        <?php $jk =  $row_kkmasuk['jenis_kain']; ?>
                        <?php endif; ?>

                        <textarea name="jenis_kain" cols="35" id="jenis_kain"><?= $jk; ?></textarea>
                    </td>
                    <td valign="top">
                        <h4 style="color: red;">Catatan</h4>
                    </td>
                    <td valign="top">:</td>
                    <td colspan="2" valign="top">
                        <?php if ($_GET['typekk'] == "SCHEDULE") : ?>
                        <?php $catatan =  $row_kkmasuk['catatan']; ?>
                        <?php endif; ?>
                        <textarea name="catatan" cols="35"><?= $catatan; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <h4>Hanger/Item</h4>
                    </td>
                    <td>:</td>
                    <td>
                        <?php if ($_GET['typekk'] == "NOW" OR $_GET['typekk'] == "SCHEDULE") : ?>
                        <?php $hanger = $dt_ITXVIEWKK['NO_HANGER']; ?>
                        <?php else : ?>
                        <?php if ($cek > 0) {
                                $hanger = $ssr['productcode'];
                            } else {
                                $hanger = $rw['no_item'];
                            } ?>
                        <?php endif; ?>
                        <input type="text" name="no_item" id="no_item" value="<?= $hanger; ?>" />
                    </td>
                    <td width="14%"><strong>Quantity (Kg)</strong></td>
                    <td width="1%">:</td>
                    <td colspan="2">
                        <?php if ($_GET['typekk'] == "NOW") : ?>
                        <?php $berat = $dt_qtyorder['QTY_ORDER']; ?>
                        <?php else : ?>
                        <?php if ($cLot > 0) {
                                $berat = round($sLot['Weight'], 2);
                            } else if ($rc > 0) {
                                $berat = round($rw['qty'], 2);
                            } else if ($rcAdm > 0) {
                                $berat = $rwAdm['qty'];
                            } ?>
                        <?php endif; ?>

                        <?php if ($_GET['typekk'] == "SCHEDULE") : ?>
                        <?php $berat =  $row_kkmasuk['qty_order']; ?>
                        <?php endif; ?>

                        <input name="qty" type="text" id="qty" size="5" value="<?= $berat; ?>" placeholder="0.00" />

                        &nbsp;&nbsp;&nbsp;&nbsp;<strong>Gramasi</strong>:

                        <?php if ($_GET['typekk'] == "NOW") : ?>
                        <?php $nlebar = floor($dt_lg['LEBAR']); ?>
                        <?php endif; ?>

                        <?php if ($_GET['typekk'] == "SCHEDULE") : ?>
                        <?php $nlebar =  $row_kkmasuk['lebar']; ?>
                        <?php $ngramasi =  $row_kkmasuk['gramasi']; ?>
                        <?php endif; ?>

                        <input name="lebar" type="text" id="lebar" size="6" value="<?= $nlebar; ?>" placeholder="0" />

                        <?php if ($_GET['typekk'] == "NOW") : ?>
                        <?php $ngramasi = floor($dt_lg['GRAMASI']) ?>
                        <?php endif; ?>

                        <input name="gramasi" type="text" id="gramasi" size="6" value="<?= $ngramasi; ?>"
                            placeholder="0" />
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <h4>No. Warna</h4>
                    </td>
                    <td>:</td>
                    <td>
                        <?php if ($_GET['typekk'] == "NOW") : ?>
                        <?php $nomor_warna = $dt_ITXVIEWKK['NO_WARNA']; ?>
                        <?php else : ?>
                        <?php if ($cek > 0) {
                                $nomor_warna = $ssr['colorno'];
                            } else {
                                $nomor_warna = $rw['no_warna'];
                            } ?>
                        <?php endif; ?>

                        <?php if ($_GET['typekk'] == "SCHEDULE") : ?>
                        <?php $nomor_warna =  $row_kkmasuk['no_warna']; ?>
                        <?php endif; ?>
                        <input name="no_warna" type="text" id="no_warna" size="35" value="<?= $nomor_warna; ?>" />
                    </td>
                    <td width="14%"><strong>Panjang (Yard)</strong></td>
                    <td>:</td>

                    <?php if ($_GET['typekk'] == "NOW") : ?>
                    <?php $qty_order_yd =  $dt_qtyorder['QTY_ORDER_YARD']; ?>
                    <?php endif; ?>
                    <?php if ($_GET['typekk'] == "SCHEDULE") : ?>
                    <?php $qty_order_yd =  $row_kkmasuk['qty_order_yd']; ?>
                    <?php endif; ?>

                    <td colspan="2"><input name="qty2" type="text" id="qty2" size="8" value="<?= $qty_order_yd; ?>"
                            placeholder="0.00" onfocus="jumlah();" /></td>
                </tr>
                <tr>
                    <td scope="row">
                        <h4>Warna</h4>
                    </td>
                    <td>:</td>
                    <td>
                        <?php if ($_GET['typekk'] == "NOW") : ?>
                        <?php $nama_warna = $dt_warna['WARNA']; ?>
                        <?php else : ?>
                        <?php if ($cek > 0) {
                                $nama_warna = $ssr['color'];
                            } else {
                                $nama_warna = $rw['warna'];
                            } ?>
                        <?php endif; ?>

                        <?php if ($_GET['typekk'] == "SCHEDULE") : ?>
                        <?php $nama_warna =  $row_kkmasuk['warna']; ?>
                        <?php endif; ?>

                        <input name="warna" type="text" id="warna" size="35" value="<?= $nama_warna; ?>" />
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <h4>Jenis Bahan</h4>
                    </td>
                    <td>:</td>
                    <td><select name="jenis_bahan" id="jenis_bahan" required="required">
                            <option value="">Pilih</option>
                            <option value="Polyesyer" <?php if ($rw['jenis_bahan'] == "Polyesyer") {
                                                            echo "SELECTED";
                                                        } ?>>Polyesyer</option>
                            <option value="Cotton" <?php if ($rw['janis_bahan'] == "Cotton") {
                                                        echo "SELECTED";
                                                    } ?>>Cotton</option>
                        </select></td>
                </tr>
                <tr>
                    <td scope="row">
                        <h4>Lot</h4>
                    </td>
                    <td>:</td>
                    <td>
                        <?php if ($_GET['typekk'] == "NOW") : ?>
                        <?php $lot =  $dt_ITXVIEWKK['LOT']; ?>
                        <?php endif; ?>
                        <?php if ($_GET['typekk'] == "SCHEDULE") : ?>
                        <?php $lot =  $row_kkmasuk['lot']; ?>
                        <?php endif; ?>
                        <input name="lot" type="text" id="lot" size="5" value="<?= $lot; ?>" />
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <h4>Roll</h4>
                    </td>
                    <td>:</td>
                    <td>
                        <?php if ($_GET['typekk'] == "NOW") : ?>
                        <?php $rol =  $dt_roll['ROLL']; ?>
                        <?php endif; ?>
                        <?php if ($_GET['typekk'] == "SCHEDULE") : ?>
                        <?php $rol =  $row_kkmasuk['roll']; ?>
                        <?php endif; ?>
                        <input name="rol" type="text" id="rol" size="3" placeholder="0" pattern="[0-9]{1,}"
                            value="<?= $rol; ?>" />
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <h4>Mulai Proses</h4>
                    </td>
                    <td>:</td>
                    <td><input name="proses_in" type="text" id="proses_in" placeholder="00:00"
                            pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25" onkeyup="
                                var time = this.value;
                                if (time.match(/^\d{2}$/) !== null) {
                                    this.value = time + ':';
                                } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
                                    this.value = time + '';
                                }" value="<?php echo $rw['jam_in'] ?>" size="5" maxlength="5" required />
                        <input name="tgl_proses_m" type="text" id="tgl_proses_m"
                            onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_proses_m);return false;"
                            size="10" placeholder="0000-00-00" value="<?php echo $rw['tgl_proses_in']; ?>" required />
                        <a href="javascript:void(0)"
                            onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_proses_m);return false;"><img
                                src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal2"
                                style="border:none" align="absmiddle" border="0" /></a>
                    </td>
                    <td>
                        <h4>Selesai Proses</h4>
                    </td>
                    <td>:</td>
                    <td colspan="2"><input name="proses_out" type="text" id="proses_out" placeholder="00:00"
                            pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25 " onkeyup="
                                                var time = this.value;
                                                if (time.match(/^\d{2}$/) !== null) {
                                                this.value = time + ':';
                                                } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
                                                this.value = time + '';
                                                }" value="<?php echo $rw['jam_out'] ?>" size="5" maxlength="5"
                            required />
                        <input name="tgl_proses_k" type="text" id="tgl_proses_k" placeholder="0000-00-00"
                            onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_proses_k);return false;"
                            value="<?php echo $rw['tgl_proses_out']; ?>" size="10" required />
                        <a href="javascript:void(0)"
                            onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_proses_k);return false;"><img
                                src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal3"
                                style="border:none" align="absmiddle" border="0" /></a>
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <h4>Mulai Stop Mesin 1</h4>
                    </td>
                    <td>:</td>
                    <td><input name="stop_mulai" type="text" id="stop_mulai" placeholder="00:00"
                            pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25 " onkeyup="
                                        var time = this.value;
                                        if (time.match(/^\d{2}$/) !== null) {
                                            this.value = time + ':';
                                        } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
                                            this.value = time + '';
                                        }" value="<?php echo $rw['stop_l'] ?>" size="5" maxlength="5" />
                        <input name="tgl_stop_m" type="text" id="tgl_stop_m" placeholder="0000-00-00"
                            onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_m);return false;"
                            value="<?php echo $rw['tgl_stop_l']; ?>" size="10" />
                        <a href="javascript:void(0)"
                            onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_m);return false;"><img
                                src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal4"
                                style="border:none" align="absmiddle" border="0" /></a>
                    </td>
                    <td>
                        <h4>Selesai Stop Mesin 1</h4>
                    </td>
                    <td>:</td>
                    <td width="21%"><input name="stop_selesai" type="text" id="stop_selesai" placeholder="00:00"
                            pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25 " onkeyup="
                            var time = this.value;
                            if (time.match(/^\d{2}$/) !== null) {
                            this.value = time + ':';
                            } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
                            this.value = time + '';
                            }" value="<?php echo $rw['stop_r'] ?>" size="5" maxlength="5" />
                        <input name="tgl_stop_s" type="text" id="tgl_stop_s" placeholder="0000-00-00"
                            onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_s);return false;"
                            value="<?php echo $rw['tgl_stop_r']; ?>" size="10" />
                        <a href="javascript:void(0)"
                            onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_s);return false;"><img
                                src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal5"
                                style="border:none" align="absmiddle" border="0" /></a>
                    </td>
                    <td width="24%">
                        <h4>Kode1:
                            <select name="kd_stop" id="kd_stop">
                                <option value="">Pilih</option>
                                <?php
                                $qry1 = sqlsrv_query($con, "SELECT kode FROM db_finishing.tbl_stop_mesin ORDER BY id ASC");
                                while ($r = sqlsrv_fetch_array($qry1)) {
                                ?>
                                <option value="<?php echo $r['kode']; ?>" <?php if ($rw['kd_stop'] == $r['kode']) {
                                                                                    echo "SELECTED";
                                                                                } ?>><?php echo $r['kode']; ?></option>
                                <?php } ?>
                            </select>
                            <?php if ($_SESSION['lvl'] == "SPV") { ?>
                            <input type="button" name="btnstop" id="btnstop" value="..."
                                onclick="window.open('pages/data-stop.php','MyWindow','height=400,width=650');" />
                            <?php } ?>
                        </h4>
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <h4>Mulai Stop Mesin 2</h4>
                    </td>
                    <td>:</td>
                    <td><input name="stop_mulai2" type="text" id="stop_mulai2" placeholder="00:00"
                            pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25 " onkeyup="
                                    var time = this.value;
                                    if (time.match(/^\d{2}$/) !== null) {
                                        this.value = time + ':';
                                    } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
                                        this.value = time + '';
                                    }" value="<?php echo $rw['stop_l2'] ?>" size="5" maxlength="5" />
                        <input name="tgl_stop_m2" type="text" id="tgl_stop_m2" placeholder="0000-00-00"
                            onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_m2);return false;"
                            value="<?php echo $rw['tgl_stop_l2']; ?>" size="10" />
                        <a href="javascript:void(0)"
                            onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_m2);return false;"><img
                                src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal6"
                                style="border:none" align="absmiddle" border="0" /></a>
                    </td>
                    <td>
                        <h4>Selesai Stop Mesin 2</h4>
                    </td>
                    <td>:</td>
                    <td><input name="stop_selesai2" type="text" id="stop_selesai2" placeholder="00:00"
                            pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25 " onkeyup="
                                    var time = this.value;
                                    if (time.match(/^\d{2}$/) !== null) {
                                        this.value = time + ':';
                                    } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
                                        this.value = time + '';
                                    }" value="<?php echo $rw['stop_r2'] ?>" size="5" maxlength="5" />
                        <input name="tgl_stop_s2" type="text" id="tgl_stop_s2" placeholder="0000-00-00"
                            onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_s2);return false;"
                            value="<?php echo $rw['tgl_stop_r2']; ?>" size="10" />
                        <a href="javascript:void(0)"
                            onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_s2);return false;"><img
                                src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal7"
                                style="border:none" align="absmiddle" border="0" /></a>
                    </td>
                    <td>
                        <h4>Kode2:
                            <select name="kd_stop2" id="kd_stop2">
                                <option value="">Pilih</option>
                                <?php
                                $qry1 = sqlsrv_query($con, "SELECT kode FROM db_finishing.tbl_stop_mesin ORDER BY id ASC");
                                while ($r = sqlsrv_fetch_array($qry1)) {
                                ?>
                                <option value="<?php echo $r['kode']; ?>" <?php if ($rw['kd_stop2'] == $r['kode']) {
                                                                                    echo "SELECTED";
                                                                                } ?>><?php echo $r['kode']; ?></option>
                                <?php } ?>
                            </select>
                            <?php if ($_SESSION['lvl'] == "SPV") { ?>
                            <input type="button" name="btnstop2" id="btnstop2" value="..."
                                onclick="window.open('pages/data-stop.php','MyWindow','height=400,width=650');" />
                            <?php } ?>
                        </h4>
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <h4>Mulai Stop Mesin 3</h4>
                    </td>
                    <td>:</td>
                    <td><input name="stop_mulai3" type="text" id="stop_mulai3" placeholder="00:00"
                            pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25 " onkeyup="
                                            var time = this.value;
                                            if (time.match(/^\d{2}$/) !== null) {
                                                this.value = time + ':';
                                            } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
                                                this.value = time + '';
                                            }" value="<?php echo $rw['stop_l3'] ?>" size="5" maxlength="5" />
                        <input name="tgl_stop_m3" type="text" id="tgl_stop_m3" placeholder="0000-00-00"
                            onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_m3);return false;"
                            value="<?php echo $rw['tgl_stop_l3']; ?>" size="10" />
                        <a href="javascript:void(0)"
                            onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_m3);return false;"><img
                                src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal8"
                                style="border:none" align="absmiddle" border="0" /></a>
                    </td>
                    <td>
                        <h4>Selesai Stop Mesin 3</h4>
                    </td>
                    <td>:</td>
                    <td><input name="stop_selesai3" type="text" id="stop_selesai3" placeholder="00:00"
                            pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25 " onkeyup="
                                        var time = this.value;
                                        if (time.match(/^\d{2}$/) !== null) {
                                        this.value = time + ':';
                                        } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
                                        this.value = time + '';
                                        }" value="<?php echo $rw['stop_r3'] ?>" size="5" maxlength="5" />
                        <input name="tgl_stop_s3" type="text" id="tgl_stop_s3" placeholder="0000-00-00"
                            onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_s3);return false;"
                            value="<?php echo $rw['tgl_stop_r3']; ?>" size="10" />
                        <a href="javascript:void(0)"
                            onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_stop_s3);return false;"><img
                                src="../calender/calender.jpeg" alt="" name="popcal" width="30" height="25" id="popcal9"
                                style="border:none" align="absmiddle" border="0" /></a>
                    </td>
                    <td>
                        <h4>Kode3:
                            <select name="kd_stop3" id="kd_stop3">
                                <option value="">Pilih</option>
                                <?php $qry1 = sqlsrv_query($con, "SELECT kode FROM db_finishing.tbl_stop_mesin ORDER BY id ASC");
                                while ($r = sqlsrv_fetch_array($qry1)) {
                                ?>
                                <option value="<?php echo $r['kode']; ?>" <?php if ($rw['kd_stop3'] == $r['kode']) {
                                                                                    echo "SELECTED";
                                                                                } ?>><?php echo $r['kode']; ?></option>
                                <?php } ?>
                            </select>
                            <?php if ($_SESSION['lvl'] == "SPV") { ?>
                            <input type="button" name="btnstop3" id="btnstop3" value="..."
                                onclick="window.open('pages/data-stop.php','MyWindow','height=400,width=650');" />
                            <?php } ?>
                        </h4>
                    </td>
                </tr>
                <tr>
                    <td scope="row">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>
                        <h4>Operator</h4>
                    </td>
                    <td>:</td>
                    <td colspan="2"><select name="acc_kain" id="acc_kain" required>
                            <option value="">Pilih</option>
                            <?php $qryacc = sqlsrv_query($con, "SELECT nama FROM db_finishing.tbl_staff ORDER BY nama ASC");
                            while ($racc = sqlsrv_fetch_array($qryacc)) {
                            ?>
                            <option value="<?php echo $racc['nama']; ?>" <?php if ($racc['nama'] == $rw['acc_staff']) {
                                                                                    echo "SELECTED";
                                                                                } ?>><?php echo $racc['nama']; ?>
                            </option>
                            <?php } ?>
                        </select>
                        <?php if ($_SESSION['lvl'] == "SPV") { ?>
                        <input type="button" name="btnacc" id="btnacc" value="..."
                            onclick="window.open('pages/data-operator.php','MyWindow','height=400,width=650');" />
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </fieldset>
        <br>
        <input type="submit" name="btnSimpan" id="btnSimpan" value="Simpan" class="art-button" />
        <input type="button" name="batal" id="batal" value="Batal" onclick="window.location.href='index.php'"
            class="art-button" />
        <input type="button" name="button2" id="button2" value="Kembali" onclick="window.location.href='../index.php'"
            class="art-button" />
    </form>
</body>

</html>