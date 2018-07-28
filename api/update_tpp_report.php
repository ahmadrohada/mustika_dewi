
<?php
$con=mysqli_connect("192.168.20.22","pare","pare!","db_pare");


	$sql =	"SELECT * FROM tpp_puskesmas ";

	
	
	$result    = mysqli_query($con,$sql);
	$no = 0;

	while($r = $result->fetch_assoc()){

		$no = $no+1;
		
		
		$tpp 			= $r['tpp'];
	
		$tpp_kinerja	= (40/100)* $tpp ;
		$tpp_kehadiran	= (60/100)* $tpp ;

		$query = " UPDATE tpp_report SET 
											
											tpp_rupiah		= '$tpp',
											tpp_kinerja		= '$tpp_kinerja',
											tpp_kehadiran	= '$tpp_kehadiran'
											
						
											WHERE nip		= '$r[nip]' ";

		$action    = mysqli_query($con,$query);
		
		echo $no."&nbsp;".$r['nip']."updated<br>";
	}







?>