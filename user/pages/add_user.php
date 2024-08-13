<?php
if($_POST){ 
	extract($_POST);
	$id = mysql_real_escape_string($_POST['id']);
	$user = mysql_real_escape_string($_POST['username']); 
	$pass = mysql_real_escape_string($_POST['password']);   
    $repass = mysql_real_escape_string($_POST['re_password']); 
    $level = mysql_real_escape_string($_POST['level']);
    $status = mysql_real_escape_string($_POST['status']);
$datauser=mysql_query("SELECT count(*) as jml FROM user_login WHERE `user`='$user' LIMIT 1");
$row=mysql_fetch_array($datauser);
	if($row[jml]>0){
		echo " <script>alert('Someone already has this usernm1!');</script>";
	}
	else if($pass!=$repass)
		{
			echo " <script>alert('Not Match Re-New Password!');</script>";
			}else
			{
				$sqlupdate=mysql_query("INSERT INTO `user_login` SET 
				`user`='$user', 
				`password`='$pass',
				`level`='$level',
				`status`='$status',
				`dept`='FIN'
				");
				echo " <script>alert('Data has been saved!');window.location='?p=user';</script>";
				}
		
		}
		

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add User</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="357" border="0">
    <tr>
      <td colspan="3"><h2>ADD USER</h2></td>
    </tr>
    <tr>
      <td width="145">Username</td>
      <td width="3">:</td>
      <td width="195"><label for="username"></label>
      <input type="text" name="username" id="username" /></td>
    </tr>
    <tr>
      <td>Password</td>
      <td>:</td>
      <td><label for="password"></label>
      <input type="password" name="password" id="password" /></td>
    </tr>
    <tr>
      <td>Re-Password</td>
      <td>:</td>
      <td><label for="re_password"></label>
      <input type="password" name="re_password" id="re_password" /></td>
    </tr>
    <tr>
      <td>Level</td>
      <td>&nbsp;</td>
      <td><label for="level"></label>
        <select name="level" id="level">
          <option value="Operator" selected="selected">Operator</option>
          <option value="Adm">Adm</option>
          <option value="SPV">SPV</option>
      </select></td>
    </tr>
    <tr>
      <td>Status</td>
      <td>&nbsp;</td>
      <td><p>
        <label>
          <input name="status" type="radio" id="status_0" value="Aktif" checked="checked" />
          Aktif</label>
        <br />
        <label>
          <input type="radio" name="status" value="Non-Aktif" id="status_1" />
          Non-Aktif</label>
        <br />
      </p></td>
    </tr>
    <tr>
      <td colspan="3"><input type="submit" name="Save" id="Save" value="SAVE" class="art-button" />
      <input type="button" name="Cancel" id="Cancel" value="CANCEL" class="art-button" onclick="window.location='?p=user'" /></td>
    </tr>
  </table>
</form>
</body>
</html>