
<?php
$con=mysqli_connect("localhost","root","","db_pare");


	$sql =	"SELECT  a.id as skp_bulanan_id,
		a.skp_tahunan_id,
		b.id as skp_th_id,
		b.u_nama,
						b.u_nip,
						b.u_golongan,
						b.u_jabatan,
						b.u_skpd,
						b.u_unit_kerja,
						b.p_nama,
						b.p_nip,
						b.p_golongan,
						b.p_jabatan,
						b.p_skpd,
						b.p_unit_kerja
		

		FROM skp_bulanan a
		LEFT JOIN skp_tahunan b ON b.id = a.skp_tahunan_id

		WHERE a.u_nama = ' ' ";

	
	
	$result    = mysqli_query($con,$sql);
	$no = 0;

	while($r = $result->fetch_assoc()){

		$no = $no+1;

		$query = " UPDATE skp_bulanan SET 
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
											id				= '$r[skp_bulanan_id]' ";

		$action    = mysqli_query($con,$query);
		
		echo $no."&nbsp;".$r['skp_bulanan_id']."updated<br>";
	}







?>