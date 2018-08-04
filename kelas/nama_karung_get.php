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
case"nama_karung":

		$nama =  isset($_GET['nama'])?$_GET['nama']:null;

		$query = $koneksi->prepare(" SELECT 	
								a.id as item_transaksi_id,
								a.nama_karung,
								a.tonase
								FROM item_transaksi a
								WHERE nama_karung LIKE '%$nama%'

								GROUP BY a.nama_karung,a.tonase		
								ORDER by a.nama_karung ASC ");

				
			$no = 0;
			$query->execute();
			while($x = $query->fetch(PDO::FETCH_OBJ)) {
						$no++;
						$item[] = array(
									'no'		=> $no,
									'id'		=> $x->item_transaksi_id.'|'.$x->tonase,
									'nama'		=> $x->nama_karung.' ['.$x->tonase.' Kg]',
						);

			}	
				
			if ($no!=0){
				header('HTTP/1.1 200 Sukses'); //if sukses
				echo json_encode($item);
				
			}else{
				header('HTTP/1.1 400 error'); //if error
			}

break;
case"nama_karung_list":

		$jenis_beras_id =  isset($_GET['jenis_beras_id'])?$_GET['jenis_beras_id']:null;

		$query = $koneksi->prepare(" SELECT 	
									a.nama_karung,
									a.tonase
									FROM item_transaksi a
									WHERE jenis_beras_id = '$jenis_beras_id'

									GROUP BY a.nama_karung,a.tonase		
									ORDER by a.nama_karung ASC ");

				
			$no = 0;
			$response["nama_karung_list"] = array();
			$query->execute();
			$stok = 0;
			while($x = $query->fetch(PDO::FETCH_OBJ)) {



				//pembelian 
				$stok_in_query = $koneksi->prepare(" SELECT 	sum(qty) FROM item_transaksi WHERE jenis_beras_id = '$jenis_beras_id' AND jenis_transaksi = 'pembelian' AND nama_karung = '$x->nama_karung' AND tonase = '$x->tonase' ");
				$stok_in_query->execute();
				$stok_total_in  = $stok_in_query->fetch(PDO::FETCH_NUM);
				
				$stok_out_query = $koneksi->prepare(" SELECT 	sum(qty) FROM item_transaksi WHERE jenis_beras_id = '$jenis_beras_id' AND jenis_transaksi = 'penjualan' AND  nama_karung = '$x->nama_karung' AND tonase = '$x->tonase' ");
				$stok_out_query->execute();
				$stok_total_out  = $stok_out_query->fetch(PDO::FETCH_NUM);

				$stok    = $stok_total_in[0] - $stok_total_out[0];


				$no++;
				$h['no']			= $no;
				$h['nama_karung']	= $x->nama_karung;
				$h['tonase']		= $x->tonase;
				$h['stok']			= $stok;
					
				
				array_push($response["nama_karung_list"], $h);
			}	
				
			if ($no!=0){
				header('HTTP/1.1 200 Sukses'); //if sukses
				echo json_encode($response);
				
			}else{
				header('HTTP/1.1 400 error'); //if error
			}

break;
default;
header('HTTP/1.1 400 request error');
break;
}
?>