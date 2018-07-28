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
case"jenis_beras":

		$label = $_GET['label'];

		$query = $koneksi->prepare(" SELECT 	
								a.id as jenis_beras_id,
								a.label
								FROM jenis_beras a
								WHERE label LIKE '%$label%'		
								ORDER by a.label ASC ");

				
			$no = 0;
			$query->execute();
			while($x = $query->fetch(PDO::FETCH_OBJ)) {
						$no++;
						$item[] = array(
									'no'		=> $no,
									'id'		=> $x->jenis_beras_id,
									'label'		=> $x->label,
						);

			}	
				
			if ($no!=0){
				header('HTTP/1.1 200 Sukses'); //if sukses
				echo json_encode($item);
				
			}else{
				header('HTTP/1.1 400 error'); //if error
			}

break;
case"harga_beras":

			$jenis_beras_id = $_GET['jenis_beras_id'];


			$query = $koneksi->prepare(" SELECT 	
								a.id,
								a.harga_jual,
								a.harga_beli

								FROM harga_beras a 
								WHERE id = 	'$jenis_beras_id'
								ORDER BY periode ASC	
								
								LIMIT 1 
								
								");

				
			$no = 0;
			$query->execute();
			$x = $query->fetch(PDO::FETCH_OBJ);
			if ($x){
		
				//== cari stok beras ====//

				$stok_in_query = $koneksi->prepare(" SELECT 	sum(income) FROM transaksi WHERE jenis_beras_id = '$x->id' ");
				$stok_in_query->execute();
				$stok_total_in  = $stok_in_query->fetch(PDO::FETCH_NUM);
				
				$stok_out_query = $koneksi->prepare(" SELECT 	sum(outcome) FROM transaksi WHERE jenis_beras_id = '$x->id' ");
				$stok_out_query->execute();
				$stok_total_out  = $stok_out_query->fetch(PDO::FETCH_NUM);

				$stok    = $stok_total_in[0] - $stok_total_out[0];

				$harga_beras = array(
							'harga_jual'		=> number_format($x->harga_jual,'0',',','.'),
							'harga_beli'		=> number_format($x->harga_beli,'0',',','.'),
							'stok'				=> number_format($stok,'0',',','.')
				);
			}else{
				
				$harga_beras = array(
					'harga_jual'		=> "",
					'harga_beli'		=> ""
				);
		
			}
			
					
			if (mysql_errno() == 0){
				echo json_encode($harga_beras);
				header('HTTP/1.1 200 Sukses'); //if sukses
			}else{
				header('HTTP/1.1 400 error'); //if error
			}

break;
}
?>