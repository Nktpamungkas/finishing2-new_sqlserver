<?PHP
session_start();
include"../koneksi.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>user</title>
<link rel="stylesheet" type="text/css" href="../css/datatable.css" />
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" />
<script src="../js/jquery.js" type="text/javascript"></script>
<script src="../js/jquery.dataTables.js" type="text/javascript"></script>
<script>
function confirmDelete(url) {
    if (confirm("Yakin Hapus data ini?")) {
        window.location.href=url;
    } else {
        false;
    }       
}
	$(document).ready(function(){
		$('#datatables').dataTable({
			"sScrollY": "400px",
			"sScrollX": "100%",
			"bScrollCollapse": true,
			"bPaginate": false,
			"bJQueryUI": true
		});			
	})
</script>
</head>

<body>
<a href="?p=add_user"><img src="../images/btn_add_data.png" alt="add data" width="120" height="34"  /></a>
<?php
   $datauser=mysql_query("SELECT * FROM user_login WHERE `dept`='FIN'");
	$no=1;
	$n=1;
	$c=0;
	 ?>
<table width="100%" border="0" id="datatables" class="display">
 <thead>
  <tr>
    <th width="4%">No</th>
    <th width="66%">UserName</th>
    <th width="17%">Level</th>
    <th width="8%">Status</th>
    <th width="5%">Action</th>
  </tr>
  </thead>
  <tbody>
  <?php
  while($rowd=mysql_fetch_array($datauser)){ 
		$bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
			
		 ?> 
  <tr bgcolor="<?php echo $bgcolor1;?>">
    <td><?php echo $no;?></td>
    <td><?php echo $rowd['user'];?></td>
    <td><?php echo $rowd['level'];?></td>
    <td><?php echo $rowd['status'];?></td>
    <td><a href="?p=edit_user&id=<?php echo $rowd['id'] ?>" title="[Edit]"><img src="../images/btn_edit.png" alt="edit" width="16" height="16"  /></a></td>
  </tr>
  <?php 
  $no++;} ?>
  </tbody>
  
</table>


</body>
</html>