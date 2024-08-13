<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Grafik</title>
<body>
<?php if($_POST['jenis']=="Tahun"){
	include "grafik-column.php";
}
	else if($_POST['jenis']=="Bulan"){
		include"grafik-pie.php";
	}
	
?>
</body>
</html>
