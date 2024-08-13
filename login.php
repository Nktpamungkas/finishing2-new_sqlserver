<?php
ini_set("error_reporting", 1);
session_start();
include_once('koneksi.php');

?>
<?PHP
if ($_POST) { //login user
  extract($_POST);
  $username = mysqli_real_escape_string($con, $_POST['username']);
  $password = mysqli_real_escape_string($con, $_POST['password']);
  $level    =  mysqli_real_escape_string($con, $_POST['level']);
  $sql = mysqli_query($con, "SELECT * FROM user_login WHERE user='$username' AND `PASSWORD`='$password' AND LEVEL = '$level' AND `status`='Aktif' LIMIT 1");
  if (mysqli_num_rows($sql) > 0) {
    $_SESSION['usr'] = $username;
    $_SESSION['pass'] = $password;
    $_SESSION['lvl'] = $level;
    $r = mysqli_fetch_array($sql);
    $_SESSION['sts'] = $r['status'];
    $_SESSION['start'] = time(); // Taking now logged in time.
    // Ending a session in 30 minutes from the starting time.
    $_SESSION['expire'] = $_SESSION['start'] + (300 * 60);
    //login_validate();
    echo "<script>alert('Login Success!! $username');window.location='index.php';</script>";
  } else {
    echo "<script>alert('Login Failed!! $username');window.location='login.php';</script>";
  }
} else
if ($_GET['act'] == "logout") { //logout user
  unset($_SESSION['usr']);
  echo "<script>alert('You are Logged out!! Klik OK to redirect'); window.location='login.php';</script>";
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head><!-- Created by Artisteer v4.3.0.60745 -->
  <meta charset="utf-8">
  <title>Login</title>
  <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">

  <!--[if lt IE 9]><script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  <link rel="stylesheet" href="style.css" media="screen">
  <!--[if lte IE 7]><link rel="stylesheet" href="style.ie7.css" media="screen" /><![endif]-->
  <link rel="stylesheet" href="style.responsive.css" media="all">
  <link rel="icon" type="image/png" href="images/index.gif">

  <script src="jquery.js"></script>
  <script src="script.js"></script>
  <script src="script.responsive.js"></script>


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
          <li><a href="index.php" class="active">Main</a></li>
          <li><a href="reports/">Reports</a></li>
          <li><a href="login.php">Log In</a></li>
        </ul>
      </div>
    </nav>
    <div class="art-sheet clearfix">
      <div class="art-layout-wrapper">
        <div class="art-content-layout">
          <div class="art-content-layout-row">
            <div class="art-layout-cell art-content">
              <article class="art-post art-article">
                <form name="form1" method="post" action="">
                  <table width="200" border="0" align="center">
                    <tr>
                      <td width="108" align="right">Username</td>
                      <td width="76"><input name="username" type="text" id="username"></td>
                    </tr>
                    <tr>
                      <td align="right">Password</td>
                      <td><input name="password" type="password" id="password"></td>
                    </tr>
                    <tr>
                      <td align="right">Level</td>
                      <td><select name="level" id="level">
                          <option value="Operator">Operator</option>
                          <option value="Adm">Adm</option>
                          <option value="SPV">SPV</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center"><input type="submit" name="login" id="login" value="LOGIN" class="art-button"></td>
                    </tr>
                  </table>
                </form>



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


</body>

</html>