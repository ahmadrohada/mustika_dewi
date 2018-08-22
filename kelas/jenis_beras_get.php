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
		

		$query = $koneksi->prepare(" SELECT 	
											c.id as jenis_beras_id,
											c.label as label
											FROM item_transaksi a
											LEFT JOIN item_transaksi b ON a.nama_karung = b.nama_karung AND a.tonase = b.tonase
											LEFT JOIN jenis_beras c ON c.id = b.jenis_beras_id
											
											WHERE 	a.id = '$id_karung'
												AND b.jenis_transaksi = 'pembelian'
												AND c.label LIKE '%$label%'	
											ORDER by c.label ASC 
											LIMIT 1 
											");

				
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
case"jenis_beras_select2":

		$label 		 =  isset($_GET['label'])?$_GET['label']:null;

		
		$query = $koneksi->prepare(" SELECT 	
											c.id as jenis_beras_id,
											c.label as label
											FROM  jenis_beras c
											
											WHERE c.label LIKE '%$label%'	
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

		
			$query_2 = $koneksi->prepare(" SELECT 	
									a.id,
									a.nama_karung,
									a.tonase,
									a.harga AS harga_beli
									FROM item_transaksi a
									WHERE   jenis_transaksi = 'pembelian'
											AND jenis_beras_id = '$x->jenis_beras_id'

									GROUP BY a.nama_karung,a.tonase
									ORDER by a.id DESC ");

				
			$no = 0;
			$query_2->execute();
			$stok = 0;
			while($y = $query_2->fetch(PDO::FETCH_OBJ)) {

 

				//pembelian 
		 		$stok_in_query = $koneksi->prepare(" SELECT 	sum(qty) AS qty  FROM item_transaksi WHERE jenis_beras_id = '$x->jenis_beras_id' AND jenis_transaksi = 'pembelian' AND nama_karung = '$y->nama_karung' AND tonase = '$y->tonase' ");
				$stok_in_query->execute();
				$stok_in  = $stok_in_query->fetch(PDO::FETCH_OBJ);

				$in 	  = $stok_in->qty * $y->tonase;
				
				$stok_out_query = $koneksi->prepare(" SELECT 	qty,tonase FROM item_transaksi WHERE jenis_transaksi = 'penjualan' AND  pembelian_id = '$y->id' ");
				$stok_out_query->execute();
				//$stok_out  = $stok_out_query->fetch(PDO::FETCH_OBJ);
				//$out       = $stok_out->qty;

				$total_out = 0 ;
				while($v = $stok_out_query->fetch(PDO::FETCH_OBJ)) {
					$total_out = $total_out + ( $v->qty*$v->tonase);

				}

				$out = $total_out ;
				$stok    = $stok + floor(($in - $out)/$y->tonase);
 
				
			} 

			$no++;
			$h['no']				= $no;
			$h['jenis_beras_id']	= $x->jenis_beras_id;
			$h['label']				= $x->label;
			$h['stok']				= $stok;

			$total = $total+$stok;
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