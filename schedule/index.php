<?php
    ini_set("error_reporting", 1);
    session_start();
    $timeout = 10; // Set timeout menit
    $logout_redirect_url = "../login.php"; // Set logout URL

    $timeout = $timeout * 60; // Ubah menit ke detik
    if (isset($_SESSION['start_time'])) {
        $elapsed_time = time() - $_SESSION['start_time'];
        if ($elapsed_time >= $timeout) {
            session_destroy();
            echo "<script>alert('Session Anda Telah Habis!'); window.location = '$logout_redirect_url'</script>";
        }
        // else{
        //     echo $elapsed_time;
        //     echo $timeout;
        // }
    }
    $_SESSION['start_time'] = time();
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
    <title>SCHEDULE FINISHING</title>
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">
    <link rel="icon" type="image/png" href="../images/icon.png">
    <!--[if lt IE 9]><script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link rel="stylesheet" href="../style.css" media="screen">
    <!--[if lte IE 7]><link rel="stylesheet" href="style.ie7.css" media="screen" /><![endif]-->
    <link rel="stylesheet" href="../style.responsive.css" media="all">
    <link rel="icon" type="image/png" href="../images/index.gif">

    <script src="../jquery.js"></script>
    <script src="../script.js"></script>
    <script src="../script.responsive.js"></script>
    <link href="../sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="../sweetalert/sweetalert2.min.js"></script>
    <style>
        .art-content .art-postcontent-0 .layout-item-0 {
            margin-bottom: 10px;
        }

        .art-content .art-postcontent-0 .layout-item-1 {
            border-top-style: solid;
            border-right-style: solid;
            border-bottom-style: solid;
            border-left-style: solid;
            border-width: 0px;
            border-color: #D1DBE0;
            color: #FFFFFF;
            background: #1F5C98;
            border-spacing: 0px 10px;
            border-collapse: separate;
        }

        .art-content .art-postcontent-0 .layout-item-2 {
            border-right-style: Dotted;
            border-right-width: 1px;
            border-right-color: #4991DA;
            color: #FFFFFF;
            padding-right: 30px;
            padding-left: 30px;
        }

        .art-content .art-postcontent-0 .layout-item-3 {
            color: #FFFFFF;
            padding-right: 30px;
            padding-left: 30px;
        }

        .ie7 .art-post .art-layout-cell {
            border: none !important;
            padding: 0 !important;
        }

        .ie6 .art-post .art-layout-cell {
            border: none !important;
            padding: 0 !important;
        }
    </style>
</head>

<body>
    <div id="art-main">
        <nav class="art-nav">
            <div class="art-nav-inner">
                <ul class="art-hmenu">
                    <li><a href="../index.php">Main</a></li>
                    <?php if ($_SESSION['lvl'] != "Operator") { ?>
                        <li><a href="../masuk/?typekk=NOW">Masuk</a></li>
                    <?php } ?>
                    <li><a href="?typekk=NOW" class="active">Schedule</a></li>
                    <li><a href="../statusmesin/">Status Mesin</a></li>
                    <?php if (!isset($_SESSION['usr']) || !isset($_SESSION['pass'])) { ?>
                        <li><a href="../login.php">Log In</a></li>
                    <?php } else { ?>
                        <li><a href="../login.php?act=logout">Log Out</a></li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
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
        <footer class="art-footer">
            <div class="art-footer-inner">
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell layout-item-0" style="width: 50%">

                        </div>
                        <div class="art-layout-cell layout-item-0" style="width: 100%">
                            <p style="float:center;">
                                Copyright © 2017 All Rights Reserved.</p>
                        </div>
                    </div>
                </div>
                <p class="art-page-footer">
                    <span id="art-footnote-links">Web Template created with Dept. DIT</span>
                </p>
            </div>
        </footer>
    </div>
    <iframe width=174 height=189 name="gToday:normal:../calender/agenda.js" id="gToday:normal:../calender/agenda.js" src="../calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
    </iframe>
</body>
</html>