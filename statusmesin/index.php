<?php
    ini_set("error_reporting", 1);
    session_start();
    // $timeout = 10; // Set timeout menit
    // $logout_redirect_url = "../login.php"; // Set logout URL

    // $timeout = $timeout * 60; // Ubah menit ke detik
    // if (isset($_SESSION['start_time'])) {
    //     $elapsed_time = time() - $_SESSION['start_time'];
    //     if ($elapsed_time >= $timeout) {
    //         session_destroy();
    //         echo "<script>alert('Session Anda Telah Habis!'); window.location = '$logout_redirect_url'</script>";
    //     }
    //     // else{
    //     //     echo $elapsed_time;
    //     //     echo $timeout;
    //     // }
    // }
    // $_SESSION['start_time'] = time();
    //request page
    $page   = isset($_GET['p']) ? $_GET['p'] : '';
    $act    = isset($_GET['act']) ? $_GET['act'] : '';
    $id     = isset($_GET['id']) ? $_GET['id'] : '';
    $page   = strtolower($page);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head><!-- Created by Artisteer v4.3.0.60745 -->
    <meta charset="utf-8">
    <title>FINISHING | STATUS MESIN</title>
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">
    <link rel="icon" type="image/png" href="../images/icon.png">
    <link rel="stylesheet" href="../style.css" media="screen">
</head>

<body>
    <div id="art-main">
        <div class="art-sheet clearfix">
            <div class="art-layout-wrapper">
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-content">
                            <article class="art-post art-article">
                                <?php
                                    if (!empty($page) and !empty($act)) {
                                        $files = 'pages/' . $page . '.' . $act . '.php';
                                    } else if (!empty($page)) {
                                        $files = 'pages/' . $page . '.php';
                                    } else {
                                        $files = 'pages/home.php';
                                    }

                                    if (file_exists($files)) {
                                        include_once($files);
                                    } else {
                                        echo '<img src="../images/404.png" width="668" height="437">';
                                    }
                                ?>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <iframe width=174 height=189 name="gToday:normal:../calender/agenda.js" id="gToday:normal:../calender/agenda.js" src="../calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
    </iframe>
</body>
</html>