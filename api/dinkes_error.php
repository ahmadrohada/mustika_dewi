
<?php
$con=mysqli_connect("192.168.20.22","pare","pare!","db_pare");


	$sql =	"SELECT a.nip,
					a.unit_kerja
					FROM users_dinkes a
					LEFT JOIN users b ON b.nip = a.nip
						
					";

	
	
	$result    = mysqli_query($con,$sql);
	$no = 0;

	while($r = $result->fetch_assoc()){

		$no = $no+1;

		$query = " UPDATE users SET 
						unit_kerja		= '$r[unit_kerja]'
						WHERE nip		= '$r[nip]' ";

		$action    = mysqli_query($con,$query);
		
		echo $no."&nbsp;".$r['nip']."updated<br>";
	}







?>