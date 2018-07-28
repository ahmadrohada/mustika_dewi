
<?php
$con=mysqli_connect("192.168.20.22","pare","pare!","db_pare");


	$sql =	"SELECT id,nip,tpp FROM users WHERE tpp > 0 ";

	
	
	$result    = mysqli_query($con,$sql);
	$no = 0;

	while($r = $result->fetch_assoc()){

		$no = $no+1;

		$query = " UPDATE skp_bulanan SET 
						tpp_bulanan		= '$r[tpp]'
						
						WHERE user_id	= '$r[id]' 
						AND tgl_mulai 	= '2018-08-01' ";

		$action    = mysqli_query($con,$query);
		
		echo $no."&nbsp;".$r['nip']."updated<br>";
	}







?>