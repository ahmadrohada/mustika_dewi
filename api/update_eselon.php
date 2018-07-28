
<?php
$con=mysqli_connect("localhost","root","","db_pare");


	$sql =	"SELECT * FROM update_fid ";

	
	
	$result    = mysqli_query($con,$sql);
	$no = 0;

	while($r = $result->fetch_assoc()){

		$no = $no+1;

		$query = " UPDATE users SET 
						tpp				= '$r[tpp]',
						fid				= '$r[fid]',
						WHERE nip		= '$r[nip]' ";

		$action    = mysqli_query($con,$query);
		
		echo $no."&nbsp;".$r['nip']."updated<br>";
	}







?>