
<?php
$con=mysqli_connect("192.168.20.22","pare","pare!","db_pare");


	$sql =	"SELECT * FROM tpp_puskesmas ";

	
	
	$result    = mysqli_query($con,$sql);
	$no = 0;

	while($r = $result->fetch_assoc()){

		$no = $no+1;

		$query = " UPDATE users SET 
						tpp				= '$r[tpp]'
						
						WHERE nip		= '$r[nip]' ";

		$action    = mysqli_query($con,$query);
		
		echo $no."&nbsp;".$r['nip']."updated<br>";
	}







?>