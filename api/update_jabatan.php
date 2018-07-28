<?php if(!isset($_SERVER['HTTP_REFERER'])) { ?><script type="text/javascript">document.location  = "./home.php";</script><?php exit(); }  ?>


<?php
$con=mysqli_connect("localhost","root","","db_simpeg");


	$sql =	"SELECT 		update_pangkat.nip,
							update_pangkat.eselon,
							update_pangkat.jabatan 
							FROM update_pangkat,pegawai 
							
							WHERE update_pangkat.nip= pegawai.nipbaru";

	
	
	$result    = mysqli_query($con,$sql);
	$no = 0;

	while($r = $result->fetch_assoc()){

		$no = $no+1;

		$query = " UPDATE pegawai SET 
											eselon				= '$r[eselon]',
											nama_jabatan		= '$r[jabatan]'
											WHERE nipbaru		= '$r[nip]' ";

		$action    = mysqli_query($con,$query);
		
		echo $no."&nbsp;".$r['nip']."updated<br>";
	}







?>