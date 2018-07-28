<?php
	//header("Content-Type:application/json");
	session_start();

	include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'../kelas/pustaka.php';
	require_once('../config/conn_pdo.php');
	
	
	$d 	= New FormatTanggal();
	$n 	= New Nota();
	$s 	= New selisih();
		
	
	

	try {
		$data				= isset($_POST['op'])?$_POST['op']:null;
	}

	catch(Exception $e) {
		$data = null;
		echo 'Message: ' .$e->getMessage();
	}	
	
switch($data){
case "add_to_tmp":
		

	$no_nota 			= preg_replace('/[^0-9]/', '', $_POST['no_nota']);		
	$jenis_beras_id 	= preg_replace('/[^0-9]/', '', $_POST['jenis_beras_id']);	
	$harga 				= preg_replace('/[^0-9]/', '', $_POST['harga']);		
	$qty 				= preg_replace('/[^0-9]/', '', $_POST['qty']);	
	$discount 			= preg_replace('/[^0-9]/', '', $_POST['discount']);
	
	$query = $koneksi->prepare("INSERT INTO detail_penjualan_tmp  (no_nota, jenis_beras_id, harga,qty,discount)
											VALUES(:a, 	:b, :c, :d ,:e)");
	$query->execute(array(
						"a" => $no_nota,
						"b" => $jenis_beras_id,
						"c" => $harga,
						"d" => $qty,
						"e" => $discount
					));	
		  
	if (mysql_errno() == 0){
		header('HTTP/1.1 200 Sukses'); //if sukses
	}else{
		header('HTTP/1.1 400 error'); //if error
	}

break;

case "delete_from_tmp":
		

	$id = preg_replace('/[^0-9]/', '', $_POST['detail_penjualan_tmp_id']);		
	
	$query = $koneksi->prepare("DELETE FROM detail_penjualan_tmp  WHERE id = :a ");
	$query->execute(array(
						"a" => $id
					));	
		  
	if (mysql_errno() == 0){
		header('HTTP/1.1 200 Sukses'); //if sukses
	}else{
		header('HTTP/1.1 400 error'); //if error
	}

break;

case "update_harga_tmp":
		
	$harga  = preg_replace('/[^0-9]/', '', $_POST['harga']);
	$id 	= preg_replace('/[^0-9]/', '', $_POST['id']);		
	
	$update = $koneksi->prepare("UPDATE detail_penjualan_tmp
										SET 	harga			= :harga
												
												WHERE id		= :id ");
	$update->execute(array(
								"harga" 	=> $harga,
								"id" 		=> $id
							));	
		  
	if (mysql_errno() == 0){
		header('HTTP/1.1 200 Sukses'); //if sukses
	}else{
		header('HTTP/1.1 400 error'); //if error
	}

break;


case "update_discount_tmp":
		
	$discount   = preg_replace('/[^0-9]/', '', $_POST['discount']);
	$id 		= preg_replace('/[^0-9]/', '', $_POST['id']);		
	
	$update = $koneksi->prepare("UPDATE detail_penjualan_tmp
										SET 	discount		= :discount
												
												WHERE id		= :id ");
	$update->execute(array(
								"discount" 	=> $discount,
								"id" 		=> $id
							));	
		  
	if (mysql_errno() == 0){
		header('HTTP/1.1 200 Sukses'); //if sukses
	}else{
		header('HTTP/1.1 400 error'); //if error
	}

break;

case "update_qty_tmp":
		
	$qty  	= preg_replace('/[^0-9]/', '', $_POST['qty']);
	$id 	= preg_replace('/[^0-9]/', '', $_POST['id']);		
	
	$update = $koneksi->prepare("UPDATE detail_penjualan_tmp
										SET 	qty			= :qty
												
												WHERE id		= :id ");
	$update->execute(array(
								"qty" 		=> $qty,
								"id" 		=> $id
							));	
		  
	if (mysql_errno() == 0){
		header('HTTP/1.1 200 Sukses'); //if sukses
	}else{
		header('HTTP/1.1 400 error'); //if error
	}

break;


case "simpan_transaksi":
		
	$bayar  		= preg_replace('/[^0-9]/', '', $_POST['bayar']);
	$grand_total  	= preg_replace('/[^0-9]/', '', $_POST['grand_total']);
	$komisi  		= preg_replace('/[^0-9]/', '', $_POST['komisi']);
	$no_nota  		= preg_replace('/[^0-9]/', '', $_POST['no_nota']);
	$pelanggan_id 	= $_POST['pelanggan_id']	;
	$user_id		= $_POST['user_id'];
	$status_hutang	= $_POST['status_hutang'];
	$keterangan		= $_POST['keterangan'];


	if ( $status_hutang == 1){
		$status_pembayaran = 'kredit';
		$sisa 			   = $grand_total-$bayar;
		$income			   = $bayar;
	}else{
		$status_pembayaran = 'tunai';
		$sisa 			   = 0;
		$income			   = $grand_total;
	}
	

	//insert data dari tmp
	$query = $koneksi->prepare(" SELECT * FROM detail_penjualan_tmp WHERE no_nota = '$no_nota' ORDER by id ASC");

	$no = 0;
	$response = array();
	$query->execute();
	while($x = $query->fetch(PDO::FETCH_OBJ)) {
		//INSERT KE TABLE TRANSAKSI


		$query_2 = $koneksi->prepare("INSERT INTO transaksi  (no_nota, jenis_beras_id,outcome,harga,discount)
											VALUES(:a, 	:b, :c, :d ,:e)");
		$query_2->execute(array(
							"a" => $x->no_nota,
							"b" => $x->jenis_beras_id,
							"c" => $x->qty,
							"d" => $x->harga,
							"e" => $x->discount
						));	
		$no++;
	}	

	if ( $no >= 1 ){

		$query_3 = $koneksi->prepare("INSERT INTO penjualan  ( no_nota,
																	tgl_nota,
																	pelanggan_id,
																	user_id,
																	grand_total, 
																	bayar,
																	komisi,
																	income,
																	sisa,
																	status_pembayaran,
																	keterangan)
									VALUES(:a,:b,:c,:d,:e,:f,:g,:h,:i,:j,:k)");
		$query_3->execute(array(
							"a" => $no_nota,
							"b" => date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s'),
							"c" => $pelanggan_id,
							"d" => $user_id,
							"e" => $grand_total,
							"f" => $bayar,
							"g" => $komisi,
							"h" => $income,
							"i" => $sisa,
							"j" => $status_pembayaran,
							"k" => $keterangan

							));	

		if (mysql_errno() == 0){


			$query = $koneksi->prepare("DELETE FROM detail_penjualan_tmp  WHERE no_nota = :a ");
			$query->execute(array(
								"a" => $no_nota
							));	

			header('HTTP/1.1 200 Sukses'); //if sukses
		}else{
			header('HTTP/1.1 400 error'); //if error
		}
	}else{
		header('HTTP/1.1 400 error'); //if error
	}

  
	

break;

default;
header('HTTP/1.1 400 request error');
break;
}
?>