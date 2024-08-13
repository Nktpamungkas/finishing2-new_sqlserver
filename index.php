<?php
/*session_start();
		$now = time(); // Checking the time now when home page starts.

        if ($now > $_SESSION['expire']) {
            session_destroy();
            echo "Your session has expired! <a href='login.php'>Login here</a>";
        }*/
ini_set("error_reporting", 1);
session_start();
include_once ('koneksi.php');
$timeout = 480; // Set timeout menit
$logout_redirect_url = "login.php"; // Set logout URL

$timeout = $timeout * 60; // Ubah menit ke detik
if (isset($_SESSION['start_time'])) {
    $elapsed_time = time() - $_SESSION['start_time'];
    if ($elapsed_time >= $timeout) {
        session_destroy();
        echo "<script>alert('Session Anda Telah Habis!'); window.location = '$logout_redirect_url'</script>";
    }
}
$_SESSION['start_time'] = time();
//include config
//require_once "waktu.php";
include_once ('koneksi.php');

?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US"><head><!-- Created by Artisteer v4.3.0.60745 -->
    <meta charset="utf-8">
    <title>Produksi Harian Finishing</title>
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">

    <!--[if lt IE 9]><script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link rel="stylesheet" href="style.css" media="screen">
    <!--[if lte IE 7]><link rel="stylesheet" href="style.ie7.css" media="screen" /><![endif]-->
    <link rel="stylesheet" href="style.responsive.css" media="all">
<link rel="icon" type="image/png" href="images/index.gif">

    <script src="jquery.js"></script>
    <script src="script.js"></script>
    <script src="script.responsive.js"></script>


<style>.art-content .art-postcontent-0 .layout-item-0 { margin-bottom: 10px;  }
.art-content .art-postcontent-0 .layout-item-1 { border-top-style:solid;border-right-style:solid;border-bottom-style:solid;border-left-style:solid;border-width:0px;border-color:#D1DBE0; color: #FFFFFF; background: #1F5C98; border-spacing: 0px 10px; border-collapse: separate;  }
.art-content .art-postcontent-0 .layout-item-2 { border-right-style:Dotted;border-right-width:1px;border-right-color:#4991DA; color: #FFFFFF; padding-right: 30px;padding-left: 30px;  }
.art-content .art-postcontent-0 .layout-item-3 { color: #FFFFFF; padding-right: 30px;padding-left: 30px;  }
.ie7 .art-post .art-layout-cell {border:none !important; padding:0 !important; }
.ie6 .art-post .art-layout-cell {border:none !important; padding:0 !important; }

</style></head>
<body>
<div id="art-main">
<nav class="art-nav">
    <div class="art-nav-inner">
    <ul class="art-hmenu">
    <li><a href="index.php" class="active">Main</a></li>
    <?php if($_SESSION['lvl']!="Operator"){ ?>
    <li><a href="masuk/?typekk=NOW">Masuk</a></li>
    <?php } ?>
    <!-- <li><a href="stenter/?typekk=NOW">Stenter</a></li>
    <li><a href="compact/?typekk=SCHEDULE">Compact</a></li>
    <li><a href="belah-lipat/?typekk=NOW">Belah &amp; Lipat</a></li>
    <li><a href="oven/?typekk=SCHEDULE">Oven</a></li>
	<li><a href="steamer/?typekk=SCHEDULE">Steamer</a></li>	 -->
    
    <li><a href="stenter/?typekk=SCHEDULE">Stenter</a></li>
    <li><a href="compact/?typekk=SCHEDULE">Compact</a></li>
    <li><a href="belah-lipat/?typekk=NOW">Belah Cuci</a></li>
    <li><a href="lipat-inspek/?typekk=SCHEDULE">Lipat/Inspek</a></li>
    <li><a href="oven/?typekk=SCHEDULE">Oven</a></li>
	<li><a href="steamer/?typekk=SCHEDULE">Steamer</a></li>	
    <?php if($_SESSION['lvl']!="Operator"){ ?>
    <li><a href="keluar/">Keluar</a></li>
    <?php } ?>
    <li><a href="reports/">Reports</a></li>
    <?php if( !isset($_SESSION['usr']) || !isset($_SESSION['pass'])){?>
    <li><a href="login.php">Log In</a></li>
    <?php }else{ ?>    
    <li><a href="login.php?act=logout">Log Out</a></li>
    <?php } ?>
    </ul> 
    </div>
    </nav>
<div class="art-sheet clearfix">
            <div class="art-layout-wrapper">
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-content"><article class="art-post art-article">
                <div class="art-postcontent art-postcontent-0 clearfix"><div class="art-content-layout-wrapper layout-item-0">
<div class="art-content-layout layout-item-1">
    <div class="art-content-layout-row">
    <div class="art-layout-cell layout-item-2" style="width: 33%" >
        <h5>Stenter</h5>
        <p><span style="font-style:italic;">Input data harian Finishing Stenter.</span></p>
        <p style="text-align: center;"><img width="200" height="120" alt="" src="images/Balls_01.png" class=""><br></p>
        <p>Form input data harian produksi Finishing Stenter.&nbsp;</p>
        <p><a href="stenter/" class="art-button">Read more</a></p>
    </div><div class="art-layout-cell layout-item-2" style="width: 34%" >
        <h5>Reports</h5>
        <p><span style="font-style:italic;">Laporan  produksi Finishing.</span></p>
        <p style="text-align: center;"><img width="200" height="120" alt="" src="images/Graph_01.png" class=""><br></p>
        <p>Laporan hasil produksi Finishing harian dan bulanan.</p>
        <p><a href="reports/" class="art-button">Read more</a></p>
    </div><div class="art-layout-cell layout-item-3" style="width: 33%" >
        <h5>Users</h5>
        <p><span style="font-style:italic;">Data User&nbsp;</span></p>
        <p style="text-align: center;"><img width="200" height="120" alt="" src="images/Puzzle_01.png" class=" art-preview-selected"><br></p>
        <p>Data User login finishing</p>
        <p><a href="user/" class="art-button">Read more</a></p>
    </div>
    </div>
</div>
</div>
</div>
                                
                

</article></div>
                    </div>
                </div>
            </div>
    </div>
<footer class="art-footer">
  <div class="art-footer-inner">
<div class="art-content-layout">
    <div class="art-content-layout-row">
    <div class="art-layout-cell layout-item-0" style="width: 50%">
        
    </div><div class="art-layout-cell layout-item-0" style="width: 100%">
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


</body></html>