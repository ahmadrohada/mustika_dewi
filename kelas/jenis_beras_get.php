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

		$label 		 =  isset($_GET['label'])?$_GET['label']:null;
		$data_k 	 =  isset($_GET['nama_karung'])?$_GET['nama_karung']:null;

		if ( $data_k != null ){
			$dt 	 	 = explode("|",$data_k);
			$id_karung   = $dt[0];
			$tonase 	 = $dt[1];
		}
		

	/* 	$query = $koneksi->prepare(" SELECT 	
											b.id as jenis_beras_id,
											b.label
											FROM item_transaksi a
											LEFT JOIN jenis_beras b ON a.jenis_beras_id = b.id

											WHERE 	    a.nama_karung = '$nama_karung' 
													AND a.tonase = '$tonase'
													AND b.label LIKE '%$label%'		
											ORDER by b.label ASC "); */
		$query = $koneksi->prepare(" SELECT 	
											c.id as jenis_beras_id,
											c.label as label
											FROM item_transaksi a
											LEFT JOIN item_transaksi b ON a.nama_karung = b.nama_karung AND a.tonase = b. tonase
											LEFT JOIN jenis_beras c ON c.id = b.jenis_beras_id
											
											WHERE 	a.id = '$id_karung'
												AND c.label LIKE '%$label%'	
											ORDER by c.label ASC ");

				
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
								WHERE a.jenis_beras_id =  '$jenis_beras_id'
								ORDER BY a.created_at ASC	
								
								LIMIT 1 
								
								");

				
			$no = 0;
			$query->execute();
			$x = $query->fetch(PDO::FETCH_OBJ);
			if ($x){
		
			
				$harga_beras = array(
							'harga_jual'		=> number_format($x->harga_jual,'0',',','.'),
							'harga_beli'		=> number_format($x->harga_beli,'0',',','.')
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
case"stok_beras":

			$jenis_beras_id = $_GET['jenis_beras_id'];


			$query = $koneksi->prepare(" SELECT 	
								a.id,
								a.harga_jual,
								a.harga_beli

								FROM harga_beras a 
								WHERE a.jenis_beras_id =  '$jenis_beras_id'
								ORDER BY a.created_at ASC	
								
								LIMIT 1 
								
								");

				
			$no = 0;
			$query->execute();
			$x = $query->fetch(PDO::FETCH_OBJ);
			if ($x){
		
				//== cari stok beras ====//
				//pembelian 
/* 				$stok_in_query = $koneksi->prepare(" SELECT 	sum(qty) FROM item_transaksi WHERE nama_karung = '$x->id' ");
				$stok_in_query->execute();
				$stok_total_in  = $stok_in_query->fetch(PDO::FETCH_NUM);
				
				$stok_out_query = $koneksi->prepare(" SELECT 	sum(outcome) FROM item_transaksi WHERE jenis_beras_id = '$x->id' ");
				$stok_out_query->execute();
				$stok_total_out  = $stok_out_query->fetch(PDO::FETCH_NUM);

				$stok    = $stok_total_in[0] - $stok_total_out[0]; */

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
case "jenis_beras_tbl_list":
		
	$query = $koneksi->prepare(" SELECT 	
								a.id as jenis_beras_id,
								a.label

								FROM jenis_beras a
								ORDER by a.id DESC");
	
	$no = 0;
	$response = array();
	$response["jenis_beras_list"] = array();
	$response["total"] = array();
	$total = 0;
	$query->execute();
	
	while($x = $query->fetch(PDO::FETCH_OBJ)) {

		//STOK IN
		$stok_in_query = $koneksi->prepare(" SELECT sum(qty) FROM item_transaksi WHERE jenis_beras_id = '$x->jenis_beras_id' AND jenis_transaksi ='pembelian' ");
		$stok_in_query->execute();
		$stok_total_in  = $stok_in_query->fetch(PDO::FETCH_NUM);
	 			
		//STOK OUT
		$stok_out_query = $koneksi->prepare(" SELECT sum(qty) FROM item_transaksi WHERE jenis_beras_id = '$x->jenis_beras_id' AND jenis_transaksi ='penjualan' ");
		$stok_out_query->execute();
		$stok_total_out  = $stok_out_query->fetch(PDO::FETCH_NUM);

		$qty    = $stok_total_in[0] - $stok_total_out[0];
		
 
			$no++;
			$h['no']				= $no;
			$h['jenis_beras_id']	= $x->jenis_beras_id;
			$h['label']				= $x->label;
			$h['qty']				= $qty;
				
			$total = $total + $qty;
			array_push($response["jenis_beras_list"], $h);
	}	

			$t['total']				= $total;
			array_push($response["total"], $t);

	if (mysql_errno() == 0){
		echo json_encode($response);
		//header('HTTP/1.1 200 Sukses'); //if sukses
	}else{
		header('HTTP/1.1 400 error'); //if error
	}

break;

}
?>