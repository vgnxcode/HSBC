<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>VGN Pdf viewer</title>
	<link rel="stylesheet" type="text/css" href="build/viewer.css">
	
</head>
<body>
	
<?php 
$filepath = $_REQUEST['path'];

?>	
<iframe src="https://cdn.vgn.in/<?php echo $filepath; ?>" style="width: 100%; height: 100%;">
	

</body>
</html>