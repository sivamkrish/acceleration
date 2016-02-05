<?php
$data=$_POST['data'];
$con=mysqli_connect("phonelabsorg.ipowermysql.com","wrdbKxB6VLc","fIT3d0VEbx","wrd_h156hmma46") or die("cannot connect");
$q=mysqli_query($con,"INSERT INTO catchit (data)
VALUES ('".$data."')");
if($q)
{
	$q=mysqli_query($con,"SELECT * FROM catchit ORDER BY id DESC LIMIT 1");
	if($q)
	{
		$row=mysqli_fetch_row($q);
		print $row[0];
	}else{
		print "Error";
	}
}else{
	print "Error";
}
?>