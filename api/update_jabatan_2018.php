
<?php

date_default_timezone_set('Asia/Jakarta');
$waktu = date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s');

$con=mysqli_connect("localhost","root","","db_pare");


	$sql =	"SELECT   	 	a.nip,
							b.golongan,
							b.skpd,
							b.unit_kerja,
							b.eselon,
							b.jabatan


							FROM history_mutasi a 
						
							LEFT JOIN users b ON b.nip = a.nip
						
						
							WHERE a.status = 'pending'";

	
	
	$result    = mysqli_query($con,$sql);
	$no = 0;

	while($r = $result->fetch_assoc()){

		$no = $no+1;

		$query = " UPDATE history_mutasi 	SET 
											skpd_lama			= '$r[skpd]',
											unit_kerja_lama		= '$r[unit_kerja]',
											golongan_lama		= '$r[golongan]',
											eselon_lama			= '$r[eselon]',
											jabatan_lama		= '$r[jabatan]',
											created_at			= '$waktu'
											WHERE nip			= '$r[nip]' ";

		$action    = mysqli_query($con,$query);
		
		echo $no."&nbsp;".$r['nip']."updated<br>";
	}







?>