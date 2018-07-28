
<?php

date_default_timezone_set('Asia/Jakarta');
$waktu = date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s');

$con=mysqli_connect("localhost","root","","db_pare");


	$sql =	"SELECT  	a.id as mutasi_id,
						a.nip,
						a.status,
						a.step,
						a.golongan_lama,
						a.jabatan_lama,
						a.eselon_lama,
						a.skpd_lama,
						a.unit_kerja_lama,
                        b.id  as skp_bulanan_id
						

						FROM history_mutasi a 
                        
                        RIGHT JOIN skp_bulanan b On b.u_nip = a.nip and YEAR(b.tgl_mulai) = '2018'
						
						WHERE a.status = 'pending' AND a.step = '1' ";

	
	
	$result    = mysqli_query($con,$sql);
	$no = 0;

	while($r = $result->fetch_assoc()){

		$no = $no+1;

		$query = " UPDATE skp_bulanan 	SET 
											u_skpd			= '$r[skpd_lama]',
											u_unit_kerja	= '$r[unit_kerja_lama]',
											u_golongan		= '$r[golongan_lama]',
											u_jabatan		= '$r[jabatan_lama]'
											
											WHERE id		= '$r[skp_bulanan_id]' ";

		$action    = mysqli_query($con,$query);
		
		echo $no."&nbsp;".$r['nip']."updated<br>";
	}







?>