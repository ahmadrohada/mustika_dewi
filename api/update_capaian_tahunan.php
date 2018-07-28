
<?php
$con=mysqli_connect("localhost","root","","db_pare");


	$sql =	"SELECT  	b.id as capaian_tahunan_id,
						a.id as skp_tahunan_id,
						a.u_nama,
						a.u_nip,
						a.u_golongan,
						a.u_jabatan,
						a.u_skpd,
						a.u_unit_kerja,
						a.p_nama,
						a.p_nip,
						a.p_golongan,
						a.p_jabatan,
						a.p_skpd,
						a.p_unit_kerja
					   
						

						FROM skp_tahunan a 
						RIGHT JOIN pengukuran_tahunan b ON b.skp_id = a.id";

	
	
	$result    = mysqli_query($con,$sql);
	$no = 0;

	while($r = $result->fetch_assoc()){

		$no = $no+1;

		$query = " UPDATE pengukuran_tahunan SET 
											u_nama			= '$r[u_nama]',
											u_nip			= '$r[u_nip]',
											u_golongan		= '$r[u_golongan]',
											u_jabatan		= '$r[u_jabatan]',
											u_skpd			= '$r[u_skpd]',
											u_unit_kerja	= '$r[u_unit_kerja]',
											p_nama			= '$r[p_nama]',
											p_nip			= '$r[p_nip]',
											p_golongan		= '$r[p_golongan]',
											p_jabatan		= '$r[p_jabatan]',
											p_skpd			= '$r[p_skpd]',
											p_unit_kerja	= '$r[p_unit_kerja]'
											
											
											WHERE 
											id				= '$r[capaian_tahunan_id]' ";

		$action    = mysqli_query($con,$query);
		
		echo $no."&nbsp;".$r['capaian_tahunan_id']."updated<br>";
	}







?>