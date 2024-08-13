<?php
include ('koneksi.php');
date_default_timezone_set('Asia/Jakarta');
if ($_GET['demand'] != "") {
    $nomordemand = $_GET['demand'];
    $anddemand = "AND DEAMAND = '$nomordemand'";
} else {
    $anddemand = "";
}
$sql_ITXVIEWKK = db2_exec($conn_db2, "SELECT
                                            TRIM(PRODUCTIONORDERCODE) AS PRODUCTIONORDERCODE,
                                            TRIM(DEAMAND) AS DEMAND,
                                            ORIGDLVSALORDERLINEORDERLINE,
                                            PROJECTCODE,
                                            ORDPRNCUSTOMERSUPPLIERCODE,
                                            TRIM(SUBCODE01) AS SUBCODE01, TRIM(SUBCODE02) AS SUBCODE02, TRIM(SUBCODE03) AS SUBCODE03, TRIM(SUBCODE04) AS SUBCODE04,
                                            TRIM(SUBCODE05) AS SUBCODE05, TRIM(SUBCODE06) AS SUBCODE06, TRIM(SUBCODE07) AS SUBCODE07, TRIM(SUBCODE08) AS SUBCODE08,
                                            TRIM(SUBCODE09) AS SUBCODE09, TRIM(SUBCODE10) AS SUBCODE10, 
                                            TRIM(ITEMTYPEAFICODE) AS ITEMTYPEAFICODE,
                                            TRIM(DSUBCODE05) AS NO_WARNA,
                                            TRIM(DSUBCODE02) || '-' || TRIM(DSUBCODE03)  AS NO_HANGER,
                                            TRIM(ITEMDESCRIPTION) AS ITEMDESCRIPTION,
                                            DELIVERYDATE,
                                            LOT
                                        FROM 
                                            ITXVIEWKK 
                                        WHERE 
                                            PRODUCTIONORDERCODE = '$idkk' $anddemand");
$dt_ITXVIEWKK = db2_fetch_assoc($sql_ITXVIEWKK);

$sql_pelanggan_buyer = db2_exec($conn_db2, "SELECT TRIM(LANGGANAN) AS PELANGGAN, TRIM(BUYER) AS BUYER FROM ITXVIEW_PELANGGAN 
                                                        WHERE ORDPRNCUSTOMERSUPPLIERCODE = '$dt_ITXVIEWKK[ORDPRNCUSTOMERSUPPLIERCODE]' AND CODE = '$dt_ITXVIEWKK[PROJECTCODE]'");
$dt_pelanggan_buyer = db2_fetch_assoc($sql_pelanggan_buyer);

$sql_demand = db2_exec($conn_db2, "SELECT LISTAGG(TRIM(DEAMAND), ', ') AS DEMAND,
                                                LISTAGG(''''|| TRIM(ORIGDLVSALORDERLINEORDERLINE) ||'''', ', ')  AS ORIGDLVSALORDERLINEORDERLINE
                                        FROM ITXVIEWKK 
                                        WHERE PRODUCTIONORDERCODE = '$nokk'");
$dt_demand = db2_fetch_assoc($sql_demand);

if (!empty($dt_demand['ORIGDLVSALORDERLINEORDERLINE'])) {
    $orderline = $dt_demand['ORIGDLVSALORDERLINEORDERLINE'];
} else {
    $orderline = '0';
}

$sql_po = db2_exec($conn_db2, "SELECT TRIM(EXTERNALREFERENCE) AS NO_PO FROM ITXVIEW_KGBRUTO 
                    WHERE PROJECTCODE = '$dt_ITXVIEWKK[PROJECTCODE]' AND ORIGDLVSALORDERLINEORDERLINE IN ($orderline)");
$dt_po = db2_fetch_assoc($sql_po);

$sql_noitem = db2_exec($conn_db2, "SELECT * FROM ORDERITEMORDERPARTNERLINK WHERE INACTIVE = 0 
                    AND ORDPRNCUSTOMERSUPPLIERCODE = '$dt_ITXVIEWKK[ORDPRNCUSTOMERSUPPLIERCODE]' 
                    AND SUBCODE01 = '$dt_ITXVIEWKK[SUBCODE01]' AND SUBCODE02 = '$dt_ITXVIEWKK[SUBCODE02]' 
                    AND SUBCODE03 = '$dt_ITXVIEWKK[SUBCODE03]' AND SUBCODE04 = '$dt_ITXVIEWKK[SUBCODE04]' 
                    AND SUBCODE05 = '$dt_ITXVIEWKK[SUBCODE05]' AND SUBCODE06 = '$dt_ITXVIEWKK[SUBCODE06]'
                    AND SUBCODE07 = '$dt_ITXVIEWKK[SUBCODE07]' AND SUBCODE08 ='$dt_ITXVIEWKK[SUBCODE08]'
                    AND SUBCODE09 = '$dt_ITXVIEWKK[SUBCODE09]' AND SUBCODE10 ='$dt_ITXVIEWKK[SUBCODE10]'");
$dt_item = db2_fetch_assoc($sql_noitem);

$sql_lebargramasi = db2_exec($conn_db2, "SELECT i.LEBAR,
                                            CASE
                                                WHEN i2.GRAMASI_KFF IS NULL THEN i2.GRAMASI_FKF
                                                ELSE i2.GRAMASI_KFF
                                            END AS GRAMASI 
                                            FROM 
                                                ITXVIEWLEBAR i 
                                            LEFT JOIN ITXVIEWGRAMASI i2 ON i2.SALESORDERCODE = '$dt_ITXVIEWKK[PROJECTCODE]' AND i2.ORDERLINE = '$dt_ITXVIEWKK[ORIGDLVSALORDERLINEORDERLINE]'
                                            WHERE 
                                                i.SALESORDERCODE = '$dt_ITXVIEWKK[PROJECTCODE]' AND i.ORDERLINE = '$dt_ITXVIEWKK[ORIGDLVSALORDERLINEORDERLINE]'");
$dt_lg = db2_fetch_assoc($sql_lebargramasi);

$sql_warna = db2_exec($conn_db2, "SELECT DISTINCT TRIM(WARNA) AS WARNA FROM ITXVIEWCOLOR 
                                            WHERE ITEMTYPECODE = '$dt_ITXVIEWKK[ITEMTYPEAFICODE]' 
                                            AND SUBCODE01 = '$dt_ITXVIEWKK[SUBCODE01]' 
                                            AND SUBCODE02 = '$dt_ITXVIEWKK[SUBCODE02]'
                                            AND SUBCODE03 = '$dt_ITXVIEWKK[SUBCODE03]' 
                                            AND SUBCODE04 = '$dt_ITXVIEWKK[SUBCODE04]'
                                            AND SUBCODE05 = '$dt_ITXVIEWKK[SUBCODE05]' 
                                            AND SUBCODE06 = '$dt_ITXVIEWKK[SUBCODE06]'
                                            AND SUBCODE07 = '$dt_ITXVIEWKK[SUBCODE07]' 
                                            AND SUBCODE08 = '$dt_ITXVIEWKK[SUBCODE08]'
                                            AND SUBCODE09 = '$dt_ITXVIEWKK[SUBCODE09]' 
                                            AND SUBCODE10 = '$dt_ITXVIEWKK[SUBCODE10]'");
$dt_warna = db2_fetch_assoc($sql_warna);

$sql_qtyorder = db2_exec($conn_db2, "SELECT DISTINCT
												GROUPSTEPNUMBER,
                                                INITIALUSERPRIMARYQUANTITY AS QTY_ORDER,
                                                INITIALUSERSECONDARYQUANTITY AS QTY_ORDER_YARD
                                            FROM 
                                                VIEWPRODUCTIONDEMANDSTEP 
                                            WHERE 
                                                PRODUCTIONORDERCODE = '$idkk'
											ORDER BY
												GROUPSTEPNUMBER ASC LIMIT 1");
$dt_qtyorder = db2_fetch_assoc($sql_qtyorder);

$sql_roll = db2_exec($conn_db2, "SELECT count(*) AS ROLL, s2.PRODUCTIONORDERCODE
                FROM STOCKTRANSACTION s2 
                WHERE  (s2.ITEMTYPECODE ='KGF' OR s2.ITEMTYPECODE = 'KFF') AND s2.PRODUCTIONORDERCODE = '$dt_ITXVIEWKK[PRODUCTIONORDERCODE]'
                GROUP BY s2.PRODUCTIONORDERCODE");
$dt_roll = db2_fetch_assoc($sql_roll);

$sql_mesinknt = db2_exec($conn_db2, "SELECT 
                                            s.LOTCODE,
                                            a.VALUESTRING 
                                        FROM STOCKTRANSACTION s 
                                        LEFT JOIN PRODUCTIONDEMAND p ON p.CODE = s.LOTCODE 
                                        LEFT JOIN ADSTORAGE a ON a.UNIQUEID = p.ABSUNIQUEID AND a.NAMENAME = 'MachineNo'
                                        WHERE s.PRODUCTIONORDERCODE = '$nokk'");
$dt_mesinknt = db2_fetch_assoc($sql_mesinknt);

$sql_bonresep1 = db2_exec($conn_db2, "SELECT
                                            TRIM(PRODUCTIONRESERVATION.PRODUCTIONORDERCODE) AS PRODUCTIONORDERCODE,
                                            TRIM(PRODUCTIONRESERVATION.PRODUCTIONORDERCODE) || '-' || TRIM(PRODUCTIONRESERVATION.GROUPLINE) AS BONRESEP1,
                                            TRIM(SUFFIXCODE) AS SUFFIXCODE
                                        FROM
                                            PRODUCTIONRESERVATION PRODUCTIONRESERVATION 
                                        WHERE
                                            -- (PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFD' OR PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFF')
                                            PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFD' AND PRODUCTIONRESERVATION.PRODUCTIONORDERCODE = '$nokk' 
                                            AND NOT SUFFIXCODE = '001'
                                        ORDER BY
                                            PRODUCTIONRESERVATION.GROUPLINE ASC LIMIT 1");
$dt_bonresep1 = db2_fetch_assoc($sql_bonresep1);

$sql_bonresep2 = db2_exec($conn_db2, "SELECT
                                            TRIM( PRODUCTIONRESERVATION.PRODUCTIONORDERCODE ) AS PRODUCTIONORDERCODE,
                                            TRIM(PRODUCTIONRESERVATION.PRODUCTIONORDERCODE) || '-' || TRIM(PRODUCTIONRESERVATION.GROUPLINE) AS BONRESEP2,
                                            TRIM(SUFFIXCODE) AS SUFFIXCODE
                                        FROM
                                            PRODUCTIONRESERVATION PRODUCTIONRESERVATION 
                                        WHERE
                                            -- (PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFD' OR PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFF')
                                            PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFD' AND PRODUCTIONRESERVATION.PRODUCTIONORDERCODE = '$nokk' 
                                            AND NOT SUFFIXCODE = '001'
                                        ORDER BY
                                            PRODUCTIONRESERVATION.GROUPLINE DESC LIMIT 1");
$dt_bonresep2 = db2_fetch_assoc($sql_bonresep2);
?>