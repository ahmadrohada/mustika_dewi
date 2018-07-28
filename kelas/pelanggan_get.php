<?php
	//header("Content-Type:application/json");
	session_start();

	include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'../kelas/pustaka.php';
	require_once('../config/conn_pdo.php');
	
	
	$d 		= New FormatTanggal();
	$n 		= New Nota();
	$s 		= New selisih();
		
	
$op				= isset($_GET['op'])?$_GET['op']:null;

switch($op){
case"pelanggan":

			$nama = $_GET['nama'];


			$query = $koneksi->prepare(" SELECT 	
								a.id as pelanggan_id,
								a.nama
								FROM pelanggan a 
								WHERE nama LIKE '%$nama%'		
								
								ORDER by a.nama ASC ");

				
			$no = 0;
			$query->execute();

			while($x = $query->fetch(PDO::FETCH_OBJ)) {
						$no++;
						$item[] = array(
									'no'		=> $no,
									'id'		=> $x->pelanggan_id,
									'nama'		=> $x->nama,
						);

			}	
				
			if ($no!=0){
				header('HTTP/1.1 200 Sukses'); //if sukses
				echo json_encode($item);
				
			}else{
				header('HTTP/1.1 400 error'); //if error
			}

break;
case"detail_pelanggan":

			$pelanggan_id = $_GET['pelanggan_id'];


			$query = $koneksi->prepare(" SELECT 	
								a.id as pelanggan_id,
								a.nama,
								a.alamat,
								a.no_tlp,
								a.info_lain
								FROM pelanggan a 
								WHERE id = 	'$pelanggan_id'	
								
								LIMIT 1 ");

				
			$no = 0;
			$query->execute();
			$x = $query->fetch(PDO::FETCH_OBJ);

			if ($x){
		
				$detail_pelanggan = array(
							'id'			=> $x->pelanggan_id,
							'nama'			=> $x->nama,
							'alamat'		=> $x->alamat,
							'tlp'			=> $x->no_tlp,
							'info_lain'		=> $x->info_lain,
				);
		
			}else{
				
				$detail_pelanggan = array(
							'id'			=> "-",
							'nama'		=> "-",
							'alamat'	=> "-",
							'tlp'			=> "-",
							'info_lain'		=> "",
				);
		
			}
			
					
			if (mysql_errno() == 0){
				echo json_encode($detail_pelanggan);
				header('HTTP/1.1 200 Sukses'); //if sukses
			}else{
				header('HTTP/1.1 400 error'); //if error
			}

break;
}
?>