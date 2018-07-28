
<?php

date_default_timezone_set('Asia/Jakarta');
$waktu = date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s');

$con=mysqli_connect("192.168.20.22","pare","pare!","db_pare");


	$sql =	"SELECT  	a.id,
						b.id as mutasi_id,
						b.status,
						b.step,
						a.nip,
						a.golongan,
						b.golongan_lama,
						a.jabatan,
						b.jabatan_lama,
						a.eselon,
						b.eselon_lama,
						a.skpd,
						b.skpd_lama,
						a.unit_kerja,
						b.unit_kerja_lama
						

						FROM users a
						
						RIGHT JOIN history_mutasi b ON b.nip = a.nip AND b.status = 'pending' AND b.step = '1'
						
						WHERE b.status = 'pending'";

	
	
	$result    = mysqli_query($con,$sql);
	$no = 0;

	while($r = $result->fetch_assoc()){

		$no = $no+1;

		$query = " UPDATE users 	SET 
											skpd			= '$r[skpd_lama]',
											unit_kerja		= '$r[unit_kerja_lama]',
											golongan		= '$r[golongan_lama]',
											eselon			= '$r[eselon_lama]',
											jabatan			= '$r[jabatan_lama]'
											
											WHERE nip			= '$r[nip]' ";

		$action    = mysqli_query($con,$query);
		
		echo $no."&nbsp;".$r['nip']."updated<br>";
	}







?>