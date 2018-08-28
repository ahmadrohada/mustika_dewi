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
								a.tonase,
								a.harga
								FROM item_transaksi a
								WHERE 		a.jenis_transaksi = 'pembelian'
										AND a.nama_karung LIKE '%$nama%'

								GROUP BY a.nama_karung,a.tonase,a.harga
								ORDER by a.nama_karung ASC ");

				
			$no = 0;
			$query->execute();
			while($x = $query->fetch(PDO::FETCH_OBJ)) {
				
				
				//pembelian 
		 		$stok_in_query = $koneksi->prepare(" SELECT 	sum(qty) AS qty  FROM item_transaksi WHERE jenis_transaksi = 'pembelian' AND nama_karung = '$x->nama_karung' AND tonase = '$x->tonase' AND harga = '$x->harga' ");
				$stok_in_query->execute();
				$stok_in  = $stok_in_query->fetch(PDO::FETCH_OBJ);

				$in 	  = $stok_in->qty * $x->tonase;
				
				$stok_out_query = $koneksi->prepare(" SELECT 	qty,tonase FROM item_transaksi WHERE jenis_transaksi = 'penjualan' AND  pembelian_id = '$x->item_transaksi_id' ");
				$stok_out_query->execute();
				//$stok_out  = $stok_out_query->fetch(PDO::FETCH_OBJ);
				//$out       = $stok_out->qty;

				$total_out = 0 ;
				while($v = $stok_out_query->fetch(PDO::FETCH_OBJ)) {
					$total_out = $total_out + ( $v->qty*$v->tonase);

				}

				$out = $total_out ;
				$stok    = floor(($in - $out)/$x->tonase);
				
				
				if ( $stok > 0 ){
					$no++;
						$item[] = array(
									'no'		=> $no,
									'id'		=> $x->item_transaksi_id.'|'.$d->tonase($x->tonase),
									'nama'		=> $x->nama_karung.' [ Tonase '.$d->tonase($x->tonase).' Kg]  [ Harga Beli Rp. ' .number_format($x->harga,'0',',','.'). ' ] [ Stok ' .$stok. ']',
						);

					
				}
						
			}	
				
			if ($no!=0){
				header('HTTP/1.1 200 Sukses'); //if sukses
				echo json_encode($item);
				
			}else{
				header('HTTP/1.1 400 error'); //if error
			}

break;
case"nama_karung_stok_list":

		$jenis_beras_id =  isset($_GET['jenis_beras_id'])?$_GET['jenis_beras_id']:null;

		$query = $koneksi->prepare(" SELECT 	
									a.id,
									a.nama_karung,
									a.tonase,
									a.harga AS harga_beli
									FROM item_transaksi a
									WHERE   jenis_transaksi = 'pembelian'
											AND jenis_beras_id = '$jenis_beras_id'

									GROUP BY a.nama_karung,a.tonase,a.harga
									ORDER by a.id DESC ");

				
			$no = 0;
			$response["nama_karung_list"] = array();
			$query->execute();
			$stok = 0;
			while($x = $query->fetch(PDO::FETCH_OBJ)) {



				//pembelian 
		 		$stok_in_query = $koneksi->prepare(" SELECT 	sum(qty) AS qty  FROM item_transaksi WHERE jenis_beras_id = '$jenis_beras_id' AND jenis_transaksi = 'pembelian' AND nama_karung = '$x->nama_karung' AND tonase = '$x->tonase' AND harga = '$x->harga_beli' ");
				$stok_in_query->execute();
				$stok_in  = $stok_in_query->fetch(PDO::FETCH_OBJ);

				$in 	  = $stok_in->qty * $x->tonase;
				
				$stok_out_query = $koneksi->prepare(" SELECT 	qty,tonase FROM item_transaksi WHERE jenis_transaksi = 'penjualan' AND  pembelian_id = '$x->id' ");
				$stok_out_query->execute();
				//$stok_out  = $stok_out_query->fetch(PDO::FETCH_OBJ);
				//$out       = $stok_out->qty;

				$total_out = 0 ;
				while($v = $stok_out_query->fetch(PDO::FETCH_OBJ)) {
					$total_out = $total_out + ( $v->qty*$v->tonase);

				}

				$out = $total_out ;
				$stok    = floor(($in - $out)/$x->tonase);


					
				if ( $stok > 0 ){
					
					$no++;
					$h['no']			= $no;
					$h['nama_karung']	= $x->nama_karung;
					$h['tonase']		= $x->tonase;
					$h['harga_beli']	= number_format($x->harga_beli,'0',',','.');
					$h['in']			= $in;
					$h['out']			= $out;
					$h['stok']			= $stok;
					
					array_push($response["nama_karung_list"], $h);
				}
				
				
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