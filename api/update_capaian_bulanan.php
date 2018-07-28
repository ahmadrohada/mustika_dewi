
<?php
$con=mysqli_connect("localhost","root","","db_pare");


	$sql =	"SELECT 	a.id as skp_id,
									jm_kegiatan
														
									FROM skp_tahunan a 
									LEFT JOIN (SELECT  id,skp_id,COUNT(id) AS jm_kegiatan FROM kegiatan_tahunan GROUP BY skp_id) b ON b.skp_id = a.id
								";

	
	
	$result    = mysqli_query($con,$sql);
	$no = 0;

	while($r = $result->fetch_assoc()){

		$no = $no+1;

		$query = " UPDATE skp_tahunan SET 
											status			= 1
											
											
											WHERE 
											id				= '$r[skp_id]' ";

		$action    = mysqli_query($con,$query);
		
		echo $no."&nbsp;".$r['skp_id']."updated<br>";
	}







?>